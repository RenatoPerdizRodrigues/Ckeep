<?php
    session_start();
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../classes/Funcionario.php");
    //É realizada uma busca para os dados já cadastrados serem mostrados no formulário.
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $result = Funcionario::search($id, 'ID');
        $usuario = $result->fetch_all(MYSQLI_ASSOC);       
    } //else header("Location: consultafuncionario.php");
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
    <div class="container m-y-32 bg-white">
        <div class="wrapper">
            <form method="POST" action="<?= 'editarfuncionario.php?id='.$usuario[0]['ID']; ?>">
            <fieldset>
            <legend>Edição de Funcionário</legend>        
                <input type="hidden" name="id" value="<?= $usuario[0]['ID']; ?>">
                <div>
                    <label>Nome</label>
                    <input type="text" name="nome" value="<?= $usuario[0]['nome']; ?>"><br>
                </div>
                <div>
                    <label>Sobrenome</label>
                    <input type="text" name="sobrenome" value="<?= $usuario[0]['sobrenome']; ?>"><br>
                </div>
                <div class="twoFields">
                    <div>
                        <label>RG</label>
                        <input type="text" name="rg" value="<?= $usuario[0]['rg']; ?>"><br>
                    </div>
                    <div>
                        <label>CPF</label>
                        <input type="text" name="cpf" value="<?= $usuario[0]['cpf']; ?>"><br>
                    </div>
                </div>
                <div class="threeFields">
                    <div>
                        <label>Idade</label>
                        <input type="number" name="idade" value="<?= $usuario[0]['idade']; ?>"><br>
                    </div>
                    <div>
                        <label>Telefone 1</label>
                        <input type="number" name="tel1" value="<?= $usuario[0]['tel1']; ?>"><br>
                    </div>
                    <div>
                        <label>Telefone 2</label>
                        <input type="number" name="tel2" value="<?= $usuario[0]['tel2']; ?>"><br>
                    </div>
                </div>
                <div>
                    <label>Carteira de Trabalho</label>
                    <input type="number" name="carteiratrab" value="<?= $usuario[0]['carteiratrab']; ?>"><br>
                </div>
                <div>
                    <label>Salário</label>
                    <input type="number" name="salario" value="<?= $usuario[0]['salario']; ?>"><br>
                </div>
                <div>
                    <label>Cargo</label>
                    <input type="text" name="cargo" value="<?= $usuario[0]['cargo']; ?>"><br>                      
                </div>
                <input type="submit" class="button" value="Enviar">
            </fieldset>
            </form>
        </div>
    </div>
    <?php
        include_once("../../footer.php");
?>
</body>
</html>
<?php
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
    $sobrenome = isset($_POST['sobrenome']) ? $_POST['sobrenome'] : null;
    $rg = isset($_POST['rg']) ? $_POST['rg'] : null;
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
    $idade = isset($_POST['idade']) ? $_POST['idade'] : null;
    $tel1 = isset($_POST['tel1']) ? $_POST['tel1'] : null;
    $tel2 = isset($_POST['tel2']) ? $_POST['tel2'] : null;
    $carteiratrab = isset($_POST['carteiratrab']) ? $_POST['carteiratrab'] : null;
    $salario = isset($_POST['salario']) ? $_POST['salario'] : null;
    $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : null;
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if ($nome && $sobrenome && $rg && $cpf && $idade && $tel1 && $tel2 && $carteiratrab && $salario && $cargo && $id){
        $user = new Funcionario($nome, $sobrenome, $rg, $cpf, $idade, $tel1, $tel2, $carteiratrab, $salario, $cargo);
        $user->update($id);
        header("Location: consultafuncionario.php");
        exit();
    }
?>