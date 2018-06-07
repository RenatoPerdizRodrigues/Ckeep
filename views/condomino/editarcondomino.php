<?php
    session_start();
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../classes/Condomino.php");
    //É realizada uma busca para os dados já cadastrados serem mostrados no formulário.
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $result = Condomino::search($id, 'ID');
        $usuario = $result->fetch_all(MYSQLI_ASSOC);       
    } else header("Location:consultacondomino.php");

    $etitular = false;
    if ($usuario[0]['titular'] == 1){
        $etitular = true;
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
    <div class="container m-y-32 bg-white">
        <div class="wrapper">
            <form method="POST" action="<?= 'editarcondomino.php?id='.$usuario[0]['ID']; ?>">
            <fieldset>
            <legend>Edição de Usuário</legend>        
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
                    <label>Apartamento</label>
                    <input <?php if ($etitular == true) { echo "disabled"; } ?> type="text" name="apartamento" value="<?= $usuario[0]['apartamento'] ?>"><br>
                </div>
                
                <!-- Caso o usuário esteja cadastrado como responsável financeiro do apartamento, ele não pode alterar seu apartamento nesta página. -->
                
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
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $apartamento = isset($_POST['apartamento']) ? $_POST['apartamento'] : null;

    if ($nome && $sobrenome && $rg && $cpf && $idade && $tel1){
        echo "UPDATE condomino SET nome = $nome, sobrenome = $sobrenome, rg = $rg, cpf = $cpf, idade = $idade, tel1 = $tel1, tel2 = $tel2, apartamento = $apartamento WHERE ID = $id";
        $user = new Condomino($nome, $sobrenome, $rg, $cpf, $idade, $tel1, $tel2, $apartamento);
        $user->update($id);
        //header("Location: consultacondomino.php");
        //exit();
    }
?>