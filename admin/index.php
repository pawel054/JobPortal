<?php
    session_start();
    require_once '../actions/connection.php';
    $companyCount = $conn->query("SELECT COUNT(company_id) FROM `company`")->fetch_row();
    $offerCount = $conn->query("SELECT COUNT(offer_id) FROM `offer`;")->fetch_row();
    $userCount = $conn->query("SELECT COUNT(user_id) FROM `users`;")->fetch_row();
    $applicationCount = $conn->query("SELECT COUNT(application_id) FROM `user_applications`")->fetch_row();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style_admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-1 leftCol">
                <div class="leftCol2" style="height: 100%;">
                    <div class="row" style="height: 100%;">
                        <div class="col-xl-12" style="height: 25%;">
                           21 
                        </div>
                        <div class="col-xl-12 d-flex flex-column justify-content-center align-items-center" style="height:50%;">
                            <a href="#"><i class="bi bi-speedometer2 menuIconClicked"></i></a>
                            <a href="offers.html"><i class="bi bi-file-earmark-text-fill menuIcon"></i></a>
                            <a href="#"><i class="bi bi-buildings-fill menuIcon"></i></a>
                            <a href="#"><i class="bi bi-people-fill menuIcon"></i></a>
                        </div>
                        <div class="col-xl-12 d-flex justify-content-center align-items-end" style="height: 25%;">
                            <img src="../imgs/UI/login_user.png" class="menuAvatar">
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-menu">
                <a href="#"><i class="bi bi-speedometer2 menuIconClicked"></i></a>
                <a href="#"><i class="bi bi-file-earmark-text-fill menuIcon"></i></a>
                <a href="#"><i class="bi bi-buildings-fill menuIcon"></i></a>
                <a href="#"><i class="bi bi-people-fill menuIcon"></i></a>
                <img src="../imgs/UI/login_user.png" class="menuAvatar">
            </div>
            <div class="col-xl-11 rightCol">
                <div class="row" style="height: 100%; padding: 25px;">
                    <div class="col-xl-12 d-flex align-items-center" style="height: 5%;">
                        <h5 class="me-auto"><span class="violetMark">Witaj,</span> <?php echo $_SESSION['email']; ?>!</h5>
                        <a href="#" class="viewButton"><i class="bi bi-eye-fill"></i>Widok strony</a>
                    </div>                    
                    <div class="col-xl-12 d-flex align-items-center mb-3" style="height: 10%;">
                        <div class="categoryTitle d-flex align-items-center">
                            <div>
                                <i class="bi bi-speedometer2"></i>
                            </div>
                            <h4>Panel główny</h4>
                        </div>
                    </div>
                    <div class="col-xl-12 statsCol" style="height: 20%;">
                        <div class="statsboxPlace">
                            <div class="row d-flex align-items-center" style="height: 100%;">
                                <div class="col-xl-3 d-flex justify-content-center align-items-center" style="height: 140px;">
                                    <div class="statsBox d-flex align-items-center">
                                        <div class="ms-4">
                                            <h5 class="mb-3">Ogłoszenia</h5>
                                            <div class="statsboxIcon d-flex align-items-center">
                                                <div>
                                                    <i class="bi bi-speedometer2"></i>
                                                </div>
                                                <h1 class="ms-2 violetText"><?php echo $offerCount[0]; ?></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 d-flex justify-content-center align-items-center" style="height: 140px;">
                                    <div class="statsBox d-flex align-items-center">
                                        <div class="ms-4">
                                            <h5 class="mb-3">Firmy</h5>
                                            <div class="statsboxIcon d-flex align-items-center">
                                                <div>
                                                    <i class="bi bi-speedometer2"></i>
                                                </div>
                                                <h1 class="ms-2 violetText"><?php echo $companyCount[0]; ?></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 d-flex justify-content-center align-items-center" style="height: 140px;">
                                    <div class="statsBox d-flex align-items-center">
                                        <div class="ms-4">
                                            <h5 class="mb-3">Użytkownicy</h5>
                                            <div class="statsboxIcon d-flex align-items-center">
                                                <div>
                                                    <i class="bi bi-speedometer2"></i>
                                                </div>
                                                <h1 class="ms-2 violetText"><?php echo $userCount[0]; ?></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 d-flex justify-content-center align-items-center" style="height: 140px;">
                                    <div class="statsBox d-flex align-items-center">
                                        <div class="ms-4">
                                            <h5 class="mb-3">Aplikacje</h5>
                                            <div class="statsboxIcon d-flex align-items-center">
                                                <div>
                                                    <i class="bi bi-speedometer2"></i>
                                                </div>
                                                <h1 class="ms-2 violetText"><?php echo $applicationCount[0]; ?></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 pb-5" style="height: 65%;">
                        <div class="statsboxPlace mt-4">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>