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
*     Filename: install.php
*  Description: exoGameCtl Installation Script
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
* $Id: install.php,v 2.28 2003/09/23 08:04:30 exodus Exp $
************************************************************************/
   require("includes/functions.inc.php");

   $page_name = "Control Panel Installation";
   $installer = true;

   head();

   $newver = checkForUpgrade();
   $unixdate = date("D M d G:i:s T Y", $now);

   if ($action == "install")
   {
      $cfg_file .= "<?php\n";
      $cfg_file .= "/************************************************************************\n";
      $cfg_file .= "*\n";
      $cfg_file .= "* exoGameCtl - Half-Life Server Control Panel\n";
      $cfg_file .= "* Copyright (c)2002-2003 Jeff Dodge Technologies.  All Rights Reserved.\n";
      $cfg_file .= "*\n";
      $cfg_file .= "*************************************************************************\n";
      $cfg_file .= "*\n";
      $cfg_file .= "*       Author: Jeffrey J. Dodge\n";
      $cfg_file .= "*        Email: info@exocontrol.com\n";
      $cfg_file .= "*          Web: http://www.exocontrol.com\n";
      $cfg_file .= "*     Filename: config.inc.php\n";
      $cfg_file .= "*  Description: exoGameCtl Configuration File\n";
      $cfg_file .= "*      Release: 2.0.7\n";
      $cfg_file .= "*\n";
      $cfg_file .= "*************************************************************************\n";
      $cfg_file .= "*\n";
      $cfg_file .= "* Please direct bug reports, suggestions, or feedback to the exoControl\n";
      $cfg_file .= "* Forums.  http://www.exocontrol.com/forums\n";
      $cfg_file .= "*\n";
      $cfg_file .= "*************************************************************************\n";
      $cfg_file .= "*\n";
      $cfg_file .= "* This software is furnished under a license and may be used and copied\n";
      $cfg_file .= "* only  in  accordance  with  the  terms  of such  license and with the\n";
      $cfg_file .= "* inclusion of the above copyright notice. This software or any other\n";
      $cfg_file .= "* copies thereof may not be provided or otherwise made available to any\n";
      $cfg_file .= "* other person. No title to and ownership of the software is hereby\n";
      $cfg_file .= "* transferred.\n";
      $cfg_file .= "*\n";
      $cfg_file .= "* Please see the LICENSE file for the full End User License Agreement\n";
      $cfg_file .= "*\n";
      $cfg_file .= "*************************************************************************\n";
      $cfg_file .= "* Created: " . $unixdate . "\n";
      $cfg_file .= "************************************************************************/\n\n";

      if (!$frm_info_type) { $frm_info_type = "default"; }

      if ($type == "standalone")
      {
         $cfg_file .= "// base directory & url where exoGameCtl is installed\n";
         $cfg_file .= "\$base_dir = \"$frm_base_dir\";\n";
         $cfg_file .= "\$base_url = \"$frm_base_url\";\n\n";

         $cfg_file .= "// hostname or ip and port of game server\n";
         $cfg_file .= "\$server_addr = \"$frm_server_addr\";\n";
         $cfg_file .= "\$server_port = \"$frm_server_port\";\n\n";

         $cfg_file .= "// rcon password of game server\n";
         $cfg_file .= "\$server_rcon = \"$frm_server_rcon\";\n\n";

         $cfg_file .= "// hostname or ip and port of hltv\n";
         $cfg_file .= "\$hltv_addr = \"$frm_hltv_addr\";\n";
         $cfg_file .= "\$hltv_port = \"$frm_hltv_port\";\n\n";

         $cfg_file .= "// rcon password of hltv server\n";
         $cfg_file .= "\$hltv_rcon = \"$frm_hltv_rcon\";\n\n";

         $cfg_file .= "// enable ftp configuration file transfer\n";
         $cfg_file .= "\$ftp_enable = $frm_ftp_enable;\n\n";

         $cfg_file .= "// hostname or ip of ftp server\n";
         $cfg_file .= "\$ftp_addr = \"$frm_ftp_addr\";\n\n";

         $cfg_file .= "// username and password to login to ftp server\n";
         $cfg_file .= "\$ftp_login = \"$frm_ftp_login\";\n";
         $cfg_file .= "\$ftp_password = \"$frm_ftp_password\";\n\n";

         $cfg_file .= "// cs1.6 editor (image settings)\n";
         $cfg_file .= "\$image_size = \"800000\";\n";
         $cfg_file .= "\$image_ext = array(\".gif\", \".GIF\", \".png\", \".PNG\", \".jpg\", \".JPG\", \".jpeg\", \".JPEG\");\n\n";

         $cfg_file .= "// enable web authentication\n";
         $cfg_file .= "\$auth_enable = $frm_auth_enable;\n\n";

         $cfg_file .= "// web authentication username and password\n";
         $cfg_file .= "\$auth_login = \"$frm_auth_login\";\n";
         $cfg_file .= "\$auth_password = \"$frm_auth_password\";\n\n";

         $cfg_file .= "// enable ping and speed testing utilities\n";
         $cfg_file .= "\$test_enable = $frm_test_enable;\n\n";

         $cfg_file .= "// enable gameserver remote control\n";
         $cfg_file .= "\$control_enable = $frm_control_enable;\n\n";

         $cfg_file .= "// enable web shell access\n";
         $cfg_file .= "\$unix_enable = $frm_unix_enable;\n\n";

         $cfg_file .= "// hostname or ip of unix shell server\n";
         $cfg_file .= "\$unix_addr = \"$frm_unix_addr\";\n\n";

         $cfg_file .= "// username and password to login to shell account\n";
         $cfg_file .= "\$unix_login = \"$frm_unix_login\";\n";
         $cfg_file .= "\$unix_password = \"$frm_unix_password\";\n\n";

         $cfg_file .= "// language pack (all text fields)\n";
         $cfg_file .= "\$lang_pack = \"$frm_language\";\n\n";
	
         $cfg_file .= "// game server configuration file location\n";
         $cfg_file .= "\$server_config    = \"$frm_server_config\";\n\n";

         $cfg_file .= "// game server motd file location\n";
         $cfg_file .= "\$server_motd      = \"$frm_server_motd\";\n\n";

         $cfg_file .= "// game server mapcycle file location\n";
         $cfg_file .= "\$server_mapcycle  = \"$frm_server_mapcycle\";\n\n";

         $cfg_file .= "// game server map path file location\n";
         $cfg_file .= "\$server_mappath   = \"$frm_server_mappath\";\n\n";

         $cfg_file .= "// metamod configuration file location\n";
         $cfg_file .= "\$metamod_plugins  = \"$frm_metamod_plugins\";\n\n";

         $cfg_file .= "// adminmod configuration file location\n";
         $cfg_file .= "\$adminmod_config  = \"$frm_adminmod_config\";\n\n";

         $cfg_file .= "// adminmod plugins file location\n";
         $cfg_file .= "\$adminmod_plugins = \"$frm_adminmod_plugins\";\n\n";

         $cfg_file .= "// adminmod users file location\n";
         $cfg_file .= "\$adminmod_users   = \"$frm_adminmod_users\";\n\n";

         $cfg_file .= "// statsme configuration file location\n";
         $cfg_file .= "\$statsme_config   = \"$frm_statsme_config\";\n\n";

         $cfg_file .= "// statsme motd file location\n";
         $cfg_file .= "\$statsme_motd     = \"$frm_statsme_motd\";\n\n";

         $cfg_file .= "// clanmod config file location\n";
         $cfg_file .= "\$clanmod_config   = \"$frm_clanmod_config\";\n\n";

         $cfg_file .= "// hlguard configuration file location\n";
         $cfg_file .= "\$hlguard_config   = \"$frm_hlguard_config\";\n\n";

         $cfg_file .= "// plbot configuration file location\n";
         $cfg_file .= "\$plbot_config     = \"$frm_plbot_config\";\n\n";

         $cfg_file .= "// enable htlv control?\n";
         $cfg_file .= "\$hltv_enable = \"$frm_hltv_enable\";\n\n";

         $cfg_file .= "// hltv configuration file location\n";
         $cfg_file .= "\$hltv_config = \"$frm_hltv_config\";\n\n";

         $cfg_file .= "// enable custom footer information / information to display\n";
         $cfg_file .= "\$info_type = \"$frm_info_type\";  // (default/custom/none)\n";
         $cfg_file .= "\$info_line1 = \"$frm_info_line1\";\n";
         $cfg_file .= "\$info_line2 = \"$frm_info_line2\";\n";
         $cfg_file .= "\$info_line3 = \"$frm_info_line3\";\n\n";

         $cfg_file .= "?>";

         $fd = @fopen("includes/config.inc.php", "w");
         @fwrite($fd, $cfg_file);
         @fclose($fd);

         echo "<meta http-equiv=\"refresh\" content=\"1; url=index.php\">";
         echo "Installation Complete!";
         exit;
      }
      elseif ($type == "gsp")
      {
         $cfg_file .= "// base directory & url where exoGameCtl is installed\n";
         $cfg_file .= "\$base_dir = \"$frm_base_dir\";\n";
         $cfg_file .= "\$base_url = \"$frm_base_url\";\n\n";

         $cfg_file .= "// enable gsp mode\n";
         $cfg_file .= "\$gsp_enable = 1;\n\n";

         $cfg_file .= "// hostname or ip of database server\n";
         $cfg_file .= "\$mysql_host = \"$frm_mysql_addr\";\n\n";

         $cfg_file .= "// name and table of database to use\n";
         $cfg_file .= "\$mysql_database = \"$frm_mysql_database\";\n";
         $cfg_file .= "\$mysql_table = \"$frm_mysql_table\";\n\n";

         $cfg_file .= "// username and password to login to db server\n";
         $cfg_file .= "\$mysql_login = \"$frm_mysql_login\";\n";
         $cfg_file .= "\$mysql_password = \"$frm_mysql_password\";\n\n";

         $cfg_file .= "// gspadmin.php password\n";
         $cfg_file .= "\$gspkey = \"" . md5($frm_gspkey) . "\";\n\n";

         $cfg_file .= "// cs1.6 editor (image settings)\n";
         $cfg_file .= "\$image_size = \"800000\";\n";
         $cfg_file .= "\$image_ext = array(\".gif\", \".GIF\", \".png\", \".PNG\", \".jpg\", \".JPG\", \".jpeg\", \".JPEG\");\n\n";

         $cfg_file .= "// language pack (all text fields)\n";
         $cfg_file .= "\$lang_pack = \"$frm_language\";\n\n";

         $cfg_file .= "// enable custom footer information / information to display\n";
         $cfg_file .= "\$info_type = \"$frm_info_type\";  // (default/custom/none)\n";
         $cfg_file .= "\$info_line1 = \"$frm_info_line1\";\n";
         $cfg_file .= "\$info_line2 = \"$frm_info_line2\";\n";
         $cfg_file .= "\$info_line3 = \"$frm_info_line3\";\n\n";

         $cfg_file .= "?>";

         $fd = @fopen("includes/config.inc.php", "w");
         @fwrite($fd, $cfg_file);
         @fclose($fd);

         @mysql_pconnect($frm_mysql_addr, $frm_mysql_login, $frm_mysql_password) or die("db connect error");
         mysql_select_db($frm_mysql_database);
         mysql_query("DROP TABLE IF EXISTS $frm_mysql_table");
         mysql_query("CREATE TABLE $frm_mysql_table (
            server_id int(4) NOT NULL auto_increment,
            created int(10) NOT NULL default '0',
            login varchar(25) NOT NULL default '',
            password varchar(25) NOT NULL default '',
            server_addr varchar(128) NOT NULL default '',
            server_port int(5) NOT NULL default '27015',
            server_rcon varchar(50) NOT NULL default '',
            hltv_enable tinyint(1) NOT NULL default '0',
            hltv_addr varchar(128) NOT NULL default '',
            hltv_port int(5) NOT NULL default '27020',
            hltv_rcon varchar(50) NOT NULL default '',
            hltv_config varchar(255) NOT NULL default '',
            ftp_enable tinyint(1) NOT NULL default '0',
            ftp_addr varchar(128) NOT NULL default '',
            ftp_port int(5) NOT NULL default '21',
            ftp_login varchar(25) NOT NULL default '',
            ftp_password varchar(25) NOT NULL default '',
            test_enable tinyint(1) NOT NULL default '0',
            control_enable tinyint(1) NOT NULL default '0',
            unix_enable tinyint(1) NOT NULL default '0',
            unix_addr varchar(128) NOT NULL default '',
            unix_login varchar(25) NOT NULL default '',
            unix_password varchar(25) NOT NULL default '',
            current_mod varchar(2) NOT NULL default '',
            server_config varchar(255) NOT NULL default '',
            server_motd varchar(255) NOT NULL default '',
            server_mapcycle varchar(255) NOT NULL default '',
            server_mappath varchar(255) NOT NULL default '',
            metamod_plugins varchar(255) NOT NULL default '',
            adminmod_config varchar(255) NOT NULL default '',
            adminmod_plugins varchar(255) NOT NULL default '',
            adminmod_users varchar(255) NOT NULL default '',
            statsme_config varchar(255) NOT NULL default '',
            statsme_motd varchar(255) NOT NULL default '',
            clanmod_config varchar(255) NOT NULL default '',
            hlguard_config varchar(255) NOT NULL default '',
            plbot_config varchar(255) NOT NULL default '',
            PRIMARY KEY  (server_id)
            ) TYPE=MyISAM;");
         mysql_close();

         echo "<meta http-equiv=\"refresh\" content=\"3; url=gspadmin.php\">";
         echo "Installation Complete!<br><br>";
         echo "Re-directing you to the GSP Admin Area so you can add some gameservers to manage!";
         exit;
      }
   }

   $path_translated = stripslashes( $HTTP_SERVER_VARS['PATH_TRANSLATED'] ) ;
   $temp_root = preg_replace( "/\/install.php/i", "", $path_translated ) ;

?>
<b><u><font size=2><?php echo $page_name ?></font></u></b>
<br><br>
<?php if ($type == "standalone"): ?>
<script language="JavaScript">
<!--
   var url = location.toString();
   url = url.replace('/install.php?type=standalone&step=1', '');
//-->
</script>
<form method="post" action="install.php?action=install&type=standalone" name="install">
You have choose to perform a standalone installation of exoGameCtl!  Once you have completed the installation you
will be able to control one gameserver from the web.
<br><br>
   <table cellspacing=1 cellpadding=2 border=0>
   <tr>
      <td colspan="4"><br><b>Path/URL Configuration</b></td>
   </tr>
   <tr>
      <td>Base Directory:</td>
      <td><input type="text" class="input" name="frm_base_dir" size="50" value="<?php echo $temp_root ?>"></td>
   </tr>
   <tr>
      <td>Base URL:</td>
      <td><input type="text" class="input" name="frm_base_url" size="50"></td>
      <script language="JavaScript">
      <!--
         document.install.frm_base_url.value = url;
      //-->
      </script>
   </tr>
   <tr>
      <td colspan="4"><br><b>Gameserver/HLTV Information</b></td>
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
      <input type="radio" name="frm_hltv_enable" value="1" <?php if ($type == "gsp"): ?> checked <?php endif; ?>>Yes
      <input type="radio" name="frm_hltv_enable" value="0" <?php if ($type == "standalone"): ?> checked <?php endif; ?>>No
      </td>
   </tr>
   <tr>
      <td>HLTV Address:</td>
      <td><input type="text" class="input" name="frm_hltv_addr" size="50"></td>
   </tr>
   <tr>
      <td>HLTV Port:</td>
      <td><input type="text" class="input" name="frm_hltv_port" size="10" value="27015"></td>
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
      <input type="radio" name="frm_ftp_enable" value="1" <?php if ($type == "gsp"): ?> checked <?php endif; ?>>Yes
      <input type="radio" name="frm_ftp_enable" value="0" <?php if ($type == "standalone"): ?> checked <?php endif; ?>>No
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
      <td colspan="4"><br><b>Language Selection</b></td>
   </tr>
   <tr>
      <td>Language Pack:</td>
      <td><select name="frm_language" class="select">
<?
   if ($dir = @opendir("lang_packs"))
   {
      while ($file = readdir($dir))
      {
         if ( ($file = preg_replace("/\.php/", "", $file)) && !preg_match("/(.bak)|(CVS)/", $file) && preg_match("/[0-9a-z]/i", $file))
         {
            $selected = "";
            if ($file == $lang_pack)
               $selected = "selected";

            print "<option value=\"$file\" $selected>$file</option>";
         }
      }
      closedir($dir);
   }
?></select></td>
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
      <td>Enable Web Authentication?</td>
      <td>
      <input type="radio" name="frm_auth_enable" value="1">Yes
      <input type="radio" name="frm_auth_enable" value="0" checked>No
      </td>
   </tr>
   <tr>
      <td>Auth Login:</td>
      <td><input type="text" class="input" name="frm_auth_login" size="35"></td>
   </tr>
   <tr>
      <td>Auth Password:</td>
      <td><input type="text" class="input" name="frm_auth_password" size="25" maxlength="20"></td>
   </tr>

   <tr>
      <td colspan="2"><br><b><u>File/Path Configuration</u></b></td>
   </tr>
   <tr>
      <td>Server Config (server.cfg):</td>
      <td><input type="text" class="input" name="frm_server_config" size="65" value="hlds_l/cstrike/server.cfg"></td>
   </tr>
   <tr>
      <td>Server MOTD (motd.txt):</td>
      <td><input type="text" class="input" name="frm_server_motd" size="65" value="hlds_l/cstrike/motd.txt">
   </tr>
   <tr>
      <td>Server Map Cycle (mapcycle.txt):</td>
      <td><input type="text" class="input" name="frm_server_mapcycle" size="65" value="hlds_l/cstrike/mapcycle.txt"></td>
   </tr>
   <tr>
      <td>Server Map Path:</td>
      <td><input type="text" class="input" name="frm_server_mappath" size="65" value="hlds_l/cstrike/maps"></td>
   </tr>
   <tr>
      <td>MetaMod Plugins (plugins.ini):</td>
      <td><input type="text" class="input" name="frm_metamod_plugins" size="65" value="hlds_l/cstrike/addons/metamod/plugins.ini"></td>
   </tr>
   <tr>
      <td>AdminMod Config (adminmod.cfg):</td>
      <td><input type="text" class="input" name="frm_adminmod_config" size="65" value="hlds_l/cstrike/addons/adminmod/config/adminmod.cfg"></td>
   </tr>
   <tr>
      <td>AdminMod Plugins (plugin.ini):</td>
      <td><input type="text" class="input" name="frm_adminmod_plugins" size="65" value="hlds_l/cstrike/addons/adminmod/config/plugin.ini"></td>
   </tr>
   <tr>
      <td>AdminMod Users (users.ini):</td>
      <td><input type="text" class="input" name="frm_adminmod_users" size="65" value="hlds_l/cstrike/addons/adminmod/config/users.ini"></td>
   </tr>
   <tr>
      <td>StatsMe Config (statsme.cfg):</td>
      <td><input type="text" class="input" name="frm_statsme_config" size="65" value="hlds_l/cstrike/addons/statsme/statsme.cfg"></td>
   </tr>
   <tr>
      <td>StatsMe MOTD (motd.cfg):</td>
      <td><input type="text" class="input" name="frm_statsme_motd" size="65" value="hlds_l/cstrike/addons/statsme/motd.cfg"></td>
   </tr>
   <tr>
      <td>ClanMod Config (clanmod.cfg):</td>
      <td><input type="text" class="input" name="frm_clanmod_config" size="65" value="hlds_l/cstrike/addons/clanmod/clanmod.cfg"></td>
   </tr>
   <tr>
      <td>HLGuard Config (hlguard.cfg):</td>
      <td><input type="text" class="input" name="frm_hlguard_config" size="65" value="hlds_l/cstrike/addons/hlguard/hlguard.cfg"></td>
   </tr>
   <tr>
      <td>PLBot Config (plbot.cfg):</td>
      <td><input type="text" class="input" name="frm_plbot_config" size="65" value="hlds_l/cstrike/addons/plbot/plbot.cfg"></td>
   </tr>
   <tr>
      <td colspan="4"><br>
      <table>
      <tr>
         <td><input type="submit" class="button" value="Complete Installation"></form></td>
      </tr>
      </table>
      </td>
   </tr>
   </table>

<?php elseif ($type == "gsp"): ?>
<script language="JavaScript">
<!--
   var url = location.toString();
   url = url.replace('/install.php?type=gsp&step=1', '');
//-->
</script>
<form method="post" action="install.php?action=install&type=gsp" name="install">
You have choose to perform an GSP installation of exoGameCtl!  Once you have completed this install you will be 
able to start adding servers to monitor!  You can monitor an unlimited amount of servers.
<br><br>
<hr size=1>
   <table cellspacing=1 cellpadding=2 border=0>
   <tr>
      <td colspan="4"><br><b>Path/URL Configuration</b></td>
   </tr>
   <tr>
      <td>Base Directory:</td>
      <td><input type="text" class="input" name="frm_base_dir" size="50" value="<?php echo $temp_root ?>"></td>
   </tr>
   <tr>
      <td>Base URL:</td>
      <td><input type="text" class="input" name="frm_base_url" size="50"></td>
      <script language="JavaScript">
      <!--
         document.install.frm_base_url.value = url;
      //-->
      </script>
   </tr>
   <tr>
      <td colspan="4"><br><b>MySQL Database Information</b></td>
   </tr>
   <tr>
      <td>MySQL Address:</td>
      <td><input type="text" class="input" name="frm_mysql_addr" value="localhost" size="50"></td>
   </tr>
   <tr>
      <td>MySQL Login:</td>
      <td><input type="text" class="input" name="frm_mysql_login" size="30"></td>
   </tr>
   <tr>
      <td>MySQL Password:</td>
      <td><input type="text" class="input" name="frm_mysql_password" size="30"></td>
   </tr>
   <tr>
      <td>MySQL Database:</td>
      <td><input type="text" class="input" name="frm_mysql_database" size="30"> [ <a href="javascript:checkDB()">check db connection</a> ]</td>
   </tr>
   <tr>
      <td>MySQL Table:</td>
      <td><input type="text" class="input" name="frm_mysql_table" size="30" value="exo_users"></td>
   </tr>
   <tr>
      <td colspan="4"><br><b>Language Selection</b></td>
   </tr>
   <tr>
      <td>Language Pack:</td>
      <td><select name="frm_language" class="select">
<?
   if ($dir = @opendir("lang_packs"))
   {
      while ($file = readdir($dir))
      {
         if ( ($file = preg_replace("/\.php/", "", $file)) && !preg_match("/(.bak)|(CVS)/", $file) && preg_match("/[0-9a-z]/i", $file))
         {
            $selected = "";
            if ($file == $lang_pack)
               $selected = "selected";

            print "<option value=\"$file\" $selected>$file</option>";
         }
      }
      closedir($dir);
   }
?></select></td>
   </tr>
   <tr>
      <td colspan="4"><br><b>GSP Admin Area Password</b></td>
   </tr>
   <tr>
      <td>Password:</td>
      <td><input type="text" class="input" name="frm_gspkey" size="25"></td>
   </tr>
   <tr>
      <td><br><br></td>
   </tr>
      <td colspan="4"><br>
      <table>
      <tr>
         <td><input type="submit" class="button" value="Complete Installation"></form></td>
      </tr>
      </table>
      </td>
   </tr>
   </table>


<?php else: ?>

Welcome to the installation of <?php echo $name ?> version <?php echo $version ?>.  This script will walk you through
the installation of exoGameCtl and get you ready to begin using the software.
<br><br>

<b><u>License Information</u></b>
<br><br>
License Type: <b><?php echo $licdata[product_edition] ?></b>
<?php if (($licdata[product_edition] == "GSP License") || ($licdata[product_edition] == "ISP License") || ($licdata[product_edition] == "Source License")): ?>
 (<b><?php if (!$licdata[maxservers]) { echo "Unlimited"; } else { echo $licdata[maxservers]; } ?> Server License</b>)<br>
<? else: ?>
<br>
<? endif; ?>
Licensed to: <b><?php echo $licdata[licensee] . "</b> (<b>" . $licdata[company] . "</b>)"; ?></b><br>
Licensed Domain: <b><?php echo $licdata[domain] ?></b><br>
Serial Number: <b><?php echo $licdata[serial] ?></b><br>
Latest Version: <b>
<?php
if ($newver != $version)
{
   echo "<font color=red>$newver</b> - There is a new version out!  You should <a href=\"http://members.exocontrol.com\"><font color=red>upgrade</font></a>.</font>";
}
else
{
   echo "<font color=green>$newver</b> - You have the latest version!</font>";
}
?>
</b><br>
<?php if ($timelim): ?>
Expiration Date: <b><?php echo date("D, M d, Y h:i:s T", $expire) ?></b>
<?php endif; ?>
<br><br>
<hr size=1>
<?php if (($licdata[product_edition] == "GSP License") || ($licdata[product_edition] == "ISP License") || ($licdata[product_edition] == "Source License")): ?>
<br>
Since you have an <?php echo $licdata[product_edition] ?> you are able to choose from the following two installation
types:
<br><br>
<ul type="disc">
<li><a href="install.php?type=standalone&step=1">Standalone Install</a> - This type of install is
designed to manage 1 gameserver with exoGameCtl.  It does not use a MySQL database it uses a flat config file.
<br><br>
<li><a href="install.php?type=gsp&step=1">GSP Install</a> - This type of install is designed to manage
many gameservers with exoGameCtl, it is designed for Gameing Providers.  You will need to configure a MySQL
database for this install to manage all the different logins and gameserver information.
</ul>
<?php else: ?>
<br>
<h3><center><a href="install.php?type=standalone&step=1">Begin Installation</a></center></h3>
<br>
<?php endif; ?>
<?php endif; ?>
<?php copyright(); foot(); ?>
