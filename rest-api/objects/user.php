
<?php
class User{
    private $conn;
    private $table_name="users";

    public $id;
    public $firstname;
    public $lastname;
    public $patronymic;
    public $email;
    public $password;
    public $token;
    public $created;
    
    public function __construct($db)
    {
        $this->conn=$db;
    }
    function read(){
        $query="SELECT 
        id, firstname, lastname, patronymic, email,  created 
        FROM ".$this->table_name." 
        ORDER BY 
        created DESC";

        $stmt=$this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }
    function store()
    {
        $query = "INSERT into
        " . $this->table_name . "
        SET
        firstname=:firstname, lastname=:lastname, 
        patronymic=:patronymic, email=:email, 
        password=:password, created=:created
        ";
        
        $stmt = $this->conn->prepare($query);

        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->patronymic=htmlspecialchars(strip_tags($this->patronymic));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=password_hash(htmlspecialchars(strip_tags($this->password)), PASSWORD_BCRYPT);

        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":patronymic", $this->patronymic);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":created", $this->created);
        
        if ($stmt->execute()) {
            return true; 
        } 
        return false;
    }
    function destroy(){
        $query="DELETE FROM ".$this->table_name." 
        WHERE id=:id";
        $stmt=$this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id",$this->id);
        
        if ($stmt->execute()) {
            return true; 
        } 
        return false;
    }
    function readOne(){
        $query="SELECT 
        id, firstname, lastname, patronymic, email,  created 
        FROM ".$this->table_name." 
        WHERE id=:id 
        LIMIT 0,1";

        $stmt=$this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if(!empty($row)){
            $this->firstname=$row["firstname"];
            $this->lastname=$row["lastname"];
            $this->patronymic=$row["patronymic"];
            $this->email=$row["email"];
        }
    }
    function update(){
        $query="UPDATE ".$this->table_name." 
        SET firstname=:firstname, lastname=:lastname, 
        patronymic=:patronymic, email=:email, 
        password=:password
        WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->patronymic=htmlspecialchars(strip_tags($this->patronymic));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=password_hash(htmlspecialchars(strip_tags($this->password)), PASSWORD_BCRYPT);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":patronymic", $this->patronymic);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);

        if ($stmt->execute()) {
            return true; 
        } 
        return false;
    }
    function login($email,$password){
        $query="SELECT 
        * 
        FROM ".$this->table_name." 
        WHERE email=:email";
        
        $stmt = $this->conn->prepare($query);

        $password=htmlspecialchars(strip_tags($password));
        $email=htmlspecialchars(strip_tags($email));
        $stmt->bindParam(":email", $email);

        $stmt->execute();

        $num=$stmt->rowCount();

        if($num>0){
            $user=$stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password,$user["password"])){
                return ['status'=>true,'message'=>'Авторизация прошла успешно'];
            }else{
                return ['status'=>false,'message'=>'Не верный email или password'];
            }
        }else{
            return ['status'=>false,'message'=>'Пользователя с таким email не существует'];
        }
    }
    function emailExists() {
        $query = 'SELECT
          u.id, u.firstname, u.lastname, u.email, u.password, u.created
          FROM '. $this -> table_name .' u 
          WHERE u.email = ?';

          $stmt = $this->conn->prepare($query);

          $this -> email = htmlspecialchars(strip_tags($this->email));
          $stmt -> bindParam(1, $this -> email);

          $stmt -> execute();

          $num = $stmt -> rowCount();
          if ($num > 0 ) {
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);
            $this -> id = $row['id'];
            $this -> firstname = $row['firstname'];
            $this -> lastname = $row['lastname'];
            $this -> password = $row['password']; 

            return true;
          } else {
            return false;
          }

        }
}
?>