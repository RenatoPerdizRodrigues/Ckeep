<?php
    session_start();
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    include_once("../../header.php");
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
        <form method="POST" action="localizacaocadastroveiculo.php">
        <fieldset>
        <legend>Consulta de Condômino para Cadastro de Veículo</legend>
        <label>Quem é o proprietário do veículo a ser cadastrado??</label><br><br>
        <label>Consultar por</label>
            <select name="tipoconsulta">
                <option value="nome">Nome</option>
                <option value="rg">RG</option>
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
    //Com base no tipo de consulta, o método estático search(), da classe Condomino, é realizado.
    $tipo = isset($_POST['tipoconsulta']) ? $_POST['tipoconsulta'] : null;
    $conteudo = isset($_POST['conteudo']) ? $_POST['conteudo'] : null;
    $acao = isset($_GET['acao']) ? $_GET['acao'] : null;
    if ($tipo){
        $result = Condomino::search($conteudo, $tipo);
        echo "<br><br><table class=\"wrapper\">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>RG</th>
            <th>Apartamento</th>
            <th>Ação</th>
        </tr>";
        foreach($result as $key){
            echo "<tr>
                <td>".$key['ID']."</td>
                <td>".$key['nome']."</td>
                <td>".$key['sobrenome']."</td>
                <td>".$key['rg']."</td>
                <td>".$key['apartamento']."</td>
                <td><a href=\"cadastroveiculo.php?id=".$key['ID']."\">Cadastrar Veículo</a><br></td>
            </tr>";
        }
        echo "</table>";
    }
?>