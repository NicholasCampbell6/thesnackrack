function showLogin() {
    if (document.getElementById("loginScreen").style.opacity === "0" && document.getElementById("loginScreen").style.display === "none") {
        document.getElementById("loginScreen").style.opacity = "1";
        document.getElementById("loginScreen").style.display = "block"
    }else{
        document.getElementById("loginScreen").style.opacity = "0";
        document.getElementById("loginScreen").style.display = "none"
    }
}

function showError(x) {
    document.getElementById(x).style.background = "linear-gradient(to bottom right, #ffffff 64%, #ff3300 100%)";
    document.getElementById(x).style.border = "1px solid red";
}

function closeWindow(x) {
    document.getElementById(x).style.opacity = '0';
    if(x == "windBack"){
        document.getElementById(x).style.display = 'none';
    }
}

window.onclick = function(event) {
  if (event.target == document.getElementById('windBack')) {
    document.getElementById('windBack').style.display = "none";
  }
}