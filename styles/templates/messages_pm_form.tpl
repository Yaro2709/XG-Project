<script src="scripts/cntchar.js" type="text/javascript"></script>
<br />
    <form action="game.php?page=messages&mode=write&id={id}" method="post">
    <table width="519">
    <tr>
        <td class="c" colspan="2">Отправка сообщения</td>
    </tr><tr>
        <th>Получатель</th>
        <th><input type="text" name="to" size="40" value="{to}" /></th>
    </tr><tr>
        <th>Тема сообщения</th>
        <th><input type="text" name="subject" size="40" maxlength="40" value="{subject}" /></th>
    </tr><tr>
        <th>Текст сообщения (<span id="cntChars">0</span> / 5000 )</th>
        <th><textarea name="text" cols="40" rows="10" size="100" onkeyup="javascript:cntchar(5000)">{text}</textarea></th>
    </tr><tr>
        <th colspan="2"><input type="submit" value="Отправить" /></th>
    </tr>
    </table>
    </form>
