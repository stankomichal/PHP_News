<?php
session_start();
if (!isset($_SESSION['user'])) {
    Header('Location: ../../Index.php');
    die();
}
if (!isset($_GET['id'])) {
    Header('Location: ../Authors.php');
    die();
}
if ($_GET['id'] != $_SESSION['user']['id'] && !$_SESSION['user']['isAdmin']) {
    Header('Location: ../Authors.php');
    die();
}

require_once '../../models/HeadingAdminSub.php';
require_once '../../models/Database.php';
require_once '../../models/BaseRepository.php';
require_once '../../models/AdminsRepository.php';
$db = new Database();
$auRep = new AdminsRepository($db);
if (isset($_GET['id'], $_POST['name'], $_POST['surname'])) {

    $auRep->UpdateAuthor($_GET['id'], $_POST['name'], $_POST['surname']);
    Header('Location: ../Authors.php');
    die();
} elseif (isset($_GET['id'])) {
    $author = $auRep->GetAuthor($_GET['id']);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP News - ADMIN</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"></script>
    <style>
        .no-underline {
            text-decoration: none;
        }

        nav a.active {
            border-bottom: 3px solid white;
        }
    </style>
</head>
<body>
<?php $hd = new HeadingAdminSub();
$hd->Draw('authors');
?>
<main class="container d-flex justify-content-center">
    <div class="col-md-8 mb-5">
        <h3 class="py-4 mb-4 border-bottom fst-italic">
            Upravit autora
        </h3>
        <form action="" method="post">
            <div class="d-flex gap-5">
                <label class="form-label col">
                    Jméno
                    <input value="<?= $author['name'] ?>" required name="name" class="form-control" type="text">
                </label>
                <label class="form-label col">
                    Příjmení
                    <input value="<?= $author['surname'] ?>" required name="surname" class="form-control" type="text">
                </label>
            </div>
            <div class="buttons d-flex justify-content-between mt-3">
                <a class="btn btn-danger" href="../Authors.php">Zrušit</a>
                <button class="btn btn-primary" type="submit">Uložit</button>
            </div>
        </form>
    </div>
</main>
</body>
</html>
