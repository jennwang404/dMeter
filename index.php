<?php session_start(); ?>
<!DOCTYPE html>
<meta content="utf-8" http-equiv="encoding">
<html class="nojs html css_verticalspacer" lang="en-US">
 <head>

  <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
  <meta name="generator" content="2017.0.1.363"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <script type="text/javascript" src="scripts/jquery-1.8.3.min.js"></script>
  <script type="text/javascript">
   // Update the 'nojs'/'js' class on the html node
document.documentElement.className = document.documentElement.className.replace(/\bnojs\b/g, 'js');

// Check that all required assets are uploaded and up-to-date
if(typeof Muse == "undefined") window.Muse = {}; window.Muse.assets = {"required":["museutils.js", "museconfig.js", "jquery.watch.js", "require.js", "index.css"], "outOfDate":[]};
</script>
  
  <title>Index</title>
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="css/site_global.css?crc=193633137"/>
  <link rel="stylesheet" type="text/css" href="css/master_main-master.css?crc=4049825680"/>
  <link rel="stylesheet" type="text/css" href="css/index.css?crc=131689208" id="pagesheet"/>
  <!-- IE-only CSS -->
  <!--[if lt IE 9]>
  <link rel="stylesheet" type="text/css" href="css/iefonts_index.css?crc=4154131170"/>
  <![endif]-->
  <!-- Other scripts -->
  <script type="text/javascript">
   var __adobewebfontsappname__ = "muse";
</script>
  <!-- JS includes -->
  <script type="text/javascript">
   document.write('\x3Cscript src="' + (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//webfonts.creativecloud.com/muli:n4,i4:default.js" type="text/javascript">\x3C/script>');
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

    $message = null;
    $login_message = null;
    $login_message_succ = null;

    if (isset($_POST['submit'])){
      if ($_POST['submit']=="SIGN UP") {
        $email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_STRING );
        $password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );
        $firstname = filter_input( INPUT_POST, 'firstname', FILTER_SANITIZE_STRING );
        $lastname = filter_input( INPUT_POST, 'lastname', FILTER_SANITIZE_STRING );
        $nyseg = filter_input( INPUT_POST, 'nyseg', FILTER_SANITIZE_STRING );
        $address = filter_input( INPUT_POST, 'address', FILTER_SANITIZE_STRING );
        $phone = filter_input( INPUT_POST, 'phone', FILTER_SANITIZE_STRING );

        $user_query = "SELECT * FROM Users WHERE email = '$email'";

        $user_result = $mysqli->query($user_query);
        
        //This user doesn't already exist in the database (no one with this email already)
        if ( $user_result && $user_result->num_rows == 0) {

          //Nothing was entered in the form
          if ($email == '' && $password == '' && $firstname == '' && $lastname == '' && $nyseg == '' && $address == '' && $phone == '') {
            $message = null;
          }
          //Check that the email address entered is valid
          else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Invalid email address";
          } 
          //Check that the first name entered is valid
          else if (ctype_alpha(str_replace(' ', '', $firstname)) === false) {
            $message = 'First name must contain letters and spaces only';
          } 
          //Check that the last name entered is valid
          else if (ctype_alpha(str_replace(' ', '', $lastname)) === false) {
            $message = 'Last name must contain letters and spaces only';
          } 
          //Check that the NYSEG Account Number entered is valid
          else if (strlen($nyseg) != 10) {
            $message = 'Invalid NYSEG account number';
          } 
          //Check that an address was entered
          else if (strlen($address) == 0) {
            $message = 'Please enter a valid home address';
          } 
          //Check that the phone number entered is valid
          else if ($phone != null && strlen($phone) != 10 && strlen($phone) != 11) {
            $message = 'Invalid phone number';
          } 
          //Everything is okay, add user to the database and echo a success message
          else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO Users VALUES ('$email', '$hashed_password', '$firstname', '$lastname', '$nyseg', '$address', '$phone')";
            //echo $query;
            $result = $mysqli->query($query);
            if ($result){
              $message = "Sign up successful. You may now log in";
            }
          }

        } else if ( $user_result && $user_result->num_rows > 0) {
          $message = "That email address seems to already have an account associated with it";
        }

      }
      else if ($_POST['submit']=="Login") {
        $login_email = filter_input( INPUT_POST, 'login_email', FILTER_SANITIZE_STRING );
        $login_password = filter_input( INPUT_POST, 'login_password', FILTER_SANITIZE_STRING );

        $user_query = "SELECT * FROM Users WHERE email = '$login_email'";

        $user_result = $mysqli->query($user_query);
        
        //Nothing was entered in the form
        if ($login_email == '' && $login_password == '') {
            $login_message = null;
        }
        //This user doesn't exist in the database
        else if ( $user_result && $user_result->num_rows == 0) {
          $login_message =  "There is no user with that email";
        } 
        else if ( $user_result && $user_result->num_rows == 1) {

          $row = $user_result->fetch_assoc();
          $db_hash_password = $row['hashpassword'];
          $db_address = strtoupper($row["address"]);
          
          if( password_verify( $login_password, $db_hash_password ) ) {
            $_SESSION['user'] = $login_email;
            $login_message_succ = "Login successful";
            $url = $_SERVER['REQUEST_URI'];


            //Redirect user to a different page depending on what region they're from

            $lansing_query = "SELECT * FROM Location WHERE region = 'Lansing'";
            $lansing_result = $mysqli->query($lansing_query);
            $lansing_addresses = array();
            while ($lansing_row = $lansing_result->fetch_assoc()) {
                array_push($lansing_addresses, $lansing_row["Street_Name"]);
            }

            $northside_query = "SELECT * FROM Location WHERE region = 'North'";
            $northside_result = $mysqli->query($northside_query);
            $northside_addresses = array();
            while ($northside_row = $northside_result->fetch_assoc()) {
                array_push($northside_addresses, $northside_row["Street_Name"]);
            }

            $southside_query = "SELECT * FROM Location WHERE region = 'South'";
            $southside_result = $mysqli->query($southside_query);
            $southside_addresses = array();
            while ($southside_row = $southside_result->fetch_assoc()) {
                array_push($southside_addresses, $southside_row["Street_Name"]);
            }

            $user_region = null;
            foreach ($lansing_addresses as $address) {
              if (strpos($db_address, $address) !== false) {
                $user_region = 'lansing';
              }
            }
            foreach ($northside_addresses as $address) {
              if (strpos($db_address, $address) !== false) {
                $user_region = 'northside';
              }
            }
            foreach ($southside_addresses as $address) {
              if (strpos($db_address, $address) !== false) {
                $user_region = 'southside';
              }
            }

            if (substr($url, -9) == "index.php") {
                $newurl =  substr($url, 0, -9).$user_region.".php";
            } else {
                $newurl = $url.$user_region.".php";
            }
            echo '<script type="text/javascript">window.location ='."'".$newurl."'".'</script>';
          } else {
            $login_message =  "Incorrect password";
          }
        } 

      }
    }

  ?>
  <div class="clearfix borderbox" id="page"><!-- column -->
   <div class="position_content" id="page_position_content">
    <div class="browser_width colelem" id="u987-bw">
     <div id="u987"><!-- group -->
      <div class="clearfix" id="u987_align_to_page">
       <div class="clearfix grpelem" id="u992-4"><!-- content -->
        <form method="post" action="">
          <?php 
            if (!isset($_SESSION['user'])) {
              echo "<p>Have an account? <input id='login-submit' type='submit' name='submit' value='Login'></p>";
            }
          ?>
          <?php echo '<div id="login-message">'.$login_message.'</div>' ?>
          <?php echo '<div id="login-message-succ">'.$login_message_succ.'</div>' ?>
          <div id="pop-up">
              Email: <input class="width1-border" type="text" name="login_email"> 
              Password:  <input class="width1-border" type="password" name="login_password">
          </div>
        </form>
       </div>
      </div>
     </div>
    </div>
    <a href="index.php"><img class="colelem" id="u986-4" alt="d.Meter" src="images/u986-4.png?crc=416918895" data-image-width="97" /></a><!-- rasterized frame -->
    <div class="clearfix colelem" id="u937-10"><!-- content -->
     <p id="u937-2">TRANSPARENT. CONVENIENT. FLEXIBLE.</p>
     <p id="u937-3">&nbsp;</p>
     <p id="u937-6"><span id="u937-4">A smart energy system that monitors your household energy usage and makes energy conservation delightful.</span></p>
     <p id="u937-7">&nbsp;</p>
     <p id="u937-8">&nbsp;</p>
    </div>
    </div>
    <form method="post" action="">
      <div id="form">
          Email: <input class="width1" type="text" name="email"><br><br>
          Password:  <input class="width2" type="text" name="password"><br><br>
          First Name:  <input class="width1" type="text" name="firstname"><br><br>
          Last Name:  <input class="width2" type="text" name="lastname"><br><br>
          NYSEG Account Number:  <input class="width1" type="text" name="nyseg"><br><br>
          Home Address:  <input class="width3" type="text" name="address"><br><br>
          Phone Number (optional):  <input class="width1" type="text" name="phone"><br><br>
      </div>
       <?php echo '<div id="message">'.$message.'</div>' ?>
      <div class="rounded-corners clearfix colelem" id="u1003-4"><!-- content -->
       <p id="u1003-2">GET STARTED</p>
      </div>
    </form>
    <div class="browser_width colelem" id="u1009-bw">
     <div id="u1009"><!-- group -->
      <div class="clearfix" id="u1009_align_to_page">
       <div class="clearfix grpelem" id="u1012-7"><!-- content -->
        <p id="u1012-2">Get access to your household energy consumption anytime, anywhere</p>
        <p id="u1012-3">&nbsp;</p>
        <p id="u1012-5">Simply log into d.Meter, and you can view your household energy usage and cost in real time.</p>
       </div>
       <div class="clearfix grpelem" id="pu1118"><!-- column -->
        <div class="clip_frame colelem" id="u1118"><!-- image -->
         <img class="block" id="u1118_img" src="images/energy%20usage.png?crc=3799165648" alt="" data-image-width="449" data-image-height="89"/>
        </div>
        <div class="clearfix colelem" id="u1095-4"><!-- content -->
         <p>June</p>
        </div>
       </div>
      </div>
     </div>
    </div>
    <div class="browser_width colelem" id="u1015-bw">
     <div id="u1015"><!-- group -->
      <div class="clearfix" id="u1015_align_to_page">
       <div class="clip_frame grpelem" id="u1138"><!-- image -->
        <img class="block" id="u1138_img" src="images/environmental%20impact.png?crc=301936809" alt="" data-image-width="322" data-image-height="289"/>
       </div>
       <div class="clearfix grpelem" id="u1016-5"><!-- content -->
        <p id="u1016-2">Understand your energy impacts to the environment</p>
        <p id="u1016-3">&nbsp;</p>
       </div>
      </div>
     </div>
    </div>
    <div class="browser_width colelem" id="u1021-bw">
     <div id="u1021"><!-- group -->
      <div class="clearfix" id="u1021_align_to_page">
       <div class="clearfix grpelem" id="u1022-7"><!-- content -->
        <p id="u1022-2">Stay alerted about unusual energy spikes</p>
        <p id="u1022-3">&nbsp;</p>
        <p id="u1022-5">d.Meter analyzes the energy usage pattern and notifies you when an unusual energy event takes place.</p>
       </div>
       <div class="clearfix grpelem" id="pu1148"><!-- column -->
        <div class="clip_frame colelem" id="u1148"><!-- image -->
         <img class="block" id="u1148_img" src="images/energy%20spike.png?crc=1556875" alt="" data-image-width="427" data-image-height="157"/>
        </div>
        <div class="clearfix colelem" id="u1158-4"><!-- content -->
         <p>Energy Spike</p>
        </div>
       </div>
      </div>
     </div>
    </div>
    <div class="verticalspacer" data-offset-top="1895" data-content-above-spacer="1895" data-content-below-spacer="62"></div>
    <div class="clearfix colelem" id="u1027-4"><!-- content -->
     <p>@d.Meter 2017</p>
    </div>
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
  <script type="text/javascript" src="scripts/index.js"></script>
   </body>
</html>