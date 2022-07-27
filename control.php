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
*     Filename: control.php
*  Description: Server Control (Stop/Start/Restart)
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
* $Id: control.php,v 2.12 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   require_once("includes/functions.inc.php");

   $page_name = "Server Control";

   if (!$control_enable)
   {
      echo "<tt><font color=red>Server Control is not enabled.</font></tt>";
      exit;
   }

   $server = new rcon();
   if (!($server->connect($server_addr, $server_port, $server_rcon)))
   {
      $online = false;
      $status = "<font color=\"#ff0000\"><b>Offline</b></font>";
   }
   else
   {
      $svrstatus = $server->serverinfo();

      if (trim($svrstatus) == "Bad rcon_password.")
      {
         $online = false;
         $status = "<font color=\"#ff0000\"><b>Invalid RCON Password!</b></font>";
      }
      elseif (!$svrstatus[ip])
      {
         $online = false;
         $status = "<font color=\"#ff0000\"><b>Offline</b></font>";
      }
      else
      {
         $online = true;
         $status = "<font color=\"#00aa00\"><b>Online</b></font>";
      }
   }

   if ($action == "test")
   {
      echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
      echo "<html>\n";
      echo "<head>\n";
      echo "<title>Server Test</title>\n";
      echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
      echo "<meta http-equiv=\"Refresh\" content=\"10; url=control.php?action=test\">\n";
      echo "<link rel=\"stylesheet\" href=\"css/base.css\" type=\"text/css\">\n";
      echo "</head>\n\n";
      echo "<body bgcolor=\"#dfdedf\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">";
      echo "Server Status: $status\n";
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
         $fd = @fopen("tmp/start.hlds", "w");
         @fwrite($fd, "go");
         @fclose($fd);

         if (ftpList($ftp_addr, $ftp_port, $ftp_login, $ftp_password, "start.hlds"))
         {
            $alert = 1;
            $message = "$product\\n\\nServer Start Request already in Queue.  Please wait..";
         }
         else
         {
            ftpPut($ftp_addr, $ftp_port, $ftp_login, $ftp_password, "start.hlds", "tmp/start.hlds", FTP_ASCII);
            @unlink("tmp/start.hlds");
            $alert = 1;
            $message = "$product\\n\\nServer Start Request Queued.  It may take up to 60 seconds for your server to be started.\\n\\nYou will see the \'Server Status\' change to \'Online\' when your server has been started!";
         }
      }
   }
      
   if ($action == "restart")
   {
      $server = connectRCON($server_addr, $server_port, $server_rcon);
      $server->rcon_command("restart");
      $server->disconnect();
      $alert = 1;
      $message = "$product\\n\\nServer has been restarted.";
   }
   elseif ($action == "stop")
   {
      $server = connectRCON($server_addr, $server_port, $server_rcon);
      $server->rcon_command("exit");
      $server->disconnect();
      $alert = 1;
      $message = "$product\\n\\nServer has been shutdown.";
   }
   elseif ($action == "kill")
   {
      if (!$online)
      {
         $alert = 1;
         $message = "$product\\n\\nCannot stop server.  It\'s already stopped!";
      }
      else
      {
         $fd = @fopen("tmp/kill.hlds", "w");
         @fwrite($fd, "stop");
         @fclose($fd);

         if (ftpList($ftp_addr, $ftp_port, $ftp_login, $ftp_password, "kill.hlds"))
         {
            $alert = 1;
            $message = "$product\\n\\nServer Kill Request already in Queue.  Please wait..";
         }
         else
         {
            ftpPut($ftp_addr, $ftp_port, $ftp_login, $ftp_password, "kill.hlds", "tmp/kill.hlds", FTP_ASCII);
            @unlink("tmp/kill.hlds");
            $alert = 1;
            $message = "$product\\n\\nServer Kill Request Queued.  It may take up to 60 seconds for your server to be killed.\\n\\nYou will see the \'Server Status\' change to \'Offline\' when your server has been killed!";
         }
      }
   }
   head();
?>
      <font size="2"><b><u>Server Control</u></b></font><br><br>
      This is where you control your game server.  Weather you want to start it up, shut it down, or restart it to refresh a new config file you just loaded.  This is where you can do it from.  Click on one of the following buttons and it's action will be carried out.
      <br><br>
      <iframe src="control.php?action=test" scrolling="no" frameborder="0" width="240" height="16"></iframe>
      <br><br>
      [ <a href="control.php?action=start">start</a> | <a href="control.php?action=restart">restart</a> | <a href="control.php?action=stop">shutdown</a> | <a href="control.php?action=kill">kill server</a> ]
      <br><br><br><br>

<?php

   copyright();
   foot();
?>
