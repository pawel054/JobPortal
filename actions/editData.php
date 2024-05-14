<?php
require_once 'connection.php';

if(isset($_POST['EditCompanyId'])) {
    $companyId = $_POST['EditCompanyId'];

    $query = "SELECT * FROM company WHERE company_id = '$companyId'";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Nie znaleziono firmy'. $companyId]);
    }
}

if(isset($_POST['EditOfferId'])) {
    $offerId = $_POST['EditOfferId'];

    $combinedData = [];

    $queries = [
        "offer" => "SELECT * FROM offer WHERE offer_id = '$offerId'",
        "duties" => "SELECT * FROM offer_duties WHERE offer_id = '$offerId'",
        "requirements" => "SELECT * FROM offer_requirements WHERE offer_id = '$offerId'",
        "benefits" => "SELECT * FROM offer_benefits WHERE offer_id = '$offerId'"
    ];

    foreach ($queries as $key => $query) {
        $result = mysqli_query($conn, $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        $combinedData[$key . '_data'] = $data;
    }

    echo json_encode($combinedData);
}

if(isset($_POST["EditCategoryId"])){
    $categoryId = $_POST['EditCategoryId'];
    $result = mysqli_query($conn, "SELECT * FROM category WHERE category_id = '$categoryId';");

    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    }
}

?>
