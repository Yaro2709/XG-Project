<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from xgproyect.net      	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

class ShowBuildingsPage
{
	private function BuildingSavePlanetRecord ($CurrentPlanet)
	{
		$QryUpdatePlanet  = "UPDATE {{table}} SET ";
		$QryUpdatePlanet .= "`b_building_id` = '". $CurrentPlanet['b_building_id'] ."', ";
		$QryUpdatePlanet .= "`b_building` = '".    $CurrentPlanet['b_building']    ."' ";
		$QryUpdatePlanet .= "WHERE ";
		$QryUpdatePlanet .= "`id` = '".            $CurrentPlanet['id']            ."';";
		doquery( $QryUpdatePlanet, 'planets');

		return;
	}

	private function CancelBuildingFromQueue (&$CurrentPlanet, &$CurrentUser)
	{
		$CurrentQueue  = $CurrentPlanet['b_building_id'];
		if ($CurrentQueue != 0)
		{
			$QueueArray          = explode ( ";", $CurrentQueue );
			$ActualCount         = count ( $QueueArray );
			$CanceledIDArray     = explode ( ",", $QueueArray[0] );
			$Element             = $CanceledIDArray[0];
			$BuildMode           = $CanceledIDArray[4];

			if ($ActualCount > 1)
			{
				array_shift( $QueueArray );
				$NewCount        = count( $QueueArray );
				$BuildEndTime    = time();
				for ($ID = 0; $ID < $NewCount ; $ID++ )
				{
					$ListIDArray          = explode ( ",", $QueueArray[$ID] );
					$BuildEndTime        += $ListIDArray[2];
					$ListIDArray[3]       = $BuildEndTime;
					$QueueArray[$ID]      = implode ( ",", $ListIDArray );
				}
				$NewQueue        = implode(";", $QueueArray );
				$ReturnValue     = true;
				$BuildEndTime    = '0';
			}
			else
			{
				$NewQueue        = '0';
				$ReturnValue     = false;
				$BuildEndTime    = '0';
			}

			if ($BuildMode == 'destroy')
			{
				$ForDestroy = true;
			}
			else
			{
				$ForDestroy = false;
			}

			if ( $Element != false ) {
			$Needed                        = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, true, $ForDestroy);
			$CurrentPlanet['metal']       += $Needed['metal'];
			$CurrentPlanet['crystal']     += $Needed['crystal'];
			$CurrentPlanet['deuterium']   += $Needed['deuterium'];
			}

		}
		else
		{
			$NewQueue          = '0';
			$BuildEndTime      = '0';
			$ReturnValue       = false;
		}

		$CurrentPlanet['b_building_id']  = $NewQueue;
		$CurrentPlanet['b_building']     = $BuildEndTime;

		return $ReturnValue;
	}

	private function RemoveBuildingFromQueue ( &$CurrentPlanet, $CurrentUser, $QueueID )
	{
		if ($QueueID > 1)
		{
			$CurrentQueue  = $CurrentPlanet['b_building_id'];
			if ($CurrentQueue != 0)
			{
				$QueueArray    = explode ( ";", $CurrentQueue );
				$ActualCount   = count ( $QueueArray );
				$ListIDArray   = explode ( ",", $QueueArray[$QueueID - 2] );
				$BuildEndTime  = $ListIDArray[3];
				for ($ID = $QueueID; $ID < $ActualCount; $ID++ )
				{
					$ListIDArray          = explode ( ",", $QueueArray[$ID] );
					$BuildEndTime        += $ListIDArray[2];
					$ListIDArray[3]       = $BuildEndTime;
					$QueueArray[$ID - 1]  = implode ( ",", $ListIDArray );
				}
				unset ($QueueArray[$ActualCount - 1]);
				$NewQueue     = implode ( ";", $QueueArray );
			}
			$CurrentPlanet['b_building_id'] = $NewQueue;
		}
		return $QueueID;
	}

	private function AddBuildingToQueue (&$CurrentPlanet, $CurrentUser, $Element, $AddMode = true)
	{
		global $resource;

		$CurrentQueue  = $CurrentPlanet['b_building_id'];

		$Queue 				= $this->ShowBuildingQueue($CurrentPlanet, $CurrentUser);
		$CurrentMaxFields  	= CalculateMaxPlanetFields($CurrentPlanet);

		if ($CurrentPlanet["field_current"] >= ($CurrentMaxFields - $Queue['lenght']) && $_GET['cmd'] != 'destroy')
			die(header("location:game.php?page=buildings"));

		if ($CurrentQueue != 0)
		{
			$QueueArray    = explode ( ";", $CurrentQueue );
			$ActualCount   = count ( $QueueArray );
		}
		else
		{
			$QueueArray    = "";
			$ActualCount   = 0;
		}

		if ($AddMode == true)
		{
			$BuildMode = 'build';
		}
		else
		{
			$BuildMode = 'destroy';
		}

		if ( $ActualCount < MAX_BUILDING_QUEUE_SIZE)
		{
			$QueueID      = $ActualCount + 1;
		}
		else
		{
			$QueueID      = false;
		}

		if ( $QueueID != false && IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, false) && IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element) )
		{
			if ($QueueID > 1)
			{
				$InArray = 0;
				for ( $QueueElement = 0; $QueueElement < $ActualCount; $QueueElement++ )
				{
					$QueueSubArray = explode ( ",", $QueueArray[$QueueElement] );
					if ($QueueSubArray[0] == $Element)
					{
						$InArray++;
					}
				}
			}
			else
			{
				$InArray = 0;
			}

			if ($InArray != 0)
			{
				$ActualLevel  = $CurrentPlanet[$resource[$Element]];
				if ($AddMode == true)
				{
					$BuildLevel   = $ActualLevel + 1 + $InArray;
					$CurrentPlanet[$resource[$Element]] += $InArray;
					$BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					$CurrentPlanet[$resource[$Element]] -= $InArray;
				}
				else
				{
					$BuildLevel   = $ActualLevel - 1 - $InArray;
					$CurrentPlanet[$resource[$Element]] -= $InArray;
					$BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element) / 2;
					$CurrentPlanet[$resource[$Element]] += $InArray;
				}
			}
			else
			{
				$ActualLevel  = $CurrentPlanet[$resource[$Element]];
				if ($AddMode == true)
				{
					$BuildLevel   = $ActualLevel + 1;
					$BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
				}
				else
				{
					$BuildLevel   = $ActualLevel - 1;
					$BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element) / 2;
				}
			}

			if ($QueueID == 1)
			{
				$BuildEndTime = time() + $BuildTime;
			}
			else
			{
				$PrevBuild = explode (",", $QueueArray[$ActualCount - 1]);
				$BuildEndTime = $PrevBuild[3] + $BuildTime;
			}

			$QueueArray[$ActualCount]       = $Element .",". $BuildLevel .",". $BuildTime .",". $BuildEndTime .",". $BuildMode;
			$NewQueue                       = implode ( ";", $QueueArray );
			$CurrentPlanet['b_building_id'] = $NewQueue;
		}
		return $QueueID;
	}

	private function ShowBuildingQueue ( $CurrentPlanet, $CurrentUser )
	{
		global $lang;

		$CurrentQueue  = $CurrentPlanet['b_building_id'];
		$QueueID       = 0;
		if ($CurrentQueue != 0)
		{
			$QueueArray    = explode ( ";", $CurrentQueue );
			$ActualCount   = count ( $QueueArray );
		}
		else
		{
			$QueueArray    = "0";
			$ActualCount   = 0;
		}

		$ListIDRow    = "";

		if ($ActualCount != 0)
		{
			$PlanetID     = $CurrentPlanet['id'];
			for ($QueueID = 0; $QueueID < $ActualCount; $QueueID++)
			{
				$BuildArray   = explode (",", $QueueArray[$QueueID]);
				$BuildEndTime = floor($BuildArray[3]);
				$CurrentTime  = floor(time());
				if ($BuildEndTime >= $CurrentTime)
				{
					$ListID       = $QueueID + 1;
					$Element      = $BuildArray[0];
					$BuildLevel   = $BuildArray[1];
					$BuildMode    = $BuildArray[4];
					$BuildTime    = $BuildEndTime - time();
					$ElementTitle = $lang['tech'][$Element];

					if ($ListID > 0)
					{
						$ListIDRow .= "<tr>";
						if ($BuildMode == 'build')
						{
							$ListIDRow .= "	<td class=\"l\" colspan=\"2\">". $ListID .".: ". $ElementTitle ." ". $BuildLevel ."</td>";
						}
						else
						{
							$ListIDRow .= "	<td class=\"l\" colspan=\"2\">". $ListID .".: ". $ElementTitle ." ". $BuildLevel . " " . $lang['bd_dismantle']."</td>";
						}
						$ListIDRow .= "	<td class=\"k\">";

						if ($ListID == 1)
						{
							$ListIDRow .= "		<div id=\"blc\" class=\"z\">". $BuildTime ."<br>";
							$ListIDRow .= "		<a href=\"game.php?page=buildings&listid=". $ListID ."&amp;cmd=cancel&amp;planet=". $PlanetID ."\">".$lang['bd_interrupt']."</a></div>";
							$ListIDRow .= "		<script language=\"JavaScript\">";
							$ListIDRow .= "			pp = \"". $BuildTime ."\";\n";
							$ListIDRow .= "			pk = \"". $ListID ."\";\n";
							$ListIDRow .= "			pm = \"cancel\";\n";
							$ListIDRow .= "			pl = \"". $PlanetID ."\";\n";
							$ListIDRow .= "			t();\n";
							$ListIDRow .= "		</script>";
							$ListIDRow .= "		<strong color=\"lime\"><br><font color=\"lime\">". date("j/m H:i:s" ,$BuildEndTime) ."</font></strong>";
						}
						else
						{
							$ListIDRow .= "		<font color=\"red\">";
							$ListIDRow .= "		<a href=\"game.php?page=buildings&listid=". $ListID ."&amp;cmd=remove&amp;planet=". $PlanetID ."\">".$lang['bd_cancel']."</a></font>";
						}
						$ListIDRow .= "	</td>";
						$ListIDRow .= "</tr>";
					}
				}
			}
		}

		$RetValue['lenght']    = $ActualCount;
		$RetValue['buildlist'] = $ListIDRow;

		return $RetValue;
	}

	public function __construct (&$CurrentPlanet, $CurrentUser)
	{
		global $ProdGrid, $lang, $resource, $reslist, $phpEx, $dpath, $game_config, $_GET, $xgp_root;

		include_once($xgp_root . 'includes/functions/IsTechnologieAccessible.' . $phpEx);
		include_once($xgp_root . 'includes/functions/GetElementPrice.' . $phpEx);
		include_once($xgp_root . 'includes/functions/GetRestPrice.' . $phpEx);

		CheckPlanetUsedFields ( $CurrentPlanet );

		$parse			= $lang;
		$Allowed['1'] 	= array(  1,  2,  3,  4, 12, 14, 15, 21, 22, 23, 24, 31, 33, 34, 35, 44, 45);
		$Allowed['3'] 	= array( 12, 14, 21, 22, 23, 24, 34, 41, 42, 43);

		if (isset($_GET['cmd']))
		{
			$bDoItNow 	= false;
			$TheCommand = $_GET['cmd'];
			$Element 	= $_GET['building'];
			$ListID 	= $_GET['listid'];

			if (!in_array( trim($Element), $Allowed[$CurrentPlanet['planet_type']]))
			{
				unset($Element);
			}

			if( isset ( $Element ))
			{
				if ( !strchr ( $Element, ",") && !strchr ( $Element, " ") &&
					 !strchr ( $Element, "+") && !strchr ( $Element, "*") &&
					 !strchr ( $Element, "~") && !strchr ( $Element, "=") &&
					 !strchr ( $Element, ";") && !strchr ( $Element, "'") &&
					 !strchr ( $Element, "#") && !strchr ( $Element, "-") &&
					 !strchr ( $Element, "_") && !strchr ( $Element, "[") &&
					 !strchr ( $Element, "]") && !strchr ( $Element, ".") &&
					 !strchr ( $Element, ":"))
				{
					if (in_array( trim($Element), $Allowed[$CurrentPlanet['planet_type']]))
					{
						$bDoItNow = true;
					}
				}
				else
				{
					header("location:game.php?page=buildings");
				}
			}
			elseif ( isset ( $ListID ))
			{
				$bDoItNow = true;
			}

			if ($Element == 31 && $CurrentUser["b_tech_planet"] != 0)
			{
				$bDoItNow = false;
			}

			if ( ( $Element == 21 or $Element == 14 or $Element == 15 ) && $CurrentPlanet["b_hangar"] != 0)
			{
				$bDoItNow = false;
			}

			if ($bDoItNow == true)
			{
				switch($TheCommand)
				{
					case 'cancel':
						$this->CancelBuildingFromQueue ($CurrentPlanet, $CurrentUser);
					break;
					case 'remove':
						$this->RemoveBuildingFromQueue ($CurrentPlanet, $CurrentUser, $ListID);
					break;
					case 'insert':
						$this->AddBuildingToQueue ($CurrentPlanet, $CurrentUser, $Element, true);
					break;
					case 'destroy':
						$this->AddBuildingToQueue ($CurrentPlanet, $CurrentUser, $Element, false);
					break;
				}
			}

			if ( $_GET['r'] == 'overview' )
			{
				header('location:game.php?page=overview');
			}
			else
			{
				header ("Location: game.php?page=buildings&mode=buildings");
			}
		}

		SetNextQueueElementOnTop($CurrentPlanet, $CurrentUser);
		$Queue = $this->ShowBuildingQueue($CurrentPlanet, $CurrentUser);
		$this->BuildingSavePlanetRecord($CurrentPlanet);

		if ($Queue['lenght'] < (MAX_BUILDING_QUEUE_SIZE))
		{
			$CanBuildElement = true;
		}
		else
		{
			$CanBuildElement = false;
		}

		$BuildingPage        = "";
		$zaehler         	 = 1;

		foreach($lang['tech'] as $Element => $ElementName)
		{
			if (in_array($Element, $Allowed[$CurrentPlanet['planet_type']]))
			{
				$CurrentMaxFields      = CalculateMaxPlanetFields($CurrentPlanet);
				if ($CurrentPlanet["field_current"] < ($CurrentMaxFields - $Queue['lenght']))
				{
					$RoomIsOk = true;
				}
				else
				{
					$RoomIsOk = false;
				}

				if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
				{
					$HaveRessources        	= IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, false);
					$parse                 	= array();
					$parse 					= $lang;
					$parse['dpath']        	= $dpath;
					$parse['i']            	= $Element;
					$BuildingLevel         	= $CurrentPlanet[$resource[$Element]];
					$parse['nivel']        	= ($BuildingLevel == 0) ? "" : " (". $lang['bd_lvl'] . " " . $BuildingLevel .")";
					$parse['n']            	= $ElementName;
					$parse['descriptions'] 	= $lang['res']['descriptions'][$Element];
					$ElementBuildTime      	= GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					$parse['time']         	= ShowBuildTime($ElementBuildTime);
					$parse['price']        	= GetElementPrice($CurrentUser, $CurrentPlanet, $Element);
				    $parse['rest_price']    = GetRestPrice($CurrentUser, $CurrentPlanet, $Element);
					$parse['click']        	= '';
					$NextBuildLevel        	= $CurrentPlanet[$resource[$Element]] + 1;
					
					
// Показ кол-ва потраченой/добоавляемой энергии START
$parse['nivel']            = ($BuildingLevel == 0) ? "" : " (". $lang['bd_lvl'] . " " . $BuildingLevel .")"; 
                    $BuildLevelFactor     = 10;
                    $BuildTemp            = $CurrentPlanet[ 'temp_max' ];
                    $CurrentBuildtLvl     = $BuildingLevel;
                    $BuildLevel           = ($CurrentBuildtLvl > 0) ? $CurrentBuildtLvl : 1;
                    $EnergyTechLevel      = $CurrentUser["energy_tech"];
                    $Prod[4]         = (floor(eval($ProdGrid[$Element]['formule']['energy'])    
                                        * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05)));
                    $ActualNeed     = floor($Prod[4]);
                    $BuildLevel++;
                    $Prod[4]         = (floor(eval($ProdGrid[$Element]['formule']['energy'])    
                                        * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05)));
                                        
                    $EnergyNeed = colorNumber( pretty_number(floor($Prod[4] - $ActualNeed)) );           
                    if ($Element >= 1 && $Element <= 3) {
                         $parse['energia'] = "("."<font color=#FF0000>". $EnergyNeed." ".$lang['Energy']."</font>".")";
                         $BuildLevel = 0;
                    }elseif ($Element == 4 || $Element == 12) {
                         $parse['energia'] = "("."<font color=#00FF00>+". $EnergyNeed." ".$lang['Energy']."</font>".")";
                         $BuildLevel = 0;
                    }
                                  
// Показ кол-ва потраченой/добоавляемой энергии END

					// Количество полей:  Остаток полей/Общее Количество полей START

         			$parse['planet_field_current']  = $CurrentPlanet['field_current'];
			        $parse['planet_field_max'] 		= CalculateMaxPlanetFields($CurrentPlanet);
                    $parse['field_libre']           = $parse['planet_field_max']  - $CurrentPlanet['field_current'];

					// Количество полей:  Остаток полей/Общее Количество полей END

					if ($RoomIsOk && $CanBuildElement)
					{
						if ($Queue['lenght'] == 0)
						{
							if ($NextBuildLevel == 1)
							{
								if ( $HaveRessources == true )

								$parse['click'] = "<form action='game.php?page=buildings&cmd=insert&building=". $Element ."' method='post'><input type='submit' style='width:100px;color:lime;font-weight:bold;' value=' ".$lang['bd_build']."'></form>";

								else
								    $parse['click'] = "<form action='' method='post'><input type='submit' style='width:100px;color:red;font-weight:bold;' value=' ".$lang['bd_build']."'></form>";

									}
							else
							{
								if ( $HaveRessources == true )
							    	$parse['click'] = "<form action='game.php?page=buildings&cmd=insert&building=". $Element ."' method='post'><input type='submit' style='width:100px;color:lime;font-weight:bold;' value=' ". $lang['bd_build_next_level'] ."'></form>";
								else
							    	$parse['click'] = "<form action='' method='post'><input type='submit' style='width:100px;color:red;font-weight:bold;' value=' ". $lang['bd_build_next_level'] ."'></form>";
									}
						}
						else
						{
					    	$parse['click'] = "<form action='game.php?page=buildings&cmd=insert&building=". $Element ."' method='post'><input type='submit' style='width:100px;color:lime;font-weight:bold;' value=' ".$lang['bd_add_to_list']."'></form>";
							}
					}
					elseif ($RoomIsOk && !$CanBuildElement)
					{
						if ($NextBuildLevel == 1)
						    $parse['click'] = "<form action='' method='post'><input type='submit' style='width:100px;color:red;font-weight:bold;' value=' ".$lang['bd_build'] ."'></form>";
							else
					    	$parse['click'] = "<form action='' method='post'><input type='submit' style='width:100px;color:red;font-weight:bold;' value=' ". $lang['bd_build_next_level'] ."'></form>";
							}
					else
						$parse['click'] = "<form action='' method='post'><input type='submit' style='width:100px;color:red;font-weight:bold;' value=' ".$lang['bd_no_more_fields'] ."'></form>";
					if ($Element == 31 && $CurrentUser["b_tech_planet"] != 0)
					{
						$parse['click'] = "<form action='' method='post'><input type='submit' style='width:100px;color:red;font-weight:bold;' value=' ".$lang['bd_working'] ."'></form>";
						}

					if ( ( $Element == 21 or $Element == 14 or $Element == 15 ) && $CurrentPlanet["b_hangar"] != 0)
					{
						$parse['click'] = "<form action='' method='post'><input type='submit' style='width:100px;color:red;font-weight:bold;' value=' ".$lang['bd_working'] ."'></form>";
						}

					$BuildingPage .= parsetemplate(gettemplate('buildings/buildings_builds_row'), $parse);
				}
			}
		}

		if ($Queue['lenght'] > 0)
		{
			include($xgp_root . 'includes/functions/InsertBuildListScript.' . $phpEx);

			$parse['BuildListScript']  = InsertBuildListScript ("buildings");
			$parse['BuildList']        = $Queue['buildlist'];
		}
		else
		{
			$parse['BuildListScript']  = "";
		    $parse['BuildList']        = "<th colspan='3'><font color=gold><blink>Очередь построек пуста!</blink></font></th>";
		}

		$parse['BuildingsList']        = $BuildingPage;

		display(parsetemplate(gettemplate('buildings/buildings_builds'), $parse));
	}
}
?>