<?php
    session_start();
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../classes/Gasto.php");
    include_once("../../classes/Previsao.php");
    include_once("../../classes/Funcionario.php");
    $datag = (isset($_GET['datag'])) ? $_GET['datag'] : date('Y-m-d');

    if ($datag > date('Y-m-d')){
        header("Location: consultaprevisao.php?datag=$datag");
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
    <div class="lookup">
        <div class="wrapper">
            <form method="GET" action="consultaprevisao.php">
            <fieldset>
            <legend>Consulta de Mês e ano para Previsão de Gastos</legend>
            <label>Mês/Ano</label>
                <input type="date" name="datag">
                <input type="submit">
            </fieldset>
            </form>
        </div>
    </div>
    <br><h2>Previsão de Gastos para <?= $datag; ?></h2><br>
    <table class=wrapper>
    <tr>
        <th>Data</th>
        <th>ID</th>
        <th>Valor</th>
        <th>Tipo</th>
        <th>Descrição</th>
    </tr>
<?php
    include_once("../../footer.php");
?>
</body>
</html>
<?php
    if ($datag){
        $result = Previsao::searchAllGastosAnteriores($datag);
        $gastos = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($gastos as $gastos){
            echo "<tr>
            <td>".date("d",strtotime($gastos['datag']))."/".date("m",strtotime($gastos['datag']))."</td>
            <td>".$gastos['ID']."</td>
            <td>".$gastos['valor']."</td>
            <td>".$gastos['tipo']."</td>
            <td>".$gastos['descricao']."</td>";
            echo "</tr>";
        }

        echo "</table>";

        $total = Previsao::searchTotal($datag);
        $valortotal = $total->fetch_all(MYSQLI_ASSOC);
        echo "Valor total: ".$valortotal[0]['total'];
    }
?>