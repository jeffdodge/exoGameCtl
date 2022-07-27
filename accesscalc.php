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
*     Filename: accesscalc.php
*  Description: RCON Access Level Calculator
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
* $Id: accesscalc.php,v 2.14 2003/09/21 18:05:41 exodus Exp $
************************************************************************/
   require("includes/functions.inc.php");

   $page_name = $lang[access][pagename];
?>
<html>
<head>
<title><?php echo $product . " .:. " . $page_name ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/base.css" type="text/css">
<script language="JavaScript" src="js/display.js"></script>
<script language="JavaScript">
<!--
function access() {
 {
 var a = 0
 var b = 0
 var c = 0
 var d = 0
 var e = 0
 var f = 0
 var g = 0
 var h = 0
 var i = 0
 var j = 0
 var k = 0
 var l = 0
 var m = 0
 var n = 0
 var o = 0
 var p = 0
 var q = 0 
 if (document.calc.a.checked)
 var a = parseInt(document.calc.a.value);
 if (document.calc.b.checked)
 var b = parseInt(document.calc.b.value);
 if (document.calc.c.checked)
 var c = parseInt(document.calc.c.value);
 if (document.calc.d.checked)
 var d = parseInt(document.calc.d.value);
 if (document.calc.e.checked)
 var e = parseInt(document.calc.e.value);
 if (document.calc.f.checked)
 var f = parseInt(document.calc.f.value);
 if (document.calc.g.checked)
 var g = parseInt(document.calc.g.value);
 if (document.calc.h.checked)
 var h = parseInt(document.calc.h.value);
 if (document.calc.i.checked)
 var i = parseInt(document.calc.i.value);
 if (document.calc.j.checked)
 var j = parseInt(document.calc.j.value);
 if (document.calc.k.checked)
 var k = parseInt(document.calc.k.value);
 if (document.calc.l.checked)
 var l = parseInt(document.calc.l.value);
 if (document.calc.m.checked)
 var m = parseInt(document.calc.m.value);
 if (document.calc.n.checked)
 var n = parseInt(document.calc.n.value);
 if (document.calc.o.checked)
 var o = parseInt(document.calc.o.value);
 if (document.calc.p.checked)
 var p = parseInt(document.calc.p.value);
 if (document.calc.q.checked)
 var q = parseInt(document.calc.q.value);
 document.calc.total.value = a + b + c + d + e + f + g + h + i + j + k + l + m + n + o + p + q;
 }
}
// -->
</script>
</head>

<body bgcolor="#dfdedf" background="images/bgtests.gif">
<table width="95%">
<tr>
   <td>
   <b><u><font size=2><?php echo $page_name ?></font></u></b><br><br>
   <?php echo $lang[access][blurb] ?>
   <form name="calc" method="post">
   <center>

   <table border="0">
   <tr>
      <td bgcolor="#5d5d5d"><center><font color="#ffffff"><b><?php echo $lang[access][grant] ?></b></font></center></td>
      <td bgcolor="#5d5d5d"><center><font color="#ffffff"><b><?php echo $lang[access][level] ?></center></b></font></td>
      <td bgcolor="#5d5d5d"><center><font color="#ffffff"><b><?php echo $lang[access][allowed] ?></b></font></center></td>
   </tr>
   <tr>
      <td bgcolor="#eeeeee">&nbsp</td>
      <td bgcolor="#eeeeee"><?php echo $lang[access][pubcmds] ?></td>
      <td bgcolor="#eeeeee">
      <table border="0" cellspacing="5">
      <tr>
         <td width="150" valign="top">admin_listmaps<br>admin_nextmap<br>admin_messagemode<br>admin_nomessagemode<br>admin_timeleft<br>admin_userlist<br>admin_version</td>
         <td width="150" valign="top">say currentmap<br>say nextmap<br>say timeleft</td>
      </tr>
      </table>
      </td>
   </tr>
   <tr>
      <td bgcolor="#f5f5f5"><center><input type="checkbox" name="a" value="1"></center></td>
      <td bgcolor="#f5f5f5"><center>1</center></td>
      <td bgcolor="#f5f5f5">
      <table border="0" cellspacing="5">
      <tr>
         <td width="150" valign="top">admin_vote_restart<br>say mapvote<br>say rockthevote</td>
         <td width="150" valign="top">say vote <map><br>admin_vote_kick<br>admin_vote_map</td>
      </tr>
      </table>
      </td>
   </tr>
   <tr>
      <td bgcolor="#eeeeee"><center><input type="checkbox" name="b" value="2"></center></td>
      <td bgcolor="#eeeeee"><center>2</center></td>
      <td bgcolor="#eeeeee">
      <table border="0" cellspacing="5">
      <tr>
         <td width="150" valign="top">admin_cancelvote<br>admin_denymap<br>admin_restartround<br>say cancelvote<br>say denymap</td>
         <td width="150" valign="top">admin_fraglimit<br>admin_map<br>admin_startvote<br>admin_timelimit</td>
      </tr>
      </table>
      </td>
   </tr>
   <tr>
      <td bgcolor="#f5f5f5"><center><input type="checkbox" name="c" value="4"></center></td>
      <td bgcolor="#f5f5f5"><center>4</center></td>
      <td bgcolor="#f5f5f5">
      <table border="0" cellspacing="5">
      <tr>
         <td width="150" valign="top">admin_prematch</td>
         <td width="150" valign="top">admin_reload</td>
      </tr>
      </table>
      </td>
   </tr>
   <tr>
      <td bgcolor="#eeeeee"><center><input type="checkbox" name="d" value="8"></center></td>
      <td bgcolor="#eeeeee"><center>8</center></td>
      <td bgcolor="#eeeeee">
      <table border="0" cellspacing="5">
      <tr>
         <td width="150" valign="top">admin_pause</td>
         <td width="150" valign="top">admin_unpause</td>
      </tr>
      </table>
      </td>
   </tr>
   <tr>
      <td bgcolor="#f5f5f5"><center><input type="checkbox" name="e" value="16"></center></td>
      <td bgcolor="#f5f5f5"><center>16</center></td>
      <td bgcolor="#f5f5f5">
      <table border="0" cellspacing="5">
      <tr>
         <td width="150" valign="top">admin_pass</td>
         <td width="150" valign="top">admin_nopass</td>
      </tr>
      </table>
      </td>
   </tr>
   <tr>
      <td bgcolor="#eeeeee"><center><input type="checkbox" name="f" value="32"></center></td>
      <td bgcolor="#eeeeee"><center>32</center></td>
      <td bgcolor="#eeeeee">
      <table border="0" cellspacing="5">
      <tr>
         <td width="150" valign="top">admin_friendlyfire<br>admin_gravity</td>
         <td width="150" valign="top">admin_teamplay<br>admin_balance</td>
      </tr>
      </table>
      </td>
   </tr>
   <tr>
      <td bgcolor="#f5f5f5"><center><input type="checkbox" name="g" value="64"></center></td>
      <td bgcolor="#f5f5f5"><center>64</center></td>
      <td bgcolor="#f5f5f5">
      <table border="0" cellspacing="5">
      <tr>
         <td width="150" valign="top">admin_chat<br>admin_say<br>admin_ssay</td>
         <td width="150" valign="top">admin_csay<br>admin_psay</td>
      </tr>
      </table>
      </td>
   </tr>
   <tr>
      <td bgcolor="#eeeeee"><center><input type="checkbox" name="h" value="128"></center></td>
      <td bgcolor="#eeeeee"><center>128</center></td>
      <td bgcolor="#eeeeee">
      <table border="0" cellspacing="5">
      <tr>
         <td width="150" valign="top">admin_slap<br>admin_slay</td>
         <td width="150" valign="top">admin_slayteam<br>admin_kick</td>
      </tr> 
      </table>
      </td>
   </tr>
   <tr>
      <td bgcolor="#f5f5f5"><center><input type="checkbox" name="i" value="256"></center></td>
      <td bgcolor="#f5f5f5"><center>256</center></td>
      <td bgcolor="#f5f5f5">
      <table border="0" cellspacing="5">
      <tr>
         <td width="150" valign="top">admin_ban</td>
         <td width="150" valign="top">admin_unban</td>
      </tr>
      </table>
      </td>
   </tr>
   <tr>
      <td bgcolor="#eeeeee"><center><input type="checkbox" name="j" value="512"></center></td>
      <td bgcolor="#eeeeee"><center>512</center></td>
      <td bgcolor="#eeeeee">
      <table border="0" cellspacing="5">
      <tr>
         <td width="150" valign="top">admin_cfg<br>admin_servercfg</td>
         <td width="150" valign="top">admin_hostname</td>
      </tr>
      </table>
      </td>
   </tr>
   <tr>
      <td bgcolor="#f5f5f5"><center><input type="checkbox" name="k" value="1024"></center></td>
      <td bgcolor="#f5f5f5"><center>1024</center></td>
      <td bgcolor="#f5f5f5" colspan="2"><center>(unused)</center></td>
   </tr>
   <tr>
      <td bgcolor="#eeeeee"><center><input type="checkbox" name="l" value="2048"></center></td>
      <td bgcolor="#eeeeee"><center>2048</center></td>
      <td bgcolor="#eeeeee">
      <table border="0" cellspacing="5">
      <tr>
         <td width="150" valign="top">admin_gag</td>
         <td width="150" valign="top">admin_ungag</td>
      </tr>
      </table>
      </td>
   </tr>
   <tr>
      <td bgcolor="#f5f5f5"><center><input type="checkbox" name="m" value="4096"></center></td>
      <td bgcolor="#f5f5f5"><center>4096</center></td>
      <td bgcolor="#f5f5f5" colspan="2"><center><i>makes player immune to admin commands damage</i></center></td>
   </tr>
   <tr>
      <td bgcolor="#eeeeee"><center><input type="checkbox" name="n" value="8192"></center></td>
      <td bgcolor="#eeeeee"><center>8192</center></td>
      <td bgcolor="#eeeeee">
      <table border="0" cellspacing="5">
      <tr>
         <td width="150" valign="top">admin_godmode<br>admin_noclip<br>admin_stack<br>admin_teleport<br>admin_userorigin<br>admin_ct (CS)<br>admin_t (CS)<br>admin_blue (TFC)<br>admin_green (TFC)<br>admin_red (TFC)<br>admin_yellow (TFC)<br>admin_enableallweapons<br>admin_enableequipment<br>admin_enablemenu<br>admin_enableweapon</td>
         <td width="150" valign="top">admin_restrictallweapons<br>admin_restrictequipment<br>admin_restrictmenu<br>admin_restrictweapon<br>admin_weaponscheck<br>admin_fun<br>admin_disco<br>admin_llama<br>admin_unllama<br>admin_listspawn<br>admin_movespawn<br>admin_removespawn<br>admin_spawn</td>
      </tr>
      </table>
      </td>
   </tr>
   <tr>
      <td bgcolor="#f5f5f5"><center><input type="checkbox" name="o" value="16384"></center></td>
      <td bgcolor="#f5f5f5"><center>16384</center></td>
      <td bgcolor="#f5f5f5" colspan="2"><center><i>flags this user name as a reserved nickname</i></center></td>
   </tr>
   <tr>
      <td bgcolor="#eeeeee"><center><input type="checkbox" name="p" value="32768"></center></td>
      <td bgcolor="#eeeeee"><center>32768</center></td>
      <td bgcolor="#eeeeee" colspan="2"><center><i>allow this user to use a reserved server spot</i></center></td>
   </tr>
   <tr>
      <td bgcolor="#f5f5f5"><center><input type="checkbox" name="q" value="65536"></center></td>
      <td bgcolor="#f5f5f5"><center>65536</center></td>
      <td bgcolor="#f5f5f5"><table border="0" cellspacing="5"><td valign="top" colspan="2">admin_rcon  (use with caution)<br>admin_execall<br>admin_execclient<br>admin_execteam</td></table></td>   
   </tr>
   <tr>
      <td colspan=4>
      <input type="button" class="button" value="<?php echo $lang[access][btn_calc] ?>" onClick="access()">
      <br><br>
      <?php echo $lang[access][yourlevel] ?> <input class="accesslvl" type="text" name="total"></form>
      </td>
   </tr>
   </table>
   </td>
</tr>
</table>
</body>
</html>
