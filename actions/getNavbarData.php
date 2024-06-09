<?php
$userID = $_SESSION['user_id'];
$profile_id = $_SESSION['profile_id'];

$favsResult = $conn->query("SELECT * FROM `user_favourites` INNER JOIN offer USING(offer_id) INNER JOIN company USING(company_id) WHERE user_id = '$userID';");
$applicationsResult = $conn->query("SELECT * FROM `user_applications` INNER JOIN offer USING(offer_id) INNER JOIN company USING(company_id) WHERE profile_id = '$profile_id';");

if (isset($_SESSION["profile_id"])) {
    $profile_id = $_SESSION["profile_id"];
    if ($row = $conn->query("SELECT avatar_src FROM `profile` WHERE profile_id = '$profile_id'")->fetch_assoc()) {
        $userAvatar = $row["avatar_src"];
    } else {
        $userAvatar = "imgs/UI/login_user.png";
    }
} else {
    $userAvatar = "imgs/UI/login_user.png";
}
?>