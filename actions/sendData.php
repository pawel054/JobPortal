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

                if($conn->query("INSERT INTO offer VALUES (NULL, '$company_id', '$position_name', '$position_level', '$contract_type', '$job_type','$salary','$working_time', '$working_hours', '$working_days', '$expiration_date', '$gmaps', '$adress', '$category_id')")){
                    $newOffer_id = mysqli_insert_id($conn);

                    if(isset($_POST["duties"])){
                        $duties = $_POST["duties"];
                        foreach($duties as $duty){
                            $conn->query("INSERT INTO offer_duties VALUES (NULL, '$duty', '$newOffer_id')");
                        }
                    }

                    if(isset($_POST["requirements"])){
                        $requirements = $_POST["requirements"];
                        foreach($requirements as $requirement){
                            $conn->query("INSERT INTO offer_requirements VALUES (NULL, '$requirement', '$newOffer_id')");
                        }
                    }

                    if(isset($_POST["benefits"])){
                        $benefits = $_POST["benefits"];
                        foreach($benefits as $benefit){
                            $conn->query("INSERT INTO offer_benefits VALUES (NULL, '$benefit', '$newOffer_id')");
                        }
                    }

                    header('Location: ../admin/offers.php');
                }
        
            }
        }
    }
    mysqli_close($conn);
?>