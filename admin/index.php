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
        <div class="leftCol">
                <h3 class="text-white mx-3 mt-4 mb-3 fw-bold">Admin</h3>
                <a href="#" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks adminMenuLinkSelected"><i class="bi bi-speedometer2 fs-4 mx-2"></i><p class="m-0 mx-1 fw-medium">Panel główny</p></a>
                <a href="offers.php" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks"><i class="bi bi-file-earmark-text-fill fs-4 mx-2"></i><p class="m-0 mx-1 fw-medium">Ogłoszenia</p></a>
                <a href="companies.php" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks"><i class="bi bi-buildings-fill fs-4 mx-2"></i><p class="m-0 mx-1 fw-medium">Firmy</p></a>
                <a href="categories.php" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks"><i class="bi bi-grid-fill fs-4 mx-2"></i><p class="m-0 mx-1 fw-medium">Kategorie</p></a>
                <a href="#" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks"><i class="bi bi-people-fill fs-4 mx-2"></i><p class="m-0 mx-1 fw-medium">Aplikacje</p></a>
            </div>
            <div class="bottom-menu">
                <a href="#"><i class="bi bi-speedometer2 menuIconClicked"></i></a>
                <a href="#"><i class="bi bi-file-earmark-text-fill menuIcon"></i></a>
                <a href="#"><i class="bi bi-buildings-fill menuIcon"></i></a>
                <a href="#"><i class="bi bi-people-fill menuIcon"></i></a>
                <img src="../imgs/UI/login_user.png" class="menuAvatar">
            </div>
            <div class="rightCol">
                <div class="row" style="height: 100%;">
                <div class="col-xl-12 d-flex align-items-center bg-light" style="height: 8%;">
                        <h3 class="m-0 me-auto fw-bold d-flex align-items-center">Witaj, admin!</h3>
                        <a href="#" class="viewButton"><i class="bi bi-eye-fill"></i>Widok strony</a>
                        <img src="../imgs/UI/login_user.png" class="menuAvatar mx-4">
                    </div>
                    <div class="col-xl-12 pe-5 px-5 statsCol" style="height: 20%;">
                    <h3 class="m-0 mb-3 me-auto fw-bold d-flex align-items-center">Panel główny</h3>
                        <div>
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