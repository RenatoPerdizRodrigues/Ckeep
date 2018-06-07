<?php
    session_start();
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../classes/Funcionario.php");
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
            <form method="POST" action="consultafuncionario.php">
            <fieldset>
            <legend>Consulta de Funcionário</legend>
            <label>Qual o método de pesquisa?</label>
                <select name="tipoconsulta">
                    <option value="nome">Nome</option>
                    <option value="rg">RG</option>
                    <option value="cargo">Cargo</option>
                </select><br>
                <label>Conteúdo</label>
                <input type="text" name="conteudo"><br><br>
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
    //Com base no tipo de consulta, o método estático search(), da classe Condomino, é realizado.
    $tipo = isset($_POST['tipoconsulta']) ? $_POST['tipoconsulta'] : null;
    $conteudo = isset($_POST['conteudo']) ? $_POST['conteudo'] : null;
    $acao = isset($_GET['acao']) ? $_GET['acao'] : null;
    if ($tipo){
        $result = Funcionario::search($conteudo, $tipo);
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
            <th>Carteira de Trabalho</th>
            <th>Salário</th>
            <th>Cargo</th>
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
                <td>".$key['carteiratrab']."</td>
                <td>".$key['salario']."</td>
                <td>".$key['cargo']."</td>";

                //Checa se o usuário é administrador ou não

                if ($key['permissao'] == 0){
                    echo "<td><a href=\"editarfuncionario.php?id=".$key['ID']."\">Editar</a><br><a href=\"?id=".$key['ID']."&acao=excluir\">Excluir</a><a href=\"?id=".$key['ID']."&acao=administrador\">Dar privilégios administrativos</a></td>
                    </tr>";
                } elseif($key['permissao'] == 1){
                    echo "<td><a href=\"editarfuncionario.php?id=".$key['ID']."\">Editar</a><br><a href=\"?id=".$key['ID']."&acao=excluir\">Excluir</a><a href=\"?id=".$key['ID']."&acao=funcionario\">Remover privilégios administrativos</a></td>
                    </tr>";
                }
        }
        echo "</table>";
    }
    if ($acao == 'excluir'){
        $result = Funcionario::delete($_GET['id']);
    }

    if ($acao == 'administrador'){
        $result = Funcionario::adicionarPrivilegiosAdministrativos($_GET['id']);
    }

    if ($acao == 'funcionario'){
        $result = Funcionario::removerPrivilegiosAdministrativos($_GET['id']);
    }
?>