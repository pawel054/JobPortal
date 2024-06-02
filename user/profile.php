<?php
session_start();
require_once '../actions/connection.php';

$userID = $_SESSION['user_id'];
$email = $_SESSION['email'];
$contentType = null;

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  echo $contentType;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
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
            <a href="#" style="visibility: collapse;" class="text-light ms-auto mx-2 fs-5 profileBtnLink profileInfoTitle align-items-center d-flex" id="dataCancel"><span class="bi bi-x-lg profileIcon me-2"></span><span class="actionText">Anuluj</span></a>
            <a href="#" onclick="replaceParagraphsWithInputs()" class="text-light ms-auto me-4 fs-5 profileBtnLink profileInfoTitle align-items-center d-flex"><span class="bi bi-pencil-fill profileIcon me-2"></span><span class="actionText">Edytuj</span></a>
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
            <a href="#" class="ms-auto me-3 fs-6 profileBtnLink px-3 pe-3 rounded-5 align-items-center d-flex fw-semibold"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
            <a href="#" class=" fs-6 fw-semibold profileBtnLink px-3 pe-3 rounded-5 align-items-center d-flex"><span class="bi bi-pencil-fill fs-6 me-2"></span>Edytuj</a>
          </div>
          <div class="profileBox2">
            <h4 class="fs-3 fw-bold mx-4 mt-4"><?php echo $jobPosition; ?></h4>
            <p class="mx-4 mb-1"><?php echo $jobPositionDesc; ?></p>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Języki</h4>
            <a href="#" class="ms-auto me-3 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
            <a href="#" class=" fs-6 fw-semibold profileBtnLink px-3 pe-3 rounded-5 align-items-center d-flex"><span class="bi bi-pencil-fill fs-6 me-2"></span>Edytuj</a>
          </div>
          <div class="profileBox2">
            <?php while ($row = mysqli_fetch_assoc($languageResult)) { ?>
              <div class="d-flex align-items-center mx-4 mt-2">
                <i class="bi bi-globe-americas fs-2 violetColor"></i>
                <p class="m-0 mx-3 fs-5"><?php echo $row['language']; ?> <span class="linkMark"><?php echo $row['level']; ?></span></p>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-lg-7 secondCol">
        <div>
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Podsumowanie zawodowe</h4>
            <a href="#" class="ms-auto me-3 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
            <a href="#" class=" fs-6 fw-semibold profileBtnLink px-3 pe-3 rounded-5 align-items-center d-flex"><span class="bi bi-pencil-fill fs-6 me-2"></span>Edytuj</a>
          </div>
          <div class="profileBox2">
            <p class="mx-4 mb-1"><?php echo $careerSummary; ?></p>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Doświadczenie zawodowe</h4>
            <a href="#" class="ms-auto me-3 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModal"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
          </div>
          <div class="profileBox2">
            <?php
            while ($row = mysqli_fetch_assoc($experienceResult)) {
            ?>
              <div class="pb-3">
                <div class="d-flex">
                  <h4 class="fw-semibold"><?php echo $row["position"]; ?></h4>
                  <div class="d-flex ms-auto gap-4">
                    <a href="#" class="fw-bold text-decoration-none align-items-center violetColor d-flex"><span class="bi bi-pencil-fill fs-6 me-2 violetColor"></span>Edytuj</a>
                    <a href="#" class="fw-bold text-decoration-none align-items-center violetColor d-flex"><span class="bi bi-trash3-fill fs-6 me-2 violetColor"></span>Usuń</a>
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
            <?php } ?>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Wykształcenie</h4>
            <a href="#" class="ms-auto me-3 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
            <a href="#" class=" fs-6 fw-semibold profileBtnLink px-3 pe-3 rounded-5 align-items-center d-flex"><span class="bi bi-pencil-fill fs-6 me-2"></span>Edytuj</a>
          </div>
          <div class="profileBox2">
            <h4 class="fs-3 fw-bold mx-4">Nazwa szkoły</h4>
            <div class="d-flex align-items-center mx-4 mb-2">
              <i class="bi bi-bar-chart fs-4 violetColor"></i>
              <p class="m-0 mx-2 fs-5">Poziom Wykształcenie</p>
            </div>
            <div class="d-flex align-items-center mx-4 mb-2">
              <i class="bi bi-mortarboard-fill fs-4 violetColor"></i>
              <p class="m-0 mx-2 fs-5">Kierunek</p>
            </div>
            <div class="d-flex align-items-center mx-4 mb-2">
              <i class="bi bi-geo-alt fs-4 violetColor"></i>
              <p class="m-0 mx-2 fs-5">Miejscowość</p>
            </div>
            <div class="d-flex align-items-center mx-4">
              <i class="bi bi-clock fs-4 violetColor"></i>
              <p class="m-0 mx-2 fs-5">okres nauki</p>
            </div>
          </div>
        </div>
        <div class="mt-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Kursy, szkolenia, certyfikaty</h4>
            <a href="#" class="ms-auto me-3 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
            <a href="#" class=" fs-6 fw-semibold profileBtnLink px-3 pe-3 rounded-5 align-items-center d-flex"><span class="bi bi-pencil-fill fs-6 me-2"></span>Edytuj</a>
          </div>
          <div class="profileBox2">
            <h4 class="fs-3 fw-bold mx-4 mt-4">Nazwa kursu</h4>
            <div class="d-flex align-items-center mx-4 mb-2">
              <i class="bi bi-person fs-4 violetColor"></i>
              <p class="m-0 mx-2 fs-5">Ogranizator</p>
            </div>
            <div class="d-flex align-items-center mx-4">
              <i class="bi bi-clock fs-4 violetColor"></i>
              <p class="m-0 mx-2 fs-5">okres nauki</p>
            </div>
          </div>
        </div>
        <div class="mt-5 mb-5">
          <div class="d-flex mb-3 align-items-center">
            <h4 class="align-items-center d-flex fw-regular m-0">Umiejętności</h4>
            <a href="#" class="ms-auto me-3 fs-6 profileBtnLink px-3 pe-3  rounded-5 align-items-center d-flex fw-semibold"><span class="bi bi-plus-lg me-2 fs-5 fw-semibold"></span>Dodaj</a>
            <a href="#" class=" fs-6 fw-semibold profileBtnLink px-3 pe-3 rounded-5 align-items-center d-flex"><span class="bi bi-pencil-fill fs-6 me-2"></span>Edytuj</a>
          </div>
          <div class="profileBox2">
            <div class="d-flex align-items-center mx-4 mt-2">
              <i class="bi bi-star fs-2 violetColor"></i>
              <p class="m-0 mx-3 fs-5">Umiejętność1</p>
            </div>
            <div class="d-flex align-items-center mx-4 mt-2">
              <i class="bi bi-star fs-2 violetColor"></i>
              <p class="m-0 mx-3 fs-5">Umiejętność2</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Doświadczenie zawodowe</h4>
            <button type="button" onclick="AddExtraInput2('testDiv2')" class="btn violetButtonsDropdown rounded-4 mx-3 align-self-center">
              <i class="bi bi-plus-lg text-white me-2"></i>Dodaj
            </button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-2">
            <form method="post" action="../actions/profileData.php">
              <input type="hidden" name="experienceForm" value="true" id="experienceForm">
              <input type="hidden" name="isEdit" value="false" id="isEdit">
              <div class="container">
                <div id="testDiv2">
                  <div class="d-flex flex-column justify-content-center mt-3" id="divvvv2">
                    <div class="m-0 d-flex justify-content-between">
                      <p class="m-0 violetColor fw-semibold">Nowe doświadczenie</p>
                      <p class="m-0 violetColor fw-semibold"><i class="bi bi-trash3-fill me-1"></i>Usuń</p>
                    </div>
                    <hr class="violetHr m-0">
                    <div class="row mt-4">
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control adminInput" id="stanowisko" name="experience[]" placeholder="" maxlength="60" required>
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
                          <input type="date" class="form-control adminInput" id="working_time" name="experience[]" placeholder="" maxlength="60" required>
                          <label>Okres zatrudnienia (od)</label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-floating mb-3">
                          <input type="date" class="form-control adminInput" id="working_time" name="experience[]" placeholder="" maxlength="60" required>
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
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script>
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

    function AddExtraInput2(divContainer) {
      var urlsDiv = document.getElementById(divContainer);
      var template = document.getElementById("divvvv2");

      var newExperience = template.cloneNode(true);
      newExperience.style.display = "block";

      var inputs = newExperience.querySelectorAll('input');
      inputs.forEach(function(input) {
        input.value = '';
      });

      var deleteButton = newExperience.querySelector("p.violetColor.fw-semibold:last-child");
      deleteButton.style.cursor = "pointer";
      deleteButton.onclick = function() {
        newExperience.remove();
      };

      urlsDiv.appendChild(newExperience);
    }
  </script>
</body>

</html>