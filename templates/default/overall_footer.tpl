Download this game for free at <a href="http://www.xphpx.net/" target="new">xphpx.net</a>
</td>
        <td width="28%" align="center">
       <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="70%" height="67">
          <tr>
            <td width="100%" height="12" background="images/header_bg.gif">
            <p align="center">{L_player_stats}</td>
          </tr>
          <tr>
            <td width="100%" height="54" background="images/nav.gif">
            <img src="images/arrow.gif">
        {L_name}: {user_name}<br />
            <img src="images/line.gif"><br>
            <img src="images/arrow.gif">
        {L_level}: {user_level}<br />
            <img src="images/line.gif"><br>
            <img src="images/arrow.gif">
        {L_class}: {user_class}<br />
            <img src="images/line.gif"><br>
            <img src="images/arrow.gif">
        {L_experience}: {user_exp}<br/>
            <img src="images/line.gif"><br>
        {hp_graph}
            <img src="images/line.gif"><br>
        {mp_graph}
            <img src="images/line.gif"><br>
            <img src="images/arrow.gif">
        {L_gold}: {user_gold}G<br />
        </td>
          </tr>
        </table>
        <br><br>
        <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="70%" height="67">
          <tr>
            <td width="100%" height="12" background="images/header_bg.gif">
            <p align="center">{L_menu}</td>
          </tr>
          <tr>
            <td width="100%" height="54" background="images/nav.gif">
            <img src="images/arrow.gif">
            <a href="#" onClick="window.open('soundplayer.php?music={music_link}','soundplayer','height=150,width=300,scrollbars=yes,resizable=yes'); return false;">{L_play_music}</a><br>
            <img src="images/line.gif"><br>
            <img src="images/arrow.gif">
            <a href="#">{L_options}</a><br>
            <img src="images/line.gif"><br>
            <img src="images/arrow.gif">
            <a href="javascript:loadwindow('inventory.php',500,300)">{L_inventory}</a><br>
            <img src="images/line.gif"><br>
            <img src="images/arrow.gif">
            <a href="javascript:loadwindow('usersonline.php',500,300)">{L_users_online}</a><br>
            <img src="images/line.gif"><br>
            <img src="images/arrow.gif">
            <a href="javascript:loadwindow('help.php',500,300)">{L_help}</a><br>
            <img src="images/line.gif"><br>
            <img src="images/arrow.gif">
            <a href="logout.php">{L_logout}</a><br>
            </td>
          </tr>
        </table>
<br><br>
       <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="70%" height="162">
          <tr>
            <td width="100%" height="12" background="images/header_bg.gif">
            <p align="center">{L_system_msg}</td>
          </tr>
          <tr>
            <td width="100%" height="150" background="images/nav.gif">
<center>
{index_message}
</center>
        </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
        </td>
  </tr>
</table>
<div id="dwindow" style="position:absolute;background-color:#EBEBEB;cursor:hand;left:0px;top:0px;display:none;z-index:1000;" onMousedown="initializedrag(event)" onMouseup="stopdrag()" onSelectStart="return false">
<div align="right" style="background-color:navy"><img src="images/max.gif" id="maxname" onClick="maximize()"><img src="images/close.gif" onClick="closeit()"></div>
<div id="dwindowcontent" style="height:100%">
<iframe id="cframe" src="" width=100% height=100%></iframe>
</div>
</div>
</body>
</html>