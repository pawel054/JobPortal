<?php
session_start();
require_once '../actions/connection.php';
require_once '../actions/getNavbarData.php';

$userID = $_GET["id"];
$userEmail = $conn->query("SELECT email FROM `users` WHERE user_id='$userID';")->fetch_assoc();
$email = $userEmail["email"];

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
            <h4 class="text-light">Profil użytkownika</h4>
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
          </div>
          <div class="profileBox2">
            <?php
            if ($jobPosition != null && $jobPositionDesc != null) {
            ?>
              <h5 class="fw-bold mx-2"><?php echo $jobPosition; ?></h5>
              <p class="mx-2 mb-1"><?php echo $jobPositionDesc; ?></p>
            <?php
            } else {
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>Użytkownik nie uzupełnij tej sekcji.</p>";
            }
            ?>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Podsumowanie pracy</h4>
          </div>
          <div class="profileBox2">
            <?php
            if ($careerSummary != null) {
            ?>
              <p class="mx-4 mb-1"><?php echo $careerSummary; ?></p>
            <?php
            } else {
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>Użytkownik nie uzupełnij tej sekcji.</p>";
            }
            ?>
          </div>
        </div>

        <div class="mt-5 mb-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Języki</h4>
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
                </div>
            <?php
              }
            } else {
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>Użytkownik nie uzupełnij tej sekcji.</p>";
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-lg-7 secondCol col-custom">
        <div>
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Linki</h4>
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
                </div>
            <?php
              }
            } else {
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>Użytkownik nie uzupełnij tej sekcji.</p>";
            }
            ?>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Doświadczenie zawodowe</h4>
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
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>Użytkownik nie uzupełnij tej sekcji.</p>";
            }
            ?>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Wykształcenie</h4>
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
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>Użytkownik nie uzupełnij tej sekcji.</p>";
            }
            ?>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Kursy, szkolenia, certyfikaty</h4>
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
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>Użytkownik nie uzupełnij tej sekcji.</p>";
            }
            ?>
          </div>
        </div>
        <div class="mt-5 mb-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Umiejętności</h4>
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
                </div>
            <?php
              }
            } else {
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>Użytkownik nie uzupełnij tej sekcji.</p>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
  </script>
</body>

</html>