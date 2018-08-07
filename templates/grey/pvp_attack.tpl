<table border="0" bgcolor="2B3758"  width="500">
        <tr>
         <td align="center" height="150">
          <img src="images/pc/{user_image}.gif"><br />
          {user_name}<br />
          {user_hp}<br />
          <form action="pvp.php" method="post"><select name="attack"><option value="1">Punch</option>{attack_opts}</select><input type="submit" value="attack" name="submit_attack"></form>
         </td>
        </tr>

        <tr>
         <td bgcolor="3D4D7C" align="center">
          {messages}
         </td>
        </tr>

        <tr>
         <td align="center" >
          <img src="images/pc/{opp_image}.gif"><br />
          {opp_name}<br /> 
          {opp_hp}<br />
          {opp_mp}<br />
         </td>
        </tr>
</table>
