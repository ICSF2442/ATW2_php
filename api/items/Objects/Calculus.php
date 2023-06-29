<?php
namespace Objects;
use Functions\Database;

class Calculus
{
    private ?int $id = null;

    private ?string $date = null;

    private ?String $name  = null;
    private ?int $result  = null;

    public function __construct(int $id = null)
    {
        if ($id != null && Database::getConnection() != null) {
            $database = Database::getConnection();
            $query = $database->query("SELECT * FROM calculus WHERE id = ".$id);

            if ($query->num_rows > 0) {
                $row = $query->fetch_array(MYSQLI_ASSOC);
                $this->id = $row["id"];
                $this->date = ($row["date"]);
                $this->name = $row["name"];
                $this->result = $row["result"];
            }
        }
    }
    public function toArray(): array{
        return array("id" => $this->id,
            "date" => $this->date,
            "name" => $this->name,
            "result"=> $this->result);
    }

    public function addUser(int $userId): void{
        if($userId != null){
            $sql = "INSERT INTO calculus_user (user_FK, calculus_FK) VALUES ('$userId', '$this->id')";
            Database::getConnection()->query($sql);
        }
    }

    public function store(): void{

        $fields = array("id","date","result", "name");

        if ($this->id == null) {

            $this->id = Database::getNextIncrement("calculus");

            $columns = "";
            $values = "";
            foreach ($fields as $field){
                $columns .= ", " . $field;
                $values .= ", " . ($this->{$field} != null ? "'" . $this->{$field} . "'" : "NULL");
            }

            $columns = substr($columns, 2);
            $values = substr($values, 2);
            $sql = "INSERT INTO CALCULUS ($columns) VALUES ($values);";


        }else{

            $values = "";
            $sql = "UPDATE CALCULUS ";
            foreach ($fields as $field){
                $values .= ",".$field." = " . ($this->{$field} != null ? "'" . $this->{$field} . "'" : "NULL");
            }

            $values = substr($values, 1);
            $sql = "UPDATE calculus SET $values WHERE id = $this->id";

        }
        Database::getConnection()->query($sql);

    }

    public function remove(): void
    {
        if ($this->id != null){
            $sql = "DELETE FROM calculus WHERE id = $this->id";
            Database::getConnection()->query($sql);
        }
    }

    public static function find(int $id = null, date $date = null, int $result = null): int{
        $sql = "SELECT id FROM calculus WHERE 1=1";
        if($id != NULL){
            $sql .= " AND (id = $id)";
        }
        if($date != NULL){
            $sql .= " AND (date = '$date')";
        }
        if($result != NULL){
            $sql .= " AND (result = '$result')";
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
            $sql = "DELETE FROM calculus WHERE id = $id";
            Database::getConnection()->query($sql);
        }
    }

    public static function search(int $id = null, date $date = null, int $result = null): array{
        // crias o comando sql principal
        $sql = "SELECT id FROM CALCULUS WHERE 1=1";
        // se passar um dado "id" então vai adicionar ao SQL uma parte dinamica: verificar se o id é igual ao id
        if($id != NULL){
            $sql .= " AND (id = $id)";
        }
        if($date != NULL){
            $sql .= " AND (date = '$date')";
        }
        if($result != NULL){
            $sql .= " AND (result = '$result')";
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
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string|null $date
     */
    public function setDate(?string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return int|null
     */
    public function getResult(): ?int
    {
        return $this->result;
    }

    /**
     * @param int|null $result
     */
    public function setResult(?int $result): void
    {
        $this->result = $result;
    }

    /**
     * @return String|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param String|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }


}