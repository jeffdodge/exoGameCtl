/************************************************************************
*
* exoGameCtl - Half-Life Server Control Panel
* Copyright (c)2002-2003 RWJD.Com.  All Rights Reserved.
*
*************************************************************************
*
*       Author: Jeffrey J. Dodge
*        Email: info@exocontrol.com
*          Web: http://www.exocontrol.com
*     Filename: display.js
*  Description: All Display Control JavaScript Functions
*      Release: 2.0.5
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
* $Id: display.js,v 2.3 2003/05/16 05:32:46 rwjd Exp $
************************************************************************/

function MM_preloadImages() { //v3.0
var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

startColor = "#000000"; // MouseOut link color 
endColor = "#eead5c"; // MouseOver link color 

stepIn = 20;
stepOut = 20;

autoFade = true; 
sloppyClass = true; 

hexa = new makearray(16); 
for(var i = 0; i < 10; i++) 
hexa[i] = i; 
hexa[10]="a"; hexa[11]="b"; hexa[12]="c"; 
hexa[13]="d"; hexa[14]="e"; hexa[15]="f"; 

document.onmouseover = domouseover; 
document.onmouseout = domouseout; 

startColor = dehexize(startColor.toLowerCase()); 
endColor = dehexize(endColor.toLowerCase()); 

var fadeId = new Array(); 

function dehexize(Color){ 
var colorArr = new makearray(3); 
for (i=1; i<7; i++){ 
for (j=0; j<16; j++){ 
if (Color.charAt(i) == hexa[j]){ 
if (i%2 !=0) 
colorArr[Math.floor((i-1)/2)]=eval(j)*16; 
else 
colorArr[Math.floor((i-1)/2)]+=eval(j); 
} 
} 
} 
return colorArr; 
} 

function domouseover() { 
if(document.all){ 
var srcElement = event.srcElement; 
if ((srcElement.tagName == "A" && autoFade) || srcElement.className == "fade" || (sloppyClass && 
srcElement.className.indexOf("fade") != -1)) 
fade(startColor,endColor,srcElement.uniqueID,stepIn); 
} 
} 

function domouseout() { 
if (document.all){ 
var srcElement = event.srcElement; 
if ((srcElement.tagName == "A" && autoFade) || srcElement.className == "fade" || (sloppyClass && 
srcElement.className.indexOf("fade") != -1)) 
fade(endColor,startColor,srcElement.uniqueID,stepOut); 
} 
} 

function makearray(n) { 
this.length = n; 
for(var i = 1; i <= n; i++) 
this[i] = 0; 
return this; 
} 

function hex(i) { 
if (i < 0) 
return "00"; 
else if (i > 255) 
return "ff"; 
else 
return "" + hexa[Math.floor(i/16)] + hexa[i%16];} 

function setColor(r, g, b, element) { 
var hr = hex(r); var hg = hex(g); var hb = hex(b); 
element.style.color = "#"+hr+hg+hb; 
} 

function fade(s,e, element,step){ 
var sr = s[0]; var sg = s[1]; var sb = s[2]; 
var er = e[0]; var eg = e[1]; var eb = e[2]; 

if (fadeId[0] != null && fade[0] != element){ 
setColor(sr,sg,sb,eval(fadeId[0])); 
var i = 1; 
while(i < fadeId.length){ 
clearTimeout(fadeId[i]); 
i++; 
} 
} 

for(var i = 0; i <= step; i++) { 
fadeId[i+1] = setTimeout("setColor(Math.floor(" +sr+ " *(( " +step+ " - " +i+ " )/ " +step+ " ) + " +er+ " * (" 
+i+ "/" + 
step+ ")),Math.floor(" +sg+ " * (( " +step+ " - " +i+ " )/ " +step+ " ) + " +eg+ " * (" +i+ "/" +step+ 
")),Math.floor(" +sb+ " * ((" +step+ "-" +i+ ")/" +step+ ") + " +eb+ " * (" +i+ "/" +step+ 
")),"+element+");",i*step); 
} 
fadeId[0] = element; 
}

FadeObjects = new Object();
FadeTimers = new Object();

function imageFade(object, destOp, rate, delta) {
if (!document.all)
return

if (object != "[object]") { setTimeout("Fade("+object+","+destOp+","+rate+","+delta+")",0); return; }
clearTimeout(FadeTimers[object.sourceIndex]);
diff = destOp-object.filters.alpha.opacity;
direction = 1;
if (object.filters.alpha.opacity > destOp) { direction = -1; }
delta=Math.min(direction*diff,delta);
object.filters.alpha.opacity+=direction*delta;
if (object.filters.alpha.opacity != destOp) { FadeObjects[object.sourceIndex]=object; FadeTimers[object.sourceIndex]=setTimeout("imageFade(FadeObjects["+object.sourceIndex+"],"+destOp+","+rate+","+delta+")",rate); }
}
function openWindow(url, name)
{
var l = openWindow.arguments.length;
var w = "";
var h = "";
var features = "";

for (i=2; i<l; i++) {
var param = openWindow.arguments[i];
if ( (parseInt(param) == 0) || (isNaN(parseInt(param))) ) {
features += param + ',';
}
else
{
(w == "") ? w = "width=" + param + "," : h = "height=" + param;
}
}
features += w + h;
var code = "popupWin = window.open(url, name";
if (l > 2) code += ", '" + features;
code += "')";
eval(code);
}

function openwin() {
if (!document.layers&&!document.all&&!document.getElementById)
{
paramstp="height=530,width=550,top=0,left=0,scrollbars=yes,location=no"+",directories=no,status=yes,menubar=no,toolbar=no,resizable=no"
var gwa=window.open("mainframe.html","",paramstp);
if (gwa.focus){gwa.focus();}
return;
}
var movespeed=200;
var resizespeed=100;
var winreswidth=800;
var winresheight=600;
var leftspeed=winreswidth/movespeed;
var topspeed=winresheight/movespeed;
var movewidth=winreswidth;
var moveheight=winresheight;
var widthspeed=winreswidth/resizespeed;
var heightspeed=winresheight/resizespeed;
var sizewidth=0;
var sizeheight=0;
var gwa=open("main.php","","left="+winreswidth+",top="+winresheight+",width=100,height=100,toolbar=no,menubar=no,location=no,status=yes,scrollbars=no,resizable=no");
for (move=0;move<movespeed;move++)
{
gwa.moveTo(movewidth,moveheight);
movewidth-=leftspeed;
moveheight-=topspeed;
}
gwa.moveTo("0","0");

for (size=0;size<resizespeed;size++){
gwa.resizeTo(sizewidth,sizeheight);
sizewidth+=widthspeed;
sizeheight+=heightspeed;
}
gwa.resizeTo(winreswidth,winresheight);
if (gwa.focus){gwa.focus();}
}

function winResize()
{
if (js12) {
if (navigator.appName=="Netscape") {
 top.outerWidth=800;
 top.outerHeight=620;
}
else 
{
top.resizeTo(814,627);
}
}
}
function submitonce(theform) {
if (document.all||document.getElementById) {
for (i=0;i<theform.length;i++) {
var tempobj=theform.elements[i]
if(tempobj.type.toLowerCase()=="submit"||tempobj.type.toLowerCase()=="reset")
 tempobj.disabled=true
}
}
}
