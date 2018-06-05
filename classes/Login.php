<?php
    if (!defined('ROOT')) define('ROOT', 'http://localhost/ckeep/');
    class Login{
        public static function checkUserLogin($user, $senha){
            $conn = new mysqli("localhost", "root", "", "ckeep");

            //Primeira query volta os resultados da busca com o usuário para podermos comparar a senha em seguida
            $stmt = $conn->prepare("SELECT * FROM condomino WHERE usuario = ? ");
            $stmt->bind_param('s', $user);

            if ($stmt->execute()){
                //Checa se ao menos um resultado foi encontrado
                $result = $stmt->get_result();
                $usuario = $result->fetch_all(MYSQLI_ASSOC);
                if ($usuario){
                    //Pega as informações do resultado. Agora devemos comparar a senha;                    
                    $checasenha = password_verify($senha, $usuario[0]['senha']);
                    if ($checasenha == true){
                        //Login e Senha corretos, cria sessão
                        echo "estou aqui";
                        $_SESSION['ID'] = $usuario[0]['ID'];
                        return $_SESSION['ID'];
                    } else {header("Location: login.php");}

                } //else {header("Location: login.php");}
            } else echo $stmt->error;
        }

        public static function checkFuncLogin($user, $senha){
            $conn = new mysqli("localhost", "root", "", "ckeep");

            //Primeira query volta os resultados da busca com o usuário para podermos comparar a senha em seguida
            $stmt = $conn->prepare("SELECT * FROM funcionario WHERE usuario = ? ");
            $stmt->bind_param('s', $user);

            if ($stmt->execute()){
                //Checa se ao menos um resultado foi encontrado
                $result = $stmt->get_result();
                $usuario = $result->fetch_all(MYSQLI_ASSOC);
                if ($usuario){
                    //Pega as informações do resultado. Agora devemos comparar a senha;                    
                    $checasenha = password_verify($senha, $usuario[0]['senha']);
                    if ($checasenha == true){
                        //Login e Senha corretos, cria sessão
                        echo "estou aqui";
                        $_SESSION['ID'] = $usuario[0]['ID'];
                        return $_SESSION['ID'];
                    } else {header("Location: login.php");}

                } else {header("Location: login.php");}
            } else echo $stmt->error;
        }

        public static function checkAdmLogin($user, $senha){
            $conn = new mysqli("localhost", "root", "", "ckeep");

            //Primeira query volta os resultados da busca com o usuário para podermos comparar a senha em seguida
            $permissao = 1;
            $stmt = $conn->prepare("SELECT * FROM funcionario WHERE usuario = ? AND permissao = ?");
            $stmt->bind_param('ii', $user, $permissao);

            if ($stmt->execute()){
                //Checa se ao menos um resultado foi encontrado
                $result = $stmt->get_result();
                $usuario = $result->fetch_all(MYSQLI_ASSOC);
                if ($usuario){
                    //Pega as informações do resultado. Agora devemos comparar a senha;                    
                    $checasenha = password_verify($senha, $usuario[0]['senha']);
                    if ($checasenha == true){
                        //Login e Senha corretos, cria sessão
                        echo "estou aqui";
                        $_SESSION['ID'] = $usuario[0]['ID'];
                        return $_SESSION['ID'];
                    } else {header("Location: login.php");}

                } //else {header("Location: login.php");}
            } else echo $stmt->error;
        }

        public static function createSession($id){
            $conn = new mysqli("localhost", "root", "", "ckeep");

            $stmt = $conn->prepare("SELECT * FROM condomino WHERE ID = ?");
            $stmt->bind_param('i', $id);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                $usuario = $result->fetch_all(MYSQLI_ASSOC);

                $_SESSION['ID'] = $usuario[0]['ID'];
                $_SESSION['nome'] = $usuario[0]['nome'];

                //hash('md5', $_SESION['token']);
                return $_SESSION['ID'];
            }
        }

        public static function authCondomino($id){
            $conn = new mysqli("localhost", "root", "", "ckeep");

            $stmt = $conn->prepare("SELECT * FROM condomino WHERE ID = ?");
            $stmt->bind_param('i', $id);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                $logado = $result->fetch_all(MYSQLI_ASSOC);
                if ($logado){
                    return true;
                } else {header("Location: ".ROOT."login.php");}
            } else echo $stmt->error;
        }

        public static function authAdm($id){
            $conn = new mysqli("localhost", "root", "", "ckeep");

            $permissao = 1;
            $stmt = $conn->prepare("SELECT * FROM funcionario WHERE ID = ? AND permissao = ?");
            $stmt->bind_param('ii', $id, $permissao);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                $logado = $result->fetch_all(MYSQLI_ASSOC);
                if ($logado){
                    return true;
                } else {header("Location: ".ROOT."login.php");}
            } else echo $stmt->error;
        }

        public static function authFuncionario($id){
            $conn = new mysqli("localhost", "root", "", "ckeep");

            $stmt = $conn->prepare("SELECT * FROM funcionario WHERE ID = ?");
            $stmt->bind_param('i', $id);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                $logado = $result->fetch_all(MYSQLI_ASSOC);
                if ($logado){
                    return true;
                } //else {header("Location: ".ROOT."login.php");}
            } else echo $stmt->error;
        }

        public static function logout($id){
            session_unset();
            session_destroy();
            header("Location: login.php");
            exit();
        }
    }
    
?>