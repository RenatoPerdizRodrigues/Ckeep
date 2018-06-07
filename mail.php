<?php
    $from = "renato@hotmail.com";

    $to = "rebsunderline@hotmail.com";

    $subject = "Cadastro em CKEEP";

    $message = "Seu cadastro foi realizado! Clique aqui para alterar sua senha!";

    $headers =  'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'From: Your name <info@address.com>' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 


    mail($to, $subject, $message, $headers);

    echo "A mensagem foi enviada";

?>