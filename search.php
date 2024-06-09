<?php
session_start();
require_once 'actions/connection.php';
require_once 'actions/getNavbarData.php';

$results_per_page = 3;

if (!isset($_GET['page']) || !is_numeric($_GET['page']) || $_GET['page'] < 1) {
  $page = 1;
} else {
  $page = intval($_GET['page']);
}

$offset = ($page - 1) * $results_per_page;

$job_position = isset($_GET['job_position']) ? $_GET['job_position'] : '';
$location = isset($_GET['adress']) ? $_GET['adress'] : '';
$selected_categories = isset($_GET['category']) ? $_GET['category'] : array();
//$selected_companies = isset($_GET['company']) ? $_GET['company'] : array();
$filters_position = isset($_GET['position']) ? $_GET['position'] : array();
$filters_contract = isset($_GET['contract']) ? $_GET['contract'] : array();
$filters_jobtype = isset($_GET['jobtype']) ? $_GET['jobtype'] : array();
$filters_worktime = isset($_GET['worktime']) ? $_GET['worktime'] : array();

$searchSql = "SELECT COUNT(*) as total FROM `offer` INNER JOIN company USING(company_id) INNER JOIN category USING(category_id) WHERE 1=1";

if (!empty($job_position)) {
  $keywords = preg_split('/\W+/', $job_position, -1, PREG_SPLIT_NO_EMPTY);
  $searchConditions = [];
  foreach ($keywords as $keyword) {
    $escapedKeyword = $conn->real_escape_string($keyword);
    $searchConditions[] = "(position_name LIKE '%" . $escapedKeyword . "%' OR company_name LIKE '%" . $escapedKeyword . "%')";
  }
  $searchSql .= " AND " . implode(' AND ', $searchConditions);
}
if (!empty($selected_categories)) {
  $searchSql .= " AND category_name IN ('" . implode("','", $selected_categories) . "')";
}
// if (!empty($selected_companies)) {
//   $searchSql .= " AND company_name IN ('" . implode("','", $selected_companies) . "')";
// }
if (!empty($location)) {
  $searchSql .= " AND adress LIKE '%" . $conn->real_escape_string($location) . "%'";
}
if (!empty($filters_position)) {
  $searchSql .= " AND position_level IN ('" . implode("','", $filters_position) . "')";
}
if (!empty($filters_contract)) {
  $searchSql .= " AND contract_type IN ('" . implode("','", $filters_contract) . "')";
}
if (!empty($filters_jobtype)) {
  $searchSql .= " AND job_type IN ('" . implode("','", $filters_jobtype) . "')";
}
if (!empty($filters_worktime)) {
  $searchSql .= " AND working_time IN ('" . implode("','", $filters_worktime) . "')";
}

$total_result = $conn->query($searchSql)->fetch_assoc()['total'];
$total_pages = ceil($total_result / $results_per_page);
$searchSql = str_replace('COUNT(*) as total', '*', $searchSql) . " LIMIT $offset, $results_per_page";
$searchResult = $conn->query($searchSql);


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
      <a class="navbar-brand" href="index.php"><img src="imgs/UI/logo.png" width="120px"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php">Strona główna</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">Oferty pracy</a>
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
  <div class="bottom-menu z-1" style="<?php if ($_SESSION['isadmin'] == 1) echo 'gap: 12%;';
                                      else echo 'gap: 19%;'; ?>">
    <a href="index.php" class="text-center text-decoration-none menuIconDiv">
      <i class="bi bi-house-fill menuIcon fs-2"></i>
      <p class="m-0 menuIconText">Home</p>
    </a>
    <a href="#" class="text-center text-decoration-none menuIconDiv menuIconClicked">
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
  <div class="container">
    <div class="row">
      <div class="col-12 mb-4">
        <form method="get">
          <div class="searchBox d-flex justify-content-center align-items-center gap-2 mt-5">
            <div class="row inputsRow d-flex justify-content-center w-100">
              <div class="col-12 col-lg-4">
                <div class="form-floating">
                  <input type="text" class="form-control rounded-3" name="job_position" placeholder="" maxlength="60" value="<?php echo $job_position; ?>">
                  <label>Stanowisko, firma</label>
                </div>
              </div>
              <div class="col-12 col-lg-3">
                <div class="form-floating position-relative">
                  <span class="form-control truncate rounded-3" id="categorySpan" placeholder="" onclick="ShowHiddenDiv('categorySelectDiv','categorySpan')">Wybierz</span>
                  <div class="hidden-div" id="categorySelectDiv">
                    <ul class="list-group">
                      <?php
                      foreach ($categoriesResult as $row) {
                        $isChecked = in_array($row["category_name"], $selected_categories) ? 'checked' : '';
                      ?>
                        <li class="list-group-item">
                          <input class="form-check-input me-1 checkCategory" type="checkbox" value="<?php echo $row["category_name"]; ?>" id="<?php echo $row["category_name"]; ?>" name="category[]" onchange="UpdateSpanValue('categorySpan','.checkCategory')" <?php echo $isChecked; ?>>
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
                  <input type="text" class="form-control rounded-3" name="adress" placeholder="" maxlength="60" value="<?php echo $location; ?>">
                  <label>Lokalizacja</label>
                </div>
              </div>
              <div class="col-12 col-lg-2 d-flex align-items-center justify-content-center">
                <input type="submit" class="btn violetButtons">
              </div>
            </div>
          </div>
      </div>
      <div class="col-4 filtersCol">
        <div class="filtersBox mb-3">
          <h5 class="fw-bold mb-2">Poziom stanowiska</h5>
          <?php
          foreach ($positionTypes as $item) {
            $isChecked = in_array($item, $filters_position) ? 'checked' : '';
          ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="<?php echo $item; ?>" id="<?php echo $item; ?>" <?php echo $isChecked; ?> name="position[]">
              <label class="form-check-label" for="<?php echo $item; ?>">
                <?php echo $item; ?>
              </label>
            </div>
          <?php } ?>
          <h5 class="fw-bold mb-2 mt-5">Rodzaj umowy</h5>
          <?php
          foreach ($contractTypes as $item) {
            $isChecked = in_array($item, $filters_contract) ? 'checked' : '';
          ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="<?php echo $item; ?>" id="<?php echo $item; ?>" <?php echo $isChecked; ?> name="contract[]">
              <label class="form-check-label" for="<?php echo $item; ?>">
                <?php echo $item; ?>
              </label>
            </div>
          <?php } ?>
          <h5 class="fw-bold mb-2 mt-5">Tryb pracy</h5>
          <?php
          foreach ($jobTypes as $item) {
            $isChecked = in_array($item, $filters_jobtype) ? 'checked' : '';
          ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="<?php echo $item; ?>" id="<?php echo $item; ?>" <?php echo $isChecked; ?> name="jobtype[]">
              <label class="form-check-label" for="<?php echo $item; ?>">
                <?php echo $item; ?>
              </label>
            </div>
          <?php } ?>
          <h5 class="fw-bold mb-2 mt-5">Wymiar pracy</h5>
          <?php
          foreach ($workingTypes as $item) {
            $isChecked = in_array($item, $filters_worktime) ? 'checked' : '';
          ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="<?php echo $item; ?>" id="<?php echo $item; ?>" <?php echo $isChecked; ?> name="worktime[]">
              <label class="form-check-label" for="<?php echo $item; ?>">
                <?php echo $item; ?>
              </label>
            </div>
          <?php } ?>
        </div>
        </form>
      </div>
      <div class="col-lg-8 d-flex flex-column align-items-center gap-4">
        <p class="align-self-start mt-3 m-0">Znalezione ogłoszenia: <?php echo $searchResult->num_rows; ?></p>
        <?php
        if ($searchResult->num_rows > 0) {
          while ($row = mysqli_fetch_assoc($searchResult)) {
        ?>
            <a href="offers/offer.php?id=<?php echo $row["offer_id"]; ?>" class="text-decoration-none text-dark w-100 offerBox">
              <div>
                <div class="row">
                  <div class="col-lg-2 square-container" id="searchOfferImage">
                    <img src="<?php echo $row["logo_src"]; ?>" class="square-image p-2">
                  </div>
                  <div class="col-lg-10">
                    <div class="row">
                      <div class="col-11">
                        <h5 class="fw-semibold mb-0"><?php echo $row["position_name"]; ?></h5>
                        <p class="fw-sedmibold"><?php echo $row["company_name"]; ?></p>
                      </div>
                      <div class="col-1 d-flex justify-content-center">
                        <i class="bi bi-star fs-4"></i>
                      </div>
                      <div class="col-11 d-flex gap-4">
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
          <?php  } ?>
          <nav class="mt-5">
            <ul class="pagination">
              <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, array("page" => ($page <= 1) ? 1 : ($page - 1)))); ?>">Previous</a>
              </li>
              <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                  <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, array("page" => $i))); ?>"><?php echo $i; ?></a>
                </li>
              <?php endfor; ?>
              <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, array("page" => ($page >= $total_pages) ? $total_pages : ($page + 1)))); ?>">Next</a>
              </li>
            </ul>
          </nav>
        <?php  } else { ?>
          <div class="d-flex flex-column align-items-center mt-5">
            <img src="imgs/ui/no-results.png" width="200">
            <div class="d-flex flex-column mt-4">
              <h2 class="fw-semibold m-0">Nie znaleziono ogłoszeń</h2>
              <p class="m-0 text-center">Spróbuj ponownie później lub wyczyść filtry.</p>
              <a href="search.php" class="btn text-center align-self-center bg-violet p-2 mt-4 text-decoration-none text-light text-uppercase rounded-3 fs-6 fw-semibold w-50">Wyczyść filtry</a>
            </div>
          </div>
        <?php  } ?>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      UpdateSpanValue('categorySpan', '.checkCategory');
      UpdateSpanValue('companySpan', '.checkCompany');
    });
  </script>
  <script src="script.js"></script>
</body>

</html>