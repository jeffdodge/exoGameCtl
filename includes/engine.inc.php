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
*     Filename: engine.inc.php
*  Description: Server License Functions (Source Version)
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
* $Id: engine-src.inc.php,v 2.13 2003/09/21 18:05:41 exodus Exp $
************************************************************************/

function licValidate()
{
   $licdata = array();
   $licdata[licensee] = "Your Name";
   $licdata[company] = "Company Name Here";

/************************************************************************
*  !! WARNING !! -- DO NOT CHANGE ANYTHING BELOW HERE -- !! WARNING !!  *
************************************************************************/
   $licdata[product] = "exoGameCtl";
   $licdata[product_version] = "2.0.5";
   $licdata[product_edition] = "Source License";
   $licdata[license_id] = "1000";
   $licdata[domain] = "any";
   $licdata[serial] = "SRCV-0000-0000-0000-0000";
   $licdata[maxservers] = 0;
   $licdata[created] = "1045974636";
   $licdata[expire] = "never";

   return $licdata;
}
