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

if (!defined('INSIDE'))die(header("location:../../"));

class FlyingFleetHandler
{
	public static function calculateAKSSteal($attackFleets, $defenderPlanet, $ForSim = false)
	{
		//Steal-Math by Slaver for 2Moons(http://code.google.com/p/2moons/) based on http://www.owiki.de/Beute
		global $pricelist;

		$SortFleets = array();
		foreach ($attackFleets as $FleetID => $Attacker)
		{
			foreach($Attacker['detail'] as $Element => $amount)
			{
				$SortFleets[$FleetID]        += $pricelist[$Element]['capacity'] * $amount;
			}

			$SortFleets[$FleetID]            -= $Attacker['fleet']['fleet_resource_metal'] - $Attacker['fleet']['fleet_resource_crystal'] - $Attacker['fleet']['fleet_resource_deuterium'];
		}

		$Sumcapacity              = array_sum($SortFleets);

		// Step 1
		$booty['metal']         = min(($Sumcapacity / 3),  ($defenderPlanet['metal'] / 2));
		$Sumcapacity             -= $booty['metal'];

		// Step 2
		$booty['crystal']         = min(($Sumcapacity / 2),  ($defenderPlanet['crystal'] / 2));
		$Sumcapacity             -= $booty['crystal'];

		// Step 3
		$booty['deuterium']     = min($Sumcapacity,  ($defenderPlanet['deuterium'] / 2));
		$Sumcapacity             -= $booty['deuterium'];

		// Step 4
		$oldMetalBooty             = $booty['metal'];
		$booty['metal']         += min(($Sumcapacity / 2),  max((($defenderPlanet['metal']) / 2) - $booty['metal'], 0));
		$Sumcapacity             += $oldMetalBooty - $booty['metal'];

		// Step 5
		$booty['crystal']         += min(($Sumcapacity),  max((($defenderPlanet['crystal']) / 2) - $booty['crystal'], 0));

		$booty['metal']            = max($booty['metal'] ,0);
		$booty['crystal']        = max($booty['crystal'] ,0);
		$booty['deuterium']        = max($booty['deuterium'] ,0);

		$steal                    = array_map('floor', $booty);

		if($ForSim)
			return $steal;

		$AllCapacity        = array_sum($SortFleets);
		$QryUpdateFleet        = "";

		foreach($SortFleets as $FleetID => $Capacity)
		{
			$QryUpdateFleet     = "UPDATE {{table}} SET ";
			$QryUpdateFleet .= "`fleet_resource_metal` =  `fleet_resource_metal` + '".floattostring($steal['metal'] * ($Capacity /  $AllCapacity))."', ";
			$QryUpdateFleet .= "`fleet_resource_crystal` =  `fleet_resource_crystal` +'".floattostring($steal['crystal'] * ($Capacity  / $AllCapacity))."', ";
			$QryUpdateFleet .= "`fleet_resource_deuterium` =  `fleet_resource_deuterium` +'".floattostring($steal['deuterium'] * ($Capacity / $AllCapacity))."' ";
			$QryUpdateFleet .= "WHERE fleet_id = '".$FleetID."' ";
			$QryUpdateFleet .= "LIMIT 1;";
			doquery($QryUpdateFleet, 'fleets');

		}

		return $steal;
	}

	private function SpyTarget ($TargetPlanet, $Mode, $TitleString)
	{
		global $lang, $resource;

		$LookAtLoop = true;
		if ($Mode == 0)
		{
			$String  = "<table width=\"440\"><tr><td class=\"c\" colspan=\"5\">";
			$String .= $TitleString ." ". $TargetPlanet['name'];
			$String .= " <a href=\"game.php?page=galaxy&mode=3&galaxy=". $TargetPlanet["galaxy"] ."&system=". $TargetPlanet["system"]. "\">";
			$String .= "[". $TargetPlanet["galaxy"] .":". $TargetPlanet["system"] .":". $TargetPlanet["planet"] ."]</a>";
			$String .= $lang['sys_the'] . gmdate("d-m-Y H:i:s", time() + 2 * 60 * 60) ."</td>";
			$String .= "</tr><tr>";
			$String .= "<td width=220>". $lang['Metal']     ."</td><td width=220 align=right>". pretty_number($TargetPlanet['metal'])      ."</td><td>&nbsp;</td>";
			$String .= "<td width=220>". $lang['Crystal']   ."</td></td><td width=220 align=right>". pretty_number($TargetPlanet['crystal'])    ."</td>";
			$String .= "</tr><tr>";
			$String .= "<td width=220>". $lang['Deuterium'] ."</td><td width=220 align=right>". pretty_number($TargetPlanet['deuterium'])  ."</td><td>&nbsp;</td>";
			$String .= "<td width=220>". $lang['Energy']    ."</td><td width=220 align=right>". pretty_number($TargetPlanet['energy_max']) ."</td>";
			$String .= "</tr>";
			$LookAtLoop = false;
		}
		elseif ($Mode == 1)
		{
			$ResFrom[0] = 200;
			$ResTo[0]   = 299;
			$Loops      = 1;
		}
		elseif ($Mode == 2)
		{
			$ResFrom[0] = 400;
			$ResTo[0]   = 499;
			$ResFrom[1] = 500;
			$ResTo[1]   = 599;
			$Loops      = 2;
		}
		elseif ($Mode == 3)
		{
			$ResFrom[0] = 1;
			$ResTo[0]   = 99;
			$Loops      = 1;
		}
		elseif ($Mode == 4)
		{
			$ResFrom[0] = 100;
			$ResTo[0]   = 199;
			$Loops      = 1;
		}

		if ($LookAtLoop == true)
		{
			$String  = "<table width=\"440\" cellspacing=\"1\"><tr><td class=\"c\" colspan=\"". ((2 * SPY_REPORT_ROW) + (SPY_REPORT_ROW - 1))."\">". $TitleString ."</td></tr>";
			$Count       = 0;
			$CurrentLook = 0;
			while ($CurrentLook < $Loops)
			{
				$row     = 0;
				for ($Item = $ResFrom[$CurrentLook]; $Item <= $ResTo[$CurrentLook]; $Item++)
				{
					if ( $TargetPlanet[$resource[$Item]] > 0)
					{
						if ($row == 0)
							$String  .= "<tr>";

						$String  .= "<td align=left>".$lang['tech'][$Item]."</td><td align=right>".$TargetPlanet[$resource[$Item]]."</td>";
						if ($row < SPY_REPORT_ROW - 1)
							$String  .= "<td>&nbsp;</td>";

						$Count   += $TargetPlanet[$resource[$Item]];
						$row++;
						if ($row == SPY_REPORT_ROW)
						{
							$String  .= "</tr>";
							$row      = 0;
						}
					}
				}

				while ($row != 0)
				{
					$String  .= "<td>&nbsp;</td><td>&nbsp;</td>";
					$row++;
					if ($row == SPY_REPORT_ROW)
					{
						$String  .= "</tr>";
						$row      = 0;
					}
				}
				$CurrentLook++;
			}
		}
		$String .= "</table>";

		$return['String'] = $String;
		$return['Count']  = $Count;

		return $return;
	}

	private function walka ($CurrentSet, $TargetSet, $CurrentTechno, $TargetTechno)
	{
		global $pricelist, $CombatCaps, $game_config, $user;

		$runda       = array();
		$atakujacy_n = array();
		$wrog_n      = array();

		if (!is_null($CurrentSet))
		{
			$atakujacy_zlom_poczatek['metal']   = 0;
			$atakujacy_zlom_poczatek['crystal'] = 0;
			foreach($CurrentSet as $a => $b)
			{
				$atakujacy_zlom_poczatek['metal']   = $atakujacy_zlom_poczatek['metal']   + $CurrentSet[$a]['count'] * $pricelist[$a]['metal'];
				$atakujacy_zlom_poczatek['crystal'] = $atakujacy_zlom_poczatek['crystal'] + $CurrentSet[$a]['count'] * $pricelist[$a]['crystal'];
			}
		}

		$wrog_zlom_poczatek['metal']   	= 0;
		$wrog_zlom_poczatek['crystal'] 	= 0;
		$wrog_poczatek 					= $TargetSet;

		if (!is_null($TargetSet))
		{
			foreach($TargetSet as $a => $b)
			{
				if ($a < 300)
				{
					$wrog_zlom_poczatek['metal']   = $wrog_zlom_poczatek['metal']   + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$wrog_zlom_poczatek['crystal'] = $wrog_zlom_poczatek['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				}
				else
				{
					$wrog_zlom_poczatek_obrona['metal']   = $wrog_zlom_poczatek_obrona['metal']   + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$wrog_zlom_poczatek_obrona['crystal'] = $wrog_zlom_poczatek_obrona['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				}
			}
		}

		for ($i = 1; $i <= 7; $i++)
		{
			$atakujacy_atak   = 0;
			$wrog_atak        = 0;
			$atakujacy_obrona = 0;
			$wrog_obrona      = 0;
			$atakujacy_ilosc  = 0;
			$wrog_ilosc       = 0;
			$wrog_tarcza      = 0;
			$atakujacy_tarcza = 0;

			if (!is_null($CurrentSet))
			{
				foreach($CurrentSet as $a => $b)
				{
					$CurrentSet[$a]["obrona"] 	= $CurrentSet[$a]['count'] * ($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10 * (1 + (0.1 * ($CurrentTechno["defence_tech"]) + (AMIRAL * $user['rpg_amiral'])));
					$rand 						= rand(80, 120) / 100;
					$CurrentSet[$a]["tarcza"] 	= $CurrentSet[$a]['count'] * $CombatCaps[$a]['shield'] * (1 + (0.1 * $CurrentTechno["shield_tech"]) + (AMIRAL * $user['rpg_amiral'])) * $rand;
					$atak_statku 				= $CombatCaps[$a]['attack'];
					$technologie 				= (1 + (0.1 * $CurrentTechno["military_tech"]+(AMIRAL * $user['rpg_amiral'])));
					$rand 						= rand(80, 120) / 100;
					$ilosc 						= $CurrentSet[$a]['count'];
					$CurrentSet[$a]["atak"] 	= $ilosc * $atak_statku * $technologie * $rand;
					$atakujacy_atak			 	= $atakujacy_atak + $CurrentSet[$a]["atak"];
					$atakujacy_obrona 			= $atakujacy_obrona + $CurrentSet[$a]["obrona"];
					$atakujacy_ilosc 			= $atakujacy_ilosc + $CurrentSet[$a]['count'];
				}
			}
			else
			{
				$atakujacy_ilosc = 0;
				break;
			}

			if (!is_null($TargetSet))
			{
				foreach($TargetSet as $a => $b)
				{
					$TargetSet[$a]["obrona"] 	= $TargetSet[$a]['count'] * ($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10 * (1 + (0.1 * ($TargetTechno["defence_tech"]) + (AMIRAL* $user['rpg_amiral'])));
					$rand 						= rand(80, 120) / 100;
					$TargetSet[$a]["tarcza"] 	= $TargetSet[$a]['count'] * $CombatCaps[$a]['shield'] * (1 + (0.1 * $TargetTechno["shield_tech"])+ (AMIRAL * $user['rpg_amiral'])) * $rand;
					$atak_statku 				= $CombatCaps[$a]['attack'];
					$technologie 				= (1 + (0.1 * $TargetTechno["military_tech"]) + (AMIRAL * $user['rpg_amiral']));
					$rand 						= rand(80, 120) / 100;
					$ilosc 						= $TargetSet[$a]['count'];
					$TargetSet[$a]["atak"] 		= $ilosc * $atak_statku * $technologie * $rand;
					$wrog_atak 					= $wrog_atak + $TargetSet[$a]["atak"];
					$wrog_obrona 				= $wrog_obrona + $TargetSet[$a]["obrona"];
					$wrog_ilosc 				= $wrog_ilosc + $TargetSet[$a]['count'];
				}
			}
			else
			{
				$wrog_ilosc 						= 0;
				$runda[$i]["atakujacy"] 			= $CurrentSet;
				$runda[$i]["wrog"] 					= $TargetSet;
				$runda[$i]["atakujacy"]["atak"] 	= $atakujacy_atak;
				$runda[$i]["wrog"]["atak"] 			= $wrog_atak;
				$runda[$i]["atakujacy"]['count'] 	= $atakujacy_ilosc;
				$runda[$i]["wrog"]['count'] 		= $wrog_ilosc;
				break;
			}

			$runda[$i]["atakujacy"] 			= $CurrentSet;
			$runda[$i]["wrog"] 					= $TargetSet;
			$runda[$i]["atakujacy"]["atak"] 	= $atakujacy_atak;
			$runda[$i]["wrog"]["atak"] 			= $wrog_atak;
			$runda[$i]["atakujacy"]['count']	= $atakujacy_ilosc;
			$runda[$i]["wrog"]['count'] 		= $wrog_ilosc;

			if (($atakujacy_ilosc == 0) or ($wrog_ilosc == 0))
				break;

			foreach($CurrentSet as $a => $b)
			{
				if ($atakujacy_ilosc > 0)
				{
					$wrog_moc = $CurrentSet[$a]['count'] * $wrog_atak / $atakujacy_ilosc;
					if ($CurrentSet[$a]["tarcza"] < $wrog_moc)
					{
						$max_zdjac = floor($CurrentSet[$a]['count'] * $wrog_ilosc / $atakujacy_ilosc);
						$wrog_moc = $wrog_moc - $CurrentSet[$a]["tarcza"];
						$atakujacy_tarcza = $atakujacy_tarcza + $CurrentSet[$a]["tarcza"];
						$ile_zdjac = floor(($wrog_moc / (($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10)));

						if ($ile_zdjac > $max_zdjac)
							$ile_zdjac = $max_zdjac;
						$atakujacy_n[$a]['count'] = ceil($CurrentSet[$a]['count'] - $ile_zdjac);

						if ($atakujacy_n[$a]['count'] <= 0)
							$atakujacy_n[$a]['count'] = 0;
					}
					else
					{
						$atakujacy_n[$a]['count'] = $CurrentSet[$a]['count'];
						$atakujacy_tarcza = $atakujacy_tarcza + $wrog_moc;
					}
				}
				else
				{
					$atakujacy_n[$a]['count'] = $CurrentSet[$a]['count'];
					$atakujacy_tarcza = $atakujacy_tarcza + $wrog_moc;
				}
			}

			foreach($TargetSet as $a => $b)
			{
				if ($wrog_ilosc > 0)
				{
					$atakujacy_moc = $TargetSet[$a]['count'] * $atakujacy_atak / $wrog_ilosc;
					if ($TargetSet[$a]["tarcza"] < $atakujacy_moc)
					{
						$max_zdjac = floor($TargetSet[$a]['count'] * $atakujacy_ilosc / $wrog_ilosc);
						$atakujacy_moc = $atakujacy_moc - $TargetSet[$a]["tarcza"];
						$wrog_tarcza = $wrog_tarcza + $TargetSet[$a]["tarcza"];

						$ile_zdjac = floor(($atakujacy_moc / (($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10)));

						if ($ile_zdjac > $max_zdjac)
							$ile_zdjac = $max_zdjac;

						$wrog_n[$a]['count'] = ceil($TargetSet[$a]['count'] - $ile_zdjac);

						if ($wrog_n[$a]['count'] <= 0)
							$wrog_n[$a]['count'] = 0;
					}
					else
					{
						$wrog_n[$a]['count'] = $TargetSet[$a]['count'];
						$wrog_tarcza = $wrog_tarcza + $atakujacy_moc;
					}
				}
				else
				{
					$wrog_n[$a]['count'] = $TargetSet[$a]['count'];
					$wrog_tarcza = $wrog_tarcza + $atakujacy_moc;
				}
			}

			foreach($CurrentSet as $a => $b)
			{
				foreach ($CombatCaps[$a]['sd'] as $c => $d)
				{
					if (isset($TargetSet[$c]))
					{
						$wrog_n[$c]['count'] = $wrog_n[$c]['count'] - floor($d * rand(50, 100) / 100);
						if ($wrog_n[$c]['count'] <= 0)
							$wrog_n[$c]['count'] = 0;
					}
				}
			}

			foreach($TargetSet as $a => $b)
			{
				foreach ($CombatCaps[$a]['sd'] as $c => $d)
				{
					if (isset($CurrentSet[$c]))
					{
						$atakujacy_n[$c]['count'] = $atakujacy_n[$c]['count'] - floor($d * rand(50, 100) / 100);
						if ($atakujacy_n[$c]['count'] <= 0)
							$atakujacy_n[$c]['count'] = 0;
					}
				}
			}

			$runda[$i]["atakujacy"]["tarcza"] 	= $atakujacy_tarcza;
			$runda[$i]["wrog"]["tarcza"] 		= $wrog_tarcza;
			$TargetSet 							= $wrog_n;
			$CurrentSet 						= $atakujacy_n;
		}

		if (($atakujacy_ilosc == 0) or ($wrog_ilosc == 0))
		{
			if (($atakujacy_ilosc == 0) and ($wrog_ilosc == 0))
				$wygrana = "r";
			else
			if ($atakujacy_ilosc == 0)
				$wygrana = "w";
			else
				$wygrana = "a";
		}
		else
		{
			$i = sizeof($runda);
			$runda[$i]["atakujacy"] = $CurrentSet;
			$runda[$i]["wrog"] = $TargetSet;
			$runda[$i]["atakujacy"]["atak"] = $atakujacy_atak;
			$runda[$i]["wrog"]["atak"] = $wrog_atak;
			$runda[$i]["atakujacy"]['count'] = $atakujacy_ilosc;
			$runda[$i]["wrog"]['count'] = $wrog_ilosc;
			$wygrana = "r";
		}

		$atakujacy_zlom_koniec['metal'] = 0;
		$atakujacy_zlom_koniec['crystal'] = 0;
		if (!is_null($CurrentSet))
		{
			foreach($CurrentSet as $a => $b)
			{
				$atakujacy_zlom_koniec['metal']   = $atakujacy_zlom_koniec['metal'] + $CurrentSet[$a]['count'] * $pricelist[$a]['metal'];
				$atakujacy_zlom_koniec['crystal'] = $atakujacy_zlom_koniec['crystal'] + $CurrentSet[$a]['count'] * $pricelist[$a]['crystal'];
			}
		}

		$wrog_zlom_koniec['metal'] = 0;
		$wrog_zlom_koniec['crystal'] = 0;
		if (!is_null($TargetSet))
		{
			foreach($TargetSet as $a => $b)
			{
				if ($a < 300)
				{
					$wrog_zlom_koniec['metal'] = $wrog_zlom_koniec['metal'] + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$wrog_zlom_koniec['crystal'] = $wrog_zlom_koniec['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				}
				else
				{
					$wrog_zlom_koniec_obrona['metal'] = $wrog_zlom_koniec_obrona['metal'] + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$wrog_zlom_koniec_obrona['crystal'] = $wrog_zlom_koniec_obrona['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				}
			}
		}
		$ilosc_wrog = 0;
		$straty_obrona_wrog = 0;

		if (!is_null($TargetSet))
		{
			foreach($TargetSet as $a => $b)
			{
				if ($a > 300)
				{
					$straty_obrona_wrog = $straty_obrona_wrog + (($wrog_poczatek[$a]['count'] - $TargetSet[$a]['count']) * ($pricelist[$a]['metal'] + $pricelist[$a]['crystal']));
					$TargetSet[$a]['count'] = $TargetSet[$a]['count'] + (($wrog_poczatek[$a]['count'] - $TargetSet[$a]['count']) * rand(60, 80) / 100);
					$ilosc_wrog = $ilosc_wrog + $TargetSet[$a]['count'];
				}
			}
		}

		if (($ilosc_wrog > 0) && ($atakujacy_ilosc == 0))
			$wygrana = "w";

		$zlom['metal']    = ((($atakujacy_zlom_poczatek['metal']   - $atakujacy_zlom_koniec['metal'])   + ($wrog_zlom_poczatek['metal']   - $wrog_zlom_koniec['metal']))   * ($game_config['Fleet_Cdr'] / 100));
		$zlom['crystal']  = ((($atakujacy_zlom_poczatek['crystal'] - $atakujacy_zlom_koniec['crystal']) + ($wrog_zlom_poczatek['crystal'] - $wrog_zlom_koniec['crystal'])) * ($game_config['Fleet_Cdr'] / 100));

		$zlom['metal']   += ((($atakujacy_zlom_poczatek['metal']   - $atakujacy_zlom_koniec['metal'])   + ($wrog_zlom_poczatek['metal']   - $wrog_zlom_koniec['metal']))   * ($game_config['Defs_Cdr'] / 100));
		$zlom['crystal'] += ((($atakujacy_zlom_poczatek['crystal'] - $atakujacy_zlom_koniec['crystal']) + ($wrog_zlom_poczatek['crystal'] - $wrog_zlom_koniec['crystal'])) * ($game_config['Defs_Cdr'] / 100));

		$zlom["atakujacy"] = (($atakujacy_zlom_poczatek['metal'] - $atakujacy_zlom_koniec['metal']) + ($atakujacy_zlom_poczatek['crystal'] - $atakujacy_zlom_koniec['crystal']));
		$zlom["wrog"]      = (($wrog_zlom_poczatek['metal']      - $wrog_zlom_koniec['metal'])      + ($wrog_zlom_poczatek['crystal']      - $wrog_zlom_koniec['crystal']) + $straty_obrona_wrog);

		return array("atakujacy" => $CurrentSet, "wrog" => $TargetSet, "wygrana" => $wygrana, "dane_do_rw" => $runda, "zlom" => $zlom);
	}

	private function RestoreFleetToPlanet ($FleetRow, $Start = true)
	{
		global $resource;

		$FleetRecord         = explode(";", $FleetRow['fleet_array']);
		$QryUpdFleet         = "";
		foreach ($FleetRecord as $Item => $Group)
		{
			if ($Group != '')
			{
				$Class        = explode (",", $Group);
				$QryUpdFleet .= "`". $resource[$Class[0]] ."` = `".$resource[$Class[0]]."` + '".$Class[1]."', \n";
			}
		}

		$QryUpdatePlanet   = "UPDATE {{table}} SET ";
		if ($QryUpdFleet != "")
			$QryUpdatePlanet  .= $QryUpdFleet;

		$QryUpdatePlanet  .= "`metal` = `metal` + '". $FleetRow['fleet_resource_metal'] ."', ";
		$QryUpdatePlanet  .= "`crystal` = `crystal` + '". $FleetRow['fleet_resource_crystal'] ."', ";
		$QryUpdatePlanet  .= "`deuterium` = `deuterium` + '". $FleetRow['fleet_resource_deuterium'] ."' ";
		$QryUpdatePlanet  .= "WHERE ";

		if ($Start == true)
		{
			$QryUpdatePlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
			$QryUpdatePlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
			$QryUpdatePlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
			$QryUpdatePlanet  .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."' ";
		}
		else
		{
			$QryUpdatePlanet  .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
			$QryUpdatePlanet  .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
			$QryUpdatePlanet  .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
			$QryUpdatePlanet  .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
		}
		$QryUpdatePlanet  .= "LIMIT 1;";
		doquery( $QryUpdatePlanet, 'planets');
	}

	private function StoreGoodsToPlanet ($FleetRow, $Start = false)
	{
		$QryUpdatePlanet   = "UPDATE {{table}} SET ";
		$QryUpdatePlanet  .= "`metal` = `metal` + '". $FleetRow['fleet_resource_metal'] ."', ";
		$QryUpdatePlanet  .= "`crystal` = `crystal` + '". $FleetRow['fleet_resource_crystal'] ."', ";
		$QryUpdatePlanet  .= "`deuterium` = `deuterium` + '". $FleetRow['fleet_resource_deuterium'] ."' ";
		$QryUpdatePlanet  .= "WHERE ";

		if ($Start == true)
		{
			$QryUpdatePlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
			$QryUpdatePlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
			$QryUpdatePlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
			$QryUpdatePlanet  .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."' ";
		}
		else
		{
			$QryUpdatePlanet  .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
			$QryUpdatePlanet  .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
			$QryUpdatePlanet  .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
			$QryUpdatePlanet  .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
		}

		$QryUpdatePlanet  .= "LIMIT 1;";
		doquery( $QryUpdatePlanet, 'planets');
	}

	private function raketenangriff($verteidiger_panzerung, $angreifer_waffen, $iraks, $def, $primaerziel = '0')
	{
		$temp = '';
		$temp2 = '';

		$def[10] = $iraks;

		$metall     = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$kristall   = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$deut       = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$verblieben = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

		for($temp = 0; $temp < 11; $temp++)
			$verblieben[$temp] = $def[$temp];

		$kaputt  = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$hull 	 = Array();
		$hull[0] = 200 * (1 + $verteidiger_panzerung / 10);
		$hull[1] = $hull[0];
		$hull[2] = 800 * (1 + ($verteidiger_panzerung / 10));
		$hull[3] = 3500 * (1 + ($verteidiger_panzerung / 10));
		$hull[4] = $hull[2];
		$hull[5] = 10000 * (1 + ($verteidiger_panzerung / 10));
		$hull[6] = 2000 * (1 + ($verteidiger_panzerung / 10));
		$hull[7] = $hull[5];
		$hull[8] = 1500 * (1 + ($verteidiger_panzerung / 10));

		$metall_cost_tab   = Array( 2, 1.5, 6, 20, 2, 50, 10, 50, 12.5, 8);
		$kristall_cost_tab = Array( 0, 0.5, 2, 15, 6, 50, 10, 50,  2.5, 0);
		$deut_cost_tab     = Array( 0,   0, 0,  2, 0, 30,  0,  0, 10.0, 2);

		$schaden = floor(($def[10] - $def[9]) * (12000 * (1 + ($angreifer_waffen / 10))));
		if ($schaden < 0)
			$schaden = 0;

		switch ($primaerziel)
		{
			case 0:
				$beschussreihenfolge = Array(0, 1, 2, 3, 4, 5, 6, 7, 8);
				break;
			case 1:
				$beschussreihenfolge = Array(1, 0, 2, 3, 4, 5, 6, 7, 8);
				break;
			case 2:
				$beschussreihenfolge = Array(2, 0, 1, 3, 4, 5, 6, 7, 8);
				break;
			case 3:
				$beschussreihenfolge = Array(3, 0, 1, 2, 4, 5, 6, 7, 8);
				break;
			case 4:
				$beschussreihenfolge = Array(4, 0, 1, 2, 3, 5, 6, 7, 8);
				break;
			case 5:
				$beschussreihenfolge = Array(5, 0, 1, 2, 3, 4, 6, 7, 8);
				break;
			case 6:
				$beschussreihenfolge = Array(6, 0, 1, 2, 3, 4, 5, 7, 8);
				break;
			case 7:
				$beschussreihenfolge = Array(7, 0, 1, 2, 3, 4, 5, 6, 8);
				break;
			case 8:
				$beschussreihenfolge = Array(0, 1, 2, 3, 4, 5, 6, 7, 8);
				break;
		}

		$verblieben[10] 	= 0;
		$kaputt[10] 	   += $def[10];
		$metall[10] 	   += $kaputt[10] * $metall_cost_tab[8];
		$kristall[10]      += $kaputt[10] * $kristall_cost_tab[8];
		$deut[10]          += $kaputt[10] * $deut_cost_tab[8];
		$verblieben[9]      = ($def[9] - $def[10]);

		if ($verblieben[9] < 0)
			$verblieben[9] = 0;

		$kaputt[11]    = $def[9] - $verblieben[9];
		$kaputt[9]    += ($def[9] - $verblieben[9]);
		$metall[9]    += $kaputt[9] * $metall_cost_tab[9];
		$kristall[9]  += $kaputt[9] * $kristall_cost_tab[9];
		$deut[9] 	  += $kaputt[9] * $deut_cost_tab[9];
		$metall[11]   += $metall[9];
		$kristall[11] += $kristall[9];
		$deut[11]     += $deut[9];

		for($temp = 0; $temp < 9; $temp++)
		{
			if ($schaden >= ($hull[$beschussreihenfolge[$temp]] * $def[$beschussreihenfolge[$temp]]))
			{
				$kaputt[$beschussreihenfolge[$temp]] += $def[$beschussreihenfolge[$temp]];
				$verblieben[$beschussreihenfolge[$temp]] = 0;
				$schaden -= ($hull[$beschussreihenfolge[$temp]] * $kaputt[$beschussreihenfolge[$temp]]);
			}
			else
			{
				$kaputt[$beschussreihenfolge[$temp]] += floor($schaden / $hull[$beschussreihenfolge[$temp]]);
				$schaden -= $kaputt[$beschussreihenfolge[$temp]] * $hull[$beschussreihenfolge[$temp]];
				$verblieben[$beschussreihenfolge[$temp]] = ($def[$beschussreihenfolge[$temp]] - $kaputt[$beschussreihenfolge[$temp]]);
			}

			$metall[$beschussreihenfolge[$temp]] += $kaputt[$beschussreihenfolge[$temp]] * $metall_cost_tab[$beschussreihenfolge[$temp]];
			$kristall[$beschussreihenfolge[$temp]] += $kaputt[$beschussreihenfolge[$temp]] * $kristall_cost_tab[$beschussreihenfolge[$temp]];
			$deut[$beschussreihenfolge[$temp]] += $kaputt[$beschussreihenfolge[$temp]] * $deut_cost_tab[$beschussreihenfolge[$temp]];

			$verblieben[11] += $verblieben[$beschussreihenfolge[$temp]];
			$kaputt[11] += $kaputt[$beschussreihenfolge[$temp]];
			$metall[11] += $metall[$beschussreihenfolge[$temp]];
			$kristall[11] += $kristall[$beschussreihenfolge[$temp]];
			$deut[11] += $deut[$beschussreihenfolge[$temp]];
		}

		$return = array();

		$return['verbleibt'] = $verblieben;
		$return['zerstoert'] = $kaputt;
		$return['verluste_metall'] = $metall;
		$return['verluste_kristall'] = $kristall;
		$return['verluste_deuterium'] = $deut;

		return $return;
	}

	private function MissionCaseAttack ($FleetRow)
	{
		global $pricelist, $lang, $resource, $CombatCaps, $game_config, $user;

		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] <= time())
		{
			$targetPlanet = doquery("SELECT * FROM {{table}} WHERE `galaxy` = ". intval($FleetRow['fleet_end_galaxy']) ." AND `system` = ". intval($FleetRow['fleet_end_system']) ." AND `planet_type` = ". intval($FleetRow['fleet_end_type']) ." AND `planet` = ". intval($FleetRow['fleet_end_planet']) .";",'planets', true);

			if ($FleetRow['fleet_group'] > 0)
			{
				doquery("DELETE FROM {{table}} WHERE id =".intval($FleetRow['fleet_group']),'aks');
				doquery("UPDATE {{table}} SET fleet_mess=1 WHERE fleet_group=".$FleetRow['fleet_group'],'fleets');
			}
			else
			{
				doquery("UPDATE {{table}} SET fleet_mess=1 WHERE fleet_id=".intval($FleetRow['fleet_id']),'fleets');
			}

			$targetGalaxy = doquery('SELECT * FROM {{table}} WHERE `galaxy` = '. intval($FleetRow['fleet_end_galaxy']) .' AND `system` = '. intval($FleetRow['fleet_end_system']) .' AND `planet` = '. intval($FleetRow['fleet_end_planet']) .';','galaxy', true);
			$targetUser   = doquery('SELECT * FROM {{table}} WHERE id='.intval($targetPlanet['id_owner']),'users', true);

			PlanetResourceUpdate ( $targetUser, $targetPlanet, time() );

			$targetGalaxy = doquery('SELECT * FROM {{table}} WHERE `galaxy` = '. intval($FleetRow['fleet_end_galaxy']) .' AND `system` = '. intval($FleetRow['fleet_end_system']) .' AND `planet` = '. intval($FleetRow['fleet_end_planet']) .';','galaxy', true);
			$targetUser   = doquery('SELECT * FROM {{table}} WHERE id='.intval($targetPlanet['id_owner']),'users', true);

			$TargetUserID = $targetUser['id'];
			$attackFleets = array();

			if ($FleetRow['fleet_group'] != 0)
			{
				$fleets = doquery('SELECT * FROM {{table}} WHERE fleet_group='.$FleetRow['fleet_group'],'fleets');
				while ($fleet = mysql_fetch_assoc($fleets))
				{
					$attackFleets[$fleet['fleet_id']]['fleet'] = $fleet;
					$attackFleets[$fleet['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id ='.intval($fleet['fleet_owner']),'users', true);
					$attackFleets[$fleet['fleet_id']]['detail'] = array();
					$temp = explode(';', $fleet['fleet_array']);
					foreach ($temp as $temp2)
					{
						$temp2 = explode(',', $temp2);

						if ($temp2[0] < 100) continue;

						if (!isset($attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]]))
							$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] = 0;

						$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
					}
				}

			}
			else
			{
				$attackFleets[$FleetRow['fleet_id']]['fleet'] = $FleetRow;
				$attackFleets[$FleetRow['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id='.intval($FleetRow['fleet_owner']),'users', true);
				$attackFleets[$FleetRow['fleet_id']]['detail'] = array();
				$temp = explode(';', $FleetRow['fleet_array']);
				foreach ($temp as $temp2)
				{
					$temp2 = explode(',', $temp2);

					if ($temp2[0] < 100) continue;

					if (!isset($attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]]))
						$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] = 0;

					$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
				}
			}
			$defense = array();

			$def = doquery('SELECT * FROM {{table}} WHERE `fleet_end_galaxy` = '. intval($FleetRow['fleet_end_galaxy']) .' AND `fleet_end_system` = '. intval($FleetRow['fleet_end_system']) .' AND `fleet_end_type` = '. intval($FleetRow['fleet_end_type']) .' AND `fleet_end_planet` = '. intval($FleetRow['fleet_end_planet']) .' AND fleet_start_time<'.time().' AND fleet_end_stay>='.time(),'fleets');
			while ($defRow = mysql_fetch_assoc($def))
			{
				$defRowDef = explode(';', $defRow['fleet_array']);
				foreach ($defRowDef as $Element)
				{
					$Element = explode(',', $Element);

					if ($Element[0] < 100) continue;

					if (!isset($defense[$defRow['fleet_id']]['def'][$Element[0]]))
						$defense[$defRow['fleet_id']][$Element[0]] = 0;

					$defense[$defRow['fleet_id']]['def'][$Element[0]] += $Element[1];
					$defense[$defRow['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id='.intval($defRow['fleet_owner']),'users', true);
				}
			}

			$defense[0]['def'] = array();
			$defense[0]['user'] = $targetUser;
			for ($i = 200; $i < 500; $i++)
			{
				if (isset($resource[$i]) && isset($targetPlanet[$resource[$i]]))
				{
					$defense[0]['def'][$i] = $targetPlanet[$resource[$i]];
				}
			}
			$start 		= microtime(true);
			$result 	= calculateAttack($attackFleets, $defense);
			$totaltime 	= microtime(true) - $start;

			$QryUpdateGalaxy = "UPDATE {{table}} SET ";
			$QryUpdateGalaxy .= "`metal` = `metal` +'".($result['debree']['att'][0]+$result['debree']['def'][0]) . "', ";
			$QryUpdateGalaxy .= "`crystal` = `crystal` + '" .($result['debree']['att'][1]+$result['debree']['def'][1]). "' ";
			$QryUpdateGalaxy .= "WHERE ";
			$QryUpdateGalaxy .= "`galaxy` = '" . intval($FleetRow['fleet_end_galaxy']) . "' AND ";
			$QryUpdateGalaxy .= "`system` = '" . intval($FleetRow['fleet_end_system']) . "' AND ";
			$QryUpdateGalaxy .= "`planet` = '" . intval($FleetRow['fleet_end_planet']) . "' ";
			$QryUpdateGalaxy .= "LIMIT 1;";
			doquery($QryUpdateGalaxy , 'galaxy');

			$totalDebree = $result['debree']['def'][0] + $result['debree']['def'][1] + $result['debree']['att'][0] + $result['debree']['att'][1];

			$steal = array('metal' => 0, 'crystal' => 0, 'deuterium' => 0);

			if ($result['won'] == "a")
			{
				$steal = self::calculateAKSSteal($attackFleets, $targetPlanet);
			}

			foreach ($attackFleets as $fleetID => $attacker)
			{
				$fleetArray = '';
				$totalCount = 0;
				foreach ($attacker['detail'] as $element => $amount)
				{
					if ($amount)
						$fleetArray .= $element.','.$amount.';';

					$totalCount += $amount;
				}

				if ($totalCount <= 0)
				{
					doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.intval($fleetID),'fleets');
				}
				else
				{
					doquery ('UPDATE {{table}} SET fleet_array="'.substr($fleetArray, 0, -1).'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.intval($fleetID),'fleets');
				}
			}

			foreach ($defense as $fleetID => $defender)
			{
				if ($fleetID != 0)
				{
					$fleetArray = '';
					$totalCount = 0;

					foreach ($defender['def'] as $element => $amount)
					{
						if ($amount) $fleetArray .= $element.','.$amount.';';
						$totalCount += $amount;
					}

					if ($totalCount <= 0)
					{
						doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.intval($fleetID),'fleets');

					}
					else
					{
						doquery('UPDATE {{table}} SET fleet_array="'.$fleetArray.'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.$fleetID,'fleets');
					}

				}
				else
				{
					$fleetArray = '';
					$totalCount = 0;

					foreach ($defender['def'] as $element => $amount)
					{
						$fleetArray .= '`'.$resource[$element].'`='.$amount.', ';
					}

					$QryUpdateTarget  = "UPDATE {{table}} SET ";
					$QryUpdateTarget .= $fleetArray;
					$QryUpdateTarget .= "`metal` = `metal` - '". $steal['metal'] ."', ";
					$QryUpdateTarget .= "`crystal` = `crystal` - '". $steal['crystal'] ."', ";
					$QryUpdateTarget .= "`deuterium` = `deuterium` - '". $steal['deuterium'] ."' ";
					$QryUpdateTarget .= "WHERE ";
					$QryUpdateTarget .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
					$QryUpdateTarget .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
					$QryUpdateTarget .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
					$QryUpdateTarget .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
					$QryUpdateTarget .= "LIMIT 1;";
					doquery( $QryUpdateTarget , 'planets');
				}
			}

			$FleetDebris      = $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
			$StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], $result['lost']['att']);
			$StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], $result['lost']['def']);
			$StrRuins         = sprintf ($lang['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $lang['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $lang['Crystal']);
			$DebrisField      = $StrAttackerUnits ."<br />". $StrDefenderUnits ."<br />". $StrRuins;
			$MoonChance       = $FleetDebris / 100000;

			if($FleetDebris > 2000000)
			{
				$MoonChance = 20;
				$UserChance = mt_rand(1, 100);
				$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
			}
			elseif($FleetDebris < 100000)
			{
				$UserChance = 0;
				$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
			}
			elseif($FleetDebris >= 100000)
			{
				$UserChance = mt_rand(1, 100);
				$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
			}

			if (($UserChance > 0) && ($UserChance <= $MoonChance) && ($targetGalaxy['id_luna'] == 0))
			{
				$TargetPlanetName = CreateOneMoonRecord ( $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $TargetUserID, $FleetRow['fleet_start_time'], '', $MoonChance );
				$GottenMoon       = sprintf ($lang['sys_moonbuilt'], $TargetPlanetName, $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
				$GottenMoon .= "<br />";
			}
			elseif ($UserChance = 0 or $UserChance > $MoonChance)
			{
				$GottenMoon = "";
			}

			$formatted_cr 	= formatCR($result,$steal,$MoonChance,$GottenMoon,$totaltime);
			$raport 		= $formatted_cr['html'];


			$rid   = md5($raport);
			$QryInsertRapport  = 'INSERT INTO {{table}} SET ';
			$QryInsertRapport .= '`time` = UNIX_TIMESTAMP(), ';

			foreach ($attackFleets as $fleetID => $attacker)
			{
				$users2[$attacker['user']['id']] = $attacker['user']['id'];
			}

			foreach ($defense as $fleetID => $defender)
			{
				$users2[$defender['user']['id']] = $defender['user']['id'];
			}

			$QryInsertRapport .= '`owners` = "'.implode(',', $users2).'", ';
			$QryInsertRapport .= '`rid` = "'. $rid .'", ';
			$QryInsertRapport .= '`a_zestrzelona` = "'.$formatted_cr['destroyed'].'", ';
			$QryInsertRapport .= '`raport` = "'. mysql_escape_string( $raport ) .'"';
			doquery($QryInsertRapport,'rw') or die("Error inserting CR to database".mysql_error()."<br /><br />Trying to execute:".mysql_query());

			if($result['won'] == "a")
			{
				$style = "green";
			}
			elseif ($result['won'] == "w")
			{
				$style = "orange";
			}
			elseif ($result['won'] == "r")
			{
				$style = "red";
			}

			$raport  = "<a href=\"#\" style=\"color:".$style.";\" OnClick='f(\"CombatReport.php?raport=". $rid ."\", \"\");' >" . $lang['sys_mess_attack_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."]</a>";

			SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $raport, '' );

			if($result['won'] == "a")
			{
				$style = "red";
			}
			elseif ($result['won'] == "w")
			{
				$style = "orange";
			}
			elseif ($result['won'] == "r")
			{
				$style = "green";
			}

			$raport2  = "<a href=\"#\" style=\"color:".$style.";\" OnClick='f(\"CombatReport.php?raport=". $rid ."\", \"\");' >" . $lang['sys_mess_attack_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."]</a>";

			foreach ($users2 as $id)
			{
				if ($id != $FleetRow['fleet_owner'] && $id != 0)
				{
					SendSimpleMessage ( $id, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $raport2, '' );
				}
			}
		}
		elseif ($FleetRow['fleet_end_time'] <= time())
		{
			$Message         = sprintf( $lang['sys_fleet_won'],
						$TargetName, GetTargetAdressLink($FleetRow, ''),
						pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],
						pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'],
						pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'] );
			SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
			$this->RestoreFleetToPlanet($FleetRow);
			doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.intval($FleetRow['fleet_id']),'fleets');
		}
	}

	private function MissionCaseACS($FleetRow)
	{
		global $pricelist, $lang, $resource, $CombatCaps, $game_config;

		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] > time())
		{
			$QryUpdateFleet  = "UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = '". intval($FleetRow['fleet_id']) ."' LIMIT 1 ;";
			doquery( $QryUpdateFleet, 'fleets');
		}
		elseif ($FleetRow['fleet_end_time'] <= time())
		{
			$this->RestoreFleetToPlanet($FleetRow);
			doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.intval($FleetRow['fleet_id']),'fleets');
		}
	}

	private function MissionCaseTransport ( $FleetRow )
	{
		global $lang;

		$QryStartPlanet   = "SELECT * FROM {{table}} ";
		$QryStartPlanet  .= "WHERE ";
		$QryStartPlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
		$QryStartPlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
		$QryStartPlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
		$QryStartPlanet  .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."';";
		$StartPlanet      = doquery( $QryStartPlanet, 'planets', true);
		$StartName        = $StartPlanet['name'];
		$StartOwner       = $StartPlanet['id_owner'];

		$QryTargetPlanet  = "SELECT * FROM {{table}} ";
		$QryTargetPlanet .= "WHERE ";
		$QryTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
		$QryTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
		$QryTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
		$QryTargetPlanet .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
		$TargetPlanet     = doquery( $QryTargetPlanet, 'planets', true);
		$TargetName       = $TargetPlanet['name'];
		$TargetOwner      = $TargetPlanet['id_owner'];

		if ($FleetRow['fleet_mess'] == 0)
		{
			if ($FleetRow['fleet_start_time'] < time())
			{
				$this->StoreGoodsToPlanet ($FleetRow, false);
				$Message         = sprintf( $lang['sys_tran_mess_owner'],
							$TargetName, GetTargetAdressLink($FleetRow, ''),
							$FleetRow['fleet_resource_metal'], $lang['Metal'],
							$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
							$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );

				SendSimpleMessage ( $StartOwner, '', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);
				if ($TargetOwner <> $StartOwner)
				{
					$Message         = sprintf( $lang['sys_tran_mess_user'],
									$StartName, GetStartAdressLink($FleetRow, ''),
									$TargetName, GetTargetAdressLink($FleetRow, ''),
									$FleetRow['fleet_resource_metal'], $lang['Metal'],
									$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
									$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );
					SendSimpleMessage ( $TargetOwner, '', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);
				}

				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_resource_metal` = '0' , ";
				$QryUpdateFleet .= "`fleet_resource_crystal` = '0' , ";
				$QryUpdateFleet .= "`fleet_resource_deuterium` = '0' , ";
				$QryUpdateFleet .= "`fleet_mess` = '1' ";
				$QryUpdateFleet .= "WHERE `fleet_id` = '". intval($FleetRow['fleet_id']) ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				doquery( $QryUpdateFleet, 'fleets');
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] < time())
			{
				$Message             = sprintf ($lang['sys_tran_mess_back'], $StartName, GetStartAdressLink($FleetRow, ''));
				SendSimpleMessage ( $StartOwner, '', $FleetRow['fleet_end_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
				$this->RestoreFleetToPlanet ( $FleetRow, true );
				doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
			}
		}
	}

	private function MissionCaseStay($FleetRow)
	{
		global $lang, $resource;

		if ($FleetRow['fleet_mess'] == 0)
		{
			if ($FleetRow['fleet_start_time'] <= time())
			{
				$QryGetTargetPlanet   = "SELECT * FROM {{table}} ";
				$QryGetTargetPlanet  .= "WHERE ";
				$QryGetTargetPlanet  .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
				$QryGetTargetPlanet  .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
				$QryGetTargetPlanet  .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
				$QryGetTargetPlanet  .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
				$TargetPlanet         = doquery( $QryGetTargetPlanet, 'planets', true);
				$TargetUserID         = $TargetPlanet['id_owner'];

				$TargetAdress         = sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
				$TargetAddedGoods     = sprintf ($lang['sys_stay_mess_goods'],
				$lang['Metal'], pretty_number($FleetRow['fleet_resource_metal']),
				$lang['Crystal'], pretty_number($FleetRow['fleet_resource_crystal']),
				$lang['Deuterium'], pretty_number($FleetRow['fleet_resource_deuterium']));

				$TargetMessage        = $lang['sys_stay_mess_start'] ."<a href=\"game.php?page=galaxy&mode=3&galaxy=". $FleetRow['fleet_end_galaxy'] ."&system=". $FleetRow['fleet_end_system'] ."\">";
				$TargetMessage       .= $TargetAdress. "</a>". $lang['sys_stay_mess_end'] ."<br />". $TargetAddedGoods;

				SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_qg'], $lang['sys_stay_mess_stay'], $TargetMessage);
				$this->RestoreFleetToPlanet ( $FleetRow, false );
				doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] <= time())
			{
				$TargetAdress         = sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet']);
				$TargetAddedGoods     = sprintf ($lang['sys_stay_mess_goods'],
				$lang['Metal'], pretty_number($FleetRow['fleet_resource_metal']),
				$lang['Crystal'], pretty_number($FleetRow['fleet_resource_crystal']),
				$lang['Deuterium'], pretty_number($FleetRow['fleet_resource_deuterium']));

				$TargetMessage        = $lang['sys_stay_mess_back'] ."<a href=\"game.php?page=galaxy&mode=3&galaxy=". $FleetRow['fleet_start_galaxy'] ."&system=". $FleetRow['fleet_start_system'] ."\">";
				$TargetMessage       .= $TargetAdress. "</a>". $lang['sys_stay_mess_bend'] ."<br />". $TargetAddedGoods;

				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 5, $lang['sys_mess_qg'], $lang['sys_mess_fleetback'], $TargetMessage);
				$this->RestoreFleetToPlanet ( $FleetRow, true );
				doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
			}
		}
	}

	private function MissionCaseStayAlly($FleetRow)
	{
		global $lang;

		$QryStartPlanet   = "SELECT * FROM {{table}} ";
		$QryStartPlanet  .= "WHERE ";
		$QryStartPlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
		$QryStartPlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
		$QryStartPlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."';";
		$StartPlanet      = doquery( $QryStartPlanet, 'planets', true);
		$StartName        = $StartPlanet['name'];
		$StartOwner       = $StartPlanet['id_owner'];

		$QryTargetPlanet  = "SELECT * FROM {{table}} ";
		$QryTargetPlanet .= "WHERE ";
		$QryTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
		$QryTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
		$QryTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."';";
		$TargetPlanet     = doquery( $QryTargetPlanet, 'planets', true);
		$TargetName       = $TargetPlanet['name'];
		$TargetOwner      = $TargetPlanet['id_owner'];

		if ($FleetRow['fleet_mess'] == 0)
		{
			if ($FleetRow['fleet_start_time'] <= time())
			{
				$Message = sprintf($lang['sys_tran_mess_owner'], $TargetName, GetTargetAdressLink($FleetRow, ''),
					$FleetRow['fleet_resource_metal'], $lang['Metal'],
					$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
					$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );

				SendSimpleMessage ($StartOwner, '',$FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);

				$Message = sprintf( $lang['sys_tran_mess_user'], $StartName, GetStartAdressLink($FleetRow, ''),
					$TargetName, GetTargetAdressLink($FleetRow, ''),
					$FleetRow['fleet_resource_metal'], $lang['Metal'],
					$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
					$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );

				SendSimpleMessage ($TargetOwner, '',$FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);

				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_mess` = 2 ";
				$QryUpdateFleet .= "WHERE `fleet_id` = '". intval($FleetRow['fleet_id']) ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				doquery( $QryUpdateFleet, 'fleets');

			}
			elseif($FleetRow['fleet_end_stay'] <= time())
			{
				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_mess` = 1 ";
				$QryUpdateFleet .= "WHERE `fleet_id` = '". intval($FleetRow['fleet_id']) ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				doquery( $QryUpdateFleet, 'fleets');
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] < time())
			{
				$Message         = sprintf ($lang['sys_tran_mess_back'], $StartName, GetStartAdressLink($FleetRow, ''));
				SendSimpleMessage ( $StartOwner, '', $FleetRow['fleet_end_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
				$this->RestoreFleetToPlanet ( $FleetRow, true );
				doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
			}
		}
	}

	private function MissionCaseSpy($FleetRow)
	{
		global $lang, $resource;

		if ($FleetRow['fleet_start_time'] <= time())
		{
			$CurrentUser         = doquery("SELECT * FROM {{table}} WHERE `id` = '".$FleetRow['fleet_owner']."';", 'users', true);
			$CurrentUserID       = $FleetRow['fleet_owner'];
			$QryGetTargetPlanet  = "SELECT * FROM {{table}} ";
			$QryGetTargetPlanet .= "WHERE ";
			$QryGetTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
			$QryGetTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
			$QryGetTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
			$QryGetTargetPlanet .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
			$TargetPlanet        = doquery( $QryGetTargetPlanet, 'planets', true);
			$TargetUserID        = $TargetPlanet['id_owner'];
			$CurrentPlanet       = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$FleetRow['fleet_start_galaxy']."' AND `system` = '".$FleetRow['fleet_start_system']."' AND `planet` = '".$FleetRow['fleet_start_planet']."';", 'planets', true);
			$CurrentSpyLvl       = $CurrentUser['spy_tech'] + ($CurrentUser['rpg_espion'] * ESPION);
			$TargetUser          = doquery("SELECT * FROM {{table}} WHERE `id` = '".$TargetUserID."';", 'users', true);
			$TargetSpyLvl        = $TargetUser['spy_tech'] + ($TargetUser['rpg_espion'] * ESPION);
			$fleet               = explode(";", $FleetRow['fleet_array']);
			$fquery              = "";

			PlanetResourceUpdate ( $TargetUser, $TargetPlanet, time() );

			foreach ($fleet as $a => $b)
			{
				if ($b != '')
				{
					$a = explode(",", $b);
					$fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";
					if ($FleetRow["fleet_mess"] != "1")
					{
						if ($a[0] == "210")
						{
							$LS    = $a[1];
							$QryTargetGalaxy  = "SELECT * FROM {{table}} WHERE ";
							$QryTargetGalaxy .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
							$QryTargetGalaxy .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
							$QryTargetGalaxy .= "`planet` = '". $FleetRow['fleet_end_planet'] ."';";
							$TargetGalaxy     = doquery( $QryTargetGalaxy, 'galaxy', true);
							$CristalDebris    = $TargetGalaxy['crystal'];
							$SpyToolDebris    = $LS * 300;

							$MaterialsInfo    = $this->SpyTarget ( $TargetPlanet, 0, $lang['sys_spy_maretials'] );
							$Materials        = $MaterialsInfo['String'];

							$PlanetFleetInfo  = $this->SpyTarget ( $TargetPlanet, 1, $lang['sys_spy_fleet'] );
							$PlanetFleet      = $Materials;
							$PlanetFleet     .= $PlanetFleetInfo['String'];

							$PlanetDefenInfo  = $this->SpyTarget ( $TargetPlanet, 2, $lang['sys_spy_defenses'] );
							$PlanetDefense    = $PlanetFleet;
							$PlanetDefense   .= $PlanetDefenInfo['String'];

							$PlanetBuildInfo  = $this->SpyTarget ( $TargetPlanet, 3, $lang['tech'][0] );
							$PlanetBuildings  = $PlanetDefense;
							$PlanetBuildings .= $PlanetBuildInfo['String'];

							$TargetTechnInfo  = $this->SpyTarget ( $TargetUser, 4, $lang['tech'][100] );
							$TargetTechnos    = $PlanetBuildings;
							$TargetTechnos   .= $TargetTechnInfo['String'];

							$TargetForce      = ($PlanetFleetInfo['Count'] * $LS) / 4;

							if ($TargetForce > 100)
								$TargetForce = 100;

							$TargetChances = rand(0, $TargetForce);
							$SpyerChances  = rand(0, 100);

							if ($TargetChances >= $SpyerChances)
								$DestProba = "<font color=\"red\">".$lang['sys_mess_spy_destroyed']."</font>";
							elseif ($TargetChances < $SpyerChances)
								$DestProba = sprintf( $lang['sys_mess_spy_lostproba'], $TargetChances);

							$AttackLink = "<center>";
							$AttackLink .= "<a href=\"game.php?page=fleet&galaxy=". $FleetRow['fleet_end_galaxy'] ."&system=". $FleetRow['fleet_end_system'] ."";
							$AttackLink .= "&planet=".$FleetRow['fleet_end_planet']."&planettype=".$FleetRow['fleet_end_type']."";
							$AttackLink .= "&target_mission=1";
							$AttackLink .= " \">". $lang['type_mission'][1] ."";
							$AttackLink .= "</a></center>";
							$MessageEnd  = "<center>".$DestProba."</center>";

							$pT = ($TargetSpyLvl - $CurrentSpyLvl);
							$pW = ($CurrentSpyLvl - $TargetSpyLvl);
							if ($TargetSpyLvl > $CurrentSpyLvl)
								$ST = ($LS - pow($pT, 2));
							if ($CurrentSpyLvl > $TargetSpyLvl)
								$ST = ($LS + pow($pW, 2));
							if ($TargetSpyLvl == $CurrentSpyLvl)
								$ST = $CurrentSpyLvl;
							if ($ST <= "1")
								$SpyMessage = $Materials."<br />".$AttackLink.$MessageEnd;
							if ($ST == "2")
								$SpyMessage = $PlanetFleet."<br />".$AttackLink.$MessageEnd;
							if ($ST == "4" or $ST == "3")
								$SpyMessage = $PlanetDefense."<br />".$AttackLink.$MessageEnd;
							if ($ST == "5" or $ST == "6")
								$SpyMessage = $PlanetBuildings."<br />".$AttackLink.$MessageEnd;
							if ($ST >= "7")
								$SpyMessage = $TargetTechnos."<br />".$AttackLink.$MessageEnd;

							SendSimpleMessage ( $CurrentUserID, '', $FleetRow['fleet_start_time'], 0, $lang['sys_mess_qg'], $lang['sys_mess_spy_report'], $SpyMessage);

							$TargetMessage  = $lang['sys_mess_spy_ennemyfleet'] ." ". $CurrentPlanet['name'];

							if($FleetRow['fleet_start_type'] == 3)
								$TargetMessage .= $lang['sys_mess_spy_report_moon'] . " ";

							$TargetMessage .= "<a href=\"game.php?page=galaxy&mode=3&galaxy=". $CurrentPlanet["galaxy"] ."&system=". $CurrentPlanet["system"] ."\">";
							$TargetMessage .= "[". $CurrentPlanet["galaxy"] .":". $CurrentPlanet["system"] .":". $CurrentPlanet["planet"] ."]</a> ";
							$TargetMessage .= $lang['sys_mess_spy_seen_at'] ." ". $TargetPlanet['name'];
							$TargetMessage .= " [". $TargetPlanet["galaxy"] .":". $TargetPlanet["system"] .":". $TargetPlanet["planet"] ."].";

							SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 0, $lang['sys_mess_spy_control'], $lang['sys_mess_spy_activity'], $TargetMessage);
						}
						if ($TargetChances >= $SpyerChances)
						{
							$QryUpdateGalaxy  = "UPDATE {{table}} SET ";
							$QryUpdateGalaxy .= "`crystal` = `crystal` + '". (0 + $SpyToolDebris) ."' ";
							$QryUpdateGalaxy .= "WHERE `id_planet` = '". $TargetPlanet['id'] ."';";
							doquery( $QryUpdateGalaxy, 'galaxy');
							doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
						}
						else
							doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
					}
				}
				else
				{
					if ($FleetRow['fleet_end_time'] <= time())
					{
						$this->RestoreFleetToPlanet ( $FleetRow, true );
						doquery("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
					}
				}
			}
		}
	}

	private function MissionCaseRecycling ($FleetRow)
	{
		global $pricelist, $lang;

		if ($FleetRow["fleet_mess"] == "0")
		{
			if ($FleetRow['fleet_start_time'] <= time())
			{
				$QrySelectGalaxy  = "SELECT * FROM {{table}} ";
				$QrySelectGalaxy .= "WHERE ";
				$QrySelectGalaxy .= "`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND ";
				$QrySelectGalaxy .= "`system` = '".$FleetRow['fleet_end_system']."' AND ";
				$QrySelectGalaxy .= "`planet` = '".$FleetRow['fleet_end_planet']."' ";
				$QrySelectGalaxy .= "LIMIT 1;";
				$TargetGalaxy     = doquery( $QrySelectGalaxy, 'galaxy', true);

				$FleetRecord         = explode(";", $FleetRow['fleet_array']);
				$RecyclerCapacity    = 0;
				$OtherFleetCapacity  = 0;
				foreach ($FleetRecord as $Item => $Group)
				{
					if ($Group != '')
					{
						$Class        = explode (",", $Group);
						if ($Class[0] == 209)
							$RecyclerCapacity   += $pricelist[$Class[0]]["capacity"] * $Class[1];
						else
							$OtherFleetCapacity += $pricelist[$Class[0]]["capacity"] * $Class[1];
					}
				}

				$IncomingFleetGoods = $FleetRow["fleet_resource_metal"] + $FleetRow["fleet_resource_crystal"] + $FleetRow["fleet_resource_deuterium"];
				if ($IncomingFleetGoods > $OtherFleetCapacity)
					$RecyclerCapacity -= ($IncomingFleetGoods - $OtherFleetCapacity);

				if (($TargetGalaxy["metal"] + $TargetGalaxy["crystal"]) <= $RecyclerCapacity)
				{
					$RecycledGoods["metal"]   = $TargetGalaxy["metal"];
					$RecycledGoods["crystal"] = $TargetGalaxy["crystal"];
				}
				else
				{
					if (($TargetGalaxy["metal"]   > $RecyclerCapacity / 2) && ($TargetGalaxy["crystal"] > $RecyclerCapacity / 2))
					{
						$RecycledGoods["metal"]   = $RecyclerCapacity / 2;
						$RecycledGoods["crystal"] = $RecyclerCapacity / 2;
					}
					else
					{
						if ($TargetGalaxy["metal"] > $TargetGalaxy["crystal"])
						{
							$RecycledGoods["crystal"] = $TargetGalaxy["crystal"];
							if ($TargetGalaxy["metal"] > ($RecyclerCapacity - $RecycledGoods["crystal"]))
								$RecycledGoods["metal"] = $RecyclerCapacity - $RecycledGoods["crystal"];
							else
								$RecycledGoods["metal"] = $TargetGalaxy["metal"];
						}
						else
						{
							$RecycledGoods["metal"] = $TargetGalaxy["metal"];
							if ($TargetGalaxy["crystal"] > ($RecyclerCapacity - $RecycledGoods["metal"]))
								$RecycledGoods["crystal"] = $RecyclerCapacity - $RecycledGoods["metal"];
							else
								$RecycledGoods["crystal"] = $TargetGalaxy["crystal"];
						}
					}
				}

				$QryUpdateGalaxy  = "UPDATE {{table}} SET ";
				$QryUpdateGalaxy .= "`metal` = `metal` - '".$RecycledGoods["metal"]."', ";
				$QryUpdateGalaxy .= "`crystal` = `crystal` - '".$RecycledGoods["crystal"]."' ";
				$QryUpdateGalaxy .= "WHERE ";
				$QryUpdateGalaxy .= "`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND ";
				$QryUpdateGalaxy .= "`system` = '".$FleetRow['fleet_end_system']."' AND ";
				$QryUpdateGalaxy .= "`planet` = '".$FleetRow['fleet_end_planet']."' ";
				$QryUpdateGalaxy .= "LIMIT 1;";
				doquery( $QryUpdateGalaxy, 'galaxy');

				$Message = sprintf($lang['sys_recy_gotten'], pretty_number($RecycledGoods["metal"]), $lang['Metal'], pretty_number($RecycledGoods["crystal"]), $lang['Crystal']);
				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 4, $lang['sys_mess_spy_control'], $lang['sys_recy_report'], $Message);

				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_resource_metal` = `fleet_resource_metal` + '".$RecycledGoods["metal"]."', ";
				$QryUpdateFleet .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '".$RecycledGoods["crystal"]."', ";
				$QryUpdateFleet .= "`fleet_mess` = '1' ";
				$QryUpdateFleet .= "WHERE ";
				$QryUpdateFleet .= "`fleet_id` = '".intval($FleetRow['fleet_id'])."' ";
				$QryUpdateFleet .= "LIMIT 1;";
				doquery( $QryUpdateFleet, 'fleets');
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] <= time())
			{
				$Message         = sprintf( $lang['sys_tran_mess_owner'],
				$TargetName, GetTargetAdressLink($FleetRow, ''),
				pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],
				pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'],
				pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'] );
				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 4, $lang['sys_mess_spy_control'], $lang['sys_mess_fleetback'], $Message);
				$this->RestoreFleetToPlanet ( $FleetRow, true );
				doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
			}
		}
	}

private function MissionCaseColonisation($FleetRow)
{
global $lang, $resource;
$iMaxColo = mysql_result(doquery("SELECT `colonisation_tech` + 1 FROM `{{table}}` WHERE `id`='". $FleetRow['fleet_owner']."'",'users'), 0); 
$iPlanetCount = mysql_result(doquery ("SELECT count(*) FROM {{table}} WHERE `id_owner` = '". $FleetRow['fleet_owner'] ."' AND `planet_type` = '1' AND `destruyed` = '0'", 'planets'), 0);

if ($FleetRow['fleet_mess'] == 0)
{
$iGalaxyPlace = mysql_result(doquery ("SELECT count(*) FROM {{table}} WHERE `galaxy` = '". $FleetRow['fleet_end_galaxy']."' AND `system` = '". $FleetRow['fleet_end_system']."' AND `planet` = '". $FleetRow['fleet_end_planet']."' AND `planet_type` = '". $FleetRow['fleet_end_type']."';", 'planets'), 0);
$TargetAdress = sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
if ($iGalaxyPlace == 0)
{
if ($iPlanetCount >= $iMaxColo || $iPlanetCount >= MAX_PLAYER_PLANETS) {
$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_maxcolo'];
SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 6, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
doquery("UPDATE `{{table}}` SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
}
else
{
$NewOwnerPlanet = CreateOnePlanetRecord($FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $FleetRow['fleet_owner'], $lang['sys_colo_defaultname'], false);
if ( $NewOwnerPlanet == true )
{
$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_allisok'];
$TheMessage = sprintf( $lang['sys_colo_arrival'] . $TargetAdress .$lang['sys_colo_tran']. $lang['sys_colo_allisok'],
$lang['Metal'], $FleetRow['fleet_resource_metal'], 
$lang['Crystal'], $FleetRow['fleet_resource_crystal'], 
$lang['Deuterium'], $FleetRow['fleet_resource_deuterium'] );
SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 6, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
if ($FleetRow['fleet_amount'] == 1) {
$this->StoreGoodsToPlanet ($FleetRow, false);
doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
} else {
$this->StoreGoodsToPlanet ($FleetRow, false);
$CurrentFleet = explode(";", $FleetRow['fleet_array']);
$NewFleet = "";
foreach ($CurrentFleet as $Item => $Group)
{
if ($Group != '')
{
$Class = explode (",", $Group);
if ($Class[0] == 208)
{
if ($Class[1] > 1)
{
$NewFleet .= $Class[0].",".($Class[1] - 1).";";
}
}
else
{
if ($Class[1] <> 0)
{
$NewFleet .= $Class[0].",".$Class[1].";";
}
}
}
}
$QryUpdateFleet = "UPDATE {{table}} SET ";
$QryUpdateFleet .= "`fleet_array` = '". $NewFleet ."', ";
$QryUpdateFleet .= "`fleet_amount` = `fleet_amount` - 1, ";
$QryUpdateFleet .= "`fleet_resource_metal` = 0, ";
$QryUpdateFleet .= "`fleet_resource_crystal` = 0, ";
$QryUpdateFleet .= "`fleet_resource_deuterium` = 0, ";
$QryUpdateFleet .= "`fleet_mess` = '1' ";
$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';";
doquery( $QryUpdateFleet, 'fleets');
}
}
else
{
$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_badpos'];
SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 6, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
}
}
}
else
{
$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_notfree'];
SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 6, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
}
}
elseif ($FleetRow['fleet_end_time'] < time())
{

$this->RestoreFleetToPlanet ( $FleetRow, true );
doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
}
}

	private function MissionCaseDestruction($FleetRow)
	{
		global $user, $phpEx, $pricelist, $lang, $resource, $CombatCaps;

		if ($FleetRow['fleet_start_time'] <= time())
		{
			if ($FleetRow['fleet_mess'] == 0)
			{
				if (!isset($CombatCaps[202]['sd']))
					header("location:game." . $phpEx . "?page=fleet");

				$QryTargetPlanet  = "SELECT * FROM {{table}} ";
				$QryTargetPlanet .= "WHERE ";
				$QryTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
				$QryTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
				$QryTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
				$QryTargetPlanet .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
				$TargetPlanet     = doquery( $QryTargetPlanet, 'planets', true);
				$TargetUserID     = $TargetPlanet['id_owner'];

				$QryDepPlanet  = "SELECT * FROM {{table}} ";
				$QryDepPlanet .= "WHERE ";
				$QryDepPlanet .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
				$QryDepPlanet .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
				$QryDepPlanet .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
				$QryDepPlanet .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."';";
				$DepPlanet     = doquery( $QryDepPlanet, 'planets', true);
				$DepName       = $DepPlanet['name'];

				$QryCurrentUser   = "SELECT * FROM {{table}} ";
				$QryCurrentUser  .= "WHERE ";
				$QryCurrentUser  .= "`id` = '". $FleetRow['fleet_owner'] ."';";
				$CurrentUser      = doquery($QryCurrentUser , 'users', true);
				$CurrentUserID    = $CurrentUser['id'];

				$QryTargetUser    = "SELECT * FROM {{table}} ";
				$QryTargetUser   .= "WHERE ";
				$QryTargetUser   .= "`id` = '". $TargetUserID ."';";
				$TargetUser       = doquery($QryTargetUser, 'users', true);

				for ($SetItem = 200; $SetItem < 500; $SetItem++)
				{
					if ($TargetPlanet[$resource[$SetItem]] > 0)
						$TargetSet[$SetItem]['count'] = $TargetPlanet[$resource[$SetItem]];
				}

				$TheFleet = explode(";", $FleetRow['fleet_array']);

				foreach($TheFleet as $a => $b)
				{
					if ($b != '')
					{
						$a = explode(",", $b);
						$CurrentSet[$a[0]]['count'] = $a[1];
					}
				}


				$walka        = $this->walka($CurrentSet, $TargetSet, $CurrentUser, $TargetUser);
				$CurrentSet   = $walka["atakujacy"];
				$TargetSet    = $walka["wrog"];
				$FleetResult  = $walka["wygrana"];
				$dane_do_rw   = $walka["dane_do_rw"];
				$zlom         = $walka["zlom"];
				$FleetArray   = "";
				$FleetAmount  = 0;
				$FleetStorage = 0;

				foreach ($CurrentSet as $Ship => $Count)
				{

					$FleetStorage += $pricelist[$Ship]["capacity"] * $Count['count'];
					$FleetArray   .= $Ship.",".$Count['count'].";";
					$FleetAmount  += $Count['count'];
				}

				$TargetPlanetUpd = "";

				if (!is_null($TargetSet))
				{
					foreach($TargetSet as $Ship => $Count)
					{
						$TargetPlanetUpd .= "`". $resource[$Ship] ."` = '". $Count['count'] ."', ";
					}
				}

				if ($FleetResult == "a")
				{
					$destructionl1 	= 100-sqrt($TargetPlanet['diameter']);
					$destructionl21 = $destructionl1*sqrt($CurrentSet['214']['count']);
					$destructionl2 	= $destructionl21/1;

					if ($destructionl2 > 100)
						$chance = '100';
					else
						$chance = round($destructionl2);

					$tirage 	= mt_rand(0, 100);
					$probalune	= sprintf ($lang['sys_destruc_lune'], $chance);

					if($tirage <= $chance)
					{
						$resultat 	= '1';
						$finmess 	= $lang['sys_destruc_reussi'];

						doquery("DELETE FROM {{table}} WHERE `id` = '". $TargetPlanet['id'] ."';", 'planets');

						$Qrydestructionlune  = "UPDATE {{table}} SET ";
						$Qrydestructionlune .= "`id_luna` = '0' ";
						$Qrydestructionlune .= "WHERE ";
						$Qrydestructionlune .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
						$Qrydestructionlune .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
						$Qrydestructionlune .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' ";
						$Qrydestructionlune .= "LIMIT 1 ;";
						doquery( $Qrydestructionlune , 'galaxy');

						$QryDetFleets1  = "UPDATE {{table}} SET ";
						$QryDetFleets1 .= "`fleet_start_type` = '1' ";
						$QryDetFleets1 .= "WHERE ";
						$QryDetFleets1 .= "`fleet_start_galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
						$QryDetFleets1 .= "`fleet_start_system` = '". $FleetRow['fleet_end_system'] ."' AND ";
						$QryDetFleets1 .= "`fleet_start_planet` = '". $FleetRow['fleet_end_planet'] ."' ";
						$QryDetFleets1 .= ";";
						doquery( $QryDetFleets1 , 'fleets');

						$QryDetFleets2  = "UPDATE {{table}} SET ";
						$QryDetFleets2 .= "`fleet_end_type` = '1' ";
						$QryDetFleets2 .= "WHERE ";
						$QryDetFleets2 .= "`fleet_end_galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
						$QryDetFleets2 .= "`fleet_end_system` = '". $FleetRow['fleet_end_system'] ."' AND ";
						$QryDetFleets2 .= "`fleet_end_planet` = '". $FleetRow['fleet_end_planet'] ."' ";
						$QryDetFleets2 .= ";";
						doquery( $QryDetFleets2 , 'fleets');

						if ($TargetUser['current_planet'] == $TargetPlanet['id'])
						{
							$QryPlanet  = "SELECT * FROM {{table}} ";
							$QryPlanet .= "WHERE ";
							$QryPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
							$QryPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
							$QryPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
							$QryPlanet .= "`planet_type` = '1';";
							$Planet     = doquery( $QryPlanet, 'planets', true);
							$IDPlanet     = $Planet['id'];

							$Qryvue  = "UPDATE {{table}} SET ";
							$Qryvue .= "`current_planet` = '". $IDPlanet ."' ";
							$Qryvue .= "WHERE ";
							$Qryvue .= "`id` = '". $TargetUserID ."' ";
							$Qryvue .= ";";
							doquery( $Qryvue , 'users');
						}
					}
					else
						$resultat = '0';

					$destructionrip = sqrt($TargetPlanet['diameter'])/2;
					$chance2		= round($destructionrip);

					if ($resultat == 0)
					{
						$tirage2 	= mt_rand(0, 100);
						$probarip	= sprintf ($lang['sys_destruc_rip'], $chance2);
						if($tirage2 <= $chance2)
						{
							$resultat2 = ' detruite 1';
							$finmess = $lang['sys_destruc_echec'];
							doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
						}
						else
						{
							$resultat2 = 'sauvees 0';
							$finmess = $lang['sys_destruc_null'];
						}
					}
				}

				$introdestruc       = sprintf ($lang['sys_destruc_mess'], $DepName , $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);

				$QryUpdateTarget  = "UPDATE {{table}} SET ";
				$QryUpdateTarget .= $TargetPlanetUpd;
				$QryUpdateTarget .= "`metal` = `metal` - '". $Mining['metal'] ."', ";
				$QryUpdateTarget .= "`crystal` = `crystal` - '". $Mining['crystal'] ."', ";
				$QryUpdateTarget .= "`deuterium` = `deuterium` - '". $Mining['deuter'] ."' ";
				$QryUpdateTarget .= "WHERE ";
				$QryUpdateTarget .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
				$QryUpdateTarget .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
				$QryUpdateTarget .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
				$QryUpdateTarget .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
				$QryUpdateTarget .= "LIMIT 1;";
				doquery( $QryUpdateTarget , 'planets');

				$QryUpdateGalaxy  = "UPDATE {{table}} SET ";
				$QryUpdateGalaxy .= "`metal` = `metal` + '". $zlom['metal'] ."', ";
				$QryUpdateGalaxy .= "`crystal` = `crystal` + '". $zlom['crystal'] ."' ";
				$QryUpdateGalaxy .= "WHERE ";
				$QryUpdateGalaxy .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
				$QryUpdateGalaxy .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
				$QryUpdateGalaxy .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' ";
				$QryUpdateGalaxy .= "LIMIT 1;";
				doquery( $QryUpdateGalaxy , 'galaxy');

				$FleetDebris      = $zlom['metal'] + $zlom['crystal'];
				$StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], $zlom["atakujacy"]);
				$StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], $zlom["wrog"]);
				$StrRuins         = sprintf ($lang['sys_gcdrunits'], $zlom["metal"], $lang['Metal'], $zlom['crystal'], $lang['Crystal']);
				$DebrisField      = $StrAttackerUnits ."<br />". $StrDefenderUnits ."<br />". $StrRuins;
				$MoonChance       = $FleetDebris / 100000;

				if ($FleetDebris > 2000000)
				{
					$MoonChance = 20;
					$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
				}
				elseif ($FleetDebris < 100000)
				{
					$UserChance = 0;
					$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
				}
				elseif ($FleetDebris >= 100000)
				{
					$UserChance = mt_rand(1, 100);
					$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
				}

				if (($UserChance > 0) and ($UserChance <= $MoonChance) and $galenemyrow['id_luna'] == 0)
				{
					$TargetPlanetName = CreateOneMoonRecord ( $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $TargetUserID, $FleetRow['fleet_start_time'], '', $MoonChance );
					$GottenMoon       = sprintf ($lang['sys_moonbuilt'], $TargetPlanetName, $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
				}
				elseif ($UserChance = 0 or $UserChance > $MoonChance)
					$GottenMoon = "";

				$AttackDate        = date("r", $FleetRow["fleet_start_time"]);
				$title             = sprintf ($lang['sys_destruc_title'], $AttackDate);
				$raport            = "<center><table><tr><td>". $title ."<br />";
				$zniszczony        = false;
				$a_zestrzelona     = 0;
				$AttackTechon['A'] = $CurrentUser["military_tech"] * 10;
				$AttackTechon['B'] = $CurrentUser["defence_tech"] * 10;
				$AttackTechon['C'] = $CurrentUser["shield_tech"] * 10;
				$AttackerData      = sprintf ($lang['sys_attack_attacker_pos'], $CurrentUser["username"], $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'] );
				$AttackerTech      = sprintf ($lang['sys_attack_techologies'], $AttackTechon['A'], $AttackTechon['B'], $AttackTechon['C']);
				$DefendTechon['A'] = $TargetUser["military_tech"] * 10;
				$DefendTechon['B'] = $TargetUser["defence_tech"] * 10;
				$DefendTechon['C'] = $TargetUser["shield_tech"] * 10;
				$DefenderData      = sprintf ($lang['sys_attack_defender_pos'], $TargetUser["username"], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'] );
				$DefenderTech      = sprintf ($lang['sys_attack_techologies'], $DefendTechon['A'], $DefendTechon['B'], $DefendTechon['C']);

				foreach ($dane_do_rw as $a => $b)
				{
					$raport .= "<table border=1 width=100%><tr><th><br /><center>".$AttackerData."<br />".$AttackerTech."<table border=1>";

					if ($b["atakujacy"]['count'] > 0)
					{
						$raport1 = "<tr><th>".$lang['sys_ship_type']."</th>";
						$raport2 = "<tr><th>".$lang['sys_ship_count']."</th>";
						$raport3 = "<tr><th>".$lang['sys_ship_weapon']."</th>";
						$raport4 = "<tr><th>".$lang['sys_ship_shield']."</th>";
						$raport5 = "<tr><th>".$lang['sys_ship_armour']."</th>";

						foreach ($b["atakujacy"] as $Ship => $Data)
						{
							if (is_numeric($Ship))
							{
								if ($Data['count'] > 0)
								{
									$raport1 .= "<th>". $lang["tech_rc"][$Ship] ."</th>";
									$raport2 .= "<th>". $Data['count'] ."</th>";
									$raport3 .= "<th>". round($Data["atak"]   / $Data['count']) ."</th>";
									$raport4 .= "<th>". round($Data["tarcza"] / $Data['count']) ."</th>";
									$raport5 .= "<th>". round($Data["obrona"] / $Data['count']) ."</th>";
								}
							}
						}

						$raport1 .= "</tr>";
						$raport2 .= "</tr>";
						$raport3 .= "</tr>";
						$raport4 .= "</tr>";
						$raport5 .= "</tr>";
						$raport  .= $raport1 . $raport2 . $raport3 . $raport4 . $raport5;

					}
					else
					{
						if ($a == 2)
							$a_zestrzelona = 1;

						$zniszczony = true;
						$raport .= "<br />". $lang['sys_destroyed'];
					}

					$raport .= "</table></center></th></tr></table>";
					$raport .= "<table border=1 width=100%><tr><th><br /><center>".$DefenderData."<br />".$DefenderTech."<table border=1>";

					if ($b["wrog"]['count'] > 0)
					{
						$raport1 = "<tr><th>".$lang['sys_ship_type']."</th>";
						$raport2 = "<tr><th>".$lang['sys_ship_count']."</th>";
						$raport3 = "<tr><th>".$lang['sys_ship_weapon']."</th>";
						$raport4 = "<tr><th>".$lang['sys_ship_shield']."</th>";
						$raport5 = "<tr><th>".$lang['sys_ship_armour']."</th>";

						foreach ($b["wrog"] as $Ship => $Data)
						{
							if (is_numeric($Ship))
							{
								if ($Data['count'] > 0)
								{
									$raport1 .= "<th>". $lang["tech_rc"][$Ship] ."</th>";
									$raport2 .= "<th>". $Data['count'] ."</th>";
									$raport3 .= "<th>". round($Data["atak"]   / $Data['count']) ."</th>";
									$raport4 .= "<th>". round($Data["tarcza"] / $Data['count']) ."</th>";
									$raport5 .= "<th>". round($Data["obrona"] / $Data['count']) ."</th>";
								}
							}
						}

						$raport1 .= "</tr>";
						$raport2 .= "</tr>";
						$raport3 .= "</tr>";
						$raport4 .= "</tr>";
						$raport5 .= "</tr>";
						$raport  .= $raport1 . $raport2 . $raport3 . $raport4 . $raport5;

					}
					else
					{
						$zniszczony = true;
						$raport .= "<br />". $lang['sys_destroyed'];
					}

					$raport .= "</table></center></th></tr></table>";



					if (($zniszczony == false) and !($a == 8))
					{
						$AttackWaveStat    = sprintf ($lang['sys_attack_attack_wave'], floor($b["atakujacy"]["atak"]), floor($b["wrog"]["tarcza"]));
						$DefendWavaStat    = sprintf ($lang['sys_attack_defend_wave'], floor($b["wrog"]["atak"]), floor($b["atakujacy"]["tarcza"]));
						$raport           .= "<br /><center>".$AttackWaveStat."<br />".$DefendWavaStat."</center>";
					}
				}

				switch ($FleetResult)
				{
					case "a":
						$raport           .= $lang['sys_attacker_won'] ."<br />";
						$raport           .= $DebrisField ."<br />";
						$raport           .= $introdestruc ."<br />";
						$raport           .= $lang['sys_destruc_mess1'];
						$raport           .= $finmess ."<br />";
						$raport           .= $probalune ."<br />";
						$raport           .= $probarip ."<br />";
						break;

					case "r":
						$raport           .= $lang['sys_both_won'] ."<br />";
						$raport           .= $DebrisField ."<br />";
						$raport           .= $introdestruc ."<br />";
						$raport           .= $lang['sys_destruc_stop'] ."<br />";
						break;

					case "w":
						$raport           .= $lang['sys_defender_won'] ."<br />";
						$raport           .= $DebrisField ."<br />";
						$raport           .= $introdestruc ."<br />";
						$raport           .= $lang['sys_destruc_stop'] ."<br />";
						doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
						break;
				}

				$raport           .= "</table>";
				$rid   			   = md5($raport);

				$QryInsertRapport  = "INSERT INTO {{table}} SET ";
				$QryInsertRapport .= "`time` = UNIX_TIMESTAMP(), ";
				$QryInsertRapport .= "`id_owner1` = '". $FleetRow['fleet_owner'] ."', ";
				$QryInsertRapport .= "`id_owner2` = '". $TargetUserID ."', ";
				$QryInsertRapport .= "`rid` = '". $rid ."', ";
				$QryInsertRapport .= "`a_zestrzelona` = '". $a_zestrzelona ."', ";
				$QryInsertRapport .= "`raport` = '". addslashes ( $raport ) ."';";
				doquery( $QryInsertRapport , 'rw');

				$raport  = "<a href # OnClick=\"f( 'CombatReport.php?raport=". $rid ."', '');\" >";
				$raport .= "<center>";

				if($FleetResult == "a")
					$raport .= "<font color=\"green\">";
				elseif ($FleetResult == "r")
					$raport .= "<font color=\"orange\">";
				elseif ($FleetResult == "w")
					$raport .= "<font color=\"red\">";

				$raport .= $lang['sys_mess_destruc_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."] </font></a><br /><br />";
				$raport .= "<font color=\"red\">". $lang['sys_perte_attaquant'] .": ". $zlom["atakujacy"] ."</font>";
				$raport .= "<font color=\"green\">   ". $lang['sys_perte_defenseur'] .":". $zlom["wrog"] ."</font><br />" ;
				$raport .= $lang['sys_debris'] ." ". $lang['Metal'] .":<font color=\"#adaead\">". $zlom['metal'] ."</font>   ". $lang['Crystal'] .":<font color=\"#ef51ef\">". $zlom['crystal'] ."</font><br /></center>";

				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_amount` = '". $FleetAmount ."', ";
				$QryUpdateFleet .= "`fleet_array` = '". $FleetArray ."', ";
				$QryUpdateFleet .= "`fleet_mess` = '1' ";
				$QryUpdateFleet .= "WHERE fleet_id = '". intval($FleetRow['fleet_id']) ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				doquery( $QryUpdateFleet , 'fleets');

				SendSimpleMessage ( $CurrentUserID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_destruc_report'], $raport );

				$raport2  = "<a href # OnClick=\"f( 'CombatReport.php?raport=". $rid ."', '');\" >";
				$raport2 .= "<center>";

				if($FleetResult == "a")
					$raport2 .= "<font color=\"red\">";
				elseif ($FleetResult == "r")
					$raport2 .= "<font color=\"orange\">";
				elseif ($FleetResult == "w")
					$raport2 .= "<font color=\"green\">";

				$raport2 .= $lang['sys_mess_destruc_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."] </font></a><br /><br />";

				SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_destruc_report'], $raport2 );
			}

			$fquery = "";

			if ($FleetRow['fleet_end_time'] <= time())
			{
				if (!is_null($CurrentSet))
				{
					foreach($CurrentSet as $Ship => $Count)
					{
						$fquery .= "`". $resource[$Ship] ."` = `". $resource[$Ship] ."` + '". $Count['count'] ."', ";
					}
				}
				else
				{
					$fleet = explode(";", $FleetRow['fleet_array']);
					foreach($fleet as $a => $b)
					{
						if ($b != '')
						{
							$a = explode(",", $b);
							$fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";
						}
					}
				}

				doquery ("DELETE FROM {{table}} WHERE `fleet_id` = " . $FleetRow["fleet_id"], 'fleets');

				if (!($FleetResult == "w"))
				{
					$QryUpdatePlanet  = "UPDATE {{table}} SET ";
					$QryUpdatePlanet .= $fquery;
					$QryUpdatePlanet .= "`metal` = `metal` + ". $FleetRow['fleet_resource_metal'] .", ";
					$QryUpdatePlanet .= "`crystal` = `crystal` + ". $FleetRow['fleet_resource_crystal'] .", ";
					$QryUpdatePlanet .= "`deuterium` = `deuterium` + ". $FleetRow['fleet_resource_deuterium'] ." ";
					$QryUpdatePlanet .= "WHERE ";
					$QryUpdatePlanet .= "`galaxy` = ".$FleetRow['fleet_start_galaxy']." AND ";
					$QryUpdatePlanet .= "`system` = ".$FleetRow['fleet_start_system']." AND ";
					$QryUpdatePlanet .= "`planet` = ".$FleetRow['fleet_start_planet']." AND ";
					$QryUpdatePlanet .= "`planet_type` = ".$FleetRow['fleet_start_type']." LIMIT 1 ;";
					doquery( $QryUpdatePlanet, 'planets' );
				}
			}
		}
	}

	private function MissionCaseMIP ($FleetRow)
	{
		global $user, $phpEx, $pricelist, $lang, $resource, $CombatCaps;

		if ($FleetRow['fleet_start_time'] <= time())
		{
			if ($FleetRow['fleet_mess'] == 0)
			{
				if (!isset($CombatCaps[202]['sd']))
					header("location:game." . $phpEx . "?page=fleet");

				$QryTargetPlanet = "SELECT * FROM {{table}} ";
				$QryTargetPlanet .= "WHERE ";
				$QryTargetPlanet .= "`galaxy` = '" . $FleetRow['fleet_end_galaxy'] . "' AND ";
				$QryTargetPlanet .= "`system` = '" . $FleetRow['fleet_end_system'] . "' AND ";
				$QryTargetPlanet .= "`planet` = '" . $FleetRow['fleet_end_planet'] . "' AND ";
				$QryTargetPlanet .= "`planet_type` = '" . $FleetRow['fleet_end_type'] . "';";
				$planet = doquery($QryTargetPlanet, 'planets', true);

				$QrySelect  = "SELECT defence_tech,military_tech FROM {{table}} ";
				$QrySelect .= "WHERE ";
				$QrySelect .= "`id` = '".$FleetRow['fleet_owner']."';";
				$UserFleet = doquery( $QrySelect, 'users',true);

				$verteidiger = $UserFleet["defence_tech"];
				$angreifer 	 = $UserFleet["military_tech"];

				$ids = array(
				0 => 401,
				1 => 402,
				2 => 403,
				3 => 404,
				4 => 405,
				5 => 406,
				6 => 407,
				7 => 408,
				8 => 502,
				9 => 503,
				10 => 409);

				$def =   array(
				0 => $planet['misil_launcher'],
				1 => $planet['small_laser'],
				2 => $planet['big_laser'],
				3 => $planet['gauss_canyon'],
				4 => $planet['ionic_canyon'],
				5 => $planet['buster_canyon'],
				6 => $planet['small_protection_shield'],
				7 => $planet['big_protection_shield'],
				8 => $planet['interceptor_misil'],
				9 => $planet['interplanetary_misil'],
				10 => $planet['planet_protector']);

				$DefenseLabel =   array(0 => $lang['tech'][401],
				1 => $lang['tech'][402],
				2 => $lang['tech'][403],
				3 => $lang['tech'][404],
				4 => $lang['tech'][405],
				5 => $lang['tech'][406],
				6 => $lang['tech'][407],
				7 => $lang['tech'][408],
				8 => $lang['tech'][502],
				9 => $lang['tech'][503],
				10 => $lang['tech'][409]);

				$message = '';

				if ($planet['interceptor_misil'] >= $FleetRow['fleet_amount'])
				{
					$message = 'Tus misiles de intersepci&oacute;n destruyeron los misiles interplanetarios<br>';
					$x = $resource[$ids[8]];
					doquery("UPDATE {{table}} SET " . $x . " = " . $x . "-" . $FleetRow['fleet_amount'] . " WHERE id = " . $planet['id'], 'planets');
				}
				else
				{
					if ($planet['interceptor_misil'] > 0)
					{
						$x = $resource[$ids[8]];
						doquery("UPDATE {{table}} SET " . $x . " = '0'  WHERE id = " . $planet['id'], 'planets');
						$message = $planet['interceptor_misil'] . "interplanetario misiles fueron destruidos por misiles interceptores.<br>";
						$irak = $this->raketenangriff($verteidiger, $angreifer, $FleetRow['fleet_amount']-$planet['interceptor_misil'], $def, $FleetRow['fleet_target_obj']);
					}

					$irak = $this->raketenangriff($verteidiger, $angreifer, $FleetRow['fleet_amount'], $def, $FleetRow['fleet_target_obj']);

					foreach ($irak['zerstoert'] as $id => $anzahl)
					{
						if ($id < 10)
						{
							if ($id != 8)
								$message .= $DefenseLabel[$id] . " (- " . $anzahl . ")<br>";

							$x = $resource[$ids[$id]];
							$x1 = $x ."-". $anzahl;
							doquery("UPDATE {{table}} SET " . $x . " = " . $x1 . " WHERE id = " . $planet['id'], 'planets');
						}
					}
				}
				$UserPlanet 		= doquery("SELECT name FROM {{table}} WHERE id = '" . $FleetRow['fleet_owner'] . "'", 'planets',true);
				$name 				= $UserPlanet['name'];
				$name_deffer 		= $QryTargetPlanet['name'];
				$message_vorlage  	= 'Un ataque con misiles (' .$FleetRow['fleet_amount']. ') de ' .$name. ' ';
				$message_vorlage   .= 'al planeta ' .$name_deffer.'<br><br>';

				if (empty($message))
					$message = "Tu planeta no tenia defensa!";

				doquery("INSERT INTO {{table}} SET
				`message_owner`='" . $FleetRow['fleet_target_owner'] . "',
				`message_sender`='".$UserPlanet['id']."',
				`message_time`=UNIX_TIMESTAMP(),
				`message_type`='3',
				`message_from`='Torre de Control',
				`message_subject`='Ataque con misiles',
				`message_text`='" . $message_vorlage . $message . "'" , 'messages');
				doquery("INSERT INTO {{table}} SET
				`message_owner`='" . $UserPlanet['id'] . "',
				`message_sender`='".$FleetRow['fleet_target_owner']."',
				`message_time`=UNIX_TIMESTAMP(),
				`message_type`='3',
				`message_from`='Torre de Control',
				`message_subject`='Ataque con misiles',
				`message_text`='" . $message_vorlage . $message . "'" , 'messages');

				doquery("DELETE FROM {{table}} WHERE fleet_id = '" . intval($FleetRow['fleet_id']) . "'", 'fleets');
			}
		}
		$FleetRow['fleet_start_time'] <= time();
	}

	private function MissionCaseExpedition($FleetRow)
	{
		global $lang, $resource, $pricelist;

		$FleetOwner = $FleetRow['fleet_owner'];
		$MessSender = $lang['sys_mess_qg'];
		$MessTitle  = $lang['sys_expe_report'];

		if ($FleetRow['fleet_mess'] == 0)
		{
			if ($FleetRow['fleet_end_stay'] < time())
			{
				$PointsFlotte = array(
				202 => 1.0,
				203 => 1.5,
				204 => 0.5,
				205 => 1.5,
				206 => 2.0,
				207 => 2.5,
				208 => 0.5,
				209 => 1.0,
				210 => 0.01,
				211 => 3.0,
				212 => 0.0,
				213 => 3.5,
				214 => 5.0,
				215 => 3.2,
				216 => 3.5,
				);

				$RatioGain = array (
				202 => 0.1,
				203 => 0.1,
				204 => 0.1,
				205 => 0.5,
				206 => 0.25,
				207 => 0.125,
				208 => 0.5,
				209 => 0.1,
				210 => 0.1,
				211 => 0.0625,
				212 => 0.0,
				213 => 0.0625,
				214 => 0.03125,
				215 => 0.0625,
				216 => 0.03125,
				);

				$FleetStayDuration 	= ($FleetRow['fleet_end_stay'] - $FleetRow['fleet_start_time']) / 3600;
				$farray 			= explode(";", $FleetRow['fleet_array']);

				foreach ($farray as $Item => $Group)
				{
					if ($Group != '')
					{
						$Class 						= explode (",", $Group);
						$TypeVaisseau 				= $Class[0];
						$NbreVaisseau 				= $Class[1];
						$LaFlotte[$TypeVaisseau]	= $NbreVaisseau;
						$FleetCapacity 			   += $pricelist[$TypeVaisseau]['capacity'];
						$FleetPoints   			   += ($NbreVaisseau * $PointsFlotte[$TypeVaisseau]);
					}
				}

				$FleetUsedCapacity  = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'] + $FleetRow['fleet_resource_darkmatter'];
				$FleetCapacity     -= $FleetUsedCapacity;
				$FleetCount 		= $FleetRow['fleet_amount'];
				$Hasard 			= rand(0, 10);
				$MessSender 		= $lang['sys_mess_qg']. "(".$Hasard.")";

				if ($Hasard < 3)
				{
					$Hasard     += 1;
					$LostAmount  = (($Hasard * 33) + 1) / 100;

					if ($LostAmount == 100)
					{
						SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_blackholl_2'] );
						doquery ("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
					}
					else
					{
						foreach ($LaFlotte as $Ship => $Count)
						{
							$LostShips[$Ship] = intval($Count * $LostAmount);
							$NewFleetArray   .= $Ship.",". ($Count - $LostShips[$Ship]) .";";
						}
						$QryUpdateFleet  = "UPDATE {{table}} SET ";
						$QryUpdateFleet .= "`fleet_array` = '". $NewFleetArray ."', ";
						$QryUpdateFleet .= "`fleet_mess` = '1'  ";
						$QryUpdateFleet .= "WHERE ";
						$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
						doquery( $QryUpdateFleet, 'fleets');
						SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_blackholl_1'] );
					}
				}
				elseif ($Hasard == 3)
				{
					doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
					SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_1'] );
				}
				elseif ($Hasard >= 4 && $Hasard < 7)
				{
					if ($FleetCapacity > 5000)
					{
						$MinCapacity = $FleetCapacity - 5000;
						$MaxCapacity = $FleetCapacity;
						$FoundGoods  = rand($MinCapacity, $MaxCapacity);
						$FoundMetal  = intval($FoundGoods / 2);
						$FoundCrist  = intval($FoundGoods / 4);
						$FoundDeute  = intval($FoundGoods / 6);
						$FoundDark   = intval($FoundGoods / 20);

						$QryUpdateFleet  = "UPDATE {{table}} SET ";
						$QryUpdateFleet .= "`fleet_resource_metal` = `fleet_resource_metal` + '". $FoundMetal ."', ";
						$QryUpdateFleet .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '". $FoundCrist."', ";
						$QryUpdateFleet .= "`fleet_resource_deuterium` = `fleet_resource_deuterium` + '". $FoundDeute ."', ";
						$QryUpdateFleet .= "`fleet_resource_darkmatter` = `fleet_resource_darkmatter` + '". $FoundDark ."', ";
						$QryUpdateFleet .= "`fleet_mess` = '1'  ";
						$QryUpdateFleet .= "WHERE ";
						$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
						doquery( $QryUpdateFleet, 'fleets');

						$Message = sprintf($lang['sys_expe_found_goods'],
						pretty_number($FoundMetal), $lang['Metal'],
						pretty_number($FoundCrist), $lang['Crystal'],
						pretty_number($FoundDeute), $lang['Deuterium'],
						pretty_number($FoundDark), $lang['Darkmatter']);

						SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message );
					}
				}
				elseif ($Hasard == 7)
				{
					doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
					SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_2'] );
				}
				elseif ($Hasard >= 8 && $Hasard < 11)
				{
					$FoundChance = $FleetPoints / $FleetCount;
					for ($Ship = 202; $Ship < 216; $Ship++)
					{
						if ($LaFlotte[$Ship] != 0)
						{
							$FoundShip[$Ship] = round($LaFlotte[$Ship] * $RatioGain[$Ship]) + 1;
							if ($FoundShip[$Ship] > 0)
								$LaFlotte[$Ship] += $FoundShip[$Ship];
						}
					}
					$NewFleetArray = "";
					$FoundShipMess = "";

					foreach ($LaFlotte as $Ship => $Count)
					{
						if ($Count > 0)
							$NewFleetArray   .= $Ship.",". $Count .";";
					}

					if ( $FoundShip != null )
					{
						foreach ($FoundShip as $Ship => $Count)
						{
							if ($Count != 0)
								$FoundShipMess   .= $Count." ".$lang['tech'][$Ship].",";
						}
					}

					$QryUpdateFleet  = "UPDATE {{table}} SET ";
					$QryUpdateFleet .= "`fleet_array` = '". $NewFleetArray ."', ";
					$QryUpdateFleet .= "`fleet_mess` = '1'  ";
					$QryUpdateFleet .= "WHERE ";
					$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
					doquery( $QryUpdateFleet, 'fleets');

					$Message = $lang['sys_expe_found_ships']. $FoundShipMess . "";
					SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message);
				}
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] < time())
			{
				$farray = explode(";", $FleetRow['fleet_array']);
				foreach ($farray as $Item => $Group)
				{
					if ($Group != '')
					{
						$Class = explode (",", $Group);
						$FleetAutoQuery .= "`". $resource[$Class[0]]. "` = `". $resource[$Class[0]] ."` + ". $Class[1] .", ";
					}
				}
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= $FleetAutoQuery;
				$QryUpdatePlanet .= "`metal` = `metal` + ". $FleetRow['fleet_resource_metal'] .", ";
				$QryUpdatePlanet .= "`crystal` = `crystal` + ". $FleetRow['fleet_resource_crystal'] .", ";
				$QryUpdatePlanet .= "`deuterium` = `deuterium` + ". $FleetRow['fleet_resource_deuterium'] ." ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
				$QryUpdatePlanet .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
				$QryUpdatePlanet .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
				$QryUpdatePlanet .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."' ";
				$QryUpdatePlanet .= "LIMIT 1 ;";
				doquery( $QryUpdatePlanet, 'planets');

				doquery("UPDATE `{{table}}` SET `darkmatter` = `darkmatter` + '".$FleetRow['fleet_resource_darkmatter']."' WHERE `id` =".$FleetRow['fleet_owner']." LIMIT 1 ;", 'users');
				doquery ("DELETE FROM {{table}} WHERE `fleet_id` = ". intval($FleetRow["fleet_id"]), 'fleets');

				SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_time'], 15, $MessSender, $MessTitle, $lang['sys_expe_back_home'] );
			}
		}
	}

	public function __construct (&$planet)
	{
		global $resource;

		doquery("LOCK TABLE {{table}}aks WRITE, {{table}}rw WRITE, {{table}}errors WRITE, {{table}}messages WRITE, {{table}}fleets WRITE,  {{table}}planets WRITE, {{table}}galaxy WRITE ,{{table}}users WRITE", "");

		$QryFleet   = "SELECT * FROM {{table}} ";
		$QryFleet  .= "WHERE (";
		$QryFleet  .= "( ";
		$QryFleet  .= "`fleet_start_galaxy` = ". $planet['galaxy']      ." AND ";
		$QryFleet  .= "`fleet_start_system` = ". $planet['system']      ." AND ";
		$QryFleet  .= "`fleet_start_planet` = ". $planet['planet']      ." AND ";
		$QryFleet  .= "`fleet_start_type` = ".   $planet['planet_type'] ." ";
		$QryFleet  .= ") OR ( ";
		$QryFleet  .= "`fleet_end_galaxy` = ".   $planet['galaxy']      ." AND ";
		$QryFleet  .= "`fleet_end_system` = ".   $planet['system']      ." AND ";
		$QryFleet  .= "`fleet_end_planet` = ".   $planet['planet']      ." ) AND ";
		$QryFleet  .= "`fleet_end_type`= ".      $planet['planet_type'] ." ) AND ";
		$QryFleet  .= "( `fleet_start_time` < '". time() ."' OR `fleet_end_time` < '". time() ."' );";
		$fleetquery = doquery( $QryFleet, 'fleets' );

		while ($CurrentFleet = mysql_fetch_array($fleetquery))
		{
			switch ($CurrentFleet["fleet_mission"])
			{
				case 1:
					$this->MissionCaseAttack($CurrentFleet);
					break;

				case 2:
					$this->MissionCaseACS($CurrentFleet);
					break;

				case 3:
					$this->MissionCaseTransport($CurrentFleet);
					break;

				case 4:
					$this->MissionCaseStay($CurrentFleet);
					break;

				case 5:
					$this->MissionCaseStayAlly($CurrentFleet);
					break;

				case 6:
					$this->MissionCaseSpy($CurrentFleet);
					break;

				case 7:
					$this->MissionCaseColonisation($CurrentFleet);
					break;

				case 8:
					$this->MissionCaseRecycling($CurrentFleet);
					break;

				case 9:
					$this->MissionCaseDestruction($CurrentFleet);
					break;

				case 10:
					$this->MissionCaseMIP($CurrentFleet);
					break;

				case 15:
					$this->MissionCaseExpedition($CurrentFleet);
					break;

				default:
					doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $CurrentFleet['fleet_id'] ."';", 'fleets');

			}
		}

		doquery("UNLOCK TABLES", "");

	}
}
?>