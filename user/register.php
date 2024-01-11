<?php
    session_start();
    if ((isset($_SESSION['logged_in'])) && ($_SESSION['logged_in']==true))
    {
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
  <div class="container">
    <div class="boxLogin">
      <h1 class="boxTitle">Utwórz konto</h1>
      <div class="d-flex justify-content-center">
        <img class="boxAvatar" src="../imgs/UI/login_user.png">
      </div>
      <div class="boxForm d-flex justify-content-center">
      <form method="post" action="../actions/actionRegister.php">
        <div class="form-floating">
          <input type="text" class="form-control <?php if(isset($_SESSION['error_email'])){?>is-invalid <?php } ?>" id="floatingEmail" name="email" placeholder="" value="<?php if(isset($_SESSION['p_email'])) echo $_SESSION['p_email']; unset($_SESSION['p_email']); ?>">
          <label for="floatingEmail" class="floatingLabelForm">Adres e-mail</label>
          <div class="invalid-feedback mx-4 mt-2 shake-text" style="color: #c02f2f;">
            <?php if(isset($_SESSION['error_email'])){echo $_SESSION['error_email']; unset($_SESSION['error_email']);} ?>
          </div>
        </div>
        <div class="form-floating">
        <input type="password" class="form-control mt-3 <?php if(isset($_SESSION['error_password'])){?>is-invalid <?php } ?>" id="floatingPass" name="password" placeholder="">
        <label for="floatingPass" class="floatingLabelForm">Hasło</label>
        <div class="invalid-feedback mx-4 mt-2 shake-text" style="color: #c02f2f;">
            <?php if(isset($_SESSION['error_password'])){echo $_SESSION['error_password']; unset($_SESSION['error_password']);} ?>
          </div>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control mt-3  <?php if(isset($_SESSION['error_password_check'])){?>is-invalid <?php } ?>" id="floatingPass" name="password-check" placeholder="">
          <label for="floatingPass" class="floatingLabelForm">Powtórz hasło</label>
          <div class="invalid-feedback mx-4 mt-2 shake-text" style="color: #c02f2f;">
            <?php if(isset($_SESSION['error_password_check'])){echo $_SESSION['error_password_check']; unset($_SESSION['error_password_check']);} ?>
          </div>
          </div>
          <div class="sendButton d-flex justify-content-center">
            <button type="submit" class="btn violetButton d-flex align-items-center justify-content-center">Utwórz konto</button>
          </div>
      </form>
    </div>
    <p class="linkRegistration d-flex justify-content-center">Masz już konto?&nbsp; <a class="violetMark" href="login.php">Zaloguj się</a></p>
    </div>
  </div>  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="js/script.js"></script>
</body>
</html>