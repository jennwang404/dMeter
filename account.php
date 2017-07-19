<?php session_start(); ?>
<!DOCTYPE html>
<html class="nojs html css_verticalspacer" lang="en-US">
 <head>

  <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
  <meta name="generator" content="2017.0.1.363"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <script src="scripts/stretchy.min.js" async></script>
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
     <a href="index.php"><img class="grpelem" id="u120-4" alt="d.Meter" src="images/u120-4.png?crc=416918895" data-image-width="97"/></a><!-- rasterized frame -->
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

    $message = null;
    
    $user_query = "SELECT * FROM Users WHERE email = '$user'";

    $user_result = $mysqli->query($user_query);

    if (isset($_POST['submit']) && $_POST['submit']=="LOG OUT") {
      unset($_SESSION['user']);
      $url = $_SERVER['REQUEST_URI'];
      $newurl =  substr($url, 0, -11)."index.php";
      echo '<script type="text/javascript">window.location ='."'".$newurl."'".'</script>';
    } else if (isset($_POST['submit']) && $_POST['submit']=="Update Information") {
      
      $newuser = $_POST['email'];
      $newfirstname = $_POST['firstname'];
      $newlastname = $_POST['lastname'];
      $newnyseg = $_POST['nyseg'];
      $newaddress = $_POST['address'];
      $newphone = $_POST['phone'];
      $newpassword = $_POST['password'];
      $newpasswordconfirm = $_POST['passwordconfirm'];

      $row = $user_result->fetch_assoc();
      $olduser = $row['email'];
      $oldfirstname = $row['firstname'];
      $oldlastname = $row['lastname'];
      $oldnyseg = $row['nyseg'];
      $oldaddress = $row['address'];
      $oldphone = $row['phone'];

      $updatequery = "UPDATE Users SET ";

      if ($newuser !== $olduser) {
        if (!filter_var($newuser, FILTER_VALIDATE_EMAIL)) {
          $message = "Invalid email address";
        } else {
          $updatequery = $updatequery."email='$newuser', ";
        }
      }
      if ($newfirstname !== $oldfirstname) {
        if (ctype_alpha(str_replace(' ', '', $newfirstname)) === false) {
          $message = 'First name must contain letters and spaces only';
        } else {
          $updatequery = $updatequery."firstname='$newfirstname', ";
        }
      }
      if ($newlastname !== $oldlastname) {
        if (ctype_alpha(str_replace(' ', '', $newlastname)) === false) {
            $message = 'Last name must contain letters and spaces only';
        } else {
          $updatequery = $updatequery."lastname='$newlastname', ";
        }
      }
      if ($newnyseg !== $oldnyseg) {
        if (strlen($newnyseg) != 10) {
          $message = 'Invalid NYSEG account number';
        } else {
          $updatequery = $updatequery."nyseg='$newnyseg', ";
        }
      }
      if ($newaddress !== $oldaddress) {
        if (strlen($newaddress) == 0) {
          $message = 'Please enter a valid home address';
        } else {
          $updatequery = $updatequery."address='$newaddress', ";
        }
      }
      if ($newphone !== $oldphone) {
        if ($newphone != null && strlen($newphone) != 10 && strlen($newphone) != 11) {
          $message = 'Invalid phone number';
        } else {
          $updatequery = $updatequery."phone='$newphone', ";
        }
      }

      if (str_replace(' ', '', $newpassword) != "") {
        if (str_replace(' ', '', $newpassword) === str_replace(' ', '', $newpasswordconfirm)) {
          $new_hashed_password = password_hash(str_replace(' ', '', $newpassword), PASSWORD_DEFAULT);
          $updatequery = $updatequery."hashpassword='$new_hashed_password', ";
        } else {
          $message = "New passwords don't match";
        }
      }

      $updatequery = substr($updatequery, 0, -2)." WHERE email='$olduser'";

      if ($message == null) {
        $result = $mysqli->query($updatequery);
        if ($result){
          $message = "Update successful";
          $_SESSION['user'] = $newuser;
        }
      }
    }

    if (isset($_SESSION['user']) && $user_result) {
        $row = $user_result->fetch_assoc();
        $user = $row['email'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $nyseg = $row['nyseg'];
        $address = $row['address'];

        if ($row['phone'] != 0) {
          $phone = $row['phone'];
        } else {
          $phone = "";
        }

        //The user hasn't clicked the Update Information button yet
        if ($row != null && $message !== "Update successful") {
          echo '<form method="post" action="">';
          echo '<div id="user-info">';
          echo 'User Information:<br><br><br>';
          echo '<div id="message">'.$message.'</div>';
          echo 'Name: <input id="edit-firstname" class="account" type="text" name="firstname" value='.$firstname.">";
          echo ' <input id="edit-lastname" class="account" type="text" name="lastname" value='.$lastname."><br>";
          echo 'Username/email: <input id="edit-email" class="account" type="text" name="email" value='.$user."><br>";
          echo 'NYSEG Account Number: <input id="edit-nyseg" class="account" type="text" name="nyseg" value='.$nyseg."><br>";
          echo 'Home Address: <input id="edit-address" class="account" type="text" name="address" value='.'"'.$address.'"'."><br>";
          echo 'Phone number: <input id="edit-phone" class="account" type="text" name="phone" value='.$phone."><br><br>";
          echo 'New Password: <input id="edit-password" class="account" type="text" name="password" value="       "><br>';
          echo 'Confirm New Password: <input id="edit-password-confirm" class="account" type="text" name="passwordconfirm" value="      "><br><br>';
          echo '<div id="submit-button-div"><input id="edit-submit" type="submit" name="submit" value="Update Information"></div></div></form>';
        } 
        /* The user has clicked the Update Information button and all the inputs check out. The db has successfully been updated and
            the session variable changed if needed */
        else if ($message == "Update successful") {
          echo '<form method="post" action="">';
          echo '<div id="user-info">';
          echo 'User Information:<br><br><br>';
          echo '<div id="message">'.$message.'</div>';
          echo 'Name: <input id="edit-firstname" class="account" type="text" name="firstname" value='.$newfirstname.">";
          echo ' <input id="edit-lastname" class="account" type="text" name="lastname" value='.$newlastname."><br>";
          echo 'Username/email: <input id="edit-email" class="account" type="text" name="email" value='.$newuser."><br>";
          echo 'NYSEG Account Number: <input id="edit-nyseg" class="account" type="text" name="nyseg" value='.$newnyseg."><br>";
          echo 'Home Address: <input id="edit-address" class="account" type="text" name="address" value='.'"'.$newaddress.'"'."><br>";
          echo 'Phone number: <input id="edit-phone" class="account" type="text" name="phone" value='.$newphone."><br><br>";
          echo 'New Password: <input id="edit-password" class="account" type="text" name="password" value="       "><br>';
          echo 'Confirm New Password: <input id="edit-password-confirm" class="account" type="text" name="passwordconfirm" value="      "><br><br>';
          echo '<div id="submit-button-div"><input id="edit-submit" type="submit" name="submit" value="Update Information"></div></div></form>';
        } 
        // The user has clicked the Update Information button but there was an error in at least one of the inputs 
        else {
          echo '<form method="post" action="">';
          echo '<div id="user-info">';
          echo 'User Information:<br><br><br>';
          echo '<div id="message">'.$message.'</div>';
          echo 'Name: <input id="edit-firstname" class="account" type="text" name="firstname" value='.$oldfirstname.">";
          echo ' <input id="edit-lastname" class="account" type="text" name="lastname" value='.$oldlastname."><br>";
          echo 'Username/email: <input id="edit-email" class="account" type="text" name="email" value='.$olduser."><br>";
          echo 'NYSEG Account Number: <input id="edit-nyseg" class="account" type="text" name="nyseg" value='.$oldnyseg."><br>";
          echo 'Home Address: <input id="edit-address" class="account" type="text" name="address" value='.'"'.$oldaddress.'"'."><br>";
          echo 'Phone number: <input id="edit-phone" class="account" type="text" name="phone" value='.$oldphone."><br><br>";
          echo 'New Password: <input id="edit-password" class="account" type="text" name="password" value="       "><br>';
          echo 'Confirm New Password: <input id="edit-password-confirm" class="account" type="text" name="passwordconfirm" value="      "><br><br>';
          echo '<div id="submit-button-div"><input id="edit-submit" type="submit" name="submit" value="Update Information"></div></div></form>';
        }
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
  <script type="text/javascript" src="scripts/account.js"></script>
   </body>
</html>
