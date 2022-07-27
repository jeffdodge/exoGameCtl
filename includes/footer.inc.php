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
*     Filename: footer.inc.php
*  Description: Design Footer File (bottom of every page)
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
* $Id: footer.inc.php,v 2.13 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   global $registered, $product, $expire;
?>
   </td>
</tr>
</table>
<?php if (!$registered): ?>
<div id="dropin" style="position:absolute;visibility:hidden;left:250;top:100;width:500;height:200;background-color:#ffc5c5">
<table border="0" width="500" height="200" cellspacing="0" cellpadding="2" bgcolor="#000000">
<tr>
   <td width="100%">
   <table border="0" width="100%" height="100%" bgcolor="#ffc5c5" cellspacing="0" cellpadding="2">
   <tr>
      <td width="100%" height="100%" valign="top" bgcolor="#ffc5c5">
      <div align="right">[ <a href="#" onClick="dismissbox();return false">Close</a> ]</div>
      <b><?php echo $product ?> - Evaluation Copy</b><br><br>
      This is an evaluation copy of <?php echo $product ?> and is set to expire on:<br>
      <b><?php echo date("D, M d, Y h:i:s T", $expire) ?></b><br><br>
      If you like this software please purchase a license for it.  A Standard License will allow you to have full control of your game server right from your own web server!
      <br><br>
      If you are a provider looking to put your customers in control of their game servers, we have a suitable license for you.  Our GSP licenses come in 10, 25, 50 and unlimited server licenses.  All GSP licenses offer an easy to use administration interface as well as the ability to be 100% customized to your sites layout.
      <br><br>
      Thanks for trying <?php echo $product ?>,
      <br><br>
      Jeffrey J. Dodge (ex0dus)<br>
      Lead Developer/Owner
      </td>
   </tr>
   </table>
   </td>
</tr>
</table>
</div>
<?php endif; ?>
</body>
</html>
