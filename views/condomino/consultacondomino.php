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
        <form method="POST" action="consultacondomino.php">
        <fieldset>
        <legend>Consulta de Usuário</legend>
        <label>Qual o método de pesquisa?</label>
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
    if ($tipo == 'nome'){
        $result = Condomino::search($conteudo, $tipo);
        echo "<br><br><table class=\"wrapper\">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>RG</th>
            <th>CPF</th>
            <th>Idade</th>
            <th>Telefone 1</th>
            <th>Telefone 2</th>
            <th>Apartamento</th>
            <th>Titular</th>
            <th>Ação</th>
        </tr>";
        foreach($result as $key){
            echo "<tr>
                <td>".$key['ID']."</td>
                <td>".$key['nome']."</td>
                <td>".$key['sobrenome']."</td>
                <td>".$key['rg']."</td>
                <td>".$key['cpf']."</td>
                <td>".$key['idade']."</td>
                <td>".$key['tel1']."</td>
                <td>".$key['tel2']."</td>
                <td>".$key['apartamento']."</td>
                <td>".$key['titular']."</td>
                <td><a href=\"editarcondomino.php?id=".$key['ID']."\">Editar</a><br><a href=\"?id=".$key['ID']."&acao=excluir\">Excluir</a></td>
            </tr>";
        }
        echo "</table>";
    } elseif($tipo == 'rg'){
        $result = Condomino::search($conteudo, $tipo);
        echo "<br><br><table class=\"wrapper\">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>RG</th>
            <th>CPF</th>
            <th>Idade</th>
            <th>Telefone 1</th>
            <th>Telefone 2</th>
            <th>Titular</th>
            <th>Ação</th>
        </tr>";
        foreach($result as $key){
            echo "<tr>
                <td>".$key['ID']."</td>
                <td>".$key['nome']."</td>
                <td>".$key['sobrenome']."</td>
                <td>".$key['rg']."</td>
                <td>".$key['cpf']."</td>
                <td>".$key['idade']."</td>
                <td>".$key['tel1']."</td>
                <td>".$key['tel2']."</td>
                <td>".$key['titular']."</td>
                <td><a href=\"?id=".$key['ID']."&acao=editar\">Editar</a><br><a href=\"?id=".$key['ID']."&acao=excluir\">Excluir</a></td>
            </tr>";
        }
        echo "</table>";
    }
    if ($acao == 'excluir'){
        $result = Condomino::delete($_GET['id']);
    }
?>