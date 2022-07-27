<?php
/************************************************************************
*
* exoGameCtl - Half-Life Server Control Panel
* Copyright (c)2002-2003 Jeff Dodge Technologies.  All Rights Reserved.
*
*************************************************************************
*
*       Author: Jeffrey J. Dodge
*        Email: info@exocontrol.com
*          Web: http://www.exocontrol.com
*     Filename: gspadmin.php
*  Description: GSP Admin Area (GSP License Only)
*      Release: 2.0.7
*
*************************************************************************
*
* Please direct bug reports, suggestions, or feedback to the exoControl
* Forums.  http://www.exocontrol.com/forums
*
*************************************************************************
*
* This software is furnished under a license and may be used and copied
* only  in  accordance  with  the  terms  of such  license and with the
* inclusion of the above copyright notice. This software or any other
* copies thereof may not be provided or otherwise made available to any
* other person. No title to and ownership of the software is hereby
* transferred.
*
* Please see the LICENSE file for the full End User License Agreement
*
*************************************************************************
* $Id: gspadmin.php,v 2.12 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   include_once("includes/functions.inc.php");
   $page_name = "GSP Admin Area";

   if (!$action)
   {
      if ($REQUEST_METHOD == "POST")
      {
         if (md5($adminpw) == $gspkey)
         {
            echo "<script language=\"JavaScript\" src=\"js/display.js\"></script>";
            echo "<body onLoad=\"javascript:openWindow('gspadmin.php?action=list&key=" . md5($adminpw) . "&page=1','gsp','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=666,height=600');\">";
            echo "<font face=\"Verdana\" size=\"1\"><b>Launching Admin Window</b><br>If it does not load that means you have a pop-up killer on, please disable it.</font>";
            exit;
         }
         else
         {
            $status = "bad password";
         }
      }

      echo "<html>\n<head>";
      echo "<title>exoGameCtl .:. GSP Admin Area</title>\n";
      echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">";
      echo "<link rel=\"stylesheet\" href=\"css/base.css\" type=\"text/css\">";
      echo "</head>\n";
      echo "<body bgcolor=\"$ffffff\" text=\"Verdana\">";
      echo "<b><u>exoGameCtl .:. GSP Administrator Login</u></b><br><br>";
      echo "Please enter the admin password to launch the GSP Admin Area.  Once you have entered the correct password<br>a new window will pop open and will allow you to add/modify/remove game servers..";
      echo "<font color=red><br><br>$status<br><br></font>";
      echo "<form method=\"post\" action=\"gspadmin.php\">";
      echo "Admin Password:<br><input type=\"password\" class=\"input\" name=\"adminpw\" size=\"25\">&nbsp;&nbsp;<input type=\"submit\" value=\"Admin Login\" class=\"input\">";
      echo "</form>";
      exit;
   }
   elseif ($action == "list")
   {
      if ($key != $gspkey)
      {
         echo "invalid key";
         exit;
      }
      $total_servers = TotalServers($dbh);
      $servers = GetAllServers($dbh, $page, 15);
      $page_string = CreatePageString($dbh, $page, "gspadmin.php?action=list&key=$key", 15, $total_servers);

      if ($from == "delete")
      {
         $alert = 1;
         $message = "$product\\n\\nServer Successfully Deleted!";
      }
      elseif ($from == "update")
      {
         $alert = 1;
         $message = "$product\\n\\nServer Configuration Successfully Updated!";
      }
   }
   elseif ($action == "add")
   {
      if ($key != $gspkey)
      {
         echo "invalid key";
         exit;
      }

      if ($REQUEST_METHOD == "POST")
      {
         AddServer($dbh, $frm_login, $frm_password, $frm_server_addr, $frm_server_port, $frm_server_rcon, $frm_hltv_enable, $frm_hltv_addr, $frm_hltv_port, $frm_hltv_rcon, $frm_hltv_config, $frm_ftp_enable, $frm_ftp_addr, $frm_ftp_port, $frm_ftp_login, $frm_ftp_password, $frm_test_enable, $frm_control_enable, $frm_unix_enable, $frm_unix_addr, $frm_unix_login, $frm_unix_password, $current_mod, $frm_server_config, $frm_server_motd, $frm_server_mapcycle, $frm_server_mappath, $frm_metamod_plugins, $frm_adminmod_config, $frm_adminmod_plugins, $frm_adminmod_users, $frm_statsme_config, $frm_statsme_motd, $frm_clanmod_config, $frm_hlguard_config, $frm_plbot_config);
         header("location: gspadmin.php?action=list&key=$key&from=update&page=$page");
      }
   }
   elseif ($action == "edit")
   {
      if ($key != $gspkey)
      {
         echo "invalid key";
         exit;
      }
      if ($id)
      {
         $this_server = GetServerById($dbh, $id);
         $this_server = $this_server[0];
      }

      if ($REQUEST_METHOD == "POST")
      {
         UpdateServer($dbh, $id, $frm_login, $frm_password, $frm_server_addr, $frm_server_port, $frm_server_rcon, $frm_hltv_enable, $frm_hltv_addr, $frm_hltv_port, $frm_hltv_rcon, $frm_hltv_config, $frm_ftp_enable, $frm_ftp_addr, $frm_ftp_port, $frm_ftp_login, $frm_ftp_password, $frm_test_enable, $frm_control_enable, $frm_unix_enable, $frm_unix_addr, $frm_unix_login, $frm_unix_password, $current_mod, $frm_server_config, $frm_server_motd, $frm_server_mapcycle, $frm_server_mappath, $frm_metamod_plugins, $frm_adminmod_config, $frm_adminmod_plugins, $frm_adminmod_users, $frm_statsme_config, $frm_statsme_motd, $frm_clanmod_config, $frm_hlguard_config, $frm_plbot_config);
         header("location: gspadmin.php?action=list&key=$key&from=update&page=$page");
      }
   }
   elseif ($action == "delete")
   {
      if ($key != $gspkey)
      {
         echo "invalid key";
         exit;
      }
      DeleteServer($dbh, $id);
      header("location: gspadmin.php?action=list&key=$key&from=delete&page=$page");
   }

   $mod_list = array(
      "01" => "Counter-Strike",
      "02" => "Day of Defeat",
      "03" => "Team Fortress Classic"
   );

   function hl_mods($hl_mod)
   {
      global $mod_list;

      while (list ($key, $value) = each ($mod_list))
      {
         if ($key == "$hl_mod")
            $output .= "<option value=\"$key\" selected>$value</option>";
         else
            $output .= "<option value=\"$key\">$value</option>";
      }
      reset($mod_list);
      return $output;
   }
?>
<html>
<head>
<title><?php echo $product . " .:. " . $page_name ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/base.css" type="text/css">
<script language="JavaScript" src="js/display.js"></script>
<script language="JavaScript">
<!--
   function do_alert()
   {
      if (<?php if (!$alert) { echo "0"; } else { echo "1"; } ?>)
         alert('<?php echo $message; ?>');
   }
   function getSelectedValue(selectName)
   {
      var select = document.getElementById(selectName);
      return select.options[select.selectedIndex].value;
   }
   function selectValue()
   {
      var item = getSelectedValue("current_mod");

      if ( item == "01" )
      {
         document.form.frm_server_config.value = "hlds_l/cstrike/server.cfg";
         document.form.frm_server_motd.value = "hlds_l/cstrike/motd.txt";
         document.form.frm_server_mapcycle.value = "hlds_l/cstrike/mapcycle.txt";
         document.form.frm_server_mappath.value = "hlds_l/cstrike/maps";
         document.form.frm_metamod_plugins.value = "hlds_l/cstrike/addons/metamod/plugins.ini";
         document.form.frm_adminmod_config.value = "hlds_l/cstrike/addons/adminmod/config/adminmod.cfg";
         document.form.frm_adminmod_plugins.value = "hlds_l/cstrike/addons/adminmod/config/plugin.ini";
         document.form.frm_adminmod_users.value = "hlds_l/cstrike/addons/adminmod/config/users.ini";
         document.form.frm_statsme_config.value = "hlds_l/cstrike/addons/statsme/statsme.cfg";
         document.form.frm_statsme_motd.value = "hlds_l/cstrike/addons/statsme/motd.cfg";
         document.form.frm_clanmod_config.value = "hlds_l/cstrike/addons/clanmod/clanmod.cfg";
         document.form.frm_hlguard_config.value = "hlds_l/cstrike/addons/hlguard/hlguard.cfg";
         document.form.frm_plbot_config.value = "hlds_l/cstrike/addons/plbot/plbot.cfg";
      }
      else if ( item == "02")
      {
         document.form.frm_server_config.value = "hlds_l/dod/server.cfg";
         document.form.frm_server_motd.value = "hlds_l/dod/motd.txt";
         document.form.frm_server_mapcycle.value = "hlds_l/dod/mapcycle.txt";
         document.form.frm_server_mappath.value = "hlds_l/dod/maps";
         document.form.frm_metamod_plugins.value = "hlds_l/dod/addons/metamod/plugins.ini";
         document.form.frm_adminmod_config.value = "hlds_l/dod/addons/adminmod/config/adminmod.cfg";
         document.form.frm_adminmod_plugins.value = "hlds_l/dod/addons/adminmod/config/plugin.ini";
         document.form.frm_adminmod_users.value = "hlds_l/dod/addons/adminmod/config/users.ini";
         document.form.frm_statsme_config.value = "hlds_l/dod/addons/statsme/statsme.cfg";
         document.form.frm_statsme_motd.value = "hlds_l/dod/addons/statsme/motd.cfg";
         document.form.frm_clanmod_config.value = "hlds_l/dod/addons/clanmod/clanmod.cfg";
         document.form.frm_hlguard_config.value = "hlds_l/dod/addons/hlguard/hlguard.cfg";
         document.form.frm_plbot_config.value = "hlds_l/dod/addons/plbot/plbot.cfg";
      }
      else if ( item == "03")
      {
         document.form.frm_server_config.value = "hlds_l/tfc/server.cfg";
         document.form.frm_server_motd.value = "hlds_l/tfc/motd.txt";
         document.form.frm_server_mapcycle.value = "hlds_l/tfc/mapcycle.txt";
         document.form.frm_server_mappath.value = "hlds_l/tfc/maps";
         document.form.frm_metamod_plugins.value = "hlds_l/tfc/addons/metamod/plugins.ini";
         document.form.frm_adminmod_config.value = "hlds_l/tfc/addons/adminmod/config/adminmod.cfg";
         document.form.frm_adminmod_plugins.value = "hlds_l/tfc/addons/adminmod/config/plugin.ini";
         document.form.frm_adminmod_users.value = "hlds_l/tfc/addons/adminmod/config/users.ini";
         document.form.frm_statsme_config.value = "hlds_l/tfc/addons/statsme/statsme.cfg";
         document.form.frm_statsme_motd.value = "hlds_l/tfc/addons/statsme/motd.cfg";
         document.form.frm_clanmod_config.value = "hlds_l/tfc/addons/clanmod/clanmod.cfg";
         document.form.frm_hlguard_config.value = "hlds_l/tfc/addons/hlguard/hlguard.cfg";
         document.form.frm_plbot_config.value = "hlds_l/tfc/addons/plbot/plbot.cfg";
      }
   }
//-->
</script>
</head>

<body bgcolor="#dfdedf" background="images/bgtests.gif" onLoad="do_alert(); <?php if ($action != "edit"): ?>selectValue();<?php endif; ?>">
<table width="95%">
<tr>
   <td>
   <font face="Verdana" size="1"><font size="2"><b><u><?php echo $product ?> .:. GSP Admin Area</u></b></font>
   <br><br>
<?php if ($action == "list"): ?>
   This is where you will add, modify, and delete the servers controled by your copy of exoGameCtl.
   <br><br>
   <?php if ((count($servers) < $licdata[maxservers]) || (!$licdata[maxservers])): ?>
   [ <a href="gspadmin.php?action=add&key=<?php echo $key ?>&page=<?php echo $page ?>">add server</a> | <a href="javascript:window.close()">exit admin</a> ]
   <?php else: ?>
   [ <a href="javascript:window.close()">exit admin</a> ]
   <? endif; ?>
   <br><br>
   <table cellspacing=1 cellpadding=2 border=0 width="95%" bgColor="#000000">
   <tr bgcolor="#5d5d5d">
      <td><font color="#ffffff"><b>ID</b></font></td>
      <td><font color="#ffffff"><b>Login (edit user)</b></font></td>
      <td><font color="#ffffff"><b>Password</b></font></td>
      <td><font color="#ffffff"><b>Server IP/Port (info)</b></font></td>
      <td><font color="#ffffff"><b>RCON Password</b></font></td>
   </tr>
<?php
   for ($c = 0; $c < count($servers); ++$c)
   {
      $this_server = $servers[$c];

      $bgcolor = "#eeeeee";
      if ($c % 2)
      {
         $bgcolor = "#f5f5f5";
      }

      echo "   <tr>\n";
      echo "      <td bgcolor=\"$bgcolor\">$this_server[server_id]</td>\n";
      echo "      <td bgcolor=\"$bgcolor\"><a href=\"gspadmin.php?action=edit&key=$key&id=$this_server[server_id]&page=$page\">$this_server[login]</a></td>\n";
      echo "      <td bgcolor=\"$bgcolor\">$this_server[password]</td>\n";
      echo "      <td bgcolor=\"$bgcolor\"><a href=\"pubinfo.php?login=$this_server[login]\" target=\"new\">$this_server[server_addr]:$this_server[server_port]</a></td>\n";
      echo "      <td bgcolor=\"$bgcolor\">$this_server[server_rcon]</td>\n";
      echo "   </tr>\n";
   }
?>
   </td>
   </table>
   [ Page: <?php echo $page_string ?> | Max Servers
<?php if (($licdata[product_edition] == "GSP License") || ($licdata[product_edition] == "ISP License") || ($licdata[product_edition] == "Source License")): ?>
<b><?php if (!$licdata[maxservers]) { echo "Unlimited"; } elseif (count($servers) == $licdata[maxservers]) { echo "<font color=red>$licdata[maxservers]</font>"; } else { echo $licdata[maxservers]; } ?></b> ]
<? endif; ?>
<?php elseif ($action == "add"): ?>
   Please enter all of the following information below about the users game server.  If a config file is not available just leave the field blank.  If you do not wish to dit this user click <a href="gspadmin.php?action=list&key=<?php echo $key ?>&page=<?php echo $page ?>">here</a>.
   <br>
   <form method="post" action="gspadmin.php?action=add&key=<?php echo $key ?>&page=<?php echo $page ?>" name="form">
   <table cellspacing=1 cellpadding=2 border=0>
   <tr>
      <td colspan="4"><b>Login Information</b></td>
   </tr>
   <tr>
      <td>Login:</td>
      <td><input type="text" class="input" name="frm_login" size="30" maxlength="25"></td>
   </tr>
   <tr>
      <td>Password:</td>
      <td><input type="text" class="input" name="frm_password" size="30" maxlength="25"></td>
   </tr>
   <tr>
      <td colspan="4"><br><b>Gameserver Information</b></td>
   </tr>
   <tr>
      <td>Server Address:</td>
      <td><input type="text" class="input" name="frm_server_addr" size="50"></td>
   </tr>
   <tr>
      <td>Server Port:</td>
      <td><input type="text" class="input" name="frm_server_port" size="10" value="27015"></td>
   </tr>
   <tr>
      <td>RCON Password:</td>
      <td><input type="text" class="input" name="frm_server_rcon" size="25"></td>
   </tr>
   <tr>
      <td>Enable HLTV Control:</td>
      <td>
      <input type="radio" name="frm_hltv_enable" value="1" checked>Yes
      <input type="radio" name="frm_hltv_enable" value="0">No
      </td>
   </tr>
   <tr>
      <td>HLTV Address:</td>
      <td><input type="text" class="input" name="frm_hltv_addr" size="50"></td>
   </tr>
   <tr>
      <td>HLTV Port:</td>
      <td><input type="text" class="input" name="frm_hltv_port" size="10" value="27020"></td>
   </tr>
   <tr>
      <td>HLTV RCON Password:</td>
      <td><input type="text" class="input" name="frm_hltv_rcon" size="25"></td>
   </tr>
   <tr>
      <td>HLTV Configuration File (hltv.cfg)</td>
      <td><input type="text" class="input" name="frm_hltv_config" size="65" value="hlds_l/hltv.cfg"></td>
   </tr>
   <tr>
      <td colspan="4"><br><b>FTP Information</b></td>
   </tr>
   <tr>
      <td>FTP Config Files?</td>
      <td>
      <input type="radio" name="frm_ftp_enable" value="1" checked>Yes
      <input type="radio" name="frm_ftp_enable" value="0">No
      </td>
   </tr>
   <tr>
      <td>FTP Address:</td>
      <td><input type="text" class="input" name="frm_ftp_addr" size="35"></td>
   </tr>
   <tr>
      <td>FTP Port:</td>
      <td><input type="text" class="input" name="frm_ftp_port" size="10" maxlength="5" value="21">
   </tr>
   <tr>
      <td>FTP Login:</td>
      <td><input type="text" class="input" name="frm_ftp_login" size="25"></td>
   </tr>
   <tr>
      <td>FTP Password:</td>
      <td><input type="text" class="input" name="frm_ftp_password" size="25"></td>
   </tr>
   <tr>
      <td colspan="2"><br><b><u>Misc Configuration</u></b></td>
   </tr>
   <tr>
      <td>Allow Ping/BW Test?</td>
      <td>
      <input type="radio" name="frm_test_enable" value="1" checked>Yes
      <input type="radio" name="frm_test_enable" value="0">No
      </td>
   </tr>
   <tr>
      <td>Allow Remote Control?</td>
      <td>
      <input type="radio" name="frm_control_enable" value="1">Yes
      <input type="radio" name="frm_control_enable" value="0" checked>No
      </td>
   </tr>
   <tr>
      <td>Allow UNIX Logins?</td>
      <td>
      <input type="radio" name="frm_unix_enable" value="1">Yes
      <input type="radio" name="frm_unix_enable" value="0" checked>No
      </td>
   </tr>
   <tr>
      <td>UNIX Host:</td>
      <td><input type="text" class="input" name="frm_unix_addr" size="35" value="<?php echo $HTTP_HOST ?>"></td>
   </tr>
   <tr>
      <td>UNIX Login:</td>
      <td><input type="text" class="input" name="frm_unix_login" size="25" maxlength="20"></td>
   </tr>
   <tr>
      <td>UNIX Password:</td>
      <td><input type="text" class="input" name="frm_unix_password" size="25" maxlength="20"></td>
   </tr>
   <tr>
      <td colspan="2"><br><b><u>File/Path Configuration</u></b></td>
   </tr>
   <tr>
      <td>Half-Life Module Name:</td>
      <td><select class="select" name="current_mod" onChange="selectValue()"><?php echo hl_mods($current_mod) ?></select></td>
   </tr>
   <tr>
      <td>Server Config (server.cfg):</td>
      <td><input type="text" class="input" name="frm_server_config" size="65"></td>
   </tr>
   <tr>
      <td>Server MOTD (motd.txt):</td>
      <td><input type="text" class="input" name="frm_server_motd" size="65">
   </tr>
   <tr>
      <td>Server Map Cycle (mapcycle.txt):</td>
      <td><input type="text" class="input" name="frm_server_mapcycle" size="65"></td>
   </tr>
   <tr>
      <td>Server Map Path:</td>
      <td><input type="text" class="input" name="frm_server_mappath" size="65"></td>
   </tr>
   <tr>
      <td>MetaMod Plugins (plugins.ini):</td>
      <td><input type="text" class="input" name="frm_metamod_plugins" size="65"></td>
   </tr>
   <tr>
      <td>AdminMod Config (adminmod.cfg):</td>
      <td><input type="text" class="input" name="frm_adminmod_config" size="65"></td>
   </tr>
   <tr>
      <td>AdminMod Plugins (plugin.ini):</td>
      <td><input type="text" class="input" name="frm_adminmod_plugins" size="65"></td>
   </tr>
   <tr>
      <td>AdminMod Users (users.ini):</td>
      <td><input type="text" class="input" name="frm_adminmod_users" size="65"></td>
   </tr>
   <tr>
      <td>StatsMe Config (statsme.cfg):</td>
      <td><input type="text" class="input" name="frm_statsme_config" size="65"></td>
   </tr>
   <tr>
      <td>StatsMe MOTD (motd.cfg):</td>
      <td><input type="text" class="input" name="frm_statsme_motd" size="65"></td>
   </tr>
   <tr>
      <td>ClanMod Config (clanmod.cfg):</td>
      <td><input type="text" class="input" name="frm_clanmod_config" size="65"></td>
   </tr>
   <tr>
      <td>HLGuard Config (hlguard.cfg):</td>
      <td><input type="text" class="input" name="frm_hlguard_config" size="65"></td>
   </tr>
   <tr>
      <td>PLBot Config (plbot.cfg):</td>
      <td><input type="text" class="input" name="frm_plbot_config" size="65"></td>
   </tr>
   <tr>
      <td colspan="4"><br>
      <table>
      <tr>
         <td><input type="submit" class="button" value="Add Server"></form></td>
      </tr>
      </table>
      </td>
   </tr>
   </table>


<?php elseif ($action == "edit"): ?>
   Please enter all of the following information below about the users game server.  If a config file is not available just leave the field blank.  If you do not wish to dit this user click <a href="gspadmin.php?action=list&key=<?php echo $key ?>&page=<?php echo $page ?>">here</a>.
   <br>
   <form method="post" action="gspadmin.php?action=edit&key=<?php echo $key ?>&id=<?php echo $id ?>&page=<?php echo $page ?>" name="form">
   <table cellspacing=1 cellpadding=2 border=0>
   <tr>
      <td colspan="4"><b>Login Information</b></td>
   </tr>
   <tr>
      <td>Login:</td>
      <td><input type="text" class="input" name="frm_login" size="30" maxlength="25" value="<?php echo $this_server[login] ?>"></td>
   </tr>
   <tr>
      <td>Password:</td>
      <td><input type="text" class="input" name="frm_password" size="30" maxlength="25" value="<?php echo $this_server[password] ?>"></td>
   </tr>

   <tr>
      <td colspan="4"><br><b>Gameserver Information</b></td>
   </tr>
   <tr>
      <td>Server Address:</td>
      <td><input type="text" class="input" name="frm_server_addr" size="50" value="<?php echo $this_server[server_addr] ?>"></td>
   </tr>
   <tr>
      <td>Server Port:</td>
      <td><input type="text" class="input" name="frm_server_port" size="10" value="<?php echo $this_server[server_port] ?>"></td>
   </tr>
   <tr>
      <td>RCON Password:</td>
      <td><input type="text" class="input" name="frm_server_rcon" size="25" value="<?php echo $this_server[server_rcon] ?>"></td>
   </tr>
   <tr>
      <td>Enable HLTV Control:</td>
      <td>
      <input type="radio" name="frm_hltv_enable" value="1" <?php if ($this_server[hltv_enable]): ?>checked<?php endif; ?>>Yes
      <input type="radio" name="frm_hltv_enable" value="0" <?php if (!$this_server[hltv_enable]): ?>checked<?php endif; ?>>No
      </td>
   </tr>
   <tr>
      <td>HLTV Address:</td>
      <td><input type="text" class="input" name="frm_hltv_addr" size="50" value="<?php echo $this_server[hltv_addr] ?>"></td>
   </tr>
   <tr>
      <td>HLTV Port:</td>
      <td><input type="text" class="input" name="frm_hltv_port" size="10" value="<?php echo $this_server[hltv_port] ?>"></td>
   </tr>
   <tr>
      <td>HLTV RCON Password:</td>
      <td><input type="text" class="input" name="frm_hltv_rcon" size="25" value="<?php echo $this_server[hltv_rcon] ?>"></td>
   </tr>
   <tr>
      <td>HLTV Configuration File (hltv.cfg)</td>
      <td><input type="text" class="input" name="frm_hltv_config" size="65" value="<?php echo $this_server[hltv_config] ?>"></td>
   </tr>

   <tr>
      <td colspan="4"><br><b>FTP Information</b></td>
   </tr>
   <tr>
      <td>FTP Config Files?</td>
      <td>
      <input type="radio" name="frm_ftp_enable" value="1" <?php if ($this_server[ftp_enable]): ?>checked<?php endif; ?>>Yes
      <input type="radio" name="frm_ftp_enable" value="0" <?php if (!$this_server[ftp_enable]): ?>checked<?php endif; ?>>No
      </td>
   </tr>
   <tr>
      <td>FTP Address:</td>
      <td><input type="text" class="input" name="frm_ftp_addr" size="35" value="<?php echo $this_server[ftp_addr] ?>"></td>
   </tr>
   <tr>
      <td>FTP Port:</td>
      <td><input type="text" class="input" name="frm_ftp_port" size="10" maxlength="5" value="<?php echo $this_server[ftp_port] ?>">
   </tr>
   <tr>
      <td>FTP Login:</td>
      <td><input type="text" class="input" name="frm_ftp_login" size="25" value="<?php echo $this_server[ftp_login] ?>"></td>
   </tr>
   <tr>
      <td>FTP Password:</td>
      <td><input type="text" class="input" name="frm_ftp_password" size="25" value="<?php echo $this_server[ftp_password] ?>"></td>
   </tr>
   <tr>
      <td colspan="2"><br><b><u>Misc Configuration</u></b></td>
   </tr>
   <tr>
      <td>Allow Ping/BW Test?</td>
      <td>
      <input type="radio" name="frm_test_enable" value="1" <?php if ($this_server[test_enable]): ?>checked<?php endif; ?>>Yes
      <input type="radio" name="frm_test_enable" value="0" <?php if (!$this_server[test_enable]): ?>checked<?php endif; ?>>No
      </td>
   </tr>
   <tr>
      <td>Allow Remote Control?</td>
      <td>
      <input type="radio" name="frm_control_enable" value="1" <?php if ($this_server[control_enable]): ?>checked<?php endif; ?>>Yes
      <input type="radio" name="frm_control_enable" value="0" <?php if (!$this_server[control_enable]): ?>checked<?php endif; ?>>No
      </td>
   </tr>
   <tr>
      <td>Allow UNIX Logins?</td>
      <td>
      <input type="radio" name="frm_unix_enable" value="1" <?php if ($this_server[unix_enable]): ?>checked<?php endif; ?>>Yes
      <input type="radio" name="frm_unix_enable" value="0" <?php if (!$this_server[unix_enable]): ?>checked<?php endif; ?>>No
      </td>
   </tr>
   <tr>
      <td>UNIX Host:</td>
      <td><input type="text" class="input" name="frm_unix_addr" size="35" value="<?php echo $this_server[unix_addr] ?>"></td>
   </tr>
   <tr>
      <td>UNIX Login:</td>
      <td><input type="text" class="input" name="frm_unix_login" size="25" maxlength="20" value="<?php echo $this_server[unix_login] ?>"></td>
   </tr>
   <tr>
      <td>UNIX Password:</td>
      <td><input type="text" class="input" name="frm_unix_password" size="25" maxlength="20" value="<?php echo $this_server[unix_password] ?>"></td>
   </tr>
   <tr>
      <td colspan="2"><br><b><u>File/Path Configuration</u></b></td>
   </tr>
   <tr>
      <td>Half-Life Module Name:</td>
      <td><select class="select" name="current_mod" onChange="selectValue()"><?php echo hl_mods($this_server[current_mod]) ?></select></td>
   </tr>
   <tr>
      <td>Server Config (server.cfg):</td>
      <td><input type="text" class="input" name="frm_server_config" size="65" value="<?php echo $this_server[server_config] ?>" ></td>
   </tr>
   <tr>
      <td>Server MOTD (motd.txt):</td>
      <td><input type="text" class="input" name="frm_server_motd" size="65" value="<?php echo $this_server[server_motd] ?>">
   </tr>
   <tr>
      <td>Server Map Cycle (mapcycle.txt):</td>
      <td><input type="text" class="input" name="frm_server_mapcycle" size="65" value="<?php echo $this_server[server_mapcycle] ?>"></td>
   </tr>
   <tr>
      <td>Server Map Path:</td>
      <td><input type="text" class="input" name="frm_server_mappath" size="65" value="<?php echo $this_server[server_mappath] ?>"></td>
   </tr>
   <tr>
      <td>MetaMod Plugins (plugins.ini):</td>
      <td><input type="text" class="input" name="frm_metamod_plugins" size="65" value="<?php echo $this_server[metamod_plugins] ?>"></td>
   </tr>
   <tr>
      <td>AdminMod Config (adminmod.cfg):</td>
      <td><input type="text" class="input" name="frm_adminmod_config" size="65" value="<?php echo $this_server[adminmod_config] ?>"></td>
   </tr>
   <tr>
      <td>AdminMod Plugins (plugin.ini):</td>
      <td><input type="text" class="input" name="frm_adminmod_plugins" size="65" value="<?php echo $this_server[adminmod_plugins] ?>"></td>
   </tr>
   <tr>
      <td>AdminMod Users (users.ini):</td>
      <td><input type="text" class="input" name="frm_adminmod_users" size="65" value="<?php echo $this_server[adminmod_users] ?>"></td>
   </tr>
   <tr>
      <td>StatsMe Config (statsme.cfg):</td>
      <td><input type="text" class="input" name="frm_statsme_config" size="65" value="<?php echo $this_server[statsme_config] ?>"></td>
   </tr>
   <tr>
      <td>StatsMe MOTD (motd.cfg):</td>
      <td><input type="text" class="input" name="frm_statsme_motd" size="65" value="<?php echo $this_server[statsme_motd] ?>"></td>
   </tr>
   <tr>
      <td>ClanMod Config (clanmod.cfg):</td>
      <td><input type="text" class="input" name="frm_clanmod_config" size="65" value="<?php echo $this_server[clanmod_config] ?>"></td>
   </tr>
   <tr>
      <td>HLGuard Config (hlguard.cfg):</td>
      <td><input type="text" class="input" name="frm_hlguard_config" size="65" value="<?php echo $this_server[hlguard_config] ?>"></td>
   </tr>
   <tr>
      <td>PLBot Config (plbot.cfg):</td>
      <td><input type="text" class="input" name="frm_plbot_config" size="65" value="<?php echo $this_server[plbot_config] ?>"></td>
   </tr>
   <tr>
      <td colspan="4"><br>
      <table>
      <tr>
         <td><input type="submit" class="button" value="Update Server"></form></td>
         <td><form method="post" action="gspadmin.php?action=delete&key=<?php echo $key ?>&id=<?php echo $id ?>&page=<?php echo $page ?>"><input type="submit" class="button" value="Delete Server"></form></td>
      </tr>
      </table>
      </td>
   </tr>
   </table>
<?php endif; ?>
<br>
   </td>
</tr>
</table>
