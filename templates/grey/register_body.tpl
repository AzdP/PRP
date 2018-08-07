<style type="text/css">
input {
font: 10px verdana,arial;
}
</style>
<form action="register.php" method="post">
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#859FA7" width="500" align="center" height="200" bgcolor="#F2F2F2">
<tr>
<td width="100%" align="center">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr><td colspan="2" align="left" bgcolor="99A9C5"><img src="templates/grey/images/logo.gif" border="0"></td></tr>
<table border="0" cellpadding="0" cellspacing="2" width="95%" align="center">
<tr><td bgcolor="#FFFFFF">{L_username}:</td><td bgcolor="#FFFFFF"><input type="text" name="username"></td></tr>
<tr><td bgcolor="#FFFFFF">{L_password}:</td><td bgcolor="#FFFFFF"><input type="password" name="password"></td></tr>
<tr><td bgcolor="#FFFFFF">{L_email}:</td><td bgcolor="#FFFFFF"><input type="text" name="email"></td></tr>
<tr><td bgcolor="#FFFFFF">{L_class}:</td><td bgcolor="#FFFFFF"><select name="class"><option value="Warrior">Warrior</option><option value="Mage">Mage</option></td></tr>
<tr><td bgcolor="#FFFFFF">{L_avatar}:</td><td bgcolor="#FFFFFF"><select name="char" onChange="var ImageNum = 'images/pc/' + form.char.value + '.gif'; document.images.pictures.src=ImageNum;">{char_list}</select> <img name="pictures" src="images/pc/5.gif"></td></tr>
<tr><td></td><td><input type="submit" value="{L_register}" name="submit"></td></tr>
</table>
</form>
</td>
</tr>
</table>