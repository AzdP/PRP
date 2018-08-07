<html>

<head>
<title>PHP MMORPG</title>
<style>
<!--
body, td {
        font-family: Verdana;
        font-size: 10px;
}
a, a:link, a:visited, a:active {
        font-family: Verdana;
        font-size: 10px; color: #51708E;
        text-decoration:none;
}
a:hover {
        font-family: Verdana;
        font-size: 10px;
        color: #51708E;
        text-decoration: underline;
}
input        { font-family: Verdana; font-size: 10px }
-->
</style>
{page_script_header}
</head>

<body bgcolor="ECECEC" onKeyPress="redir(event);">
{index_div}
<table bgcolor="DFDFDF" border="1" bordercolor="606060" width="750" style="border-collapse: collapse" height="110">
  <tr>
    <td bgcolor="99A9C5" height="100">
    <img border="0" src="templates/grey/images/logo.gif" width="450" height="100"></td>
  </tr>
  <tr>
    <td>
    <!-- Main Content -->
    <table border="0" height="500" width="752">
      <tr>
        <td valign="top" width="184">
        <!-- content boxes -->
        <table border="0" bgcolor="ECECEC" cellpadding="1" cellspacing="0" bordercolor="#7C98BA" width="140" style="border-collapse: collapse">
          <tr>
            <td background="templates/grey/images/tbl_middle.png" height="12"><center>
            <b>{L_player_stats}</b></center></td>
          </tr>
          <tr>
            <td>
            <img src="templates/grey/images/arrow.gif">
        {L_name}: {user_name}<br />
            <img src="templates/grey/images/line.gif"><br>
            <img src="templates/grey/images/arrow.gif">
        {L_level}: {user_level}<br />
            <img src="templates/grey/images/line.gif"><br>
            <img src="templates/grey/images/arrow.gif">
        {L_class}: {user_class}<br />
            <img src="templates/grey/images/line.gif"><br>
            <img src="templates/grey/images/arrow.gif">
        {L_experience}: {user_exp}<br/>
            <img src="templates/grey/images/line.gif"><br>
        {hp_graph}
            <img src="templates/grey/images/line.gif"><br>
        {mp_graph}
            <img src="templates/grey/images/line.gif"><br>
            <img src="templates/grey/images/arrow.gif">
        {L_gold}: {user_gold} <img src="templates/grey/images/gold.gif"><br />
        </td>
            </tr>
            </table>
                <br />
                <br />
            <table border="0" bgcolor="ECECEC" cellpadding="1" cellspacing="0" bordercolor="#7C98BA" width="140" style="border-collapse: collapse">
          <tr>
            <td background="templates/grey/images/tbl_middle.png" height="12"><center>
            <b>{L_menu}</b></center></td>
          </tr>
          <tr>
            <td>
            <img src="templates/grey/images/arrow.gif">
            <a href="index.php">{L_home}</a><br>
            <img src="templates/grey/images/line.gif"><br>
            <img src="templates/grey/images/arrow.gif">
			<a href="member_list.php">{L_user_list}</a><br>
            <img src="templates/grey/images/line.gif"><br>
            <img src="templates/grey/images/arrow.gif">
            <a href="javascript:loadwindow('inventory.php',500,300)">{L_inventory}</a><br>
            <img src="templates/grey/images/line.gif"><br>
            <img src="templates/grey/images/arrow.gif">
            <a href="#">{L_options}</a><br>
            <img src="templates/grey/images/line.gif"><br>
            <img src="templates/grey/images/arrow.gif">
            <a href="javascript:loadwindow('help.php',500,300)">{L_help}</a><br>
            <img src="templates/grey/images/line.gif"><br>
            <img src="templates/grey/images/arrow.gif">
            <a href="logout.php">{L_logout}</a><br>

            </td>
            </tr>
            </table>
            <br />
            <br />
                <table border="0" bgcolor="ECECEC" cellpadding="1" width="178" cellspacing="0" bordercolor="#7C98BA" width="140" style="border-collapse: collapse" height="166">
                  <tr>
                    <td background="templates/grey/images/tbl_middle.png" height="12"><center>
                    <b>{L_online}</b></center></td>
                  </tr>
                  <tr><td align="center">{online_list}</td>
                  </tr>
                </table>
                </td>
                <td valign="top" width="564">
                <table border="0" width="558">
                  <tr>
                    <td align="center" width="552">
                    <div align="left">
                      <table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
                        <tr>
                          <td>
