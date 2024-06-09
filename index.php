<?php
session_start();
require_once 'actions/connection.php';
$userID = $_SESSION['user_id'];
$profile_id = $_SESSION['profile_id'];

$offersResult = $conn->query("SELECT * FROM `offer` INNER JOIN company USING(company_id) INNER JOIN category USING(category_id);");
$categoriesResult = $conn->query("SELECT * FROM `category`;");
$companiesResult = $conn->query("SELECT * FROM `company`;");
$favsResult = $conn->query("SELECT * FROM `user_favourites` INNER JOIN offer USING(offer_id) INNER JOIN company USING(company_id) WHERE user_id = '$userID';");
$applicationsResult = $conn->query("SELECT * FROM `user_applications` INNER JOIN offer USING(offer_id) INNER JOIN company USING(company_id) WHERE profile_id = '$profile_id';");

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
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <title>Strona głowna</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="imgs/UI/logo.png" width="120px"></a>
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
                    <a href="admin/index.php" class="text-decoration-none">
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
  <div class="bottom-menu z-1" style="<?php if ($_SESSION['isadmin'] == 1) echo 'gap: 12%;';
                                      else echo 'gap: 19%;'; ?>">
    <a href="#" class="text-center text-decoration-none menuIconDiv menuIconClicked">
      <i class="bi bi-house-fill menuIcon fs-2"></i>
      <p class="m-0 menuIconText">Home</p>
    </a>
    <a href="search.php" class="text-center text-decoration-none menuIconDiv">
      <i class="bi bi-search menuIcon fs-2"></i>
      <p class="m-0 menuIconText">Szukaj</p>
    </a>
    <a href="user/mobile_account.php" class="text-center text-decoration-none menuIconDiv">
      <i class="bi bi-person-fill menuIcon fs-2"></i>
      <p class="m-0 menuIconText">Konto</p>
    </a>
    <?php if ($_SESSION['isadmin'] == 1) { ?>
      <a href="admin/index.php" class="text-center text-decoration-none menuIconDiv">
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
                      <img src="<?php echo $row["logo_src"]; ?>" class="square-image p-2">
                    </div>
                    <div class="col-lg-10">
                      <div class="row">
                        <div class="col-12 d-flex">
                          <div>
                            <h6 class="fw-semibold mb-0"><?php echo $row["position_name"]; ?></h6>
                            <p class="fw-sedmibold"><?php echo $row["company_name"]; ?></p>
                          </div>
                          <form class="ms-auto align-self-start" method="post" action="actions/sendData.php">
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
                            <h6 class="m-0"><?php $adress = explode(":", $row['adress'], 2);
                                            echo trim($adress[1]); ?></h6>
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
                      <img src="<?php echo $row["logo_src"]; ?>" class="square-image p-2">
                    </div>
                    <div class="col-lg-10">
                      <div class="row">
                        <div class="col-12 d-flex">
                          <div>
                            <h6 class="fw-semibold mb-0"><?php echo $row["position_name"]; ?></h6>
                            <p class="fw-sedmibold"><?php echo $row["company_name"]; ?></p>
                          </div>
                          <form class="ms-auto align-self-start" method="post" action="actions/sendData.php">
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

  <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="settingsModalLabel">Ustawienia</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex">
            <i class="bi bi-pencil-fill"></i>
            <h6>Zmień hasło</h6>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid mainImageDiv d-flex align-items-center justify-content-center mb-5">
    <div class="row">
      <div class="col d-flex flex-column justify-content-center align-items-center">
        <h1 class="mb-3 align-self-start fw-semibold" id="mainTitle">Ponad <b class="violetColor">64 271</b> ofert pracy<br> czeka na Ciebie.</h1>
        <div class="mainSearch">
          <div class="mainSearchInputs w-100">
            <form action="search.php" method="GET">
              <div class="row inputsRow d-flex justify-content-center">
                <div class="col-12 col-lg-4">
                  <div class="form-floating">
                    <input class="form-control" type="text" placeholder="Stanowisko" id="stanowiskoInput" name="job_position">
                    <label for="stanowiskoInput">Stanowisko, firma</label>
                  </div>
                </div>
                <div class="col-12 col-lg-3">
                  <div class="form-floating position-relative text-start">
                    <span class="form-control truncate rounded-3" id="categorySpan" placeholder="" onclick="ShowHiddenDiv('categorySelectDiv','categorySpan')">Wybierz</span>
                    <div class="hidden-div" id="categorySelectDiv">
                      <ul class="list-group">
                        <?php
                        while ($row = mysqli_fetch_assoc($categoriesResult)) {
                        ?>
                          <li class="list-group-item">
                            <input class="form-check-input me-1 checkCategory" type="checkbox" value="<?php echo $row["category_name"]; ?>" id="<?php echo $row["category_name"]; ?>" name="category[]" onchange="UpdateSpanValue('categorySpan','.checkCategory')">
                            <label class="form-check-label" for="<?php echo $row["category_name"]; ?>"><?php echo $row["category_name"]; ?></label>
                          </li>
                        <?php } ?>
                      </ul>
                    </div>
                    <label>Kategoria</label>
                  </div>
                </div>
                <div class="col-12 col-lg-3">
                  <div class="form-floating">
                    <input class="form-control" type="text" placeholder="Lokalizacja" id="lokalizacjaInput" name="adress">
                    <label for="lokalizacjaInput">Lokalizacja</label>
                  </div>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-12 col-lg-4 d-flex justify-content-center">
                  <button type="button" class="btn coloredFont ms-lg-5" data-bs-toggle="modal" data-bs-target="#exampleModal">Filtry Zaawansowane</button>
                </div>
                <div class="col-12 col-lg-4">
                  <button class="btn violetButtons">Szukaj</button>
                </div>
                <div class="col-lg-4 col-sm-4 col-xl-4">
                </div>
              </div>
              <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title fw-semibold" id="exampleModalLabel">Filtry Zaawansowane</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="ClearModalCheckbox()"></button>
                    </div>
                    <div class="modal-body text-start">
                      <div class="kategoriaGroup">
                        <h5>Poziom stanowiska</h5>
                        <?php
                        foreach ($positionTypes as $item) {
                        ?>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?php echo $item; ?>" id="<?php echo $item; ?>" name="position[]">
                            <label class="form-check-label" for="<?php echo $item; ?>">
                              <?php echo $item; ?>
                            </label>
                          </div>
                        <?php } ?>
                      </div>
                      <div class="kategoriaGroup">
                        <h5>Rodzaj umowy</h5>
                        <?php
                        foreach ($contractTypes as $item) {
                        ?>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?php echo $item; ?>" id="<?php echo $item; ?>" name="contract[]">
                            <label class="form-check-label" for="<?php echo $item; ?>">
                              <?php echo $item; ?>
                            </label>
                          </div>
                        <?php } ?>
                      </div>
                      <div class="kategoriaGroup">
                        <h5>Tryb pracy</h5>
                        <?php
                        foreach ($jobTypes as $item) {
                        ?>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?php echo $item; ?>" id="<?php echo $item; ?>" name="jobtype[]">
                            <label class="form-check-label" for="<?php echo $item; ?>">
                              <?php echo $item; ?>
                            </label>
                          </div>
                        <?php } ?>
                      </div>
                      <div class="kategoriaGroup">
                        <h5>Wymiar pracy</h5>
                        <?php
                        foreach ($workingTypes as $item) {
                        ?>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?php echo $item; ?>" id="<?php echo $item; ?>" name="worktime[]">
                            <label class="form-check-label" for="<?php echo $item; ?>">
                              <?php echo $item; ?>
                            </label>
                          </div>
                        <?php } ?>
                      </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn modalExit" onclick="ClearModalCheckbox()">Wyczyść</button>
                      <button type="button" class="btn modalSave" data-bs-dismiss="modal">Zapisz</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <h1 class="text-center fw-bold">Najnowsze oferty</h1>
    <h5 class="text-center fw-normal mb-5">Przeglądaj najnowsze oferty pracy i znajdź idealne zatrudnienie. Aplikuj już dziś!</h5>
    <div class="row">
      <?php
      while ($row = mysqli_fetch_assoc($offersResult)) {
      ?>
        <div class="col-12 col-lg-6 col-xl-4 d-flex justify-content-center mb-4">
          <a class="offerBox" href="offers/offer.php?id=<?php echo $row['offer_id'] ?>">
            <div style="height: 60px;">
              <h5 class="fw-bolder"><?php DisplayShortText($row["position_name"], 45); ?></h5>
            </div>
            <div class="d-flex align-items-center gap-3">
              <div class="square-container">
                <img src="<?php echo $row["logo_src"]; ?>" class="square-image">
              </div>
              <div>
                <h6 class="m-0 fw-semibold"><?php DisplayShortText($row["company_name"], 40); ?></h6>
                <p class="m-0"><?php DisplayShortText($row["category_name"], 16); ?></p>
              </div>
            </div>
            <div class="d-flex gap-3 fw-semibold">
              <span class="bi bi-currency-exchange">
                <?php echo $row["salary"]; ?> zł
              </span>
              <span class="bi bi-geo-alt-fill">
                <?php $adress = explode(":", $row['adress'], 2);
                echo trim($adress[1]); ?>
              </span>
            </div>
          </a>
        </div>
      <?php } ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="script.js"></script>
  <script>
    function ClearModalCheckbox() {
      var myModal = document.getElementById('exampleModal');
      var checkboxes = myModal.querySelectorAll('input[type="checkbox"]');
      checkboxes.forEach(function(checkbox) {
        checkbox.checked = false;
      });
    }
  </script>
</body>

</html>