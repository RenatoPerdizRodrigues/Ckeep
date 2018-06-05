<?php
    $user = "admin";
    $senha = "admin";
    $id = 1;
    $hashPwd = password_hash($senha, PASSWORD_DEFAULT);

    $conn = new mysqli("localhost", "root", "", "ckeep");
    $stmt = $conn->prepare("UPDATE funcionario SET usuario = ?, senha = ? WHERE ID = ?");
    $stmt->bind_param('ssi', $user, $hashPwd, $id);
    $stmt->execute();

    echo "Senha: $senha";
    echo '<br>';
    echo "Senha hasehada no sis: ".$hashPwd;
    echo "Senha hasheada tabela: ".$hashsis;
    echo "<br>";
    echo "Vamos realizar a verificação.";

    $check = password_verify('senha', $hashsis);

    if ($check == true){
        echo "Deu certo";
    } else echo "Deu errado";
?>