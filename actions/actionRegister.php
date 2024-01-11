<?php
    session_start();
    require_once "connection.php";
    if($conn->connect_errno!=0)
	{
		echo "Error: ".$conn->connect_errno;
	}
    else
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordCheck = $_POST['password-check'];

        $status_ok = true;
        $emailCheck = filter_var($email, FILTER_SANITIZE_EMAIL);

        if((filter_var($emailCheck, FILTER_VALIDATE_EMAIL)==false) || ($emailCheck!=$email)){
            $status_ok = false;
            $_SESSION['error_email'] = "Adres e-mail ma niepoprawny format.";
        }

        if((strlen($password)<5) || (strlen($password)>40)){
            $status_ok = false;
            $_SESSION['error_password'] = "Hasło może zawierać od 5 do 40 znaków";
        }

        if($password!=$passwordCheck){
            $status_ok = false;
            $_SESSION['error_password_check'] = "Podane hasła różnią się";
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $_SESSION['p_email'] = $email;

        $result =  $conn->query("SELECT user_id FROM users WHERE email='$email'");
        
        $emailCount = $result->num_rows;
        if($emailCount>0){
            $status_ok = false;
            $_SESSION['error_email'] = "Konto o podanym adresie e-mail już istnieje.";
        }

        if($status_ok == true){
            if( $conn->query("INSERT INTO users VALUES (NULL, '$email', '$passwordHash', 0)")){
                header('Location: zarejestrowano.php');
                unset($_SESSION['p_email']);
                exit();
            }
        }
        else{
            header('Location: ../user/register.php');
        }
            $conn->close();
    }
?>