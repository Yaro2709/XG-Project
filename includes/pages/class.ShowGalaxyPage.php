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

include_once($xgp_root . 'includes/classes/class.GalaxyRows.' . $phpEx);

class ShowGalaxyPage extends GalaxyRows
{
	private function InsertGalaxyScripts ($CurrentPlanet)
	{
		$Script  = "<div style=\"top: 10px;\" id=\"content\">";
		$Script .= "<script language=\"JavaScript\">\n";
		$Script .= "function galaxy_submit(value) {\n";
		$Script .= "	document.getElementById('auto').name = value;\n";
		$Script .= "	document.getElementById('galaxy_form').submit();\n";
		$Script .= "}\n\n";
		$Script .= "function fenster(target_url,win_name) {\n";
		$Script .= "	var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=640,height=480,top=0,left=0');\n";
		$Script .= "	new_win.focus();\n";
		$Script .= "}\n";
		$Script .= "</script>\n";
		$Script .= "<script language=\"JavaScript\" src=\"scripts/tw-sack.js\"></script>\n";
		$Script .= "<script type=\"text/javascript\">\n\n";
		$Script .= "var ajax = new sack();\n";
		$Script .= "var strInfo = \"\";\n";
		$Script .= "function whenResponse () {\n";
		$Script .= "	retVals   = this.response.split(\"|\");\n";
		$Script .= "	Message   = retVals[0];\n";
		$Script .= "	Infos     = retVals[1];\n";
		$Script .= "	retVals   = Infos.split(\" \");\n";
		$Script .= "	UsedSlots = retVals[0];\n";
		$Script .= "	SpyProbes = retVals[1];\n";
		$Script .= "	Recyclers = retVals[2];\n";
		$Script .= "	Missiles  = retVals[3];\n";
		$Script .= "	retVals   = Message.split(\";\");\n";
		$Script .= "	CmdCode   = retVals[0];\n";
		$Script .= "	strInfo   = retVals[1];\n";
		$Script .= "	addToTable(\"done\", \"success\");\n";
		$Script .= "	changeSlots( UsedSlots );\n";
		$Script .= "	setShips(\"probes\", SpyProbes );\n";
		$Script .= "	setShips(\"recyclers\", Recyclers );\n";
		$Script .= "	setShips(\"missiles\", Missiles );\n";
		$Script .= "}\n\n";
		$Script .= "function doit (order, galaxy, system, planet, planettype, shipcount) {\n";
		$Script .= "	ajax.requestFile = \"FleetAjax.php?action=send\";\n";
		$Script .= "	ajax.runResponse = whenResponse;\n";
		$Script .= "	ajax.execute = true;\n\n";
		$Script .= "	ajax.setVar(\"thisgalaxy\", ". $CurrentPlanet["galaxy"] .");\n";
		$Script .= "	ajax.setVar(\"thissystem\", ". $CurrentPlanet["system"] .");\n";
		$Script .= "	ajax.setVar(\"thisplanet\", ". $CurrentPlanet["planet"] .");\n";
		$Script .= "	ajax.setVar(\"thisplanettype\", ". $CurrentPlanet["planet_type"] .");\n";
		$Script .= "	ajax.setVar(\"mission\", order);\n";
		$Script .= "	ajax.setVar(\"galaxy\", galaxy);\n";
		$Script .= "	ajax.setVar(\"system\", system);\n";
		$Script .= "	ajax.setVar(\"planet\", planet);\n";
		$Script .= "	ajax.setVar(\"planettype\", planettype);\n";
		$Script .= "	if (order == 6)\n";
		$Script .= "		ajax.setVar(\"ship210\", shipcount);\n";
		$Script .= "	if (order == 7) {\n";
		$Script .= "		ajax.setVar(\"ship208\", 1);\n\n";
		$Script .= "		ajax.setVar(\"ship203\", 2);\n\n";
		$Script .= "	}\n";
		$Script .= "	if (order == 8)\n";
		$Script .= "		ajax.setVar(\"ship209\", shipcount);\n\n";
		$Script .= "	ajax.runAJAX();\n";
		$Script .= "}\n\n";
		$Script .= "function addToTable(strDataResult, strClass) {\n";
		$Script .= "	var e = document.getElementById('fleetstatusrow');\n";
		$Script .= "	var e2 = document.getElementById('fleetstatustable');\n";
		$Script .= "	e.style.display = '';\n";
		$Script .= "	if(e2.rows.length > 2) {\n";
		$Script .= "		e2.deleteRow(2);\n";
		$Script .= "	}\n";
		$Script .= "	var row = e2.insertRow(0);\n";
		$Script .= "	var td1 = document.createElement(\"td\");\n";
		$Script .= "	var td1text = document.createTextNode(strInfo);\n";
		$Script .= "	td1.appendChild(td1text);\n";
		$Script .= "	var td2 = document.createElement(\"td\");\n";
		$Script .= "	var span = document.createElement(\"span\");\n";
		$Script .= "	var spantext = document.createTextNode(strDataResult);\n";
		$Script .= "	var spanclass = document.createAttribute(\"class\");\n";
		$Script .= "	spanclass.nodeValue = strClass;\n";
		$Script .= "	span.setAttributeNode(spanclass);\n";
		$Script .= "	span.appendChild(spantext);\n";
		$Script .= "	td2.appendChild(span);\n";
		$Script .= "	row.appendChild(td1);\n";
		$Script .= "	row.appendChild(td2);\n";
		$Script .= "}\n\n";
		$Script .= "function changeSlots(slotsInUse) {\n";
		$Script .= "	var e = document.getElementById('slots');\n";
		$Script .= "	e.innerHTML = slotsInUse;\n";
		$Script .= "}\n\n";
		$Script .= "function setShips(ship, count) {\n";
		$Script .= "	var e = document.getElementById(ship);\n";
		$Script .= "	e.innerHTML = count;\n";
		$Script .= "}\n";
		$Script .= "</script>\n";

		return $Script;
	}

	private function ShowGalaxyRows($Galaxy, $System, $HavePhalanx, $CurrentGalaxy, $CurrentSystem, $CurrentRC, $CurrentMIP)
	{
		global $planetcount, $dpath, $user, $xgp_root, $phpEx;

		$UserPoints    = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". intval($user['id']) ."';", 'statpoints', true);

		$Result = "";
		for ($Planet = 1; $Planet < 1+(MAX_PLANET_IN_SYSTEM); $Planet++)
		{
			unset($GalaxyRowPlanet);
			unset($GalaxyRowMoon);
			unset($GalaxyRowPlayer);
			unset($GalaxyRowAlly);

			$GalaxyRow = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$Galaxy."' AND `system` = '".$System."' AND `planet` = '".$Planet."';", 'galaxy', true);

			$Result .= "\n";
			$Result .= "<tr>";

			if ($GalaxyRow)
			{
				if ($GalaxyRow["id_planet"] != 0)
				{
					$GalaxyRowPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRow["id_planet"] ."';", 'planets', true);

					if ($GalaxyRowPlanet['destruyed'] != 0 && $GalaxyRowPlanet['id_owner'] != '' && $GalaxyRow["id_planet"] != '')
					{
						$this->CheckAbandonPlanetState ($GalaxyRowPlanet);
					}
					else
					{
						$planetcount++;
						$GalaxyRowPlayer = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRowPlanet["id_owner"] ."';", 'users', true);
					}

					if ($GalaxyRow["id_luna"] != 0)
					{
						$GalaxyRowMoon   = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRow["id_luna"] ."' AND planet_type='3';", 'planets', true);

						if ($GalaxyRowMoon["destruyed"] != 0)
						{
							$this->CheckAbandonMoonState ($GalaxyRowMoon);
						}
					}

					if ($GalaxyRowPlanet['id_owner'] <> 0)
						$GalaxyRowUser     = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRowPlanet['id_owner'] ."';", 'users', true);
					else
						$GalaxyRowUser     = array();

				}
			}

			$Result .= $this->GalaxyRowPos        ( $GalaxyRow, $Galaxy, $System, $Planet, 1 );
			$Result .= $this->GalaxyRowPlanet     ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 1, $HavePhalanx, $CurrentGalaxy, $CurrentSystem);
			$Result .= $this->GalaxyRowPlanetName ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 1, $HavePhalanx, $CurrentGalaxy, $CurrentSystem);
			$Result .= $this->GalaxyRowMoon       ( $GalaxyRow, $GalaxyRowMoon  , $GalaxyRowPlayer, $Galaxy, $System, $Planet, 3 );
			$Result .= $this->GalaxyRowDebris     ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 2, $CurrentRC);
			$Result .= $this->GalaxyRowUser       ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 0, $UserPoints );
			$Result .= $this->GalaxyRowAlly       ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 0 );
			$Result .= $this->GalaxyRowActions    ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 0, $CurrentGalaxy, $CurrentSystem, $CurrentMIP);
			$Result .= "</tr>";
		}
		return $Result;
	}

	public function __construct($CurrentUser, $CurrentPlanet)
	{
		global $xgp_root, $phpEx, $dpath, $resource, $lang, $planetcount;

		$fleetmax      	= ($CurrentUser['computer_tech'] + 1) + ($CurrentUser['rpg_commandant'] * COMMANDANT);
		$CurrentPlID   	= $CurrentPlanet['id'];
		$CurrentMIP    	= $CurrentPlanet['interplanetary_misil'];
		$CurrentRC     	= $CurrentPlanet['recycler'];
		$CurrentSP     	= $CurrentPlanet['spy_sonde'];
		$HavePhalanx   	= $CurrentPlanet['phalanx'];
		$CurrentSystem 	= $CurrentPlanet['system'];
		$CurrentGalaxy 	= $CurrentPlanet['galaxy'];
		$CanDestroy    	= $CurrentPlanet[$resource[213]] + $CurrentPlanet[$resource[214]];

		$maxfleet       = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '". intval($CurrentUser['id']) ."';", 'fleets');
		$maxfleet_count = mysql_num_rows($maxfleet);

		if (!isset($mode))
		{
			if (isset($_GET['mode']))
			{
				$mode = intval($_GET['mode']);
			}
			else
			{
				$mode = 0;
			}
		}

		if ($mode == 0)
		{
			$galaxy        = $CurrentPlanet['galaxy'];
			$system        = $CurrentPlanet['system'];
			$planet        = $CurrentPlanet['planet'];
		}
		elseif ($mode == 1)
		{
			if (intval($_POST["galaxy"]))
			{
				$_POST["galaxy"] = ereg_replace("[^0-9]","",$_POST["galaxy"]);
			}
			else
			{
				$_POST["galaxy"] = 1;
			}

			if (intval($_POST["system"]))
			{
				$_POST["system"] = ereg_replace("[^0-9]","",$_POST["system"]);
			}
			else
			{
				$_POST["system"] = 1;
			}

			if ($_POST["galaxy"] > MAX_GALAXY_IN_WORLD)
				$_POST["galaxy"] = MAX_GALAXY_IN_WORLD;

			if ($_POST["system"] > MAX_SYSTEM_IN_GALAXY)
				$_POST["system"] = MAX_SYSTEM_IN_GALAXY;

			if ($_POST["galaxyLeft"])
			{
				if ($_POST["galaxy"] < 1)
				{
					$_POST["galaxy"] = 1;
					$galaxy          = 1;
				}
				elseif ($_POST["galaxy"] == 1)
				{
					$_POST["galaxy"] = 1;
					$galaxy          = 1;
				}
				else
				{
					$galaxy = $_POST["galaxy"] - 1;
				}
			}
			elseif ($_POST["galaxyRight"])
			{
				if ($_POST["galaxy"] > MAX_GALAXY_IN_WORLD OR $_POST["galaxyRight"] > MAX_GALAXY_IN_WORLD)
				{
					$_POST["galaxy"]      = MAX_GALAXY_IN_WORLD;
					$_POST["galaxyRight"] = MAX_GALAXY_IN_WORLD;
					$galaxy               = MAX_GALAXY_IN_WORLD;
				}
				elseif ($_POST["galaxy"] == MAX_GALAXY_IN_WORLD)
				{
					$_POST["galaxy"]      = MAX_GALAXY_IN_WORLD;
					$galaxy               = MAX_GALAXY_IN_WORLD;
				}
				else
				{
					$galaxy = $_POST["galaxy"] + 1;
				}
			}
			else
			{
				$galaxy = $_POST["galaxy"];
			}

			if ($_POST["systemLeft"])
			{
				if ($_POST["system"] < 1)
				{
					$_POST["system"] = 1;
					$system          = 1;
				}
				elseif ($_POST["system"] == 1)
				{
					$_POST["system"] = 1;
					$system          = 1;
				}
				else
				{
					$system = $_POST["system"] - 1;
				}
			}
			elseif ($_POST["systemRight"])
			{
				if ($_POST["system"]      > MAX_SYSTEM_IN_GALAXY OR $_POST["systemRight"] > MAX_SYSTEM_IN_GALAXY)
				{
					$_POST["system"]      = MAX_SYSTEM_IN_GALAXY;
					$system               = MAX_SYSTEM_IN_GALAXY;
				}
				elseif ($_POST["system"] == MAX_SYSTEM_IN_GALAXY)
				{
					$_POST["system"]      = MAX_SYSTEM_IN_GALAXY;
					$system               = MAX_SYSTEM_IN_GALAXY;
				}
				else
				{
					$system = $_POST["system"] + 1;
				}
			}
			else
			{
				$system = $_POST["system"];
			}
		}
		elseif ($mode == 2)
		{
			$galaxy        = intval($_GET['galaxy']);
			$system        = intval($_GET['system']);
			$planet        = intval($_GET['planet']);
		}
		elseif ($mode == 3)
		{
			$galaxy        = intval($_GET['galaxy']);
			$system        = intval($_GET['system']);
		}
		else
		{
			$galaxy        = 1;
			$system        = 1;
		}

		if ( ( $CurrentPlanet['system'] != ( $_POST["system"] - 1 ) ) && ( $mode != 0 ) && ( $CurrentPlanet['deuterium'] < 10 ) )
		{
			die (message($lang['gl_no_deuterium_to_view_galaxy'], "game.php?page=galaxy&mode=0", 2));
		}
		elseif( ( $CurrentPlanet['system'] != ( $_POST["system"] - 1 ) ) && ( $mode != 0 ) )
		{
			$QryGalaxyDeuterium   = "UPDATE {{table}} SET ";
			$QryGalaxyDeuterium  .= "`deuterium` = `deuterium` -  10 ";
			$QryGalaxyDeuterium  .= "WHERE ";
			$QryGalaxyDeuterium  .= "`id` = '". $CurrentPlanet['id'] ."' ";
			$QryGalaxyDeuterium  .= "LIMIT 1;";
			doquery($QryGalaxyDeuterium, 'planets');
		}

		$planetcount = 0;
		$lunacount   = 0;

		$parse						= $lang;
		$parse['galaxy']			= $galaxy;
		$parse['system']			= $system;
		$parse['planet']			= $planet;
		$parse['currentmip']		= $CurrentMIP;
		$parse['maxfleetcount']		= $maxfleet_count;
		$parse['fleetmax']			= $fleetmax;
		$parse['recyclers']   		= pretty_number($CurrentRC);
		$parse['spyprobes']   		= pretty_number($CurrentSP);
		$parse['missile_count']		= sprintf($lang['gl_missil_to_launch'], $CurrentMIP);
		$parse['current']			= $_GET['current'];
		$parse['current_galaxy']	= $CurrentPlanet["galaxy"];
		$parse['current_system']	= $CurrentPlanet["system"];
		$parse['current_planet']	= $CurrentPlanet["planet"];
		$parse['planet_type'] 		= $CurrentPlanet["planet_type"];

		$page['galaxyscripts']		= $this->InsertGalaxyScripts ($CurrentPlanet);
		$page['galaxyselector']		= parsetemplate(gettemplate('galaxy/galaxy_selector'), $parse);
		($mode == 2) ? $page['mip'] = parsetemplate(gettemplate('galaxy/galaxy_missile_selector'), $parse) : " ";
		$page['galaxytitles'] 		= parsetemplate(gettemplate('galaxy/galaxy_titles'), $parse);
		$page['galaxyrows'] 		= $this->ShowGalaxyRows   ($galaxy, $system, $HavePhalanx, $CurrentGalaxy, $CurrentSystem, $CurrentRC, $CurrentMIP);

		$parse['planetcount'] 		= $planetcount ." ". $lang['gl_populed_planets'];

		$page['galaxyfooter'] 		= parsetemplate(gettemplate('galaxy/galaxy_footer'), $parse);

		return display(parsetemplate(gettemplate('galaxy/galaxy_body'), $page), false);
	}
}
?>