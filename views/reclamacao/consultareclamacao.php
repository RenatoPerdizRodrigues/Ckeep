<?php
    session_start();
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../classes/Veiculo.php");
    include_once("../../classes/Condomino.php");
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
        <form method="POST" action="consultaveiculo.php">
        <fieldset>
        <legend>Consulta de Veículo</legend>
        <label>Qual o método de pesquisa?</label>
            <select name="tipoconsulta">
                <option value="placa">Placa</option>
                <option value="modelo">Modelo</option>
                <option value="nome">Nome do Proprietário</option>
            </select><br>
            <label>Conteúdo</label>
            <input type="text" name="conteudo"><br><br>
            <input type="submit">
        </fieldset>
        </form>
    </div>
</body>
</html>
<?php
    //Com base no tipo de consulta, o método estático search(), da classe Veiculo, é realizado.
    $tipo = isset($_POST['tipoconsulta']) ? $_POST['tipoconsulta'] : null;
    $conteudo = isset($_POST['conteudo']) ? $_POST['conteudo'] : null;
    $acao = isset($_GET['acao']) ? $_GET['acao'] : null;
    $result = null;
    if ($tipo){
        if ($tipo == 'nome'){
        $condomino = Condomino::search($conteudo, $tipo);
        $usuario = $condomino->fetch_all(MYSQLI_ASSOC);

        echo "<br><br><table class=\"wrapper\">
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Placa</th>
            <th>Cor</th>
            <th>Proprietário</th>
            <th>Ação</th>
        </tr>";
        foreach($usuario as $usuario){
        $result = Veiculo::search($usuario['ID'], 'condominoID');
        foreach($result as $key){
            echo "<tr>
                <td>".$key['ID']."</td>
                <td>".$key['tipo']."</td>
                <td>".$key['marca']."</td>
                <td>".$key['modelo']."</td>
                <td>".$key['placa']."</td>
                <td>".$key['cor']."</td>
                <td>".$usuario['nome'].' '.$usuario['sobrenome']."</td>
                <td><a href=\"editarveiculo.php?id=".$key['ID']."\">Editar</a><br><a href=\"?id=".$key['ID']."&acao=excluir\">Excluir</a></td>
            </tr>";
        }
        }
        echo "</table>";

    } else {        
        $result = Veiculo::search($conteudo, $tipo);
        $veiculo = $result->fetch_all(MYSQLI_ASSOC);
        if (!$veiculo){
            header("Location: consultaveiculo.php");
            exit();
        }
        $resultado = Condomino::search($veiculo[0]['condominoID'] ,'ID');
        $usuario = $resultado->fetch_all(MYSQLI_ASSOC);

        echo "<br><br><table class=\"wrapper\">
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Placa</th>
            <th>Cor</th>
            <th>Proprietário</th>
            <th>Ação</th>
        </tr>";
        foreach($result as $key){
            echo "<tr>
                <td>".$key['ID']."</td>
                <td>".$key['tipo']."</td>
                <td>".$key['marca']."</td>
                <td>".$key['modelo']."</td>
                <td>".$key['placa']."</td>
                <td>".$key['cor']."</td>
                <td>".$usuario[0]['nome'].' '.$usuario[0]['sobrenome']."</td>
                <td><a href=\"editarveiculo.php?id=".$key['ID']."\">Editar</a><br><a href=\"?id=".$key['ID']."&acao=excluir\">Excluir</a></td>
            </tr>";
        }
        echo "</table>";
    }
    }
    if ($acao == 'excluir'){
        $result = Veiculo::delete($_GET['id']);
    }
?>