let myInputs = document.getElementsByTagName("input");
let inputs = Array.from(myInputs);
inputs.forEach((ele) => {
  ele.error = function (hint) {
    let placeholder = ele.placeholder;
    ele.style.outline = "1px solid #ff0000";
    ele.placeholder = hint;
    setTimeout(function () {
      ele.style.outline = "0";
      ele.placeholder = placeholder;
    }, 5000);
  };
})
let myTabs = document.querySelectorAll("#login #tabs li");
let tabs = Array.from(myTabs);
let myForms = document.querySelectorAll("#login #content form");
let forms = Array.from(myForms);
tabs.forEach((ele) => {
  ele.addEventListener("click", function (e) {
    tabs.forEach((ele) => {
      ele.id = "";
    });
    e.currentTarget.id = "active";
    forms.forEach((form) => {
      form.style.display = "none";
    });
    document.querySelector(e.currentTarget.dataset.id).style.display = "block";
  });
});
let validate = {
  username: false,
  name: false,
  email: false,
  password: false,
  repassword: false,
};
let myUsername = document.getElementById("username");
myUsername.onblur = function (e) {
  if (myUsername.value.length >= 5) {
    let myRequest = new XMLHttpRequest();
    myRequest.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
        let myResponse = JSON.parse(this.responseText);
        if (myResponse.ok == true) {
          validate.username = true;
        } else {
          myUsername.error("! Sorry Username Is Used !");
        }
      }
    };
    myRequest.open("POST", "../foo.php", true);
    myRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    myRequest.send(`action=username&username=${myUsername.value}`);
  } else {
    myUsername.error("! Your Username is must be greeter than 5 !");
  }
};
let myName = document.getElementById("name");
myName.onblur = function (e) {
  if (myName.value.length >= 7) {
    validate.name = true;
  } else {
    myName.error("! Name must be more than 7 Character !");
  }
};
let myEmail = document.getElementById("email");
myEmail.onblur = function (e) {
  if (myEmail.value.length >= 6) {
    if (
      myEmail.value.includes("@gmail.com") == true ||
      myEmail.value.includes("@yahoo.com") == true ||
      myEmail.value.includes("@outlook.com") == true
    ) {
      let myRequest = new XMLHttpRequest();
      myRequest.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          let myResponse = JSON.parse(this.responseText);
          if (myResponse.ok == true) {
            validate.email = true;
          } else {
            myEmail.error("! There is account with this email !\n! Please Sign In !");
            document.querySelector("#login #tabs li:last-child").click();
          }
        }
      };
      myRequest.open("POST", "../foo.php", true);
      myRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      myRequest.send(`action=email&email=${myEmail.value}`);
    } else {
      validate.email = false;
      myEmail.error("! We Don't Trust This Email use gmail !");
    }
  } else {
    validate.email = false;
    myEmail.error("! Email must be more than or Eqaul 6 Character !");
  }
};
let myPassword = document.getElementById("password");
myPassword.onblur = function (e) {
  if (myPassword.value.length > 8) {
    validate.password = true;
  } else {
    myPassword.error("! Password must be at least 8 Character !");
  }
};
let myRepassword = document.getElementById("repassword");
myRepassword.onblur = function (e) {
  if (myRepassword.value == myPassword.value) {
    validate.repassword = true;
  } else {
    myRepassword.error("! Password Not Equals !");
  }
};
document.forms[0].onsubmit = function (e) {
  if (
    validate.username == false ||
    validate.name == false ||
    validate.password == false ||
    validate.repassword == false
  ) {
    e.preventDefault();
  }
};
let validate1 = {
  username: false,
  password: false,
};
let myUsernamei = document.getElementById("usernamei");
myUsernamei.onblur = function () {
  let myRequest = new XMLHttpRequest();
  myRequest.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      let myResponse = JSON.parse(this.responseText);
      if (myResponse.ok == false) {
        validate1.username = true;
      } else {
        myUsernamei.error("! There Is No Account With This Username !\n! Please Sign Up !");
      }
    }
  };
  myRequest.open("POST", "../foo.php", true);
  myRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  myRequest.send(`action=username&username=${myUsernamei.value}`);
};
let myPasswordi = document.getElementById("passwordi");
myPasswordi.onblur = function () {
  let myRequest = new XMLHttpRequest();
  myRequest.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      let myResponse = JSON.parse(this.responseText);
      if (myResponse.ok == true) {
        validate1.password = true;
      } else {
        myPasswordi.error("! Password Wrong !\n! Please Try Again Later !");
      }
    }
  };
  myRequest.open("POST", "../foo.php", true);
  myRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  myRequest.send(`action=signin&username=${myUsernamei.value}&password=${myPasswordi.value}`);
};
document.forms[1].onsubmit = function (e) {
  if (validate1.username == false || validate1.password == false) {
    e.preventDefault();
  }
};
