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
*     Filename: execcmd.php
*  Description: Execute RCON Command
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
* $Id: execcmd.php,v 2.11 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   require_once("includes/functions.inc.php");

   $page_name = "Execute RCON Command";
   $server = connectRCON($server_addr, $server_port, $server_rcon);
   $server->disconnect();

   if ($REQUEST_METHOD == "POST")
   {
      if (preg_match("/(exit)|(restart)|(quit)/", $command))
      {
         $alert = 1;
         $message = "$product - Command Error!\\n\\nYou are now allowed to run any \"exit\" or \"restart\" commands from here.";
      }
      else
      {
         $server = connectRCON($server_addr, $server_port, $server_rcon);
         $result = $server->rcon_command(trim(stripslashes($command)));
         $server->disconnect();
      }
   }
   head();
?>
      <b><u><font size=2><?php echo $page_name ?></font></u></b><br><br>
      This is where you can run any Remote Connection (RCON) command you wish as the system (admin) user and see the results of the command you've run.
      <br><br>
      <form method="post" action="execcmd.php" onSubmit="submitonce(this);">
      <b>Command:</b>
      <input type="text" size="25" name="command" class="input" tabindex="1" value="<?php echo stripslashes($command); ?>">
      <textarea class="textarea" cols=100 rows=15 <?php if (!$result): ?>disabled<?php endif; ?>><?php echo $result ?></textarea><br>
      <input type="submit" class="button" tabindex="2" value="Execute Command">
      </form>
      Note: You are not allowed to run any commands to shutdown/restart the server, they have been blocked.
<?php
   copyright();
   foot();
?>
