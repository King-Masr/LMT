<?php
  header("Access-Control-Allow-Origin: https://www.facebook.com");
  if ($_SERVER["QUERY_STRING"] == null) {
    session_start();
    if (@$_SESSION["login"] == "yes") {
      header('Location: profile.php?user='.$_SESSION["username"]);
    } else {
      header('Location: login.php');
    }
  }
?>
<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>LMT - Profile</title>
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/normalise.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
  </head>
  <body>
    <section id="pop">
      <section id="profile">
        <header>
          <section id="image">
            <img src="imgs/profile.jpg" alt="profile image">
          </section>
          <section id="info">
            <h1 id="name">Loading...</h1>
            <p id="level">Loading...</p>
          </section>
        </header>
        <main>
          <ul>
            <li>Score:</li>
          </ul>
          <ul>
            <li id="score">Loading...</li>
          </ul>
        </main>
        <footer>
          <section>
            <h2 id="username">Profile of Username: </h2>
          </section>
        </footer>
      </section>
    </section>
    <script>
      function GET(name) {
        let urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has(name) === true) {
          return urlParams.get(name);
        } else {
          return undefined;
        }
      }
      let user = GET("user");
      window.onload = function () {
        let myRequest = new XMLHttpRequest();
        myRequest.onreadystatechange = function () {
          if (this.readyState === 4 && this.status === 200) {
            let myResponse = JSON.parse(this.responseText);
            if (myResponse.ok != false) {
              document.getElementsByTagName("title")[0].innerText = `LMT - ${myResponse.name}`;
              document.getElementById("name").innerText = myResponse.name;
              document.getElementById("level").innerText = `Level: ${myResponse.level}`;
              document.getElementById("score").innerText = myResponse.score;
              document.getElementById("username").innerHTML += `<a href="profile.php?user=${myResponse.username}">@${myResponse.username}</a>`;
            }
          }
        };
        myRequest.open("POST", "foo.php", true);
        myRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        myRequest.send(`action=users&username=${user}`);
      }
    </script>
  </body>
</html>