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
*     Filename: about.php
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
* $Id: about.php,v 2.23 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   require_once("includes/functions.inc.php");

   $eula = CallHome("action=eula&domain=$licdata[domain]&serial=$licdata[serial]");
   $page_name = "About exoGameCtl";
   $newver = checkForUpgrade();
   head();
?>
   <b><u><font size=2>About/Software Information</font></u></b>
   <br><br>
   <?php echo $product ?> is written in PHP, JavaScript, and HTML.<br>
   ionCube Encoded using the ionCube Cerberus Encoder 3.0.0<br>
   Zend Encoded using the Zend Encoder Unlimited v3.1.0-zlm<br>
   SourceGuardian Encoded using SourceGuardian Pro 2.0
   <br><br>
   License type: <b><?php echo $licdata[product_edition] ?></b>
<?php if (($licdata[product_edition] == "GSP License") || ($licdata[product_edition] == "ISP License") || ($licdata[product_edition] == "Source License")): ?>
 (<b><?php if (!$licdata[maxservers]) { echo "Unlimited"; } else { echo $licdata[maxservers]; } ?> Server License</b>)<br>
<? else: ?>
<br>
<? endif; ?>
   Licensed to: <b><?php echo $licdata[company] ?></b> (domain: <b><?php echo $licdata[domain] ?></b>)<br>
   Serial Number: <b><?php echo $licdata[serial] ?></b><br><br>
<?php
if ($newver != $version)
{
   echo "Latest version of exoGameCtl available: <a href=\"http://members.exocontrol.com\">$newver</a>; Your version: $version.";
}
else
{
   echo "You are running the latest version of exoGameCtl (<b>$newver</b>)";
}

?></b>
<?php
   if ($timelim)
   {
      echo "<br><br>";

      if ($warnday < $now)
      {
         echo "This copy of $name is set to expire on:<br>";
         echo "<b><font color=\"red\">" . date("D, M d, Y h:i:s T", $expire) . "</font></b>";
      }
      else
      {
         echo "This copy of $name is set to expire on:<br>";
         echo "<b>" . date("D, M d, Y h:i:s T", $expire) . "</b>";
      }
   }
   else
   {
      echo "<br>";
   }
?>
<hr size=1>
<?
   if ($eula)
   {
      print $eula;
   }
   else
   {
      echo "<font color=red>EULA Fetch Error!</font><br><br>Contact <a href=\"mailto:licenses@exocontrol.com\">licenses@exocontrol.com</a> for a copy of the End User License Agreement.";
   }
?>
<?php
   echo "<br><hr>" . $product . " (" . $licdata[company] .")" . "<br>Copyright &copy;2002 <a href=\"http://www.jeffdodge.com\">Jeff Dodge Technologies</a>.<br><a href=\"mailto:info@exocontrol.com\">info@exocontrol.com</a><br><br>";
   foot();
?>
