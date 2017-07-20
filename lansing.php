<?php session_start(); ?>
<!DOCTYPE html>
<html class="nojs html css_verticalspacer" lang="en-US">
 <head>

  <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
  <meta name="generator" content="2017.0.1.363"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <script type="text/javascript" src="scripts/d3.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script type="text/javascript">
   // Update the 'nojs'/'js' class on the html node
document.documentElement.className = document.documentElement.className.replace(/\bnojs\b/g, 'js');

// Check that all required assets are uploaded and up-to-date
if(typeof Muse == "undefined") window.Muse = {}; window.Muse.assets = {"required":["museutils.js", "museconfig.js", "jquery.watch.js", "require.js", "jquery.musepolyfill.bgsize.js", "webpro.js", "musewpslideshow.js", "jquery.museoverlay.js", "touchswipe.js", "lansing.css"], "outOfDate":[]};
</script>
  
  <title>Lansing</title>
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="css/site_global.css?crc=193633137"/>
  <link rel="stylesheet" type="text/css" href="css/master_a-master.css?crc=238735217"/>
  <link rel="stylesheet" type="text/css" href="css/lansing.css?crc=3959280708" id="pagesheet"/>
  <link rel="stylesheet" type="text/css" href="css/datavis.css"/>

  <!-- Other scripts -->
  <script type="text/javascript">
   var __adobewebfontsappname__ = "muse";
</script>
  <!-- JS includes -->
  <script type="text/javascript">
   document.write('\x3Cscript src="' + (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//webfonts.creativecloud.com/muli:n4:default.js" type="text/javascript">\x3C/script>');
</script>
   </head>
 <body>
  <?php

        //Get the connection info for the database
      require_once 'includes/config.php';

      //Establish a database connection
      $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      //Was there an error connecting to the database?
      if ($mysqli->errno) {
        //The page isn't worth much without a db connection so display the error and quit
        print($mysqli->error);
        exit();
      }

      if (isset($_POST['submit']) && $_POST['submit']=="LOG OUT") {
        unset($_SESSION['user']);
        $url = $_SERVER['REQUEST_URI'];
        $newurl =  substr($url, 0, -11)."index.php";
        echo '<script type="text/javascript">window.location ='."'".$newurl."'".'</script>';
      }

    ?>
  <div class="clearfix borderbox" id="page"><!-- column -->
   <div class="position_content" id="page_position_content">
    <div class="browser_width colelem" id="u108-bw">
     <div id="u108"><!-- group -->
      <div class="clearfix" id="u108_align_to_page">
       <div class="clearfix grpelem" id="u114-4"><!-- content -->
        <form method="post" action="">
          <p id="u114-2"><input id='logout-submit' type='submit' name='submit' value='LOG OUT'></p>
        </form>
       </div>
      </div>
     </div>
    </div>
    <div class="clearfix colelem" id="pu120-4"><!-- group -->
     <a href="index.php"><img class="grpelem" id="u120-4" alt="d.Meter" src="images/u120-4.png?crc=416918895" data-image-width="97"/></a><!-- rasterized frame -->
     <a class="nonblock nontext clearfix grpelem" id="u129-4" href="account.php"><!-- content --><p>my account</p></a>
     <a class="nonblock nontext clearfix grpelem" id="u132-4" href="techsupport.html"><!-- content --><p>technical support</p></a>
    </div>
    <div class="PamphletWidget clearfix colelem" id="pamphletu810"><!-- none box -->
     <div class="popup_anchor" id="u821popup">
      <div class="ContainerGroup clearfix" id="u821"><!-- stack box -->
       <div class="Container shadow clearfix grpelem" id="u822"><!-- column -->
        <div class="museBGSize colelem" id="u824"><!-- simple frame --></div>
        <div class="clearfix colelem" id="u823-4"><!-- content -->
         <p>The unusual energy spike costs you $40. You may spend 23% more utility than usual in this month.</p>
        </div>
       </div>
       <div class="Container invi shadow clearfix grpelem" id="u828"><!-- column -->
        <div class="museBGSize colelem" id="u830"><!-- simple frame --></div>
        <div class="clearfix colelem" id="u829-4"><!-- content -->
         <p>You help to beautify the environment by saving 325 kWh this month.</p>
        </div>
       </div>
       <div class="Container invi shadow clearfix grpelem" id="u825"><!-- column -->
        <div class="museBGSize colelem" id="u827"><!-- simple frame --></div>
        <div class="clearfix colelem" id="u826-4"><!-- content -->
         <p>So far, you owe NYSEG $134.56 by using 1534 kWh.</p>
        </div>
       </div>
      </div>
     </div>
     <div class="ThumbGroup clearfix grpelem" id="u815"><!-- none box -->
      <div class="popup_anchor" id="u816popup">
       <div class="Thumb popup_element rounded-corners" id="u816"><!-- simple frame --></div>
      </div>
      <div class="popup_anchor" id="u818popup">
       <div class="Thumb popup_element rounded-corners" id="u818"><!-- simple frame --></div>
      </div>
      <div class="popup_anchor" id="u817popup">
       <div class="Thumb popup_element rounded-corners" id="u817"><!-- simple frame --></div>
      </div>
     </div>
    </div>
      <!--put the rest before div for vertical spacer-->
    <div class = "card">
      <div class = "contain">
        <div class = "buttons">
          <span class = "btn" id = "button0" onclick = "plotGraph('yeardata.php', 0)">year</span> 
          <span class = "btn" id = "button1" onclick = "plotGraph('monthdata.php', 1)">month</span> 
          <span class = "btn" id = "button2" onclick = "plotGraph('weekdata.php', 2)">week</span> 
          <!--span class = "btn" id = "button3" onclick = "changeGraph('yeardata.php', 3)">day</span--> 
        </div>
        <div id = "svg">
        <svg id = "graph"></svg>
        </div>
        <script src = "scripts/graph.js"></script>
        <script>
          /** Only function needs to be called to generate graph
            First parameter is the php file to call to database and get data
            Second parameter is the mode such as year month or week, 0 for year, 1 for month, 2 for week
            Scales are still not working will be fixed
            Functions for second line graph is still not done
          */
          plotGraph("monthdata.php",1);
        </script>
        <div id = "notifs">
          <h1>[Insert whatever title needed for this section]</h1>
          <div>[Insert whatever needs to be displayed here]</div>
        
        </div>
      </div>
    </div>
    <div class="verticalspacer" data-offset-top="656" data-content-above-spacer="656" data-content-below-spacer="62"></div>
   </div>
  </div>
  <!-- Other scripts -->
  <script type="text/javascript">
   window.Muse.assets.check=function(d){if(!window.Muse.assets.checked){window.Muse.assets.checked=!0;var b={},c=function(a,b){if(window.getComputedStyle){var c=window.getComputedStyle(a,null);return c&&c.getPropertyValue(b)||c&&c[b]||""}if(document.documentElement.currentStyle)return(c=a.currentStyle)&&c[b]||a.style&&a.style[b]||"";return""},a=function(a){if(a.match(/^rgb/))return a=a.replace(/\s+/g,"").match(/([\d\,]+)/gi)[0].split(","),(parseInt(a[0])<<16)+(parseInt(a[1])<<8)+parseInt(a[2]);if(a.match(/^\#/))return parseInt(a.substr(1),
16);return 0},g=function(g){for(var f=document.getElementsByTagName("link"),h=0;h<f.length;h++)if("text/css"==f[h].type){var i=(f[h].href||"").match(/\/?css\/([\w\-]+\.css)\?crc=(\d+)/);if(!i||!i[1]||!i[2])break;b[i[1]]=i[2]}f=document.createElement("div");f.className="version";f.style.cssText="display:none; width:1px; height:1px;";document.getElementsByTagName("body")[0].appendChild(f);for(h=0;h<Muse.assets.required.length;){var i=Muse.assets.required[h],l=i.match(/([\w\-\.]+)\.(\w+)$/),k=l&&l[1]?
l[1]:null,l=l&&l[2]?l[2]:null;switch(l.toLowerCase()){case "css":k=k.replace(/\W/gi,"_").replace(/^([^a-z])/gi,"_$1");f.className+=" "+k;k=a(c(f,"color"));l=a(c(f,"backgroundColor"));k!=0||l!=0?(Muse.assets.required.splice(h,1),"undefined"!=typeof b[i]&&(k!=b[i]>>>24||l!=(b[i]&16777215))&&Muse.assets.outOfDate.push(i)):h++;f.className="version";break;case "js":h++;break;default:throw Error("Unsupported file type: "+l);}}d?d().jquery!="1.8.3"&&Muse.assets.outOfDate.push("jquery-1.8.3.min.js"):Muse.assets.required.push("jquery-1.8.3.min.js");
f.parentNode.removeChild(f);if(Muse.assets.outOfDate.length||Muse.assets.required.length)f="Some files on the server may be missing or incorrect. Clear browser cache and try again. If the problem persists please contact website author.",g&&Muse.assets.outOfDate.length&&(f+="\nOut of date: "+Muse.assets.outOfDate.join(",")),g&&Muse.assets.required.length&&(f+="\nMissing: "+Muse.assets.required.join(",")),alert(f)};location&&location.search&&location.search.match&&location.search.match(/muse_debug/gi)?setTimeout(function(){g(!0)},5E3):g()}};
var muse_init=function(){require.config({baseUrl:""});require(["jquery","museutils","whatinput","jquery.watch","jquery.musepolyfill.bgsize","webpro","musewpslideshow","jquery.museoverlay","touchswipe"],function(d){var $ = d;$(document).ready(function(){try{
window.Muse.assets.check($);/* body */
Muse.Utils.transformMarkupToFixBrowserProblemsPreInit();/* body */
Muse.Utils.prepHyperlinks(true);/* body */
Muse.Utils.resizeHeight('.browser_width');/* resize height */
Muse.Utils.requestAnimationFrame(function() { $('body').addClass('initialized'); });/* mark body as initialized */
Muse.Utils.fullPage('#page');/* 100% height page */
Muse.Utils.initWidget('#pamphletu810', ['#bp_infinity'], function(elem) { return new WebPro.Widget.ContentSlideShow(elem, {contentLayout_runtime:'stack',event:'mouseover',deactivationEvent:'none',autoPlay:false,displayInterval:3000,transitionStyle:'fading',transitionDuration:0,hideAllContentsFirst:false,shuffle:false,enableSwipe:true,resumeAutoplay:true,resumeAutoplayInterval:3000,playOnce:false,autoActivate_runtime:false}); });/* #pamphletu810 */
Muse.Utils.showWidgetsWhenReady();/* body */
Muse.Utils.transformMarkupToFixBrowserProblems();/* body */
}catch(b){if(b&&"function"==typeof b.notify?b.notify():Muse.Assert.fail("Error calling selector function: "+b),false)throw b;}})})};

</script>
  <!-- RequireJS script -->
  <script src="scripts/require.js?crc=4159430777" type="text/javascript" async data-main="scripts/museconfig.js?crc=4179431180" onload="if (requirejs) requirejs.onError = function(requireType, requireModule) { if (requireType && requireType.toString && requireType.toString().indexOf && 0 <= requireType.toString().indexOf('#scripterror')) window.Muse.assets.check(); }" onerror="window.Muse.assets.check();"></script>
   </body>
</html>
