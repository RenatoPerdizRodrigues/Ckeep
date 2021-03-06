<?php
        session_start();
        include_once("../../classes/Login.php");
        $logado = Login::authAdm($_SESSION['sessao']);
        include_once("../../header.php");
        include_once("../../usuario/classes/Reclamacao.php");
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

        //Implementar busca para condômino ou funcionário, dependendo do usuário;
        $result = Reclamacao::listAllOpen();
        $reclamacoes = $result->fetch_all(MYSQLI_ASSOC);
        
        echo "<table>
        <tr>
            <th>Data</th>
            <th>Descrição</th>
            <th>Status</th>
            <th>Ação</th>
            <th>Resposta</th>
        </tr>";
        
        foreach ($reclamacoes as $reclamacoes){
            //Checa se a reclamação está aberta ou fechada;
            $aberto;
            if ($reclamacoes['aberto'] == 1){
                $aberto = "Aberta";
            } else {$aberto = "Fechada";}

            //Checa se há resposta
            $resposta;
            if (!is_null($reclamacoes['resposta'])){
                $resposta = true;
            } elseif(is_null($reclamacoes['resposta'])) {$resposta = false;}

            echo "<tr>
            <td>".date("d",strtotime($reclamacoes['datar']))."/".date("m",strtotime($reclamacoes['datar']))."</td>
            <td>".$reclamacoes['descricao']."</td>";

            echo "<td>".$aberto."</td>";
            
            if ($aberto == "Aberta"){
                echo "<td><a href=\"responderreclamacao.php?id=".$reclamacoes['ID']."\">Responder</a><br><a href=\"consultareclamacao.php?id=".$reclamacoes['ID']."&acao=fechar\">Fechar</a></td>";
            } elseif ($aberto == "Fechado"){
                echo "<td><a href=\"responderreclamacao.php?id=".$reclamacoes['ID']."\">Responder</a><br><a href=\"consultareclamacao.php?id=".$reclamacoes['ID']."&acao=reabrir\">Reabrir</a></td>";
            }

            if($resposta){
                echo "<td><a href=editarresposta.php?id=".$reclamacoes['ID'].">Visualizar ou Editar Resposta</a></td>";
            }

            echo "</tr>";
        }        
    

    if ($acao == 'fechar'){        
        $id = $_GET['id'];
        $result = Reclamacao::fechar($id);
    }
?>