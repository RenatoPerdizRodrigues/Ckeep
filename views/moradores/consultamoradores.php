<?php
    /*
    session_start();
    $id = $_SESSION['ID'];
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($id);
    */
    include_once("../../header.php");
    include_once("../../classes/Moradores.php");
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
        <form method="POST" action="consultamoradores.php">
        <fieldset>
        <legend>Consultar moradores por apartamento</legend>
        <label>Apartamento</label>
        <input type="text" name="apartamento"><br><br>
        <input type="submit">
        </fieldset>
        </form>
    </div>
</body>
</html>
<?php
    //Com base no tipo de consulta, o método estático search(), da classe Condomino, é realizado.
    $apartamento = isset($_POST['apartamento']) ? $_POST['apartamento'] : null;

    if ($apartamento){
        $result = Moradores::search($apartamento);
        echo "<br><br><table class=\"wrapper\">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>Ação</th>
        </tr>";
        foreach($result as $key){
            echo "<tr>
                <td>".$key['ID']."</td>
                <td>".$key['nome']."</td>
                <td>".$key['sobrenome']."</td>
                <td><a href=\"consultamoradores.php?id=".$key['ID']."&acao=1&ap=".$key['apartamento']."\">Definir como Titular</a><br></td>
            </tr>";
            $apartamento = $key['apartamento'];
        }
        echo "</table>";
    }

    $ap = isset($_GET['ap']) ? $_GET['ap'] : null;
    $id2 = isset($_GET['id']) ? $_GET['id'] : null;
    $acao = isset($_GET['acao']) ? $_GET['acao'] : null;

    if ($acao == 1 && $id2 && $ap){
        Moradores::definirTitular($id2, $ap);
    }
?>