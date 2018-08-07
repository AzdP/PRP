<center><b>{L_memberlist}</b><br /><br />
<form action="view_profile.php"><input type="text" name="id"> <input type="submit" value="search"></form>
{L_perpg}: <a href="member_list.php?perpg=20">20</a> | <a href="member_list.php?perpg=40">40</a> | <a href="member_list.php?perpg=60">60</a> | <a href="member_list.php?perpg=all">All</a><br /><br />
{back_link} || {next_link}<br /><br />
<table border="0" width="400">
<tr bgcolor="F0F0F0"><td><a href="member_list.php?order=char_img&perpg={perpg}">{L_avatar}</a></td><td><a href="member_list.php?order=name&perpg={perpg}">{L_username}</a></td><td><a href="member_list.php?order=level&perpg={perpg}">{L_level}</a></td><td><a href="member_list.php?order=class&perpg={perpg}">{L_class}</a></td><td><a href="member_list.php?order=gold&perpg={perpg}">{L_gold}</a></td></tr>
{list}
</table>
<center>
{desc_link} || {asc_link}<br />
<a href="index.php">{L_back_to_game}</a><br />
</center>