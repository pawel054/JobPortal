<?php
    session_start();
    require_once "connection.php";
    if($conn->connect_errno!=0)
	{
		echo "Error: ".$conn->connect_errno;
	}
    else{
        $offerID = $_GET['oid'];
        $userID = $_SESSION['user_id'];
        $action = $_GET['action'];

        if($action == "add"){
            $conn->query("INSERT INTO `user_favourites` VALUES (NULL, '$offerID', '$userID');");
            header("Location: ../offers/offer.php?id=".$offerID);
        }
        if($action == "remove"){
            $conn->query("DELETE FROM `user_favourites` WHERE user_id='$userID' AND offer_id='$offerID';");
            header("Location: ../offers/offer.php?id=".$offerID);
        }
    }
?>