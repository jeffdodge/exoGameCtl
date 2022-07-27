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
*     Filename: functions.inc.php
*  Description: Main Software Functions
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
* $Id: functions.inc.php,v 2.41 2003/09/23 08:31:30 exodus Exp $
************************************************************************/
   $name    = "exoGameCtl";
   $vernum  = "2.0.7";
   $coding  = "i"; // s/i/z (sg/ion/zend)

   $version = $vernum . $coding;
   $product = $name . " " . $version;
   $now     = time();

   switch ($coding)
   {
      case "i": $encoding = "ionCube"; break;
      case "s": $encoding = "SourceGuardian"; break;
      case "z": $encoding = "Zend"; break;
      default: $encoding = "Source Code"; break;
   }

   if (file_exists("includes/engine.inc.php"))
   {
      include_once("includes/engine.inc.php");
   }
   else
   {
      echo "<tt><font color=red>Unable to open required license files!</font></tt>"; exit;
   }

   if (!function_exists("licValidate"))
   {
      echo "<tt><font color=red>Unable to open required license files!</font></tt>";
      exit;
   }
   $licdata = licValidate("license.dat", "JDEkeHIzNnJPQjckZmZXSDdzVTJNU3l0OW1ZSHJGRDI4Lw", "cd0f597045deba9b18b11079454d9d82e6139baf1cb2b9", "b7ec358595dbf015f3b7b3fcf603ea4a61b92db920918e");
   switch ($licdata)
   {
      case 0: $message = "Unable to open key file!"; $icon = i; break;
      case 1: $message = "Invalid key file!"; $icon = e; break;
      case 2: $message = "Your install domain does not match the license key!"; $icon = e; break;
      case 3: $message = "This license has expired!"; $icon = i; break;
   }
   if (count($licdata) <= 1)
   {
      $message = "$message<br>Please contact <a href=\"mailto:licenses@exocontrol.com\" style=\"color: #000000; font-weight: bold;\">licenses@exocontrol.com</a>.";

      genError("License Error", $message, $icon);
      exit;
   }

   if ($licdata[expire] == "never")
   {
      $timelim = false;
   }
   else
   {
      $date = date("m-d-Y", $now);
      $exp_date = date("m-d-Y", $licdata[expire]);
      $time = date("G:i:s", $now);
      $exp_time = date("G:i:s", $licdata[expire]);
      list($exp_month,$exp_day,$exp_year) = explode("-", $exp_date);
      list($month,$day,$year) = explode("-", $date);
      list($hour,$minute,$second) = explode(":", $time);
      list($exp_hour,$exp_minute,$exp_second) = explode(":", $exp_time);
      $warnday = mktime($exp_hour,$exp_minute,$exp_second,$exp_month,$exp_day-3,$exp_year);
      $expire = $licdata[expire];
      $timelim = true;
   }

   if (!preg_match("/MSIE/", $_SERVER[HTTP_USER_AGENT]))
   {
      echo "<tt><font color=red>$product is only designed for Microsoft Internet Explorer.<br><br>We are working on a Mozilla design for v2.1!<br><br>Sorry for any inconvenence.</font></tt>";
      exit;
   }

   if ((!is_writable("./tmp")) || (!is_writable("./includes")))
   {
      echo "<tt><font color=red>Your tmp/ and includes/ directories MUST be writable.</font></tt>";
      exit;
   }

   if (!file_exists("includes/config.inc.php"))
   {
      if (!preg_match("/misc.php/", $PHP_SELF))
      {
         if (!preg_match("/install.php/", $PHP_SELF))
         {
            header("location: install.php");
            exit;
         }
      }
   }
   else
   {
         include_once("includes/config.inc.php");
   }

   if (!preg_match("/install.php/", $PHP_SELF))
   {
      if ($lang_pack)
      {
         if (file_exists("lang_packs/$lang_pack.php"))
         {
            include_once("lang_packs/$lang_pack.php");
         }
         else
         {
            echo "<tt><font color=red>Missing language pack!</font></tt>";
            exit;
         }
      }
      else
      {
         if (!preg_match("/misc.php/", $PHP_SELF))
         {
            echo "<tt><font color=red>Language is not set.</font></tt>";
            exit;
         }
      }
   }

   if (($licdata[product_edition] == "GSP License") || ($licdata[product_edition] == "ISP License") || ($licdata[product_edition] == "Source License"))
   {
      if ($gsp_enable)
      {
         include_once("includes/mysql.inc.php");
         if (!@mysql_connect($mysql_host, $mysql_login, $mysql_password))
         {
            echo "<tt><font color=red>Unable to connect to MySQL Database</font></tt>";
            exit;
         }
         elseif (!@mysql_select_db($mysql_database))
         {
            echo "<tt><font color=red>Unable to select MySQL Database</font></tt>";
            exit;
         }

         session_start();
         if (!$exosess)
         {
            session_register("exosess");
            $exosess = array();
         }

         if ( (!preg_match("/login.php/", $PHP_SELF)) && (!preg_match("/gspadmin.php/", $PHP_SELF)) && (!preg_match("/pubinfo.php/", $PHP_SELF)) && ($firstlogin != "true"))
         {
            if (!$exosess[login])
            {
               header("location: login.php");
            }
            elseif ($exosess[admin])
            {
               $admin = true;
            }
         }

         $serverinfo       = GetServerByLogin($dbh, $exosess[login]);
         $serverinfo       = $serverinfo[0];
         $server_addr      = $serverinfo[server_addr];
         $server_port      = $serverinfo[server_port];
         $server_rcon      = $serverinfo[server_rcon];
         $hltv_enable      = $serverinfo[hltv_enable];
         $hltv_addr        = $serverinfo[hltv_addr];
         $hltv_port        = $serverinfo[hltv_port];
         $hltv_rcon        = $serverinfo[hltv_rcon];
         $hltv_config      = $serverinfo[hltv_config];
         $ftp_enable       = $serverinfo[ftp_enable];
         $ftp_addr         = $serverinfo[ftp_addr];
         $ftp_port         = $serverinfo[ftp_port];
         $ftp_login        = $serverinfo[ftp_login];
         $ftp_password     = $serverinfo[ftp_password];
         $test_enable      = $serverinfo[test_enable];
         $control_enable   = $serverinfo[control_enable];
         $unix_enable      = $serverinfo[unix_enable];
         $unix_addr        = $serverinfo[unix_addr];
         $unix_login       = $serverinfo[unix_login];
         $unix_password    = $serverinfo[unix_password];
         $server_config    = $serverinfo[server_config];
         $server_motd      = $serverinfo[server_motd];
         $server_mapcycle  = $serverinfo[server_mapcycle];
         $server_mappath   = $serverinfo[server_mappath];
         $metamod_plugins  = $serverinfo[metamod_plugins];
         $adminmod_config  = $serverinfo[adminmod_config];
         $adminmod_plugins = $serverinfo[adminmod_plugins];
         $adminmod_users   = $serverinfo[adminmod_users];
         $statsme_config   = $serverinfo[statsme_config];
         $statsme_motd     = $serverinfo[statsme_motd];
         $clanmod_config   = $serverinfo[clanmod_config];
         $hlguard_config   = $serverinfo[hlguard_config];
         $plbot_config     = $serverinfo[plbot_config];
      }
   }
   else
   {
      if ($gsp_enable)
      {
         echo "<tt><font color=red>You must have an GSP License to enable the GSP Functions!";
         echo "<br><br>";
         echo "You MUST disable the GSP Functions or get an GSP License for exoGameCtl to function.</font></tt>";
         exit;
      }
   }

   if ($licdata[product_edition] == "Demo License")
   {
      if (!$auth_enable)
      {
         $auth_enable = true;
         $auth_login = "demo_user";
         $auth_password = "demo_pass";
      }
      $registered = false;
   }
   else
   {
      $registered = true;
   }

   function CallHome($data)
   {
      if (!($fp = fsockopen("216.67.238.73", 80)))
         return false;

      $header .= "POST /members/verify.php HTTP/1.0\r\n";
      $header .= "Host: www.exocontrol.com\r\n";
      $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
      $header .= "Content-length: " . strlen($data) . "\r\n\r\n";

      fputs($fp, $header . $data);

      while (!feof($fp))
         $result .= fgets($fp, 1024);

      fclose($fp);

      $result = explode("Content-Type: text/html", $result);
      $result = trim($result[1]);

      return $result;
   }

   function checkForUpgrade()
   {
     global $coding;

     $home_url = "http://216.67.238.73/~exodus/members/verify.php?action=upgcheck&enc=$coding";

     $fp = @fopen($home_url, "r");
     $response = @fread($fp, 10);
     @fclose($fp);

     return $response;
   }

   function htauth()
   {
      global $product, $auth_enable, $auth_login, $auth_password;
      global $PHP_AUTH_USER, $PHP_AUTH_PW;

      if (!$auth_enable)
      {
         return;
      }

      if (($PHP_AUTH_USER != $auth_login) || ($PHP_AUTH_PW != $auth_password))
      {
         header("WWW-Authenticate: Basic realm=\"$product\"");
         header("HTTP/1.0 401 Unauthorized");

         echo "<tt><font color=red>Authorization Failure</font></tt>";
         exit;
      }
   }

   function encode_page($content)
   {
      global $version, $licdata;

      $content = str_replace("<body", "<body onContextMenu=\"return false;\" onSelectStart=\"return false;\" onDragStart=\"return false;\" ", $content);
      $content = str_replace("<img", "<img galleryimg=\"no\" ", $content);
      $content.= "<script language=\"JavaScript\">function noStatus() { window.status=\"exoGameCtl $version ($licdata[company])\"; setTimeout(\"noStatus()\",5) } noStatus() $eval_alert</script>";

      $table = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_@";
      $xor = 165;

      $table = array_keys(count_chars($table, 1));
      $i_min = min($table);
      $i_max = max($table);

      for ($c = count($table); $c > 0; $r = mt_rand(0, $c--))
         array_splice($table, $r, $c - $r, array_reverse(array_slice($table, $r, $c - $r)));

      $len = strlen($content);
      $word = $shift = 0;

      for ($i = 0; $i < $len; $i++)
      {
         $ch = $xor ^ ord($content[$i]);
         $word |= ($ch << $shift);
         $shift = ($shift + 2) % 6;
         $enc .= chr($table[$word & 0x3F]);
         $word >>= 6;
         if (!$shift)
         {
            $enc .= chr($table[$word]);
            $word >>= 6;
         }
      }

      if ($shift)
         $enc .= chr($table[$word]);

      $tbl = array_fill($i_min, $i_max - $i_min + 1, 0);

      while (list($k,$v) = each($table))
         $tbl[$v] = $k;

      $tbl = implode(",", $tbl);

      $fi = ",p=0,s=0,w=0,t=Array({$tbl})";
      $f  = "w|=(t[x.charCodeAt(p++)-{$i_min}])<<s;";
      $f .= "if(s){r+=String.fromCharCode({$xor}^w&255);w>>=8;s-=2}else{s=6}";

      $jsdec = "function gctlRun(x){";
      $jsdec.= "var l=x.length,b=1024,i,j,r{$fi};";
      $jsdec.= "for(j=Math.ceil(l/b);j>0;j--){r='';for(i=Math.min(l,b);i>0;i--,l--){{$f}}document.write(r)}}";

      for ($c=0; $c < strlen($jsdec); $c++)
      {
         $encoded = ord(substr($jsdec, $c));
         $rnd_letter = chr(rand(64, 90));
         if (rand(0,1))
            $rnd_letter = chr(rand(95, 122));
         $dec .= $rnd_letter . dechex($encoded);
         $dec = str_replace("`", "_", $dec);
      }

      $nfo[0] = "\n\n\n\x3c\x21\x2d\x2d\xd\xa\xd\xa\x65\x78\x6f\x47\x61\x6d\x65\x43\x74\x6c\x20\x5b";
      $nfo[1] = "\x5d\x20\x2d\x20\x48\x61\x6c\x66\x2d\x4c\x69\x66\x65\x20\x53\x65\x72\x76\x65\x72\x20\x43\x6f\x6e\x74\x72\x6f\x6c\x20\x50\x61\x6e\x65\x6c\xd\xa\x43\x6f\x70\x79\x72\x69\x67\x68\x74\x20\x28\x63\x29\x32\x30\x30\x32\x2d\x32\x30\x30\x33\x20\x53\x74\x72\x65\x65\x6d\x4c\x69\x6e\x65\x2c\x20\x4c\x4c\x43\x2e\x20\x20\x41\x6c\x6c\x20\x52\x69\x67\x68\x74\x73\x20\x52\x65\x73\x65\x72\x76\x65\x64\x2e\xd\xa\x4c\x69\x63\x65\x6e\x73\x65\x64\x20\x74\x6f\x3a\x0";
      $nfo[2] = "\n\n\x41\x6e\x79\x20\x61\x6e\x61\x6c\x79\x73\x69\x73\x20\x6f\x66\x20\x74\x68\x69\x73\x20\x20\x73\x6f\x75\x72\x63\x65\x20\x63\x6f\x64\x65\x2c\x20\x20\x65\x6d\x62\x65\x64\x64\x65\x64\x20\x64\x61\x74\x61\x20\x20\x6f\x72\x20\x66\x69\x6c\x65\x20\x62\x79\x20\x61\x6e\x79\x20\x6d\x65\x61\x6e\x73\x20\x61\x6e\x64\x20\x62\x79\xd\xa\x61\x6e\x79\x20\x65\x6e\x74\x69\x74\x79\x20\x77\x68\x65\x74\x68\x65\x72\x20\x68\x75\x6d\x61\x6e\x20\x6f\x72\x20\x6f\x74\x68\x65\x72\x77\x69\x73\x65\x20\x20\x74\x6f\x20\x69\x6e\x63\x6c\x75\x64\x69\x6e\x67\x20\x62\x75\x74\x20\x77\x69\x74\x68\x6f\x75\x74\x20\x20\x6c\x69\x6d\x69\x74\x61\x74\x69\x6f\x6e\x20\x74\x6f\xd\xa\x64\x69\x73\x63\x6f\x76\x65\x72\x20\x64\x65\x74\x61\x69\x6c\x73\x20\x20\x6f\x66\x20\x69\x6e\x74\x65\x72\x6e\x61\x6c\x20\x6f\x70\x65\x72\x61\x74\x69\x6f\x6e\x2c\x20\x74\x6f\x20\x20\x72\x65\x76\x65\x72\x73\x65\x20\x20\x65\x6e\x67\x69\x6e\x65\x65\x72\x2c\x20\x74\x6f\x20\x20\x64\x65\x2d\x63\x6f\x6d\x70\x69\x6c\x65\xd\xa\x6f\x62\x6a\x65\x63\x74\x20\x63\x6f\x64\x65\x2c\x20\x6f\x72\x20\x74\x6f\x20\x6d\x6f\x64\x69\x66\x79\x20\x20\x66\x6f\x72\x20\x74\x68\x65\x20\x70\x75\x72\x70\x6f\x73\x65\x73\x20\x20\x6f\x66\x20\x6d\x6f\x64\x69\x66\x79\x69\x6e\x67\x20\x62\x65\x68\x61\x76\x69\x6f\x72\x20\x6f\x72\x20\x73\x63\x6f\x70\x65\x20\x6f\x66\xd\xa\x74\x68\x65\x69\x72\x20\x75\x73\x61\x67\x65\x20\x69\x73\x20\x66\x6f\x72\x62\x69\x64\x64\x65\x6e\x2e\xd\xa\xd\xa\x2d\x2d\x3e\x0";

      $page.= $nfo[0] . $version . $nfo[1] . $licdata[company] . $nfo[2];
      for ($c=0; $c <= 100; $c++) { $page.= "\n"; }
      $page.= "<script language=\"JavaScript\">";
      $page.= "c=\"$dec\";";
      $page.= "eval(unescape(\"%64%3d%22%22%3b%66%6f%72%28%69%3d%30%3b%69%3c%63%2e%6c%65%6e%67%74%68%3b%69%2b%2b%29%69%66%28%69%25%33%3d%3d%30%29%64%2b%3d%22%25%22%3b%65%6c%73%65%20%64%2b%3d%63%2e%63%68%61%72%41%74%28%69%29%3b%65%76%61%6c%28%75%6e%65%73%63%61%70%65%28%64%29%29%3b%64%3d%22%22%3b\"));";
      $page.= "gctlRun(\"{$enc}\");";
      $page.= "</script><noscript>In order to view this page you need a JavaScript enabled browser.</noscript>";

      return $page;
   }

   function head()
   {
      global $page_name, $product, $body_extra, $htmlcrypt;
      header("Expires: Tue, 16 Dec 1980 05:00:00 GMT");
      header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
      header("Cache-Control: no-store, no-cache, must-revalidate");
      header("Cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");

      htauth();
      if ($htmlcrypt != "no_crypt_html_or_js")
      {
         ob_start("encode_page");
      }
      @include_once("includes/header.inc.php");
   }

   class zipfile
   {
      var $datasec      = array();
      var $ctrl_dir     = array();
      var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
      var $old_offset   = 0;

      function unix2DosTime($unixtime = 0)
      {
         $timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);

         if ($timearray['year'] < 1980)
         {
            $timearray['year']    = 1980;
            $timearray['mon']     = 1;
            $timearray['mday']    = 1;
            $timearray['hours']   = 0;
            $timearray['minutes'] = 0;
            $timearray['seconds'] = 0;
         }

         return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) | ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
      }

      function addFile($data, $name, $time = 0)
      {
         $name     = str_replace('\\', '/', $name);
         $dtime    = dechex($this->unix2DosTime($time));
         $hexdtime = '\x' . $dtime[6] . $dtime[7]
                   . '\x' . $dtime[4] . $dtime[5]
                   . '\x' . $dtime[2] . $dtime[3]
                   . '\x' . $dtime[0] . $dtime[1];

         eval('$hexdtime = "' . $hexdtime . '";');

         $fr   = "\x50\x4b\x03\x04";
         $fr   .= "\x14\x00";
         $fr   .= "\x00\x00";
         $fr   .= "\x08\x00";
         $fr   .= $hexdtime;

         $unc_len = strlen($data);
         $crc     = crc32($data);
         $zdata   = gzcompress($data);
         $zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2);
         $c_len   = strlen($zdata);
         $fr      .= pack('V', $crc);
         $fr      .= pack('V', $c_len);
         $fr      .= pack('V', $unc_len);
         $fr      .= pack('v', strlen($name));
         $fr      .= pack('v', 0);
         $fr      .= $name;
         $fr      .= $zdata;
         $fr .= pack('V', $crc);
         $fr .= pack('V', $c_len);
         $fr .= pack('V', $unc_len);

         $this -> datasec[] = $fr;
         $new_offset        = strlen(implode('', $this->datasec));

         $cdrec = "\x50\x4b\x01\x02";
         $cdrec .= "\x00\x00";
         $cdrec .= "\x14\x00";
         $cdrec .= "\x00\x00";
         $cdrec .= "\x08\x00";
         $cdrec .= $hexdtime;
         $cdrec .= pack('V', $crc);
         $cdrec .= pack('V', $c_len);
         $cdrec .= pack('V', $unc_len);
         $cdrec .= pack('v', strlen($name) );
         $cdrec .= pack('v', 0 );
         $cdrec .= pack('v', 0 );
         $cdrec .= pack('v', 0 );
         $cdrec .= pack('v', 0 );
         $cdrec .= pack('V', 32 );
         $cdrec .= pack('V', $this -> old_offset );

         $this -> old_offset = $new_offset;
         $cdrec .= $name;
         $this -> ctrl_dir[] = $cdrec;
      }

      function file()
      {
         $data    = implode('', $this -> datasec);
         $ctrldir = implode('', $this -> ctrl_dir);

         return $data . $ctrldir . $this -> eof_ctrl_dir . pack('v', sizeof($this -> ctrl_dir)) . pack('v', sizeof($this -> ctrl_dir)) . pack('V', strlen($ctrldir)) . pack('V', strlen($data)) . "\x00\x00";
      }
   }

   function ftpList($host, $port, $login, $password, $file)
   {
      if (!$host || !$login || !$password)
      {
         return false;
      }
      elseif (!$port)
      {
         $port = 21;
      }

      $ftpconn = @ftp_connect($host, $port);
      $login = @ftp_login($ftpconn, $login, $password);
      if (!$file)
      {
         $file = @ftp_pwd($ftpconn);
         $list = ftp_nlist($ftpconn, $file);
      }
      else
      {
         $list = ftp_nlist($ftpconn, $file);
      }

      if (!$ftpconn || !$login || !$list)
      {
         return false;
      }
      return $list;
   }

   function ftpGet($host, $port, $login, $password, $local_file, $remote_file, $ftp_mode)
   {
      if (!$host || !$login || !$password || !$local_file || !$remote_file)
      {
         return false;
      }
      elseif (!$port)
      {
         $port = 21;
      }

      $ftpconn = ftp_connect($host, $port);
      $login = @ftp_login($ftpconn, $login, $password);
      $get = @ftp_get($ftpconn, $local_file, $remote_file, $ftp_mode);
      @ftp_close($ftpconn);

      if (!$ftpconn || !$login || !$get)
      {
         return false;
      }
      return true;
   }

   function ftpPut($host, $port, $login, $password, $remote_file, $local_file, $ftp_mode)
   {
      if (!$host || !$login || !$password || !$remote_file || !$local_file)
      {
         return false;
      }
      elseif (!$port)
      {
         $port = 21;
      }

      $ftpconn = @ftp_connect($host, $port);
      $login = @ftp_login($ftpconn, $login, $password);
      $put = @ftp_put($ftpconn, $remote_file, $local_file, $ftp_mode);
      @ftp_close($ftpconn);

      if (!$ftpconn || !$login || !$put)
      {
         return false;
      }
      return true;
   }

   function ftpDelete($host, $port, $login, $password, $remote_file)
   {
      if (!$host || !$login || !$password || !$remote_file)
      {
         return false;
      }
      elseif (!$port)
      {
         $port = 21;
      }

      $ftpconn = @ftp_connect($host, $port);
      $login = @ftp_login($ftpconn, $login, $password);
      $delete = @ftp_delete($ftpconn, $remote_file);
      @ftp_close($ftpconn);

      if (!$ftpconn || !$login || !$delete)
      {
         return false;
      }
      return true;
   }

   function copyright()
   {
     global $timelim, $product, $licdata, $warnday, $now, $expire, $info_type, $info_line1, $info_line2, $info_line3;

     if ($licdata[product_edition] != "Demo License")
     {
        if ($info_type == "custom")
        {
           echo "      <hr size=1>\n";
           echo "      <font face=\"Verdana\" size=\"1\">\n";
           echo "      $info_line1<br>\n";
           echo "      $info_line2<br>\n";
           echo "      $info_line3\n";
        }
        elseif ($info_type == "none")
        {
           echo "";
        }
        else
        {
           echo "      <hr size=1>\n";
           echo "      <font face=\"Verdana\" size=\"1\">\n";
           echo "      $product ($licdata[company])<br>\n";
           echo "      Copyright &copy;2002-2003 <a href=\"http://www.jeffdodge.com\">Jeff Dodge Technologies</a>.<br>\n";
           echo "      <a href=\"mailto:info@exocontrol.com\">info@exocontrol.com</a>\n";
           echo "      <br><br><br>\n";
        }

        if ($timelim)
        {
           if ($warnday <= $now)
           {
              echo "      <br><br>\n";
              echo "      Your license is about to expire and this copy of $product<br>";
              echo "      will cease to function on: <font color=\"red\">". date("D, M d, Y h:i:s T", $expire) ."</font><br><br>";
           }
        }
        $registered = true;
     }
     else
     {
        echo "      <hr size=1>\n";
        echo "      <font face=\"Verdana\" size=\"1\">\n";
        echo "      <font color=red>Evaluation Copy (Expires: ". date("D, M d, Y h:i:s T", $expire) .")</font><br>";
        echo "      $product<br>";
        echo "      Copyright &copy;2002-2003 <a href=\"http://www.jeffdodge.com\">Jeff Dodge Technologies</a>.<br>\n";
        echo "      <a href=\"mailto:info@exocontrol.com\">info@exocontrol.com</a><br><br>\n";
        echo "      NOTE:<br>";
        echo "      This is an unlicensed, time limited copy of $product.  If you like this control panel please purchase ";
        echo "      a license for it.  A Standard License is valid for 1 year and allows you control your own game server.";
        echo "      <br><br>";
        echo "      If you are an GSP you may purchase an GSP License which is also valid for 1 year but it allows you to ";
        echo "      control an unlimited amount of gameservers and has extra GSP features which make server installation, ";
        echo "      configuration, and management a snap.";
        echo "      <br><br>";
        echo "      Contact <a href='mailto:licenses@exocontrol.com?subject=I need a license for $product!'>licenses@exocontrol.com</a> for more information on obtaining a license.<br><br>";
        $registered = false;
     }
   }

   function foot()
   {
      global $version, $licdata;
      include_once("includes/footer.inc.php");
   }

   if (file_exists("includes/rcon.inc.php"))
   {
      require_once("includes/rcon.inc.php");
   }
   else
   {
      echo "<tt><font color=red>Unable to open required server connection files!</font></tt>";
      exit;
   }

   function connectRCON($ip, $port, $pass)
   {
      global $control_enable;

      $server = new rcon();

      if (!($server->connect($ip, $port, $pass)))
      {
         head();
         echo "      <tt><font size=2 color=red>Server not available.</font></tt>";
         if ($control_enable)
         {
            echo "      <br><br>";
            echo "      <tt><font size=2 color=black>Click <a href=\"control.php\">here</a> for \"server control\".</font></tt>";
         }
         foot();
         exit;
      }
      else
      {
         $status = $server->serverinfo();

         if (trim($status) == "Bad rcon_password.")
         {
            head();
            echo "      <tt><font size=2 color=red>Incorrect RCON password.</font></tt><br><br>";
            echo "      <tt><font size=2>Please contact the administrator to manually change your RCON password.</font></tt>";
            foot();
            exit;
         }
         elseif (!$status[ip])
         {
            head();
            echo "      <tt><font size=2 color=red>Check your servers port settings.</font></tt>";
            if ($control_enable)
            {
               echo "      <br><br>";
               echo "      <tt><font size=2 color=black>Click <a href=\"control.php\">here</a> for \"server control\".</font></tt>";
            }
            foot();
            exit;
         }
         return $server;
      }
   }
?>
