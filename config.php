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
*     Filename: config.php
*  Description: Server Configuration / Pre-Defined Config Selector
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
* $Id: config.php,v 2.17 2003/10/01 03:51:50 exodus Exp $
************************************************************************/
   require_once("includes/functions.inc.php");

   $page_name = $lang[config][pagename];
   $server = connectRCON($server_addr, $server_port, $server_rcon);
   $server->disconnect();

   if ($action == "change_config")
   {
      if ($config == "cal")
      {
         $server = connectRCON($server_addr, $server_port, $server_rcon);
         $server->rcon_command("hostname \"CAL CS Match Server\"");
         $server->rcon_command("sv_maxupdaterate 100");
         $server->rcon_command("sv_minupdaterate 20");
         $server->rcon_command("sv_unlag 1");
         $server->rcon_command("sv_maxunlag .5");
         $server->rcon_command("sv_voiceenable 1");
         $server->rcon_command("sv_unlagsamples 1");
         $server->rcon_command("sv_unlagpush 0");
         $server->rcon_command("mp_autokick 0");
         $server->rcon_command("mp_autocrosshair 0");
         $server->rcon_command("mp_autoteambalance 0");
         $server->rcon_command("mp_buytime .25");
         $server->rcon_command("mp_consistency 1");
         $server->rcon_command("mp_c4timer 35");
         $server->rcon_command("mp_fadetoblack 0");
         $server->rcon_command("mp_flashlight 1");
         $server->rcon_command("mp_forcechasecam 2");
         $server->rcon_command("mp_forcecamera 2");
         $server->rcon_command("mp_footsteps 1");
         $server->rcon_command("mp_freezetime 10");
         $server->rcon_command("mp_friendlyfire 1");
         $server->rcon_command("mp_hostagepenalty 0");
         $server->rcon_command("mp_limitteams 6");
         $server->rcon_command("mp_logecho 1");
         $server->rcon_command("mp_logdetail 1");
         $server->rcon_command("mp_logfile 1");
         $server->rcon_command("mp_logmessages 1");
         $server->rcon_command("mp_maxrounds 12");
         $server->rcon_command("mp_playerid 0");
         $server->rcon_command("mp_roundtime 3");
         $server->rcon_command("mp_timelimit 999");
         $server->rcon_command("mp_tkpunish 0");
         $server->rcon_command("sv_aim 0");
         $server->rcon_command("sv_airaccelerate 10");
         $server->rcon_command("sv_airmove 1");
         $server->rcon_command("sv_allowdownload 1");
         $server->rcon_command("sv_allowupload 1");
         $server->rcon_command("sv_proxies 1");
         $server->rcon_command("sv_cheats 0");
         $server->rcon_command("sv_clienttrace 1.0");
         $server->rcon_command("sv_clipmode 0");
         $server->rcon_command("sv_contact frank@thecpl.com");
         $server->rcon_command("say " . $lang[config][cal_cfgload] . " $product\" from \"exoGameCtl\"");
         $server->disconnect();
         $alert = 1;
         $message = "$product\\n\\nCyberathlete Amateur League (CAL) " . $lang[config][loadok1] . "\\n\\n" . $lang[config][loadok2];
      }
      elseif ($config == "ogl")
      {
         $server = connectRCON($server_addr, $server_port, $server_rcon);
         $server->rcon_command("hostname \"OGL CS Match in Progress\"");
         $server->rcon_command("log on");
         $server->rcon_command("pausable 0");
         $server->rcon_command("mp_logecho 1");
         $server->rcon_command("mp_logfile 1");
         $server->rcon_command("mp_logmessages 1");
         $server->rcon_command("mp_logdetail 1");
         $server->rcon_command("mp_tkpunish 0");
         $server->rcon_command("mp_limitteams 6");
         $server->rcon_command("mp_consistency 1");
         $server->rcon_command("sv_maxunlag .3");
         $server->rcon_command("sv_voiceenable 1");
         $server->rcon_command("sv_contact OGL-cs.112502");
         $server->rcon_command("sv_cheats 0");
         $server->rcon_command("sv_airmove 1");
         $server->rcon_command("sv_allowdownload 1");
         $server->rcon_command("sv_allowupload 1");
         $server->rcon_command("sv_clipmode 0");
         $server->rcon_command("sv_friction 4");
         $server->rcon_command("sv_gravity 800");
         $server->rcon_command("sv_minrate 2500");
         $server->rcon_command("sv_stepsize 18");
         $server->rcon_command("sv_stopspeed 75");
         $server->rcon_command("sv_timeout 65");
         $server->rcon_command("sv_wateraccelerate 10");
         $server->rcon_command("sv_alltalk 0");
         $server->rcon_command("sv_aim 0");
         $server->rcon_command("sv_proxies 1");
         $server->rcon_command("sv_airaccelerate 10");
         $server->rcon_command("sv_clienttrace 1.0");
         $server->rcon_command("sv_maxspeed 320");
         $server->rcon_command("sv_maxrate 10000");
         $server->rcon_command("mp_friendlyfire 0");
         $server->rcon_command("mp_buytime .5");
         $server->rcon_command("mp_footsteps 1");
         $server->rcon_command("mp_freezetime 5");
         $server->rcon_command("mp_fraglimit 0");
         $server->rcon_command("mp_c4timer 35");
         $server->rcon_command("mp_flashlight 1");
         $server->rcon_command("mp_fadetoblack 0");
         $server->rcon_command("mp_forcechasecam 2");
         $server->rcon_command("mp_forcecamera 2");
         $server->rcon_command("mp_autokick 0");
         $server->rcon_command("mp_hostagepenalty 0");
         $server->rcon_command("mp_autoteambalance 0");
         $server->rcon_command("mp_playerid 0");
         $server->rcon_command("mp_autocrosshair 0");
         $server->rcon_command("mp_allowspectators 0");
         $server->rcon_command("decalfrequency 60");
         $server->rcon_command("edgefriction 2");
         $server->rcon_command("mp_timelimit 25");
         $server->rcon_command("mp_maxrounds 0");
         $server->rcon_command("mp_roundtime 5");
         $server->rcon_command("say " . $lang[config][ogl_cfgload] . " $product\" from \"exoGameCtl\"");
         $server->disconnect();
         $alert = 1;
         $message = "$product\\n\\nOnline Gaming League (OGL) " . $lang[config][loadok1] . "\\n\\n" . $lang[config][loadok2];
      }
   }
   elseif ($action == "reset_config")
   {
      $alert = 1;
      $message = "$product\\n\\n" . $lang[config][resetcfg];
      $server = connectRCON($server_addr, $server_port, $server_rcon);
      $server->rcon_command("exec server.cfg");
      $server->rcon_command("say " . $lang[config][cfgload] . " $product\" from \"exoGameCtl\"");
      $server->disconnect();
   }
   elseif ($action == "update_motd")
   {
      if ($ftp_enable)
      {
         $tempfile = "tmp/temp" . rand(100, 999) . ".tmp";
         $fd = fopen($tempfile, "w") or $error = "could not write to temp file / check your file permissions";
         fwrite($fd, stripslashes($motd_html));
         fclose($fd);

         ftpPut($ftp_addr, $ftp_port, $ftp_login, $ftp_password, $file, $tempfile, FTP_ASCII);
         unlink($tempfile);
      }
      else
      {
         $fd = @fopen($filename, "w") or $error = "file not found / incorrect permissions";
         @fwrite($fd, stripslashes($motd_html));
         @fclose($fd);
      }
      $alert = 1;
      $message = "$product\\nMOTD file successfully updated!";
   }

   if ($ftp_enable)
      $errormsg = "MOTD file not found or file transfer error";
   else
      $errormsg = "MOTD file not found or incorrect permissions";

   $tempfile = "tmp/motd" . rand(100, 999) . ".txt";
   $filename = $server_motd;

   if ($ftp_enable)
   {
      ftpGet($ftp_addr, $ftp_port, $ftp_login, $ftp_password, $tempfile, $filename, FTP_ASCII);
      $fd = @fopen($tempfile, "r") or $error = $errormsg;
      $contents = @fread($fd, filesize($tempfile));
      @fclose($fd);
      @unlink($tempfile);
   }
   else
   {
      $fd = @fopen($filename, "r") or $error = $errormsg;
      $contents = @fread($fd, filesize($filename));
      @fclose($fd);
   }
   $contents = str_replace("\n", "", $contents);
   $contents = str_replace("\r", "", $contents);
   head();
?>
      <b><u><font size=2><?php echo $page_name ?></font></u></b><br><br>
      <?php echo $lang[config][blurb] ?>
      <br><br>
      <?php echo $lang[config][predef_config] ?>
      <br><br>
      <table border="0">
      <tr>
         <td colspan=2>
         <form method="post" action="config.php">
         <input type="hidden" name="action" value="change_config">
         <select name="config" class="select">
            <option value="cal">Cyberathlete Amateur League (cal.cfg)</option>
            <option value="ogl">Online Gaming League (ogl.cfg)</option>
         </select>
         </td>
      </tr>
      <tr>
         <td>
         <input type="submit" class="button" value="<?php echo $lang[config][btn_changecfg] ?>">
         </form>
         </td>
         <td>

         <form method="post" action="config.php">
         <input type="hidden" name="action" value="reset_config">
         <input type="submit" class="button" value="<?php echo $lang[config][btn_resetcfg] ?>">
         </form>
         </td>
      </tr>
      </table>

      Please choose from the dropdown list which configuration or plugin file you would like to edit, once you click the submit button it will be displayed in the textarea below.
      <form method="post" action="config_editor.php" target="editor">
      <input type="hidden" name="action" value="choose_file">
      <select name="filename" class="select">
         <option><?php echo $lang[config][sel_selectcfg] ?></option>
<?php
   if ($server_config)
   {
      echo "         <option value=\"servercfg\">Server Configuration (server.cfg)</option>\n";
   }
   if ($server_motd)
   {
      echo "         <option value=\"motd\">Message Of The Day (motd.txt)</option>\n";
   }
   if ($metamod_plugins)
   {
      echo "         <option value=\"metaplgns\">MetaMod Plug-In Configuration (plugins.ini)</option>\n";
   }
   if ($adminmod_config)
   {
      echo "         <option value=\"adminmodcfg\">AdminMod Configuration (adminmod.cfg)</option>\n";
   }
   if ($adminmod_plugins)
   {
      echo "         <option value=\"adminmodplgn\">AdminMod Plug-In Configuration (plugin.ini)</option>\n";
   }
   if ($statsme_config)
   {
      echo "         <option value=\"statsmecfg\">StatsMe Configuration (statsme.cfg)</option>\n";
   }
   if ($statsme_motd)
   {
      echo "         <option value=\"statsmemotd\">StatsMe Message Of The Day (motd.cfg)</option>\n";
   }
   if ($clanmod_config)
   {
      echo "         <option value=\"clanmodcfg\">ClanMod Configuration (clanmod.cfg)</option>\n";
   }
   if ($hlguard_config)
   {
      echo "         <option value=\"hlguardcfg\">HLGuard Configuration (hlguard.cfg)</option>\n";
   }
   if ($plbot_config)
   {
      echo "         <option value=\"plbotcfg\">PLBot Configuration (plbot.cfg)</option>\n";
   }
?>
   </select>
   <input type="submit" class="button" value="<?php echo $lang[config][btn_edit] ?>">
   </form>
   <iframe src="config_editor.php" frameborder="0" scrolling="no" width="621" height="326" name="editor"></iframe>
   <br><hr size=1>
<b><u><?php echo $lang[config][motd_title]; ?></u></b>
<br><br>
<?php echo $lang[config][motd_blurb]; ?>
<form method="post" action="config.php" name="medit">
<input type="hidden" name="action" value="update_motd">
<input type="hidden" name="file" value="<?php echo $filename; ?>">
<input type="hidden" name="motd" value="">
<script language="JavaScript">
<!--
   var edit = new ACEditor("edit");

   edit.width = "621";
   edit.height = "326";
   edit.isFullHTML = true;
   edit.useStyle = false;
   edit.useAsset = false;
   edit.ImagePageURL = "insert_image.php";
   edit.ImagePageWidth = "400";
   edit.ImagePageHeight = "150";
   edit.usePageProperties = false;
   edit.RUN();
<?php if ($contents): ?>
   edit.putContent('<?php echo $contents ?>');
<?php else: ?>
   edit.putContent('<HTML><HEAD><META content="MSHTML 6.00.2800.1170" name=GENERATOR></HEAD><BODY><DIV><A href="http://www.exocontrol.com" target=_self><IMG height=50 src="images/exo_logo.gif" width=150 border=0></A></DIV><DIV><FONT face=Arial size=2></FONT>&nbsp;</DIV><DIV><FONT face=Arial size=2>You are playing Counter-Strike v1.6</FONT></DIV><DIV><FONT face=Arial size=2>Visit the official CS web site @ <A href="http://www.counter-strike.net">www.counter-strike.net</A>.</FONT></DIV><DIV><FONT face=Arial size=2></FONT>&nbsp;</DIV><DIV><FONT face=Arial size=2>This server is controlled by exoGameControl v2.0.7</FONT></DIV><DIV><FONT face=Arial size=2>Visit the offical exoGameCtl web site @ <A href="http://www.exocontrol.com">www.exocontrol.com</A>.</FONT></DIV></BODY></HTML>');
<?php endif; ?>
</script>
<br><br>
<input type="button" class="button" value="Update MOTD" onclick="SubmitForm()">
</form>

<?php
   copyright();
   foot();
?>
