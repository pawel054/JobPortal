<?php
    session_start();
    require_once "connection.php";
    if($conn->connect_errno!=0)
	{
		echo "Error: ".$conn->connect_errno;
	}
    else{
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["offerForm"])) {
                $category_id = $_POST["category_id"];
                $company_id = $_POST["company_id"];
                $position_name = $_POST["stanowisko"];
                $position_level = $_POST["poziom_stanowisko"];
                $contract_type = $_POST["umowa"];
                $working_time = $_POST["etat"];
                $job_type = $_POST["tryb_praca"];
                $working_days = $_POST["dni_praca"];
                $working_hours = $_POST["godziny_praca"];
                $adress = $_POST["adres"];
                $expiration_date = $_POST["termin"];
                $salary = $_POST["wynagrodzenie"];
                $gmaps = $_POST["gmaps"];

            if ($_POST["isEdit"] == "false"){
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
            }
            else{
                $offer_id_edit = $_POST["offerForm"];
                $conn->query("UPDATE offer SET position_name = '$position_name', position_level = '$position_level', contract_type = '$contract_type', job_type='$job_type', salary = '$salary', working_time = '$working_time', working_hours = '$working_hours', working_days = '$working_days', expiration_date = '$expiration_date', gmaps_url = '$gmaps', adress = '$adress', company_id = '$company_id', category_id = '$category_id' WHERE offer_id = '$offer_id_edit';");
            }
            header('Location: ../admin/offers.php');
        
            }

            if (isset($_POST["companyForm"])) {
                $company_name = $_POST["company_name"];
                $company_description = $_POST["company_description"];

                if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['file']['tmp_name'];
                    $fileName = $_FILES['file']['name'];

                    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
                    $uploadedFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    if(in_array($uploadedFileType, $allowedExtensions)) {
                        $newFileName = "companyLogo-" . bin2hex(random_bytes(16)) . "." . $uploadedFileType;
                        $targetFilePath  = '../imgs/company/' . $newFileName;
                        if(move_uploaded_file($fileTmpPath, $targetFilePath)) {
                            $uploadedFilePath = 'imgs/company/' . $newFileName;
                        }
                        else{
                            $uploadedFilePath = "nie przesieniono";
                        }
                    }
                    else{
                        $uploadedFilePath = "nie w tablicyt";
                    }
                }
                else{
                    $uploadedFilePath = "jakis error idk"; 
                }
                if($conn->query("INSERT INTO company VALUES (NULL, '$company_name', '$uploadedFilePath', '$company_description')")){
                    header('Location: ../admin/companies.php');
                }
            }

            if (isset($_POST["companyFormEdit"])) {
                $company_name = $_POST["company_name"];
                $company_id_edit = $_POST["companyFormEdit"];
                $company_description = $_POST["company_description"];

                if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['file']['tmp_name'];
                    $fileName = $_FILES['file']['name'];

                    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
                    $uploadedFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    if(in_array($uploadedFileType, $allowedExtensions)) {
                        $newFileName = "companyLogo-" . bin2hex(random_bytes(16)) . "." . $uploadedFileType;
                        $targetFilePath  = '../imgs/company/' . $newFileName;
                        if(move_uploaded_file($fileTmpPath, $targetFilePath)) {
                            $uploadedFilePath = 'imgs/company/' . $newFileName;
                        }
                        else{
                            $uploadedFilePath = "nie przesieniono";
                        }
                    }
                    else{
                        $uploadedFilePath = "nie w tablicyt";
                    }

                    $result = $conn->query("SELECT logo_src FROM company WHERE company_id='$company_id_edit';");
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $imagePath = "../" . $row["logo_src"];
                    }

                    if($conn->query("UPDATE company SET company_name = '$company_name', logo_src = '$uploadedFilePath', information = '$company_description' WHERE company_id = '$company_id_edit';")){
                        if(file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                        header('Location: ../admin/companies.php');
                    }
                }
                else{
                    if($conn->query("UPDATE company SET company_name = '$company_name', information = '$company_description' WHERE company_id = '$company_id_edit';")){
                        header('Location: ../admin/companies.php');
                    }
                }
            }

            if(isset($_POST["categoryForm"])){
                if($_POST["isEdit"] == "false"){
                    $category_name = $_POST["category_name"];
                    $conn->query("INSERT INTO category VALUES (NULL, '$category_name')");
                }
                else{
                    $category_id_edit = $_POST["categoryForm"];
                    $category_name = $_POST["category_name"];
                    $conn->query("UPDATE category SET category_name = '$category_name' WHERE category_id = '$category_id_edit';");
                }
                header('Location: ../admin/categories.php');
            }

            if(isset($_POST["applicationForm"])){
                if($_POST["isEdit"] == "false"){
                    $offer_id = $_POST["offer_id"];
                    $profile_id = $_POST["profile_id"];
                    $conn->query("INSERT INTO user_applications VALUES (NULL, '$offer_id', '$profile_id', 'Oczekuje')");
                    header('Location: ../offers/offer.php?id=' . $offer_id);
                }
                else{
                    $application_id = $_POST["application_id"];
                    $status = $_POST["status"];
                    $conn->query("UPDATE user_applications SET user_applications.status = '$status' WHERE application_id = '$application_id';");
                    header('Location: ../admin/applications.php');
                }
            }

            if(isset($_POST["DeleteFavoriteOffer"])){
                $deleteId = $_POST["DeleteFavoriteOffer"];
                $headerAdress = $_POST["return_url"];
                echo $headerAdress;
                $conn->query("DELETE FROM user_favourites WHERE favourite_id = '$deleteId'");
                header('Location: '.$headerAdress);
            }

        if (isset($_POST["DeleteApplicationOffer"])) {
            $deleteId = $_POST["DeleteApplicationOffer"];
            $headerAdress = $_POST["return_url"];
            echo $headerAdress;
            $conn->query("DELETE FROM user_applications WHERE application_id = '$deleteId'");
            header('Location: ' . $headerAdress);
        }
        }

        
    }
    mysqli_close($conn);
?>