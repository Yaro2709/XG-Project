<script language="JavaScript" type="text/javascript">
var chat_type = "{chat_type}";
var ally_id = "{ally_id}";
</script>
<script language="JavaScript" type="text/javascript" src="scripts/chat.js"></script>

<br><br>

<table align="center" width='60%'><tbody>

<tr><td class="c"><b>{chat_disc}</b></td></tr>

<tr><th><div id="shoutbox" style="margin: 5px; vertical-align: text-top; height: 360px; overflow:auto;"></div></th></tr>

<tr><th nowrap>
{chat_message}: <input name="msg" type="text" id="msg" style="width:80%" maxlength="120" onKeyPress="if(event.keyCode == 13){ addMessage(); } if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"> 
<div nowrap>
&nbsp;&nbsp;
<select name="color" id="chat_color">
	<option value="white">Белый</option>
	<option value="Blue" style=color:Blue;>Синий</option>
	<option value="yellow" style=color:yellow;>Желтый</option>
	<option value="green" style=color:green;>Зелёный</option>
	<option value="pink" style=color:pink;>Розовый</option>
	<option value="red" style=color:red;>Красный - Цвет Администрации</option>
	<option value="orange" style=color:orange;>Оранжевый</option>
	
	<option value="lime" style=color:lime;>Лайм</option>
	<option value="BlueViolet" style=color:BlueViolet;>Фиолетовый</option>
	<option value="cyan" style=color:cyan;>Циан</option>
	
	
</select>
&nbsp;&nbsp;
<input type="button" name="send" value="{chat_send}" id="send" onClick="addMessage()">
&nbsp;&nbsp;
&nbsp;&nbsp;
<input type="button" name="send" value="{chat_history}" id="send" onClick="MessageHistory()">
</div>
</th>
<tr>
   <td>
&nbsp;&nbsp;<font color="Yellow"><b>Онлайн:</b></font>{OnlineAdmins}
    </td>
</tr>
<tr>
<th nowrap>
<div nowrap>  
<img src="styles/images/smileys/aggressive.gif" align="absmiddle" title=":agr:" alt=":agr:" onClick="addSmiley(':agr:')">
<img src="styles/images/smileys/angel.gif" align="absmiddle" title=":angel:" alt=":angel:" onClick="addSmiley(':angel:')">
<img src="styles/images/smileys/bad.gif" align="absmiddle" title=":bad:" alt=":bad:" onClick="addSmiley(':bad:')">
<img src="styles/images/smileys/blink.gif" align="absmiddle" title="o0" alt="o0" onClick="addSmiley(':blink:')">
<img src="styles/images/smileys/blush.gif" align="absmiddle" title=":blush:" alt=":blush:" onClick="addSmiley(':blush:')">
<img src="styles/images/smileys/bomb.gif" align="absmiddle" title=":bomb:" alt=":blush:" onClick="addSmiley(':bomb:')">
<img src="styles/images/smileys/clapping.gif" align="absmiddle" title=":clap:" alt=":clap:" onClick="addSmiley(':clap:')">
<img src="styles/images/smileys/cool.gif" align="absmiddle" title=":cool:" alt=":cool:" onClick="addSmiley(':cool:')">
<img src="styles/images/smileys/cray.gif" align="absmiddle" title=":c:" alt=":c:" onClick="addSmiley(':c:')">
<img src="styles/images/smileys/crazy.gif" align="absmiddle" title=":crz:" alt=":crz:" onClick="addSmiley(':crz:')">
<img src="styles/images/smileys/diablo.gif" align="absmiddle" title=":diablo:" alt=":diablo:" onClick="addSmiley(':diablo:')">
<img src="styles/images/smileys/dirol.gif" align="absmiddle" title=":cool2:" alt=":cool2:" onClick="addSmiley(':cool2:')">
<img src="styles/images/smileys/fool.gif" align="absmiddle" title=":s:" alt=":s:" onClick="addSmiley(':fool:')">
<img src="styles/images/smileys/give_rose.gif" align="absmiddle" title=":rose:" alt=":rose:" onClick="addSmiley(':rose:')">
<img src="styles/images/smileys/good.gif" align="absmiddle" title=":good:" alt=":good:" onClick="addSmiley(':good:')">
<img src="styles/images/smileys/huh.gif" align="absmiddle" title=":huh:" alt=":huh:" onClick="addSmiley(':huh:')">
<img src="styles/images/smileys/lol.gif" align="absmiddle" title=":D" alt=":D" onClick="addSmiley(':D:')">
<img src="styles/images/smileys/mellow.gif" align="absmiddle" title=":/" alt=":/" onClick="addSmiley(':/')"> 
<img src="styles/images/smileys/yu.gif" align="absmiddle" title=":yu" alt=":yu" onClick="addSmiley(':yu')">
<img src="styles/images/smileys/unknw.gif" align="absmiddle" title=":unknw:" alt=":unknw:" onClick="addSmiley(':unknw:')">
<img src="styles/images/smileys/sad.gif" align="absmiddle" title=":(" alt=":(" onClick="addSmiley(':sad')">
<img src="styles/images/smileys/smile.gif" align="absmiddle" title=":)" alt=":)" onClick="addSmiley(':smile')">
<img src="styles/images/smileys/shok.gif" align="absmiddle" title=":o" alt=":o" onClick="addSmiley(':shok:')"> 
<img src="styles/images/smileys/rofl.gif" align="absmiddle" title=":rofl" alt=":rofl" onClick="addSmiley(':rofl')">
<img src="styles/images/smileys/blackeye.gif" align="absmiddle" title=":eye" alt=":eye" onClick="addSmiley(':eye')">
<img src="styles/images/smileys/tongue.gif" align="absmiddle" title=":p" alt=":p" onClick="addSmiley(':p')">
<img src="styles/images/smileys/wink.gif" align="absmiddle" title=";)" alt=";)" onClick="addSmiley(';)')">                
<img src="styles/images/smileys/yahoo.gif" align="absmiddle" title=":yahoo:" alt=":yahoo:" onClick="addSmiley(':yahoo:')">
<img src="styles/images/smileys/mill.gif" align="absmiddle" title=":tratata:" alt=":tratata:" onClick="addSmiley(':tratata:')">
<br>


<img src="styles/images/smileys/friends.gif" align="absmiddle" title=":fr:" alt=":fr:" onClick="addSmiley(':fr')">
<img src="styles/images/smileys/drinks.gif" align="absmiddle" title=":dr:" alt=":dr:" onClick="addSmiley(':dr')">
<img src="styles/images/smileys/tease.gif" align="absmiddle" title=":tease:" alt=":tease:" onClick="addSmiley(':tease:')">
<img src="styles/images/smileys/mail1.gif" align="absmiddle" title=":mail1:" alt=":mail1:" onClick="addSmiley(':mail1:')">
<img src="styles/images/smileys/beee.gif" align="absmiddle" title=":beee:" alt=":beee:" onClick="addSmiley(':beee:')">
<img src="styles/images/smileys/preved.gif" align="absmiddle" title=":preved:" alt=":preved:" onClick="addSmiley(':preved:')">
<img src="styles/images/smileys/posle.gif" align="absmiddle" title=":posle:" alt=":posle:" onClick="addSmiley(':posle:')">
<img src="styles/images/smileys/nono.gif" align="absmiddle" title=":nono:" alt=":nono:" onClick="addSmiley(':nono:')">

<img src="styles/images/smileys/bc.gif" align="absmiddle" title=":bc:" alt=":bc:" onClick="addSmiley(':bc:')">
<img src="styles/images/smileys/be.gif" align="absmiddle" title=":be:" alt=":be:" onClick="addSmiley(':be:')">
<img src="styles/images/smileys/bh.gif" align="absmiddle" title=":bh:" alt=":bh:" onClick="addSmiley(':bh:')">
<img src="styles/images/smileys/bi.gif" align="absmiddle" title=":bi:" alt=":bi:" onClick="addSmiley(':bi:')">
<img src="styles/images/smileys/bk.gif" align="absmiddle" title=":bk:" alt=":bk:" onClick="addSmiley(':bk:')">
<img src="styles/images/smileys/bl.gif" align="absmiddle" title=":bl:" alt=":bl:" onClick="addSmiley(':bl:')">
<img src="styles/images/smileys/br.gif" align="absmiddle" title=":br:" alt=":br:" onClick="addSmiley(':br:')">
<img src="styles/images/smileys/bx.gif" align="absmiddle" title=":bx:" alt=":bx:" onClick="addSmiley(':bx:')">
<img src="styles/images/smileys/cc.gif" align="absmiddle" title=":cc:" alt=":cc:" onClick="addSmiley(':cc:')">
<img src="styles/images/smileys/cr.gif" align="absmiddle" title=":cr:" alt=":cr:" onClick="addSmiley(':cr:')">
<img src="styles/images/smileys/cg.gif" align="absmiddle" title=":cg:" alt=":cg:" onClick="addSmiley(':cg:')">
<img src="styles/images/smileys/ci.gif" align="absmiddle" title=":ci:" alt=":ci:" onClick="addSmiley(':ci:')">
<img src="styles/images/smileys/co.gif" align="absmiddle" title=":co:" alt=":co:" onClick="addSmiley(':co:')">



</div>
</th>
</tr>



<tr>
<td class="c"><center>{ExternalTchatFrame}&nbsp;&nbsp;&nbsp;&nbsp;{ClickBanner}</center></td>
</tr>
</table>
</center>