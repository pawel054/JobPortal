<?php
session_start();
require_once '../actions/connection.php';

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

  if(isset($_POST["delete_language"])){
    $lang_id = $_POST["delete_language"];
    $conn->query("DELETE FROM profile_languages WHERE language_id='$lang_id'");
  }

  if(isset($_POST["delete_skill"])){
    $skill_id = $_POST["delete_skill"];
    $conn->query("DELETE FROM profile_skills WHERE skill_id='$skill_id'");
  }

  if(isset($_POST["delete_certificate"])){
    $certificate_id = $_POST["delete_certificate"];
    $conn->query("DELETE FROM profile_certificates WHERE certificate_id='$certificate_id'");
  }
  if(isset($_POST["delete_education"])){
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
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.php">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Strona główna</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Oferty pracy</a>
          </li>
        </ul>
        <div class="dropdown ms-auto">
          <button type="button" class="btn violetButtonsDropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            Konto
          </button>
          <div class="dropdown-menu p-4 dropdownLogowanie">
            <?php if (isset($_SESSION['logged_in'])) { ?>
              <div class="mb-4">
                <div class="d-flex align-items-center mt-2 mb-2">
                  <img src="../imgs/UI/login_user.png" class="rounded-circle" width="50px">
                  <p class="kontoDescription m-auto ms-3"><?php DisplayShortText($_SESSION['email'], 20) ?></p>
                </div>
                <hr class="w-100">
              </div>
              <?php if ($_SESSION['isadmin'] == 1) { ?>
                <div class="p-1 dropdownElement">
                  <a href="user/login.php" class="text-decoration-none">
                    <div class="d-flex align-items-center text-dark"><i class="bi bi-tools mx-3 fs-3 panelIcons"></i>Panel administratora</div>
                  </a>
                </div>
              <?php } ?>
              <div class="p-1 dropdownElement">
                <a href="user/profile.php" class="text-decoration-none">
                  <div class="d-flex align-items-center text-dark"><i class="bi bi-person-fill mx-3 fs-3 panelIcons"></i>Profil użytkownika</div>
                </a>
              </div>
              <div class="p-1 dropdownElement">
                <a href="user/login.php" class="text-decoration-none">
                  <div class="d-flex align-items-center text-dark"><i class="bi bi-bookmarks-fill mx-3 fs-3 panelIcons"></i>Zapisane oferty</div>
                </a>
              </div>
              <hr class="w-100">
              <div class="mt-4 d-flex justify-content-center align-items-center">
                <a href="actions/actionLogout.php"><button class="btn violetButtons">Wyloguj</button></a>
              </div>
            <?php } else { ?>
              <div class="mb-4">
                <h4 class="kontoTitle">Witaj w JobPortal!</h4>
                <p class="kontoDescription">Logując się na konto zyskujesz dostęp do profilu, zapisywania ofert i wielu innych funkcji!</p>
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
  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-5">
        <div class="profileBox">
          <div class="profileBoxPart d-flex">
            <h4 class="text-light mx-4 align-items-center d-flex profileInfoTitle">Mój profil</h4>  
            <a href="#" id="informationsEditBtn" onclick="replaceParagraphsWithInputs()" class="text-light ms-auto me-4 fs-5 profileBtnLink profileInfoTitle align-items-center d-flex"><span class="bi bi-pencil-fill profileIcon me-2"></span><span class="actionText">Edytuj</span></a>
          </div>
          <div class="profileInfoData mx-4">
            <form method="post">
              <img src="<?php echo $avatarSrc; ?>" width="110" height="110" class="rounded-circle">
              <h4 class="mt-4 mb-3 fw-semibold">Podstawowe dane</h4>
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-person-fill fs-2 violetColor"></i>
                <p class="m-0 mx-3 fs-5" id="nameSurname"><?php echo $name . " " . $surname; ?></p>
              </div>
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-cake2-fill fs-2 violetColor"></i>
                <p class="m-0 mx-3 fs-5" id="birthdate"><?php echo $birthdate; ?></p>
              </div>
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-envelope-fill fs-2 violetColor"></i>
                <p class="m-0 mx-3 fs-5" id="email"><?php echo $email; ?></p>
              </div>
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-telephone-fill fs-2 violetColor"></i>
                <p class="m-0 mx-3 fs-5" id="number"><?php echo $phoneNumber; ?></p>
              </div>
              <div class="d-flex align-items-center">
                <i class="bi bi-house-fill fs-2 violetColor"></i>
                <p class="m-0 mx-3 fs-5" id="adress"><?php echo $adress; ?></p>
              </div>
              <h4 class="mt-5 mb-3 fw-semibold">Linki</h4>
              <div class="d-flex align-items-center">
                <i class="bi bi-link-45deg fs-2 violetColor"></i>
                <p class="m-0 mx-3 fs-5"><span class="me-2 linkMark">Youtube:</span> https://www.youtube.com/@user</p>
              </div>
              <span>&nbsp;</span>
              <input type="submit">
            </form>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Aktualne stanowisko</h4>
            <?php
            if ($jobPosition != null && $jobPositionDesc != null) {
            ?>
            <a href="#" class="ms-auto me-3 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold"><span class="bi bi-pencil-fill me-2 fs-5 fw-semibold"></span>Edytuj</a>
            <a href="#" class=" fs-6 fw-semibold profileBtnLink px-3 pe-3 rounded-5 align-items-center d-flex" data-bs-toggle="modal" data-bs-target="#decisionModal" onclick="SetDeleteData('<?php echo $profileID; ?>', 'positionDeleteForm', 'position')"><span class="bi bi-trash3-fill fs-6 me-2"></span>Usuń</a>
            <?php } else{ ?>
              <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
            <?php } ?>
          </div>
          <div class="profileBox2">
          <?php
            if ($jobPosition != null && $jobPositionDesc != null) {
          ?>
            <h4 class="fw-bold mx-2"><?php echo $jobPosition; ?></h4>
            <p class="mx-2 mb-1"><?php echo $jobPositionDesc; ?></p>
          <?php
            } else{
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>W tym miejscu wyświetli się aktualne stanowisko  </p>";
            }
          ?>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Języki</h4>
            <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
          </div>
          <div class="profileBox2">
            <?php
            if($languageResult->num_rows > 0){
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
            } else{
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>W tym miejscu wyświetlą się języki.</p>";
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-lg-7 secondCol">
        <div>
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Podsumowanie zawodowe</h4>
            <?php
            if ($careerSummary != null) {
            ?>
            <a href="#" class="ms-auto me-3 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold"><span class="bi bi-pencil-fill me-2 fs-5 fw-semibold"></span>Edytuj</a>
            <a href="#" class=" fs-6 fw-semibold profileBtnLink px-3 pe-3 rounded-5 align-items-center d-flex" data-bs-toggle="modal" data-bs-target="#decisionModal" onclick="SetDeleteData('<?php echo $profileID; ?>', 'summaryDeleteForm', 'summary')"><span class="bi bi-trash3-fill fs-6 me-2"></span>Usuń</a>
            <?php } else{ ?>
              <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
            <?php } ?>
          </div>
          <div class="profileBox2">
            <?php
            if ($careerSummary != null) {
            ?>
            <p class="mx-4 mb-1"><?php echo $careerSummary; ?></p>
            <?php
            } else{
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>W tym miejscu wyświetli się podsumowanie zawodowe</p>";
            }
            ?>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Doświadczenie zawodowe</h4>
            <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3 rounded-5 align-items-center d-flex fw-semibold mx-auto" data-bs-toggle="modal" data-bs-target="#experienceModal"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
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
                  <h4 class="fw-semibold"><?php echo $row["position"]; ?></h4>
                  <div class="d-flex ms-auto gap-4">
                    <a href="#" class="fw-bold text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#experienceModal" onclick="EditExperience('<?php echo $experience_id; ?>', '<?php echo $position; ?>', '<?php echo $company_name; ?>' , '<?php echo $location; ?>', '<?php echo $peroid_from ?>', '<?php echo $peroid_to ?>')"><span class="bi bi-pencil-fill fs-6 me-2 violetColor"></span>Edytuj</a>
                    <a href="#" class="fw-bold text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#decisionModal" onclick="SetDeleteData('<?php echo $experience_id; ?>', 'experienceDeleteForm', 'experience')"><span class="bi bi-trash3-fill fs-6 me-2 violetColor"></span>Usuń</a>
                  </div>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-buildings fs-4 violetColor"></i>
                  <p class="m-0 mx-2 fs-5"><?php echo $row["company_name"]; ?></p>
                </div>
                <div class="d-flex align-items-centermb-2">
                  <i class="bi bi-geo-alt fs-4 violetColor"></i>
                  <p class="m-0 mx-2 fs-5"><?php echo $row["location"]; ?></p>
                </div>
                <div class="d-flex align-items-center">
                  <i class="bi bi-clock fs-4 violetColor"></i>
                  <p class="m-0 mx-2 fs-5"><?php echo $row["peroid_from"]; ?> - <?php echo $row["peroid_to"]; ?></p>
                </div>
              </div>
            <?php
              }
            } else{
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>W tym miejscu wyświetlą się doświadczenia.</p>";
            }
            ?>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Wykształcenie</h4>
            <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold" data-bs-toggle="modal" data-bs-target="#educationModal"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
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
                  <h4 class="fw-semibold"><?php echo $row["school_name"]; ?></h4>
                  <div class="d-flex ms-auto gap-4">
                    <a href="#" class="fw-bold text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#educationModal" onclick="EditEducation('<?php echo $education_id; ?>', '<?php echo $school_name; ?>', '<?php echo $education_level; ?>' , '<?php echo $major; ?>', '<?php echo $school_adress ?>', '<?php echo $peroid_from ?>', '<?php echo $peroid_to ?>')"><span class="bi bi-pencil-fill fs-6 me-2 violetColor"></span>Edytuj</a>
                    <a href="#" class="fw-bold text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#decisionModal" onclick="SetDeleteData('<?php echo $education_id; ?>', 'educationDeleteForm', 'education')"><span class="bi bi-trash3-fill fs-6 me-2 violetColor"></span>Usuń</a>
                  </div>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-bar-chart fs-4 violetColor"></i>
                  <p class="m-0 mx-2 fs-5"><?php echo $row["education_level"]; ?></p>
                </div>
                <div class="d-flex align-items-centermb-2">
                  <i class="bi bi-mortarboard-fill fs-4 violetColor"></i>
                  <p class="m-0 mx-2 fs-5"><?php echo $row["major"]; ?></p>
                </div>
                <div class="d-flex align-items-centermb-2">
                  <i class="bi bi-geo-alt fs-4 violetColor"></i>
                  <p class="m-0 mx-2 fs-5"><?php echo $row["location"]; ?></p>
                </div>
                <div class="d-flex align-items-center">
                  <i class="bi bi-clock fs-4 violetColor"></i>
                  <p class="m-0 mx-2 fs-5"><?php echo $row["peroid_from"]; ?> - <?php echo $row["peroid_to"]; ?></p>
                </div>
              </div>
            <?php
              }
            } else{
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>W tym miejscu wyświetlą się wykształcenia.</p>";
            }
            ?>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Kursy, szkolenia, certyfikaty</h4>
            <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
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
                  <h4 class="fw-semibold"><?php echo $row["name"]; ?></h4>
                  <div class="d-flex ms-auto gap-4">
                    <a href="#" class="fw-bold text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#experienceModal" onclick="EditExperience('<?php echo $experience_id; ?>', '<?php echo $position; ?>', '<?php echo $company_name; ?>' , '<?php echo $location; ?>', '<?php echo $peroid_from ?>', '<?php echo $peroid_to ?>')"><span class="bi bi-pencil-fill fs-6 me-2 violetColor"></span>Edytuj</a>
                    <a href="#" class="fw-bold text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#decisionModal" onclick="SetDeleteData('<?php echo $cert_id; ?>', 'certificateDeleteForm', 'certificate')"><span class="bi bi-trash3-fill fs-6 me-2 violetColor"></span>Usuń</a>
                  </div>
                </div>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-person fs-4 violetColor"></i>
                  <p class="m-0 mx-2 fs-5"><?php echo $row["organizer"]; ?></p>
                </div>
                <div class="d-flex align-items-center">
                  <i class="bi bi-clock fs-4 violetColor"></i>
                  <p class="m-0 mx-2 fs-5"><?php echo $row["peroid_from"]; ?> - <?php echo $row["peroid_to"]; ?></p>
                </div>
              </div>
            <?php
              }
            } else{
              echo "<h5 class='fw-bold m-0'>Brak danych</h5><p class='m-0'>W tym miejscu wyświetlą się Kursy, szkolenia lub certyfikaty.</p>";
            }
            ?>
          </div>
        </div>
        <div class="mt-5 mb-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Umiejętności</h4>
            <a href="#" class="ms-auto me-0 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
          </div>
          <div class="profileBox2">
            <?php
            if($skillsResult->num_rows > 0){
              while ($row = mysqli_fetch_assoc($skillsResult)) {
                $skill_id = $row["skill_id"];
            ?>
              <div class="d-flex">
                <div class="d-flex align-items-center mx-2 mt-2">
                  <i class="bi bi-star fs-2 violetColor"></i>
                  <p class="m-0 mx-3 fs-5"><?php echo $row['skill']; ?></p>
                </div>
                <a href="#" class="fw-bold ms-auto mx-2 text-decoration-none align-items-center violetColor d-flex" data-bs-toggle="modal" data-bs-target="#decisionModal" onclick="SetDeleteData('<?php echo $skill_id; ?>', 'skillDeleteForm', 'skill')"><span class="bi bi-trash3-fill fs-6 me-2 violetColor"></span>Usuń</a>
              </div>
            <?php
              }
            } else{
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
                          <input type="text" class="form-control adminInput" id="position" name="experience[]" placeholder="" maxlength="60" required>
                          <label>Stanowisko</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="company_name" name="experience[]" placeholder="" maxlength="60" required>
                          <label>Nazwa firmy</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="company_adress" name="experience[]" placeholder="" maxlength="60" required>
                          <label>Adres firmy</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="date" class="form-control adminInput" id="working_from" name="experience[]" placeholder="" maxlength="60" required>
                          <label>Okres zatrudnienia (od)</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="date" class="form-control adminInput" id="working_to" name="experience[]" placeholder="" maxlength="60" required>
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
                          <input type="text" class="form-control adminInput" id="school_name" name="education[]" placeholder="" maxlength="60" required>
                          <label>Nazwa szkoły</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="education_level" name="education[]" placeholder="" maxlength="60" required>
                          <label>Poziom wykształcenia</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="major" name="education[]" placeholder="" maxlength="60" required>
                          <label>Kierunek</label>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="school_adress" name="education[]" placeholder="" maxlength="60" required>
                          <label>Adres szkoły</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="date" class="form-control adminInput" id="studying_from" name="education[]" placeholder="" maxlength="60" required>
                          <label>Okres uczęszczania (od)</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="date" class="form-control adminInput" id="studying_to" name="education[]" placeholder="" maxlength="60" required>
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
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script>
    var deleteId;
    var deleteFromId;
    var dataType;

    function replaceParagraphsWithInputs() {
      var profileInfoData = document.querySelector('.profileInfoData');
      var paragraphs = profileInfoData.querySelectorAll('p');

      paragraphs.forEach(function(paragraph) {
        var input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('value', paragraph.textContent.trim());
        input.classList.add('form-control');
        paragraph.parentNode.replaceChild(input, paragraph);
      });
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

    var myModal = document.getElementsByClassName('modal');

    for (let i = 0; i < myModal.length-1; i++) {
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
  </script>
</body>

</html>