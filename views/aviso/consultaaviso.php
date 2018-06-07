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
    <div class="lookup">
        <div class="wrapper">
            <form method="POST" action="consultaaviso.php">
            <fieldset>
            <legend>Consulta de Avisos por Mês e Ano</legend>
            <div>
                <label>Mês/Ano</label>
                    <input type="date" name="datag"><br>
            </div>
                <input type="submit" class="button" value="Enviar">
            </fieldset>
            </form>
        </div>
    </div>
<?php
    $datag = (isset($_POST['datag'])) ? $_POST['datag'] : null;
    $acao = (isset($_GET['acao'])) ? $_GET['acao'] : null;

    if ($datag){
        $result = Aviso::search($datag);
        $avisos = $result->fetch_all(MYSQLI_ASSOC);

        echo "<table class=\"wrapper\">
        <tr>
            <th>Data</th>
            <th>Descrição</th>
        </tr>";

        foreach ($avisos as $avisos){
            echo "<tr>
            <td>".date("d",strtotime($avisos['dataav']))."/".date("m",strtotime($avisos['dataav']))."</td>
            <td>".$avisos['descricao']."</td>
            <td><a href=\"editaraviso.php?id=".$avisos['ID']."\">Editar</a><br><a href=\"consultaaviso.php?id=".$avisos['ID']."&acao=excluir\">Excluir</a></td>
            </tr>";
        }        
    }

    if ($acao == 'excluir'){        
        $id = $_GET['id'];
        $result = Aviso::delete($id);
        if($result){
            header("Location: consultaprevisao.php");
            exit();
        }
    }
?>
<?php
    include_once("../../footer.php");
?>
</body>