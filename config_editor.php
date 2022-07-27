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
*     Filename: config_editor.php
*  Description: Config File Edit/Save Script
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
* $Id: config_editor.php,v 2.17 2003/09/23 08:00:00 exodus Exp $
************************************************************************/
   require_once("includes/functions.inc.php");

   if ($action == "choose_file")
   {
      $updatefile = $filename;
      switch($filename)
      {
         case "servercfg":
            unset($filename);
            $tempfile = "tmp/config" . rand(100, 999) . ".cfg";
            $filename = $server_config;

            if ($ftp_enable)
               $errormsg = "Server config file not found or file transfer error";
            else
               $errormsg = "Server config file not found or incorrect permissions";

            break;

         case "motd":
            unset($filename);
            $tempfile = "tmp/motd" . rand(100, 999) . ".txt";
            $filename = $server_motd;

            if ($ftp_enable)
               $errormsg = "MOTD file not found or file transfer error";
            else
               $errormsg = "MOTD file not found or incorrect permissions";

            break;

         case "adminmodplgn":
            unset($filename);
            $tempfile = "tmp/plugin" . rand(100, 999) . ".ini";
            $filename = $adminmod_plugins;

            if ($ftp_enable)
               $errormsg = "Server Plug-Ins file not found or file transfer error";
            else
               $errormsg = "Server Plug-Ins file not found or incorrect permissions";

            break;

         case "metaplgns":
            unset($filename);
            $tempfile = "tmp/plugins" . rand(100, 999) . ".ini";
            $filename = $metamod_plugins;

            if ($ftp_enable)
               $errormsg = "MetaMod plugins file not found or file transfer error";
            else
               $errormsg = "MetaMod plugins file not found or incorrect permissions";

            break;

         case "adminmodcfg":
            unset($filename);
            $tempfile = "tmp/adminmod" . rand(100, 999) . ".cfg";
            $filename = $adminmod_config;

            if ($ftp_enable)
               $errormsg = "AdminMod Config file not found or file transfer error";
            else
               $errormsg = "AdminMod Config file not found or incorrect permissions";

            break;

         case "statsmecfg":
            unset($filename);
            $tempfile = "tmp/statsme" . rand(100, 999) . ".cfg";
            $filename = $statsme_config;

            if ($ftp_enable)
               $errormsg = "StatsMe Config file not found or file transfer error";
            else
               $errormsg = "StatsMe Config file not found or incorrect permissions";

            break;

         case "statsmemotd":
            unset($filename);
            $tempfile = "tmp/motd" . rand(100, 999) . ".cfg";
            $filename = $statsme_motd;

            if ($ftp_enable)
               $errormsg = "StatsMe MOTD file not found or file transfer error";
            else
               $errormsg = "StatsMe MOTD file not found or incorrect permissions";

            break;

         case "clanmodcfg":
            unset($filename);
            $tempfile = "tmp/clanmod" . rand(100, 999) . ".cfg";
            $filename = $clanmod_config;

            if ($ftp_enable)
               $errormsg = "ClanMod Config file not found or file transfer error";
            else
               $errormsg = "ClanMod Config file not found or incorrect permissions";

            break;

         case "hlguardcfg":
            unset($filename);
            $tempfile = "tmp/hlguard" . rand(100, 999) . ".cfg";
            $filename = $hlguard_config;

            if ($ftp_enable)
               $errormsg = "HLGuard Config file not found or file transfer error";
            else
               $errormsg = "HLGuard Config file not found or incorrect permissions";

            break;

         case "plbotcfg":
            unset($filename);
            $tempfile = "tmp/plbot" . rand(100, 999) . ".cfg";
            $filename = $plbot_config;

            if ($ftp_enable)
               $errormsg = "HLGuard Config file not found or file transfer error";
            else
               $errormsg = "HLGuard Config file not found or incorrect permissions";
            break;
      }

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
   }
   elseif ($action == "save_file")
   {
      if ($ftp_enable)
      {
         $tempfile = "tmp/temp" . rand(100, 999) . ".tmp";
         $fd = fopen($tempfile, "w") or $error = "could not write to temp file / check your file permissions";
         fwrite($fd, stripslashes($contents));
         fclose($fd);

         ftpPut($ftp_addr, $ftp_port, $ftp_login, $ftp_password, $file, $tempfile, FTP_ASCII);
         unlink($tempfile);
      }
      else
      {
         $fd = @fopen($filename, "w") or $error = "file not found / incorrect permissions";
         @fwrite($fd, stripslashes($contents));
         @fclose($fd);
      }

      if ($server_reload)
      {
         $server = connectRCON($server_addr, $server_port, $server_rcon);
         $server->rcon_command("reload");
         $server->disconnect();
         $alert = 1;
         $message = "$product\\n\\nFile Saved.  Gameserver Restarted.\\n\\nAll configuration files have been successfully reloaded!";
      }
      else
      {
         $alert = 1;
         $message = "$product\\n\\nFile Saved.\\n\\nYou must restart your gameserver for configuration changes to take effect!";
      }
   }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo $product ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
<!--

   function do_alert()
   {
      if (<?php if (!$alert) { $alert = 0; } echo $alert; ?>)
         alert('<?php echo $message; ?>');
   }

   function submitonce(theform)
   {
      if (document.all||document.getElementById)
      {
         for (i=0;i<theform.length;i++)
         {
            var tempobj=theform.elements[i]

            if(tempobj.type.toLowerCase()=="submit"||tempobj.type.toLowerCase()=="reset")
            tempobj.disabled=true
         }
      }
   }
//-->
</script>
<link rel="stylesheet" href="css/base.css" type="text/css">
</head>

<body bgcolor="#dfdedf" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="do_alert();">
<?php if ($contents): ?>
<form method="post" action="config_editor.php" onSubmit="submitonce(this);">
<input type="hidden" name="action" value="save_file">
<input type="hidden" name="file" value="<?php echo $filename ?>">
<textarea class="textarea" cols="120" rows="25" name="contents"><?php echo stripslashes($contents); ?></textarea>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
   <td><input type="submit" class="button" value="<?php echo $lang[cfgedit][btn_save] ?>"></td>
   <td><input type="checkbox" name="server_reload"></td>
   <td align="middle"><?php echo $lang[cfgedit][reload] ?></td>
</tr>
</table>
</form>
<?php else: ?>
<?php if (!$error): ?>
   <textarea class="textarea" cols="120" rows="25" name="contents" disabled><?php echo $lang[cfgedit][nofile] ?></textarea>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
   <td><input type="submit" class="button" value="<?php echo $lang[cfgedit][btn_save] ?>" disabled></td>
   <td><input type="checkbox" name="server_reload" disabled></td>
   <td align="middle"><?php echo $lang[cfgedit][reload] ?></td>
</tr>
</table>
<?php else: ?>
   <br><br>
   <center>
   <tt><font size=2 color="red"><?php echo $error; ?></font></tt>
   </center>
<?php endif; ?>
<?php endif; ?>
   </body>
</html>
