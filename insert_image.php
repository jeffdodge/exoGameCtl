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
*     Filename: insert_image.php
*  Description: CS 1.6 - MOTD Image Insert (editor.js)
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
* $Id: insert_image.php,v 2.1 2003/09/22 01:16:15 exodus Exp $
************************************************************************/

   require_once("includes/functions.inc.php");
   $page_name = $lang[insert_image][pagename];

   if ($REQUEST_METHOD == "POST")
   {
      $ext = strrchr($file_name, '.');
      $sizelimit = $image_size/1000 . "KB";

      if (!$file_name)
         $result = $lang[insert_image][nofile];
      elseif (file_exists("$path/$file_name"))
         $result = $lang[insert_image][exists];
      elseif ($image_size < $file_size)
         $result = "$lang[insert_image][toobig] ($sizelmit $lang[insert_image][slimit]).";
      elseif (!in_array($ext, $image_ext))
         $result = $lang[insert_image][intype];
      else
      {
         $rand = substr(md5($file_name . time() . rand(1000, 9999)), 0, 15);
         list($fname, $fext) = explode(".", $file_name);
         @copy($file, "$base_dir/images/public/$rand.$fext") or $result = "Could not copy file to server!";
         print "<script>window.opener.edit.InsertImage('$base_url/images/public/$rand.$fext','','','','','','',''); self.close();</script>";
         echo $file_name;
      }
   }
?>
<html>
<head>
<title><?php echo $page_name; ?></title>
<link rel="stylesheet" href="css/base.css" type="text/css">
</head>

<body bgcolor="#ffffff" text="#000000">
Image Upload/Insert
<br><br><font color="#ff0000"><? echo $result; ?></font><br><br>
<form method="post" action="?upload=yes" enctype="multipart/form-data">
<input class="input" type="file" name="file" size="40">
<br><br>
<input type="submit" class="input" value="<?php echo $lang[insert_image][submit]; ?>">
</form>
</body>
</html>
