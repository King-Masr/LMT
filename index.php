<?php
  $uri = str_replace("index.php", "", $_SERVER["SCRIPT_NAME"]);
  header("Access-Control-Allow-Origin: *");
  session_start();
  if (@$_GET["logout"] == "yes") {
    $_SESSION["login"] = "no";
    unset($_SESSION["username"]);
    unset($_SESSION["password"]);
    header("Location: ".$uri);
  }
  if (@$_SESSION["login"] == "yes") {
    setcookie("login", $_SESSION["login"]);
    setcookie("username", $_SESSION["username"]);
    setcookie("password", $_SESSION["password"]);
  } elseif (@$_SESSION["login"] == "no") {
    setcookie("login", "", -1);
    setcookie("username", "", -1);
    setcookie("password", "", -1);
  } else {
    if (@$_COOKIE["login"] == "yes") {
      $_SESSION["login"] = $_COOKIE["login"];
      $_SESSION["username"] = $_COOKIE["username"];
      $_SESSION["password"] = $_COOKIE["password"];
      header("Location: ".$uri);
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>LMT - Learn Me Type</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/normalise.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="h8lMGU9_1iXRPfVsjpv2qwnRfOzy6A_Y1_JKzkU5sug" />
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7751237521788876" crossorigin="anonymous"></script>
  </head>
  <body>
    <header>
      <main>
        <p>موقع لتعليم السرعة والدقة في الكتابة</p>
      </main>
    </header>
    <section id="landing">
      <section id="popop">
        <span id="start">Start</span>
      </section>
      <header>
        <span id="score">Score: 0</span>
        <section id="setting">
          <span id="profile">My Profile</span>
          <span id="login">Login</span>
        </section>
        <h1>
          <span id="l">L</span>
          <span id="m">M</span>
          <span id="t">T</span>
        </h1>
      </header>
      <main>
        <p id="question">يتم البحث عن سؤال...</p>
        <input type="text" id="input" placeholder="اكتب هنا ما تراه بالأعلى!">
        <section id="timer">
          <h4>Time Left: <span id="time">5</span>s</h4>
        </section>
        <section id="btns">
          <span id="check">تحقق</span>
        </section>
      </main>
    </section>
    <footer></footer>
    <form action="login.php" method="post" style="display: none;">
      <input type="hidden" name="score" id="scorei" value="0">
    </form>
    <script src="js/main.js"></script>
    <!-- Messenger Code -->
    <div id="fb-root"></div>
    <!-- Your code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>
    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "103839318756415");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>
    <!-- Facebook SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v12.0'
        });
      };
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/ar_AR/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
  </body>
</html>
