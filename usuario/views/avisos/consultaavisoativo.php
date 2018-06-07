<?php
    session_start();
    include_once("../../../classes/Login.php");
    $logado = Login::authUser($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../../classes/Aviso.php");
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
        <br><h2>Avisos Ativos</h2><br>
            <?php
                $result = Aviso::searchAtivos(date('Y-m-d'));
                $avisos = $result->fetch_all(MYSQLI_ASSOC);

                    echo "<table class=\"wrapper\">
                    <tr>
                        <th>Data</th>
                        <th>Descrição</th>
                    </tr>";

                    foreach ($avisos as $avisos){
                        echo "<tr>
                        <td>".date("d",strtotime($avisos['dataav']))."/".date("m",strtotime($avisos['dataav']))."</td>
                        <td>".$avisos['descricao']."</td>
                        </tr>";
                    } 
            ?>
        </div>
    </div>
<?php
        include_once("../../../footer.php");
?>
</body>