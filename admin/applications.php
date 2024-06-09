<?php
session_start();
require_once '../actions/connection.php';
$applicationResults = $conn->query("SELECT * FROM `user_applications`;");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["deleteForm"])) {
        $application_id = $_POST["deleteForm"];
        $conn->query("DELETE FROM user_applications WHERE application_id='$application_id';");
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
                <a href="companies.php" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks"><i class="bi bi-buildings-fill fs-4 mx-2"></i>
                    <p class="m-0 mx-1 fw-medium">Firmy</p>
                </a>
                <a href="categories.php" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks"><i class="bi bi-grid-fill fs-4 mx-2"></i>
                    <p class="m-0 mx-1 fw-medium">Kategorie</p>
                </a>
                <a href="#" class="d-flex align-items-center text-decoration-none p-1 rounded-3 adminMenuLinks adminMenuLinkSelected"><i class="bi bi-people-fill fs-4 mx-2"></i>
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
                <a href="companies.php" class="text-center text-decoration-none menuIconDiv">
                    <i class="bi bi-buildings-fill menuIcon fs-2"></i>
                    <p class="m-0 menuIconText">Firmy</p>
                </a>
                <a href="categories.php" class="text-center text-decoration-none menuIconDiv">
                    <i class="bi bi-grid-fill menuIcon fs-2"></i>
                    <p class="m-0 menuIconText">Kategorie</p>
                </a>
                <a href="#" class="text-center text-decoration-none menuIconDiv menuIconClicked">
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
                            <h3 class="m-0 me-auto fw-bold d-flex align-items-center">Aplikacje</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-3">ID</th>
                                        <th scope="col">ID profilu</th>
                                        <th scope="col">ID ogłoszenia</th>
                                        <th scope="col">Status</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($applicationResults) > 0) {
                                        while ($row = mysqli_fetch_assoc($applicationResults)) {
                                            $application_id = $row["application_id"];
                                    ?>
                                            <tr>
                                                <th scope="row" class="px-3">#<?php echo $row["application_id"]; ?></th>
                                                <td><?php echo $row["profile_id"]; ?></td>
                                                <td><?php echo $row["offer_id"]; ?></td>
                                                <td><?php echo $row["status"]; ?></td>
                                                <td>
                                                    <i type="button" class="bi bi-three-dots fs-5" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                    <ul class="dropdown-menu rounded-3">
                                                        <li onclick="SendEditForm('<?php echo $application_id; ?>', 'Zatwierdzono')"><a class="dropdown-item fw-semibold" href="#"><i class="bi bi-check-lg mx-2 me-2"></i>Akceptuj</a></li>
                                                        <li onclick="SendEditForm('<?php echo $application_id; ?>', 'Odrzucono')"><a class="dropdown-item fw-semibold" href="#"><i class="bi bi-x-lg mx-2 me-2"></i>Odrzuć</a></li>
                                                        <li><a class="dropdown-item fw-semibold" href="../user/profile_user.php?id=<?php echo $row["profile_id"]; ?>"><i class="bi bi-person-fill mx-2 me-2"></i>Dane</a></li>
                                                        <li onclick="SetOfferId('<?php echo $application_id; ?>')"><a class="dropdown-item fw-semibold" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="bi bi-trash-fill mx-2 me-2"></i>Usuń</a></li>
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
        <div class="modal bounce-in" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Uwaga!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Czy na pewno chcesz usunąć aplikację?
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
        <form id="editForm" method="post" action="../actions/sendData.php">
            <input type="hidden" name="applicationForm" value="true">
            <input type="hidden" name="isEdit" value="true" id="isEdit">
            <input type="hidden" name="application_id" value="" id="applicationIdInput">
            <input type="hidden" name="status" value="" id="statusInput">
        </form>
    </div>
    <script>
        var currentOfferId;

        function SendDeleteForm() {
            var form = document.getElementById('offerDeleteForm');

            var hiddenInput = document.createElement("input");
            hiddenInput.setAttribute("type", "hidden");
            hiddenInput.setAttribute("name", "deleteForm");
            hiddenInput.setAttribute("value", currentOfferId);

            form.appendChild(hiddenInput);
            form.submit();
            currentOfferId = 0;
        }

        function SendEditForm(id, status) {
            var form = document.getElementById('editForm');
            document.getElementById('statusInput').value = status;
            document.getElementById('applicationIdInput').value = id;
            form.submit();
        }

        function SetOfferId(offerId) {
            currentOfferId = offerId;
        }

        var myModal = document.getElementById('exampleModal');
        myModal.addEventListener('hidden.bs.modal', function() {
            var form = this.querySelector('form');
            if (form) {
                form.reset();
                var formInput = form.querySelector('#isEdit');
                if (formInput) {
                    formInput.value = 'false';
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>