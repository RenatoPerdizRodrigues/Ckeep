<?php
    Class Moradores{

        public static function search($apartamento){
            $conn = new mysqli("localhost", "root", "", "ckeep");
                                    
            $stmt = $conn->prepare("SELECT * FROM condomino WHERE apartamento = ?");
            $stmt->bind_param('s', $apartamento);
            if ($stmt->execute()){ 
                $result = $stmt->get_result();
                return $result;
            }               
        }

        public static function definirTitular($id, $apartamento){
            $conn = new mysqli("localhost", "root", "", "ckeep");

            //Primeiro, queremos pegar o status de pagamento atual do apartamento;
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
                            //Inserimos o novo responsável na tabela
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