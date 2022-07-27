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
*     Filename: hltvcfg.php
*  Description: HLTV Configuration/Start/Stop Script
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
* $Id: hltvcfg.php,v 2.12 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   require_once("includes/functions.inc.php");
   $page_name = "HLTV Control/Config";

   if ($action == "update")
   {
      if ($ftp_enable)
      {
         $tempfile = "tmp/temp" . rand(100, 999) . ".tmp";
         $fd = fopen($tempfile, "w") or $error = "could not write to temp file / check your file permissions";
         fwrite($fd, stripslashes($contents));
         fclose($fd);

         ftpPut($ftp_addr, $ftp_port, $ftp_login, $ftp_password, $hltv_config, $tempfile, FTP_ASCII);
         unlink($tempfile);
      }
      else
      {
         $fd = @fopen($hltv_config, "w") or $error = "file not found / incorrect permissions";
         @fwrite($fd, stripslashes($contents));
         @fclose($fd);
      }

      if (!$error)
      {
         $alert = 1;
         $message = "$product\\n\\nHLTV Configuration File Saved.";
      }
   }
   elseif ($action == "test")
   {
      $server = new rcon();
      if (!($server->connect($hltv_addr, $hltv_port, $hltv_rcon)))
      {
         $online = false;
         $status = "<font color=\"#ff0000\"><b>Offline</b></font>";
      }
      else
      {
         $clients = $server->rcon_command("clients");

         if (!$clients)
         {
            $online = false;
            $status = "<font color=\"#ff0000\"><b>Offline</b></font>";
         }
         else
         {
            $online = true;
            if (ftpList($ftp_addr, $ftp_port, $ftp_login, $ftp_password, "hltv.recording"))
            {
               $status = "<font color=\"#0000aa\"><b>Recording Demo</b></font>";
            }
            else
            {
               $status = "<font color=\"#00aa00\"><b>Online</b></font>";
            }
         }
      }

      echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
      echo "<html>\n";
      echo "<head>\n";
      echo "<title>Server Test</title>\n";
      echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
      echo "<meta http-equiv=\"Refresh\" content=\"10; url=hltvcfg.php?action=test\">\n";
      echo "<link rel=\"stylesheet\" href=\"css/base.css\" type=\"text/css\">\n";
      echo "</head>\n\n";
      echo "<body bgcolor=\"#dfdedf\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">";
      echo "HLTV Status: $status";
      echo "</body>\n";
      echo "</html>";
      exit;
   }
   elseif ($action == "start")
   {
      if (!$ftp_enable)
      {
         head();
         echo "      <tt><font size=2 color=red>FTP must be ENABLED for remote start to work.</font></tt>";
         foot();
         exit;
      }

      if ($online)
      {
         $alert = 1;
         $message = "$product\\n\\nCannot start server.  It\'s already running!";
      }
      else
      {
         $fd = @fopen("tmp/start.hltv", "w");
         @fwrite($fd, "go");
         @fclose($fd);

         if (ftpList($ftp_addr, $ftp_port, $ftp_login, $ftp_password, "start.hltv"))
         {
            $alert = 1;
            $message = "$product\\n\\nServer Start Request already in Queue.  Please wait..";
         }
         else
         {
            ftpPut($ftp_addr, $ftp_port, $ftp_login, $ftp_password, "start.hltv", "tmp/start.hltv", FTP_ASCII);
            @unlink("tmp/start.hltv");
            $alert = 1;
            $message = "$product\\n\\nHLTV Start Request Queued.  It may take up to 60 seconds for HLTV to be started.\\n\\nYou will see the \'HLTV Status\' change to \'Online\' when HLTV has been started!";
         }
      }
   }
   elseif ($action == "record")
   {

      $server = new rcon();
      if (!($server->connect($hltv_addr, $hltv_port, $hltv_rcon)))
      {
         $alert = 1;
         $message = "$product\\n\\nThe HLTV server is not online!";
      }
      elseif (ftpList($ftp_addr, $ftp_port, $ftp_login, $ftp_password, "hltv.recording"))
      {
         $alert = 1;
         $message = "$product\\n\\nHLTV is already recording!";
      }
      else
      {
         $record_file = "$filename-" . date("mdyhm");
         $server = connectRCON($hltv_addr, $hltv_port, $hltv_rcon);
         $server->rcon_command("record $record_file");
         $server->disconnect();

         $fd = @fopen("tmp/hltv.recording", "w");
         @fwrite($fd, "$record_file");
         @fclose($fd);

         ftpPut($ftp_addr, $ftp_port, $ftp_login, $ftp_password, "hltv.recording", "tmp/hltv.recording", FTP_ASCII);
         @unlink("tmp/hltv.recording");

         $alert = 1;
         $message = "$product\\n\\nHLTV is now recording to:\\n$record_file-1.dem";
      }
   }
   elseif ($action == "stoprecord")
   {
      $server = new rcon();
      if (!($server->connect($hltv_addr, $hltv_port, $hltv_rcon)))
      {
         $alert = 1;
         $message = "$product\\n\\nThe HLTV server is not online!";
      }
      else
      {
         $server = connectRCON($hltv_addr, $hltv_port, $hltv_rcon);
         $server->rcon_command("stoprecord");
         $server->disconnect();

         ftpDelete($ftp_addr, $ftp_port, $ftp_login, $ftp_password, "hltv.recording");

         $alert = 1;
         $message = "$product\\n\\nHLTV has stopped recording.\\n\\nYour recorded file is on your server in your HLTV path.";
      }
   }
   elseif ($action == "stop")
   {
      $server = connectRCON($hltv_addr, $hltv_port, $hltv_rcon);
      $server->rcon_command("exit");
      $server->disconnect();

      $alert = 1;
      $message = "$product\\n\\nHLTV has been shutdown.";
   }


   $tempfile = "tmp/hltv" . rand(100, 999) . ".cfg";
   if ($ftp_enable)
   {
      ftpGet($ftp_addr, $ftp_port, $ftp_login, $ftp_password, $tempfile, $hltv_config, FTP_ASCII);
      $fd = @fopen($tempfile, "r") or $error = $errormsg;
      $contents = @fread($fd, filesize($tempfile));
      @fclose($fd);
      @unlink($tempfile);
   }
   else
   {
      $fd = @fopen($hltv_config, "r") or $error = $errormsg;
      $contents = @fread($fd, filesize($hltv_config));
      @fclose($fd);
   }
   head();
?>
      <b><u><font size=2><?php echo $page_name ?></font></u></b><br><br>
      This is where you can edit your HLTV configuration file, start/stop recording and kill your HLTV server.  You will need to start your HLTV server from the command line since it will not run in the background we cannot start it.
      <br><br>
      <iframe src="hltvcfg.php?action=test" scrolling="no" frameborder=0 width="240" height="16"></iframe>

      <table border="0" cellpadding="0" cellspacing="0">
      <tr>
         <td>
         <table border="0" cellpadding="0" cellspacing="0">
         <tr>
            <td>
            <form method="post" action="hltvcfg.php">
            <input type="hidden" name="action" value="record">
            Filename: <input type="text" name="filename" class="input">
            <input type="submit" class="button" value="Start Recording">
            </form>
            </td>
            <td>&nbsp;</td>
            <td>
            <form method="post" action="hltvcfg.php">
            <input type="hidden" name="action" value="stoprecord">
            <input type="submit" class="button" value="Stop Recording">
            </form>
            </td>
         </tr>
         </table>
      </tr>
      <tr>
         <td>
         <form method="post" action="hltvcfg.php">
         <input type="hidden" name="action" value="update">
         <textarea class="textarea" cols="120" rows="25" name="contents"><?php echo stripslashes($contents); ?></textarea>
         <table border="0" cellpadding="0" cellspacing="0">
         <tr>
            <td><input type="submit" class="button" value="Update Configuration"></td>
         </tr>
         </table>
         </form>
         </td>
      </tr>
      </table>
<?
   copyright();
   foot();
?>
