<?php
    include_once ("Connection.php");
    /*A classe Veiculo é utilizada por todas as views relacionadas ao Veículo. 
    Seu primeiro elemento são os atributos, privados, e seus respectivos Sets e Gets.*/
    class Previsao{
        private $gastosID;
        private $valor;
        private $total;

        public function setGastosID($gastosID){
            $this->gastosID = $gastosID;
        }

        public function getGastosID(){
            return $this->gastosID;
        }

        public function setValor($valor){
            $this->valor = $valor;
        }

        public function getValor(){
            return $this->valor;
        }

        public function setTotal($total){
            $this->total = $total;
        }

        public function getTotal(){
            return $this->total;
        }

        public static function searchAllGastos($datag){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $stmt = $conn->prepare("SELECT * FROM gastos WHERE MONTH(?) = MONTH(datag)");
            $stmt->bind_param('s', $datag);
            if ($stmt->execute()){ 
                $result = $stmt->get_result();
                return $result;
            }
        }
    }