<?php
session_start();
require_once '../actions/connection.php';
$companiesResult = $conn->query("SELECT * FROM `company`;");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["delete_companyId"])) {
        $company_id = $_POST["delete_companyId"];

        $result = $conn->query("SELECT logo_src FROM company WHERE company_id='$company_id';");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $imagePath = "../" . $row["logo_src"];

            if (file_exists($imagePath)) {
                unlink($imagePath);
            } else {
                echo "file not exist";
            }
        } else {
            echo "num rows = 0";
        }

        $conn->query("DELETE FROM company WHERE company_id='$company_id'");
        header("Location: " . $_SERVER['PHP_SELF']);
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
                <a href="index.php" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks"><i class="bi bi-speedometer2 fs-4 mx-2"></i>
                    <p class="m-0 mx-1 fw-medium">Panel główny</p>
                </a>
                <a href="offers.php" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks"><i class="bi bi-file-earmark-text-fill fs-4 mx-2"></i>
                    <p class="m-0 mx-1 fw-medium">Ogłoszenia</p>
                </a>
                <a href="#" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks adminMenuLinkSelected"><i class="bi bi-buildings-fill fs-4 mx-2"></i>
                    <p class="m-0 mx-1 fw-medium">Firmy</p>
                </a>
                <a href="categories.php" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks"><i class="bi bi-grid-fill fs-4 mx-2"></i>
                    <p class="m-0 mx-1 fw-medium">Kategorie</p>
                </a>
                <a href="applications.php" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks"><i class="bi bi-people-fill fs-4 mx-2"></i>
                    <p class="m-0 mx-1 fw-medium">Aplikacje</p>
                </a>
            </div>
            <div class="bottom-menu">
                <a href="index.php" class="text-center text-decoration-none menuIconDiv">
                    <i class="bi bi-speedometer2 menuIcon fs-2"></i>
                    <p class="m-0 menuIconText">Panel</p>
                </a>
                <a href="offers.php" class="text-center text-decoration-none menuIconDiv">
                    <i class="bi bi-file-earmark-text-fill menuIcon fs-2"></i>
                    <p class="m-0 menuIconText">Ogłoszenia</p>
                </a>
                <a href="#" class="text-center text-decoration-none menuIconDiv menuIconClicked">
                    <i class="bi bi-buildings-fill menuIcon fs-2"></i>
                    <p class="m-0 menuIconText">Firmy</p>
                </a>
                <a href="categories.php" class="text-center text-decoration-none menuIconDiv">
                    <i class="bi bi-grid-fill menuIcon fs-2"></i>
                    <p class="m-0 menuIconText">Kategorie</p>
                </a>
                <a href="applications.php" class="text-center text-decoration-none menuIconDiv">
                    <i class="bi bi-people-fill menuIcon fs-2"></i>
                    <p class="m-0 menuIconText">Aplikacje</p>
                </a>
            </div>
            <div class="rightCol">
                <div class="row" style="height: 100%;">
                    <div class="col-xl-12 d-flex align-items-center bg-light" style="height: 8%;">
                        <h3 class="m-0 me-auto fw-bold d-flex align-items-center">Witaj, admin!</h3>
                        <a href="#" class="viewButton"><i class="bi bi-eye-fill"></i>Widok strony</a>
                        <img src="../imgs/UI/login_user.png" class="menuAvatar mx-4">
                    </div>
                    <div class="col-xl-12 pe-5 px-5" style="height: 85%;">
                        <div class="d-flex align-items-center mb-4">
                            <h3 class="m-0 me-auto fw-bold d-flex align-items-center">Firmy</h3>
                            <a href="#" class="adminAddButton d-flex align-items-center gap-1 text-decoration-none rounded-4 px-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus-lg fs-3 text-white"></i>
                                <h5 class="m-0 text-white fw-normal">Dodaj</h5>
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-3">ID</th>
                                        <th scope="col">Logo</th>
                                        <th scope="col">Nazwa</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($companiesResult) > 0) {
                                        while ($row = mysqli_fetch_assoc($companiesResult)) {
                                            $companyID = $row["company_id"];
                                    ?>
                                            <tr style="height: 100px !important;">
                                                <th scope="row" class="px-3">#<?php echo $row["company_id"]; ?></th>
                                                <td><img src="../<?php echo $row["logo_src"]; ?>" style="width: 150px; max-height: 90px;"></td>
                                                <td><?php echo $row["company_name"]; ?></td>
                                                <td>
                                                    <i type="button" class="bi bi-three-dots fs-5" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                    <ul class="dropdown-menu rounded-3">
                                                        <li onclick="GetCompanyInfo('<?php echo $companyID; ?>')"><a class="dropdown-item fw-semibold" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal3" data-company-id="<?php echo $row["company_id"]; ?>"><i class="bi bi-pencil-fill mx-2 me-2"></i>Edytuj</a></li>
                                                        <li onclick="SetOfferId('<?php echo $companyID; ?>')"><a class="dropdown-item fw-semibold" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="bi bi-trash-fill mx-2 me-2"></i>Usuń</a></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
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
                <div class="modal-content rounded-4" style="height: 47% !important;">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="exampleModalLabel">Dodaj firmę</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="../actions/sendData.php" enctype="multipart/form-data">
                            <input type="hidden" name="companyForm" value="true">
                            <div class="container">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control adminInput" id="floatingInput" name="company_name" placeholder="" maxlength="60" required>
                                            <label for="floatingInput">Nazwa</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-3">
                                            <input type="file" class="form-control form-control-sm adminInput" id="floatingInput" name="file" placeholder="" accept=".jpg, .jpeg, .png, .gif" required>
                                            <label for="floatingInput">Logo</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control adminInput" style="height: 150px;" placeholder="" id="floatingTextarea" name="company_description"></textarea>
                                            <label for="floatingTextarea">Informacje o firmie</label>
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

        <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content rounded-4" style="height: 47% !important;">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="exampleModalLabel">Edytuj firmę</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="../actions/sendData.php" enctype="multipart/form-data">
                            <input type="hidden" name="companyFormEdit" id="companyFormEdit">
                            <div class="container">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control adminInput" id="company_name" name="company_name" placeholder="" maxlength="60" required>
                                            <label for="company_name">Nazwa</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-3">
                                            <input type="file" class="form-control form-control-sm adminInput" id="logo" name="file" placeholder="" accept=".jpg, .jpeg, .png, .gif">
                                            <label for="logo">Logo</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control adminInput" style="height: 150px;" placeholder="" id="company_description" name="company_description"></textarea>
                                            <label for="company_description">Informacje o firmie</label>
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


        <div class="modal bounce-in" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Uwaga!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Czy na pewno chcesz usunąć firmę? Wszystkie ogłoszenia powiązane z tą firmą zostaną usunięte.
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
        function GetCompanyInfo(companyid) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../actions/editData.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    document.getElementById('company_name').value = data.company_name;
                    document.getElementById('company_description').value = data.information;
                    document.getElementById('companyFormEdit').value = data.company_id;
                }
            };
            xhr.send('EditCompanyId=' + companyid);
        }

        function AddExtraInput(divContainer, inputName) {
            var urlsDiv = document.getElementById(divContainer);

            var containerDiv = document.createElement("div");
            containerDiv.className = "d-flex align-items-center mt-3 position-relative";

            var input = document.createElement("input");
            input.type = "text";
            input.name = inputName;
            input.className = "form-control adminInput w-100";
            input.required = true;
            input.maxLength = 60;
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
        var currentEditID;

        function SendDeleteForm(formId) {
            var form = document.getElementById(formId);

            var hiddenInput = document.createElement("input");
            hiddenInput.setAttribute("type", "hidden");
            hiddenInput.setAttribute("name", "delete_companyId");
            hiddenInput.setAttribute("value", currentOfferId);

            form.appendChild(hiddenInput);
            form.submit();
            currentOfferId = 0;
        }

        function SetOfferId(offerId) {
            currentOfferId = offerId;
        }

        function SetEditId(editEntryID) {
            currentEditID = editEntryID;
        }

        var myModal = document.getElementById('exampleModal3');

        myModal.addEventListener('hidden.bs.modal', function() {
            var form = this.querySelector('form');
            if (form) {
                form.reset();
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>