<?php
    include_once ("Connection.php");
    /*A classe Veiculo é utilizada por todas as views relacionadas ao Veículo. 
    Seu primeiro elemento são os atributos, privados, e seus respectivos Sets e Gets.*/
    class Reclamacao extends Connection{
        private $datar;
        private $descricao;
        private $resposta;
        private $aberto;

        public function setData($datar){
            $this->datar = $datar;
        }

        public function getData(){
            return $this->datar;
        }
        
        public function setDescricao($descricao){
            $this->descricao = $descricao;
        }

        public function getDescricao(){
            return $this->descricao;
        }

        public function setResposta($resposta){
            $this->resposta = $resposta;
        }

        public function getResposta(){
            return $this->resposta;
        }

        public function setAberto($aberto){
            $this->aberto = $aberto;
        }

        public function getAberto(){
            return $this->aberto;
        }

        /*O construtor da classe define todos os seus atributos*/
        public function Reclamacao($datar, $descricao, $aberto){
            $this->setData($datar);
            $this->setDescricao($descricao);
            $this->setAberto($aberto);
        }

        

        /*Função de inserção de funcionário, chamada por um objeto Funcionário.*/
        public function insertCondomino($id){
            $data = $this->getData();
            $descricao = $this->getDescricao();
            $aberto = $this->getAberto();

            echo "<br>".$data."<br>";
            echo "<br>".$descricao."<br>";
            echo "<br>".$aberto."<br>";

            $conn = $this->connectDB();
            $stmt = $conn->prepare("INSERT INTO reclamacao (condominoID, datar, descricao, aberto) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('issi', $id, $data, $descricao, $aberto);
            
            if ($stmt->execute()){
                echo "Inserido com sucesso!";
            } else echo $stmt->error;
        }

        public function insertFuncionario($id){
            $data = $this->getData();
            $descricao = $this->getDescricao();
            $aberto = $this->getAberto();
            $conn = $this->connectDB();
            $stmt = $conn->prepare("INSERT INTO reclamacao (funcionarioID, datar, descricao, aberto) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('issi', $id, $data, $descricao, $aberto);
            
            if ($stmt->execute()){
                echo "Inserido com sucesso!";
            } else echo $stmt->error;
        }

        /*Função estática para poder ser acessada sem a criação de um objeto.
        Recebe como parâmetro o tipo de dado a ser comparado na tabela
        e seu conteúdo. Caso seja procura por Nome, divide o conteúdo entre Nome e Sobrenome,
        e busca utilizando AND e LIKE.*/

        public static function search($tipo){
            $conn = new mysqli("localhost", DB_NAME, DB_PASS, "ckeep");     
                $stmt = $conn->prepare("SELECT * FROM gastos WHERE tipo = ?");
                $stmt->bind_param('s', $tipo);
                    if ($stmt->execute()){ 
                            $result = $stmt->get_result();
                            return $result;
                        }
        }

        public static function countReclamacao(){
            $conn = new mysqli("localhost", DB_NAME, DB_PASS, "ckeep");
                                    
            $stmt = $conn->prepare("SELECT * FROM reclamacao WHERE aberto = 1");
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

        public static function countReclamacaoUsuario($id, $table){
            $conn = new mysqli("localhost", DB_NAME, DB_PASS, "ckeep");
                                    
            if ($table == 'condominoID'){
                $stmt = $conn->prepare("SELECT * FROM reclamacao WHERE aberto = 1 AND condominoID = ?");
                $stmt->bind_param('s', $id);
                if ($stmt->execute()){ 
                    $contagem = 0;
                    $result = $stmt->get_result();
                    $status = $result->fetch_all(MYSQLI_ASSOC);
                    foreach($status as $status){
                        $contagem++;
                    }
                    return $contagem;
                }               
            } elseif ($table == 'funcionarioID'){
                $stmt = $conn->prepare("SELECT * FROM reclamacao WHERE aberto = 1 AND funcionarioID = ?");
                $stmt->bind_param('s', $id);
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
        }

        /*Função de exclusão, que não permite a exclusão de usuário
        caso o mesmo seja responsável financeiro por algum apartamento.*/
        public static function delete($id){
            $conn = new mysqli("localhost", DB_NAME, DB_PASS, "ckeep");
            $stmt = $conn->prepare("DELETE FROM reclamacao WHERE ID = ?");
            $stmt->bind_param('i', $id);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                return $result;
            } else echo $stmt->error;
        }

        //Daqui pra baixo, teremos que ver editar, responder e fechar
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
