<?php
    require_once "connection.php";
    if($conn->connect_errno!=0)
	{
		echo "Error: ".$conn->connect_errno;
	}
    else{
        $email = $_GET['email'];
        $result = $conn->query("SELECT avatar_src FROM `profile` INNER JOIN users USING(user_id) WHERE email='$email';");
        if($result->num_rows > 0){
            $row = mysqli_fetch_assoc($result);
            echo $row['avatar_src'];
        }
        else{
            echo "imgs/UI/login_user.png";
        }
    }
    $conn->close();
?>