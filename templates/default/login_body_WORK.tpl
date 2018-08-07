<form action="login.php" method="post">
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#859FA7" width="500" align="center" height="200" bgcolor="#F2F2F2">
<tr>
<td width="100%" align="center">
<table border="0">
<tr><td>{L_username}:</td><td><input type="text" name="username"></td></tr>
<tr><td>{L_password}:</td><td><input type="password" name="password"></td></tr>
<tr><td>{L_rememberme}:</td><td><input type="checkbox" name="remember"></td></tr>
<tr><td>{L_randtext} {L_randimg}:</tl></td><input type="text" name="botcheck"></td></tr>
<input type="hidden" name="botcid" value="{L_imgidentity}">
<tr><td></td><td><input type="submit" name="submit" value="{L_login}"></td></tr>
<tr><td></td><td><a href="register.php">{L_click_register}</a></td></tr>
</table>
</td>
</tr>
</table>
</form>