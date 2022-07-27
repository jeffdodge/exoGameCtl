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
*     Filename: admins.php
*  Description: AdminMod User Editor / Autoexec.cfg Creator
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
* $Id: admins.php,v 2.14 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   require_once("includes/functions.inc.php");

   $page_name = $lang[admins][pagename];
   $server = connectRCON($server_addr, $server_port, $server_rcon);
   $server->disconnect();


   if ($action == "update_users")
   {
      head();

      if ($ftp_enable)
      {
         $users_temp = "tmp/users" . rand(100, 999) . ".ini";
         $fd = @fopen($users_temp, "w");
         @fwrite($fd, stripslashes($contents));
         @fclose($fd);

         ftpPut($ftp_addr, $ftp_port, $ftp_login, $ftp_password, $adminmod_users, $users_temp, FTP_ASCII);
      }
      else
      {
         $fd = @fopen($adminmod_users, "w");
         @fwrite($fd, stripslashes($contents));
         @fclose($fd);
      }
      $server = connectRCON($server_addr, $server_port, $server_rcon);
      $server->rcon_command("say The users.ini file has been updated.  (reloading server config) via $product\" from \"exoGameCtl\"");
      $server->rcon_command("reload");
      $server->disconnect();
      include_once("js/page_reload.php");
      foot();
      exit;
   }
   elseif ($action == "autoexec")
   {
      $rndfn = md5(time());
      $rndfn = substr($rndfn, 0, 6);
      $zipfn = $rndfn . "_autoexec.zip";
      $zipfile = new zipfile();
      $auto_content = "setinfo " . $autoexec_passvar . " \"" . $autoexec_pass . "\"";

      $zipfile->addFile($auto_content, "autoexec.cfg");

      header("Content-type: application/x-zip");
      header("Content-Disposition: inline; filename=$zipfn");
      header("Content-length: " . strlen($zipfile->file()));
      print $zipfile->file();
      exit;
   }

   if ($ftp_enable)
   {
      $users_temp = "tmp/mapcycle" . rand(100, 999) . ".ini";
      $getmaps = ftpGet($ftp_addr, $ftp_port, $ftp_login, $ftp_password, $users_temp, $adminmod_users, FTP_ASCII);
      $fd = @fopen($users_temp, "r") or $error = "users file not found or transfer error";
      $contents = @fread($fd, filesize($users_temp));
      @fclose($fd);
      @unlink($users_temp);
   }
   else
   {
      $fd = @fopen($adminmod_users, "r+") or $error = "users file not found or incorrect permissions";
      $contents = @fread($fd, filesize($adminmod_users));
      @fclose($fd);
   }

   head();
?>
      <b><u><font size=2><?php echo $page_name ?></font></u></b><br><br>   
      <form method="post" action="admins.php" onSubmit="submitonce(this);">
      <?php echo $lang[admins][blurb] ?>
      <br><br>
      <?php echo $lang[admins][inidesc1] ?>
      <br>
      <b><?php echo $lang[admins][inidesc2] ?></b> (<a href="javascript:openWindow('accesscalc.php','accesscalc','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=666,height=600');"><?php echo $lang[admins][link_calc] ?></a>)
      <br><br>
<?php if ($error): ?>
      <font color=red><?php echo $error; ?></font><br>
<?php else: ?>
      <b>users.ini</b><br>
      <input type="hidden" name="action" value="update_users">
      <textarea cols="100" rows="15" class="textarea" name="contents" tabindex="1"><?php echo stripslashes($contents); ?></textarea><br>
      <input type="submit" class="button" value="Update Admins">
      </form>
<?php endif; ?>
      <br>
      <form method="post" action="admins.php">
      <input type="hidden" name="action" value="autoexec">
      <b><?php echo $lang[admins][createauto] ?></b><br>
      <?php echo $lang[admins][autovar] ?>
      <input type="text" class="input" name="autoexec_passvar" value="<?php echo $lang[admins][defvar] ?>">
      <?php echo $lang[admins][autopw] ?>
      <input type="text" class="input" name="autoexec_pass">
      <input type="submit" class="button" value="<?php echo $lang[admins][btn_dl] ?>"><br>
      <?php echo $lang[admins][afterdl] ?>
      </form>
<?php
   copyright();
   foot();
?>
