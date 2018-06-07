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
                            header("Location: " . ROOT . "usuario/index.php");
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
                    //Hora de comparar a senha digitada com a senha hasehada do banco de dados
                    $checasenha = false;
                    $correto = 0;
                    //Este for verifica se a senha é correta e, caso seja, devolve também a posição do array usuario onde ele está
                    for ($i = 0; $i < 5; $i++){
                        $logado = password_verify($senha, $usuario[$i]['senha']);
                        if ($logado == true){$correto = $si; $checasenha = true;}
                    }

                    if ($checasenha == true){
                        //Login e Senha corretos, cria sessão
                        $_SESSION['ID'] = $usuario[$correto]['ID'];
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

        public static function checkPermission($id){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $stmt = $conn->prepare("SELECT * FROM sessao WHERE ID = ?");
            $stmt->bind_param('s', $id);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                $logado = $result->fetch_all(MYSQLI_ASSOC);
                $permissao = $logado[0]['permissao'];
                return $permissao;
            }
        }


        public static function authUser($id){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $ip = $_SERVER['REMOTE_ADDR'];
            $permissao = (int)2;
            $permissao2 = (int)3;
            $stmt = $conn->prepare("SELECT * FROM sessao WHERE ID = ? AND ip = ? AND permissao IN (?, ?)");
            $stmt->bind_param('ssii', $id, $ip, $permissao, $permissao2);
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

        public static function authEmail($uniqueID, $email){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $stmt = $conn->prepare("SELECT * FROM condomino WHERE usuario = ?");
            $emaildecodado = base64_decode($email);
            $stmt->bind_param('s', $emaildecodado);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                $banco = $result->fetch_all(MYSQLI_ASSOC);
                if (password_verify($uniqueID, $banco[0]['primeirasessao'])){
                    return true;
                } else return false;
            }
        }

        public static function authEmailFunc($uniqueID, $email){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $stmt = $conn->prepare("SELECT * FROM funcionario WHERE usuario = ?");
            $emaildecodado = base64_decode($email);
            $stmt->bind_param('s', $emaildecodado);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                $banco = $result->fetch_all(MYSQLI_ASSOC);
                if (password_verify($uniqueID, $banco[0]['primeirasessao'])){
                    return true;
                } else return false;
            }
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
            }else echo $stmt->error;            
        }
    }

?>