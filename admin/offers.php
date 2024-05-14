<?php
    session_start();
    require_once '../actions/connection.php';
    $offersResult = $conn->query("SELECT * FROM `offer`;");
    $categoriesResult = $conn->query("SELECT * FROM `category`;");
    $companiesResult = $conn->query("SELECT * FROM `company`;");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["delete_offerId"])){
            $offer_id = $_POST["delete_offerId"];
            $conn->query("DELETE FROM offer WHERE offer_id='$offer_id'");
            header("Location: " . $_SERVER['PHP_SELF']);
        }
    }

    function GetCompanyName($id, $conn){
        $getCompanyNameResult = $conn->query("SELECT company_name FROM `company` WHERE company_id='$id';")->fetch_row();
        if($getCompanyNameResult != null){
            echo $getCompanyNameResult[0];
        }
        else{
            echo "Not found";
        }
      }

      function GetCategory($id, $conn){
        $getCategoryNameResult = $conn->query("SELECT category_name FROM `category` WHERE category_id='$id';")->fetch_row();
        if($getCategoryNameResult != null){
            echo $getCategoryNameResult[0];
        }
        else{
            echo "Not found";
        }
      }

      function DisplayShortText($text, $maxSymbols){
        if(strlen($text) > $maxSymbols)
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
    <title>Document</title>
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="../css/animations.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="leftCol">
                <h3 class="text-white mx-3 mt-4 mb-3 fw-bold">Admin</h3>
                <a href="index.php" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks"><i class="bi bi-speedometer2 fs-4 mx-2"></i><p class="m-0 mx-1 fw-medium">Panel główny</p></a>
                <a href="#" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks adminMenuLinkSelected"><i class="bi bi-file-earmark-text-fill fs-4 mx-2"></i><p class="m-0 mx-1 fw-medium">Ogłoszenia</p></a>
                <a href="companies.php" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks"><i class="bi bi-buildings-fill fs-4 mx-2"></i><p class="m-0 mx-1 fw-medium">Firmy</p></a>
                <a href="categories.php" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks"><i class="bi bi-grid-fill fs-4 mx-2"></i><p class="m-0 mx-1 fw-medium">Kategorie</p></a>
                <a href="#" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks"><i class="bi bi-people-fill fs-4 mx-2"></i><p class="m-0 mx-1 fw-medium">Aplikacje</p></a>
            </div>
            <div class="bottom-menu">
                <a href="#"><i class="bi bi-speedometer2 menuIconClicked"></i></a>
                <a href="#"><i class="bi bi-file-earmark-text-fill menuIcon"></i></a>
                <a href="#"><i class="bi bi-buildings-fill menuIcon"></i></a>
                <a href="#"><i class="bi bi-people-fill menuIcon"></i></a>
            </div>
            <div class="rightCol">
                <div class="row" style="height: 100%;">
                    <div class="col-xl-12 d-flex align-items-center bg-light" style="height: 8%;">
                        <h3 class="m-0 me-auto fw-bold d-flex align-items-center">Witaj, admin!</h3>
                        <a href="../index.php" class="viewButton"><i class="bi bi-eye-fill"></i>Widok strony</a>
                        <img src="../imgs/UI/login_user.png" class="menuAvatar mx-4">
                    </div>
                    <div class="col-xl-12 pe-5 px-5" style="height: 85%;">
                        <div class="statsboxPlace p-5" style="display:none;">
                            <a href="#" class="adminAddButton d-flex align-items-center justify-content-center gap-2 text-decoration-none" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus-lg fs-2 text-white"></i><h4 class="m-0 text-white fw-normal">Dodaj</h4></a>
                            <div class="adminDataColumns mt-5 p-3">
                                <div class="row row-cols-6">
                                    <div class="col text-center mb-3">
                                        <h5 class="fw-bold">ID</h5>
                                    </div>
                                    <div class="col text-center mb-3">
                                        <h5 class="fw-bold">Firma</h5>
                                    </div>
                                    <div class="col text-center mb-3">
                                        <h5 class="fw-bold">Stanowisko</h5>
                                    </div>
                                    <div class="col text-center mb-3">
                                        <h5 class="fw-bold">kategoria</h5>
                                    </div>
                                    <div class="col text-center mb-3">
                                        <h5 class="fw-bold">Lokalizacja</h5>
                                    </div>
                                    <div class="col text-center mb-3">
                                    </div>
                                    
                                    <div class="col text-center d-flex justify-content-center align-items-center p-3">
                                        <h5>#<?php echo $row["offer_id"]; ?></h5>
                                    </div>
                                    <div class="col text-center d-flex justify-content-center align-items-center">
                                        <h5><?php DisplayShortText(GetCompanyName($row["company_id"], $conn),26); ?></h5>
                                    </div>
                                    <div class="col text-center d-flex justify-content-center align-items-center">
                                        <h5><?php DisplayShortText($row["position_name"], 26); ?></h5>
                                    </div>
                                    <div class="col text-center d-flex justify-content-center align-items-center">
                                        <h5><?php DisplayShortText(GetCategory($row["category_id"], $conn), 26); ?></h5>
                                    </div>
                                    <div class="col text-center d-flex justify-content-center align-items-center">
                                    <h5><?php echo DisplayShortText($city, 26); ?></h5>
                                    </div>
                                    <div class="col text-center d-flex justify-content-center align-items-center">
                                    <i type="button" class="bi bi-three-dots fs-5" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                        <ul class="dropdown-menu rounded-3">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil-fill mx-2 me-2"></i>Edytuj</a></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="bi bi-trash-fill mx-2 me-2"></i>Usuń</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                        <h3 class="m-0 me-auto fw-bold d-flex align-items-center">Ogłoszenia</h3>
                        <a href="#" class="adminAddButton d-flex align-items-center gap-1 text-decoration-none rounded-4 px-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus-lg fs-3 text-white"></i><h5 class="m-0 text-white fw-normal">Dodaj</h5></a>
                        </div>
                        <div class="table-responsive">
                        <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="px-3">ID</th>
                                <th scope="col">Firma</th>
                                <th scope="col">Stanowisko</th>
                                <th scope="col">Kategoria</th>
                                <th scope="col">Lokalizacja</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(mysqli_num_rows($offersResult) > 0) {
                            while($row = mysqli_fetch_assoc($offersResult)) {
                                $offerID = $row["offer_id"];
                        ?>
                            <tr>
                                <th scope="row" class="px-3">#<?php echo $row["offer_id"]; ?></th>
                                <td><?php GetCompanyName($row["company_id"], $conn); ?></td>
                                <td><?php echo $row["position_name"]; ?></td>
                                <td><?php GetCategory($row["category_id"], $conn); ?></td>
                                <td><?php $parts = explode(":", $row["adress"]); $city = end($parts); echo $city;?></td>
                                <td>
                                    <i type="button" class="bi bi-three-dots fs-5" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                    <ul class="dropdown-menu rounded-3">
                                        <li onclick="GetOfferInfo('<?php echo $offerID; ?>')"><a class="dropdown-item fw-semibold" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal3"><i class="bi bi-pencil-fill mx-2 me-2"></i>Edytuj</a></li>
                                        <li onclick="SetOfferId('<?php echo $offerID; ?>')"><a class="dropdown-item fw-semibold" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="bi bi-trash-fill mx-2 me-2"></i>Usuń</a></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php
                            }
                        }else {
                            echo "Brak wyników do wyświetlenia.";
                        }
                        ?>
                        </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content rounded-4" style="height: 80% !important;">
                <div class="modal-header">
                    <h1 class="modal-title fs-3" id="exampleModalLabel">Dodaj ogłoszenie</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form method="post" action="../actions/sendData.php" id="offerForm">
                <input type="hidden" name="offerForm" value="true">
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-6">
                                <div class="form-floating mb-3 mt-3">
                                    <select class="form-select adminInput" id="floatingSelect" aria-label="Floating label select example" name="category_id">
                                        <option selected>Wybierz</option>
                                        <?php while($row = mysqli_fetch_assoc($categoriesResult)){?>
                                            <option value="<?php echo $row["category_id"];?>"><?php echo $row["category_name"];?></option>
                                        <?php } ?>
                                    </select>
                                <label for="floatingSelect" class="floatingInputStyle">Kategoria</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control adminInput" id="floatingInput" name="stanowisko" placeholder="" maxlength="60" required>
                                    <label for="floatingInput">Stanowisko</label>
                                </div>
                                <div class="form-floating mb-3">
                                        <select class="form-select adminInput" id="floatingSelect" aria-label="Floating label select example" name="umowa">
                                        <option selected>Wybierz</option>
                                            <option value="o pracę">o pracę</option>
                                            <option value="o dzieło">o dzieło</option>
                                            <option value="o zlecenie">zlecenie</option>
                                            <option value="B2B">B2B</option>
                                            <option value="zastępstwo">zastępstwo</option>
                                            <option value="staż/praktyka">staż/praktyka</option>
                                        </select>
                                    <label for="floatingSelect" class="floatingInputStyle">Rodzaj umowy</label>
                                </div>
                                <div class="form-floating mb-3">
                                        <select class="form-select adminInput" id="floatingSelect" aria-label="Floating label select example" name="etat">
                                            <option selected>Wybierz</option>
                                            <option value="część etatu">część etatu</option>
                                            <option value="cały etat">cały etat</option>
                                            <option value="dodatkowa/tymczasowa">dodatkowa/tymczasowa</option>
                                        </select>
                                    <label for="floatingSelect" class="floatingInputStyle">Wymiar etatu</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control adminInput" id="floatingInput" name="dni_praca" placeholder="" maxlength="40" required>
                                    <label for="floatingInput">Dni pracy</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control adminInput" id="floatingInput" name="adres" placeholder="" maxlength="80" required>
                                    <label for="floatingInput">Adres</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control adminInput" id="floatingInput" name="termin" placeholder="" required>
                                    <label for="floatingInput">Termin ważności</label>
                                </div>
                            </div>
                            <div class="col-6">     
                                <div class="form-floating mb-3 mt-3">
                                        <select class="form-select adminInput" id="floatingSelect" aria-label="Floating label select example" name="company_id">
                                            <option selected>Wybierz</option>
                                            <?php while($row = mysqli_fetch_assoc($companiesResult)){?>
                                            <option value="<?php echo $row["company_id"];?>"><?php echo $row["company_name"];?></option>
                                        <?php } ?>
                                        </select>
                                    <label for="floatingSelect" class="floatingInputStyle">Firma</label>
                                </div>
                                <div class="form-floating mb-3">
                                        <select class="form-select adminInput" id="floatingSelect" aria-label="Floating label select example" name="poziom_stanowisko">
                                            <option selected>Wybierz</option>
                                            <option value="praktykant/stażysta">praktykant/stażysta</option>
                                            <option value="asystent">asystent</option>
                                            <option value="młodszy specjalista (junior)">młodszy specjalista (junior)</option>
                                            <option value="specjalista (mid)">specjalista (mid)</option>
                                            <option value="starszy specjalista (senior)">starszy specjalista (senior)</option>
                                            <option value="ekspert">ekspert</option>
                                            <option value="kierownik/koordynator">kierownik/koordynator</option>
                                            <option value="menedżer">menedżer</option>
                                            <option value="dyrektor">dyrektor</option>
                                            <option value="prezes">prezes</option>
                                        </select>
                                    <label for="floatingSelect" class="floatingInputStyle">Poziom stanowiska</label>
                                </div>
                                <div class="form-floating mb-3">
                                        <select class="form-select adminInput" id="floatingSelect" aria-label="Floating label select example" name="tryb_praca">
                                            <option selected>Wybierz</option>
                                            <option value="stacjonarna">stacjonarna</option>
                                            <option value="hybrydowa">hybrydowa</option>
                                            <option value="zdalna">zdalna</option>
                                        </select>
                                    <label for="floatingSelect" class="floatingInputStyle">Tryb pracy</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control adminInput" id="floatingInput" name="wynagrodzenie" placeholder="" maxlength="50" required>
                                    <label for="floatingInput">Wynagrodzenie</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control adminInput" id="floatingInput" name="godziny_praca" placeholder="" maxlength="40" required>
                                    <label for="floatingInput">Godziny pracy</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control adminInput" id="floatingInput" name="gmaps" placeholder="" required>
                                    <label for="floatingInput">Google maps url</label>
                                </div>
                            </div>
                            <p class="text-center mb-1 text-secondary">Dodatkowe Opcje</p>
                            <hr>
                            <div class="adminAddOfferSpecial d-flex align-items-center rounded-top-4">
                                <h5 class="m-0">Zakres obowiązków</h5>
                                <i class="bi bi-plus-lg fs-2 text-white" style="margin-left: auto;" onclick="AddExtraInput('duties','duties[]', null)"></i>
                            </div>
                            <div id="duties">
                            </div>
                            <div class="adminAddOfferSpecial d-flex align-items-center rounded-top-4 mt-5">
                                <h5 class="m-0">Wymagania</h5>
                                <i class="bi bi-plus-lg fs-2 text-white" style="margin-left: auto;" onclick="AddExtraInput('requirements','requirements[]', null)"></i>
                            </div>
                            <div id="requirements">

                            </div>
                            <div class="adminAddOfferSpecial d-flex align-items-center rounded-top-4 mt-5">
                                <h5 class="m-0">Benefity</h5>
                                <i class="bi bi-plus-lg fs-2 text-white" style="margin-left: auto;" onclick="AddExtraInput('benefits','benefits[]', null)"></i>
                            </div>
                            <div id="benefits">
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

        <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content rounded-4" style="height: 80% !important;">
                <div class="modal-header">
                    <h1 class="modal-title fs-3" id="exampleModalLabel">Dodaj ogłoszenie</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form method="post" action="../actions/sendData.php" id="offerForm">
                <input type="hidden" name="offerForm" value="true">
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-6">
                                <div class="form-floating mb-3 mt-3">
                                    <select class="form-select adminInput" id="kategoria" aria-label="Floating label select example" name="category_id">
                                        <option selected>Wybierz</option>
                                        <?php
                                            $aaa = $conn->query("SELECT * FROM `category`;");
                                            while($row = mysqli_fetch_assoc($aaa)){?>
                                            <option value="<?php echo $row["category_id"];?>"><?php echo $row["category_name"];?></option>
                                        <?php } ?>
                                    </select>
                                <label for="floatingSelect" class="floatingInputStyle">Kategoria</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control adminInput" id="stanowisko" name="stanowisko" placeholder="" maxlength="60" required>
                                    <label for="floatingInput">Stanowisko</label>
                                </div>
                                <div class="form-floating mb-3">
                                        <select class="form-select adminInput" id="umowa" aria-label="Floating label select example" name="umowa">
                                        <option selected>Wybierz</option>
                                            <option value="o pracę">o pracę</option>
                                            <option value="o dzieło">o dzieło</option>
                                            <option value="o zlecenie">zlecenie</option>
                                            <option value="B2B">B2B</option>
                                            <option value="zastępstwo">zastępstwo</option>
                                            <option value="staż/praktyka">staż/praktyka</option>
                                        </select>
                                    <label for="floatingSelect" class="floatingInputStyle">Rodzaj umowy</label>
                                </div>
                                <div class="form-floating mb-3">
                                        <select class="form-select adminInput" id="etat" aria-label="Floating label select example" name="etat">
                                            <option selected>Wybierz</option>
                                            <option value="część etatu">część etatu</option>
                                            <option value="pełny etat">pełny etat</option>
                                            <option value="dodatkowa/tymczasowa">dodatkowa/tymczasowa</option>
                                        </select>
                                    <label for="floatingSelect" class="floatingInputStyle">Wymiar etatu</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control adminInput" id="dni_praca" name="dni_praca" placeholder="" maxlength="40" required>
                                    <label for="floatingInput">Dni pracy</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control adminInput" id="adres" name="adres" placeholder="" maxlength="80" required>
                                    <label for="floatingInput">Adres</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control adminInput" id="termin" name="termin" placeholder="" required>
                                    <label for="floatingInput">Termin ważności</label>
                                </div>
                            </div>
                            <div class="col-6">     
                                <div class="form-floating mb-3 mt-3">
                                        <select class="form-select adminInput" id="firma" aria-label="Floating label select example" name="company_id">
                                            <option selected>Wybierz</option>
                                            <?php while($row = mysqli_fetch_assoc($companiesResult)){?>
                                            <option value="<?php echo $row["company_id"];?>"><?php echo $row["company_name"];?></option>
                                        <?php } ?>
                                        </select>
                                    <label for="floatingSelect" class="floatingInputStyle">Firma</label>
                                </div>
                                <div class="form-floating mb-3">
                                        <select class="form-select adminInput" id="poziom_stanowisko" aria-label="Floating label select example" name="poziom_stanowisko">
                                            <option selected>Wybierz</option>
                                            <option value="praktykant/stażysta">praktykant/stażysta</option>
                                            <option value="asystent">asystent</option>
                                            <option value="młodszy specjalista (junior)">młodszy specjalista (junior)</option>
                                            <option value="specjalista (mid)">specjalista (mid)</option>
                                            <option value="starszy specjalista (senior)">starszy specjalista (senior)</option>
                                            <option value="ekspert">ekspert</option>
                                            <option value="kierownik/koordynator">kierownik/koordynator</option>
                                            <option value="menedżer">menedżer</option>
                                            <option value="dyrektor">dyrektor</option>
                                            <option value="prezes">prezes</option>
                                        </select>
                                    <label for="floatingSelect" class="floatingInputStyle">Poziom stanowiska</label>
                                </div>
                                <div class="form-floating mb-3">
                                        <select class="form-select adminInput" id="tryb_praca" aria-label="Floating label select example" name="tryb_praca">
                                            <option selected>Wybierz</option>
                                            <option value="stacjonarna">stacjonarna</option>
                                            <option value="hybrydowa">hybrydowa</option>
                                            <option value="zdalna">zdalna</option>
                                        </select>
                                    <label for="floatingSelect" class="floatingInputStyle">Tryb pracy</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control adminInput" id="wynagrodzenie" name="wynagrodzenie" placeholder="" maxlength="50" required>
                                    <label for="floatingInput">Wynagrodzenie</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control adminInput" id="godziny_praca" name="godziny_praca" placeholder="" maxlength="40" required>
                                    <label for="floatingInput">Godziny pracy</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control adminInput" id="gmaps" name="gmaps" placeholder="" required>
                                    <label for="floatingInput">Google maps url</label>
                                </div>
                            </div>
                            <p class="text-center mb-1 text-secondary">Dodatkowe Opcje</p>
                            <hr>
                            <div class="adminAddOfferSpecial d-flex align-items-center rounded-top-4">
                                <h5 class="m-0">Zakres obowiązków</h5>
                                <i class="bi bi-plus-lg fs-2 text-white" style="margin-left: auto;" onclick="AddExtraInput('duties2','duties[]', null)"></i>
                            </div>
                            <div id="duties2">
                            </div>
                            <div class="adminAddOfferSpecial d-flex align-items-center rounded-top-4 mt-5">
                                <h5 class="m-0">Wymagania</h5>
                                <i class="bi bi-plus-lg fs-2 text-white" style="margin-left: auto;" onclick="AddExtraInput('requirements2','requirements[]', null)"></i>
                            </div>
                            <div id="requirements2">

                            </div>
                            <div class="adminAddOfferSpecial d-flex align-items-center rounded-top-4 mt-5">
                                <h5 class="m-0">Benefity</h5>
                                <i class="bi bi-plus-lg fs-2 text-white" style="margin-left: auto;" onclick="AddExtraInput('benefits2','benefits[]', null)"></i>
                            </div>
                            <div id="benefits2">
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

        <div class="modal bounce-in" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Uwaga!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            Czy na pewno chcesz usunąć ogłoszenie?
            Tej operacji nie można cofnąć.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Anuluj</button>
                <button type="button" class="btn btn-danger" onclick="SendDeleteForm('offerDeleteForm')">Tak</button>
            </div>
            </div>
        </div>
        </div>
        <form id="offerDeleteForm" method="post"></form>
    </div>
    <script>

function GetOfferInfo(offerid){
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../actions/editData.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);

                    var offerData = data.offer_data[0];
                    var dutiesData = data.duties_data;
                    var requirementsData = data.requirements_data;
                    var benefitsData = data.benefits_data;


                    document.getElementById('stanowisko').value = offerData.position_name;
                    document.getElementById('dni_praca').value = offerData.working_days;
                    document.getElementById('adres').value = offerData.adress;
                    document.getElementById('termin').value = offerData.expiration_date;
                    document.getElementById('wynagrodzenie').value = offerData.salary;
                    document.getElementById('godziny_praca').value = offerData.working_hours;
                    document.getElementById('gmaps').value = offerData.gmaps_url;

                    var optionKategoria = document.getElementById('kategoria').querySelector('option[value="' + offerData.category_id + '"]');
                    if (optionKategoria) optionKategoria.selected = true;

                    var optionFirma = document.getElementById('firma').querySelector('option[value="' + offerData.company_id + '"]');
                    if (optionFirma) optionFirma.selected = true;

                    var umowa = document.getElementById('umowa').querySelector('option[value="' + offerData.contract_type + '"]');
                    if (umowa) umowa.selected = true;

                    var etat = document.getElementById('etat').querySelector('option[value="' + offerData.working_time + '"]');
                    if (etat) etat.selected = true;

                    var poziom_stanowisko = document.getElementById('poziom_stanowisko').querySelector('option[value="' + offerData.position_level + '"]');
                    if (poziom_stanowisko) poziom_stanowisko.selected = true;

                    var tryb_praca = document.getElementById('tryb_praca').querySelector('option[value="' + offerData.job_type + '"]');
                    if (tryb_praca) tryb_praca.selected = true;

                    dutiesData.forEach(function(item) {
                        AddExtraInput('duties2','duties[]', item.duty);
                    });

                    requirementsData.forEach(function(item) {
                        AddExtraInput('requirements2','requirements[]', item.requirement);
                    });

                    benefitsData.forEach(function(item) {
                        AddExtraInput('benefits2','benefits[]', item.benefit);
                    });

                }
            };
            xhr.send('EditOfferId=' + offerid);
        }
               function AddExtraInput(divContainer, inputName, inputValue) {
                var urlsDiv = document.getElementById(divContainer);

                var containerDiv = document.createElement("div");
                containerDiv.className = "d-flex align-items-center mt-3 position-relative";

                var input = document.createElement("input");
                input.type = "text";
                input.name = inputName;
                input.value = inputValue;
                input.placeholder = ""
                input.className = "form-control adminInput w-100";
                input.required = true; // Wymagane pole URL
                input.maxLength = 80;
                input.required;

                var delButton = document.createElement("button");
                delButton.className = "btn btn-danger position-absolute end-0";
                delButton.textContent = "Del";
                delButton.onclick = function() {
                    containerDiv.remove(); 
                };

                containerDiv.appendChild(input);
                containerDiv.appendChild(delButton);

                urlsDiv.appendChild(containerDiv);
        }

        var currentOfferId;
        function SendDeleteForm(formId) {
            var form = document.getElementById(formId);

            var hiddenInput = document.createElement("input");
            hiddenInput.setAttribute("type", "hidden");
            hiddenInput.setAttribute("name", "delete_offerId");
            hiddenInput.setAttribute("value", currentOfferId);

            form.appendChild(hiddenInput);
            form.submit();
            currentOfferId = 0;
        }

        function SetOfferId(offerId){
            currentOfferId = offerId;
        }

        var myModal = document.getElementById('exampleModal3'); // Zastąp 'MyModal' odpowiednim id twojego modala

myModal.addEventListener('hidden.bs.modal', function () {
    var form = this.querySelector('form');
    if (form) {
        var divsToRemove = form.querySelectorAll('div#duties2, div#requirements2, div#benefits2' );
        divsToRemove.forEach(function(div) {
            div.innerHTML = ''; // Usuń zawartość diva
        });
        form.reset();
    }
});

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>