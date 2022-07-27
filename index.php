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
*     Filename: index.php
*  Description: Server Information / Players (Kick/Ban)
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
* $Id: index.php,v 2.22 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   if ($QUERY_STRING == "info")
   {
      phpinfo();
      exit;
   }
   require_once("includes/functions.inc.php");

   $page_name = $lang[index][pagename];

   if ($gsp_enable)
   {
      $serverinfo = GetServerByLogin($dbh, $exosess[login]);
      $serverinfo = $serverinfo[0];
   }

   $server = connectRCON($server_addr, $server_port, $server_rcon);
   $status = $server->serverinfo();
   $bans = $server->serverbanlist();
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

   if ($action)
   {
      $kickmsg = preg_replace("/%%user%%/", $user, $lang[index][kickmsg]);
      $tbanmsg = preg_replace("/%%user%%/", $user, $lang[index][tbanmsg]);
      $pbanmsg = preg_replace("/%%user%%/", $user, $lang[index][pbanmsg]);
      $rbanmsg = preg_replace("/%%wonid%%/", $id, $lang[index][rbanmsg]);

      switch($action)
      {
         case "kick": $command = "kick #" . $id; $alert = 1; $message = "$product\\n\\n$kickmsg"; break;
         case "5ban": $command = "banid 5 " . $id; $alert = 1; $message = "$product\\n\\n$tbanmsg"; break;
         case "pban": $command = "banid 0 " . $id; $alert = 1; $message = "$product\\n\\n$pbanmsg"; break;
         case "rban": $command = "removeid " . $id; $alert = 1; $message = "$product\\n\\n$rbanmsg"; break;
         case "restart": $command = "restart"; $alert = 1; $message = "$product\\n\\n" . $lang[index][restart]; break;
      }

      if (!$command)
      {
         echo "<tt><font color=red>No command to execute.</font></tt>";
         exit;
      }
      else
      {
         $server = connectRCON($server_addr, $server_port, $server_rcon);
         $command = trim(urldecode($command));
         $result = $server->rcon_command($command);
         if (preg_match("/id/", $command))
         {
            $server->rcon_command("writeid");
         }
         $status = $server->serverinfo();
         $bans = $server->serverbanlist();
         $server->disconnect();

         $ip      = $status["ip"];
         $name    = $status["name"];
         $map     = $status["map"];
         $mod     = $status["mod"];
         $game    = $status["game"];
         $players = ($status["activeplayers"] . " active / " . $status["maxplayers"] . " max");
      }
   }
   head();
?>
      <b><u><font size=2><?php echo $page_name ?></font></u></b><br><br>
      <?php echo $lang[index][blurb] ?>
      <br><br>
      <table border=0 cellpadding=0 cellspacing=0>
      <tr>
         <td><img src="images/maps/<?php echo $mapfile; ?>.jpg" align="left"></td>
         <td valign="top">
         <table border="0" cellspacing="5">
<?php
echo "         <tr>\n";
echo "            <td>" . $lang[index][serv_ip] . "</td><td><b>$ip</td>\n";
echo "         </tr>\n";
echo "         <tr>\n";
echo "            <td>" . $lang[index][serv_name] . "</td><td><b>$name</b></td>\n";
echo "         </tr>\n";
echo "         <tr>\n";
echo "            <td>" . $lang[index][curr_map] . "</td><td><b>$map</b></td>\n";
echo "         </tr>\n";
echo "         <tr>\n";
echo "         <td>" . $lang[index][gamemod] . "</td><td><b>$game: $mod</b></td>\n";
echo "         </tr>\n";
echo "         <tr>\n";
echo "            <td>" . $lang[index][players] . "</td><td><b>$players</b></td>\n";
echo "         </tr>\n";
?>
         <tr>
            <td colspan=2>[ <?php if ($test_enable): ?><a href="javascript:openWindow('ping.php','ping','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbar=no,resizable=no,width=650,height=600');"><?php echo $lang[index][link_ping] ?></a> | <a href="javascript:openWindow('bwtest.php','ping','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbar=no,resizable=no,width=650,height=620');"><?php echo $lang[index][link_speed] ?></a> |<?php endif; ?><?php if ($control_enable): ?> <a href="control.php"><?php echo $lang[index][link_control] ?></a><?php else: ?> <a href="index.php?action=restart"><?php echo $lang[index][link_restart] ?></a><?php endif; ?><? if ($hltv_enable): ?> | <a href="hltvcfg.php"><?php echo $lang[index][link_hltvctl] ?></a><? endif; ?> ]</td>
         </tr>
         <tr>
            <td colspan=2>[ <a href="javascript:openWindow('misc.php?action=changercon<? if ($gsp_enable): ?>&id=<? echo $serverinfo[server_id]; endif; ?>','rcon','toolbar=0,,location=0,directories=0,status=0,menubar=0,scrollbar=no,resizable=no,width=300,height=165');">change rcon password</a> ]</td>
         </tr>
<?php if ($gsp_enable): ?>
         <tr>
            <td>&nbsp;</td>
         </tr>
         <tr>
            <td colspan=2><?php echo $lang[index][in_as] . " <b>" . $exosess[login] ?></b> - [ <a href="login.php?action=logout"><?php echo $lang[index][link_logout] ?></a> ]</td> <?php endif; ?>
         </table>
         </td>
      </tr>
      <tr>
         <td colspan=2>
         <table border="0" cellpadding="5">
         <tr>   
            <td colspan=6><b><?php echo $lang[index][activeplyrs] ?></b></td>
         </tr>
         <tr bgcolor="#5d5d5d">
<?php if ($status[activeplayers]): ?>
            <td><b><font color="#ffffff"><?php echo $lang[index][plyr_id] ?></font></b></td>
            <td><b><font color="#ffffff"><?php echo $lang[index][plyr_name] ?></font></b></td>
            <td><b><font color="#ffffff"><?php echo $lang[index][plyr_kills] ?></font></b></td>
            <td><b><font color="#ffffff"><?php echo $lang[index][plyr_ping] ?></font></b></td>
            <td><b><font color="#ffffff"><?php echo $lang[index][plyr_time] ?></font></b></td>
            <td><b><font color="#ffffff"><?php echo $lang[index][plyr_wonid] ?></font></b></td>
<?php else: ?>
            <td><b><font color="#ffffff"><?php echo $lang[index][no_active] ?></b></td>
<?php endif; ?>
         </tr>
<?php
   for ($c = 1; $c <= $status[activeplayers]; $c++)
   {
      if (isset($status[$c]))
      {
         $row = "#f5f5f5";
         if ($c % 2)
         {
            $row = "#eeeeee";
         }

         echo "         <tr>\n";
         echo "            <td bgcolor=\"$row\">" . $status[$c][id] . "</td>\n";
         echo "            <td bgcolor=\"$row\">" . $status[$c][name] . "</td>\n";
         echo "            <td bgcolor=\"$row\">" . $status[$c][frag] . "</td>\n";
         echo "            <td bgcolor=\"$row\">" . $status[$c][ping] . "</td>\n";
         echo "            <td bgcolor=\"$row\">" . $status[$c][time] . "</td>\n";
         echo "            <td bgcolor=\"$row\">" . $status[$c][wonid] . "</td>\n";
         echo "            <td bgcolor=\"$row\"><a href=\"?action=kick&user=" . $status[$c][name] . "&id=" . $status[$c][id] . "\">" . $lang[index][plyr_kick] . "</a></td>\n";
         echo "            <td bgcolor=\"$row\"><a href=\"?action=5ban&user=" . $status[$c][name] . "&id=" . $status[$c][wonid] . "\">" . $lang[index][plyr_tban] . "</a></td>\n";
         echo "            <td bgcolor=\"$row\"><a href=\"?action=pban&user=" . $status[$c][name] . "&id=" . $status[$c][wonid] . "\">" . $lang[index][plyr_pban] . "</a></td>\n";
         echo "         </tr>\n";
      }
      else
      {
         echo "         <tr>\n";
         echo "            <td colspan=9><center><b>" . $lang[index][conn_player] . "</b></center></td>\n";
         echo "         </tr>\n";
      }
   }
?>
         </tr>
      </td>
      </table>
      <tr>
         <td colspan=2>
         <table border="0" cellpadding="5">
         <tr>   
            <td colspan=6><b><?php echo $lang[index][activebans] ?></b></td>
         </tr>
         <tr bgcolor="#5d5d5d">
<?php if (count($bans) >= 2): ?>
            <td><b><font color="#ffffff">WonID</font></b></td>
            <td><b><font color="#ffffff">Duration</font></b></td>
<?php else: ?>
            <td><b><font color="#ffffff"><?php echo $lang[index][no_bans] ?></b></td>
<?php endif; ?>
         </tr>
<?php
   for ($c = 1; $c <= count($bans); $c++)
   {
      if (isset($bans[$c]))
      {
         $row = "#f5f5f5";
         if ($c % 2)
         {
            $row = "#eeeeee";
         }

         echo "         <tr>\n";
         echo "            <td bgcolor=\"$row\">" . $bans[$c][id] . "</td>\n";
         if ($bans[$c][timeframe] == "permanent")
         {
            echo "            <td bgcolor=\"$row\">" . $bans[$c][timeframe] . "</td>\n";
         }
         else
         {
            echo "            <td bgcolor=\"$row\">" . $bans[$c][timeframe] . " min</td>\n";
         }
         echo "            <td bgcolor=\"$row\"><a href=\"index.php?action=rban&id=" . $bans[$c][id]. "\">remove ban</a></td>\n";
      }
   }
?>

         </table>
         </td>
      </tr>
      </table>
<?php
   copyright();
   foot();
?>
