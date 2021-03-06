<?php
    include_once ("Connection.php");
    include_once ("Email.php");
    include_once ("Condomino.php");
    /*A classe Funcionario é utilizada por todas as views relacionadas ao Funcionário. 
    Seu primeiro elemento são os atributos, privados, e seus respectivos Sets e Gets.*/
    class Funcionario extends Connection{
        private $nome;
        private $sobrenome;
        private $rg;
        private $cpf;
        private $idade;
        private $tel1;
        private $tel2;
        private $carteiratrab;
        private $salario;
        private $cargo;
        private $usuario;
        private $senha;
        private $primeirasessao;

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

        public function setCarteiraTrab($carteiratrab){
            $this->carteiratrab = $carteiratrab;
        }

        public function getCarteiraTrab(){
            return $this->carteiratrab;
        }

        public function setSalario($salario){
            $this->salario = $salario;
        }

        public function getSalario(){
            return $this->salario;
        }

        public function setCargo($cargo){
            $this->cargo = $cargo;
        }

        public function getCargo(){
            return $this->cargo;
        }

        public function setUsuario($usuario){
            $this->usuario = $usuario;
        }

        public function getUsuario(){
            return $this->usuario;
        }

        public function setSenha($senha){
            $this->senha = (int)$senha;
        }

        public function getSenha(){
            return $this->senha;
        }
        public function setPrimeiraSessao($primeirasessao){
            $this->primeirasessao = $primeirasessao;
        }

        public function getPrimeiraSessao(){
            return $this->primeirasessao;
        }
        
        /*O construtor da classe define todos os seus atributos*/
        public function Funcionario($nome, $sobrenome, $rg, $cpf, $idade, $tel1, $tel2, $carteiratrab, $salario, $cargo, $usuario){
            $this->setNome($nome);
            $this->setSobrenome($sobrenome);
            $this->setRg($rg);
            $this->setCpf($cpf);
            $this->setIdade($idade);
            $this->setTel1($tel1);
            $this->setTel2($tel2);
            $this->setCarteiraTrab($carteiratrab);
            $this->setSalario($salario);
            $this->setCargo($cargo);
            $this->setUsuario($usuario);
        }

        /*Função de inserção de funcionário, chamada por um objeto Funcionário.*/
        public function insert(){
            $nome = $this->getNome();
            $sobrenome = $this->getSobrenome();
            $rg = $this->getRg();
            $cpf = $this->getCpf();
            $idade = $this->getIdade();
            $tel1 = $this->getTel1();
            $tel2 = $this->getTel2();
            $carteiratrab = $this->getCarteiraTrab();
            $salario = $this->getSalario();
            $cargo = $this->getCargo();
            $email = $this->getUsuario();
            $conn = $this->connectDB();

            //Define a senha provisória e envia o e-mail para alteração de senha para o funcionário
            $uniqueID = uniqid();
            $hash = Email::criaHash($uniqueID);
            Email::emailPrimeiroAcesso($email, $uniqueID);
            $senha = Condomino::generateRandomString();

            $stmt = $conn->prepare("INSERT INTO funcionario (nome, sobrenome, rg, cpf, idade, tel1, tel2, carteiratrab, salario, cargo, usuario, senha, primeirasessao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssiiiiiissss', $nome, $sobrenome, $rg, $cpf, $idade, $tel1, $tel2, $carteiratrab, $salario, $cargo, $email, $senha, $hash);
            
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
                    $stmt = $conn->prepare("SELECT * FROM funcionario WHERE nome = ? AND sobrenome LIKE ?");
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
                    $stmt = $conn->prepare("SELECT * FROM funcionario WHERE $tipo=?");
                    $stmt->bind_param('s', $conteudo);
                    if ($stmt->execute()){ 
                            $result = $stmt->get_result();
                            return $result;
                        }
                }
        }

        public static function searchAllFuncionarios(){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $stmt = $conn->prepare("SELECT * FROM funcionario");
            if ($stmt->execute()){ 
                $result = $stmt->get_result();
                return $result;
            }
        }

        /*Função de exclusão, que não permite a exclusão de usuário
        caso o mesmo seja responsável financeiro por algum apartamento.*/
        public static function delete($id){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $stmt = $conn->prepare("DELETE FROM funcionario WHERE id = ?");
            $stmt->bind_param('i', $id);
            if ($stmt->execute()){
                echo "<br><div class=\"wrapper\">Exclusão bem sucedida</div>";
            } else echo $stmt->error;
        }

        public static function adicionarPrivilegiosAdministrativos($id){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $stmt = $conn->prepare("UPDATE funcionario SET permissao = 1 WHERE id = ?");
            $stmt->bind_param('i', $id);
            if ($stmt->execute()){
                echo "<br><div class=\"wrapper\">Funcionário agora pode entrar na parte administrativa do site</div>";
            } else echo $stmt->error;
        }

        public static function removerPrivilegiosAdministrativos($id){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $stmt = $conn->prepare("UPDATE funcionario SET permissao = 0 WHERE id = ?");
            $stmt->bind_param('i', $id);
            if ($stmt->execute()){
                echo "<br><div class=\"wrapper\">Funcionário não pode mais entrar na parte administrativa do site</div>";
            } else echo $stmt->error;
        }

        
        public function update($id){
            $nome = $this->getNome();
            $sobrenome = $this->getSobrenome();
            $rg = $this->getRg();
            $cpf = $this->getCpf();
            $idade = $this->getIdade();
            $tel1 = $this->getTel1();
            $tel2 = $this->getTel2();
            $carteiratrab = $this->getCarteiraTrab();
            $salario = $this->getSalario();
            $cargo = $this->getCargo();
            $conn = $this->connectDB();
            $stmt = $conn->prepare("UPDATE funcionario SET nome = ?, sobrenome = ?, rg = ?, cpf = ?, idade = ?, tel1 = ?, tel2 = ?, carteiratrab = ?, salario = ?, cargo = ? WHERE ID = ?");
            $stmt->bind_param('sssiiiiiisi', $nome, $sobrenome, $rg, $cpf, $idade, $tel1, $tel2, $carteiratrab, $salario, $cargo, $id);

            if ($stmt->execute()){
                echo "Editado com sucesso!";
            } else echo $stmt->error;
        }

        public static function updatePassword($senha, $email){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $senha = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE funcionario SET senha = ?, primeirasessao = NULL WHERE usuario = ?");
            $stmt->bind_param('ss', $senha, $email);
            if ($stmt->execute()){
                header("Location: ../../login.php");
            } else echo $stmt->error;
        }
        
        public static function updateCadastro($senha, $email, $id){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $senha = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE funcionario SET senha = ?, usuario = ? WHERE ID = ?");
            $stmt->bind_param('ssi', $senha, $email, $id);
            if ($stmt->execute()){
                Login::logout($id);
            } else echo $stmt->error;
        }
}
?>
