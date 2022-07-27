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
*     Filename: mysql.inc.php
*  Description: MySQL Database Connection Functions
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
* $Id: mysql.inc.php,v 2.17 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   $connection = mysql_connect($mysql_host, $mysql_login, $mysql_password);
   mysql_select_db($mysql_database);

   $dbh[con] = $connection;

   function database_mysql_query(&$dbh, $query)
   {
      $dbh[ok] = 0;
      $dbh[result] = 0;
      $dbh[error] = "None";
      $dbh[query] = $query;

      $result = mysql_query($query, $dbh[con]);
      if ( $result )
      {
         $dbh[result] = $result;
         $dbh[ok] = 1;
         $dbh[error] = "None";
      }
      else
      {
         $dbh[result] = 0;
         $dbh[ok] = 0;
         $dbh[error] = mysql_error();
      }
   }

   function database_mysql_fetchrow(&$dbh)
   {
      $result = mysql_fetch_array($dbh[result]);
      return $result;
   }

   function database_mysql_insertid(&$dbh)
   {
      $id = mysql_insert_id();
      return $id;
   }

   function database_mysql_nresults(&$dbh)
   {
      $total = mysql_num_rows($dbh[result]);
      return $total;
   }

/************************************************************************
* Add/Remove/Update Server Functions
************************************************************************/
   function AddServer(&$dbh, $login, $password, $server_addr, $server_port, $server_rcon, $hltv_enable, $hltv_addr, $hltv_port, $hltv_rcon, $hltv_config, $ftp_enable, $ftp_addr, $ftp_port, $ftp_login, $ftp_password, $test_enable, $control_enable, $unix_enable, $unix_addr, $unix_login, $unix_password, $current_mod, $server_config, $server_motd, $server_mapcycle, $server_mappath, $metamod_plugins, $adminmod_config, $adminmod_plugins, $adminmod_users, $statsme_config, $statsme_motd, $clanmod_config, $hlguard_config, $plbot_config)
   {
      global $mysql_table;

      if (!$login || !$password || !$server_addr || !$server_port || !$server_rcon)
      {
         return false;
      }

      $query = "SELECT server_id FROM $mysql_table WHERE login = '$login'";
      database_mysql_query($dbh, $query);

      if ($dbh[ok])
      {
         $data = database_mysql_fetchrow($dbh);

         if ($data[server_id])
         {
            return false;
         }

         $now = time();
         $query = "INSERT INTO $mysql_table VALUES('', $now, '$login', '$password', '$server_addr', $server_port, '$server_rcon', $hltv_enable, '$hltv_addr', $hltv_port, '$hltv_rcon', '$hltv_config', $ftp_enable, '$ftp_addr', $ftp_port, '$ftp_login', '$ftp_password', $test_enable, $control_enable, $unix_enable, '$unix_addr', '$unix_login', '$unix_password', '$current_mod', '$server_config', '$server_motd', '$server_mapcycle', '$server_mappath', '$metamod_plugins', '$adminmod_config', '$adminmod_plugins', '$adminmod_users', '$statsme_config', '$statsme_motd', '$clanmod_config', '$hlguard_config', '$plbot_config')";
         database_mysql_query($dbh, $query);

         if ($dbh[ok])
         {
            $id = database_mysql_insertid($dbh);
            return $id;
         }
         return false;
      }
      return false;
   }

   function UpdateServer(&$dbh, $server_id, $login, $password, $server_addr, $server_port, $server_rcon, $hltv_enable, $hltv_addr, $hltv_port, $hltv_rcon, $hltv_config, $ftp_enable, $ftp_addr, $ftp_port, $ftp_login, $ftp_password, $test_enable, $control_enable, $unix_enable, $unix_addr,  $unix_login, $unix_password, $current_mod, $server_config, $server_motd, $server_mapcycle, $server_mappath, $metamod_plugins, $adminmod_config, $adminmod_plugins, $adminmod_users, $statsme_config, $statsme_motd, $clanmod_config, $hlguard_config, $plbot_config)
   {
      global $mysql_table;

      if (!$login || !$password || !$server_addr || !$server_port || !$server_rcon)
      {
         return false;
      }

      $query = "UPDATE $mysql_table SET login = '$login', password = '$password', server_addr = '$server_addr', server_port = $server_port, server_rcon = '$server_rcon', hltv_enable = $hltv_enable, hltv_addr = '$hltv_addr', hltv_port = $hltv_port, hltv_rcon = '$hltv_rcon', hltv_config = '$hltv_config', ftp_enable = $ftp_enable, ftp_addr = '$ftp_addr', ftp_port = $ftp_port, ftp_login = '$ftp_login', ftp_password = '$ftp_password', test_enable = $test_enable, control_enable = $control_enable, unix_enable = $unix_enable, unix_addr = '$unix_addr', unix_login = '$unix_login', unix_password = '$unix_password', current_mod = '$current_mod', server_config = '$server_config', server_motd = '$server_motd', server_mapcycle = '$server_mapcycle', server_mappath = '$server_mappath', metamod_plugins = '$metamod_plugins', adminmod_config = '$adminmod_config', adminmod_plugins = '$adminmod_plugins', adminmod_users = '$adminmod_users', statsme_config = '$statsme_config', statsme_motd = '$statsme_motd', clanmod_config = '$clanmod_config', hlguard_config = '$hlguard_config', plbot_config = '$plbot_config' WHERE server_id = $server_id";
      database_mysql_query($dbh, $query); 

      if ($dbh[ok])
      {
         return true;
      }
      return false;
   }

   function DeleteServer(&$dbh, $server_id)
   {
      global $mysql_table;

      if (!$server_id)
      {
         return false;
      }

      $query = "DELETE FROM $mysql_table WHERE server_id = $server_id";
      database_mysql_query($dbh, $query);

      if ($dbh[ok])
      {
         return true;
      }
      return false;
   }

   function GetAllServers(&$dbh, $page, $page_per)
   {
      global $mysql_table;

      $page -= 1;
      if ($page < 1)
      {
         $begin_index = 0;
      }
      else
      {
         $begin_index = $page * $page_per;
      }

      if ($page_per)
      {
         $query = "SELECT * FROM $mysql_table ORDER BY server_id ASC LIMIT $begin_index, $page_per";
      }
      else
      {
         $query = "SELECT * FROM $mysql_table ORDER BY server_id ASC";
      }
      database_mysql_query($dbh, $query);

      if ($dbh[ok])
      {
         while ($data = database_mysql_fetchrow($dbh))
         {
            $users[] = $data;
         }
         return $users;
      }
      return false;
   }

   function GetServerByLogin(&$dbh, $login)
   {
      global $mysql_table;

      $query = "SELECT * FROM $mysql_table WHERE login = '$login' ORDER BY login ASC" ;
      database_mysql_query($dbh, $query) ;

      if ($dbh[ok])
      {
         while ($data = database_mysql_fetchrow($dbh))
         {
            $users[] = $data;
         }
         return $users;
      }
      return false;
   }

   function GetServerById(&$dbh, $server_id)
   {
      global $mysql_table;

      $query = "SELECT * FROM $mysql_table WHERE server_id = $server_id ORDER BY server_id ASC" ;
      database_mysql_query($dbh, $query) ;

      if ($dbh[ok])
      {
         while ($data = database_mysql_fetchrow($dbh))
         {
            $users[] = $data;
         }
         return $users;
      }
      return false;
   }

   function TotalServers(&$dbh)
   {
      global $mysql_table;

      $query = "SELECT count(*) AS total FROM $mysql_table";
      database_mysql_query($dbh, $query);

      if ($dbh[ok])
      {
         $data = database_mysql_fetchrow($dbh);
         return $data[total];
      }
      return false;
   }

   function UpdateRowValue(&$dbh, $server_id, $row, $value)
   {
      global $mysql_table;

      if (!$server_id || !$row || !$value)
      {
         return false;
      }

      $query = "UPDATE $mysql_table SET $row = '$value' WHERE server_id = $server_id";
      database_mysql_query($dbh, $query);

      if ($dbh[ok])
      {
         return true;
      }
      return false;
   }

   function CheckServer(&$dbh, $login)
   {
      global $mysql_table;

      if (!$login)
      {
         return false;
      }

      $query = "SELECT * FROM $mysql_table WHERE login = '$login'";
      database_mysql_query($dbh, $query);

      if ($dbh[ok])
      {
         $data = database_mysql_fetchrow($dbh);
         if ($data[login])
         {
            return $data[login];
         }
      }
      return false;
   }

   function CreatePageString(&$dbh, $current_page, $url, $page_per, $total_contacts)
   {
      if (!$page_per || !$total_contacts)
      {
         return false;
      }

      if (!$current_page)
      {
         $current_page = 1;
      }

      $page_buffer = 3;  // num of pages to show before current page
      $page_max = 6;    // max no. of pages to display
      $page_string = "";
      $pages = floor($total_contacts / $page_per);
      $remainder = ($total_contacts % $page_per);

      if ($remainder > 0)
      {
         $pages += 1;
      }

      $difference = $current_page - $page_buffer;
      if ($difference >= 1)
      {
         $page_start = $difference;
      }
      else
      {
         $page_start = 1;
      }

      $buffer_end = ($current_page + ($page_max - $page_buffer));
      if ($buffer_end <= $pages)
      {
         if ($buffer_end < $page_max)
         {
            $page_end = $page_start + $page_max;
         }
         else
         {
            $page_end = $buffer_end;
         }
      }
      else
      {
         $page_end = $pages;
      }

      if ($page_start > 1)
      {
         $page_string = "<a href=\"$url&page=1\">first</a> - ";
      }

      if ($pages < $page_max)
      {
         $page_end = $pages;
      }

      for ($page = $page_start; $page <= $page_end ; ++$page)
      {
         if ($page == $current_page)
         {
            $page_string .= "<font size=1><b>$page</b></font> - ";
         }
         else
         {
            $page_string .= "<a href=\"$url&page=$page\">$page</a> - ";
         }
      }

      if ($page_end < $pages)
      {
         $page_string .= "<a href=\"$url&page=$pages\">last</a>";
      }
      else
      {
         $page_string = substr($page_string, 0, strlen($page_string) - 2);
      }
      return "$page_string\n";
   }
?>
