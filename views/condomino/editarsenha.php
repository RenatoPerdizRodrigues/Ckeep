<?php
    session_start();
    include_once("../../classes/Login.php");
    $auth = Login::authEmail($_GET['sess'], $_GET['em']);

    if ($auth == false){
        header("Location: ../../login.php");
    }
    include_once("../../header.php");
    include_once("../../classes/Condomino.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../style.css">
    <title>Document</title>
</head>
<body>
    <?php
        include_once("../../header.php");
    ?>

    <div class="container m-y-32 bg-white">
        <div class="wrapper">
            <form method="POST" action="<?= "editarsenha.php?sess=".$_GET['sess']."&em=".$_GET['em']; ?>">
                <fieldset>
                    <legend>Editar Senha</legend>
                    <div>
                        <label>Senha*</label>
                        <input required type="password" name="senha1"><br>
                    </div>
                    <div>
                        <label>Digite novamente a Senha*</label>
                        <input required type="password" name="senha2"><br>
                    </div>
                    <input type="submit" class="button m-t-16" value="Alterar Senha">
            </form>
        </div>
    </div>

    <?php
        include_once("../../footer.php");
    ?>
</body>
</html>
<?php
    $senha1 = isset($_POST['senha1']) ? $_POST['senha1'] : null;
    $senha2 = isset($_POST['senha2']) ? $_POST['senha2'] : null;
    $email = base64_decode($_GET['em']);


    if ($senha1 && $senha2 && $senha1 == $senha2){
        Condomino::updatePassword($senha1, $email);
    }
?>