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


    .hidden {
      display: none;
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
      background: #f0f0f0;
      border: none;
      outline: none;
    }

    .tab.active {
      background: white;
    }

    .highlight {
      position: absolute;
      bottom: 0;
      width: 50%;
      height: 4px;
      background: purple;
      transition: transform 0.3s ease;
    }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
  <div class="container d-flex flex-column">
    <div class="d-flex justify-content-center align-self-center z-3" style="width: 130px; margin-bottom:-65px">
      <img class="img-fluid" src="../imgs/UI/login_user.png" id="userImage" style="border-radius: 50%; transition: opacity 0.5s ease-in-out; border:3px solid gray;">
    </div>
    <div class="test">
      <div class="tabs mt-5">
        <button id="loginTab" class="tab active toggle">Logowanie</button>
        <button id="signUpTab" class="tab toggle2">Rejestracja</button>
        <div class="highlight"></div>
      </div>
      <div class="forms">
        <div class="w-50 p-2 login">
          <div class="form-floating mt-4">
            <input type="text" class="form-control rounded-4" id="floatingEmail" name="email" placeholder="" value="<?php if (isset($_SESSION['valueEmail'])) echo $_SESSION['valueEmail'];
                                                                                                                    unset($_SESSION['valueEmail']); ?>">
            <label for="floatingEmail">Adres e-mail</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control mt-3 rounded-4" id="floatingPass" name="password" placeholder="">
            <label for="floatingPass">Hasło</label>
          </div>
          <div class="sendButton d-flex justify-content-center">
            <button type="submit" class="btn violetButton rounded-4 fs-5">Zaloguj</button>
          </div>
        </div>
        <div class="w-50 p-2 signup">

        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script>
    document.querySelector('.toggle').addEventListener('click', event => {
      const forms = document.querySelector('.forms');
      const container = document.querySelector('.test');
      const highlight = document.querySelector('.highlight');

      forms.style.transform = 'translateX(0)';
      highlight.style.transform = 'translateX(0)';
      container.style.height = '454px';
    });
    document.querySelector('.toggle2').addEventListener('click', event => {
      const forms = document.querySelector('.forms');
      const container = document.querySelector('.test');
      const highlight = document.querySelector('.highlight');

      forms.style.transform = 'translateX(-100%)';
      highlight.style.transform = 'translateX(100%)';
      container.style.height = '150px';

    });
  </script>
</body>

</html>