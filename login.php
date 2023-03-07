<?php
  $uri = str_replace("login.php", "", $_SERVER["SCRIPT_NAME"]);
  header("Access-Control-Allow-Origin: *");
  $score = 0;
  $answer = 0;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["score"] != null && $_POST["answer"] != null) {
      $score = $_POST["score"];
      $answer = $_POST["answer"];
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>LMT - Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/normalise.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
  </head>
  <body>
    <section id="landing">
      <h2 id="mainTitle">Log In</h2>
      <main>
        <section  id="login">
          <ul id="tabs">
            <li id="active" data-id="#Signup">Sign Up</li>
            <li data-id="#Signin">Sign In</li>
          </ul>
          <section id="content">
            <form action="foo.php" method="post" id="Signup">
              <input type="hidden" name="action" value="createaccount">
              <input type="hidden" name="provider" value="email">
              <input type="hidden" name="score" value="<?php echo $score; ?>">
              <input type="hidden" name="answer" value="<?php echo $answer; ?>">
              <ul>
                <li><input type="text" name="username" id="username" placeholder="Enter your Username" required></li>
                <li><input type="text" name="name" id="name" placeholder="Enter your Full Name" required></li>
                <li><input type="email" name="email" id="email" placeholder="Enter your Email"></li>
                <li><input type="password" name="password" id="password" placeholder="Enter your Password" required></li>
                <li><input type="password" id="repassword" placeholder="reEnter your Password" required displayed></li>
              </ul>
              <input type="submit" value="Sign Up" id="signup">
            </form>
            <form action="foo.php" method="post" id="Signin">
              <input type="hidden" name="action" value="signtoaccount">
              <ul>
                <li><input type="text" name="username" id="usernamei" placeholder="Enter your Username" required></li>
                <li><input type="password" name="password" id="passwordi" placeholder="Enter your Password" required></li>
              </ul>
              <input type="submit" value="Sign In" id="signin">
            </form>
            <section id="sociallogin">
              <div class="fb-login-button" data-width="100" data-size="large" data-button-type="continue_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="true"></div>
            </section>
          </section>
        </section>
      </main>
    </section>
    <script src="js/login.js"></script>
    <script type="module">
      // Import the functions you need from the SDKs you need
import { initializeApp } from "<?php echo $uri; ?>node_modules/firebase/app";
import { getAnalytics } from "<?php echo $uri; ?>node_modules/firebase/firebase-analytics.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyD8p5ck5vQdML22iGpuyzYNn-nNlhhDb-M",
  authDomain: "lmet-4dde8.firebaseapp.com",
  projectId: "lmet-4dde8",
  storageBucket: "lmet-4dde8.appspot.com",
  messagingSenderId: "999888732597",
  appId: "1:999888732597:web:a9e5383816f81785e459fc",
  measurementId: "G-BYQPSKX4GN",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
console.log(app);
const analytics = getAnalytics(app);

    </script>
  </body>
</html>
