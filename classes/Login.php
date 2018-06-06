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
                        $_SESSION['ID'] = $usuario[0]['ID'];
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $permissao = 2;
                        //Insere sessão hasheada na tabela Session para autenticação em cada página
                        $idhash = password_hash($_SESSION['ID'], PASSWORD_DEFAULT);
                        $stmt = $conn->prepare("INSERT INTO sessao (ID, ip, permissao) VALUES (?, ?, ?)");
                        $_SESSION['sessao'] = $idhash;
                        $stmt->bind_param('ssi', $idhash, $ip, $permissao);
                        if ($stmt->execute()){
                            header("Location: " . ROOT . "usuario/index.php");
                            exit();
                        } echo $stmt->error;
                    } else {header("Location: login.php");}

                } //else {header("Location: login.php");}
            } else echo $stmt->error;
        }

        public static function checkFuncLogin($user, $senha){
            $conn = new mysqli("localhost", "root", "", "ckeep");

            $permissao = 0;
            //Primeira query volta os resultados da busca com o usuário para podermos comparar a senha em seguida
            $stmt = $conn->prepare("SELECT * FROM funcionario WHERE usuario = ? AND permissao = ? ");
            $stmt->bind_param('si', $user, $permissao);

            if ($stmt->execute()){
                //Checa se ao menos um resultado foi encontrado
                $result = $stmt->get_result();
                $usuario = $result->fetch_all(MYSQLI_ASSOC);
                if ($usuario){
                    //Pega as informações do resultado. Agora devemos comparar a senha;
                    $checasenha = password_verify($senha, $usuario[0]['senha']);
                    if ($checasenha == true){
                        //Login e Senha corretos, cria sessão
                        $_SESSION['ID'] = $usuario[0]['ID'];
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $permissao = 3;
                        //Insere sessão hasheada na tabela Session para autenticação em cada página
                        $idhash = password_hash($_SESION['ID'], PASSWORD_DEFAULT);
                        $stmt = $conn->prepare("INSERT INTO sessao (ID, ip, permissao) VALUES (?, ?, ?)");
                        $_SESSION['sessao'] = $idhash;
                        $stmt->bind_param('ssi', $idhash, $ip, $permissao);
                        if ($stmt->execute()){
                            header("Location: " . ROOT . "funcionario/index.php");
                            exit();
                        } echo $stmt->error;
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
                        $_SESSION['ID'] = $usuario[0]['ID'];
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $permissao = 1;
                        //Insere sessão hasheada na tabela Session para autenticação em cada página
                        $idhash = password_hash($_SESSION['ID'], PASSWORD_DEFAULT);
                        $stmt = $conn->prepare("INSERT INTO sessao (ID, ip, permissao) VALUES (?, ?, ?)");
                        $_SESSION['sessao'] = $idhash;
                        $stmt->bind_param('ssi', $idhash, $ip, $permissao);
                        if ($stmt->execute()){
                            header("Location: " . ROOT . "index.php");
                            exit();
                        } echo $stmt->error;
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
            $ip = $_SERVER['REMOTE_ADDR'];
            $permissao = (int)2;
            $stmt = $conn->prepare("SELECT * FROM sessao WHERE ID = ? AND ip = ? AND permissao = ?");
            $stmt->bind_param('ssi', $id, $ip, $permissao);
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
            $ip = $_SERVER['REMOTE_ADDR'];
            $permissao = (int)1;
            $stmt = $conn->prepare("SELECT * FROM sessao WHERE ID = ? AND ip = ? AND permissao = ?");
            $stmt->bind_param('ssi', $id, $ip, $permissao);
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
            $ip = $_SERVER['REMOTE_ADDR'];
            $permissao = (int)3;
            $stmt = $conn->prepare("SELECT * FROM sessao WHERE ID = ? AND ip = ? AND permissao = ?");
            $stmt->bind_param('ssi', $id, $ip, $permissao);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                $logado = $result->fetch_all(MYSQLI_ASSOC);
                if ($logado){
                    return true;
                } else {header("Location: ".ROOT."login.php");}
            } else echo $stmt->error;
        }

        public static function logout($id){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $stmt = $conn->prepare("DELETE FROM sessao WHERE ID = ?");
            $stmt->bind_param('s', $id);
            if ($stmt->execute()){
                session_unset();
                session_destroy();
                header("Location: " . ROOT . "login.php");
                exit();
            }            
        }
    }

?>