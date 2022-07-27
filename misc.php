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
*     Filename: misc.php
*  Description: Miscellaneous Functions (DB Test, RCON Test)
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
* $Id: misc.php,v 2.13 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   include_once("includes/functions.inc.php");

   if ($action == "checkdb")
   {
      echo "<html>\n<head>\n<title>DB Test</title>\n</head>\n\n";
      echo "<body bgcolor=\"#dfdedf\" text=\"#000000\">\n<font face=\"Verdana\" size=\"1\">";
      if (!$host || !$login || !$password)
      {
         echo "Please fill in the host, login, and password before clicking on \"check db connection\"!";
         echo "<br><br>[ <a href=\"javascript:window.close()\" style=\"color: black; font-weight: bold;\">close window</a> ]\n\n</body></html>";
         exit;
      }
      echo "<b>DB Connection: ";
 
      if (@mysql_connect($host, $login, $password))
      {
         if (@mysql_select_db($db))
         {
            echo "<font color=green>Connected Successfully!</font></b><br><br>You are ready to continue with your install.";
         }
         else
         {
            echo "<font color=red>Failed!</font></b><br><br>Could not select the database.";
         }
      }
      else
      {
         echo "<font color=red>Failed!</font></b><br><br>This is caused by an incorrect hostname, login, or password.  Please check to make sure you are using the correct information and try again.";
      }
      echo "<br><br>[ <a href=\"javascript:window.close()\" style=\"color: black; font-weight: bold;\">close window</a> ]\n\n</body></html>";
   }
   elseif ($action == "changercon")
   {
      echo "<html>\n<head>\n<title>" . $lang[misc][rcon_pagename] . "</title>\n<link rel=\"stylesheet\" href=\"css/base.css\" type=\"text/css\">\n</head>\n\n";
      echo "<body bgcolor=\"#dfdedf\" text=\"#000000\">\n<font face=\"Verdana\" size=\"1\">\n";
      echo $lang[misc][rcon_pagename] . "\n<br>\n";

      if ($gsp_enable)
      {
         if (!$id)
         {
            echo "invalid server id";
            exit;
         }
         else
         {
            $serverinfo = GetServerById($dbh, $id);
            $serverinfo = $serverinfo[0];
            echo "for server: <b>$serverinfo[login]</b>\n<br><br>\n";
         }
      }

      if ($REQUEST_METHOD == "POST")
      {
         if (!$newrcon)
         {
            echo "The new RCON password cannot be left blank.<br><br><input type=\"button\" class=\"button\" onClick=\"javascript:window.close()\" value=\"<?php echo $lang[misc][closewin] ?>\">";
            exit;
         }

         $tempfile = "tmp/config" . rand(100, 999) . ".cfg";
         $filename = $server_config;

         if ($ftp_enable)
         {
            $errormsg = "Server config file not found or file transfer error";
         }
         else
         {
            $errormsg = "Server config file not found or incorrect permissions";
         }

         if ($ftp_enable)
         {
            ftpGet($ftp_addr, $ftp_port, $ftp_login, $ftp_password, $tempfile, $filename, FTP_ASCII);
            $fd = @fopen($tempfile, "r") or $error = $errormsg;
            while (!feof($fd))
            {
               $fdLine = fgets($fd, 512);
               $fdLine = trim($fdLine);
               $fdData = explode("rcon_password", $fdLine);

               if ($fdData[1])
               {
                  $rcon_pw = trim($fdData[1]);
                  $rcon_pw = str_replace("\"", "", $rcon_pw);
               }
            }            
            @fclose($fd);

            $fd = @fopen($tempfile, "r") or $error = $errormsg;
            $newfd = @fread($fd, filesize($tempfile));
            $newfd = str_replace($rcon_pw, $newrcon, $newfd);
            @fclose($fd);

            $fd = fopen($tempfile, "w") or $error = $errormsg;
            @fwrite($fd, stripslashes($newfd));
            @fclose($fd);
            ftpPut($ftp_addr, $ftp_port, $ftp_login, $ftp_password, $filename, $tempfile, FTP_ASCII);
            $server = connectRCON($server_addr, $server_port, $server_rcon);
            $server->rcon_command("restart");
            $server->disconnect();
            UpdateRowValue($dbh, $id, "server_rcon", $newrcon);
            @unlink($tempfile);
            echo "<font color=\"green\"><?php echo $lang[misc][rcon_changed] ?></font><br><br><font color=\"red\"><?php echo $lang[misc][restarted]; ?></font>\n<br><br><br>\n<input type=\"button\" onClick=\"javascript:window.close()\" class=\"button\" value=\"<?php echo $lang[misc][closewin] ?>\">";
            exit;
         }
         else
         {
            $fd = @fopen($filename, "r") or $error = $errormsg;
            while (!feof($fd))
            {
               $fdLine = fgets($fd, 512);
               $fdLine = trim($fdLine);
               $fdData = explode("rcon_password", $fdLine);

               if ($fdData[1])
               {
                  $rcon_pw = trim($fdData[1]);
                  $rcon_pw = str_replace("\"", "", $rcon_pw);
               }
            }            
            @fclose($fd);

            $fd = @fopen($filename, "r") or $error = $errormsg;
            $newfd = @fread($fd, filesize($filename));
            $newfd = str_replace($rcon_pw, $newrcon, $newfd);
            @fclose($fd);

            $fd = @fopen("includes/config.inc.php", "r") or $error = $errormsg;
            $newcfg = @fread($fd, filesize("includes/config.inc.php"));
            $newcfg = str_replace($rcon_pw, $newrcon, $newcfg);
            @fclose($fd);

            $server = connectRCON($server_addr, $server_port, $server_rcon);
            $server->rcon_command("restart");
            $server->disconnect();

            $fd = @fopen($filename, "w") or $error = $errormsg;
            @fwrite($fd, stripslashes($newfd));
            @fclose($fd);

            $fd = @fopen("includes/config.inc.php", "w") or $error = $errormsg;
            @fwrite($fd, stripslashes($newcfg));
            @fclose($fd);
            echo "<font color=\"green\">RCON Password Change Successful!</font><br><br><font color=\"red\">Server Restarted!</font>\n<br><br><br>\n<input type=\"button\" onClick=\"javascript:window.close()\" class=\"button\" value=\"<?php echo $lang[misc][closewin] ?>\">";
            exit;
         }
      }
      else
      {
         if ($gsp_enable)
         {
            echo "<form method=\"post\" action=\"misc.php?action=changercon&id=$id\">\n";
         }
         else
         {
            echo "<form method=\"post\" action=\"misc.php?action=changercon\">\n";
         }
         echo $lang[misc][rcon_newpw] . "\n<br>\n<input type=\"text\" class=\"input\" size=\"30\" maxlength=\"15\" name=\"newrcon\">\n<br><br>\n";
         echo "<input type=\"submit\" class=\"button\" value=\"" . $lang[misc][btn_chgpw] . "\">";
         exit;
      }
   }
?>
