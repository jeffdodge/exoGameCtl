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
*     Filename: header.inc.php
*  Description: Design Header File (top of every page)
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
* $Id: header.inc.php,v 2.15 2003/10/01 03:51:50 exodus Exp $
************************************************************************/
   global $registered, $product, $page_name, $version, $encoding;
   global $expire, $installer, $alert, $message, $extra_onload;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo $product . " .:. " . $page_name ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/base.css" type="text/css">
<script language="Javascript">
<!--
   var js12 = false;
//-->
</script>
<script language="Javascript1.2">
<!--
   var js12 = true;
//-->
</script>
<script language="JavaScript" src="js/display.js"></script>
<?php if (preg_match("/(config.php)/", $_SERVER[PHP_SELF])): ?>
<script language="JScript.Encode" src="js/color.js"></script>
<script language="JScript.Encode" src="js/editor.js"></script>
<?php endif; ?>
<script language="JavaScript">
<!--
   function do_alert()
   {
      if (<?php if (!$alert) { echo "0"; } else { echo "1"; } ?>)
         alert('<?php echo $message; ?>');
   }
<?php if (preg_match("/(install.php)/", $_SERVER[PHP_SELF])): ?>
   function checkDB()
   {
      var host=document.forms['install'].elements['frm_mysql_addr'].value;
      var login=document.forms['install'].elements['frm_mysql_login'].value;
      var passwd=document.forms['install'].elements['frm_mysql_password'].value;
      var db=document.forms['install'].elements['frm_mysql_database'].value;

      window.open('misc.php?action=checkdb&host='+host+'&login='+login+'&password='+passwd+'&db='+db,'','dependent=1,directories=0,height=150,width=300,location=0');
   }
<?php endif; ?>
<?php if (preg_match("/(config.php)/", $_SERVER[PHP_SELF])): ?>
   function SubmitForm()
   {
      if (edit.displayMode == "HTML")
      {
         alert("Please uncheck HTML view");
         return;
      }

      medit.motd.value = edit.getContentBody();
      medit.submit();
   }
<?php endif; ?>
//-->
</script>
<?php if (!$registered): ?>
<script language="JavaScript1.2" src="js/displaye.js"></script>
<?php endif; ?>
</head>

<body bgcolor="#dfdedf" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('images/homeb.jpg','images/configb.jpg','images/rulesb.jpg','images/mapsb.jpg','images/adminsb.jpg','images/execb.jpg','images/accb.jpg','images/homec.jpg','images/configc.jpg','images/rulesc.jpg','images/mapsc.jpg','images/adminsc.jpg','images/execc.jpg','images/accc.jpg','images/aboutc.jpg');<?php if (!$registered) { echo " initbox();"; } ?> do_alert();<?php if ($extra_onload) { echo " $extra_onload"; } ?>">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
   <td height="66" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td height="77" nowrap background="images/topbgyellow.jpg"> 
      <div align="left"><img src="images/titleyellow.jpg" width="368" height="77"></div></td>
   </tr>
   <tr>
      <td height="28" nowrap background="images/menubgb.jpg"><div align="left"><img src="images/menuleft.jpg" width="162" height="28"><a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('home','','images/homec.jpg',1)"><img src="images/home.jpg" name="home" width="67" height="28" border="0"></a><a href="config.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('config','','images/configc.jpg',1)"><img src="images/config.jpg" name="config" width="68" height="28" border="0"></a><a href="rules.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('rules','','images/rulesc.jpg',1)"><img src="images/rules.jpg" name="rules" width="70" height="28" border="0"></a><a href="maps.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('maps','','images/mapsc.jpg',1)"><img src="images/maps.jpg" name="maps" width="68" height="28" border="0"></a><a href="admins.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('admins','','images/adminsc.jpg',1)"><img src="images/admins.jpg" name="admins" width="70" height="28" border="0"></a><a href="execcmd.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('exec','','images/execc.jpg',1)"><img src="images/exec.jpg" name="exec" width="69" height="28" border="0"></a><a href="acctacc.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('acc','','images/accc.jpg',1)"><img src="images/acc.jpg" name="acc" width="69" height="28" border="0"></a><a href="about.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('about','','images/aboutc.jpg',1)"><img src="images/about.jpg" name="about" width="70" height="28" border="0"></a><img src="images/menurightb.jpg" width="53" height="28"></div></td>
   </tr>
   </table>
   </td>
</tr>
<tr>
   <td background="images/bglarge.gif" valign="top" width="705">
   <center>
   <table width="95%" border=0>
   <tr>
      <td>
      <br><br>
