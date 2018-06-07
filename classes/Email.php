<?php
    class Email{
        public static function criaHash($uniqueID){
            $uniqueIDhash = password_hash($uniqueID, PASSWORD_DEFAULT);
            return $uniqueIDhash;
        }

        public static function emailPrimeiroAcesso($email, $hash){
        $from = "ckeepadm@gmail.com";

        $to = "$email";

        $subject = "Cadastro em CKEEP";

        $message = "Seu cadastro foi realizado! <a href=\"http://localhost/ckeep/views/condomino/editarsenha.php?sess=$hash&em=".base64_encode($email)."\">Clique aqui para alterar sua senha!</a>";

        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: CKeep <info@address.com>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 


        mail($to, $subject, $message, $headers);

        echo "A mensagem foi enviada";
        }
    }
?>