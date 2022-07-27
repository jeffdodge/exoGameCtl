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
*     Filename: maps.php
*  Description: Map Change/Rotation/Upload/Delte
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
* $Id: maps.php,v 2.13 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   require_once("includes/functions.inc.php");
   $page_name = $lang[maps][pagename];

   if ($REQUEST_METHOD == "POST")
   {
      if ($action == "mapchange")
      {
         if (!$map)
         {
            head();
            echo $lang[maps][err_select];
            foot();
            exit;
         }

         $command = "changelevel " . $map;

         $server = connectRCON($server_addr, $server_port, $server_rcon);
         $command = $server->rcon_command($command);
         $server->disconnect();
         head();
         include_once("js/page_reload.php");
         foot();
         exit;
      }
      elseif ($action == "deletemap")
      {
         if (!$map)
         {
            $delres = $lang[maps][err_seldel];
         }
         else
         {
            if ($ftp_enable)
            {
               $map_file = $map . ".bsp";
               $delete_file = $server_mappath . "/" . $map_file;
               ftpDelete($ftp_addr, $ftp_port, $ftp_login, $ftp_password, $delete_file);
               $alert = 1;
               $message = "$product\\n\\n" . preg_replace("/%%map%%/", $map, $lang[maps][deleted]);
            }
            else
            {
               $map_file = $map . ".bsp";
               $delete_file = $server_mappath . "/" .map_file;
               @unlink($delete_file);
               $alert = 1;
               $message = "$product\\n\\n" . preg_replace("/%%map%%/", $map, $lang[maps][deleted]);
            }
         }
      }
      elseif ($action == "uploadmap")
      {
         $limit_size = "800000000"; // 8 meg size limit
         $extensions = array(".bsp");
         $sizelimit  = $limit_size/1000 . "KB";

         $ext = strrchr(strtolower($file_name), '.');

         if (!$file_name)
         {
            $uploadres = $lang[maps][ul_nofile];
         }
         elseif (file_exists("$server_mappath/$file_name"))
         {
            $uploadres = $lang[maps][ul_exists];
         }
         elseif ($limit_size < $file_size)
         {
            $uploadres = preg_replace("/%%sizelimit%%/", $sizelimit, $lang[maps][ul_sizelim]);
         }
         elseif (!in_array($ext, $extensions))
         {
            $uploadres = $lang[maps][ul_badtype];
         }
         else
         {
            if ($ftp_enable)
            {
               $alert = 1;
               @copy($file, "tmp/$file_name") or $message = "$product\\n\\n" . $lang[maps][ul_notmp];
               ftpPut($ftp_addr, $ftp_port, $ftp_login, $ftp_password, "$server_mappath/$file_name", "tmp/$file_name", FTP_BINARY);
               @unlink("tmp/$file_name");
               if (!$message)
               {
                  $message = "$product\\n\\n" . $lang[maps][ul_sucsvr];
               }
            }
            else
            {
               $alert = 1;
               @copy($file, "$server_mappath/$file_name") or $message = "$product\\n\\n" . $lang[maps][ul_nocopy];
               if (!$message)
               {
                  $message = "$product\\n\\n" . $lang[maps][ul_sucloc];
               }
            }
         }
      }
      elseif ($action == "maprotation")
      {
         if ($ftp_enable)
         {
            $map_temp = "tmp/mapcycle" . rand(100, 999) . ".txt";
            $fd = fopen($map_temp, "w") or $error = $lang[maps][rot_notrans];
            fwrite($fd, stripslashes($contents));
            fclose($fd);

            ftpPut($ftp_addr, $ftp_port, $ftp_login, $ftp_password, $server_mapcycle, $map_temp, FTP_ASCII);
         }
         else
         {
            $fd = @fopen($server_mapcycle, "w") or $error = $lang[maps][rot_badperm];
            @fwrite($fd, stripslashes($contents));
            @fclose($fd);
         }
         head();
         include_once("js/page_reload.php");
         foot();
         exit;
      }
   }	

   if ($ftp_enable)
   {
      $map_temp = "tmp/mapcycle" . rand(100, 999) . ".txt";
      $getmaps = ftpGet($ftp_addr, $ftp_port, $ftp_login, $ftp_password, $map_temp, $server_mapcycle, FTP_ASCII);
      $fd = @fopen($map_temp, "r") or $error = $lang[maps][rot_notrans];
      $contents = @fread($fd, filesize($map_temp));
      @fclose($fd);
      @unlink($map_temp);
   }
   else
   {
      $fd = @fopen($server_mapcycle, "r+") or $error = $lang[maps][rot_badperm];
      $contents = @fread($fd, filesize($server_mapcycle));
      @fclose($fd);
   }

   $server = connectRCON($server_addr, $server_port, $server_rcon);
   $status = $server->serverinfo();
   $maps = $server->servermaps();
   $server->disconnect();

   $current_map = $status[map];

   head();
   echo "      <script language=\"JavaScript\">\n";
   echo "      <!--\n";
   echo "      function verify_delete()\n";
   echo "      {\n";
   echo "         if (confirm(\"" . $lang[maps][delete1] . "\"))\n";
   echo "         {\n";
   echo "            if (confirm(\"" . $lang[maps][delete2] . "\\n\\n" . $lang[maps][delete3] . "\"))\n";
   echo "            {\n";
   echo "               document.form.submit()\n";
   echo "            }\n";
   echo "         }\n";
   echo "      }\n";
   echo "      //-->\n";
   echo "      </script>\n";
?>
      <b><u><font size=2><?php echo $page_name ?></font></u></b><br><br>
      <?php echo $lang[maps][blurb] ?>
      <br><br>
      <?php echo $lang[maps][current] ?> <b><?php echo $current_map; ?></b>
      <table border="0">
      <tr>
         <td valign="top">
         <form method="post" action="maps.php" onSubmit="submitonce(this);">
         <input type="hidden" name="action" value="mapchange">
         <b><?php echo $lang[maps][change] ?></b><br>
         <select name="map" class="select">
<?php
   $mods = array_keys($maps);

   for ($c = 0; $c < sizeof($mods); $c++)
   {
      $mod_maps = $maps[$mods[$c]];
      sort($mod_maps);

      echo "            <option value=\"\">--". $mods[$c] . " maps  --</option>\n";

      for ($m = 0; $m < sizeof($mod_maps); $m++)
      {
         echo "            <option name=\"" . $mod_maps[$m] . "\">" . $mod_maps[$m] . "</option>\n";
      }
   }
?>
         </select>
         <input type="submit" class="button" value="<?php echo $lang[maps][btn_change] ?>">
         </form>

         <form method="post" action="?upload=yes" enctype="multipart/form-data">
<?php if ($uploadres) { echo "   <font color=\"red\"><b> " . $uploadres . "</b></font><br>"; } else { echo "<br>"; } ?>
         <b><?php echo $lang[maps][uploadnew] ?><br></b>
         <input type="hidden" name="action" value="uploadmap">
         <input type="file" class="input" name="file" size="30">
         <input type="submit" class="button" value="<?php echo $lang[maps][btn_upload] ?>">
         </form>
         <form method="post" action="maps.php" name="form">
<?php if ($delres) { echo "   <font color=\"red\"><b>" . $delres . "</b></font><br>"; } else { echo "<br>"; } ?>
         <input type="hidden" name="action" value="deletemap">
         <b><?php echo $lang[maps][deletemap] ?></b><br>
         <select name="map" class="select">
<?php
   $mods = array_keys($maps);

   for ($c = 0; $c < sizeof($mods)-1; $c++)
   {
      $mod_maps = $maps[$mods[$c]];
      sort($mod_maps);

      echo "            <option value=\"\">--". $mods[$c] . " maps  --</option>\n";

      for ($m = 0; $m < sizeof($mod_maps); $m++)
      {
         echo "            <option name=\"" . $mod_maps[$m] . "\">" . $mod_maps[$m] . "</option>\n";
      }
   }
?>
         </select>
         <input type="button" class="button" onClick="verify_delete();" value="<?php echo $lang[maps][btn_delete] ?>">
         </form>
         </td>
         <td>&nbsp;&nbsp;&nbsp;</td>
         <td valign="top">
         <form method="post" action="maps.php">
         <input type="hidden" name="action" value="maprotation">
         <b><?php echo $lang[maps][rotation] ?></b>
<?php if ($error): ?>
         <br><br><font color="red"><?php echo $error ?></font><br>
<?php else: ?>
         <br>
         <textarea class="textarea" cols=30 rows=15 name="contents"><?php echo $contents; ?></textarea><br>
         <input type="submit" class="input" value="<?php echo $lang[maps][btn_rotation] ?>">
<?php endif; ?>
         </form>
         </td>
      </tr>
      </table>
<?php
   copyright();
   foot();
?>
