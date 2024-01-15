<?php
    session_start();
    require_once '../actions/connection.php';
    $offerID = $_GET['id'];
    $userID = $_SESSION['user_id'];

    $benefitsResult = $conn->query("SELECT * FROM `offer_benefits` WHERE offer_id='$offerID';");
    $requirementsResult = $conn->query("SELECT * FROM `offer_requirements` WHERE offer_id='$offerID';");
    $dutiesResult = $conn->query("SELECT * FROM `offer_duties` WHERE offer_id='$offerID';");
    $offerResult = $conn->query("SELECT * FROM `offer` INNER JOIN company USING(company_id) INNER JOIN category USING(category_id) WHERE offer_id='$offerID';");
    
    if($offerResult->num_rows > 0){
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
              <div class="dropdown ms-auto ">
                <button type="button" class="btn violetButtonsDropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                  Konto
                </button>
            <div class="dropdown-menu p-4 dropdownLogowanie">
              <?php if(isset($_SESSION['logged_in'])){ ?>
                <div class="mb-4">
                <h4 class="kontoTitle">Moje konto</h4>
                <p class="kontoDescription"><?php echo $_SESSION['email']; ?></p>
              </div>
              <?php if($_SESSION['isadmin']==1){ ?>
              <div class="mb-3 d-flex justify-content-center align-items-center">
                <a href="../user/login.php"><button class="btn violetButtonsFrame">Panel administratora</button></a>
              </div>
              <?php } ?>
              <div class="mb-3 d-flex justify-content-center align-items-center">
                <a href="../user/login.php"><button class="btn violetButtonsFrame">Profil użytkownika</button></a>
              </div>
              <div class="mb-3 d-flex justify-content-center align-items-center">
                <a href="../user/offers.html"><button class="btn violetButtonsFrame">Zapisane oferty</button></a>
              </div>
              <div class="mb-1 d-flex justify-content-center align-items-center">
                <a href="actions/actionLogout.php"><button class="btn violetButtons">Wyloguj</button></a>
              </div>
                <?php }else{?>
              <div class="mb-4">
                <h4 class="kontoTitle">Witaj w JobPortal!</h4>
                <p class="kontoDescription">Logując się na konto zyskujesz dostęp do profilu, zapisywania ofert i wielu innych funkcji!</p>
              </div>
              <div class="mb-5 d-flex justify-content-center align-items-center">
                <a href="../user/login.php"><button class="btn violetButtons">Zaloguj się</button></a>
              </div>
              <div class="mb-1 d-flex justify-content-center align-items-center">
                <p class="coloredFont">Nie masz jeszcze konta?</p>
              </div>
              <div class="mb-1 d-flex justify-content-center align-items-center">
                <a href="../user/register.php"><button class="btn violetButtonsFrame">Utwórz konto</button></a>
              </div>
              <?php } ?>
            </div>
              </div>
          </div>
        </div>
      </nav>
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
                        <?php if(isset($_SESSION['logged_in'])){ ?>
                          <i class="bi bi-star favoriteIcon" id="starIcon"></i>
                        <?php }else{?>
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
                            <span>&nbsp;</span>
                            <h3 class="text-center jobDetailsTitle">Szczegóły oferty</h3>
                            <div class="row d-flex justify-content-center p-lg-3 p-xl-0">
                                <div class="col-lg-6 d-flex justify-content-center">
                                  <div>
                                    <div class="jobDetailsIcon d-flex align-items-center">
                                        <i class="bi bi-bar-chart"></i><h5><?php echo $poziomStanoiwka; ?></h5>
                                    </div>
                                    <div class="jobDetailsIcon d-flex align-items-center">
                                        <i class="bi bi-file-earmark-text-fill"></i><h5><?php echo $typUmowy; ?></h5>
                                    </div>
                                    <div class="jobDetailsIcon d-flex align-items-center">
                                      <i class="bi bi-clock"></i><h5><?php echo $wymiarZatrudnienia; ?></h5>
                                    </div>
                                    <div class="jobDetailsIcon d-flex align-items-center">
                                      <i class="bi bi-briefcase-fill"></i><h5><?php echo $typPracy; ?></h5>
                                    </div>
                                    <div class="jobDetailsIcon d-flex align-items-center">
                                      <i class="bi bi-calendar4-week"></i>
                                      <div>
                                        <h5><?php echo $dniPracy; ?></h5>
                                        <h6 class="jobDetailsIconHours"><?php echo $godzinyPracy; ?></h6>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-6 d-flex justify-content-center order-first order-md-last secondCol">
                                  <div>
                                    <div class="jobDetailsIcon2 d-flex align-items-center">
                                      <i class="bi bi-currency-exchange"></i>
                                      <div>
                                        <h5><?php echo $wynagrodzenie; ?> zł</h5>
                                        <h6 class="jobDetailsIconHours">brutto / miesięcznie</h6>
                                      </div>
                                    </div>
                                    <div class="jobDetailsIcon d-flex align-items-center">
                                      <i class="bi bi-hourglass-split"></i><h5>Ważne do: <?php echo $dataWygasania; ?></h5>
                                  </div>
                                  </div>
                                </div>
                            </div>
                            <span>&nbsp;</span>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <div class="jobDetailsBox">
                          <span>&nbsp;</span>
                          <h3 class="text-center jobDetailsTitle">Zakres obowiązków</h3>
                          <?php
                          while($row = mysqli_fetch_assoc($dutiesResult)){
                          ?>
                          <div class="dutiesDiv">
                            <i class="bi bi-check2-circle"></i>
                            <p><?php echo $row['duty']; ?></p>
                          </div>
                          <?php } ?>
                          <span>&nbsp;</span>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                      <div class="jobDetailsBox">
                        <span>&nbsp;</span>
                        <h3 class="text-center jobDetailsTitle">Wymagania</h3>
                        <?php
                          while($row = mysqli_fetch_assoc($requirementsResult)){
                        ?>
                        <div class="dutiesDiv">
                          <i class="bi bi-check2-circle"></i>
                          <p><?php echo $row['requirement']; ?></p>
                        </div>
                        <?php } ?>
                      </div>
                      <span>&nbsp;</span>
                    </div>
                    <div class="col-12 mt-5 aaa">
                      <div class="jobBenefitsBox">
                        <span>&nbsp;</span>
                        <h3 class="text-center jobDetailsTitle">Co oferujemy</h3>
                        <?php
                          while($row = mysqli_fetch_assoc($benefitsResult)){
                        ?>
                        <div class="d-flex justify-content-center benefitContainer">
                          <div class="benefitBox">
                            <i class="bi bi-star-fill benefitIcon"></i>
                            <p><?php echo $row['benefit']; ?></p>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                      <span>&nbsp;</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 mt-5">
                <div class="row">
                    <div class="col-12 applyCol">
                        <div class="jobDetailsBox applyBottom">
                          <span>&nbsp;</span>
                          <h5 class="text-center mb-4 applyText">Podoba Ci się ta oferta?</h5>
                          <?php if(isset($_SESSION['logged_in'])){ ?>
                          <a href="#" class="d-flex justify-content-center"><p class="applyButton d-flex justify-content-center align-items-center">Aplikuj</p></a>
                          <?php } else{ ?>
                            <a class="d-flex justify-content-center opacity-50" id="liveToastBtn2"><p class="applyButton d-flex justify-content-center align-items-center">Aplikuj</p></a>
                          <?php } ?>
                        </div>
                        <span>&nbsp;</span>
                    </div>
                    <div class="col-12 mt-4">
                      <div class="jobDetailsBox">
                        <span>&nbsp;</span>
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
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
                    <div class="jobDetailsBox">
                      <span>&nbsp;</span>
                      <h5 class="text-center mb-4">Więcej o firmie</h5>
                      <p class="moreDescription"><?php echo $opisFirmy; ?></p>
                    </div>
                    <span>&nbsp;</span>
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

            starIcon.addEventListener("click", function(){
              if(isFavorite){
                starIcon.className = "bi bi-star favoriteIcon";
                window.location.href = "../actions/actionFavorite.php?oid=" + oID + "&action=remove";
              }
              else{
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