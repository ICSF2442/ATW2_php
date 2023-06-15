<?php

namespace Objects;
use Functions\Database;

class User
{
    private ?int $id = null;

    private ?string $username = null;

    private ?string $email = null;

    private ?string $password = null;

    private ?string $birthday = null;

    private ?int $dev = null;


    public function __construct(int $id = null)
    {
        if ($id != null && Database::getConnection() != null) {
            $database = Database::getConnection();
            $query = $database->query("SELECT * FROM user WHERE id = ".$id);

            if ($query->num_rows > 0) {
                $row = $query->fetch_array(MYSQLI_ASSOC);
                $this->id = $row["id"];
                $this->username = $row["username"];
                $this->email = $row["email"];
                $this->password = $row["password"];
                $this->birthday = $row["birthday"];
                $this->dev = $row["dev"];
            }
        }
    }
    public function toArray(): array{
        return array("id" => $this->id,
            "username" => $this->username,
            "dev"=> $this->dev);
    }

    public function store(): void{

        $fields = array("id","username","email","password","birthday","dev");

        if ($this->id == null) {

            $this->id = Database::getNextIncrement("user");

            $columns = "";
            $values = "";
            foreach ($fields as $field){
                $columns .= ", " . $field;
                $values .= ", " . ($this->{$field} != null ? "'" . $this->{$field} . "'" : "NULL");
            }

            $columns = substr($columns, 2);
            $values = substr($values, 2);
            $sql = "INSERT INTO USER ($columns) VALUES ($values);";

            //$sql = "INSERT INTO user (id,username,email,birthday,password,winrate,dev,image,team,status,role) VALUES ($this->id,'$this->username','$this->email','$this->birthday','$this->password',$this->winrate,$this->dev,'$this->image',".($this->team == null ? "NULL" : "'$this->team'").",$this->status,$this->role)";
            //echo ($sql);
        }else{

            $values = "";
            $sql = "UPDATE USER ";
            foreach ($fields as $field){
                $values .= ",".$field." = " . ($this->{$field} != null ? "'" . $this->{$field} . "'" : "NULL");
            }

            $values = substr($values, 1);
            $sql = "UPDATE user SET $values WHERE id = $this->id";

            //$sql = "UPDATE user SET username = '$this->username', email = '$this->email', password = '$this->password', birthday = '$this->birthday', winrate = $this->winrate, dev=$this->dev, image = '$this->image', team = $this->team, status = $this->status, role = $this->role WHERE id = $this->id";
            //echo($sql);
        }
        Database::getConnection()->query($sql);

    }

    public function remove(): void
    {
        if ($this->id != null){
            $sql = "DELETE FROM user WHERE id = $this->id";
            Database::getConnection()->query($sql);
        }
    }

    public static function find(int $id = null, string $username = null, string $email = null, string $password = null, int $verification = null, int $user_number = null): int{
        $sql = "SELECT id FROM user WHERE 1=1";
        if($id != NULL){
            $sql .= " AND (id = $id)";
        }
        if($username != NULL){
            $sql .= " AND (username = '$username')";
        }
        if($email != NULL){
            $sql .= " AND (email = '$email')";
        }
        if($password != NULL){
            $sql .= " AND (password = '$password')";
        }
        if($verification != NULL){
            $sql .= " AND (verification = '$verification')";
        }
        if($user_number != NULL){
            $sql .= " AND (user_number = $user_number)";
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
            $sql = "DELETE FROM user WHERE id = $id";
            Database::getConnection()->query($sql);
        }
    }

    public static function search(int $id = null, string $username = null, string $email = null, string $password = null, int $user_number = null): array{
        // crias o comando sql principal
        $sql = "SELECT id FROM USER WHERE 1=1";
        // se passar um dado "id" então vai adicionar ao SQL uma parte dinamica: verificar se o id é igual ao id
        if($id != null){
            $sql .= " and (id = $id)";
        }
        if($username != null){
            $sql .= " and (username = '$username')";
        }
        if($email != null){
            $sql .= " and (email = '$email')";
        }
        if($password != null){
            $sql .= " and (password = '$password')";
        }
        if($user_number != null){
            $sql .= " and (user_number = $user_number)";
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
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * @param string|null $birthday
     */
    public function setBirthday(?string $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return float|null
     */
    public function getWinrate(): ?float
    {
        return $this->winrate;
    }

    /**
     * @param float|null $winrate
     */
    public function setWinrate(?float $winrate): void
    {
        $this->winrate = $winrate;
    }

    /**
     * @return int|null
     */
    public function getDev(): ?int
    {
        return $this->dev;
    }

    /**
     * @param int|null $dev
     */
    public function setDev(?int $dev): void
    {
        $this->dev = $dev;
    }

    /**
     * @return Blob|null
     */
    public function getImage(): ?Blob
    {
        return $this->image;
    }

    /**
     * @param Blob|null $image
     */
    public function setImage(?Blob $image): void
    {
        $this->image = $image;
    }

    /**
     * @return int|null
     */
    public function getTeam(): ?int
    {
        return $this->team;
    }

    /**
     * @param int|null $team
     */
    public function setTeam(?int $team): void
    {
        $this->team = $team;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     */
    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int|null
     */
    public function getRole(): ?int
    {
        return $this->role;
    }

    /**
     * @param int|null $role
     */
    public function setRole(?int $role): void
    {
        $this->role = $role;
    }

    /**
     * @return int|null
     */
    public function getVerification(): ?int
    {
        return $this->verification;
    }

    /**
     * @param int|null $verification
     */
    public function setVerification(?int $verification): void
    {
        $this->verification = $verification;
    }

    /**
     * @return int|null
     */
    public function getUserNumber(): ?int
    {
        return $this->user_number;
    }

    /**
     * @param int|null $user_number
     */
    public function setUserNumber(): void
    {

        $user_number = rand(0, 9999);

        if(User::find(null,null,null,null,null,$user_number)){
            $this->setUserNumber();
        }else{
            $this->user_number = $user_number;
        }

    }






}
