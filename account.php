<?php session_start(); ?>
<!DOCTYPE html>
<html class="nojs html css_verticalspacer" lang="en-US">
 <head>

  <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
  <meta name="generator" content="2017.0.1.363"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <script type="text/javascript">
   // Update the 'nojs'/'js' class on the html node
document.documentElement.className = document.documentElement.className.replace(/\bnojs\b/g, 'js');

// Check that all required assets are uploaded and up-to-date
if(typeof Muse == "undefined") window.Muse = {}; window.Muse.assets = {"required":["museutils.js", "museconfig.js", "jquery.watch.js", "require.js", "account.css"], "outOfDate":[]};
</script>
  
  <title>Account</title>
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="css/site_global.css?crc=193633137"/>
  <link rel="stylesheet" type="text/css" href="css/master_a-master.css?crc=238735217"/>
  <link rel="stylesheet" type="text/css" href="css/account.css?crc=269193992" id="pagesheet"/>
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

  <div class="clearfix borderbox" id="page"><!-- column -->
   <div class="position_content" id="page_position_content">
    <div class="browser_width colelem" id="u108-bw">
     <div id="u108"><!-- group -->
      <div class="clearfix" id="u108_align_to_page">
       <div class="rounded-corners clearfix grpelem" id="u114-4"><!-- content -->
        <form method="post" action="">
          <p id="u114-2"><input id='logout-submit' type='submit' name='submit' value='LOG OUT'></p>
        </form>
       </div>
      </div>
     </div>
    </div>
    <div class="clearfix colelem" id="pu120-4"><!-- group -->
     <img class="grpelem" id="u120-4" alt="d.Meter" src="images/u120-4.png?crc=416918895" data-image-width="97"/><!-- rasterized frame -->
     <a class="nonblock nontext MuseLinkActive clearfix grpelem" id="u129-4" href="account.php"><!-- content --><p>my account</p></a>
     <a class="nonblock nontext clearfix grpelem" id="u132-4" href="techsupport.html"><!-- content --><p>technical support</p></a>
    </div>
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

    $user = $_SESSION['user'];
    
    $user_query = "SELECT * FROM Users WHERE email = '$user'";

    $user_result = $mysqli->query($user_query);

    if (isset($_POST['submit']) && $_POST['submit']=="LOG OUT") {
      unset($_SESSION['user']);
      $url = $_SERVER['REQUEST_URI'];
      $newurl =  substr($url, 0, -11)."index.php";
      echo '<script type="text/javascript">window.location ='."'".$newurl."'".'</script>';
    }

    if (isset($_SESSION['user']) && $user_result) {
        $row = $user_result->fetch_assoc();
        $user = $row['email'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $nyseg = $row['nyseg'];
        $address = $row['address'];
        $phone = $row['phone'];

        echo '<div id="user-info">';
        echo 'User Information:<br><br><br>';
        echo 'Name: '.$firstname." ".$lastname.'<br><br>';
        echo 'Username/email: '.$user.'<br><br>';
        echo 'NYSEG Account Number: '.$nyseg.'<br><br>';
        echo 'Home Address: '.$address.'<br><br>';
        echo 'Phone number: '.$phone;
        echo '</div>';
    }

  ?>
    <div class="verticalspacer" data-offset-top="0" data-content-above-spacer="117" data-content-below-spacer="383"></div>
   </div>
  </div>
  <!-- Other scripts -->
  <script type="text/javascript">
   window.Muse.assets.check=function(d){if(!window.Muse.assets.checked){window.Muse.assets.checked=!0;var b={},c=function(a,b){if(window.getComputedStyle){var c=window.getComputedStyle(a,null);return c&&c.getPropertyValue(b)||c&&c[b]||""}if(document.documentElement.currentStyle)return(c=a.currentStyle)&&c[b]||a.style&&a.style[b]||"";return""},a=function(a){if(a.match(/^rgb/))return a=a.replace(/\s+/g,"").match(/([\d\,]+)/gi)[0].split(","),(parseInt(a[0])<<16)+(parseInt(a[1])<<8)+parseInt(a[2]);if(a.match(/^\#/))return parseInt(a.substr(1),
16);return 0},g=function(g){for(var f=document.getElementsByTagName("link"),h=0;h<f.length;h++)if("text/css"==f[h].type){var i=(f[h].href||"").match(/\/?css\/([\w\-]+\.css)\?crc=(\d+)/);if(!i||!i[1]||!i[2])break;b[i[1]]=i[2]}f=document.createElement("div");f.className="version";f.style.cssText="display:none; width:1px; height:1px;";document.getElementsByTagName("body")[0].appendChild(f);for(h=0;h<Muse.assets.required.length;){var i=Muse.assets.required[h],l=i.match(/([\w\-\.]+)\.(\w+)$/),k=l&&l[1]?
l[1]:null,l=l&&l[2]?l[2]:null;switch(l.toLowerCase()){case "css":k=k.replace(/\W/gi,"_").replace(/^([^a-z])/gi,"_$1");f.className+=" "+k;k=a(c(f,"color"));l=a(c(f,"backgroundColor"));k!=0||l!=0?(Muse.assets.required.splice(h,1),"undefined"!=typeof b[i]&&(k!=b[i]>>>24||l!=(b[i]&16777215))&&Muse.assets.outOfDate.push(i)):h++;f.className="version";break;case "js":h++;break;default:throw Error("Unsupported file type: "+l);}}d?d().jquery!="1.8.3"&&Muse.assets.outOfDate.push("jquery-1.8.3.min.js"):Muse.assets.required.push("jquery-1.8.3.min.js");
f.parentNode.removeChild(f);if(Muse.assets.outOfDate.length||Muse.assets.required.length)f="Some files on the server may be missing or incorrect. Clear browser cache and try again. If the problem persists please contact website author.",g&&Muse.assets.outOfDate.length&&(f+="\nOut of date: "+Muse.assets.outOfDate.join(",")),g&&Muse.assets.required.length&&(f+="\nMissing: "+Muse.assets.required.join(",")),alert(f)};location&&location.search&&location.search.match&&location.search.match(/muse_debug/gi)?setTimeout(function(){g(!0)},5E3):g()}};
var muse_init=function(){require.config({baseUrl:""});require(["jquery","museutils","whatinput","jquery.watch"],function(d){var $ = d;$(document).ready(function(){try{
window.Muse.assets.check($);/* body */
Muse.Utils.transformMarkupToFixBrowserProblemsPreInit();/* body */
Muse.Utils.prepHyperlinks(true);/* body */
Muse.Utils.resizeHeight('.browser_width');/* resize height */
Muse.Utils.requestAnimationFrame(function() { $('body').addClass('initialized'); });/* mark body as initialized */
Muse.Utils.fullPage('#page');/* 100% height page */
Muse.Utils.showWidgetsWhenReady();/* body */
Muse.Utils.transformMarkupToFixBrowserProblems();/* body */
}catch(b){if(b&&"function"==typeof b.notify?b.notify():Muse.Assert.fail("Error calling selector function: "+b),false)throw b;}})})};

</script>
  <!-- RequireJS script -->
  <script src="scripts/require.js?crc=4159430777" type="text/javascript" async data-main="scripts/museconfig.js?crc=4179431180" onload="if (requirejs) requirejs.onError = function(requireType, requireModule) { if (requireType && requireType.toString && requireType.toString().indexOf && 0 <= requireType.toString().indexOf('#scripterror')) window.Muse.assets.check(); }" onerror="window.Muse.assets.check();"></script>
   </body>
</html>
