<?php
        /*session_start();
    if (!defined('ROOT')) define('ROOT', 'localhost/ckeep/');
    include_once("../classes/Login.php");
    $id = $_SESSION['ID'];
    $logado = Login::authCondomino($id);*/
    include_once("../../header.php");
    include_once("../../classes/Reclamacao.php");
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
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
</body>
<?php
    $acao = (isset($_GET['acao'])) ? $_GET['acao'] : null;

    if ($id){
        //Implementar busca para condômino ou funcionário, dependendo do usuário;
        $result = Reclamacao::search($id, 'condominoID');
        $reclamacoes = $result->fetch_all(MYSQLI_ASSOC);

        echo "<table class=\"wrapper\">
        <tr>
            <th>Data</th>
            <th>Descrição</th>
            <th>Status</th>
            <th>Acao</th>
        </tr>";

        foreach ($reclamacoes as $reclamacoes){
            echo "<tr>
            <td>".date("d",strtotime($reclamacoes['datar']))."/".date("m",strtotime($reclamacoes['datar']))."</td>
            <td>".$reclamacoes['descricao']."</td>
            <td><a href=\"editarreclamacao.php?id=".$reclamacoes['ID']."\">Editar</a><br><a href=\"consultareclamacao.php?id=".$reclamacoes['ID']."&acao=excluir\">Excluir</a></td>
            </tr>";
        }        
    }

    if ($acao == 'excluir'){        
        $id = $_GET['id'];
        $result = Reclamacao::delete($id);
        if($result){
            header("Location: consultaprevisao.php");
            exit();
        }
    }
?>