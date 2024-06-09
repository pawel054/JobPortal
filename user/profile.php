<?php
session_start();
require_once '../actions/connection.php';
require_once '../actions/getNavbarData.php';

$userID = $_SESSION['user_id'];
$email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["delete_experience"])) {
    $experience_id = $_POST["delete_experience"];
    $conn->query("DELETE FROM profile_experience WHERE experience_id='$experience_id'");
  }

  if (isset($_POST["delete_summary"])) {
    $profile_id = $_POST["delete_summary"];
    $conn->query("UPDATE `profile` SET career_summary = null WHERE profile_id='$profile_id'");
  }

  if (isset($_POST["delete_position"])) {
    $profile_id = $_POST["delete_position"];
    $conn->query("UPDATE `profile` SET job_position = null, job_position_description = null WHERE profile_id='$profile_id'");
  }

  if (isset($_POST["delete_language"])) {
    $lang_id = $_POST["delete_language"];
    $conn->query("DELETE FROM profile_languages WHERE language_id='$lang_id'");
  }

  if (isset($_POST["delete_skill"])) {
    $skill_id = $_POST["delete_skill"];
    $conn->query("DELETE FROM profile_skills WHERE skill_id='$skill_id'");
  }

  if (isset($_POST["delete_url"])) {
    $url_id = $_POST["delete_url"];
    $conn->query("DELETE FROM profile_urls WHERE url_id='$url_id'");
  }

  if (isset($_POST["delete_certificate"])) {
    $certificate_id = $_POST["delete_certificate"];
    $conn->query("DELETE FROM profile_certificates WHERE certificate_id='$certificate_id'");
  }
  if (isset($_POST["delete_education"])) {
    $edu_id = $_POST["delete_education"];
    $conn->query("DELETE FROM profile_education WHERE education_id='$edu_id'");
  }

  header("Location: " . $_SERVER['PHP_SELF']);
}

$profileInfoResult = $conn->query("SELECT * FROM `profile` WHERE user_id='$userID'");
if ($profileInfoResult->num_rows > 0) {
  $row = mysqli_fetch_assoc($profileInfoResult);
  $profileID = $row['profile_id'];
  $name = $row['name'];
  $surname = $row['surname'];
  $birthdate = $row['birth_date'];
  $phoneNumber = $row['phone_number'];
  $avatarSrc = $row['avatar_src'];
  $adress = $row['user_adress'];
  $jobPosition = $row['job_position'];
  $jobPositionDesc = $row['job_position_description'];
  $careerSummary = $row['career_summary'];
}

$urlsResult = $conn->query("SELECT * FROM `profile_urls` WHERE profile_id='$profileID';");
$languageResult = $conn->query("SELECT * FROM `profile_languages` WHERE profile_id='$profileID';");
$experienceResult = $conn->query("SELECT * FROM `profile_experience` WHERE profile_id='$profileID';");
$educationResult = $conn->query("SELECT * FROM `profile_education` WHERE profile_id='$profileID';");
$certificatesResult = $conn->query("SELECT * FROM `profile_certificates` WHERE profile_id='$profileID';");
$skillsResult = $conn->query("SELECT * FROM `profile_skills` WHERE profile_id='$profileID';");

function DisplayShortText($text, $maxSymbols)
{
  if (strlen($text) > $maxSymbols)
    echo substr($text, 0, $maxSymbols) . '...';
  else
    echo $text;
}

$availableIcons = ["youtube", "twitter", "x", "facebook", "instagram", "threads", "tiktok", "telegram", "reddit", "discord", "linkedin", "paypal", "pinterest", "github", "gitlab"];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/animations.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <title>Document</title>
</head>

<body id="profileBody">
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.php"><img src="../imgs/UI/logo.png" width="120px"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="../index.php">Strona główna</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../search.php">Oferty pracy</a>
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
                    <img src="<?php echo "../" . $userAvatar; ?>" class="userIconMenu mx-2">
                    <a href="#" class="text-decoration-none">
                      <p class="kontoDescription m-auto ms-2 fw-semibold" title="<?php echo $_SESSION['email']; ?>"><?php DisplayShortText($_SESSION['email'], 15) ?></p>
                      <p class="kontoDescription m-auto ms-2 text-secondary" style="font-size: 14px;">Zobacz mój profil ></p>
                    </a>
                  </div>
                </div>
              </div>
              <p class="m-0 text-secondary mx-2" style="font-size: 15px;">Opcje</p>
              <div style=" padding:10px;" class="rounded-4">
                <?php if ($_SESSION['isadmin'] == 1) { ?>
                  <div class="dropdownElement mb-2 p-1 rounded-3">
                    <a href="../admin/index.php" class="text-decoration-none">
                      <div class="d-flex align-items-center gap-3 fw-semibold"><i class="bi bi-tools fs-4 ms-2 panelIcons"></i>Panel administratora</div>
                    </a>
                  </div>
                <?php } ?>
                <div class="dropdownElement mb-2 p-1 rounded-3">
                  <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#savedModal">
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
  <div class="bottom-menu z-1" style="<?php if ($_SESSION['isadmin'] == 1) echo 'gap: 12%;';
                                      else echo 'gap: 19%;'; ?>">
    <a href="../index.php" class="text-center text-decoration-none menuIconDiv">
      <i class="bi bi-house-fill menuIcon fs-2"></i>
      <p class="m-0 menuIconText">Home</p>
    </a>
    <a href="../search.php" class="text-center text-decoration-none menuIconDiv">
      <i class="bi bi-search menuIcon fs-2"></i>
      <p class="m-0 menuIconText">Szukaj</p>
    </a>
    <a href="../user/mobile_account.php" class="text-center text-decoration-none menuIconDiv">
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
  <div class="modal fade" id="savedModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="savedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="savedModalLabel">Zapisane oferty</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex flex-column">
          <p class="d-inline-flex gap-1">
            <a class="text-decoration-none fs-5 dropdown-toggle page-link" data-bs-toggle="collapse" href="#favsCollapse" role="button" aria-expanded="false" aria-controls="favsCollapse">
              Rozwiń ulubione oferty (<?php echo $favsResult->num_rows ?>)
            </a>
          </p>
          <div class="collapse" id="favsCollapse">
            <?php
            while ($row = mysqli_fetch_assoc($favsResult)) {
            ?>
              <a href="offers/offer.php?id=<?php echo $row["offer_id"]; ?>" class="text-decoration-none text-dark">
                <div class="offerBox w-100 mb-3">
                  <div class="row">
                    <div class="col-lg-2 square-container" id="searchOfferImage">
                      <img src="<?php echo "../" . $row["logo_src"]; ?>" class="square-image p-2">
                    </div>
                    <div class="col-lg-10">
                      <div class="row">
                        <div class="col-12 d-flex">
                          <div>
                            <h6 class="fw-semibold mb-0"><?php echo $row["position_name"]; ?></h6>
                            <p class="fw-sedmibold"><?php echo $row["company_name"]; ?></p>
                          </div>
                          <form class="ms-auto align-self-start" method="post" action="../actions/sendData.php">
                            <input type="hidden" name="DeleteFavoriteOffer" value="<?php echo $row["favourite_id"]; ?>" hidden>
                            <input type="hidden" name="return_url" value="<?php echo htmlspecialchars("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" hidden>
                            <input type="submit" class="btn fw-bold bg-danger text-light" value="x">
                          </form>
                        </div>
                        <div class="col-12 d-flex gap-4">
                          <?php if ($row["salary"] != null) { ?>
                            <div class="d-flex align-items-center gap-2">
                              <i class="bi bi-currency-exchange fs-5"></i>
                              <h6 class="m-0"><?php echo $row["salary"]; ?> zł / mies.</h6>
                            </div>
                          <?php } ?>
                          <div class="d-flex align-items-center gap-2 searchBoxdetails">
                            <i class="bi bi-geo-alt-fill fs-5"></i>
                            <h6 class="m-0"><?php $adress2 = explode(":", $row['adress'], 2);
                                            echo trim($adress2[1]); ?></h6>
                          </div>
                          <div class="d-flex align-items-center gap-2" id="expDate">
                            <i class="bi bi-hourglass-split fs-5"></i>
                            <h6 class="m-0">Wygasa: <?php echo $row["expiration_date"]; ?></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            <?php } ?>
          </div>
          <p class="d-inline-flex gap-1">
            <a class="text-decoration-none fs-5 dropdown-toggle page-link" data-bs-toggle="collapse" href="#appsCollapse" role="button" aria-expanded="false" aria-controls="appsCollapse">
              Rozwiń swoje aplikcaje (<?php echo $applicationsResult->num_rows ?>)
            </a>
          </p>
          <div class="collapse" id="appsCollapse">
            <?php
            while ($row = mysqli_fetch_assoc($applicationsResult)) {
            ?>
              <a href="offers/offer.php?id=<?php echo $row["offer_id"]; ?>" class="text-decoration-none text-dark">
                <div class="offerBox w-100 mt-3">
                  <div class="row">
                    <div class="col-lg-2 square-container" id="searchOfferImage">
                      <img src="<?php echo "../" . $row["logo_src"]; ?>" class="square-image p-2">
                    </div>
                    <div class="col-lg-10">
                      <div class="row">
                        <div class="col-12 d-flex">
                          <div>
                            <h6 class="fw-semibold mb-0"><?php echo $row["position_name"]; ?></h6>
                            <p class="fw-sedmibold"><?php echo $row["company_name"]; ?></p>
                          </div>
                          <form class="ms-auto align-self-start" method="post" action="../actions/sendData.php">
                            <input type="hidden" name="DeleteApplicationOffer" value="<?php echo $row["application_id"]; ?>" hidden>
                            <input type="hidden" name="return_url" value="<?php echo htmlspecialchars("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" hidden>
                            <input type="submit" class="btn fw-bold bg-danger text-light" value="x">
                          </form>
                        </div>
                        <div class="col-12 d-flex gap-4">
                          <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-hourglass-split fs-5"></i>
                            <h6 class="m-0">Złożono: <?php echo $row["expiration_date"]; ?></h6>
                          </div>
                          <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-bar-chart-fill fs-5"></i>
                            <h6 class="m-0"><?php echo $row["status"]; ?></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            <?php } ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
        </div>
      </div>
    </div>
  </div>
  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-5 col-custom">
        <div class="profileBox">
          <div class="profileBoxPart d-flex p-4">
            <h4 class="text-light">Mój profil</h4>
            <a href="#" id="informationsEditBtn" onclick="toggleEdit()" class="text-light text-decoration-none ms-auto fs-5">
              <span class="bi bi-pencil-fill text-light profileIcon me-2"></span>
              <span class="actionText text-light">Edytuj</span>
            </a>
          </div>
          <div class="profileInfoData mx-4 pb-5">
            <form method="post" action="../actions/profileData.php" enctype="multipart/form-data">
              <input type="hidden" name="baseForm" value="true" id="baseForm">
              <div class="position-relative d-inline-block" id="avatarContainer">
                <img src="../<?php echo $avatarSrc; ?>" class="avatarEdit" id="avatarImage" data-original-image="<?php echo $avatarSrc; ?>">
                <div class="position-absolute top-50 start-50 translate-middle camera-icon">
                  <i class="bi bi-camera-fill fs-1 text-secondary"></i>
                </div>
              </div>

              <input type="file" name="file" id="fileInput" accept=".jpg, .jpeg, .png, .gif">

              <h4 class="mt-4 mb-3 fw-semibold">Podstawowe dane</h4>
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-person-fill fs-2 violetColor"></i>
                <p class="m-0 mx-3 fs-5" id="nameSurname" data-original-text="<?php echo $name . ' ' . $surname; ?>"><?php echo $name . ' ' . $surname; ?></p>
              </div>
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-cake2-fill fs-2 violetColor"></i>
                <p class="m-0 mx-3 fs-5" id="birthdate" data-original-text="<?php echo $birthdate; ?>"><?php echo $birthdate; ?></p>
              </div>
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-envelope-fill fs-2 violetColor"></i>
                <p class="m-0 mx-3 fs-5" id="email" data-original-text="<?php echo $email; ?>"><?php echo $email; ?></p>
              </div>
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-telephone-fill fs-2 violetColor"></i>
                <p class="m-0 mx-3 fs-5" id="number" data-original-text="<?php echo $phoneNumber; ?>"><?php echo $phoneNumber; ?></p>
              </div>
              <div class="d-flex align-items-center">
                <i class="bi bi-house-fill fs-2 violetColor"></i>
                <p class="m-0 mx-3 fs-5" id="adress" data-original-text="<?php echo $adress; ?>"><?php echo $adress; ?></p>
              </div>
              <input type="submit" class="btn bg-violet text-light w-25 fs-6 rounded-4 p-2 mt-4" id="baseSubmitBtn" style="display: none;">
            </form>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Aktualne stanowisko</h4>
            <?php
            if ($jobPosition != null && $jobPositionDesc != null) {
            ?>
              <a href="#" class="ms-auto me-3 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold" data-bs-toggle="modal" data-bs-target="#positionModal" onclick="EditPosition('<?php echo $jobPosition; ?>', '<?php echo $jobPositionDesc; ?>')"><span class="bi bi-pencil-fill me-2 fs-5 fw-semibold"></span>Edytuj</a>
              <a href="#" class=" fs-6 fw-semibold profileBtnLink px-3 pe-3 rounded-5 align-items-center d-flex" data-bs-toggle="modal" data-bs-target="#decisionModal" onclick="SetDeleteData('<?php echo $profileID; ?>', 'positionDeleteForm', 'position')"><span class="bi bi-trash3-fill fs-6 me-2 profileBtnLinkIcon"></span>Usuń</a>
            <?php } else { ?>
              <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold" data-bs-toggle="modal" data-bs-target="#positionModal"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
            <?php } ?>
          </div>
          <div class="profileBox2">
            <?php
            if ($jobPosition != null && $jobPositionDesc != null) {
            ?>
              <h5 class="fw-bold mx-2"><?php echo $jobPosition; ?></h5>
              <p class="mx-2 mb-1"><?php echo $jobPositionDesc; ?></p>
            <?php
            } else {
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>W tym miejscu wyświetli się aktualne stanowisko  </p>";
            }
            ?>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Podsumowanie pracy</h4>
            <?php
            if ($careerSummary != null) {
            ?>
              <a href="#" class="ms-auto me-3 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold" data-bs-toggle="modal" data-bs-target="#summaryModal" onclick="EditSummary('<?php echo $careerSummary; ?>')"><span class="bi bi-pencil-fill me-2 fs-5 fw-semibold profileBtnLinkIcon"></span>Edytuj</a>
              <a href="#" class=" fs-6 fw-semibold profileBtnLink px-3 pe-3 rounded-5 align-items-center d-flex" data-bs-toggle="modal" data-bs-target="#decisionModal" onclick="SetDeleteData('<?php echo $profileID; ?>', 'summaryDeleteForm', 'summary')"><span class="bi bi-trash3-fill fs-6 me-2 profileBtnLinkIcon"></span>Usuń</a>
            <?php } else { ?>
              <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold" data-bs-toggle="modal" data-bs-target="#summaryModal"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
            <?php } ?>
          </div>
          <div class="profileBox2">
            <?php
            if ($careerSummary != null) {
            ?>
              <p class="mx-4 mb-1"><?php echo $careerSummary; ?></p>
            <?php
            } else {
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>W tym miejscu wyświetli się podsumowanie zawodowe</p>";
            }
            ?>
          </div>
        </div>

        <div class="mt-5 mb-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Języki</h4>
            <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold" data-bs-toggle="modal" data-bs-target="#languageModal"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
          </div>
          <div class="profileBox2">
            <?php
            if ($languageResult->num_rows > 0) {
              while ($row = mysqli_fetch_assoc($languageResult)) {
                $lang_id = $row["language_id"];
            ?>
                <div class="d-flex">
                  <div class="d-flex align-items-center mx-2 mt-2">
                    <i class="bi bi-globe-americas fs-2 violetColor"></i>
                    <p class="m-0 mx-3 fs-5"><?php echo $row['language']; ?> <span class="linkMark"><?php echo $row['level']; ?></span></p>
                  </div>
                  <a href="#" class="fw-bold ms-auto mx-2 text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#decisionModal" onclick="SetDeleteData('<?php echo $lang_id; ?>', 'langDeleteForm', 'language')"><span class="bi bi-trash3-fill fs-6 me-2 violetColor"></span>Usuń</a>
                </div>
            <?php
              }
            } else {
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>W tym miejscu wyświetlą się języki.</p>";
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-lg-7 secondCol col-custom">
        <div>
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Linki</h4>
            <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold" data-bs-toggle="modal" data-bs-target="#urlModal"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold profileBtnLinkIcon"></span>Dodaj</a>
          </div>
          <div class="profileBox2">
            <?php
            if ($urlsResult->num_rows > 0) {
              while ($row = mysqli_fetch_assoc($urlsResult)) {
                $url_id = $row["url_id"];
            ?>
                <div class="d-flex">
                  <div class="d-flex align-items-center mx-2 mt-2">
                    <?php
                    $brandName = strtolower($row['url_name']);
                    $hasHttps = substr($row['url'], 0, 8);
                    if (in_array($brandName, $availableIcons)) {
                      if ($brandName == "twitter" || $brandName == "x") $brandName = "twitter-x";
                      echo '<i class="bi bi-' . $brandName . ' fs-2 violetColor" data-bs-toggle="tooltip" data-bs-title="' . $brandName . '"></i>';
                    } else {
                      echo
                      '<i class="bi bi-link-45deg fs-2 violetColor" data-bs-toggle="tooltip" data-bs-title="' . $brandName . '"></i>';;
                    }
                    ?>
                    <a href="<?php if ($hasHttps == "https://") echo $row['url']; else echo "https://" . $row['url']; ?>" target="_blank" class="m-0 mx-3 fs-5 text-decoration-none violetColor"><?php DisplayShortText($row['url'], 47); ?></a>
                  </div>
                  <a href="#" class="fw-bold ms-auto mx-2 text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#decisionModal" onclick="SetDeleteData('<?php echo $url_id; ?>', 'urlDeleteForm', 'url')"><span class="bi bi-trash3-fill fs-6 me-2 violetColor profileBtnLinkIcon"></span>Usuń</a>
                </div>
            <?php
              }
            } else {
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>W tym miejscu wyświetlą się twoje linki.</p>";
            }
            ?>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Doświadczenie zawodowe</h4>
            <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3 rounded-5 align-items-center d-flex fw-semibold mx-auto" data-bs-toggle="modal" data-bs-target="#experienceModal"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold profileBtnLinkIcon"></span>Dodaj</a>
          </div>
          <div class="profileBox2">
            <?php
            if ($experienceResult->num_rows > 0) {
              while ($row = mysqli_fetch_assoc($experienceResult)) {
                $experience_id = $row["experience_id"];
                $position = $row["position"];
                $company_name = $row["company_name"];
                $location = $row["location"];
                $peroid_from = $row["peroid_from"];
                $peroid_to = $row["peroid_to"];
            ?>
                <div class="p-3">
                  <div class="d-flex">
                    <h5 class="fw-semibold"><?php echo $row["position"]; ?></h5>
                    <div class="d-flex ms-auto gap-4">
                      <a href="#" class="fw-bold text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#experienceModal" onclick="EditExperience('<?php echo $experience_id; ?>', '<?php echo $position; ?>', '<?php echo $company_name; ?>' , '<?php echo $location; ?>', '<?php echo $peroid_from ?>', '<?php echo $peroid_to ?>')"><span class="bi bi-pencil-fill fs-6 me-2 violetColor"></span>Edytuj</a>
                      <a href="#" class="fw-bold text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#decisionModal" onclick="SetDeleteData('<?php echo $experience_id; ?>', 'experienceDeleteForm', 'experience')"><span class="bi bi-trash3-fill fs-6 me-2 violetColor"></span>Usuń</a>
                    </div>
                  </div>
                  <div class="d-flex align-items-center mb-1">
                    <i class="bi bi-buildings fs-5 violetColor"></i>
                    <p class="m-0 mx-2 fs-6"><?php echo $row["company_name"]; ?></p>
                  </div>
                  <div class="d-flex align-items-center mb-1">
                    <i class="bi bi-geo-alt fs-5 violetColor"></i>
                    <p class="m-0 mx-2 fs-6"><?php echo $row["location"]; ?></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-clock fs-5 violetColor"></i>
                    <p class="m-0 mx-2 fs-6"><?php echo $row["peroid_from"]; ?> - <?php echo $row["peroid_to"]; ?></p>
                  </div>
                </div>
            <?php
              }
            } else {
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>W tym miejscu wyświetlą się doświadczenia.</p>";
            }
            ?>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Wykształcenie</h4>
            <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold" data-bs-toggle="modal" data-bs-target="#educationModal"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold profileBtnLinkIcon"></span>Dodaj</a>
          </div>
          <div class="profileBox2">
            <?php
            if ($educationResult->num_rows > 0) {
              while ($row = mysqli_fetch_assoc($educationResult)) {
                $education_id = $row["education_id"];
                $school_name = $row["school_name"];
                $education_level = $row["education_level"];
                $major = $row["major"];
                $school_adress = $row["location"];
                $peroid_from = $row["peroid_from"];
                $peroid_to = $row["peroid_to"];
            ?>
                <div class="p-3">
                  <div class="d-flex">
                    <h5 class="fw-semibold"><?php echo $row["school_name"]; ?></h5>
                    <div class="d-flex ms-auto gap-4">
                      <a href="#" class="fw-bold text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#educationModal" onclick="EditEducation('<?php echo $education_id; ?>', '<?php echo $school_name; ?>', '<?php echo $education_level; ?>' , '<?php echo $major; ?>', '<?php echo $school_adress ?>', '<?php echo $peroid_from ?>', '<?php echo $peroid_to ?>')"><span class="bi bi-pencil-fill fs-6 me-2 violetColor"></span>Edytuj</a>
                      <a href="#" class="fw-bold text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#decisionModal" onclick="SetDeleteData('<?php echo $education_id; ?>', 'educationDeleteForm', 'education')"><span class="bi bi-trash3-fill fs-6 me-2 violetColor"></span>Usuń</a>
                    </div>
                  </div>
                  <div class="d-flex align-items-center mb-1">
                    <i class="bi bi-bar-chart fs-5 violetColor"></i>
                    <p class="m-0 mx-2 fs-6"><?php echo $row["education_level"]; ?></p>
                  </div>
                  <div class="d-flex align-items-center mb-1">
                    <i class="bi bi-mortarboard-fill fs-5 violetColor"></i>
                    <p class="m-0 mx-2 fs-6"><?php echo $row["major"]; ?></p>
                  </div>
                  <div class="d-flex align-items-center mb-1">
                    <i class="bi bi-geo-alt fs-5 violetColor"></i>
                    <p class="m-0 mx-2 fs-6"><?php echo $row["location"]; ?></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-clock fs-5 violetColor"></i>
                    <p class="m-0 mx-2 fs-6"><?php echo $row["peroid_from"]; ?> - <?php echo $row["peroid_to"]; ?></p>
                  </div>
                </div>
            <?php
              }
            } else {
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>W tym miejscu wyświetlą się wykształcenia.</p>";
            }
            ?>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Kursy, szkolenia, certyfikaty</h4>
            <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold" data-bs-toggle="modal" data-bs-target="#certificatesModal"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold profileBtnLinkIcon"></span>Dodaj</a>
          </div>
          <div class="profileBox2">
            <?php
            if ($certificatesResult->num_rows > 0) {
              while ($row = mysqli_fetch_assoc($certificatesResult)) {
                $cert_id = $row["certificate_id"];
                $cert_name = $row["name"];
                $cert_organizer = $row["organizer"];
                $peroid_from = $row["peroid_from"];
                $peroid_to = $row["peroid_to"];
            ?>
                <div class="p-3">
                  <div class="d-flex">
                    <h5 class="fw-semibold"><?php echo $row["name"]; ?></h5>
                    <div class="d-flex ms-auto gap-4">
                      <a href="#" class="fw-bold text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#certificatesModal" onclick="EditCertificate('<?php echo $cert_id; ?>', '<?php echo $cert_name; ?>', '<?php echo $cert_organizer; ?>' , '<?php echo $peroid_from; ?>', '<?php echo $peroid_to ?>')"><span class="bi bi-pencil-fill fs-6 me-2 violetColor"></span>Edytuj</a>
                      <a href="#" class="fw-bold text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#decisionModal" onclick="SetDeleteData('<?php echo $cert_id; ?>', 'certificateDeleteForm', 'certificate')"><span class="bi bi-trash3-fill fs-6 me-2 violetColor"></span>Usuń</a>
                    </div>
                  </div>
                  <div class="d-flex align-items-center mb-1">
                    <i class="bi bi-person fs-5 violetColor"></i>
                    <p class="m-0 mx-2 fs-6"><?php echo $row["organizer"]; ?></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-clock fs-5 violetColor"></i>
                    <p class="m-0 mx-2 fs-6"><?php echo $row["peroid_from"]; ?> - <?php echo $row["peroid_to"]; ?></p>
                  </div>
                </div>
            <?php
              }
            } else {
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>W tym miejscu wyświetlą się Kursy, szkolenia lub certyfikaty.</p>";
            }
            ?>
          </div>
        </div>
        <div class="mt-5 mb-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Umiejętności</h4>
            <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold" data-bs-toggle="modal" data-bs-target="#skillsModal"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold profileBtnLinkIcon"></span>Dodaj</a>
          </div>
          <div class="profileBox2">
            <?php
            if ($skillsResult->num_rows > 0) {
              while ($row = mysqli_fetch_assoc($skillsResult)) {
                $skill_id = $row["skill_id"];
            ?>
                <div class="d-flex">
                  <div class="d-flex align-items-center mx-2 mt-2">
                    <i class="bi bi-star fs-2 violetColor"></i>
                    <p class="m-0 mx-3 fs-5"><?php echo $row['skill']; ?></p>
                  </div>
                  <a href="#" class="fw-bold ms-auto mx-2 text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#decisionModal" onclick="SetDeleteData('<?php echo $skill_id; ?>', 'skillDeleteForm', 'skill')"><span class="bi bi-trash3-fill fs-6 me-2 violetColor profileBtnLinkIcon"></span>Usuń</a>
                </div>
            <?php
              }
            } else {
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>W tym miejscu wyświetlą się umiejętności.</p>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="experienceModal" tabindex="-1" aria-labelledby="experienceModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4">
          <div class="modal-header">
            <h4 class="modal-title" id="experienceModalLabel">Doświadczenie zawodowe</h4>
            <button type="button" onclick="AddExtraInput2('testDiv2','experienceElement')" class="btn violetButtonsDropdown rounded-4 mx-3 align-self-center addNewElementButton">
              <i class="bi bi-plus-lg text-white me-2"></i>Dodaj
            </button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-2">
            <form method="post" action="../actions/profileData.php">
              <input type="hidden" name="experienceForm" value="true" id="experienceForm">
              <input type="hidden" name="isEdit" value="false" id="isEditExperience" class="editElement">
              <div class="container">
                <div id="testDiv2">
                  <div class="d-flex flex-column justify-content-center mt-3" id="experienceElement">
                    <div class="m-0 d-flex justify-content-between">
                      <p class="m-0 violetColor fw-semibold">Nowe doświadczenie</p>
                      <p class="m-0 violetColor fw-semibold deleteElement invisible"><i class="bi bi-trash3-fill me-1"></i>Usuń</p>
                    </div>
                    <hr class="violetHr m-0">
                    <div class="row mt-4">
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="position" name="experience[]" placeholder="" maxlength="80" required>
                          <label>Stanowisko</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="company_name" name="experience[]" placeholder="" maxlength="50" required>
                          <label>Nazwa firmy</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="company_adress" name="experience[]" placeholder="" maxlength="50" required>
                          <label>Adres firmy</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="date" class="form-control adminInput" id="working_from" name="experience[]" placeholder="" required>
                          <label>Okres zatrudnienia (od)</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="date" class="form-control adminInput" id="working_to" name="experience[]" placeholder="" required>
                          <label>Okres zatrudnienia (do)</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary">
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="educationModal" tabindex="-1" aria-labelledby="educationModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4">
          <div class="modal-header">
            <h4 class="modal-title" id="educationModalLabel">Wykształcenie</h4>
            <button type="button" onclick="AddExtraInput2('educationDivModal', 'educationElement')" class="btn violetButtonsDropdown rounded-4 mx-3 align-self-center addNewElementButton">
              <i class="bi bi-plus-lg text-white me-2"></i>Dodaj
            </button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-2">
            <form method="post" action="../actions/profileData.php">
              <input type="hidden" name="educationForm" value="true" id="educationForm">
              <input type="hidden" name="isEdit" value="false" id="isEditEducation" class="editElement">
              <div class="container">
                <div id="educationDivModal">
                  <div class="d-flex flex-column justify-content-center mt-3" id="educationElement">
                    <div class="m-0 d-flex justify-content-between">
                      <p class="m-0 violetColor fw-semibold">Nowe wykształcenie</p>
                      <p class="m-0 violetColor fw-semibold deleteElement invisible"><i class="bi bi-trash3-fill me-1"></i>Usuń</p>
                    </div>
                    <hr class="violetHr m-0">
                    <div class="row mt-4">
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="school_name" name="education[]" placeholder="" maxlength="80" required>
                          <label>Nazwa szkoły</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="education_level" name="education[]" placeholder="" maxlength="50" required>
                          <label>Poziom wykształcenia</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="major" name="education[]" placeholder="" maxlength="50" required>
                          <label>Kierunek</label>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="school_adress" name="education[]" placeholder="" maxlength="50" required>
                          <label>Adres szkoły</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="date" class="form-control adminInput" id="studying_from" name="education[]" placeholder="" required>
                          <label>Okres uczęszczania (od)</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="date" class="form-control adminInput" id="studying_to" name="education[]" placeholder="" required>
                          <label>Okres uczęszczania (do)</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary">
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="certificatesModal" tabindex="-1" aria-labelledby="certificatesModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4">
          <div class="modal-header">
            <h4 class="modal-title" id="certificatesModalLabel">Kursy, szkolenia, certyfikaty</h4>
            <button type="button" onclick="AddExtraInput2('certificatesDivModal', 'certificatesElement')" class="btn violetButtonsDropdown rounded-4 mx-3 align-self-center addNewElementButton">
              <i class="bi bi-plus-lg text-white me-2"></i>Dodaj
            </button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-2">
            <form method="post" action="../actions/profileData.php">
              <input type="hidden" name="certificatesForm" value="true" id="certificatesForm">
              <input type="hidden" name="isEdit" value="false" id="isEditCertificate" class="editElement">
              <div class="container">
                <div id="certificatesDivModal">
                  <div class="d-flex flex-column justify-content-center mt-3" id="certificatesElement">
                    <div class="m-0 d-flex justify-content-between">
                      <p class="m-0 violetColor fw-semibold">Nowy element</p>
                      <p class="m-0 violetColor fw-semibold deleteElement invisible"><i class="bi bi-trash3-fill me-1"></i>Usuń</p>
                    </div>
                    <hr class="violetHr m-0">
                    <div class="row mt-4">
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="cert_name" name="certificates[]" placeholder="" maxlength="80" required>
                          <label>Nazwa kursu</label>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="organizer" name="certificates[]" placeholder="" maxlength="50" required>
                          <label>Organizator</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="date" class="form-control adminInput" id="cert_peroid_from" name="certificates[]" placeholder="" required>
                          <label>Okres uczęszczania (od)</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="date" class="form-control adminInput" id="cert_peroid_to" name="certificates[]" placeholder="" required>
                          <label>Okres uczęszczania (do)</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary">
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="skillsModal" tabindex="-1" aria-labelledby="skillsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4">
          <div class="modal-header">
            <h4 class="modal-title" id="skillsModalLabel">Umiejętności</h4>
            <button type="button" onclick="AddExtraInput2('skillsDivModal', 'skillsElement')" class="btn violetButtonsDropdown rounded-4 mx-3 align-self-center addNewElementButton">
              <i class="bi bi-plus-lg text-white me-2"></i>Dodaj
            </button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-2">
            <form method="post" action="../actions/profileData.php">
              <input type="hidden" name="skillsForm" value="true">
              <div class="container">
                <div id="skillsDivModal">
                  <div class="d-flex flex-column justify-content-center mt-3" id="skillsElement">
                    <div class="m-0 d-flex justify-content-between">
                      <p class="m-0 violetColor fw-semibold">Nowa umiejętność</p>
                      <p class="m-0 violetColor fw-semibold deleteElement invisible"><i class="bi bi-trash3-fill me-1"></i>Usuń</p>
                    </div>
                    <hr class="violetHr m-0">
                    <div class="row mt-4">
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" name="skill[]" placeholder="" maxlength="100" required>
                          <label>Umiejętność</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary">
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="urlModal" tabindex="-1" aria-labelledby="urlModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4">
          <div class="modal-header">
            <h4 class="modal-title" id="urlModalLabel">Linki</h4>
            <button type="button" onclick="AddExtraInput2('urlDivModal', 'urlElement')" class="btn violetButtonsDropdown rounded-4 mx-3 align-self-center addNewElementButton">
              <i class="bi bi-plus-lg text-white me-2"></i>Dodaj
            </button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-2">
            <form method="post" action="../actions/profileData.php">
              <input type="hidden" name="urlForm" value="true">
              <div class="container">
                <div id="urlDivModal">
                  <div class="d-flex flex-column justify-content-center mt-3" id="urlElement">
                    <div class="m-0 d-flex justify-content-between">
                      <p class="m-0 violetColor fw-semibold">Nowy link</p>
                      <p class="m-0 violetColor fw-semibold deleteElement invisible"><i class="bi bi-trash3-fill me-1"></i>Usuń</p>
                    </div>
                    <hr class="violetHr m-0">
                    <div class="row mt-4">
                      <div class="col-3">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" name="url[]" placeholder="" maxlength="50" required>
                          <label>Serwis</label>
                        </div>
                      </div>
                      <div class="col-9">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" name="url[]" placeholder="" maxlength="65535" required>
                          <label>Link</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary">
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="languageModal" tabindex="-1" aria-labelledby="languageModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4">
          <div class="modal-header">
            <h4 class="modal-title" id="languageModalLabel">Języki</h4>
            <button type="button" onclick="AddExtraInput2('langDivModal', 'langElement')" class="btn violetButtonsDropdown rounded-4 mx-3 align-self-center addNewElementButton">
              <i class="bi bi-plus-lg text-white me-2"></i>Dodaj
            </button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-2">
            <form method="post" action="../actions/profileData.php">
              <input type="hidden" name="langForm" value="true">
              <div class="container">
                <div id="langDivModal">
                  <div class="d-flex flex-column justify-content-center mt-3" id="langElement">
                    <div class="m-0 d-flex justify-content-between">
                      <p class="m-0 violetColor fw-semibold">Nowy język</p>
                      <p class="m-0 violetColor fw-semibold deleteElement invisible"><i class="bi bi-trash3-fill me-1"></i>Usuń</p>
                    </div>
                    <hr class="violetHr m-0">
                    <div class="row mt-4">
                      <div class="col-9">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" name="lang[]" placeholder="" maxlength="39" required>
                          <label>Język</label>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="form-floating mb-3">
                          <select class="form-select adminInput" id="kategoria" aria-label="Floating label select example" name="lang[]">
                            <option>A1</option>
                            <option>A2</option>
                            <option>B1</option>
                            <option>B2</option>
                            <option>C1</option>
                            <option>C2</option>
                          </select>
                          <label>Poziom</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary">
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4">
          <div class="modal-header">
            <h4 class="modal-title" id="summaryModalLabel">Podsumowanie zawodowe</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-2">
            <form method="post" action="../actions/profileData.php">
              <input type="hidden" name="summaryForm" value="true">
              <div class="container">
                <div>
                  <div class="d-flex flex-column justify-content-center mt-3">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" name="summary" id="summary" placeholder="" maxlength="60" required>
                          <label>Podsumowanie zawodowe (opis)</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary">
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="positionModal" tabindex="-1" aria-labelledby="positionModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4">
          <div class="modal-header">
            <h4 class="modal-title" id="positionModalLabel">Aktualne stanowisko</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-2">
            <form method="post" action="../actions/profileData.php">
              <input type="hidden" name="positionForm" value="true">
              <div class="container">
                <div>
                  <div class="d-flex flex-column justify-content-center mt-3">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" name="cur_position" id="cur_position" placeholder="" maxlength="80" required>
                          <label>Stanowisko</label>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <textarea class="form-control adminInput" style="height: 120px; resize:none;" name="cur_position_desc" id="cur_position_desc" placeholder="" maxlength="200" required></textarea>
                          <label>Opis</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary">
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal bounce-in" id="decisionModal" tabindex="-1" aria-labelledby="decisionModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="decisionModalLabel">Uwaga!</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Czy na pewno chcesz usunąć element?
            Tej operacji nie można cofnąć.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Anuluj</button>
            <button type="button" class="btn btn-danger" onclick="SendDeleteForm()">Tak</button>
          </div>
        </div>
      </div>
    </div>
    <form id="experienceDeleteForm" method="post"></form>
    <form id="langDeleteForm" method="post"></form>
    <form id="skillDeleteForm" method="post"></form>
    <form id="certificateDeleteForm" method="post"></form>
    <form id="educationDeleteForm" method="post"></form>
    <form id="summaryDeleteForm" method="post"></form>
    <form id="positionDeleteForm" method="post"></form>
    <form id="urlDeleteForm" method="post"></form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script>
    var deleteId;
    var deleteFromId;
    var dataType;

    function toggleEdit() {
      var profileInfoData = document.querySelector('.profileInfoData');
      var paragraphs = profileInfoData.querySelectorAll('p');
      var editButton = document.getElementById('informationsEditBtn');
      var actionText = editButton.querySelector('.actionText');
      var profileIcon = document.querySelector('.profileIcon');
      var avatarContainer = document.getElementById('avatarContainer');
      var avatarImage = document.getElementById('avatarImage');
      var baseSubmitBtn = document.getElementById('baseSubmitBtn');

      if (actionText.textContent === "Edytuj") {
        baseSubmitBtn.style.display = "block";
        paragraphs.forEach(function(paragraph) {
          var input = document.createElement('input');
          if (paragraph.id == "birthdate") input.setAttribute('type', 'date');
          else input.setAttribute('type', 'text');
          input.style.marginLeft = "15px";
          input.setAttribute('name', paragraph.id);
          input.setAttribute('value', paragraph.getAttribute('data-original-text'));
          input.setAttribute('data-original-text', paragraph.getAttribute('data-original-text'));
          input.classList.add('form-control');
          input.classList.add('addedInputs');
          if (paragraph.id == "email") input.disabled = true;
          paragraph.parentNode.replaceChild(input, paragraph);
        });
        avatarContainer.classList.add('avatar-container');
        avatarContainer.addEventListener("click", clickFileInput);
        actionText.textContent = "Anuluj";
        profileIcon.classList.replace('bi-pencil-fill', 'bi-x-lg');
      } else {
        baseSubmitBtn.style.display = "none";
        var inputs = profileInfoData.querySelectorAll('.addedInputs');
        inputs.forEach(function(input) {
          var paragraph = document.createElement('p');
          paragraph.classList.add('m-0', 'mx-3', 'fs-5');
          paragraph.setAttribute('id', input.name);
          paragraph.textContent = input.getAttribute('data-original-text');
          paragraph.setAttribute('data-original-text', input.getAttribute('data-original-text'));
          input.parentNode.replaceChild(paragraph, input);
        });
        avatarContainer.classList.remove('avatar-container');
        avatarContainer.removeEventListener("click", clickFileInput);
        avatarImage.src = "../" + avatarImage.getAttribute('data-original-image');
        actionText.textContent = "Edytuj";
        profileIcon.classList.replace('bi-x-lg', 'bi-pencil-fill');
      }
    }

    document.getElementById('fileInput').addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const preview = document.getElementById('avatarImage');
          preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });


    function clickFileInput() {
      document.getElementById('fileInput').click();
    }

    function AddExtraInput2(divContainer, cloneElement) {
      var urlsDiv = document.getElementById(divContainer);
      var template = document.getElementById(cloneElement);

      var newExperience = template.cloneNode(true);
      newExperience.style.display = "block";
      newExperience.classList.add("extraDiv");

      var inputs = newExperience.querySelectorAll('input');
      inputs.forEach(function(input) {
        input.value = '';
      });

      var deleteButton = newExperience.querySelector(".deleteElement");
      deleteButton.classList.remove("invisible");
      deleteButton.style.cursor = "pointer";
      deleteButton.onclick = function() {
        newExperience.remove();
      };

      urlsDiv.appendChild(newExperience);
    }

    function EditExperience(id, position, company_name, company_adress, workingTime1, workingTime2) {
      document.getElementById('position').value = position;
      document.getElementById('company_name').value = company_name;
      document.getElementById('company_adress').value = company_adress;
      document.getElementById('working_from').value = workingTime1;
      document.getElementById('working_to').value = workingTime2;
      document.getElementById('isEditExperience').value = true;
      document.querySelector('.addNewElementButton').classList.add("invisible");
      document.getElementById('experienceForm').value = id;
    }

    function EditEducation(id, school_name, education_level, major, school_adress, studying_from, studying_to) {
      document.getElementById('school_name').value = school_name;
      document.getElementById('education_level').value = education_level;
      document.getElementById('major').value = major;
      document.getElementById('school_adress').value = school_adress;
      document.getElementById('studying_from').value = studying_from;
      document.getElementById('studying_to').value = studying_to;
      document.getElementById('isEditEducation').value = true;
      document.querySelector('.addNewElementButton').classList.add("invisible");
      document.getElementById('educationForm').value = id;
    }

    function EditCertificate(id, cert_name, organizer, peroid_from, peroid_to) {
      document.getElementById('cert_name').value = cert_name;
      document.getElementById('organizer').value = organizer;
      document.getElementById('cert_peroid_from').value = peroid_from;
      document.getElementById('cert_peroid_to').value = peroid_to;
      document.getElementById('isEditCertificate').value = true;
      document.querySelector('.addNewElementButton').classList.add("invisible");
      document.getElementById('certificatesForm').value = id;
    }

    function EditSummary(name) {
      document.getElementById('summary').value = name;
    }

    function EditPosition(position, description) {
      document.getElementById('cur_position').value = position;
      document.getElementById('cur_position_desc').value = description;
    }

    var myModal = document.getElementsByClassName('modal');

    for (let i = 0; i < myModal.length - 1; i++) {
      var testtt = document.getElementById(myModal[i].id);
      testtt.addEventListener('hidden.bs.modal', function() {
        var form = this.querySelector('form');
        if (form) {
          form.reset();
          var formInput = form.querySelector('.editElement');
          if (formInput) {
            formInput.value = 'false';
          }
          document.querySelector('.addNewElementButton').classList.remove("invisible");
          var extraDivs = form.querySelectorAll('.extraDiv');
          extraDivs.forEach(function(extraDiv) {
            extraDiv.remove();
          });
        }
      });
    }

    function SendDeleteForm() {
      var form = document.getElementById(deleteFromId);

      var hiddenInput = document.createElement("input");
      hiddenInput.setAttribute("type", "hidden");
      hiddenInput.setAttribute("name", "delete_" + dataType);
      hiddenInput.setAttribute("value", deleteId);

      console.log(hiddenInput);

      form.appendChild(hiddenInput);
      form.submit();
      deleteId = 0;
    }

    function SetDeleteData(elementId, formId, elementType) {
      deleteId = elementId;
      deleteFromId = formId;
      dataType = elementType;
    }

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
  </script>
</body>

</html>