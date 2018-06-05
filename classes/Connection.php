<?php
    class Connection{
        private $mysqli;

        public function connectDb(){
            $mysqli = new mysqli("localhost", "root", "", "ckeep");
            if (!$mysqli){
                echo "Não foi possível conectar";
            } else {
            return $mysqli;
            }
        }
    }
?>