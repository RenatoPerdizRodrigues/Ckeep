<?php
    /*
    session_start();
    $id = $_SESSION['ID'];
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($id);
    */
    include_once("../../header.php");
    include_once("../../classes/Pagador.php");
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
</html>
<?php  

    $id = isset($_GET['id']) ? $_GET['id'] : null;
        $responsaveis = Pagador::search();
        $vazios = Pagador::searchVazios();
        echo "<br><br><table class=\"wrapper\">
        <tr>
            <th>Apartamento</th>
            <th>Responsável</th>
            <th>Status de Pagamento</th>
            <th>Ação</th>
        </tr>";
        foreach($responsaveis as $key){
            echo "<tr>
                <td>".$key['apartamento']."</td>
                <td>".$key['ID']."</td>
                <td>"; if ($key['statuspagamento'] == NULL) { echo "Não pagante"; } elseif($key['statuspagamento'] == 1){ echo "Em dia";} elseif($key['statuspagamento'] == 0){ echo "Não pagante";} echo "</td>
                <td><a href=consultastatuspagador.php?id=".$key['ID'].">Alterar Status</a></td>
            </tr>";
        }
        echo "</table>";
    
        echo "<br><br>Apartamentos vazios:";

        foreach($vazios as $vazios){
            echo " ".$vazios['apartamento'];
        }

    if ($id){
        Pagador::alterarStatus($id);
        header("Location: consultastatuspagador.php");
    }
?>