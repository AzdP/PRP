<style type="text/css">
input {
font: 10px verdana,arial;
}
</style>
<form action="login.php" method="post">
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#859FA7" width="500" align="center" height="200" bgcolor="#F2F2F2">
<tr>
<td width="100%" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td colspan="2" align="left" bgcolor="99A9C5"><img src="templates/grey/images/logo.gif" border="0"></td></tr>
<tr>
<table border="0" cellpadding="0" cellspacing="2" width="95%">
<tr>
<td bgcolor="#FFFFFF">{L_username}:</td><td bgcolor="#FFFFFF"><input type="text" name="username"></td></tr>
<tr><td bgcolor="#FFFFFF">{L_password}:</td><td bgcolor="#FFFFFF"><input type="password" name="password"></td></tr>
<tr><td bgcolor="#FFFFFF">{L_rememberme}:</td><td bgcolor="#FFFFFF"><input type="checkbox" name="remember"></td></tr>
<tr><td></td><td><input type="submit" name="submit" value="{L_login}"></td></tr>
<tr><td colspan="2" align="center"><a href="register.php">{L_click_register}</a></td></tr>
</table>
</td>
</tr>
</table>
</form>