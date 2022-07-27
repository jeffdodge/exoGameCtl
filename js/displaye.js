   if (js12)
   {
      var ie=document.all
      var dom=document.getElementById
      var ns4=document.layers

      var bouncelimit=32 //(must be divisible by 8)
      var direction="up"

      function initbox()
      {
         if (!dom&&!ie&&!ns4)
         {
            return
         }
         crossobj=(dom)?document.getElementById("dropin").style : ie? document.all.dropin : document.dropin
         scroll_top=(ie)? document.body.scrollTop : window.pageYOffset
         crossobj.top=scroll_top-250
         crossobj.visibility=(dom||ie)? "visible" : "show"
         dropstart=setInterval("dropin()",50)
      }

      function dropin()
      {
         scroll_top=(ie)? document.body.scrollTop : window.pageYOffset
         if (parseInt(crossobj.top)<100+scroll_top)
         {
            crossobj.top=parseInt(crossobj.top)+40
         }
         else
         {
            clearInterval(dropstart)
            bouncestart=setInterval("bouncein()",50)
         }
      }

      function bouncein()
      {
         crossobj.top=parseInt(crossobj.top)-bouncelimit
         if (bouncelimit<0)
         {
            bouncelimit+=8
         }
         bouncelimit=bouncelimit*-1
         if (bouncelimit==0)
         {
            clearInterval(bouncestart)
         }
      }

      function dismissbox()
      {
         if (window.bouncestart) clearInterval(bouncestart)
         {
            crossobj.visibility="hidden"
         }
      }
   }
   else
   {
      alert('<?php echo $product ?> - Evaluation Copy\n\nThis is an evaluation copy of exoGameCtl and the Demo Licensethat\nis installed will expire on <?php echo date("D, M d, Y h:i:s T", $expire) ?>.\n\nPlease contact licenses@exocontrol.com to purchase a license!');
   }
