<?php

   if (file_exists("includes/db_update.txt"))
   {
      echo "Your database has already been updated!";
      exit;
   }

   if (file_exists("includes/config.inc.php"))
      include_once("includes/config.inc.php");

   if ($REQUEST_METHOD == "POST")
   {
      @mysql_pconnect($frm_mysql_addr, $frm_mysql_login, $frm_mysql_password) or die("db connect error");
      mysql_select_db($frm_mysql_database);
      mysql_query("ALTER TABLE `exo_users` ADD `current_mod` VARCHAR( 2 ) NOT NULL AFTER `unix_password` ;");
      mysql_close();

      $fd = fopen("includes/db_update.txt", "w+");
      fclose($fd);

      echo "Database Update Completed Successfully!";
      exit;
   }
?>
<html>
<head>
<title>exoGameCtl Database Update</title>
</head>

<body bgcolor="#ffffff" text="#000000">
<font face="Verdana" size="2">
<b>exoGameCtl v2.0.7 - Database Update</b>
<br><br>
There have been some minor changes to the database structure of exoGameCtl v2.0.7.
<br><br>
Please enter your database information below and hit the submit button.
<form method="post" action="db_update.php">
<table border=0>
<tr>
   <td>Database Host:</td>
   <td><input type="text" name="frm_mysql_addr" value="<?php echo $mysql_host ?>"></td>
</tr>
<tr>
   <td>Database Login:</td>
   <td><input type="text" name="frm_mysql_login" value="<?php echo $mysql_login ?>"></td>
</tr>
<tr>
   <td>Database Password:</td>
   <td><input type="text" name="frm_mysql_password" value="<?php echo $mysql_password ?>"></td>
</tr>
<tr>
   <td>Database Name:</td>
   <td><input type="text" name="frm_mysql_database" value="<?php echo $mysql_database ?>"></td>
</tr>
<tr>
   <td>Database Table:</td>
   <td><input type="text" name="frm_mysql_table" value="<?php echo $mysql_table ?>"></td>
</tr>
<tr>
   <td><input type="submit" value="Update Database"></td>
</tr>
</table>
</form>
