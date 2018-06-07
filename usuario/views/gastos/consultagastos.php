<?php
    session_start();
    include_once("../../../classes/Login.php");
    $logado = Login::authUser($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../../classes/Gasto.php");
    include_once("../../../classes/Previsao.php");
    include_once("../../../classes/Funcionario.php");
    $datag = (isset($_GET['datag'])) ? $_GET['datag'] : date('Y-m-d');

    if ($datag <= date('Y-m-d')){
        header("Location: consultagastos.php?datag=$datag");
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
            <br><h2>Gastos para <?= $datag; ?></h2><br>
            <table class=wrapper>
            <tr>
                <th>Data</th>
                <th>Valor</th>
                <th>Descrição</th>
            </tr>
</html>
<?php
    $condominio = 0;
    if ($datag){
        $result = Previsao::searchAllGastosAnteriores($datag);
        $gastos = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($gastos as $gastos){
            //Se for gasto fixo, aparece tudo junto;
            //Se for atividade ou emergencial, aparece separado;
            if ($gastos['tipo'] == 'Fixo'){
                $condominio += $gastos['valor'];
            } else {
            echo "<tr>
            <td>".date("d",strtotime($gastos['datag']))."/".date("m",strtotime($gastos['datag']))."</td>
            <td>".$gastos['valor']."</td>
            <td>".$gastos['descricao']."</td>";
            echo "</tr>";
            }
        }

        echo "<tr>
        <td>".$datag."</td>
        <td>".$condominio."</td>
        <td>Gastos do Condomínio</td>";

        echo "</table>";

        $total = Previsao::searchTotal($datag);
        $gastos = $total->fetch_all(MYSQLI_ASSOC);

        echo "<br>Gasto total: ".$gastos[0]['total'];

    }

    include_once("../../../footer.php");

?>
</div></div>
</body>