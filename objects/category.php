<?php
class Category{
    private $conn;
    private $table_name="categories";

    public $id;
    public $name;
    public $description;
    public $created;
    
    public function __construct($db)
    {
        $this->conn=$db;
    }
    function read(){
        $query="SELECT 
        id, name,  description,  created 
        FROM ".$this->table_name." 
        ORDER BY 
        created DESC";

        $stmt=$this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }
    function create()
    {
        $query = "INSERT into
        " . $this->table_name . "
        SET
        name=:name, description=:description, created=:created
        ";
        
        $stmt = $this->conn->prepare($query);

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->description=htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":created", $this->created);
        
        if ($stmt->execute()) {
            return true; 
        } 
        return false;
    }
    function delete(){
        $query="DELETE FROM ".$this->table_name." 
        WHERE id=:id";
        $stmt=$this->conn->prepare($query);
        $stmt->bindParam(":id",$this->id);
        
        if ($stmt->execute()) {
            return true; 
        } 
        return false;
    }
    function readOne(){
        $query="SELECT 
        name,  description, created 
        FROM ".$this->table_name." 
        WHERE id=:id 
        LIMIT 0,1";

        $stmt=$this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        $this->name=$row["name"];
        $this->description=$row["description"];
    }
}
?>