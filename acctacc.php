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
*     Filename: acctacc.php
*  Description: UNIX Web Account Access
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
* $Id: acctacc.php,v 2.12 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   require_once("includes/functions.inc.php");

   $page_name = $lang[acct][pagename];
   $server = connectRCON($server_addr, $server_port, $server_rcon);
   $server->disconnect();
   head();

   if (!$unix_enable)
   {
      echo $lang[acct][disabled] . "\n";
      echo "<br><br><br><br>\n";
      copyright();
      foot();
      exit;
   }

   $file = "tmp/applet.conf";
   if (!$unix_host)
   {
      $unixhost = $HTTP_HOST;
   }
   else
   {
      $unixhost = $unix_addr;
   }

   if (!$unix_login || !$unix_password)
   {
      echo $lang[acct][notsetup] . "\n";
      echo "<br><br><br><br>\n";
      copyright();
      foot();
      exit;
   }

   $telnet_conf .= "plugins                     =       Status,Socket,Telnet,Script,Terminal,Timeout\n";
   $telnet_conf .= "layout                      =       BorderLayout\n";
   $telnet_conf .= "layout.Status               =       South\n";
   $telnet_conf .= "layout.Terminal             =       Center\n";
   $telnet_conf .= "Applet.detach               =       true\n";
   $telnet_conf .= "Applet.detach.startText     =       Connect\n";
   $telnet_conf .= "Applet.detach.stopText      =       Disconnect\n";
   $telnet_conf .= "Applet.detach.immediately   =       false\n";
   $telnet_conf .= "Applet.detach.menuBar       =       true\n";
   $telnet_conf .= "Applet.Netscape.privilege   =       UniversalConnect,UniversalPrintJobAccess,UniversalSystemClipboardAccess\n";
   $telnet_conf .= "Socket.host                 =       $unixhost\n";
   $telnet_conf .= "Socket.port                 =       23\n";
   $telnet_conf .= "Timeout.seconds             =       60\n";
   $telnet_conf .= "Timeout.command             =       logout\\n\n";
   $telnet_conf .= "Terminal.id                 =       vt320\n";
   $telnet_conf .= "Terminal.buffer             =       1000\n";
   $telnet_conf .= "Terminal.size               =       [80,24]\n";
   $telnet_conf .= "Terminal.resize             =       font\n";
   $telnet_conf .= "Terminal.font               =       Monospaced\n";
   $telnet_conf .= "Terminal.fontStyle          =       plain\n";
   $telnet_conf .= "Terminal.fontSize           =       12\n";
   $telnet_conf .= "Terminal.foreground         =       #ffffff\n";
   $telnet_conf .= "Terminal.background         =       #000000\n";
   $telnet_conf .= "Terminal.cursor.foreground  =       #000000\n";
   $telnet_conf .= "Terminal.cursor.background  =       #00ff00\n";
   $telnet_conf .= "Terminal.print.color        =       false\n";
   $telnet_conf .= "Terminal.border             =       2\n";
   $telnet_conf .= "Terminal.borderRaised       =       false\n";
   $telnet_conf .= "Script.script               =       login:|$unix_login|Password:|$unix_password\n";

   $ssh_conf .= "plugins                     =       Status,Socket,SSH,Terminal,Timeout\n";
   $ssh_conf .= "layout                      =       BorderLayout\n";
   $ssh_conf .= "layout.Status               =       South\n";
   $ssh_conf .= "layout.Terminal             =       Center\n";
   $ssh_conf .= "Applet.detach               =       true\n";
   $ssh_conf .= "Applet.detach.startText     =       Connect\n";
   $ssh_conf .= "Applet.detach.stopText      =       Disconnect\n";
   $ssh_conf .= "Applet.detach.immediately   =       false\n";
   $ssh_conf .= "Applet.detach.menuBar       =       true\n";
   $ssh_conf .= "Applet.Netscape.privilege   =       UniversalConnect,UniversalPrintJobAccess,UniversalSystemClipboardAccess\n";
   $ssh_conf .= "Socket.host                 =       $unixhost\n";
   $ssh_conf .= "Socket.port                 =       22\n";
   $ssh_conf .= "SSH.user                    =       $unix_login\n";
   $ssh_conf .= "SSH.password                =       $unix_password\n";
   $ssh_conf .= "Timeout.seconds             =       60\n";
   $ssh_conf .= "Timeout.command             =       logout\\n\n";
   $ssh_conf .= "Terminal.id                 =       vt320\n";
   $ssh_conf .= "Terminal.buffer             =       1000\n";
   $ssh_conf .= "Terminal.size               =       [80,24]\n";
   $ssh_conf .= "Terminal.resize             =       font\n";
   $ssh_conf .= "Terminal.font               =       Monospaced\n";
   $ssh_conf .= "Terminal.fontStyle          =       plain\n";
   $ssh_conf .= "Terminal.fontSize           =       12\n";
   $ssh_conf .= "Terminal.foreground         =       #ffffff\n";
   $ssh_conf .= "Terminal.background         =       #000000\n";
   $ssh_conf .= "Terminal.cursor.foreground  =       #000000\n";
   $ssh_conf .= "Terminal.cursor.background  =       #00ff00\n";
   $ssh_conf .= "Terminal.print.color        =       false\n";
   $ssh_conf .= "Terminal.border             =       2\n";
   $ssh_conf .= "Terminal.borderRaised       =       false\n";

   if ($action == "telnet")
   {
      $fd = @fopen($file, "w");
      @fwrite($fd, $telnet_conf);
      @fclose($fd);
      $protocol = "Telnet";
   }
   elseif ($action == "ssh")
   {
      $fd = @fopen($file, "w");
      @fwrite($fd, $ssh_conf);
      @fclose($fd);
      $protocol = "SSH";
   }
   else
   {
      echo "<font size=\"2\"><b><u><php echo $page_name ?></u></b></font>\n";
      echo "<br><br>\n";
      echo $lang[acct][blurb];
      echo "<br><br>";
      echo $lang[acct][howacc];
      echo "<br><br>";
      echo "[ <a href=\"?action=telnet\">telnet</a> | <a href=\"?action=ssh\">SSH</a> ]\n";
      echo "<br><br><br><br>\n";
      copyright();
      foot();
      exit;
   }
?>
<?php echo preg_replace("/%%protocol%%/", $protocol, $lang[acct][howopen]); ?>
<br><br><br>
<dd><applet codebase="." archive="jta20.jar" code="de.mud.jta.Applet" width="70" height="20">
  <param name="config" value="tmp/applet.conf">
</applet>
<br><br><br>
<?php
   copyright();
   foot();
?>
