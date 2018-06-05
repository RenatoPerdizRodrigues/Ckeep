<?php
    include_once("../../classes/Condomino.php");
    class Pagador{
        //Listar cada apartamento, cada responsável financeiro, status de pagamento, opção de mudar para pagante e devedor;
        public static function search(){
            $conn = new mysqli("localhost", "root", "", "ckeep");
                                    
            $stmt = $conn->prepare("SELECT * FROM responsavel_financeiro");
            if ($stmt->execute()){ 
                $result = $stmt->get_result();
                $responsaveis = $result->fetch_all(MYSQLI_ASSOC);
                return $responsaveis;
            }
        }

        public static function searchVazios(){
            $conn = new mysqli("localhost", "root", "", "ckeep");

            $stmt = $conn->prepare("SELECT apartamentos.apartamento FROM apartamentos LEFT JOIN responsavel_financeiro ON apartamentos.apartamento = responsavel_financeiro.apartamento WHERE responsavel_financeiro.apartamento IS NULL");
            if ($stmt->execute()){ 
                $result = $stmt->get_result();
                $vazios = $result->fetch_all(MYSQLI_ASSOC);
                return $vazios;
            }
        }

        public static function alterarStatus($id){
            $conn = new mysqli("localhost", "root", "", "ckeep");
            $stmt = $conn->prepare("SELECT statuspagamento FROM responsavel_financeiro WHERE ID = ?");
            $stmt->bind_param('i', $id);
            if ($stmt->execute()){ 
                $result = $stmt->get_result();
                $responsaveis = $result->fetch_all(MYSQLI_ASSOC);
            }

            if ($responsaveis[0]['statuspagamento'] == NULL || $responsaveis[0]['statuspagamento'] == 0){
                $status = 1;
            } elseif ($responsaveis[0]['statuspagamento'] == 1) { $status = 0; }
            $stmt = $conn->prepare("UPDATE responsavel_financeiro SET statuspagamento = ? WHERE ID = ?");
            $stmt->bind_param('ii', $status, $id);
            if ($stmt->execute()){ 
                echo "Alterado";
            }
        }
    }
?>