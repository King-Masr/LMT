let question = "No Question";
let score = 0;
let answer = 0;
let myInput = document.getElementById("input");
let time = document.getElementById("time");
let myCheckBtn = document.getElementById("check");
function play() {
  time.innerText = Math.trunc(question.length / 2);
  let timer = setInterval(function () {
    time.innerText--;
    if (time.innerText == "0") {
      clearInterval(timer);
      myCheckBtn.click();
    }
  }, 1000);
}
let startBtn = document.getElementById("start");
startBtn.onclick = function () {
  document.getElementById("popop").remove();
  newQuestion();
};
let profileBtn = document.getElementById("profile");
let loginBtn = document.getElementById("login");
let myScoreSpan = document.getElementById("score");
function getCookie(name) {
  let value = null;
  let x1 = document.cookie.split("; ");
  let y1 = Array.from(x1);
  y1.forEach((cookie) => {
    let x2 = cookie.split("=");
    let y2 = Array.from(x2);
    if (y2[0] == name) {
      value = y2[1];
      return true;
    }
  });
  return value;
}
let myUsername = getCookie("username");
if (myUsername == null) {
  profileBtn.remove();
  loginBtn.onclick = function () {
    document.forms[0].submit();
  };
} else {
  loginBtn.innerText = "Sign Out";
  getUser(myUsername);
  loginBtn.onclick = function () {
    window.location.href = `${window.location.origin}/?logout=yes`;
  };
  document.forms[0].remove();
}
myInput.onfocus = function () {
  myInput.style.boxShadow = "5px 5px 2px #3585c7";
};
myInput.onblur = function () {
  myInput.style.boxShadow = "";
};
myInput.onpaste = function (e) {
  e.preventDefault();
};
myInput.ondrop = function (e) {
  e.preventDefault();
};
window.ononline = function () {
  getUser(myUsername);
};
profileBtn.onclick = function () {
  window.location.href = `${window.location.origin}/profile.php?user=${myUsername}`;
};
function getUser(username) {
  let myRequest = new XMLHttpRequest();
  myRequest.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      let myResponse = JSON.parse(this.responseText);
      if (myResponse.ok != false) {
        score = myResponse.score;
        answer = myResponse.answer;
        profileBtn.innerText = myResponse.name;
      }
      myScoreSpan.innerText = `Score: ${score}`;
    }
  };
  myRequest.open("POST", "../foo.php", true);
  myRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  myRequest.send(`action=users&username=${username}`);
}
myCheckBtn.onclick = function () {
  if (myInput.value == question) {
    score++;
    answer++;
    myScoreSpan.innerText = `Score: ${score}`;
    if (myUsername == null) {
      Congratulation();
      document.getElementById("scorei").value = score;
      document.getElementById("answer").value = answer;
    } else {
      nextQuestion();
      let myRequest = new XMLHttpRequest();
      myRequest.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          let myResponse = JSON.parse(this.responseText);
          myScoreSpan.innerText = `Score: ${myResponse.score}`;
        }
      };
      myRequest.open("POST", "../foo.php", true);
      myRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      myRequest.send(`action=update&username=${myUsername}&score=${score}&answer=${answer}`);
    }
  } else {
    wrongQuestion();
  }
};
function newQuestion() {
  let myRequest = new XMLHttpRequest();
  myRequest.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      if (this.responseText != "") {
        document.getElementById("question").innerText = this.responseText;
        question = this.responseText;
        myInput.value = "";
        myInput.focus();
        play();
      }
    }
  };
  myRequest.open("POST", "../foo.php", true);
  myRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  myRequest.send("action=questions");
}
function Congratulation() {
  let popSection = document.createElement("section");
  popSection.id = "pop";
  let popMessage = document.createElement("section");
  popSection.appendChild(popMessage);
  popMessage.id = "message";
  let messageHeader = document.createElement("header");
  popMessage.appendChild(messageHeader);
  let myHeading = document.createElement("h2");
  myHeading.innerText = "!تهانينا";
  messageHeader.appendChild(myHeading);
  let closeBtn = document.createElement("span");
  closeBtn.id = "close";
  messageHeader.appendChild(closeBtn);
  let messageBody = document.createElement("main");
  popMessage.appendChild(messageBody);
  let myParagraph = document.createElement("p");
  myParagraph.innerText =
    "تهانينا لك عزيزي لقد كتبت الجملة بشكل صحيح لقد حصلت على نقطة هل تريد حفظ تقدمك قم بانشاء حساب";
  messageBody.appendChild(myParagraph);
  let myFooter = document.createElement("footer");
  popMessage.appendChild(myFooter);
  let firstBtn = document.createElement("span");
  firstBtn.innerText = "السؤال التالي";
  myFooter.appendChild(firstBtn);
  firstBtn.id = "next";
  let secondBtn = document.createElement("span");
  secondBtn.innerText = "انشاء حساب";
  myFooter.appendChild(secondBtn);
  secondBtn.id = "login";
  document.body.appendChild(popSection);
  closeBtn.onclick = function () {
    document.getElementById("pop").remove();
  };
  firstBtn.onclick = function () {
    newQuestion();
    popSection.remove();
  };
  secondBtn.onclick = function () {
    document.forms[0].submit();
  };
}
function nextQuestion() {
  let popSection = document.createElement("section");
  popSection.id = "pop";
  let popMessage = document.createElement("section");
  popSection.appendChild(popMessage);
  popMessage.id = "message";
  let messageHeader = document.createElement("header");
  popMessage.appendChild(messageHeader);
  let myHeading = document.createElement("h2");
  myHeading.style.margin = "0.83em auto";
  myHeading.innerText = "!تهانينا";
  messageHeader.appendChild(myHeading);
  let messageBody = document.createElement("main");
  messageBody.style.height = "50%";
  popMessage.appendChild(messageBody);
  let myParagraph = document.createElement("p");
  myParagraph.innerText = "لقد حصلت على نقطة، جاري البحث عن سؤال آخر";
  messageBody.appendChild(myParagraph);
  let myFooter = document.createElement("footer");
  popMessage.appendChild(myFooter);
  myFooter.id = "loading";
  let firstBtn = document.createElement("span");
  myFooter.appendChild(firstBtn);
  let secondBtn = document.createElement("span");
  myFooter.appendChild(secondBtn);
  let thirdBtn = document.createElement("span");
  myFooter.appendChild(thirdBtn);
  document.body.appendChild(popSection);
  setTimeout(function () {
    newQuestion();
    document.getElementById("pop").remove();
    myInput.focus();
  }, 2500);
}
function wrongQuestion() {
  let popSection = document.createElement("section");
  popSection.id = "pop";
  let popMessage = document.createElement("section");
  popSection.appendChild(popMessage);
  popMessage.id = "message";
  let messageHeader = document.createElement("header");
  popMessage.appendChild(messageHeader);
  let myHeading = document.createElement("h2");
  myHeading.style.margin = "0.83em auto";
  myHeading.innerText = "!لقد خسرت";
  messageHeader.appendChild(myHeading);
  let messageBody = document.createElement("main");
  messageBody.style.height = "50%";
  popMessage.appendChild(messageBody);
  let myParagraph = document.createElement("p");
  myParagraph.innerText = "للآسف يا عزيزي لقد خسرت حاول مجددا في سؤال آخر";
  messageBody.appendChild(myParagraph);
  let myFooter = document.createElement("footer");
  popMessage.appendChild(myFooter);
  myFooter.id = "loading";
  let firstBtn = document.createElement("span");
  myFooter.appendChild(firstBtn);
  let secondBtn = document.createElement("span");
  myFooter.appendChild(secondBtn);
  let thirdBtn = document.createElement("span");
  myFooter.appendChild(thirdBtn);
  document.body.appendChild(popSection);
  setTimeout(function () {
    myInput.value = "";
    newQuestion();
    document.getElementById("pop").remove();
    myInput.focus();
  }, 2500);
}
