<?php
session_start();

if ((isset($_SESSION['logged_in'])) && ($_SESSION['logged_in'] == true)) {
  header('Location: ../index.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/style_login.css">
  <style>
    .test {
      background-color: #f0f0f0;
      padding: 30px;
      border-radius: 25px;
      width: 500px;
      overflow: hidden;
      position: relative;
      transition: height 0.5s ease;
    }

    .forms {
      display: flex;
      transition: transform 0.5s ease;
      width: 200%;
      transform: translateX(0);
    }

    .login {
      transform: translateX(0);
    }

    .signup {
      transform: translateX(100%);
    }


    .tabs {
      display: flex;
      position: relative;
    }

    .tab {
      flex: 1;
      padding: 15px 0;
      text-align: center;
      cursor: pointer;
      border: none;
      outline: none;
    }

    .tab.active {
      font-weight: 800 !important;
      color: #400DD0;
    }

    .highlight {
      position: absolute;
      bottom: 0;
      width: 50%;
      height: 4px;
      background: #400DD0;
      transition: transform 0.3s ease;
    }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
  <!--
  <div class="container">
    <div class="boxLogin">
      <div></div>
      <h1 class="boxTitle">Zaloguj się</h1>
      <div class="d-flex justify-content-center">
        <img class="boxAvatar" src="../imgs/UI/login_user.png" id="userIdmage" style="border-radius: 50%; transition: opacity 0.5s ease-in-out;">
      </div>
      <div class="boxForm d-flex justify-content-center">
        <form method="post" action="../actions/actionLogin.php">
          <div class="form-floating">
            <input type="text" class="form-control" id="floatingEmail" name="email" placeholder="">
            <label for="floatingEmail" class="floatingLabelForm">Adres e-mail</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control mt-3" id="floatingPass" name="password" placeholder="">
            <label for="floatingPass" class="floatingLabelForm">Hasło</label>
          </div>
            <div class="d-flex justify-content-center wrongData">
              <h5 class="mt-1 mx-2 shake-text">Nieprawidłowy e-mail lub hasło!</h5>
            </div>
          <div class="sendButton d-flex justify-content-center">
            <button type="submit" class="btn violetButton d-flex align-items-center justify-content-center">Zaloguj</button>
          </div>
        </form>
      </div>
      <p class="linkRegistration d-flex justify-content-center">Nie masz jeszcze konta?&nbsp; <a class="violetMark" href="register.php">Utwórz konto</a></p>
    </div>
  </div>
  -->


  <div class="container d-flex flex-column">
    <div class="d-flex justify-content-center align-self-center z-3" style="width: 130px; margin-bottom:-65px">
      <img class="img-fluid" src="../imgs/UI/login_user.png" id="userImage" style="border-radius: 50%; transition: opacity 0.5s ease-in-out; border:3px solid gray;">
    </div>
    <div class="test">
      <div class="tabs mt-5">
        <button id="loginTab" class="tab active toggle fw-semibold">Zaloguj się</button>
        <button id="signUpTab" class="tab toggle2 fw-semibold">Zarejestruj się</button>
        <div class="highlight"></div>
      </div>
      <div class="forms">
        <div class="w-50 p-2 login">
          <form method="post" action="../actions/actionLogin.php">
            <div class="form-floating mt-4">
              <input type="text" class="form-control rounded-4" id="floatingEmail" name="email" placeholder="" value="<?php if (isset($_SESSION['valueEmail'])) echo $_SESSION['valueEmail'];
                                                                                                                      unset($_SESSION['valueEmail']); ?>">
              <label for="floatingEmail">Adres e-mail</label>
            </div>
            <div class="form-floating">
              <input type="password" class="form-control mt-3 rounded-4" id="floatingPass" name="password" placeholder="">
              <label for="floatingPass">Hasło</label>
            </div>
            <?php if (isset($_SESSION['error'])) { ?>
              <div class="d-flex justify-content-center wrongData">
                <h6 class="mt-1 mx-2 shake-text">Nieprawidłowy e-mail lub hasło!</h6>
              </div>
            <?php }
            unset($_SESSION['error']); ?>
            <div class="sendButton d-flex justify-content-center">
              <button type="submit" class="btn violetButton rounded-4 fs-5">Zaloguj</button>
            </div>
          </form>
        </div>
        <div class="w-50 p-2 signup">

        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script>
    var input1 = document.getElementById('floatingEmail');
    input1.addEventListener("change", GetUserImg);
    <?php if (isset($_SESSION['error2'])) {
      echo "GetUserImg();";
      unset($_SESSION['error2']);
    } ?>

    function GetUserImg() {
      var username = input1.value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var imagePath = this.responseText;

          var imgElement = document.getElementById("userImage");
          imgElement.style.opacity = 0;

          imgElement.addEventListener("transitionend", function() {
            imgElement.src = imagePath;
            imgElement.style.opacity = 1;
          }, {
            once: true
          });
        }
      };
      xmlhttp.open("GET", "../actions/actionGetUserImage.php?email=" + username, true);
      xmlhttp.send();
    }

    const forms = document.querySelector('.forms');
    const container = document.querySelector('.test');
    const highlight = document.querySelector('.highlight');
    const loginTab = document.querySelector('#loginTab');
    const signUpTab = document.querySelector('#signUpTab');

    document.querySelector('.toggle').addEventListener('click', event => {
      forms.style.transform = 'translateX(0)';
      highlight.style.transform = 'translateX(0)';
      container.style.height = '414px';
      loginTab.classList.add('active');
      signUpTab.classList.remove('active');
    });
    document.querySelector('.toggle2').addEventListener('click', event => {
      forms.style.transform = 'translateX(-100%)';
      highlight.style.transform = 'translateX(100%)';
      container.style.height = '150px';
      loginTab.classList.remove('active');
      signUpTab.classList.add('active');
    });
  </script>
</body>

</html>