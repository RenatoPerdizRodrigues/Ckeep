<?php
    include_once ("Connection.php");
    /*A classe Veiculo é utilizada por todas as views relacionadas ao Veículo. 
    Seu primeiro elemento são os atributos, privados, e seus respectivos Sets e Gets.*/
    class Previsao{
        private $gastosID;
        private $valor;
        private $total;

        public function setGastosID($gastosID){
            $this->gastosID = $gastosID;
        }

        public function getGastosID(){
            return $this->gastosID;
        }

        public function setValor($valor){
            $this->valor = $valor;
        }

        public function getValor(){
            return $this->valor;
        }

        public function setTotal($total){
            $this->total = $total;
        }

        public function getTotal(){
            return $this->total;
        }

        public static function searchAllGastos($datag){
            $conn = new mysqli("localhost", DB_NAME, DB_PASS, "ckeep");
            $stmt = $conn->prepare("SELECT * FROM gastos WHERE MONTH(?) = MONTH(datag)");
            $stmt->bind_param('s', $datag);
            if ($stmt->execute()){ 
                $result = $stmt->get_result();
                return $result;
            }
        }

        public static function searchAllGastosAnteriores($datag){
            $conn = new mysqli("localhost", DB_NAME, DB_PASS, "ckeep");
            $mespesquisa = date("m",strtotime($datag));
            $anopesquisa = date("y",strtotime($datag));
            $anopesquisa += 2000;
            $stmt = $conn->prepare("SELECT * FROM gastosanteriores WHERE ? = MONTH(datag) AND ? = YEAR(datag)");
            $stmt->bind_param('ss', $mespesquisa, $anopesquisa);
            if ($stmt->execute()){ 
                $result = $stmt->get_result();
                return $result;
            }
        }

        public static function searchTotal($datag){
            $conn = new mysqli("localhost", DB_NAME, DB_PASS, "ckeep");
            $mespesquisa = date("m",strtotime($datag));
            $anopesquisa = date("y",strtotime($datag));
            $anopesquisa += 2000;
            $stmt = $conn->prepare("SELECT * FROM previsao WHERE ? = MONTH(datap) AND ? = YEAR(datap)");
            $stmt->bind_param('ss', $mespesquisa, $anopesquisa);
            if ($stmt->execute()){ 
                $result = $stmt->get_result();
                return $result;
            }
        }

        public static function fecharGastos($total, $data){
            $conn = new mysqli("localhost", DB_NAME, DB_PASS, "ckeep");
            //Primeiro, descobrimos qual o mês anterior
            $mesatual = date("m",strtotime($data));
            $mesanterior = ($mesatual - 1);
            $ano = date("y",strtotime($data));
            $ano += 2000;

            //Caso seja janeiro, ele deve reverter o mês para dezembro e retirar um ano
            if ($mesanterior == 11){
                $mesanterior = 12;
                $ano = ($ano - 1);
            }

            //Então pesquisamos na tabela previsao para nos certificarmos que o mês em questão já não foi fechado
            $stmt = $conn->prepare("SELECT * FROM previsao WHERE ? = MONTH(datap) AND ? = YEAR(datap)");
            $stmt->bind_param('ss', $mesanterior, $ano);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                $haprevisao = $result->fetch_all(MYSQLI_ASSOC);
                if ($haprevisao){
                    exit();
                } else { $haprevisao == false; }
            } else { exit(); }
            
            //Sabendo que não previsão registrada para o mês, devemos nos certificar que todos os custos cadastrados são do mesmo mês
            $stmt = $conn->prepare("SELECT DISTINCT MONTH(datag) FROM gastos");
            if ($stmt->execute()){ 
                $result = $stmt->get_result();
                $distintos = $result->fetch_all(MYSQLI_ASSOC);
                $quantidadedatas = 0;
                foreach($distintos as $distintos){
                    $quantidadedatas++;
                }
            } else echo $stmt->error;

            //Caso haja mais de um mês distinto nos gastos, há mais de um mês e não é possível fechar os gastos
            if ($quantidadedatas > 1){
                $hames = false;
            } elseif ($quantidadedatas = 1){
                $hames = true;
            }

            //Caso não haja previsão cadastrada para o mês e todas as previsões forem do mesmo mês, as funções de fechamento podem começar
            if ($hames && !$haprevisao){

            //Deve acertar a data de inserção
            $datafinal = "$ano-$mesanterior-30";

            //Data do começo do mês
            $datainicial = "$ano-$mesanterior-01";

                //Insere total dos gastos do mês na tabela Previsao
                $stmt = $conn->prepare("INSERT INTO previsao (datap, total) VALUES (?, ?)");
                $stmt->bind_param('si', $datafinal, $total);
                if ($stmt->execute()){ 
                    //Insere os gastos do mês na tabela gastos anteriores
                    $stmt = $conn->prepare("INSERT INTO gastosanteriores (datag, valor, tipo, descricao) SELECT datag, valor, tipo, descricao FROM gastos");
                    if ($stmt->execute()){ 
                        //Remove os gastos da tabela gastos, com exceção dos fixos
                        $tipo = 'Fixo';
                        $stmt = $conn->prepare("DELETE FROM gastos WHERE NOT tipo = ?");
                        $stmt->bind_param('s', $tipo);
                        if ($stmt->execute()){ 
                            //Muda a data dos gastos fixos para um mês a mais que sua data original
                            $stmt = $conn->prepare("UPDATE gastos SET datag = DATE_ADD(datag, INTERVAL 1 MONTH)");
                            if ($stmt->execute()){
                                //Insere também os funcionários nos gastos. Para isso faz uma busca com
                                $stmt = $conn->prepare("INSERT INTO gastosanteriores (datag, valor, tipo, descricao) SELECT NULL AS datag, salario AS valor, 'Fixo' AS tipo, nome AS descricao FROM funcionario");
                                if ($stmt->execute()){
                                    $stmt = $conn->prepare("UPDATE gastosanteriores SET datag = ? WHERE datag IS NULL");
                                    $stmt->bind_param('s', $datainicial);
                                    if ($stmt->execute()){
                                        echo "Gastos Fechados com sucesso";
                                    }
                                }
                            } else echo $stmt->error;
                        } else echo $stmt->error;
                    } else echo $stmt->error;               
                } else echo $stmt->error;
            }
        }
    }