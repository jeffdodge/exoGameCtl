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
*     Filename: English.php
*  Description: English language file.  All text seen in exoGameCtl.
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
* $Id: English.php,v 1.14 2003/09/23 08:00:00 exodus Exp $
************************************************************************/
$lang = array();  // MUST initialize, DO NOT CHANGE!


/***************** ONLY MAKE CHANGES BELOW THIS LINE! ******************/

// login.php
$lang[login][pagename] = "Control Panel Login";
$lang[login][blurb] = "Please enter your servers login name and password below and you will be logged into the control panel so that you can manage your gameserver.";
$lang[login][btn_login] = " Login ";
$lang[login][badlogin] = "Invalid Control Panel Login!";
$lang[login][badpass] = "Invalid Control Panel Password!";
$lang[login][logout] = "You have been successfully logged out!";

// index.php
$lang[index][pagename] = "Server Information";
$lang[index][blurb] = "This is where you can get all of the information about the gameserver which you are controlling. When players begin to login to the server you will see their information show up below the map picture, you will then be able to kick them from the server, temp ban them (5 min), and perm ban them from the server.";
$lang[index][no_active] = "There are currently no active players.";
$lang[index][no_bans] = "There are currently no active bans.";
$lang[index][conn_player] = "Connecting Player";
$lang[index][in_as] = "Logged in as";
$lang[index][serv_ip] = "Server IP:";
$lang[index][serv_name] = "Server Name:";
$lang[index][curr_map] = "Current Map:";
$lang[index][gamemod] = "Game/Mod:";
$lang[index][players] = "Players:";
$lang[index][activeplyrs] = "Active Players:";
$lang[index][activebans] = "Active Bans:";
$lang[index][plyr_id] = "ID";
$lang[index][plyr_name] = "Name";
$lang[index][plyr_kills] = "Kills";
$lang[index][plyr_ping] = "Ping";
$lang[index][plyr_time] = "Time";
$lang[index][plyr_wonid] = "WON ID";
$lang[index][plyr_kick] = "Kick";
$lang[index][plyr_tban] = "Temp Ban";
$lang[index][plyr_pban] = "Perm Ban";
$lang[index][kickmsg] = "Successfully kicked %%user%% from the server!";
$lang[index][tbanmsg] = "Successfully banned %%user%% from the server for 5 minutes!";
$lang[index][pbanmsg] = "Successfully permanently banned %%user%% from the server!";
$lang[index][rbanmsg] = "Successfully removed ban for WonID %%wonid%%!";
$lang[index][restart] = "The server has successfully been restarted!";
$lang[index][link_ping] = "ping yourself";
$lang[index][link_speed] = "speed test";
$lang[index][link_control] = "server control";
$lang[index][link_restart] = "restart server";
$lang[index][link_hltvctl] = "hltv control";
$lang[index][link_logout] = "logout";

// config.php
$lang[config][pagename] = "Server Configuration";
$lang[config][blurb] = "The configuration page allows you to edit all of your server and plugin configuration files as well as execute one of several popular pre-defined configuration files.";
$lang[config][predef_config] = "The below dropdown box will allow you to change your servers current configuration to one of the popular pre-defined server configurations listed below. When you are finished playing with the pre-defined configuration file just click on the \"Reset Config\" button.";
$lang[config][cal_cfgload] = "CAL config loaded via";
$lang[config][ogl_cfgload] = "OGL config loaded via";
$lang[config][def_cfgload] = "Default Server config loaded via";
$lang[config][loadok1] = "Configuration Successfully Loaded";
$lang[config][loadok2] = "Enjoy your game!";
$lang[config][btn_changecfg] = "Change Config";
$lang[config][btn_resetcfg] = "Reset Config";
$lang[config][sel_selectcfg] = "--- Select Configuration File ---";
$lang[config][btn_edit] = " Edit ";
$lang[config][resetcfg] = "Your original configuration settings have been restored.";
$lang[config][motd_blurb] = "As you may or may not know, the new hlds for CS 1.6 now allows for HTML in the MOTD. You can use the below WYSIWYG editor to edit your motd.txt file, you can include images, tables, and anything else you would like to show up in your MOTD.";
$lang[config][motd_title] = "WYSIWYG MOTD Editor";

// config_editor.php
$lang[cfgedit][nofile] = "No File Selected\nSelect a file to edit from the dropdown above";
$lang[cfgedit][btn_save] = "Save Changes";
$lang[cfgedit][reload] = "Reload Configuration Files (Server Restart)";

// insert_image.php
$lang[insert_image][pagename] = "Image Upload/Insert";
$lang[insert_image][submit] = "Insert Image";
$lang[insert_image][nofile] = "No file selected for upload!";
$lang[insert_image][exists] = "File already exists!";
$lang[insert_image][toobig] = "Image is too large!";
$lang[insert_image][slimit] = "file size limit";
$lang[insert_image][intype] = "Incorrect file type!";

// rules.php
$lang[rules][pagename] = "Server Rules";
$lang[rules][blurb] = "This section allows you to change the rules of your gameserver on the fly. Just modify the value of the rule you wish to change/update and click the \"Update\" button next to that rule and it will be instantly updated on the server. If you would like to change all of the rules back to their default values go to the <a href='config.php'>config</a> page and click the \"Reset Config\" button.";
$lang[rules][updated] = "Rule Successfully Updated!";
$lang[rules][top_rule] = "Rule";
$lang[rules][top_value] = "Value";
$lang[rules][top_change] = "Change";
$lang[rules][btn_update] = "Update";

// maps.php
$lang[maps][pagename] = "Map Change/Rotation/Upload";
$lang[maps][blurb] = "Here is where you can change just about everything about maps. You can upload new maps, delete existing maps, change to a new map, even change the way the maps are played (rotation), just use the forms below to change and/or update your map settings.";
$lang[maps][current] = "Current Map:";
$lang[maps][change] = "Change Map";
$lang[maps][btn_change] = "Change Map";
$lang[maps][uploadnew] = "Upload new map (.bsp):";
$lang[maps][btn_upload] = " Upload ";
$lang[maps][deletemap] = "Delete Map";
$lang[maps][btn_delete] = "Delete Map";
$lang[maps][rotation] = "Change map rotation";
$lang[maps][btn_rotation] = "Change Rotation";
$lang[maps][err_select] = "You must select a map to change to.<br><br>Go <a href=\"maps.php\">back</a>.";
$lang[maps][err_seldel] = "You must select a map to delete from the list.";
$lang[maps][deleted] = "The mapfile %%map%%.bsp has successfully been deleted from the server.";
$lang[maps][ul_nofile] = "No file selected for upload!";
$lang[maps][ul_exists] = "Map already exists!";
$lang[maps][ul_sizelim] = "Map filesize is too large!  (%%sizelimit%% file size limit).  Upload map via FTP";
$lang[maps][ul_badtype] = "Incorrect file type!";
$lang[maps][ul_sucsvr] = "Map successfully uploaded and transferred to server!";
$lang[maps][ul_notmp] = "Could not copy to tmp/ directory!";
$lang[maps][ul_nocopy] = "Could not copy file to maps directory!";
$lang[maps][ul_sucloc] = "Map successfully uploaded!";
$lang[maps][rot_notrans] = "maps file not found / transfer error";
$lang[maps][rot_badperm] = "maps file not found / incorrect permissions";
$lang[maps][delete1] = "Do you REALLY want to delete this map?";
$lang[maps][delete2] = "This will permanently DELETE the file from the gameserver.  You cannot undo this.";
$lang[maps][delete3] = "Are you 100% sure?";


// admins.php
$lang[admins][pagename] = "AdminMod Admin Configuration";
$lang[admins][blurb] = "This is where you add users information to your AdminMod users.ini file so that they can have RCON administrator access to your gameserver. If you do not know which access level to give your admin please click on the \"access level calculator\" link below and you will be able to calculate your admins access. ";
$lang[admins][inidesc1] = "Each entry in the users.ini file needs to be on it's own line and consists of 3 fields.";
$lang[admins][inidesc2] = "WONid : Password : Access Level (ex. 536423:mypassword:131071)";
$lang[admins][link_calc] = "access calculator";
$lang[admins][autodl] = "Ready to download?";
$lang[admins][createauto] = "create autoexec.cfg file for your c:\halflife\cstrike directory";
$lang[admins][autovar] = "variable:";
$lang[admins][autopw] = "password:";
$lang[admins][defvar] = "_pw-home";
$lang[admins][afterdl] = "(once you download, unzip file to your halflife\cstrike directory)";
$lang[admins][btn_dl] = "download autoexec.cfg";

// accesscalc.php
$lang[access][pagename] = "AdminMod Access Level Calculator";
$lang[access][blurb] = "In order to get the numeric value for your access level setting check off all of the check boxes you wish the user your adding to have access to then at the bottom of this page click on the \"Calculate Levels\" button and it will give you the ncessary value you insert into your users.ini file. ";
$lang[access][grant] = "Grant Access?";
$lang[access][level] = "Access Level";
$lang[access][allowed] = "Commands Allowed";
$lang[access][pubcmds] = "public commands";
$lang[access][btn_calc] = "Calculate Levels";
$lang[access][yourlevel] = "Your user.ini access level is:";


// execcmd.php
$lang[exec][pagename] = "Execute RCON Command";
$lang[exec][blurb] = "This is where you can run any Remote Connection (RCON) command you wish as the system (admin) user and see the results of the command you've run.";

// acctacc.php
$lang[acct][pagename] = "UNIX Shell Access";
$lang[acct][blurb] = "Shell access allows you to connect interactively with the server your gameserver resides on via a UNIX Shell Account, you can execute command, run applications, browse the web, and edit your configuration files from a shell account.";
$lang[acct][howacc] = "How would you like to connect to your account?";
$lang[acct][disabled] = "UNIX Shell Access has been DISABLED by the administrator.";
$lang[acct][notsetup] = "UNIX Shell Access is not completely setup.  login and/or password NOT defined.";
$lang[acct][howopen] = "To open the terminal applet and connect to your UNIX account via %%protocol%% please click on the<br>\"connect\" button...";

// misc.php
$lang[misc][rcon_pagename] = "RCON Password Change";
$lang[misc][rcon_newpw] = "New RCON Password:";
$lang[misc][btn_chgpw] = "Change Password";
$lang[misc][rcon_changed] = "RCON Password Successfully Changed!";
$lang[misc][restarted] = "Server Restarted";
$lang[misc][closewin] = "Close Window";

?>
