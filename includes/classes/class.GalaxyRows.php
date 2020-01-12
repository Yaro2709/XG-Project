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

class GalaxyRows
{
	private function GetMissileRange ()
	{
		global $resource, $user;

		if ($user[$resource[117]] > 0)
		{
			$MissileRange = ($user[$resource[117]] * 2) - 1;
		}
		elseif($user[$resource[117]] == 0)
		{
			$MissileRange = 0;
		}
		return $MissileRange;
	}

	public function GetPhalanxRange($PhalanxLevel)
	{
		$PhalanxRange = 0;

		if ($PhalanxLevel > 1)
		{
			$PhalanxRange = pow($PhalanxLevel, 2) - 1;
		}
		elseif($PhalanxLevel == 1)
		{
			$PhalanxRange = 1;
		}

		return $PhalanxRange;
	}

	public function CheckAbandonMoonState($lunarow)
	{
		if (($lunarow['destruyed'] + 172800) <= time() && $lunarow['destruyed'] != 0)
			$QryUpdateGalaxy  = "UPDATE {{table}} SET `id_luna` = '0' WHERE `galaxy` = '". intval($lunarow['galaxy']) ."' AND `system` = '". intval($lunarow['system']) ."' AND `planet` = '". intval($lunarow['planet']) ."' LIMIT 1;";
		doquery( $QryUpdateGalaxy , 'galaxy');
		doquery("DELETE FROM {{table}} WHERE `id` = ".intval($lunarow['id'])."", 'planets');
	}

	public function CheckAbandonPlanetState(&$planet)
	{
		if ($planet['destruyed'] <= time())
		{
			doquery("DELETE FROM {{table}} WHERE `id_planet` = '".intval($planet['id'])."' LIMIT 1;" , 'galaxy');
			doquery("DELETE FROM {{table}} WHERE `id` = ".intval($planet['id'])."", 'planets');
		}
	}

	public function GalaxyRowActions($GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, $PlanetType, $CurrentGalaxy, $CurrentSystem, $CurrentMIP)
	{
		global $user, $dpath, $lang;

		$Result = "<th style=\"white-space: nowrap;\" width=125>";

		if ($GalaxyRowPlayer['id'] != $user['id'])
		{
			if ($CurrentMIP <> 0)
			{
				if ($GalaxyRowUser['id'] != $user['id'])
				{
					if ($GalaxyRowPlanet["galaxy"] == $CurrentGalaxy)
					{
						$Range = $this->GetMissileRange();
						$SystemLimitMin = $CurrentSystem - $Range;
						if ($SystemLimitMin < 1)
						{
							$SystemLimitMin = 1;
						}
						$SystemLimitMax = $CurrentSystem + $Range;

						if ($System <= $SystemLimitMax)
						{
							if ($System >= $SystemLimitMin)
							{
								$MissileBtn = true;
							}
							else
							{
								$MissileBtn = false;
							}
						}
						else
						{
							$MissileBtn = false;
						}
					}
					else
					{
						$MissileBtn = false;
					}
				}
				else
				{
					$MissileBtn = false;
				}
			}
			else
			{
				$MissileBtn = false;
			}

			if ($GalaxyRowPlayer && $GalaxyRowPlanet["destruyed"] == 0)
			{
				if ($user["settings_esp"] == "1" && $GalaxyRowPlayer['id'])
				{
					$Result .= "<a href=# onclick=\"javascript:doit(6, ".$Galaxy.", ".$System.", ".$Planet.", 1, ".$user["spio_anz"].");\" >";
					$Result .= "<img src=". $dpath ."img/e.gif title=\"".$lang['gl_spy']."\" border=0></a>";
					$Result .= "&nbsp;";
				}
				if ($user["settings_wri"] == "1" && $GalaxyRowPlayer['id'])
				{
					$Result .= "<a href=game.php?page=messages&mode=write&id=".$GalaxyRowPlayer["id"].">";
					$Result .= "<img src=". $dpath ."img/m.gif title=\"".$lang['write_message']."\" border=0></a>";
					$Result .= "&nbsp;";
				}
				if ($user["settings_bud"] == "1" && $GalaxyRowPlayer['id'])
				{
					$Result .= "<a href=game.php?page=buddy&mode=2&u=".$GalaxyRowPlayer['id']." >";
					$Result .= "<img src=". $dpath ."img/b.gif title=\"".$lang['gl_buddy_request']."\" border=0></a>";
					$Result .= "&nbsp;";
				}
				if ($user["settings_mis"] == "1" && $MissileBtn == true && $GalaxyRowPlayer['id'])
				{
					$Result .= "<a href=game.php?page=galaxy&mode=2&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&current=".$user['current_planet']." >";
					$Result .= "<img src=". $dpath ."img/r.gif title=\"".$lang['gl_missile_attack']."\" border=0></a>";
				}
			}
		}
		$Result .= "</th>";

		return $Result;
	}

	public function GalaxyRowAlly($GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType)
	{
		global $user, $lang;

		$Result  = "<th width=80>";
		if ($GalaxyRowUser['ally_id'] && $GalaxyRowUser['ally_id'] != 0)
		{
			$allyquery = doquery("SELECT * FROM {{table}} WHERE id=" . intval($GalaxyRowUser['ally_id']), "alliance", true);
			if ($allyquery)
			{
				$members_count = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE ally_id=" . intval($allyquery['id']) . ";", "users", true);

				if ($members_count[0] > 1)
					$add = $lang['gl_member_add'];
				else
					$add = "";

				$Result .= "<a style=\"cursor: pointer;\"";
				$Result .= " onmouseover='return overlib(\"";
				$Result .= "<table width=240>";
				$Result .= "<tr>";
				$Result .= "<td class=c>".$lang['gl_alliance']. " " . $allyquery['ally_name'] . $lang['gl_with'] . $members_count[0] . $lang['gl_member'] . $add ."</td>";
				$Result .= "</tr>";
				$Result .= "<th>";
				$Result .= "<table>";
				$Result .= "<tr>";
				$Result .= "<td><a href=game.php?page=alliance&mode=ainfo&a=". $allyquery['id'] .">".$lang['gl_alliance_page']."</a></td>";
				$Result .= "</tr><tr>";
				$Result .= "<td><a href=game.php?page=statistics&start=101&who=ally>".$lang['gl_see_on_stats']."</a></td>";
				if ($allyquery["ally_web"] != "")
				{
					$Result .= "</tr><tr>";
					$Result .= "<td><a href=". $allyquery["ally_web"] ." target=_new>".$lang['gl_alliance_web_page']."</td>";
				}
				$Result .= "</tr>";
				$Result .= "</table>";
				$Result .= "</th>";
				$Result .= "</table>\"";
				$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
				$Result .= " onmouseout='return nd();'>";
				if ($user['ally_id'] == $GalaxyRowPlayer['ally_id'])
				{
					$Result .= "<span class=\"allymember\">". $allyquery['ally_tag'] ."</span></a>";
				}
				elseif ($GalaxyRowUser['ally_id'] == $user['ally_id'])
				{
					$Result .= "<font color=lime>".$allyquery['ally_tag'] ."</font></a>";
				}
				else
				{
					$Result .= $allyquery['ally_tag'] ."</a>";
				}
			}
		}
		$Result .= "</th>";
		return $Result;
	}

	public function GalaxyRowDebris($GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType, $CurrentRC)
	{
		global $dpath, $user, $pricelist, $lang;

		$Result  = "<th style=\"white-space: nowrap;\" width=30>";
		if ($GalaxyRow)
		{
			if ($GalaxyRow["metal"] != 0 || $GalaxyRow["crystal"] != 0)
			{
				$RecNeeded = ceil(($GalaxyRow["metal"] + $GalaxyRow["crystal"]) / $pricelist[209]['capacity']);

				if ($RecNeeded < $CurrentRC)
					$RecSended = $RecNeeded;
				elseif ($RecNeeded >= $CurrentRC)
					$RecSended = $CurrentRC;
				else
					$RecSended = $RecyclerCount;

				$Result .= "<a style=\"cursor: pointer;\"";
				$Result .= " onmouseover='return overlib(\"";
				$Result .= "<table width=240>";
				$Result .= "<tr>";
				$Result .= "<td class=c colspan=2>";
				$Result .= $lang['gl_debris_field'] . "[".$Galaxy.":".$System.":".$Planet."]";
				$Result .= "</td>";
				$Result .= "</tr><tr>";
				$Result .= "<th width=80>";
				$Result .= "<img src=". $dpath ."planeten/debris.jpg height=75 width=75 />";
				$Result .= "</th>";
				$Result .= "<th>";
				$Result .= "<table>";
				$Result .= "<tr>";
				$Result .= "<td class=c colspan=2>".$lang['gl_resources'].":</td>";
				$Result .= "</tr><tr>";
				$Result .= "<th>".$lang['Metal'].": </th><th>". number_format( $GalaxyRow['metal'], 0, '', '.') ."</th>";
				$Result .= "</tr><tr>";
				$Result .= "<th>".$lang['Crystal'].": </th><th>". number_format( $GalaxyRow['crystal'], 0, '', '.') ."</th>";
				$Result .= "</tr><tr>";
				$Result .= "<td class=c colspan=2>".$lang['gl_actions'].":</td>";
				$Result .= "</tr><tr>";
				$Result .= "<th colspan=2 align=left>";
				$Result .= "<a href= # onclick=&#039javascript:doit (8, ".$Galaxy.", ".$System.", ".$Planet.", ".$PlanetType.", ".$RecSended."); return nd();&#039 >".$lang['gl_collect']."</a>";
				$Result .= "</tr>";
				$Result .= "</table>";
				$Result .= "</th>";
				$Result .= "</tr>";
				$Result .= "</table>\"";
				$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
				$Result .= " onmouseout='return nd();'>";
				$Result .= "<img src=". $dpath ."planeten/debris.jpg height=22 width=22></a>";
			}
		}
		$Result .= "</th>";
		return $Result;
	}

	public function GalaxyRowMoon($GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType)
	{
		global $user, $dpath, $CanDestroy, $lang;

		$Result  = "<th style=\"white-space: nowrap;\" width=30>";
		if ($GalaxyRowUser['id'] != $user['id'])
			$MissionType6Link = "<a href=# onclick=&#039javascript:doit(6, ".$Galaxy.", ".$System.", ".$Planet.", ".$PlanetType.", ".$user["spio_anz"].");&#039 >".$lang['type_mission'][6]."</a><br /><br />";
		elseif ($GalaxyRowUser['id'] == $user['id'])
			$MissionType6Link = "";

		if ($GalaxyRowUser['id'] != $user['id'])
			$MissionType1Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=1>".$lang['type_mission'][1]."</a><br />";
		elseif ($GalaxyRowUser['id'] == $user['id'])
			$MissionType1Link = "";

		if ($GalaxyRowUser['id'] != $user['id'])
			$MissionType5Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=5>".$lang['type_mission'][5]."</a><br />";
		elseif ($GalaxyRowUser['id'] == $user['id'])
			$MissionType5Link = "";

		if ($GalaxyRowUser['id'] == $user['id'])
			$MissionType4Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=4>".$lang['type_mission'][4]."</a><br />";
		elseif ($GalaxyRowUser['id'] != $user['id'])
			$MissionType4Link = "";

		if ($GalaxyRowUser['id'] != $user['id'])
			if ($CanDestroy > 0)
				$MissionType9Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=9>".$lang['type_mission'][9]."</a>";
		else
			$MissionType9Link = "";
		elseif ($GalaxyRowUser['id'] == $user['id'])
			$MissionType9Link = "";

		$MissionType3Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=3>".$lang['type_mission'][3]."</a><br />";

		if ($GalaxyRow && $GalaxyRowPlanet["destruyed"] == 0 && $GalaxyRow["id_luna"] != 0)
		{
			$Result .= "<a style=\"cursor: pointer;\"";
			$Result .= " onmouseover='return overlib(\"";
			$Result .= "<table width=240>";
			$Result .= "<tr>";
			$Result .= "<td class=c colspan=2>";
			$Result .= $lang['gl_moon'] . " ".$GalaxyRowPlanet["name"]." [".$Galaxy.":".$System.":".$Planet."]";
			$Result .= "</td>";
			$Result .= "</tr><tr>";
			$Result .= "<th width=80>";
			$Result .= "<img src=". $dpath ."planeten/mond.jpg height=75 width=75 />";
			$Result .= "</th>";
			$Result .= "<th>";
			$Result .= "<table>";
			$Result .= "<tr>";
			$Result .= "<td class=c colspan=2>".$lang['gl_features']."</td>";
			$Result .= "</tr><tr>";
			$Result .= "<th>".$lang['gl_diameter']."</th>";
			$Result .= "<th>". number_format($GalaxyRowPlanet['diameter'], 0, '', '.') ."</th>";
			$Result .= "</tr><tr>";
			$Result .= "<th>".$lang['gl_temperature']."</th><th>". number_format($GalaxyRowPlanet['temp_min'], 0, '', '.') ."</th>";
			$Result .= "</tr><tr>";
			$Result .= "<td class=c colspan=2>".$lang['gl_actions']."</td>";
			$Result .= "</tr><tr>";
			$Result .= "<th colspan=2 align=center>";
			$Result .= $MissionType6Link;
			$Result .= $MissionType3Link;
			$Result .= $MissionType4Link;
			$Result .= $MissionType1Link;
			$Result .= $MissionType5Link;
			$Result .= $MissionType9Link;
			$Result .= "</tr>";
			$Result .= "</table>";
			$Result .= "</th>";
			$Result .= "</tr>";
			$Result .= "</table>\"";
			$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
			$Result .= " onmouseout='return nd();'>";
			$Result .= "<img src=". $dpath ."planeten/small/s_mond.jpg height=22 width=22>";
			$Result .= "</a>";
		}
		$Result .= "</th>";
		return $Result;
	}

	public function GalaxyRowPlanet($GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType, $HavePhalanx, $CurrentGalaxy, $CurrentSystem)
	{
		global $dpath, $user, $CurrentMIP, $CurrentSystem, $game_config, $lang;

		$Result  = "<th width=30>";
		if ($GalaxyRow && $GalaxyRowPlanet["destruyed"] == 0 && $GalaxyRow["id_planet"] != 0)
		{
			if ($HavePhalanx <> 0)
			{
				if ($GalaxyRowUser['id'] != $user['id'])
				{
					if ($GalaxyRowPlanet["galaxy"] == $CurrentGalaxy)
					{
						$PhRange = $this->GetPhalanxRange ( $HavePhalanx );
						$SystemLimitMin = $CurrentSystem - $PhRange;
						if ($SystemLimitMin < 1)
							$SystemLimitMin = 1;

						$SystemLimitMax = $CurrentSystem + $PhRange;
						if ($System <= $SystemLimitMax)
						{
							if ($System >= $SystemLimitMin)
								$PhalanxTypeLink = "<a href=# onclick=fenster(&#039;game.php?page=phalanx&galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&#039;) >".$lang['gl_phalanx']."</a><br />";
							else
								$PhalanxTypeLink = "";
						}
						else
						{
							$PhalanxTypeLink = "";
						}
					}
					else
					{
						$PhalanxTypeLink = "";
					}
				}
				else
				{
					$PhalanxTypeLink = "";
				}
			}
			else
			{
				$PhalanxTypeLink = "";
			}

			if ($CurrentMIP <> 0)
			{
				if ($GalaxyRowUser['id'] != $user['id'])
				{
					if ($GalaxyRowPlanet["galaxy"] == $CurrentGalaxy)
					{
						$MiRange = $this->GetMissileRange();
						$SystemLimitMin = $CurrentSystem - $MiRange;
						if ($SystemLimitMin < 1)
							$SystemLimitMin = 1;

						$SystemLimitMax = $CurrentSystem + $MiRange;

						if ($System <= $SystemLimitMax)
						{
							if ($System >= $SystemLimitMin)
								$MissileBtn = true;
							else
								$MissileBtn = false;
						}
						else
						{
							$MissileBtn = false;
						}
					}
					else
					{
						$MissileBtn = false;
					}
				}
				else
				{
					$MissileBtn = false;
				}
			}
			else
			{
				$MissileBtn = false;
			}

			if ($GalaxyRowUser['id'] != $user['id'])
				$MissionType6Link = "<a href=# onclick=&#039javascript:doit(6, ".$Galaxy.", ".$System.", ".$Planet.", ".$PlanetType.", ".$user["spio_anz"].");&#039 >".$lang['type_mission'][6]."</a><br /><br />";
			elseif ($GalaxyRowUser['id'] == $user['id'])
				$MissionType6Link = "";

			if ($GalaxyRowUser['id'] != $user['id'])
				$MissionType1Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=1>".$lang['type_mission'][1]."</a><br />";
			elseif ($GalaxyRowUser['id'] == $user['id'])
				$MissionType1Link = "";

			if ($GalaxyRowUser['id'] == $user['id'])
				$MissionType5Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=5>".$lang['type_mission'][5]."</a><br />";
			elseif ($GalaxyRowUser['id'] == $user['id'])
				$MissionType5Link = "";

			if ($GalaxyRowUser['id'] == $user['id'])
				$MissionType4Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=4>".$lang['type_mission'][4]."</a><br />";
			elseif ($GalaxyRowUser['id'] != $user['id'])
				$MissionType4Link = "";

			if ($user["settings_mis"] == "1" AND $MissileBtn == true && $GalaxyRowUser['id'])
				$MissionType10Link = "<a href=game.php?page=galaxy&mode=2&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&current=".$user['current_planet']." >".$lang['gl_missile_attack']."</a><br />";
			elseif ($GalaxyRowUser['id'] != $user['id'])
				$MissionType10Link = "";

			$MissionType3Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=3>".$lang['type_mission'][3]."</a><br />";

			$Result .= "<a style=\"cursor: pointer;\"";
			$Result .= " onmouseover='return overlib(\"";
			$Result .= "<table width=240>";
			$Result .= "<tr>";
			$Result .= "<td class=c colspan=2>";
			$Result .= $lang['gl_planet'] . " " . $GalaxyRowPlanet["name"] ." [".$Galaxy.":".$System.":".$Planet."]";
			$Result .= "</td>";
			$Result .= "</tr>";
			$Result .= "<tr>";
			$Result .= "<th width=80>";
			$Result .= "<img src=". $dpath ."planeten/small/s_". $GalaxyRowPlanet["image"] .".jpg height=75 width=75 />";
			$Result .= "</th>";
			$Result .= "<th align=left>";
			$Result .= $MissionType6Link;
			$Result .= $PhalanxTypeLink;
			$Result .= $MissionType1Link;
			$Result .= $MissionType5Link;
			$Result .= $MissionType4Link;
			$Result .= $MissionType3Link;
			$Result .= $MissionType10Link;
			$Result .= "</th>";
			$Result .= "</tr>";
			$Result .= "</table>\"";
			$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
			$Result .= " onmouseout='return nd();'>";
			$Result .= "<img src=".   $dpath ."planeten/small/s_". $GalaxyRowPlanet["image"] .".jpg height=30 width=30>";
			$Result .= "</a>";
		}
		$Result .= "</th>";

		return $Result;
	}

	public function GalaxyRowPlanetName($GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType, $HavePhalanx, $CurrentGalaxy, $CurrentSystem)
	{
		global $user, $lang;

		$Result  = "<th style=\"white-space: nowrap;\" width=130>";

		if ($GalaxyRowPlanet['last_update'] > (time()-59 * 60) && $GalaxyRowUser['id'] != $user['id'])
			$Inactivity = pretty_time_hour(time() - $GalaxyRowPlanet['last_update']);

		if ($GalaxyRow && $GalaxyRowPlanet["destruyed"] == 0)
		{
			if ($HavePhalanx <> 0)
			{
				if ($GalaxyRowPlanet["galaxy"] == $CurrentGalaxy)
				{
					$Range = $this->GetPhalanxRange ( $HavePhalanx );
					if ($CurrentGalaxy + $Range <= $CurrentSystem && $CurrentSystem >= $CurrentGalaxy - $Range)
						$PhalanxTypeLink = "<a href=# onclick=fenster('game.php?page=phalanx&galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."')  title=\"Phalanx\">".$GalaxyRowPlanet['name']."</a><br />";
					else
						$PhalanxTypeLink = stripslashes($GalaxyRowPlanet['name']);
				}
				else
				{
					$PhalanxTypeLink = stripslashes($GalaxyRowPlanet['name']);
				}
			}
			else
			{
				$PhalanxTypeLink = stripslashes($GalaxyRowPlanet['name']);
			}

			$Result .= $TextColor . $PhalanxTypeLink . $EndColor;

			if ($GalaxyRowPlanet['last_update']  > (time()-59 * 60) && $GalaxyRowUser['id'] != $user['id'])
			{
				if ($GalaxyRowPlanet['last_update']  > (time()-10 * 60) && $GalaxyRowUser['id'] != $user['id'])
					$Result .= "(*)";
				else
					$Result .= " (".$Inactivity.")";
			}
		}
		elseif($GalaxyRowPlanet["destruyed"] != 0)
		{
			$Result .= $lang['gl_planet_destroyed'];
		}

		$Result .= "</th>";

		return $Result;
	}

	public function GalaxyRowPos($GalaxyRow, $Galaxy, $System, $Planet)
	{
		$Result  = "<th width=30>";
		$Result .= "<a href=\"game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=0&target_mission=7\"";
		if ($GalaxyRow)
			$Result .= " tabindex=\"". ($Planet + 1) ."\"";
		$Result .= ">". $Planet ."</a>";
		$Result .= "</th>";

		return $Result;
	}

	public function GalaxyRowUser($GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType, $UserPoints)
	{
		global $game_config, $user, $lang;

		$Result = "<th width=150>";

		if ($GalaxyRowUser && $GalaxyRowPlanet["destruyed"] == 0)
		{
			$protection      	= $game_config['noobprotection'];
			$protectiontime  	= $game_config['noobprotectiontime'];
			$protectionmulti 	= $game_config['noobprotectionmulti'];
			$User2Points 		= doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $GalaxyRowUser['id'] ."';", 'statpoints', true);
			$CurrentPoints 		= $UserPoints['total_points'];
			$RowUserPoints 		= $User2Points['total_points'];
			$MyGameLevel 		= $CurrentPoints * $protectionmulti['config_value'];
			$HeGameLevel 		= $RowUserPoints * $protectionmulti['config_value'];

			if ($GalaxyRowUser['bana'] == 1 && $GalaxyRowUser['urlaubs_modus'] == 1)
			{
				$Systemtatus2 	= "v <a href=\"game.php?page=banned\"><span class=\"banned\">".$lang['gl_b']."</span></a>";
				$Systemtatus 	= "<span class=\"vacation\">";
			}
			elseif ($GalaxyRowUser['bana'] == 1)
			{
				$Systemtatus2 	= "<a href=\"game.php?page=banned\"><span class=\"banned\">".$lang['gl_b']."</span></a>";
				$Systemtatus 	= "";
			}
			elseif ($GalaxyRowUser['urlaubs_modus'] == 1)
			{
				$Systemtatus2 	= "<span class=\"vacation\">".$lang['gl_v']."</span>";
				$Systemtatus 	= "<span class=\"vacation\">";
			}
			elseif ($GalaxyRowUser['onlinetime'] < (time()-60 * 60 * 24 * 7) && $GalaxyRowUser['onlinetime'] > (time()-60 * 60 * 24 * 28))
			{
				$Systemtatus2 	= "<span class=\"inactive\">".$lang['gl_i']."</span>";
				$Systemtatus 	= "<span class=\"inactive\">";
			}
			elseif ($GalaxyRowUser['onlinetime'] < (time()-60 * 60 * 24 * 28))
			{
				$Systemtatus2 	= "<span class=\"inactive\">".$lang['gl_i']."</span><span class=\"longinactive\">".$lang['gl_I']."</span>";
				$Systemtatus 	= "<span class=\"longinactive\">";
			}
			elseif (($MyGameLevel > ($HeGameLevel * $protectionmulti)) && $protection == 1 && ($HeGameLevel < ($protectiontime * 1000)))
			{
				$Systemtatus2 	= "<span class=\"noob\">".$lang['gl_w']."</span>";
				$Systemtatus 	= "<span class=\"noob\">";
			}
			elseif ((($MyGameLevel * $protectionmulti) < $HeGameLevel) && $protection == 1 && ($MyGameLevel < ($protectiontime * 1000)))
			{
				$Systemtatus2 	= $lang['gl_s'];
				$Systemtatus 	= "<span class=\"strong\">";
			}
			else
			{
				$Systemtatus2 	= "";
				$Systemtatus 	= "";
			}
			$Systemtatus4 		= $User2Points['total_rank'];

			if ($Systemtatus2 != '')
			{
				$Systemtatus6 	= "<font color=\"white\">(</font>";
				$Systemtatus7 	= "<font color=\"white\">)</font>";
			}
			if ($Systemtatus2 == '')
			{
				$Systemtatus6 	= "";
				$Systemtatus7 	= "";
			}

			$Systemtart = $User2Points['total_rank'];

			if (strlen($Systemtart) < 3)
				$Systemtart = 1;
			else
				$Systemtart = (floor( $User2Points['total_rank'] / 100 ) * 100) + 1;

			$Result .= "<a style=\"cursor: pointer;\"";
			$Result .= " onmouseover='return overlib(\"";
			$Result .= "<table width=190>";
			$Result .= "<tr>";
			$Result .= "<td class=c colspan=2>". $lang['gl_player'] .$GalaxyRowUser['username']. $lang['gl_in_the_rank'] .$Systemtatus4."</td>";
			$Result .= "</tr><tr>";
			if ($GalaxyRowUser['id'] != $user['id'])
			{
				$Result .= "<td><a href=game.php?page=messages&mode=write&id=".$GalaxyRowUser['id'].">".$lang['write_message']."</a></td>";
				$Result .= "</tr><tr>";
				$Result .= "<td><a href=game.php?page=buddy&mode=2&u=".$GalaxyRowUser['id'].">".$lang['gl_buddy_request']."</a></td>";
				$Result .= "</tr><tr>";
			}
			$Result .= "<td><a href=game.php?page=statistics&who=player&start=".$Systemtart.">".$lang['gl_stat']."</a></td>";
			$Result .= "</tr>";
			$Result .= "</table>\"";
			$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
			$Result .= " onmouseout='return nd();'>";
			$Result .= $Systemtatus;
			$Result .= $GalaxyRowUser["username"]."</span>";
			$Result .= $Systemtatus6;
			$Result .= $Systemtatus;
			$Result .= $Systemtatus2;
			$Result .= $Systemtatus7." ".$admin;
			$Result .= "</span></a>";
		}
		$Result .= "</th>";

		return $Result;
	}
}
?>