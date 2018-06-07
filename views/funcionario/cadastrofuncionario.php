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
    <div class="container m-y-32 bg-white">
        <div class="wrapper">
            <form method="POST" action="cadastrofuncionario.php">
            <fieldset>
            <legend>Cadastro de Funcionário</legend>
                <div>
                    <label>Nome*</label>
                    <input required type="text" name="nome"><br>
                </div>
                <div>
                    <label>Sobrenome*</label>
                    <input required type="text" name="sobrenome"><br>
                </div>
                <div class="twoFields">
                    <div>
                        <label>RG*</label>
                        <input required type="text" name="rg"><br>
                    </div>
                    <div>
                        <label>CPF*</label>
                        <input required type="text" name="cpf"><br>
                    </div>
                </div>
                <div class="threeFields">
                    <div>
                        <label>Idade*</label>
                        <input required type="number" name="idade"><br>
                    </div>
                    <div>
                        <label>Telefone 1*</label>
                        <input required type="number" name="tel1"><br>
                    </div>
                    <div>
                        <label>Telefone 2</label>
                        <input type="number" name="tel2"><br>
                    </div>
                </div>
                <div>
                    <label>Carteira de Trabalho*</label>
                    <input required type="number" name="carteiratrab"><br>
                </div>
                <div>
                    <label>Salário*</label>
                    <input required type="number" name="salario"><br>
                </div>
                <div>
                    <label>Cargo*</label>
                    <input required type="text" name="cargo"><br>
                </div>
                <div>
                    <label>E-mail*</label>
                    <input required type="text" name="email"><br>
                </div>
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
    /*Em caso de primeiro nome composto, ele é dividido, e tem sua primeira palavra inserida
    em "Nome" e as outras acrescentadas em "Sobrenome", para facilitar a busca.*/
    $sobrenome = '';
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
    if (isset($nome)){
            $nomes = explode(' ', $nome);
            $nome = $nomes[0];
            $nomes = array_slice($nomes, 1);
            foreach($nomes as $nome){
                $sobrenome .= " $nome";
            }
        }
    $sobrenome .= isset($_POST['sobrenome']) ? $_POST['sobrenome'] : null;
    if (isset($nome) && isset($sobrenome)){
        $sobrenome = trim($sobrenome);
    }
    $rg = isset($_POST['rg']) ? $_POST['rg'] : null;
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
    $idade = isset($_POST['idade']) ? $_POST['idade'] : null;
    $tel1 = isset($_POST['tel1']) ? $_POST['tel1'] : null;
    $tel2 = isset($_POST['tel2']) ? $_POST['tel2'] : null;
    $carteiratrab = isset($_POST['carteiratrab']) ? $_POST['carteiratrab'] : null;
    $salario = isset($_POST['salario']) ? $_POST['salario'] : null;
    $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;

    if ($nome && $sobrenome && $rg && $cpf && $idade && $tel1 && $carteiratrab && $salario && $cargo && $email){
        //Objeto Condômino é criado e se insere no banco de dados através da função insert().
        if ($user = new Funcionario($nome, $sobrenome, $rg, $cpf, $idade, $tel1, $tel2, $carteiratrab, $salario, $cargo, $email)){
        $user->insert();
        }
    }
?>