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
    <form class="wrapper" method="POST" action="login.php">
        <fieldset>
            <legend>Login</legend>
            <label>Tipo de Usuário</label>
            <select name="tipo">
                <option value="condomino">Condômino</option>
                <option value="funcionario">Funcionário</option>
                <option value="administrador">Administrador</option>
            </select>
            <label>Usuário</label>
            <input type="text" name="usuario">
            <label>Senha</label>
            <input type="password" name="senha"><br>
            <input type="submit">
        </fieldset>
    </form>
</body>
</html>
<?php
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
    $senha = isset($_POST['senha']) ? $_POST['senha'] : null;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;

    if ($usuario && $senha && $tipo){
        switch($tipo){

        case 'condomino':
            Login::checkUserLogin($usuario, $senha)
            exit();
            break;

        case 'funcionario':
            Login::checkFuncLogin($usuario, $senha);
            exit();
            break;

        case 'administrador':
            Login::checkAdmLogin($usuario, $senha);
            exit();
            break;
        }
    }
?>