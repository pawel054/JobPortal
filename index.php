<?php
    session_start();
    require_once 'actions/connection.php';
    $offersResult = $conn->query("SELECT * FROM `offer` INNER JOIN company USING(company_id) INNER JOIN category USING(category_id);");
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
              <?php if(isset($_SESSION['logged_in'])){ ?>
                <div class="mb-4">
                <h4 class="kontoTitle">Moje konto</h4>
                <p class="kontoDescription"><?php echo $_SESSION['email']; ?></p>
              </div>
              <?php if($_SESSION['isadmin']==1){ ?>
              <div class="mb-3 d-flex justify-content-center align-items-center">
                <a href="user/login.php"><button class="btn violetButtonsFrame">Panel administratora</button></a>
              </div>
              <?php } ?>
              <div class="mb-3 d-flex justify-content-center align-items-center">
                <a href="user/login.php"><button class="btn violetButtonsFrame">Profil użytkownika</button></a>
              </div>
              <div class="mb-3 d-flex justify-content-center align-items-center">
                <a href="user/login.php"><button class="btn violetButtonsFrame">Zapisane oferty</button></a>
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
  
  
      <div class="container">
        <div class="d-flex align-items-center justify-content-center mt-4 mb-5">
          <i class="bi bi-briefcase-fill offerCountIcon"></i>
          <h1 class="h1Title mt-5 mb-5 fs-2"><span class="offersCountMark">64 258</span> oferty pracy od najlepszych pracodawców</h1>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-center mb-5">
                <div class="mainSearch">
                <div class="mainSearchInputs">
                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <div class="form-floating">
                                <input class="form-control" type="text" placeholder="Stanowisko" id="stanowiskoInput">
                                <label for="stanowiskoInput">Stanowisko</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                          <div class="form-floating">
                            <input class="form-control" type="text" placeholder="Kategoria" id="kategoriaInput">
                            <label for="kategoriaInput">Kategoria</label>
                        </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-floating">
                                <input class="form-control" type="text" placeholder="Lokalizacja" id="lokalizacjaInput">
                                <label for="lokalizacjaInput">Lokalizacja</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-floating">
                                <input class="form-control" type="text" value="10KM" placeholder="Odleglosc" id="odlegloscInput">
                                <label for="odlegloscInput">Odgległość (km)</label>
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
                </div>
            </div>
            </div>
        </div>
        <h1 class="h1Title mt-5">Ostatnio dodane oferty</h1>
        <h5 class="h1TitleDescription mt-3 mb-5">Poznaj ostatnio dodane ogłoszenia od pracodawców.</h5>
        <div class="row">
          <?php
            while($row = mysqli_fetch_assoc($offersResult)){
          ?>
          <div class="col-12 col-lg-6 col-xl-4 d-flex justify-content-center">
            <a class="offerBox mb-5" href="offers/offer.php?id=<?php echo $row['offer_id'] ?>">
              <div class="row xdd">
                <div class="col-lg-6 col-6 testcol d-flex align-items-center">
                  <h5 class="boxTitle"><?php echo $row["position_name"];?></h5>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-6 testcol2 d-flex align-items-center">
                    <h5 class="testt"><?php echo $row["company_name"];?></h5>
                </div>
                <div class="col-lg-3 col-3 testcol3 boxImageplace" >
                  <img class="boxImage" src="<?php echo $row["logo_src"];?>">
                </div>
            </div>
              <div class="row">
                <div class="col-lg-6 col-3 testcol4 d-flex justify-content-center">
                  <span class="bi bi-geo-alt-fill boxIcon"><div class="geoName"><?php $adress=explode(":", $row['adress'], 2); echo trim($adress[1]);?></div></span>
                </div>
                <div class="col-lg-6 col-3 testcol42 d-flex justify-content-center">
                  <span class="bi bi-currency-exchange boxIcon"><div class="geoName"><?php echo $row["salary"];?> zł</div></span>
                </div>
              </div>
            </a>
          </div>
          <?php } ?>
        </div>
    </div>
    
    <div class="modal fade custom-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Filtry Zaawansowane</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="kategoriaGroup">
              <h5>Poziom stanowiska</h5>
              <div class="form-check">
               <input class="form-check-input" type="checkbox" value="" id="option1">
               <label class="form-check-label" for="option1">
                 Praktykant / stażysta
               </label>
             </div>
             <div class="form-check">
               <input class="form-check-input" type="checkbox" value="" id="option2">
               <label class="form-check-label" for="option2">
                 Asystent
               </label>
             </div>
             <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="option3">
              <label class="form-check-label" for="option3">
                Młodszy specjalista (junior)
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="option4">
              <label class="form-check-label" for="option4">
                Specjalista (mid)
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="option5">
              <label class="form-check-label" for="option5">
                Starszy specjalista (senior)
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="option6">
              <label class="form-check-label" for="option6">
                Ekspert
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="option7">
              <label class="form-check-label" for="option7">
                Kierownik / koordynator
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="option8">
              <label class="form-check-label" for="option8">
                Menedżer
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="option9">
              <label class="form-check-label" for="option9">
                Dyrektor
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="option10">
              <label class="form-check-label" for="option10">
                Prezes
              </label>
            </div>
            </div>
            <div class="kategoriaGroup">
              <h5>Rodzaj umowy</h5>
              <div class="form-check">
               <input class="form-check-input" type="checkbox" value="" id="2option1">
               <label class="form-check-label" for="2option1">
                 Umowa o pracę
               </label>
             </div>
             <div class="form-check">
               <input class="form-check-input" type="checkbox" value="" id="2option2">
               <label class="form-check-label" for="2option2">
                 Umowa o dzieło
               </label>
             </div>
             <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="2option3">
              <label class="form-check-label" for="2option3">
                Umowa zlecenie
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="2option4">
              <label class="form-check-label" for="2option4">
                Umowa B2B
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="2option5">
              <label class="form-check-label" for="2option5">
                Umowa na zastępstwo
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="2option6">
              <label class="form-check-label" for="2option6">
                Umowa o staż / praktyki
              </label>
            </div>
            </div>
            <div class="kategoriaGroup">
              <h5>Wymiar etatu</h5>
              <div class="form-check">
               <input class="form-check-input" type="checkbox" value="" id="3option1">
               <label class="form-check-label" for="3option1">
                 Część etatu
               </label>
             </div>
             <div class="form-check">
               <input class="form-check-input" type="checkbox" value="" id="3option2">
               <label class="form-check-label" for="3option2">
                 Cały etat
               </label>
             </div>
             <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="3option3">
              <label class="form-check-label" for="3option3">
                Dodatkowa / tymczasowa
              </label>
            </div>
            </div>
            <div class="kategoriaGroup">
              <h5>Tryb pracy</h5>
              <div class="form-check">
               <input class="form-check-input" type="checkbox" value="" id="4option1">
               <label class="form-check-label" for="4option1">
                 Stacjonarnie
               </label>
             </div>
             <div class="form-check">
               <input class="form-check-input" type="checkbox" value="" id="4option2">
               <label class="form-check-label" for="4option2">
                 Hybrydowo
               </label>
             </div>
             <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="4option3">
              <label class="form-check-label" for="4option3">
                Zdalnie
              </label>
            </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn modalExit" data-bs-dismiss="modal">Zamknij</button>
            <button type="button" class="btn modalSave">Zapisz</button>
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>