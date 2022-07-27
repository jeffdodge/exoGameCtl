<?

if ($action == "mapchange")
{
   $time = 10;
   $file = "maps.php";
   $text = "Map change will be complete in";
}
elseif ($action == "maprotation")
{
   $time = 3;
   $file = "maps.php";
   $text = "Map rotation change will be complete in";
}
elseif ($action == "update_users")
{
   $time = 10;
   $file = "admins.php";
   $text = "AdminMod users file update will be complete in";
}

print "
<script language=\"JavaScript\">
var countDownInterval=$time;
var countDownTime=countDownInterval+1;

function countDown()
{
  countDownTime--;
  if (countDownTime <=0)
  {
    countDownTime=countDownInterval;
    clearTimeout(counter)
    window.location='$file';
    return
  }

  if (document.all) document.all.countDownText.innerText = countDownTime+\" \";
  else if (document.getElementById) document.getElementById(\"countDownText\").innerHTML=countDownTime+\" \"

  counter=setTimeout(\"countDown()\", 1000);
}

function startit()
{
   if (document.all||document.getElementById)
   document.write('$text <b id=\"countDownText\">'+countDownTime+' </b> seconds.')
   countDown()
}

if (document.all||document.getElementById) startit()
else window.onload=startit
</script>
";
