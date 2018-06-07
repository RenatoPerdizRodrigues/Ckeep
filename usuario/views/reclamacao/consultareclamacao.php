<?php
        session_start();
        include_once("../../../classes/Login.php");
        $logado = Login::authUser($_SESSION['sessao']);
        include_once("../../header.php");
        include_once("../../classes/Reclamacao.php");
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
            <br>
            <h3>Consulta de reclamações</h3>
            <br>

            <table>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
        <?php
            $acao = (isset($_GET['acao'])) ? $_GET['acao'] : null;

            if ($_SESSION['ID']){
                //Função que checa se o usuário é condômino (2) ou funcionário(3), para inserir com o respectivo ID
                $permissao = Login::checkPermission($_SESSION['sessao']);
                $table = '';
                if ($permissao == 2){
                    $table = 'condominoID';
                } elseif ($permissao == 3){
                    $table = 'funcionarioID';
                }
                //Implementar busca para condômino ou funcionário, dependendo do usuário;
                $result = Reclamacao::search($_SESSION['ID'], $table);
                $reclamacoes = $result->fetch_all(MYSQLI_ASSOC);
                
                foreach ($reclamacoes as $reclamacoes){
                    //Checa se a reclamação está aberta ou fechada;
                    $aberto;
                    if ($reclamacoes['aberto'] == 1){
                        $aberto = "Aberta";
                    } else {$aberto = "Fechada";}

                    echo "<tr>
                    <td>".date("d",strtotime($reclamacoes['datar']))."/".date("m",strtotime($reclamacoes['datar']))."</td>
                    <td>".$reclamacoes['descricao']."</td>";

                    echo "<td>".$aberto."</td>";
                    
                    if ($aberto == "Aberta" && $reclamacoes['resposta'] != NULL){
                        echo "<td><a href=\"visualizarresposta.php?id=".$reclamacoes['ID']."\">Visualizar Resposta</a><a href=\"consultareclamacao.php?id=".$reclamacoes['ID']."&acao=fechar\">Fechar</a><a href=\"editarreclamacao.php?id=".$reclamacoes['ID']."\">Editar</a><br><a href=\"consultareclamacao.php?id=".$reclamacoes['ID']."&acao=excluir\">Excluir</a></td>
                        </tr>";
                    } elseif ($aberto == "Aberta" && $reclamacoes['resposta'] == NULL){
                        echo "<td><a href=\"consultareclamacao.php?id=".$reclamacoes['ID']."&acao=fechar\">Fechar</a><a href=\"editarreclamacao.php?id=".$reclamacoes['ID']."\">Editar</a><br><a href=\"consultareclamacao.php?id=".$reclamacoes['ID']."&acao=excluir\">Excluir</a></td>
                        </tr>";
                    } else echo "<td>&nbsp</td></tr>";

                
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

            if ($acao == 'fechar'){        
                $id = $_GET['id'];
                $result = Reclamacao::fechar($id);
            }


                include_once("../../../footer.php");
        ?>
            </table>
        </div>
    </div>
</body>
