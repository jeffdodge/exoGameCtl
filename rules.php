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
*     Filename: rules.php
*  Description: Modify Server Rules
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
* $Id: rules.php,v 2.12 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   require_once("includes/functions.inc.php");

   $server = connectRCON($server_addr, $server_port, $server_rcon);
   $status = $server->serverinfo();
   $rules = $server->serverrules();
   $server->disconnect();
   $page_name = $lang[rules][pagename];

   if ($REQUEST_METHOD == "POST")
   {
      $server = connectRCON($server_addr, $server_port, $server_rcon);

      $command = $rule . " " . $value;
      $command = trim(urldecode($command));
      $result = $server->rcon_command($command);
      $rules = $server->serverrules();
      $server->disconnect();

      $alert = 1;
      $message = "$product\\n\\n" . $lang[rules][updated] . "\\n$rule = $value";
   }

   head();
?>
      <b><u><font size=2><?php echo $page_name ?></font></u></b><br><br>
      <?php echo $lang[rules][blurb] ?>
      <br><br>
      <table border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td valign="top">
         <table border="0">
         <tr>
            <td bgcolor="#5d5d5d"><center><b><font color="#ffffff"><?php echo $lang[rules][top_rule] ?></font></b></center></td>
            <td bgcolor="#5d5d5d"><center><b><font color="#ffffff"><?php echo $lang[rules][top_value] ?></font></b></center></td>
            <td bgcolor="#5d5d5d"><center><b><font color="#ffffff"><?php echo $lang[rules][top_change] ?></font></b></center></td>
         </tr>
<?php
   for ($c = 1; $c < sizeof($rules); $c++)
   {
      $row = "#f5f5f5";
      if ($c % 2)
      {
         $row = "#eeeeee";
      }

      if ($c == round(sizeof($rules)/2))
      {
         echo "         </table>\n";
         echo "         </td>\n\n";
         echo "            <td>&nbsp</td>\n\n";
         echo "            <td valign=\"top\">\n";
         echo "            <table border=\"0\">\n";
         echo "            <tr>\n";
         echo "               <td bgcolor=\"#5d5d5d\"><center><b><font color=\"#ffffff\">" . $lang[rules][top_rule] . "</font></b></center></td>\n";
         echo "               <td bgcolor=\"#5d5d5d\"><center><b><font color=\"#ffffff\">" . $lang[rules][top_value] . "</font></b></center></td>\n";
         echo "               <td bgcolor=\"#5d5d5d\"><center><b><font color=\"#ffffff\">" . $lang[rules][top_change] . "</font></b></center></td>\n";
         echo "         </tr>\n";
      }

      echo "         <tr>\n";
      echo "            <form method=\"post\" action=\"rules.php\">\n";
      echo "            <input type=\"hidden\" name=\"rule\" value=\"". $rules[$c][name] . "\">\n";
      echo "            <td bgcolor=\"$row\">" . $rules[$c][name] . "</td>\n";
      echo "            <td bgcolor=\"$row\"><input type=\"text\" size=\"15\" name=\"value\" value=\"". $rules[$c][value] . "\" class=\"input\"></td>\n";
      echo "            <td bgcolor=\"$row\"><center><input type=\"submit\" value=\"" . $lang[rules][btn_update] . "\" class=\"button\"></center></td>\n";
      echo "            </form>\n";
      echo "         </tr>\n";
   }
?>
         </table>
         </td>
      </tr>
      </table>
      </center>
<?php
   copyright();
   foot();
?>
