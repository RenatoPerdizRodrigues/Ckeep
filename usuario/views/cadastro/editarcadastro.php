<?php
    session_start();
    include_once("../../../classes/Login.php");
    include_once("../../header.php");
    include_once("../../../classes/Condomino.php");
    include_once("../../../classes/Funcionario.php");
    $logado = Login::authUser($_SESSION['sessao']);
    $permissao = Login::checkPermission($_SESSION['sessao']);
    if ($permissao == 2){
        $result = Condomino::search($_SESSION['ID'], 'ID');
        $usuario = $result->fetch_all(MYSQLI_ASSOC);
    } elseif($permissao == 3){
        $result = Funcionario::search($_SESSION['ID'], 'ID');
        $usuario = $result->fetch_all(MYSQLI_ASSOC);
    }
    
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
            <form method="POST" action="editarcadastro.php">
                <fieldset>
                    <legend>Editar Cadastro</legend>
                    <div>
                        <label>Email*</label>
                        <input required type="text" name="email" value="<?= $usuario[0]['usuario'] ?>"><br>
                    </div>
                    <div>
                        <label>Senha*</label>
                        <input required type="password" name="senha1"><br>
                    </div>
                    <div>
                        <label>Digite novamente a Senha*</label>
                        <input required type="password" name="senha2"><br>
                    </div>
                    <input type="submit" class="button m-t-16" value="Enviar">
            </form>
        </div>
    </div>

    <?php
        include_once("../../../footer.php");
    ?>
</body>
</html>
<?php
    $senha1 = isset($_POST['senha1']) ? $_POST['senha1'] : null;
    $senha2 = isset($_POST['senha2']) ? $_POST['senha2'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;

    echo $senha1.$senha2.$email;

    if ($email && $senha1 && $senha2 && $senha1 == $senha2){
        if ($permissao == 2){
            Condomino::updateCadastro($senha1, $email, $_SESSION['ID']);
        } elseif ($permissao == 3){
            Funcionario::updateCadastro($senha1, $email, $_SESSION['ID']);
        }
    }
?>