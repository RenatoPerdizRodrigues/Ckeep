<?php
    include_once ("Connection.php");
    /*A classe Veiculo é utilizada por todas as views relacionadas ao Veículo. 
    Seu primeiro elemento são os atributos, privados, e seus respectivos Sets e Gets.*/
    class Aviso extends Connection{
        private $dataav;
        private $descricao;
        private $vencimento;

        public function setData($dataav){
            $this->dataav = $dataav;
        }

        public function getData(){
            return $this->dataav;
        }
        
        public function setDescricao($descricao){
            $this->descricao = $descricao;
        }

        public function getDescricao(){
            return $this->descricao;
        }

        public function setVencimento($vencimento){
            $this->vencimento = $vencimento;
            
            $this->vencimento = $vencimento;
        }

        public function getVencimento(){
            return $this->vencimento;
        }

        /*O construtor da classe define todos os seus atributos*/
        public function Aviso($dataav, $descricao){
            $this->setData($dataav);
            $this->setDescricao($descricao);
        }

        /*Função de inserção de funcionário, chamada por um objeto Funcionário.*/
        public function insert(){
            $data = $this->getData();
            $descricao = $this->getDescricao();
            $vencimento = $this->getVencimento();
            $conn = $this->connectDB();
            $stmt = $conn->prepare("INSERT INTO aviso (dataav, descricao, vencimento) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $data, $descricao, $vencimento);
            
            if ($stmt->execute()){
                echo "Inserido com sucesso!";
            } else echo $stmt->error;
        }

        /*Função estática para poder ser acessada sem a criação de um objeto.
        Recebe como parâmetro o tipo de dado a ser comparado na tabela
        e seu conteúdo. Caso seja procura por Nome, divide o conteúdo entre Nome e Sobrenome,
        e busca utilizando AND e LIKE.*/
        public static function search($data){
            $conn = new mysqli("localhost", "root", "", "ckeep");     
                $stmt = $conn->prepare("SELECT * FROM aviso WHERE MONTH(?) = MONTH(dataav)");
                $stmt->bind_param('s', $data);
                    if ($stmt->execute()){ 
                            $result = $stmt->get_result();
                            return $result;
                        }
        }

        public static function countAvisosAtivos(){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $hoje = date('Y-m-d');
            $stmt = $conn->prepare("SELECT * FROM aviso WHERE vencimento > ?");
            $stmt->bind_param('s', $hoje);
            if ($stmt->execute()){ 
                $contagem = 0;
                $result = $stmt->get_result();
                $status = $result->fetch_all(MYSQLI_ASSOC);
                foreach($status as $status){
                    $contagem++;
                }
                return $contagem;
            }               
        }

        //Busca todos os avisos que ainda não passaram da data de vencimento
        public static function searchAtivos($hoje){
            $conn = new mysqli("localhost", "root", "", "ckeep");     
            $stmt = $conn->prepare("SELECT * FROM aviso WHERE ? <= vencimento");
            $stmt->bind_param('s', $hoje);
            if ($stmt->execute()){ 
                $result = $stmt->get_result();
            return $result;
            }
        }

        public static function searchAll($conteudo, $tipo){
            $conn = new mysqli("localhost", "root", "", "ckeep");     
                $stmt = $conn->prepare("SELECT * FROM aviso WHERE $tipo=?");
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
            $stmt = $conn->prepare("DELETE FROM aviso WHERE ID = ?");
            $stmt->bind_param('i', $id);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                return $result;
            } else echo $stmt->error;
        }

        
        public function update($id){
            $data = $this->getData();
            $descricao = $this->getDescricao();
            $conn = $this->connectDB();
            $stmt = $conn->prepare("UPDATE aviso SET dataav = ?, descricao = ? WHERE ID = ?");
            $stmt->bind_param('ssi', $data, $descricao, $id);

            if ($stmt->execute()){
                echo "Editada com sucesso!";
            } else echo $stmt->error;
        }

        
}
?>
