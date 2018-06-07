<?php
    session_start();
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../classes/Aviso.php");
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
            <form method="POST" action="cadastroaviso.php">
            <fieldset>
            <legend>Cadastro de Aviso</legend>
        <div>
            <label>Data*</label>
            <input required type="hidden" name="data" value="<?= date('Y-m-d') ?>"><br>
            <input disabled type="date" name="data" value="<?= date('Y-m-d') ?>"><br>
        </div>
        <div>
            <label>Descrição*</label>
            <input required type="textarea" name="descricao"><br>
        </div>
        <div>
                <label>Ativo por</label>
                <select name="vencimento" required>
                    <option value="1">1 dia</option>
                    <option value="3">3 dias</option>
                    <option value="7">7 dias</option>
                </select><br>
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
    /*Em caso de primeiro nome composto, ele é dividido, e tem sua primeira palavra inserida
    em "Nome" e as outras acrescentadas em "Sobrenome", para facilitar a busca.*/
    $data = isset($_POST['data']) ? $_POST['data'] : null;
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;
    $vencimento = isset($_POST['vencimento']) ? $_POST['vencimento'] : null;
 
    if ($data && $descricao && $vencimento){
        //Verifica por quantos dias o aviso ficará ativo e acrescenta para a data
        if ($vencimento == 1){
            $vencimento = date('Y-m-d', strtotime($data. " + 1 days"));
        } elseif ($vencimento == 3){
            $vencimento = date('Y-m-d', strtotime($data. " + 3 days"));
        } elseif ($vencimento == 7){
            $vencimento = date('Y-m-d', strtotime($data. " + 7 days"));
        }
        if ($aviso = new Aviso($data, $descricao)){
            $aviso->setVencimento($vencimento);
        $aviso->insert();
        header("Location: consultaaviso.php?datag=".$data);
        }
    }
    
?>