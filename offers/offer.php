<?php
session_start();
require_once '../actions/connection.php';
require_once '../actions/getNavbarData.php';
$offerID = $_GET['id'];
$userID = $_SESSION['user_id'];
$profile_id = $_SESSION['profile_id'];

$benefitsResult = $conn->query("SELECT * FROM `offer_benefits` WHERE offer_id='$offerID';");
$requirementsResult = $conn->query("SELECT * FROM `offer_requirements` WHERE offer_id='$offerID';");
$dutiesResult = $conn->query("SELECT * FROM `offer_duties` WHERE offer_id='$offerID';");
$offerResult = $conn->query("SELECT * FROM `offer` INNER JOIN company USING(company_id) INNER JOIN category USING(category_id) WHERE offer_id='$offerID';");

if ($offerResult->num_rows > 0) {
  $row = mysqli_fetch_assoc($offerResult);
  $nazwaStanowiska = $row['position_name'];
  $nazwaFirmy = $row['company_name'];
  $logoSrc = $row['logo_src'];
  $poziomStanoiwka = $row['position_level'];
  $typUmowy = $row['contract_type'];
  $wymiarZatrudnienia = $row['working_time'];
  $typPracy = $row['job_type'];
  $dniPracy = $row['working_days'];
  $godzinyPracy = $row['working_hours'];
  $wynagrodzenie = $row['salary'];
  $dataWygasania = $row['expiration_date'];
  $adres = explode(":", $row['adress'], 2);
  $opisFirmy = $row['information'];
  $googleMapsUrl = $row['gmaps_url'];
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
  <link rel="stylesheet" href="../css/style_offer.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <title>Document</title>
</head>

<body>
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
                    <a href="../user/profile.php" class="text-decoration-none">
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
  <div class="container">
    <div class="row">
      <div class="col-12 mt-5">
        <div class="titleBox d-flex justify-content-center">
          <div class="row" style="width: 95%; height: 100%;">
            <div class="col-sm-12 col-lg-2 d-flex justify-content-center align-items-center">
              <img src="../<?php echo $logoSrc; ?>" width="110" class="offerImg">
            </div>
            <div class="col-lg-8 col-10 d-flex justify-content-start align-items-center">
              <div class="row">
                <div class="col-12">
                  <h4><?php echo $nazwaStanowiska; ?></h4>
                </div>
                <div class="col-12">
                  <h5 class="titleBoxCompany"><?php echo $nazwaFirmy; ?></h5>
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-2 d-flex justify-content-center align-items-center">
              <?php if (isset($_SESSION['logged_in'])) { ?>
                <i class="bi bi-star favoriteIcon" id="starIcon"></i>
              <?php } else { ?>
                <i class="bi bi-star favoriteIcon opacity-50" id="liveToastBtn"></i>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-lg-8 mt-5">
        <div class="row">
          <div class="col-12 ">
            <div class="jobDetailsBox">
              <h3 class="text-center mb-5 fw-semibold">Szczegóły oferty</h3>
              <div class="row d-flex justify-content-center p-lg-3 p-xl-0">
                <div class="col-lg-6 d-flex justify-content-center">
                  <div>
                    <div class="jobDetailsIcon d-flex align-items-center">
                      <i class="bi bi-bar-chart violetColor fs-1 mx-3"></i>
                      <p class="violetColor fw-semibold mx-1 m-0 jobDetailFontSize"><?php echo $poziomStanoiwka; ?></p>
                    </div>
                    <div class="jobDetailsIcon d-flex align-items-center">
                      <i class="bi bi-file-earmark-text-fill violetColor fs-1 mx-3"></i>
                      <p class="violetColor fw-semibold mx-1 m-0 jobDetailFontSize"><?php echo $typUmowy; ?></p>
                    </div>
                    <div class="jobDetailsIcon d-flex align-items-center">
                      <i class="bi bi-clock violetColor fs-1 mx-3"></i>
                      <p class="violetColor fw-semibold mx-1 m-0 jobDetailFontSize"><?php echo $wymiarZatrudnienia; ?></p>
                    </div>
                    <div class="jobDetailsIcon d-flex align-items-center">
                      <i class="bi bi-briefcase-fill violetColor fs-1 mx-3"></i>
                      <p class="violetColor fw-semibold mx-1 m-0 jobDetailFontSize"><?php echo $typPracy; ?></p>
                    </div>
                    <div class="jobDetailsIcon d-flex align-items-center">
                      <i class="bi bi-calendar4-week violetColor fs-1 mx-3"></i>
                      <div>
                        <p class="violetColor fw-semibold mx-1 m-0 jobDetailFontSize"><?php echo $dniPracy; ?></p>
                        <p class="mx-1 m-0 fw-regular jobDetailsIconHours"><?php echo $godzinyPracy; ?></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-center order-first order-md-last secondCol">
                  <div>
                    <?php if ($wynagrodzenie != null) { ?>
                      <div class="jobDetailsIcon d-flex align-items-center">
                        <i class="bi bi-currency-exchange violetColor fs-1 mx-3"></i>
                        <div>
                          <h5 class="violetColor fw-bold mx-1 m-0"><?php echo $wynagrodzenie; ?> zł</h5>
                          <p class="mx-1 m-0 fw-regular jobDetailsIconHours">brutto / miesięcznie</p>
                        </div>
                      </div>
                    <?php } ?>
                    <div class="jobDetailsIcon d-flex align-items-center">
                      <i class="bi bi-hourglass-split violetColor fs-1 mx-3"></i>
                      <h6 class="violetColor fw-semibold mx-1 m-0">Ważne do: <?php echo $dataWygasania; ?></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php if ($dutiesResult->num_rows > 0) { ?>
            <div class="col-12 mt-5">
              <div class="jobDetailsBox">
                <h3 class="text-center mb-4 fw-semibold">Zakres obowiązków</h3>
                <?php
                while ($row = mysqli_fetch_assoc($dutiesResult)) {
                ?>
                  <div class="d-flex align-items-center gap-2 mt-3">
                    <i class="bi bi-check2-circle"></i>
                    <p class="jobDetailFontSize m-0"><?php echo $row['duty']; ?></p>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php }
          if ($requirementsResult->num_rows > 0) { ?>
            <div class="col-12 mt-5">
              <div class="jobDetailsBox">
                <h3 class="text-center mb-4 fw-semibold">Wymagania</h3>
                <?php
                while ($row = mysqli_fetch_assoc($requirementsResult)) {
                ?>
                  <div class="d-flex align-items-center gap-2 mt-3">
                    <i class="bi bi-check2-circle"></i>
                    <p class="jobDetailFontSize m-0"><?php echo $row['requirement']; ?></p>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php }
          if ($benefitsResult->num_rows > 0) { ?>
            <div class="col-12 mt-5 mb-5">
              <div class="jobDetailsBox">
                <h3 class="text-center jobDetailsTitle">Co oferujemy</h3>
                <?php
                while ($row = mysqli_fetch_assoc($benefitsResult)) {
                ?>
                  <div class="d-flex justify-content-center benefitContainer">
                    <div class="benefitBox d-flex align-items-center gap-3 w-100 p-1 mt-4">
                      <i class="bi bi-star-fill benefitIcon"></i>
                      <p><?php echo $row['benefit']; ?></p>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="col-12 col-lg-4 mt-5 order-first order-lg-last">
        <div class="row">
          <div class="col-12">
            <div class="jobDetailsBox2 p-4 applyBottom">
              <h5 class="text-center mb-4 applyText">Podoba Ci się ta oferta?</h5>
              <?php if (isset($_SESSION['logged_in'])) { ?>
                <form method="post" action="../actions/sendData.php">
                  <input type="hidden" name="applicationForm" value="true">
                  <input type="hidden" name="isEdit" value="false" id="isEdit">
                  <input type="hidden" value="<?php echo $offerID; ?>" name="offer_id">
                  <input type="hidden" value="<?php echo $profile_id; ?>" name="profile_id">
                  <div class="d-flex justify-content-center">
                    <input type="submit" class="btn applyButton d-flex justify-content-center align-items-center" value="Aplikuj">
                  </div>
                </form>
              <?php } else { ?>
                <a class="d-flex justify-content-center opacity-50" id="liveToastBtn2">
                  <p class="applyButton d-flex justify-content-center align-items-center">Aplikuj</p>
                </a>
              <?php } ?>
            </div>
          </div>
          <div class="col-12 mt-4">
            <div class="jobDetailsBox2">
              <div class="d-flex align-items-center justify-content-center gap-2 mt-3 mb-2">
                <i class="bi bi-geo-alt-fill"></i>
                <div class="locationDiv">
                  <h5><?php echo trim($adres[0]); ?></h5>
                  <h6><?php echo trim($adres[1]); ?></h6>
                </div>
              </div>
              <iframe src="<?php echo $googleMapsUrl; ?>" width="100%" height="250" style="border:0; border-radius: 30px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
          <div class="col-12 mt-4">
            <div class="jobDetailsBox2 p-4">
              <h5 class="text-center mb-3 mt-2 fw-semibold">Więcej o firmie</h5>
              <p class=""><?php echo $opisFirmy; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header toastViolet text-light">
        <strong class="me-auto">JobPortal</strong>
        <i class="bi bi-x-lg" data-bs-dismiss="toast" aria-label="Close"></i>
      </div>
      <div class="toast-body">
        Zaloguj się aby skorzystać z tej funkcji
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script>
    var starIcon = document.getElementById("starIcon");
    var isFavorite;
    var uID;
    var oID;

    <?php
    $favoriteResult = $conn->query("SELECT * FROM `user_favourites` WHERE user_id='$userID' AND offer_id='$offerID';");
    if ($favoriteResult->num_rows > 0) {
      echo "starIcon.className = 'bi bi-star-fill favoriteIcon'; isFavorite = true; uID='$userID'; oID='$offerID';";
    } else {
      echo "starIcon.className = 'bi bi-star favoriteIcon'; isFavorite = false; uID='$userID'; oID='$offerID';";
    }
    ?>

    starIcon.addEventListener("click", function() {
      if (isFavorite) {
        starIcon.className = "bi bi-star favoriteIcon";
        window.location.href = "../actions/actionFavorite.php?oid=" + oID + "&action=remove";
      } else {
        starIcon.className = "bi bi-star-fill favoriteIcon";
        window.location.href = "../actions/actionFavorite.php?oid=" + oID + "&action=add";
      }
    });
  </script>
  <script>
    var liveToastBtn = document.getElementById('liveToastBtn');
    var liveToastBtn2 = document.getElementById('liveToastBtn2');
    var liveToast = new bootstrap.Toast(document.getElementById('liveToast'));
    liveToastBtn.addEventListener('click', function() {
      liveToast.show();
    });
    liveToastBtn2.addEventListener('click', function() {
      liveToast.show();
    });
  </script>
</body>

</html>