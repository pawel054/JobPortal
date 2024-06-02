<?php
session_start();
require_once "connection.php";
$profile_id = $_SESSION['profile_id'];

if ($conn->connect_errno != 0) {
    echo "Error: " . $conn->connect_errno;
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["experienceForm"])) {
            if ($_POST["isEdit"] == "false") {
                /*
                if ($conn->query("INSERT INTO offer VALUES (NULL, '$company_id', '$position_name', '$position_level', '$contract_type', '$job_type','$salary','$working_time', '$working_hours', '$working_days', '$expiration_date', '$gmaps', '$adress', '$category_id')")) {
                    $newOffer_id = mysqli_insert_id($conn);

                    if (isset($_POST["duties"])) {
                        $duties = $_POST["duties"];
                        foreach ($duties as $duty) {
                            $conn->query("INSERT INTO offer_duties VALUES (NULL, '$duty', '$newOffer_id')");
                        }
                    }

                    if (isset($_POST["requirements"])) {
                        $requirements = $_POST["requirements"];
                        foreach ($requirements as $requirement) {
                            $conn->query("INSERT INTO offer_requirements VALUES (NULL, '$requirement', '$newOffer_id')");
                        }
                    }

                    if (isset($_POST["benefits"])) {
                        $benefits = $_POST["benefits"];
                        foreach ($benefits as $benefit) {
                            $conn->query("INSERT INTO offer_benefits VALUES (NULL, '$benefit', '$newOffer_id')");
                        }
                    }
                }
                */

                if (isset($_POST["experience"])) {
                    $experience = $_POST["experience"];
                    $experienceCount = count(($experience));

                    if ($experienceCount % 5 == 0) {
                        for($i = 0; $i < $experienceCount; $i += 5){
                            $data = array_slice($experience, $i, 5);
                            $conn->query("INSERT INTO profile_experience VALUES (NULL, '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$profile_id')");
                        }
                    }
                }

            } else {
                $offer_id_edit = $_POST["offerForm"];
                $conn->query("UPDATE offer SET position_name = '$position_name', position_level = '$position_level', contract_type = '$contract_type', job_type='$job_type', salary = '$salary', working_time = '$working_time', working_hours = '$working_hours', working_days = '$working_days', expiration_date = '$expiration_date', gmaps_url = '$gmaps', adress = '$adress', company_id = '$company_id', category_id = '$category_id' WHERE offer_id = '$offer_id_edit';");
            }
            header('Location: ../user/profile.php');
        }

    }
}
mysqli_close($conn);
