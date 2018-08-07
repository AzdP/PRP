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
input,textarea        { font-family: Verdana; font-size: 10px }
-->
</style>
<map name="1">
<area href="index.php?x={u_x}&y={move_up}" shape="rect" coords="40,2,125,31">
<area href="index.php?x={move_left}&y={u_y}" shape="rect" coords="28,30,66,67">
<area href="index.php?x={move_right}&y={u_y}" shape="rect" coords="99,30,132,64">
<area href="index.php?x={u_x}&y={move_down}" shape="rect" coords="41,66,120,92">
<area href="index.php?x={u_x}&y={u_y}" shape="circle" coords="82,48,15">
<area shape="default" nohref>
</map>
</head>

<body bgcolor="ECECEC">
<!--
<div id="dwindow" style="position:absolute;background-color:#EBEBEB;cursor:hand;left:0px;top:0px;display:none;z-index:1000;" onMousedown="initializedrag(event)" onMouseup="stopdrag()" onSelectStart="return false">
<div align="right" style="background-color:navy"><img src="images/max.gif" id="maxname" onClick="maximize()"><img src="images/close.gif" onClick="closeit()"></div>
<div id="dwindowcontent" style="height:100%"></div>
-->
<table border="1" bordercolor="606060" width="750" style="border-collapse: collapse" height="110">
  <tr>
    <td bgcolor="99A9C5" height="100">
    <img border="0" src="images/logo.gif" width="450" height="100"></td>
  </tr>
  <tr>
    <td>
    <!-- Main Content -->
    <table border="0" height="500" width="752">
      <tr>
        <td valign="top" width="184">
        <!-- content boxes -->
        <table border="1" cellpadding="1" cellspacing="0" bordercolor="#111111" width="140" style="border-collapse: collapse">
          <tr>
            <td background="images/tbl_middle.png" height="12"><center>
            <b>Menu</b></center></td>
          </tr>
          <tr>
            <td>
            <img src="images/arrow.gif" width="20" height="7"><a href="#" onClick="window.open('module.php?mid=updatecache', 'update_cache', 'directories=no,height=200,width=400,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')">Update Cache</a>
            <img src="images/line.gif" width="174" height="2"><br />
            <img src="images/arrow.gif" width="20" height="7">Export World
            <img src="images/line.gif" width="174" height="2"><br />
            <img src="images/arrow.gif" width="20" height="7">Import World
            <img src="images/line.gif" width="174" height="2"><br />
            <img src="images/arrow.gif" width="20" height="7"><a href="index.php?clipping=1">Toggle Clipping</a><br />
            <img src="images/line.gif" width="174" height="2"><br />
            <img src="images/arrow.gif" width="20" height="7"><a href="#" onClick="window.open('module.php?mid=dialogue', 'dialogue', 'directories=no,height=300,width=450,location=no,resizable=yes,status=no,titlebar=no,toolbar=no,scrollbars=yes')">Dialogue Editor</a>
            <img src="images/line.gif" width="174" height="2"><br />
            <img src="images/arrow.gif" width="20" height="7"><a href="#" onClick="window.open('module.php?mid=weapons', 'weapons', 'directories=no,height=300,width=450,location=no,resizable=yes,status=no,titlebar=no,toolbar=no,scrollbars=yes')">Weapons Editor</a>
            </td>
            </tr>
            </table>
                <br />
                <br />
                        <table border="1" cellpadding="1" cellspacing="0" bordercolor="#111111" width="140" style="border-collapse: collapse">
          <tr>
            <td background="images/tbl_middle.png" height="12"><center>
            <b>Tasks</b></center></td>
          </tr>
          <tr>
            <td>
            <img src="images/arrow.gif" width="20" height="7"><a href="#" onClick="window.open('module.php?mid=makeNPC', 'makenpc', 'directories=no,height=400,width=400,location=no,resizable=yes,status=no,titlebar=no,toolbar=no,scrollbars=yes')">Create NPC</a>
            <img src="images/line.gif" width="174" height="2"><br />
            <img src="images/arrow.gif" width="20" height="7">Create Monster
            <img src="images/line.gif" width="174" height="2"><br />
            <img src="images/arrow.gif" width="20" height="7"><a href="#" onClick="window.open('module.php?mid=newsector', 'new_sector', 'directories=no,height=300,width=400,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')">Create New Sector</a>
            <img src="images/line.gif" width="174" height="2"><br />
            <img src="images/arrow.gif" width="20" height="7"><a href="#" onClick="window.open('module.php?mid=sectorproperties', 'sector_properties', 'directories=no,height=300,width=400,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')">Current Sector
            Properties</a>
            <img src="images/line.gif" width="174" height="2"><br />
            <img src="images/arrow.gif" width="20" height="7"><a href="#" onClick="window.open('module.php?mid=changesector', 'change_sector', 'directories=no,height=200,width=400,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')">Change Sector</a></td>
            </tr>
            </table>
            <br />
            <br />
                <table border="1" cellpadding="1" width="178" cellspacing="0" bordercolor="#111111" width="140" style="border-collapse: collapse" height="166">
                  <tr>
                    <td background="images/tbl_middle.png" height="12"><center>
                    <b>Place Items</b></center></td>
                  </tr>
                  <tr>
                    <td align="center" height="149">
                    <input type="button" value="Terrain" onClick="window.open('module.php?mid=terrain', 'add_Terrain', 'directories=no,height=200,width=400,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')"><br><br>
                    <input type="button" value="Building" onClick="window.open('module.php?mid=addbuilding', 'add_Terrain', 'directories=no,height=300,width=400,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')"><br><br>
                    <input type="button" value="Monster"><br><br>
                    <input type="button" value="NPC"> </td>
                  </tr>
                </table>
                </td>
                <td valign="top" width="564">
                <table border="0" width="558" height="369">
                  <tr>
                    <td align="center" width="552" height="353">
                    <div align="left">
                      <table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
                        <tr>
                          <td valign="top">
                           {main}
                          </td>
                          <td width="50%" valign="top">
                          <table border="1" cellspacing="0" bordercolor="#111111" width="100%" style="border-collapse: collapse" height="135">
                            <tr>
                              <td background="images/tbl_middle.png" height="12">
                              <center><b>Move</b></center></td>
                            </tr>
                            <tr>
                              <td height="122">
                              <p align="left">
                              <img border="0" usemap=#1 src="images/move.gif" width="144" height="98"></p>
                              </td>
                            </tr>
                          </table>
                          <br>
                          <br>
                          <table border="1" cellspacing="0" bordercolor="#111111" width="100%" style="border-collapse: collapse">
                            <tr>
                              <td background="images/tbl_middle.png" height="12">
                              <center><b>Controls</b></center></td>
                            </tr>
                            <tr>
                              <td height="50">
                                <p align="center">
                              <form action="index.php" method="post">Move <input value="{pixel_moves}" size="3" type="text" name="pixs_move" > Pixels<input value="Enter" type="submit" name="Enter" ></form>
                              <form action="index.php" method="post"><input value="{grab_button}" type="submit" name="grab" {grab_disabled}></form>
                              <form action="index.php" method="post"><input value="Delete Object" type="submit" name="delete" {del_disabled}></form>
                              <form action="index.php" method="post"><input value="Clip/Unclip" type="submit" name="clip"></form>
                                </p>
                              </td>
                            </tr>
                          </table>
                          <br>
                          <br>
                          <table border="1" cellspacing="0" bordercolor="#111111" width="100%" style="border-collapse: collapse" height="135">
                            <tr>
                              <td background="images/tbl_middle.png" height="12">
                              <center><b>System</b></center></td>
                            </tr>
                            <tr>
                              <td height="122" align="center">
                              {system_msg}
                              </td>
                            </tr>
                          </table>
                          </td>
                        </tr>
                      </table>
                    </div>
                    </td>
                  </tr>
                  </table>
                </td>
                </tr>
              </table>
              </td>
            </tr>
            </table>

            </body>

            </html>
