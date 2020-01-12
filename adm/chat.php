<?php

/**
 * chat.php
 *
 * @version 1
 * @copyright 2008 By e-Zobar for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);
if ($user['authlevel'] >= 3) {
     // Systeme de suppression
     $parse    = $lang;
     extract($_GET);
     if (isset($delete)) {
         doquery("DELETE FROM {{table}} WHERE `messageid`=".$delete, 'chat');
       } elseif ($deleteall == 'yes') {
           doquery("DELETE FROM {{table}}", 'chat');
       }

        // Affichage des messages
        $query = doquery("SELECT * FROM {{table}} ORDER BY messageid DESC LIMIT 25", 'chat');
        $i = 0;
        while ($e = mysql_fetch_array($query)) {
            $i++;
            $parse['msg_list'] .= stripslashes("<tr><td class=n rowspan=2>{$e['messageid']}</td>" .
            "<td class=n style=color:red;><center><a href=?delete={$e['messageid']}><img src=\"/styles/images/r1.png\"></a></center></td>" .
            "<td class=n><center>{$e['user']}</center></td>" .
            "<td class=n><center>" . date('d/m/Y - h:i:s', $e['timestamp']) . "</center></td></tr><tr>" .
            "<td class=b colspan=4 width=700>" . nl2br($e['message']) . "</td></tr>");
        }
        $parse['msg_list'] .= "<tr><th class=b colspan=4>Сообщений <font color=lime>{$i} </font> ".$lang['ch_nbs']."</th></tr>";

        display(parsetemplate(gettemplate('adm/chat_body'), $parse),false, '', true, false);
    } else {
        message ($lang['not_enough_permissions']);
    }
?>