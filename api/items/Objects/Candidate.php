<?php
namespace Objects;
use Cassandra\Blob;
use Functions\Database;
class Candidate
{
    private ?int $id;

    private ?blob $photo;

    private ?String $name;

    public function __construct(int $id = null)
    {
        if ($id != null && Database::getConnection() != null) {
            $database = Database::getConnection();
            $query = $database->query("SELECT * FROM candidate WHERE id = ".$id);

            if ($query->num_rows > 0) {
                $row = $query->fetch_array(MYSQLI_ASSOC);
                $this->id = $row["id"];
                $this->photo = $row["photo"];
                $this->name = $row["name"];
            }
        }
    }
    public function toArray(): array{
        return array("id" => $this->id,
            "photo" => $this->photo,
            "name"=> $this->name);
    }

    public function store(): void{

        $fields = array("id","photo","name");

        if ($this->id == null) {

            $this->id = Database::getNextIncrement("candidate");

            $columns = "";
            $values = "";
            foreach ($fields as $field){
                $columns .= ", " . $field;
                $values .= ", " . ($this->{$field} != null ? "'" . $this->{$field} . "'" : "NULL");
            }

            $columns = substr($columns, 2);
            $values = substr($values, 2);
            $sql = "INSERT INTO CANDIDATE ($columns) VALUES ($values);";


        }else{

            $values = "";
            $sql = "UPDATE CANDIDATE ";
            foreach ($fields as $field){
                $values .= ",".$field." = " . ($this->{$field} != null ? "'" . $this->{$field} . "'" : "NULL");
            }

            $values = substr($values, 1);
            $sql = "UPDATE candidate SET $values WHERE id = $this->id";

        }
        Database::getConnection()->query($sql);

    }

    public function remove(): void
    {
        if ($this->id != null){
            $sql = "DELETE FROM candidate WHERE id = $this->id";
            Database::getConnection()->query($sql);
        }
    }

    public static function find(int $id = null, String $name = null): int{
        $sql = "SELECT id FROM candidate WHERE 1=1";
        if($id != NULL){
            $sql .= " AND (id = $id)";
        }
        if($name != NULL){
            $sql .= " AND (name = '$name')";
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
            $sql = "DELETE FROM candidate WHERE id = $id";
            Database::getConnection()->query($sql);
        }
    }

    public static function search(int $id = null, string $name = null): array{
        // crias o comando sql principal
        $sql = "SELECT id FROM CANDIDATE WHERE 1=1";
        // se passar um dado "id" então vai adicionar ao SQL uma parte dinamica: verificar se o id é igual ao id
        if($id != null){
            $sql .= " and (id = $id)";
        }
        if($name != null){
            $sql .= " and (name = '$name')";
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
     * @return Blob|null
     */
    public function getPhoto(): ?Blob
    {
        return $this->photo;
    }

    /**
     * @param Blob|null $photo
     */
    public function setPhoto(?Blob $photo): void
    {
        $this->photo = $photo;
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