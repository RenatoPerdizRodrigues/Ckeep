<?php
    session_start();
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../classes/Gasto.php");
    include_once("../../classes/Previsao.php");
    include_once("../../classes/Funcionario.php");
    $datag = (isset($_GET['datag'])) ? $_GET['datag'] : date('Y-m-d');
    $acao = isset($_GET['acao']) ? $_GET['acao'] : null;    
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
            <form method="GET" action="consultaprevisaoanterior.php">
            <fieldset>
            <legend>Consulta de Mês e Ano para Previsão de Gastos</legend>
            <label>Mês/Ano</label>
                <input type="date" name="datag"><br>
                <input type="submit" class="button" value="Enviar">
            </fieldset>
            </form>
        </div>
    </div>
    <?php
        //if ($datag > date('Y-m-d')){
        //    echo "Não há previsão disponível para o mês selecionado!";
        //    exit();
        //}
    ?>

    <br><h2>Previsão de Gastos para <?= $datag; ?></h2><br>
    <table class=wrapper>
    <tr>
        <th>Data</th>
        <th>ID</th>
        <th>Valor</th>
        <th>Tipo</th>
        <th>Descrição</th>
        <th>Ação</th>
    </tr>
</body>
</html>
<?php
    //Verificamos se a data inserida é a padrão, anterior ou posterior
    if ($datag > date('Y-m-d')){
        echo "Usuário quer visualizar gastos futuros";
    } elseif($datag < date('Y-m-d')){
        echo "Usuário quer visualizar gastos passados";
    } else {
    $total = 0;
    
        $result = Previsao::searchAllGastos($datag);
        $gastos = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($gastos as $gastos){
            echo "<tr>
            <td>".date("d",strtotime($gastos['datag']))."/".date("m",strtotime($gastos['datag']))."</td>
            <td>".$gastos['ID']."</td>
            <td>".$gastos['valor']."</td>
            <td>".$gastos['tipo']."</td>
            <td>".$gastos['descricao']."</td>
            <td><a href=\"editargasto.php?id=".$gastos['ID']."\">Editar</a><br><a href=\"consultaprevisao.php?id=".$gastos['ID']."&acao=excluir\">Excluir</a></td>
            </tr>";
            $total += (int)$gastos['valor'];
        }        
    
        $result = Funcionario::searchAllFuncionarios();
        $salarios = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($salarios as $salarios){
            echo "<tr>
            <td>01/".date("m",strtotime($datag))."</td>
            <td>".$salarios['ID']."</td>
            <td>".$salarios['salario']."</td>
            <td>Fixo</td>
            <td>".$salarios['cargo']."</td>
            <td><a href=\"editargasto.php?id=".$salarios['ID']."\">Editar</a><br><a href=\"consultaprevisao.php?id=".$salarios['ID']."&acao=excluir\">Excluir</a></td>
            </tr>";
            $total += (int)$salarios['salario'];
        }

        echo "<tr><td></td><td></td><td></td><td></td><td><a href=\"cadastrogasto.php?datag=$datag\">Acrescentar Gasto</a></td></tr>";

        echo "</table><br><br><div class=\"wrapper\">Gasto Total: R$".$total."</div>";
    }

    if ($acao == 'excluir'){        
        $id = $_GET['id'];
        $result = Gasto::delete($id);
        if($result){
            header("Location: consultaprevisao.php");
            exit();
        }
    }


    //Função para verificar se é dia primeiro, para ativar ou não o fechamento de gastos
    $diahoje = date("d",strtotime(date('Y-m-d')));
    if ($diahoje === '01'){
        echo "entrou aqui";
        //Enviaria o datag para fechar o mês anterior, mas no caso enviamos algo manualmente
        //Previsao::fecharGastos($total, '2018-07-01');
    }
?>