<?php
  $uri = str_replace("foo.php", "", $_SERVER["SCRIPT_NAME"]);
  // $dns = "mysql:host=sql213.epizy.com;dbname=epiz_31734586_lmt";
  $dns = "mysql:host=127.0.0.1;dbname=lmt";
  $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8;");
  // $db = new PDO($dns, "epiz_31734586", "hoA5gxEEYHo4", $option);
  $db = new PDO($dns, "root", "", $option);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == "createaccount") {
      $q = "";
      if ($_POST["email"] == "") {
        $q = "INSERT INTO `accounts` (`username`, `email`, `password`, `provider`, `id`) VALUES ('".$_POST["username"]."', NULL, '".$_POST["password"]."', '".$_POST["provider"]."', NULL);";
      } else {
        $q = "INSERT INTO `accounts` (`username`, `email`, `password`, `provider`, `id`) VALUES ('".$_POST["username"]."', '".$_POST["email"]."', '".$_POST["password"]."', '".$_POST["provider"]."', NULL);";
      }
      $db->exec($q);
      $q = "INSERT INTO `users` (`username`, `name`, `level`, `score`, `answer`, `help`, `id`) VALUES ('".$_POST["username"]."', '".$_POST["name"]."', '1', '".$_POST["score"]."', '".$_POST["answer"]."', '0', NULL);";
      $db->exec($q);
      session_start();
      $_SESSION["login"] = "yes";
      $_SESSION["username"] = $_POST["username"];
      $_SESSION["password"] = $_POST["password"];
      header("Location: ".$uri);
    } elseif ($_POST["action"] == "signtoaccount") {
      $q = "SELECT * FROM `accounts` WHERE `username` = '".$_POST["username"]."';";
      foreach ($db->query($q) as $user) {}
      if ($user["password"] == $_POST["password"]) {
        echo json_encode(["ok"=>true, "description"=>"Password Is right"], 128|32|256);
      } else {
        echo json_encode(["ok"=>false, "description"=>"Password Is Wrong"], 128|32|256);
      }
      header("Location: ".$uri);
    } elseif ($_POST["action"] == "signin") {
      $q = "SELECT * FROM `accounts` WHERE `username` = '".$_POST["username"]."';";
      foreach ($db->query($q) as $user) {}
      if ($user["password"] == $_POST["password"]) {
        echo json_encode(["ok"=>true, "description"=>"Password Is right"], 128|32|256);
        session_start();
        $_SESSION["login"] = "yes";
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["password"] = $_POST["password"];
      } else {
        echo json_encode(["ok"=>false, "description"=>"Password Is Wrong"], 128|32|256);
      }
    } elseif ($_POST["action"] == "questions") {
      $questions = [];
      $q = "SELECT * FROM `questions`;";
      foreach ($db->query($q) as $question) {
        $questions[(count($questions)+1)] = $question;
      }
      $num = count($questions);
      $number = rand(1, $num);
      if (gettype($questions[$number][0]) == "string") {
        echo $questions[$number][0];
      }
    } elseif ($_POST["action"] == "users") {
      $q = "SELECT * FROM `users` WHERE `username` = '".$_POST["username"]."';";
      foreach ($db->query($q) as $user) {}
      if (empty($user)) {
        echo json_encode(["ok"=>false, "description"=>"Username Is Not Found"], 128|32|256);
      } else {
        echo json_encode($user, 128|32|256);
      }
    } elseif ($_POST["action"] == "username") {
      $q = "SELECT * FROM `users` WHERE `username` = '".$_POST["username"]."';";
      foreach ($db->query($q) as $user) {}
      if (empty($user)) {
        echo json_encode(["ok"=>true, "description"=>"Username Is Not Found"], 128|32|256);
      } else {
        echo json_encode(["ok"=>false, "description"=>"Username Is Used"], 128|32|256);
      }
    } elseif ($_POST["action"] == "email") {
      $q = "SELECT * FROM `accounts` WHERE `email` = '".$_POST["email"]."';";
      foreach ($db->query($q) as $user) {}
      if (empty($user)) {
        echo json_encode(["ok"=>true, "description"=>"Email Is Not Found"], 128|32|256);
      } else {
        echo json_encode(["ok"=>false, "description"=>"Email Is Used"], 128|32|256);
      }
    } elseif ($_POST["action"] == "update") {
      $q = "UPDATE `users` SET ";
      if (@$_POST["name"] != "") {
        $q .= "`name` = '".$_POST["name"]."',";
      }
      if (@$_POST["level"] != "") {
        $q .= "`level` = '".$_POST["level"]."',";
      }
      if (@$_POST["score"] != "") {
        $q .= "`score` = '".$_POST["score"]."',";
      }
      if (@$_POST["answer"] != "") {
        $q .= "`answer` = '".$_POST["answer"]."',";
      }
      if (@$_POST["help"] != "") {
        $q .= "`help` = '".$_POST["help"]."',";
      }
      $q .= " WHERE `username` = '".$_POST["username"]."';";
      $q = str_replace(", WHERE", " WHERE", $q);
      $db->exec($q);
      $q = "SELECT * FROM `users` WHERE `username` = '".$_POST["username"]."';";
      foreach ($db->query($q) as $user) {
        echo json_encode($user);
      }
    }
  } else {
    header("Location: /errors/403.html");
  }
?>