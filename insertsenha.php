<?php
    $user = "admin";
    $senha = "admin";
    $id = 1;
    $hashPwd = password_hash($senha, PASSWORD_DEFAULT);

    $conn = new mysqli("localhost", "root", "", "ckeep");
    $stmt = $conn->prepare("UPDATE funcionario SET usuario = ?, senha = ? WHERE ID = ?");
    $stmt->bind_param('ssi', $user, $hashPwd, $id);
    if ($stmt->execute()){
        echo "ok";
    } else echo $stmt->error;
?>