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
                if (isset($_POST["experience"])) {
                    $experience = $_POST["experience"];
                    $experience_id = $_POST["experienceForm"];
                    echo $experience[0];
                    $conn->query("UPDATE profile_experience SET position = '$experience[0]', company_name = '$experience[1]', profile_experience.location = '$experience[2]', peroid_from='$experience[3]', peroid_to = '$experience[4]' WHERE experience_id = '$experience_id';");
                }
            }
        }
        if (isset($_POST["educationForm"])) {
            if ($_POST["isEdit"] == "false") {
                if (isset($_POST["education"])) {
                    $education = $_POST["education"];
                    $educationCount = count(($education));

                    if ($educationCount % 6 == 0) {
                        for($i = 0; $i < $educationCount; $i += 6){
                            $data = array_slice($education, $i, 6);
                            $conn->query("INSERT INTO profile_education VALUES (NULL, '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$profile_id')");
                        }
                    }
                }
            } else{
                if (isset($_POST["education"])) {
                    $education = $_POST["education"];
                    $education_id = $_POST["educationForm"];

                    $conn->query("UPDATE profile_education SET school_name = '$education[0]', education_level = '$education[1]', major='$education[2]', `location` = '$education[3]', peroid_from='$education[4]', peroid_to = '$education[5]' WHERE education_id = '$education_id';");
                }
            }
        }

        if (isset($_POST["certificatesForm"])) {
            if (isset($_POST["certificates"])) {
                $certificates = $_POST["certificates"];
                $certificatesCount = count(($certificates));
                $cert_id = $_POST["certificatesForm"];

                if ($_POST["isEdit"] == "false") {
                    if ($certificatesCount % 4 == 0) {
                        for ($i = 0; $i < $certificatesCount; $i += 4) {
                            $data = array_slice($certificates, $i, 4);
                            $conn->query("INSERT INTO profile_certificates VALUES (NULL, '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$profile_id')");
                        }
                    }
                } else {
                        $conn->query("UPDATE profile_certificates SET `name` = '$certificates[0]', organizer = '$certificates[1]', peroid_from='$certificates[2]', peroid_to = '$certificates[3]' WHERE certificate_id = '$cert_id';");
                }
            }
        }

        if (isset($_POST["skillsForm"])) {
            if (isset($_POST["skill"])) {
                $skills = $_POST["skill"];
                foreach ($skills as $skill) {
                    $conn->query("INSERT INTO profile_skills VALUES (NULL, '$skill', '$profile_id')");
                }
            }
        }

        if(isset($_POST["langForm"])){
            if (isset($_POST["lang"])) {
                $languages = $_POST["lang"];
                $languagesCount = count(($languages));

                if ($languagesCount % 2 == 0) {
                    for ($i = 0; $i < $languagesCount; $i += 2) {
                        $data = array_slice($languages, $i, 2);
                        $conn->query("INSERT INTO profile_languages VALUES (NULL, '$data[0]', '$data[1]', '$profile_id')");
                    }
                }
            }
        }

    }
    header('Location: ../user/profile.php');
}
mysqli_close($conn);
