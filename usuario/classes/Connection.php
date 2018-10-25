<?php
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