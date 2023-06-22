<?php

namespace Objects;
use Functions\Database;

class Idea
{
    private ?int $id = null;

    private ?string $idea = null;

    private ?float $value = null;


    public function __construct(int $id = null)
    {
        if ($id != null && Database::getConnection() != null) {
            $database = Database::getConnection();
            $query = $database->query("SELECT * FROM idea WHERE id = ".$id);

            if ($query->num_rows > 0) {
                $row = $query->fetch_array(MYSQLI_ASSOC);
                $this->id = $row["id"];
                $this->idea = $row["idea"];
                $this->value = $row["value"];
            }
        }
    }
    public function toArray(): array{
        return array("id" => $this->id,
            "idea" => $this->idea,
            "value"=> $this->value);
    }

    public function addCandidate(int $candidateId): void{
        if($candidateId != null){
            $sql = "INSERT INTO candidate_idea (idea_FK, candidate_FK) VALUES ('$this->id', '$candidateId')";
            Database::getConnection()->query($sql);
        }
    }
    public function store(): void{

        $fields = array("id","idea","value");

        if ($this->id == null) {

            $this->id = Database::getNextIncrement("idea");

            $columns = "";
            $values = "";
            foreach ($fields as $field){
                $columns .= ", " . $field;
                $values .= ", " . ($this->{$field} != null ? "'" . $this->{$field} . "'" : "NULL");
            }

            $columns = substr($columns, 2);
            $values = substr($values, 2);
            $sql = "INSERT INTO IDEA ($columns) VALUES ($values);";

            //$sql = "INSERT INTO user (id,username,email,birthday,password,winrate,dev,image,team,status,role) VALUES ($this->id,'$this->username','$this->email','$this->birthday','$this->password',$this->winrate,$this->dev,'$this->image',".($this->team == null ? "NULL" : "'$this->team'").",$this->status,$this->role)";
            //echo ($sql);
        }else{

            $values = "";
            $sql = "UPDATE IDEA ";
            foreach ($fields as $field){
                $values .= ",".$field." = " . ($this->{$field} != null ? "'" . $this->{$field} . "'" : "NULL");
            }

            $values = substr($values, 1);
            $sql = "UPDATE idea SET $values WHERE id = $this->id";

            //$sql = "UPDATE user SET username = '$this->username', email = '$this->email', password = '$this->password', birthday = '$this->birthday', winrate = $this->winrate, dev=$this->dev, image = '$this->image', team = $this->team, status = $this->status, role = $this->role WHERE id = $this->id";
            //echo($sql);
        }
        Database::getConnection()->query($sql);

    }

    public function remove(): void
    {
        if ($this->id != null){
            $sql = "DELETE FROM idea WHERE id = $this->id";
            Database::getConnection()->query($sql);
        }
    }

    public static function find(int $id = null, string $idea = null, string $value = null): int{
        $sql = "SELECT id FROM idea WHERE 1=1";
        if($id != NULL){
            $sql .= " AND (id = $id)";
        }
        if($idea != NULL){
            $sql .= " AND (idea = '$idea')";
        }
        if($value != NULL){
            $sql .= " AND (value = '$value')";
        }

        $query = Database::getConnection()->query($sql);

        if ($query->num_rows > 0) {
            return 1;
        }else{
            return 0;
        }
    }

    public static function remover(int $id): void
    {
        if ($id != null){
            $sql = "DELETE FROM idea WHERE id = $id";
            Database::getConnection()->query($sql);
        }
    }

    public static function search(int $id = null, string $idea = null, string $value = null): array{
        // crias o comando sql principal
        $sql = "SELECT id FROM IDEA WHERE 1=1";
        // se passar um dado "id" então vai adicionar ao SQL uma parte dinamica: verificar se o id é igual ao id
        if($id != null){
            $sql .= " and (id = $id)";
        }
        if($idea != null){
            $sql .= " and (idea = '$idea')";
        }
        if($value != null){
            $sql .= " and (value = '$value')";
        }
        // cria o array de retorno
        $ret = array();
        // executa o comando sql dinamico
        $query = Database::getConnection()->query($sql);
        // echo $sql;
        if ($query->num_rows > 0) {
            // se o comando sql for maior que 0 irá percorrer o array de ids
            while($row = $query->fetch_array(MYSQLI_ASSOC)){
                // para cada id irá instanciar um objeto User através daquele id que, por sua vez, irá buscar os dados
                // necessários para construir o objeto
                $ret[] = new User($row["id"]);
            }
        }
        //var_dump($ret);

        // retorno o array com os objetos, caso haja objetos
        return $ret;

    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getIdea(): ?string
    {
        return $this->idea;
    }

    /**
     * @param string|null $idea
     */
    public function setIdea(?string $idea): void
    {
        $this->idea = $idea;
    }

    /**
     * @param float|null $value
     */
    public function setValue(?float $value): void
    {
        $this->value = $value;
    }


    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }


}
