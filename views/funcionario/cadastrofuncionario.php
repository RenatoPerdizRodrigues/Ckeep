<?php
    /*
    session_start();
    $id = $_SESSION['ID'];
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($id);
    */
    include_once("../../header.php");
    include_once("../../classes/Funcionario.php");
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
    <div class="wrapper">
        <form method="POST" action="cadastrofuncionario.php">
        <fieldset>
        <legend>Cadastro de Funcionário</legend>
            <label>Nome*</label>
            <input required type="text" name="nome"><br>
            <label>Sobrenome*</label>
            <input required type="text" name="sobrenome"><br>
            <label>RG*</label>
            <input required type="text" name="rg"><br>
            <label>CPF*</label>
            <input required type="text" name="cpf"><br>
            <label>Idade*</label>
            <input required type="number" name="idade"><br>
            <label>Telefone 1*</label>
            <input required type="number" name="tel1"><br>
            <label>Telefone 2</label>
            <input type="number" name="tel2"><br>
            <label>Carteira de Trabalho*</label>
            <input required type="number" name="carteiratrab"><br>
            <label>Salário*</label>
            <input required type="number" name="salario"><br>
            <label>Cargo*</label>
            <input required type="text" name="cargo"><br>
            <input type="submit">
        </fieldset>
        </form>
    </div>
</body>
</html>
<?php
    /*Em caso de primeiro nome composto, ele é dividido, e tem sua primeira palavra inserida
    em "Nome" e as outras acrescentadas em "Sobrenome", para facilitar a busca.*/
    $sobrenome = '';
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
    if (isset($nome)){
            $nomes = explode(' ', $nome);
            $nome = $nomes[0];
            $nomes = array_slice($nomes, 1);
            foreach($nomes as $nome){
                $sobrenome .= " $nome";
            }
        }
    $sobrenome .= isset($_POST['sobrenome']) ? $_POST['sobrenome'] : null;
    if (isset($nome) && isset($sobrenome)){
        $sobrenome = trim($sobrenome);
    }
    $rg = isset($_POST['rg']) ? $_POST['rg'] : null;
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
    $idade = isset($_POST['idade']) ? $_POST['idade'] : null;
    $tel1 = isset($_POST['tel1']) ? $_POST['tel1'] : null;
    $tel2 = isset($_POST['tel2']) ? $_POST['tel2'] : null;
    $carteiratrab = isset($_POST['carteiratrab']) ? $_POST['carteiratrab'] : null;
    $salario = isset($_POST['salario']) ? $_POST['salario'] : null;
    $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : null;

    if ($nome && $sobrenome && $rg && $cpf && $idade && $tel1 && $carteiratrab && $salario && $cargo){
        //Objeto Condômino é criado e se insere no banco de dados através da função insert().
        if ($user = new Funcionario($nome, $sobrenome, $rg, $cpf, $idade, $tel1, $tel2, $carteiratrab, $salario, $cargo)){
        $user->insert();
        }
    }
?>