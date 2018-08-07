<form action="register.php" method="post">
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#859FA7" width="500" align="center" height="200" bgcolor="#F2F2F2">
<tr>
<td width="100%" align="center">
<table border="0">
<tr><td>{L_username}:</td><td><input type="text" name="username"></td></tr>
<tr><td>{L_password}:</td><td><input type="password" name="password"></td></tr>
<tr><td>{L_email}:</td><td><input type="text" name="email"></td></tr>
<tr><td>{L_class}:</td><td><select name="class"><option value="Warrior">Warrior</option><option value="Mage">Mage</option></td></tr>
<tr><td>{L_avatar}:</td><td><select name="char" onChange="var ImageNum = 'images/pc/' + form.char.value + '.gif'; document.images.pictures.src=ImageNum;">{char_list}</select> <img name="pictures" src="images/pc/5.gif"></td></tr>
<tr><td></td><td><input type="submit" value="{L_register}" name="submit"></td></tr>
</table>
</form>
</td>
</tr>
</table>