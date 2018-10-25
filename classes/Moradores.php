<?php
    include_once("Email.php");
    include_once("Condomino.php");
    Class Moradores{

        public static function search($apartamento){
            $conn = new mysqli("localhost", DB_NAME, DB_PASS, "ckeep");
                                    
            $stmt = $conn->prepare("SELECT * FROM condomino WHERE apartamento = ?");
            $stmt->bind_param('s', $apartamento);
            if ($stmt->execute()){ 
                $result = $stmt->get_result();
                return $result;
            }               
        }

        public static function countDevedor(){
            $conn = new mysqli("localhost", DB_NAME, DB_PASS, "ckeep");
                                    
            $stmt = $conn->prepare("SELECT * FROM responsavel_financeiro WHERE statuspagamento = 0");
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

        public static function definirTitular($id, $apartamento){
            $conn = new mysqli("localhost", DB_NAME, DB_PASS, "ckeep");
            $email = '';
            //Primeiro, checamos se o novo titular possui email cadastrado
            $stmt = $conn->prepare("SELECT * FROM condomino WHERE ID = ?");
            $stmt->bind_param('s', $id);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                $status = $result->fetch_all(MYSQLI_ASSOC);
                if ($status[0]['usuario'] == NULL){
                    echo "Usuario não possui e-mail cadastrado, então não pode ser titular!";
                    die();
                } else {$email = $status[0]['usuario'];}
            } else die();

            //Agora, devemos retirar a senha de acesso do antigo responsável financeiro do apartamento
            $stmt = $conn->prepare("SELECT * FROM responsavel_financeiro WHERE apartamento = ?");
            $stmt->bind_param('s', $apartamento);
            if ($stmt->execute()){
                //Pegamos o ID do responsável anterior da tabela de responsáveis
                $result = $stmt->get_result();
                $status = $result->fetch_all(MYSQLI_ASSOC);
                $idanterior = $status[0]['ID'];

                //Agora, retiramos sua senha na tabela condominos
                $stmt = $conn->prepare("UPDATE condomino SET senha = NULL WHERE ID = ?");
                $stmt->bind_param('s', $idanterior);
                if ($stmt->execute()){
                    echo "atualizou";
                } else $stmt->error;
            }else die();

            //Agora, enviamos um e-mail para o novo responsável para que o mesmo defina sua senha
            $uniqueID = uniqid();
            $hash = Email::criaHash($uniqueID);
            Email::emailPrimeiroAcesso($email, $uniqueID);            
            $senha = Condomino::generateRandomString();

            echo $senha."<br>";
            echo $hash."<br>";
            echo $id."<br>";

            //Inserimos no banco de dados a hash para ercuperação da uniqueID, e uma senha aleatória
            $stmt = $conn->prepare("UPDATE condomino set senha = ?, primeirasessao = ? WHERE ID = ?");
            $stmt->bind_param('ssi', $senha, $hash, $id);
            if ($stmt->execute()){
                //Ok
            }else die();

            //Depois, queremos pegar o status de pagamento atual do apartamento;
            $stmt = $conn->prepare("SELECT * FROM responsavel_financeiro WHERE apartamento = ?");
            $stmt->bind_param('s', $apartamento);
            
            if ($stmt->execute()){
                $result = $stmt->get_result();
                $status = $result->fetch_all(MYSQLI_ASSOC);
                var_dump($status);
                $statuspagamento = $status[0]['statuspagamento'];
                //Depois de passarmos o status de pagamento para uma variável, setamos todos os 'titular' para 0, com exceção do ID selecionado
                $stmt = $conn->prepare("UPDATE condomino SET titular = 0 WHERE apartamento = ? AND NOT ID = ?");
                $stmt->bind_param('si', $apartamento, $id);
                if ($stmt->execute()){ 
                    //Deletamos o antigo responsável financeiro do apartamento da tabela
                    $stmt = $conn->prepare("DELETE FROM responsavel_financeiro WHERE apartamento = ?");
                    $stmt->bind_param('s', $apartamento);
                        if ($stmt->execute()){
                        //Colocamos o 'titular' do novo responsável como 1
                        $stmt = $conn->prepare("UPDATE condomino SET titular = 1 WHERE apartamento = ? AND ID = ?");
                        $stmt->bind_param('si', $apartamento, $id);
                        if ($stmt->execute()){
                            //Inserimos o novo responsável na tabela de responsáveis
                            $stmt = $conn->prepare("INSERT INTO responsavel_financeiro (ID, apartamento, statuspagamento) VALUES (?, ?, ?)");
                            $stmt->bind_param('isi', $id, $apartamento, $statuspagamento);
                            if ($stmt->execute()){
                                echo "Atualizado com Sucesso";
                            }
                        }
                    }
                }
            }
        }
    }
?>