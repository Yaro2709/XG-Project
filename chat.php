<?php
  ini_set('display_error',0);
 ini_set('error_reporting',0);
/**
 * chat.php
 *
 * @version 1.0
 * @version 1.2 by Ihor
 * @copyright 2008 by e-Zobar for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xgp_root_path = './';
include($xgp_root_path . 'extension.inc.php');
include($xgp_root_path . 'common.' . $phpEx);

  

if ($IsUserChecked == false) {
    includeLang('INGAME');
    header("Location: login.php");
}
    includeLang('chat');
    $BodyTPL = gettemplate('chat/chat_body');
    $nick = $user['username'];
    $parse = $lang;
    if ($_GET) {
        if($_GET["chat_type"]=="ally"){
            $parse['chat_type'] = $_GET["chat_type"];
            $parse['ally_id']   = $user['ally_id'];
        }
    }
	
    //Онлайн
        $OnlineUsers = doquery("SELECT COUNT(*) FROM {{table}} WHERE onlinetime>='".(time()-15*60)."'",'users', 'true');
        $parse['NumberMembersOnline'] = $OnlineUsers[0];
        ////caha
        $searchtext="chat";
        $OnlineAdmins = doquery("SELECT * FROM {{table}} WHERE authlevel<=1 AND current_page LIKE '%{$searchtext}%'  ",'users');
        ////
        if($OnlineAdmins){
            $parse['OnlineAdmins'] = "";
            while ($oas = mysql_fetch_array($OnlineAdmins)) {
                $parse['OnlineAdmins'] .= "&nbsp;<a href=\"game.php?page=messages&mode=write&id=". $oas['id'] ."\" ><font color='lime'>". $oas['username'] ."&nbsp;,&nbsp;</a></font><br>";
            }                                                          
        }else{
            $parse['OnlineAdmins'] = "--";
        }
	
    $page = parsetemplate($BodyTPL, $parse);
    display($page, $lang['chat']);

// Shoutbox by e-Zobar - Copyright XNova Team 2008
?>