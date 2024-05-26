<?php
session_start();
require_once 'actions/connection.php';
$offersResult = $conn->query("SELECT * FROM `offer` INNER JOIN company USING(company_id) INNER JOIN category USING(category_id);");
$categoriesResult = $conn->query("SELECT * FROM `category`;");
$companiesResult = $conn->query("SELECT * FROM `company`;");

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
                  <img src="imgs/UI/login_user.png" class="rounded-circle" width="50px">
                  <p class="kontoDescription m-auto ms-3"><?php DisplayShortText($_SESSION['email'], 20) ?></p>
                </div>
                <hr class="w-100">
              </div>
              <?php if ($_SESSION['isadmin'] == 1) { ?>
                <div class="p-1 dropdownElement">
                  <a href="admin/index.php" class="text-decoration-none">
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
                    <input class="form-control" type="text" placeholder="Lokalizacja" id="lokalizacjaInput" name="location">
                    <label for="lokalizacjaInput">Lokalizacja</label>
                  </div>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-12 col-lg-4 d-flex justify-content-center">
                  <button type="button" class="btn coloredFont" data-bs-toggle="modal" data-bs-target="#exampleModal">Filtry Zaawansowane</button>
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
                            <input class="form-check-input" type="checkbox" value="<?php echo $item; ?>" id="<?php echo $item; ?>" name="contact[]">
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
              <h5 class="fw-bolder"><?php DisplayShortText($row["position_name"],45); ?></h5>
            </div>
            <div class="d-flex align-items-center gap-3">
              <div class="square-container">
                <img src="<?php echo $row["logo_src"]; ?>" class="square-image">
              </div>
              <div>
                <h6 class="m-0 fw-semibold"><?php DisplayShortText($row["company_name"],40); ?></h6>
                <p class="m-0"><?php DisplayShortText($row["category_name"],16); ?></p>
              </div>
            </div>
            <div class="d-flex gap-3 fw-semibold">
              <span class="bi bi-currency-exchange">
                <?php echo $row["salary"]; ?> zł
              </span>
              <span class="bi bi-geo-alt-fill">
                <?php $adress = explode(":", $row['adress'], 2); echo trim($adress[1]); ?>
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