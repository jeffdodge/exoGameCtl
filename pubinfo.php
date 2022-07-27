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
*     Filename: pubinfo.php
*  Description: Public Server Information / Players
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
* $Id: pubinfo.php,v 2.16 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   require_once("includes/functions.inc.php");
   $page_name = "Public Server";
   connectRCON($server_addr, $server_port, $server_rcon);
?>

<?php
   if ($gsp_enable):
   if (!$login):
?>

<html>
<head>
<title><?php echo $product . " .:. " . $page_name ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/base.css" type="text/css">
<script language="JavaScript" src="js/display.js"></script>
</head>

<body bgcolor="#dfdedf" background="images/bglarge.gif">
<b><u><?php echo $page_name ?> Listing</u></b><br><br>
<table width="50%">
<tr>
   <td>
   <table cellspacing=1 cellpadding=2 border=0 width="95%" bgColor="#000000">
   <tr bgcolor="#5d5d5d">
      <td><font color="#ffffff"><b>Login (view info)</b></font></td>
      <td><font color="#ffffff"><b>Server IP/Port (info)</b></font></td>
   </tr>

<?php endif; endif; ?>

<?php
   if ($gsp_enable)
   {
      if (!$login)
      {
         $total_servers = TotalServers($dbh);
         $servers = GetAllServers($dbh, $page, 15);
         $page_string = CreatePageString($dbh, $page, "gspadmin.php?action=list&key=$key", 15, $total_servers);

         for ($c = 0; $c < count($servers); ++$c)
         {
            $this_server = $servers[$c];

            $bgcolor = "#eeeeee";
            if ($c % 2)
            {
               $bgcolor = "#f5f5f5";
            }

            echo "   <tr>\n";
            echo "      <td bgcolor=\"$bgcolor\"><a href=\"pubinfo.php?login=$this_server[login]\">$this_server[login]</a></td>\n";
            echo "      <td bgcolor=\"$bgcolor\">$this_server[server_addr]:$this_server[server_port]</a></td>\n";
            echo "   </tr>\n";
         }
?>
      </table>
      </td>
      <tr>
      <td><br><br>
<?php copyright(); ?>
    </td>
    </tr>
</table>
<?php

         foot();

         exit;
      }
      elseif (!GetServerByLogin($dbh, $login))
      {
         echo "<tt><font color=red>Server does not exist!</font></tt>";
         exit;
      }
      else
      {
         $serverinfo = GetServerByLogin($dbh, $login);
         $serverinfo = $serverinfo[0];
         $server_addr = $serverinfo[server_addr];
         $server_port = $serverinfo[server_port];
         $server_rcon = $serverinfo[server_rcon];
      }
   }

   $server = connectRCON($server_addr, $server_port, $server_rcon);
   $status = $server->serverinfo();
   $rules = $server->serverrules();
   $server->disconnect();

   $ip      = $status["ip"];
   $name    = $status["name"];
   $map     = $status["map"];
   $mod     = $status["mod"];
   $game    = $status["game"];
   $players = ($status["activeplayers"] . " active / " . $status["maxplayers"] . " max");

   if (!file_exists("images/maps/$map.jpg"))
   {
      $mapfile = "default";
   }
   else
   {
      $mapfile = $map;
   }
?>
<html>
<head>
<title><?php echo $product ?> .:. Public Information for login: <?php echo $login ?></title>
<link rel="stylesheet" href="css/base.css" type="text/css">
<script language="JavaScript" src="js/display.js"></script>
</head>

<body bgcolor="#ffffff" background="images/bglarge.gif">

<b><u><?php echo $page_name ?> Information</u></b><br><br>
<table>
<tr>
   <td><img src="images/maps/<?php echo $mapfile; ?>.jpg" align="left"></td>
   <td valign="top">
      <table border="0" cellspacing="5">
<?php
print "      <tr>
         <td><font class=\"normal\">Server Name:</font></td><td><font class=\"bold\">$name</font></td>
      </tr>
      <tr>
         <td><font class=\"normal\">Server IP:</font></td><td><font class=\"bold\">$ip</font></td>
      </tr>
      <tr>
         <td><font class=\"normal\">Current Map:</font></td><td><font class=\"bold\">$map</font></td>
      </tr>
      <tr>
         <td><font class=\"normal\">Game/Mod:</font></td><td><font class=\"bold\">$game: $mod</font></td>
      </tr>
      <tr>
         <td><font class=\"normal\">Players:</font></td><td><font class=\"bold\">$players</font></td>
      </tr>
";
?>
      <tr>
         <td>Rules:</td>
         <td>
         <select size="1" name="novalue" class="select">
<?php
   $rule_count = sizeof($rules);
   for ($c = 0; $c < $rule_count; $c++)
   {
      $output = "<option>" . $rules[$c][name] . " = " . $rules[$c][value] . "</option>";
      if (!preg_match("/<option> =/", $output))
      {
         echo $output;
      }
   }
?></select>
         </td>
      </tr>
      </table>
   </td>
<tr>
   <td>&nbsp;</td>
</tr>
<tr>
   <td colspan=2>
   <center>
   <table cellpadding="5" border="0">
   <tr bgcolor="#5d5d5d">
      <td width=150><font color="#ffffff">Player</font></td>
      <td width=75><font color="#ffffff">Kills</font></td>
      <td width=75><font color="#ffffff">Ping</font></td>
      <td width=100><font color="#ffffff">Connected</font></td>
   </tr>
<?php
   if ($status[activeplayers])
   {
      for ($c = 1; $c <= $status[activeplayers]; $c++)
      {
         if (isset($status[$c]))
         {
            $row = "#f5f5f5";
            if ($c % 2)
            {
               $row = "#eeeeee";
            }
            echo "   <tr>\n";
            echo "      <td bgcolor=\"$row\">" . $status[$c][name] . "</td>\n";
            echo "      <td bgcolor=\"$row\">" . $status[$c][frag] . "</td>\n";
            echo "      <td bgcolor=\"$row\">" . $status[$c][ping] . "</td>\n";
            echo "      <td bgcolor=\"$row\">" . $status[$c][time] . "</td>\n";
            echo "   </tr>\n";
         }
         else
         {
            echo "   <tr>\n";
            echo "      <td colspan=3><center><font class=\"bold\">Connecting Player</font></center></td>\n";
            echo "   </tr>\n";
         }
      }
   }
   else
   {
      print "   <tr>
      <td colspan=3><center>Sorry, Empty Server</center></td>
   </tr>";
   }
?>
</td>
</table>
</center>
<?php
   copyright();
   foot();
?>
