<?php
    session_start();
    include_once("classes/Login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
</body>
</html>
<?php
    $id = isset($_SESSION['ID']) ? $_SESSION['ID'] : null;

    if ($id) {
        Login::logout($id);
    } else {
        header("Location: " . ROOT . "login.php");
        exit();
    }
?>