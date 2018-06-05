<?php
    include_once ("Connection.php");
    /*A classe Veiculo é utilizada por todas as views relacionadas ao Veículo. 
    Seu primeiro elemento são os atributos, privados, e seus respectivos Sets e Gets.*/
    class Veiculo extends Connection{
        private $tipo;
        private $marca;
        private $modelo;
        private $placa;
        private $cor;
        private $proprietario;

        public function setTipo($tipo){
            $this->tipo = $tipo;
        }

        public function getTipo(){
            return $this->tipo;
        }

        public function setMarca($marca){
            $this->marca = $marca;
        }

        public function getMarca(){
            return $this->marca;
        }

        public function setModelo($modelo){
            $this->modelo = $modelo;
        }

        public function getModelo(){
            return $this->modelo;
        }

        public function setPlaca($placa){
            $this->placa = $placa;
        }

        public function getPlaca(){
            return $this->placa;
        }

        public function setCor($cor){
            $this->cor = $cor;
        }

        public function getCor(){
            return $this->cor;
        }

        public function setProprietario($proprietario){
            $this->proprietario = $proprietario;
        }

        public function getProprietario(){
            return $this->proprietario;
        }
        
        /*O construtor da classe define todos os seus atributos*/
        public function Veiculo($tipo, $marca, $modelo, $placa, $cor, $proprietario){
            $this->setTipo($tipo);
            $this->setMarca($marca);
            $this->setModelo($modelo);
            $this->setPlaca($placa);
            $this->setCor($cor);
            $this->setProprietario($proprietario);
        }

        /*Função de inserção de funcionário, chamada por um objeto Funcionário.*/
        public function insert(){
            $tipo = $this->getTipo();
            $marca = $this->getMarca();
            $modelo = $this->getModelo();
            $placa = $this->getPlaca();
            $cor = $this->getCor();
            $proprietario = $this->getProprietario();
            $conn = $this->connectDB();
            $stmt = $conn->prepare("INSERT INTO veiculo (tipo, marca, modelo, placa, cor, condominoID) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssssi', $tipo, $marca, $modelo, $placa, $cor, $proprietario);
            
            if ($stmt->execute()){
                echo "Inserido com sucesso!";
            } else echo $stmt->error;
        }

        /*Função estática para poder ser acessada sem a criação de um objeto.
        Recebe como parâmetro o tipo de dado a ser comparado na tabela
        e seu conteúdo. Caso seja procura por Nome, divide o conteúdo entre Nome e Sobrenome,
        e busca utilizando AND e LIKE.*/
        public static function search($conteudo, $tipo){
            $conn = new mysqli("localhost", "root", "", "ckeep");     
                $stmt = $conn->prepare("SELECT * FROM veiculo WHERE $tipo=?");
                $stmt->bind_param('s', $conteudo);
                    if ($stmt->execute()){ 
                            $result = $stmt->get_result();
                            return $result;
                        }
        }

        /*Função de exclusão, que não permite a exclusão de usuário
        caso o mesmo seja responsável financeiro por algum apartamento.*/
        public static function delete($id){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $stmt = $conn->prepare("DELETE FROM veiculo WHERE ID = ?");
            $stmt->bind_param('i', $id);
            if ($stmt->execute()){
                echo "<br><div class=\"wrapper\">Exclusão bem sucedida</div>";
            } else echo $stmt->error;
        }

        
        public function update($id){
            $tipo = $this->getTipo();
            $marca = $this->getMarca();
            $modelo = $this->getModelo();
            $placa = $this->getPlaca();
            $cor = $this->getCor();
            $proprietario = $this->getProprietario();
            $conn = $this->connectDB();
            $stmt = $conn->prepare("UPDATE veiculo SET tipo = ?, marca = ?, modelo = ?, placa = ?, cor = ?, condominoID = ? WHERE ID = ?");
            $stmt->bind_param('sssssii', $tipo, $marca, $modelo, $placa, $cor, $proprietario, $id);

            if ($stmt->execute()){
                echo "Editado com sucesso!";
            } else echo $stmt->error;
        }
}
?>
