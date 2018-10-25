<?php
    //Defina o nome do banco de dados
    define('DB_NAME', "ckeep");

    //Defina a senha do banco de dados
    define('DB_PASS', "pass");
    
    class Connection{
        private $mysqli;
        

        public function connectDb(){
            $mysqli = new mysqli("localhost", DB_NAME, DB_PASS, "ckeep");
            if (!$mysqli){
                echo "Não foi possível conectar";
            } else {
            return $mysqli;
            }
        }
    }
?>