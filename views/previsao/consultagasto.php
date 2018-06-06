<?php
    session_start();
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../classes/Reclamacao.php");
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
        <form method="POST" action="consultagasto.php">
        <fieldset>
        <legend>Consulta de Gastos</legend>
        <label>Tipo</label>
            <select name="tipo">
                <option value=1>Fixo</option>
                <option value=2>Extraordinário</option>
                <option value=3>Atividade</option>
            </select>
            <input type="submit">
        </fieldset>
        </form>
    </div>
<?php
    $tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : null;
    $acao = (isset($_GET['acao'])) ? $_GET['acao'] : null;

    if ($tipo){
        echo $tipo;
        $result = Reclamacao::search($tipo);
        $gastos = $result->fetch_all(MYSQLI_ASSOC);

        echo "<table class=\"wrapper\">
        <tr>
            <th>Data</th>
            <th>Valor</th>
            <th>Tipo</th>
            <th>Descrição</th>
        </tr>";

        foreach ($gastos as $gastos){
            echo "<tr>
            <td>".date("d",strtotime($gastos['datag']))."/".date("m",strtotime($gastos['datag']))."</td>
            <td>".$gastos['valor']."</td>
            <td>".$gastos['tipo']."</td>
            <td>".$gastos['descricao']."</td>
            <td><a href=\"editargasto.php?id=".$gastos['ID']."\">Editar</a><br><a href=\"consultaprevisao.php?id=".$gastos['ID']."&acao=excluir\">Excluir</a></td>
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