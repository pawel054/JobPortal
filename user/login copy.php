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
      transition: background 0.3s ease;
    }

    .tab.active {
      background: white;
    }

    .highlight {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50%;
      height: 4px;
      background: #007BFF;
      transition: transform 0.3s ease;
    }

    .content {
      padding: 20px;
    }

    .content-panel {
      display: none;
    }

    .content-panel.active {
      display: block;
    }



    .LoginBoxx {
      background-color: #f0f0f0;
      padding: 30px;
      border-radius: 25px;
      width: 500px;
      transition: height 0.5s ease;
    }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <div class="LoginBoxx d-flex flex-column">
      <div class="d-flex justify-content-center align-self-center" style="width: 130px; margin-top:-15%;">
        <img class="img-fluid" src="../imgs/UI/login_user.png" id="userImage" style="border-radius: 50%; transition: opacity 0.5s ease-in-out; border:3px solid gray;">
      </div>
      <div>
        <div class="tabs">
          <button id="loginTab" class="tab active toggle">Login</button>
          <button id="signUpTab" class="tab toggle">Sign Up</button>
          <div class="highlight"></div>
        </div>
        <div class="content d-flex justify-content-center">
          <div id="loginContent" class="content-panel active w-100">
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
              <button type="submit" class="btn violetButton d-flex align-items-center justify-content-center rounded-4 fs-5">Zaloguj</button>
            </div>
          </div>
          <div id="signUpContent" class="content-panel">Sign Content</div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const loginTab = document.getElementById('loginTab');
      const signUpTab = document.getElementById('signUpTab');
      const loginContent = document.getElementById('loginContent');
      const signUpContent = document.getElementById('signUpContent');
      const highlight = document.querySelector('.highlight');
      const loginBoxx = document.querySelector('.LoginBoxx');

      loginTab.addEventListener('click', function() {
        loginTab.classList.add('active');
        signUpTab.classList.remove('active');
        loginContent.classList.add('active');
        signUpContent.classList.remove('active');
        highlight.style.transform = 'translateX(0)';
        loginBoxx.style.height = '454px'; // Dodane height
      });

      signUpTab.addEventListener('click', function() {
        signUpTab.classList.add('active');
        loginTab.classList.remove('active');
        signUpContent.classList.add('active');
        loginContent.classList.remove('active');
        highlight.style.transform = 'translateX(100%)';
        loginBoxx.style.height = '200px'; // Dodane height
      });
    });
  </script>
</body>

</html>