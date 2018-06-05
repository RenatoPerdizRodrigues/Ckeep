<?php
    include_once ("Connection.php");
    /*A classe Veiculo é utilizada por todas as views relacionadas ao Veículo. 
    Seu primeiro elemento são os atributos, privados, e seus respectivos Sets e Gets.*/
    class Gasto extends Connection{
        private $data;
        private $valor;
        private $tipo;
        private $descricao;

        public function setData($data){
            $this->data = $data;
        }

        public function getData(){
            return $this->data;
        }

        public function setValor($valor){
            $this->valor = $valor;
        }

        public function getValor(){
            return $this->valor;
        }

        public function setTipo($tipo){
            $this->tipo = $tipo;
        }

        public function getTipo(){
            return $this->tipo;
        }
        
        public function setDescricao($descricao){
            $this->descricao = $descricao;
        }

        public function getDescricao(){
            return $this->descricao;
        }

        /*O construtor da classe define todos os seus atributos*/
        public function Gasto($data, $valor, $tipo, $descricao){
            $this->setData($data);
            $this->setValor($valor);
            $this->setTipo($tipo);
            $this->setDescricao($descricao);
        }

        /*Função de inserção de funcionário, chamada por um objeto Funcionário.*/
        public function insert(){
            $data = $this->getData();
            $valor = $this->getValor();
            $tipo = $this->getTipo();
            $descricao = $this->getDescricao();
            $conn = $this->connectDB();
            $stmt = $conn->prepare("INSERT INTO gastos (datag, valor, tipo, descricao) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('siis', $data, $valor, $tipo, $descricao);
            
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
                $stmt = $conn->prepare("SELECT * FROM gastos WHERE $tipo=?");
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
            $stmt = $conn->prepare("DELETE FROM gastos WHERE ID = ?");
            $stmt->bind_param('i', $id);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                return $result;
            } else echo $stmt->error;
        }

        
        public function update($id){
            $data = $this->getData();
            $valor = $this->getValor();
            $tipo = $this->getTipo();
            $descricao = $this->getDescricao();
            $conn = $this->connectDB();
            $stmt = $conn->prepare("UPDATE gastos SET datag = ?, valor = ?, tipo = ?, descricao = ? WHERE ID = ?");
            $stmt->bind_param('siisi', $data, $valor, $tipo, $descricao, $id);

            if ($stmt->execute()){
                echo "Editado com sucesso!";
            } else echo $stmt->error;
        }
}
?>
