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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
  <div class="container d-flex flex-column">
    <div class="d-flex justify-content-center align-self-center z-3" style="width: 130px; margin-bottom:-65px">
      <img class="userImage" src="../imgs/UI/login_user.png" id="userImage">
    </div>
    <div class="loginDiv">
      <div class="tabs mt-5">
        <button id="loginTab" class="tab active toggle fw-semibold">Zaloguj się</button>
        <button id="signUpTab" class="tab toggle2 fw-semibold">Zarejestruj się</button>
        <div class="loginSelectBar"></div>
      </div>
      <div class="forms">
        <div class="w-50 p-2 loginView">
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
            <div class="sendButton d-flex justify-content-center mt-4">
              <button type="submit" class="btn violetButton rounded-4 fs-5">Zaloguj</button>
            </div>
          </form>
        </div>
        <div class="w-50 p-2 signupView" id="signupView">
          <form method="post" action="../actions/actionRegister.php">
            <div class="form-floating mt-4">
              <input type="text" class="form-control rounded-4 <?php if (isset($_SESSION['error_email'])) { ?>is-invalid <?php } ?>" id="floatingEmail" name="email" placeholder="" value="<?php if (isset($_SESSION['p_email'])) echo $_SESSION['p_email'];
                                                                                                                                                                                            unset($_SESSION['p_email']); ?>">
              <label for="floatingEmail">Adres e-mail</label>
              <div class="invalid-feedback mx-4 mt-2 shake-text" style="color: #c02f2f;">
                <?php if (isset($_SESSION['error_email'])) {
                  echo $_SESSION['error_email'];
                  unset($_SESSION['error_email']);
                } ?>
              </div>
            </div>
            <div class="form-floating">
              <input type="password" class="form-control mt-3 rounded-4 <?php if (isset($_SESSION['error_password'])) { ?>is-invalid <?php } ?>" id="floatingPass" name="password" placeholder="">
              <label for="floatingPass">Hasło</label>
              <div class="invalid-feedback mx-4 mt-2 shake-text" style="color: #c02f2f;">
                <?php if (isset($_SESSION['error_password'])) {
                  echo $_SESSION['error_password'];
                  unset($_SESSION['error_password']);
                } ?>
              </div>
            </div>
            <div class="form-floating">
              <input type="password" class="form-control mt-3 rounded-4 <?php if (isset($_SESSION['error_password_check'])) { ?>is-invalid <?php } ?>" id="floatingPass" name="password-check" placeholder="">
              <label for="floatingPass">Powtórz hasło</label>
              <div class="invalid-feedback mx-4 mt-2 shake-text" style="color: #c02f2f;">
                <?php if (isset($_SESSION['error_password_check'])) {
                  echo $_SESSION['error_password_check'];
                  unset($_SESSION['error_password_check']);
                } ?>
              </div>
            </div>
            <?php if (isset($_SESSION['error'])) { ?>
              <div class="d-flex justify-content-center wrongData">
                <h6 class="mt-1 mx-2 shake-text">Nieprawidłowy e-mail lub hasło!</h6>
              </div>
            <?php }
            unset($_SESSION['error']); ?>
            <div class="sendButton d-flex justify-content-center mt-4">
              <button type="submit" class="btn violetButton rounded-4 fs-5">Zaloguj</button>
            </div>
          </form>
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
            imgElement.src = "../" + imagePath;
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
    const container = document.querySelector('.loginDiv');
    const loginSelectBar = document.querySelector('.loginSelectBar');
    const loginTab = document.querySelector('#loginTab');
    const signUpTab = document.querySelector('#signUpTab');
    const signUpView = document.querySelector('#signupView');

    signUpView.style.display = "none";

    var containerHeight = String(container.offsetHeight + "px");

    document.querySelector('.toggle').addEventListener('click', event => {
      forms.style.transform = 'translateX(0)';
      loginSelectBar.style.transform = 'translateX(0)';
      container.style.height = containerHeight;
      loginTab.classList.add('active');
      signUpTab.classList.remove('active');
    });

    document.querySelector('.toggle2').addEventListener('click', event => {
      forms.style.transform = 'translateX(-100%)';
      loginSelectBar.style.transform = 'translateX(100%)';
      loginTab.classList.remove('active');
      signUpTab.classList.add('active');
      signUpView.style.display = "block";

      setTimeout(() => {
        var containerHeight2 = container.offsetHeight + "px";
        console.log(containerHeight2);
        container.style.height = containerHeight2;
        console.log("Kuirwa" + containerHeight2);
      }, 0);
    });
  </script>
</body>

</html>