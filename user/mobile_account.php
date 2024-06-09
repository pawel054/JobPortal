<?php
session_start();
require_once '../actions/connection.php';
$offersResult = $conn->query("SELECT * FROM `offer` INNER JOIN company USING(company_id) INNER JOIN category USING(category_id);");
$categoriesResult = $conn->query("SELECT * FROM `category`;");
$companiesResult = $conn->query("SELECT * FROM `company`;");

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

$filtersResult = $conn->query("SELECT * FROM `offer_filters`;");
if ($filtersResult->num_rows > 0) {
    while ($row = $filtersResult->fetch_assoc()) {
        if ($row['filters_id'] == 'contract_type') {
            $content = $row['items'];
            $contractTypes = explode(";", $content);
        }
        if ($row['filters_id'] == 'job_type') {
            $content2 = $row['items'];
            $jobTypes = explode(";", $content2);
        }
        if ($row['filters_id'] == 'position_level') {
            $content3 = $row['items'];
            $positionTypes = explode(";", $content3);
        }
        if ($row['filters_id'] == 'working_time') {
            $content4 = $row['items'];
            $workingTypes = explode(";", $content4);
        }
    }
}

function DisplayShortText($text, $maxSymbols)
{
    if (strlen($text) > $maxSymbols)
        echo substr($text, 0, $maxSymbols) . '...';
    else
        echo $text;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Strona głowna</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="../imgs/UI/logo.png" width="120px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Strona główna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="search.php">Oferty pracy</a>
                    </li>
                </ul>
                <div class="dropdown ms-auto">
                    <button type="button" class="btn violetButtonsDropdown rounded-4" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        <i class="bi bi-person text-white me-2"></i>Konto
                    </button>
                    <div class="dropdown-menu p-4 dropdownLogowanie rounded-3">
                        <?php if (isset($_SESSION['logged_in'])) { ?>
                            <div class="mb-4">
                                <p class="m-0 text-secondary mb-1 mx-2" style="font-size: 15px;">Moje konto</p>
                                <div style="background-color: #efefef; padding:5px;" class="rounded-4">
                                    <div class="d-flex align-items-center mt-2 mb-2">
                                        <img src="<?php echo $userAvatar; ?>" class="userIconMenu mx-2">
                                        <a href="user/profile.php" class="text-decoration-none">
                                            <p class="kontoDescription m-auto ms-2 fw-semibold" title="<?php echo $_SESSION['email']; ?>"><?php DisplayShortText($_SESSION['email'], 25) ?></p>
                                            <p class="kontoDescription m-auto ms-2 text-secondary" style="font-size: 14px;">Zobacz mój profil ></p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <p class="m-0 text-secondary mx-2" style="font-size: 15px;">Opcje</p>
                            <div style=" padding:10px;" class="rounded-4">
                                <?php if ($_SESSION['isadmin'] == 1) { ?>
                                    <div class="dropdownElement mb-2 p-1 rounded-3">
                                        <a href="admin/index.php" class="text-decoration-none">
                                            <div class="d-flex align-items-center gap-3 fw-semibold"><i class="bi bi-tools fs-4 ms-2 panelIcons"></i>Panel administratora</div>
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="dropdownElement mb-2 p-1 rounded-3">
                                    <a href="user/login.php" class="text-decoration-none">
                                        <div class="d-flex align-items-center gap-3 fw-semibold"><i class="bi bi-bookmarks-fill fs-4 ms-2 panelIcons"></i>Zapisane oferty</div>
                                    </a>
                                </div>
                                <div class="dropdownElement mb-2 p-1 rounded-3">
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#settingsModal">
                                        <div class="d-flex align-items-center gap-3 fw-semibold"><i class="bi bi-gear-fill fs-4 ms-2 panelIcons"></i>Ustawienia</div>
                                    </a>
                                </div>
                                <div class="dropdownElement mb-2 p-1 rounded-3">
                                    <a href="actions/actionLogout.php" class="text-decoration-none">
                                        <div class="d-flex align-items-center gap-3 fw-semibold"><i class="bi bi-box-arrow-right fs-4 ms-2 panelIcons"></i>Wyloguj</div>
                                    </a>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="mb-4">
                                <h5 class="mb-2 fw-semibold mt-3">Witaj w JobPortal!</h5>
                                <p class="fw-normal fs-6">Logując się na konto zyskujesz dostęp do profilu, zapisywania ofert i wielu innych funkcji!</p>
                            </div>
                            <div class="mb-5 d-flex justify-content-center align-items-center">
                                <a href="user/login.php"><button class="btn violetButtons">Zaloguj się</button></a>
                            </div>
                            <div class="mb-1 d-flex justify-content-center align-items-center">
                                <p class="coloredFont">Nie masz jeszcze konta?</p>
                            </div>
                            <div class="mb-1 d-flex justify-content-center align-items-center">
                                <a href="#"><button class="btn violetButtonsFrame">Utwórz konto</button></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="bottom-menu z-1" style="<?php if ($_SESSION['isadmin'] == 1) echo 'gap: 12%;'; else echo 'gap: 19%;'; ?>">
        <a href="../index.php" class="text-center text-decoration-none menuIconDiv">
            <i class="bi bi-house-fill menuIcon fs-2"></i>
            <p class="m-0 menuIconText">Home</p>
        </a>
        <a href="../search.php" class="text-center text-decoration-none menuIconDiv">
            <i class="bi bi-search menuIcon fs-2"></i>
            <p class="m-0 menuIconText">Szukaj</p>
        </a>
        <a data-bs-toggle="#" class="text-center text-decoration-none menuIconDiv menuIconClicked">
            <i class="bi bi-person-fill menuIcon fs-2"></i>
            <p class="m-0 menuIconText">Konto</p>
        </a>
        <?php if ($_SESSION['isadmin'] == 1) { ?>
        <a href="../admin/index.php" class="text-center text-decoration-none menuIconDiv">
            <i class="bi bi-tools menuIcon fs-2"></i>
            <p class="m-0 menuIconText">Admin</p>
        </a>
        <?php } ?>
    </div>

    <div class="container-fluid d-flex p-4">
        <div class="w-100">
            <h1 class="fw-bold mt-2">Moje konto</h1>
            <?php if (isset($_SESSION['logged_in'])) { ?>
                <div class="mb-4 mt-4">
                    <p class="m-0 text-secondary mb-1 mx-2" style="font-size: 15px;">Zalogowano jako</p>
                    <div style="background-color: white; padding:5px;" class="rounded-4">
                        <div class="d-flex align-items-center mt-2 mb-2">
                            <img src="<?php echo "../" . $userAvatar; ?>" class="userIconMenu mx-2">
                            <a href="../user/profile.php" class="text-decoration-none">
                                <p class="kontoDescription m-auto ms-2 fw-semibold" title="<?php echo $_SESSION['email']; ?>"><?php DisplayShortText($_SESSION['email'], 15) ?></p>
                                <p class="kontoDescription m-auto ms-2 text-secondary" style="font-size: 14px;">Zobacz swój profil ></p>
                            </a>
                        </div>
                    </div>
                </div>
                <p class="m-0 text-secondary mb-1 mx-2" style="font-size: 15px;">Opcje</p>
                <div style="background-color: white; padding:10px;" class="rounded-4">
                    <div class="dropdownElement mb-2 p-1 rounded-3">
                        <a href="../user/login.php" class="text-decoration-none">
                            <div class="d-flex align-items-center gap-3 fw-semibold"><i class="bi bi-bookmarks-fill fs-4 ms-2 panelIcons"></i>Zapisane oferty</div>
                        </a>
                    </div>
                    <div class="dropdownElement mb-2 p-1 rounded-3">
                        <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#settingsModal">
                            <div class="d-flex align-items-center gap-3 fw-semibold"><i class="bi bi-gear-fill fs-4 ms-2 panelIcons"></i>Ustawienia</div>
                        </a>
                    </div>
                    <div class="dropdownElement mb-2 p-1 rounded-3">
                        <a href="../actions/actionLogout.php" class="text-decoration-none">
                            <div class="d-flex align-items-center gap-3 fw-semibold"><i class="bi bi-box-arrow-right fs-4 ms-2 panelIcons"></i>Wyloguj</div>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>