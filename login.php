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
*     Filename: login.php
*  Description: Control Panel Login (GSP License Only)
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
* $Id: login.php,v 2.14 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   require_once("includes/functions.inc.php");

   $page_name = $lang[login][pagename];

   if ($action == "login")
   {
      if (GetServerByLogin($dbh, $login))
      {
         $serverinfo = GetServerByLogin($dbh, $login);
         $serverinfo = $serverinfo[0];
      }

      if (!GetServerByLogin($dbh, $login))
      {
         $alert = 1;
         $message = "$product\\n\\n" . $lang[login][badlogin];
      }
      elseif ($serverinfo[password] != $password)
      {
         $alert = 1;
         $message = "$product\\n\\n" . $lang[login][badpass];
      }
      else
      {
         $exosess[login] = $serverinfo[login];
         $exosess[admin] = $serverinfo[admin];

         header("location: index.php");
      }
   }
   elseif ($action == "logout")
   {
      session_unregister("exosess");
      session_destroy();
      $alert = 1;
      $message = "$product\\n\\n" . $lang[login][logout];
   }
   head();
?>
      <font size=2><b><u><?php echo $page_name ?></u></b></font><br><br>
      <?php echo $lang[login][blurb] ?>
      <form method="post" action="login.php" onSubmit="submitonce(this);">
      <input type="hidden" name="action" value="login">
      <table>
      <tr>
         <td>Login:</td>
         <td><input type="text" class="input" name="login" maxlength="25" size="25" tabindex="1"></td>
      </tr>
      <tr>
         <td>Password:</td>
         <td><input type="password" class="input" name="password" maxlength="25" size="25" tabindex="2"></td>
      </tr>
      <tr>
         <td colspan="2"><input type="submit" class="button" value="<?php echo $lang[login][btn_login] ?>" tabindex="3"></td>
      </tr>
      </table>
      </form>
<?php
   copyright();
   foot();
?>
