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
        $pass = $_POST['password'];
        $_SESSION['valueEmail'] = $email;

        $email = htmlentities($email, ENT_QUOTES, "UTF-8");

        if ($result = @$conn->query(
            sprintf("SELECT * FROM users WHERE email='%s'",
            mysqli_real_escape_string($conn,$email))))
            {
                if ($result->num_rows > 0)
                {
                    $row = $result->fetch_assoc();
                    if(password_verify($pass,$row['password'])){
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['isadmin'] = $row['isadmin'];
                    $user_id = $row['user_id'];

                    unset($_SESSION['error']);
                    $result->free_result();
                    if($_SESSION['isadmin']==1)
                        //header('Location: ../admin/index.php');
                        header('Location: ../index.php');
                    else
                        header('Location: ../index.php');
                    }
                    else 
                    {
                        $_SESSION['error'] = 0;
                        $_SESSION['error2'] = 0;
                        header('Location: ../user/login.php');
                    }

                    if($profileResult = $conn->query("SELECT profile_id FROM profile WHERE user_id = '$user_id'")){
                        $row2 = $profileResult->fetch_assoc();
                        if ($profileResult->num_rows > 0){
                            $_SESSION['profile_id'] = $row2['profile_id'];
                        }
                        else{
                            $_SESSION['profile_id'] = -1;
                        }
                    }
                }

                else
                {
                    $_SESSION['error'] = 0;
                    $_SESSION['error2'] = 0;
                    header('Location: ../user/login.php');
                }
            }
        $conn->close();
    }

?>