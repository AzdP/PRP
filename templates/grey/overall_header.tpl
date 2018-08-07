<html>

<head>
<title>PHP MMORPG</title>
<map name="1">
<area href="{move_up}" shape="rect" coords="31, 1, 124, 36">
<area href="{move_down}" shape="rect" coords="35, 71, 115, 108">
<area href="{move_right}" shape="rect" coords="93, 36, 145, 71">
<area href="{move_left}" shape="rect" coords="13, 37, 61, 71">
<area href="{move_refresh}" shape="circle" coords="77, 53, 19">
<area shape="default" nohref>
</map>
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

<body bgcolor="ffffff" onKeyPress="redir(event);">
{index_div}
<table bgcolor="ffffff" border="1" bordercolor="606060" style="border-collapse: collapse" height="110">
  <tr>
    <td bgcolor="99A9C5" height="100">
    <img border="0" src="templates/grey/images/logo.gif" width="450" height="100"></td>
  </tr>
  <tr>
    <td>
    <!-- Main Content -->
    <table border="0">
      <tr>
        <td valign="top">
        <!-- content boxes -->
        <table border="0" cellpadding="0" cellspacing="0" bordercolor="#7C98BA" width="140" style="border-collapse: collapse">
          <tr>
            <td background="templates/grey/images/tbl_middle.png" height="12"><center>
            <b>{L_player_stats}</b></center></td>
          </tr>
          <tr>
            <td bgcolor="ECECEC">
        {L_name}: {user_name}<br />
        {L_level}: {user_level}<br />
        {L_class}: {user_class}<br />
        {L_experience}: {user_exp}<br/>
        {hp_graph}
        {mp_graph}
        {L_gold}: {user_gold} <img src="templates/grey/images/gold.gif"><br />
        </td>
           </tr>
             <tr>
              <td>
<img src="templates/grey/images/tbl_bottom.png">
              </td>
            </tr>
            </table>
                <br />
            <table border="0" cellpadding="0" cellspacing="0" width="140" style="border-collapse: collapse">
          <tr>
            <td background="templates/grey/images/tbl_middle.png" height="12"><center>
            <b>{L_menu}</b></center></td>
          </tr>
          <tr>
            <td bgcolor="ECECEC">
            <a href="index.php">{L_home}</a><br>
                        <a href="member_list.php">{L_user_list}</a><br>
            <a href="javascript:loadwindow('inventory.php',500,300)">{L_inventory}</a><br>
            <a href="#">{L_options}</a><br>
            <a href="javascript:loadwindow('help.php',500,300)">{L_help}</a><br>
            <a href="logout.php">{L_logout}</a><br>
          </td>
           </tr>
             <tr>
              <td>
<img src="templates/grey/images/tbl_bottom.png">
            </td>
            </tr>
            </table>
            <br />
                <table border="0"  cellpadding="0" width="140" cellspacing="0" bordercolor="#7C98BA" width="140" style="border-collapse: collapse">
                  <tr>
                    <td background="templates/grey/images/tbl_middle.png" height="12"><center>
                    <b>{L_online}</b></center></td>
                  </tr>
                  <tr><td align="center" bgcolor="ECECEC">{online_list}
                  </td>
           </tr>
             <tr>
              <td>
<img src="templates/grey/images/tbl_bottom.png">
                  </td>
                  </tr>
                </table>
                </td>
                <td valign="top" width="100%">
                <table border="0" width="100%">
                  <tr>
                    <td align="center" width="100%">
                      <table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
                        <tr>
                          <td>
