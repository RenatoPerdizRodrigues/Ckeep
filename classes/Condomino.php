<?php
    include_once ("Connection.php");
    /*A classe condômino é utilizada por todas as views relacionadas ao Condômino. 
    Seu primeiro elemento são os atributos, privados, e seus respectivos Sets e Gets.*/
    class Condomino extends Connection{
        private $nome;
        private $sobrenome;
        private $rg;
        private $cpf;
        private $idade;
        private $tel1;
        private $tel2;
        private $apartamento;
        private $titular;

        public function setNome($nome){
            $this->nome = $nome;
        }

        public function getNome(){
            return $this->nome;
        }

        public function setSobrenome($sobrenome){
            $this->sobrenome = $sobrenome;
        }

        public function getSobrenome(){
            return $this->sobrenome;
        }

        public function setRg($rg){
            $this->rg = $rg;
        }

        public function getRg(){
            return $this->rg;
        }

        public function setCpf($cpf){
            $this->cpf = $cpf;
        }

        public function getCpf(){
            return $this->cpf;
        }

        public function setIdade($idade){
            if ($idade <= 112){
                $this->idade = $idade;
            } else echo "Idade invalida";
        }

        public function getIdade(){
            return $this->idade;
        }

        public function setTel1($tel1){
            $this->tel1 = $tel1;
        }

        public function getTel1(){
            return $this->tel1;
        }

        public function setTel2($tel2){
            $this->tel2 = $tel2;
        }

        public function getTel2(){
            return $this->tel2;
        }

        public function setApartamento($apartamento){
            $this->apartamento = $apartamento;
        }

        public function getApartamento(){
            return $this->apartamento;
        }

        public function setTitular($titular){
            $this->titular = (int)$titular;
        }

        public function getTitular(){
            return $this->titular;
        }
        
        /*O construtor da classe define todos os atributos, com exceção do booleano "Titular", que define se a pessoa é titular de seu respectivo apartamento ou não.
        O motivo para isso é que na página de edição de usuário, não é possível atualizar a titularidade do apartamento. Essa funcionalidade se encontra dentro da classe Apartamento.
        Portanto, na hora de instanciar um objeto para a utilização da classe update(), não se deve settar o valor de $titular, tornando sua instanciação desnecssária no construtor.*/
        public function Condomino($nome, $sobrenome, $rg, $cpf, $idade, $tel1, $tel2, $apartamento){
            $this->setNome($nome);
            $this->setSobrenome($sobrenome);
            $this->setRg($rg);
            $this->setCpf($cpf);
            $this->setIdade($idade);
            $this->setTel1($tel1);
            $this->setTel2($tel2);
            $this->setApartamento($apartamento);
        }

        /*Função de inserção de condômino, chamada por um objeto Condomino.*/
        public function insert(){
            $nome = $this->getNome();
            $sobrenome = $this->getSobrenome();
            $rg = $this->getRg();
            $cpf = $this->getCpf();
            $idade = $this->getIdade();
            $tel1 = $this->getTel1();
            $tel2 = $this->getTel2();
            $apartamento = $this->getApartamento();
            $titular = $this->getTitular();
            $inserirtitular = true;

            if ($titular == 1){
                $conn = $this->connectDB();
                $stmt = $conn->prepare("SELECT * FROM responsavel_financeiro WHERE apartamento = ?");
                $stmt->bind_param('s', $apartamento);
                $stmt->execute();
                $result = $stmt->get_result();
                $resultadotitular = $result->fetch_all(MYSQLI_ASSOC);
                if (!empty($resultadotitular)){
                    echo "Não é possível inserir usuário como responsável financeiro, apartamento já possui titular";
                    $titular = 0;
                    $inserirtitular = false;
                }
            }

            $conn = $this->connectDB();
            $stmt = $conn->prepare("INSERT INTO condomino (nome, sobrenome, rg, cpf, idade, tel1, tel2, apartamento, titular) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssiiiisi', $nome, $sobrenome, $rg, $cpf, $idade, $tel1, $tel2, $apartamento, $titular);
            $stmt->execute();
            /*Na execução do código, além de ser inserido na tabela de morador,
            o usuário é inserido em responsável financeiro caso seja titular.
            Já conferirmos anteriormente se já existe outro responsável.*/
            if ($inserirtitular == true){
                $this->insertResponsavel($apartamento, $nome, $sobrenome);
                echo "Inserido com sucesso!";       
            } 
        }

        public function insertResponsavel($apartamento, $nome, $sobrenome){
            $nomecompleto = $nome.' '.$sobrenome;            
            $result = $this->search($nomecompleto, 'nome');
            $usuario = $result->fetch_all(MYSQLI_ASSOC);
            $id = $usuario[0]['ID'];

            $conn = $this->connectDB();
            $status = 0;
            $stmt = $conn->prepare("INSERT INTO responsavel_financeiro (ID, apartamento, statuspagamento) VALUES (?, ?, ?)");
            $stmt->bind_param('isi', $id, $apartamento, $status);

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
                if($tipo == 'nome'){
                    $stmt = $conn->prepare("SELECT * FROM condomino WHERE nome = ? AND sobrenome LIKE ?");
                    $nomes = explode(" ", $conteudo);
                    $primeironome = $nomes[0];
                    $nomes = array_slice($nomes, 1);
                    $sobrenome = '';
                    foreach ($nomes as $nome){
                        $sobrenome .= " $nome";
                    }
                    $sobrenome = trim($sobrenome);
                    $sobrenome = "%".$sobrenome."%";
                    $stmt->bind_param('ss', $primeironome, $sobrenome);
                    if ($stmt->execute()){
                        $result = $stmt->get_result();
                        return $result;                
                    }
                } else {                    
                    $stmt = $conn->prepare("SELECT * FROM condomino WHERE $tipo=?");
                    $stmt->bind_param('s', $conteudo);
                    if ($stmt->execute()){ 
                            $result = $stmt->get_result();
                            return $result;
                        }
                }
        }

        /*Função de exclusão, que não permite a exclusão de usuário
        caso o mesmo seja responsável financeiro por algum apartamento.*/
        public static function delete($id){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $stmt = $conn->prepare("DELETE FROM condomino WHERE id = ?");
            $stmt->bind_param('i', $id);
            if ($stmt->execute()){
                echo "<br><div class=\"wrapper\">Exclusão bem sucedida</div>";
            }
        }

        public function update($id){
            $nome = $this->getNome();
            $sobrenome = $this->getSobrenome();
            $rg = $this->getRg();
            $cpf = $this->getCpf();
            $idade = $this->getIdade();
            $tel1 = $this->getTel1();
            $tel2 = $this->getTel2();
            $apartamento = $this->getApartamento();
            $conn = $this->connectDB();
            $stmt = $conn->prepare("UPDATE condomino SET nome = ?, sobrenome = ?, rg = ?, cpf = ?, idade = ?, tel1 = ?, tel2 = ?, apartamento = ? WHERE ID = ?");
            $stmt->bind_param('sssiiiisi', $nome, $sobrenome, $rg, $cpf, $idade, $tel1, $tel2, $apartamento, $id);

            if ($stmt->execute()){
                echo "Editado com sucesso!";
            } else echo $stmt->error;
        }
}
?>
