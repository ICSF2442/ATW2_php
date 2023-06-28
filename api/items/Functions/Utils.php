<?php
namespace Functions;
use Objects\Candidate;
use Objects\Idea;

class Utils{

    public static function isJson(string $json): bool
    {
        json_decode($json);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public static function getRequestBody(){
        $body = file_get_contents('php://input');
        if(self::isJson($body)){
            return json_decode($body,true);
        }
        return null;

    }

    public static function calcularCandidatoIdeal($calculusID) {
        $candidatos = self::obterArrayCanditos($calculusID);
        $min_peso = -10;
        $max_peso = 10;
        $melhorPontuacao = PHP_INT_MIN;
        $candidatoIdeal = null;

        foreach ($candidatos as $candidato) {
            $pontuacao = 0;
            $ideias = self::obterArrayIdeias($candidato->getId());
            foreach ($ideias as $ideia) {
                $pontuacao += $ideia->getValue();
            }

            // Normalizar a pontuação entre 0 e 1
            $pontuacaoNormalizada = ($pontuacao - $min_peso) / ($max_peso - $min_peso);

            if ($pontuacaoNormalizada > $melhorPontuacao) {
                $melhorPontuacao = $pontuacaoNormalizada;
                $candidatoIdeal = $candidato;
            }
        }
        return $candidatoIdeal;
    }

    public static function obterArrayIdeias($candidatoID): array
    {
        $ret = array();
        if($candidatoID != null){
            $sql = "SELECT idea_FK FROM candidate_idea WHERE candidate_FK = '$candidatoID'";
            $query = Database::getConnection()->query($sql);
            if ($query->num_rows > 0) {
                while($row = $query->fetch_array(MYSQLI_ASSOC)){
                    $ret[] = new Idea($row["id"]);
                }
            }
        }
        return $ret;
    }

    public static function obterArrayCanditos($calculusID): array
    {
        $ret = array();
        if($calculusID != null){
            $sql = "SELECT candidate_FK FROM calculus_candidate WHERE calculus_FK = '$calculusID'";
            $query = Database::getConnection()->query($sql);
            if ($query->num_rows > 0) {
                while($row = $query->fetch_array(MYSQLI_ASSOC)){
                    $ret[] = new Candidate($row["id"]);
                }
            }
        }
        return $ret;
    }
}


