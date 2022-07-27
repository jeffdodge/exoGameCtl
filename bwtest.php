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
*     Filename: bwtest.php
*  Description: Image Download / Bandwidth Tester
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
* $Id: bwtest.php,v 2.13 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   require_once("includes/functions.inc.php");

   $page_name = "Bandwidth Tester (Image Download)";

   $rnd = md5(time());
   $rnd = substr($rnd, 0, 6);

   $filesize = 605;
   $testtype = "605 KB Image Download";

   if ($REQUEST_METHOD == "GET")
   {
      $rndfile = "tmp/bwtest_$rnd.js";
      $jsfile .= "function now()\n";
      $jsfile .= "{\n";
      $jsfile .= "   time = new Date();\n";
      $jsfile .= "   return time.getTime();\n";
      $jsfile .= "}\n\n";
      $jsfile .= "function calcSpeed(timeStart)\n";
      $jsfile .= "{\n";
      $jsfile .= "   timeEnd = now();\n";
      $jsfile .= "   timeElapsed = (timeEnd - timeStart)/1000 - 0.15;\n";
      $jsfile .= "   kbytes = $filesize/timeElapsed;\n";
      $jsfile .= "   bits = kbytes * 1024 * 8;\n";
      $jsfile .= "   document.forms[0].bps.value = bits;\n";
      $jsfile .= "   document.forms[0].submit();\n";
      $jsfile .= "}\n";

      $fd = @fopen($rndfile, "w");
      @fwrite($fd, $jsfile);
      @fclose($fd);
   }
?>
<html>
<head>
<title><?php echo $product . " .:. " . $page_name ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/base.css" type="text/css">
<script language="JavaScript" src="js/display.js"></script>
<?php if ($REQUEST_METHOD == "GET"): ?>
<script language="JavaScript" src="<?php echo $rndfile ?>"></script>
<?php endif; ?>
</head>

<body bgcolor="#dfdedf" background="images/bgtests.gif">
<font face="Verdana" size="1">
<?php
   if ($REQUEST_METHOD == "POST")
   {
      $rawdata = number_format($bps, 2, ".", "");
      $kbits   = number_format($bps / 1000, 1);
      $kbytes  = number_format(($bps / 8) / 1024, 1);
      $megdl   = number_format((1048576 / $kbytes) / 1000, 1, ".", "");
   }

   $nocopy = true;

   if ($REQUEST_METHOD == "GET"):
?>
<font size="2"><b><u>Bandwidth Test (Image Download)</u></b></font><br><br>
This test transfers a 605 KB image file from our server to your computer.
<br><br>
<dd><li>Download Starts -> "start time" recorded.
<dd><li>Download Finished -> "end time" recorded.
<dd><li>Transfer Speed Calculated -> results are displayed.
<br><br>
<b>test in progress, please wait...</b>
<br><br>
<script language="JavaScript">
<!--
   timeStart = now();
//-->
</script>

<img src="images/bwtest_<?php echo $filesize ?>kb.jpg?a=<? echo $rnd ?>" width="0" height="0" onLoad="calcSpeed(timeStart);">

<form method="post" action="<?php echo $PHP_SELF ?>">
   <input type="hidden" name="bps" value="">
   <input type="hidden" name="tmpfile" value="<?php echo $rndfile ?>">
   <input type="hidden" name="testtype" value="<?php echo $testtype ?>">
</form>

<?php
   else:
   $nocopy = false;
?>

<table border="1" cellpadding="9" bordercolor="#aaaaaa">
<tr>
   <td colspan="2" bgcolor="#eeeeee"><img src="images/bwtest_clock.gif" align="absmiddle"><font face="Verdana" 
size="
2"><b>Speed Test Results</b></font></td>
</tr>
<tr>
   <td colspan="2"><font face="Verdana" size="3" color="#0278A0"><center><b><?php echo $kbits ?> kilobits per second</b></font></center></td>
</tr>
<tr>
   <td colspan="2"><font face="Verdana" size="1"><b><font size="2">Details</font><br><img src="images/bar.gif" width="260" height="1" border="0"><br><br></b>Your raw speed was <b><?php echo $rawdata ?></b> bits per second, which is the same as:<br><br>
<table>
<tr>
   <td><img src="images/bwtest_network.gif" align="absmiddle"><font face="Verdana" size="1"><b>Communications</b></font></td>
   <td><font face="Verdana" size="1"><font face="Verdana" size="3" color="#0278A0"><b><?php echo $kbits ?></b></font> kilobits per second.<br><font face="Arial" size="1">How communication devices are rated. Kilo means 1,000 and mega<br>means 1,000,000. Examples include 56k modem and 10Mbit<br>Ethernet</font></font></td>
</tr>
<tr>
   <td colspan=2><center><hr size=1 width="75%"></td>
</tr>
<tr>
   <td><img src="images/bwtest_disk.gif" align="absmiddle"><font face="Verdana" size="1"><b>Storage</b></font></td>
   <td><font face="Verdana" size="1"><font face="Verdana" size="3" color="#0278A0"><b><?php echo $kbytes ?></b></font> kilobytes per second<br><font face="Arial" size="1">The way data is measured on your hard drive and how file sharing<br> and FTP programs measure transfer speeds. Kilo is 1,024 and mega<br> is 1,048,576.</font></font></td>
</tr>
<tr>
   <td colspan=2><center><hr size=1 width="75%"></td>
</tr>
<tr>
   <td><img src="images/bwtest_download.gif" align="absmiddle"><font face="Verdana" size="1"><b>1MB file download</b></font></td>
   <td><font face="Verdana" size="1"><font face="Verdana" size="3" color="#0278A0"><b><?php echo $megdl ?></b></font> seconds</b></font><br><font face="Arial" size="1">The time it would take you to download a 1 megabyte file at this<br>speed.</font></font></td> </tr>
</table>
   </td>
</tr>
<tr>
   <td width="20%"><font face="Verdana" size="1">Test Type</font></td>
   <td width="80%"><font face="Verdana" size="1"><b><?php echo $testtype; ?></b></font></td>
</tr>
<tr>
   <td width="20%"><font face="Verdana" size="1">Test Time</font></td>
   <td width="80%"><font face="Verdana" size="1"><b><?php echo date("m-d-Y H:i:s"); ?></b></font></td>
</tr>
<tr>
   <td width="20%"><font face="Verdana" size="1">IP Address</font></td>
   <td width="80%"><font face="Verdana" size="1"><b><?php echo $REMOTE_ADDR ?></b></font></td>
</tr>
<tr>
   <td colspan="2"><center>[ <a href="bwtest.php?id=<?php echo $rnd ?>">run test again</a> | <a href="javascript:window.close()">close window</a> ]</center></td>
</tr>
</table>
</font>
<?php endif; ?>
<?php
   if (!$nocopy)
   {
      echo "<hr size=\"1\" align=\"left\" width=\"90%\">\n";
      echo "$product ($licdata[company])<br>\n";
      echo "Copyright &copy;2002-03 <a href=\"http://www.exocontrol.com\" target=\"new\">RWJD.Com</a>.<br>\n";
      echo "<a href=\"mailto:info@exocontrol.com\">info@exocontrol.com</a>\n";
   }
   @unlink($tmpfile);
   foot();
?>
