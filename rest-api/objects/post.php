<?php
class Post{
    private $conn;
    private $table_name="posts";

    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;
    
    public function __construct($db)
    {
        $this->conn=$db;
    }
    function store()
    {
        $query = "INSERT into
        " . $this->table_name . "
        SET
        name=:name, description=:description, price=:price, category_id=:category_id, created=:created
        ";
        
        $stmt = $this->conn->prepare($query);

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":category_id", $this->category_id);
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
        c.name as category_name, p.id, p.name,  p.description,  p.price,  p.category_id,  p.created 
        FROM ".$this->table_name." p 
            LEFT JOIN 
            categories c 
            ON p.category_id=c.id
        WHERE p.id=:id 
        LIMIT 0,1";

        $stmt=$this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        $this->name=$row["name"];
        $this->description=$row["description"];
        $this->price=$row["price"];
        $this->category_id=$row["category_id"];
        $this->category_name=$row["category_name"];
    }
    function update(){
        $query="UPDATE ".$this->table_name." 
        SET name=:name, description=:description, price=:price, category_id=:category_id 
        WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":category_id", $this->category_id);

        if ($stmt->execute()) {
            return true; 
        } 
        return false;
    }
    function searchPaging($keywords,$category,$price,$from_record_num,$records_per_page){
        $category=htmlspecialchars(strip_tags($category));
        $category=$category!=""?" and (c.id = ".$category.") ":"";

        $price=htmlspecialchars(strip_tags($price));
        $price=$price!=""?" and (p.price > ".explode("-", $price)[0]." and p.price < ".explode("-", $price)[1].") ":"";

        $query="SELECT 
        c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
        FROM " . $this->table_name . " p 
        LEFT JOIN
        categories c 
        ON p.category_id = c.id
        WHERE (p.name LIKE ? or c.name LIKE ? or p.description LIKE ?) ".
        $category.$price."
        ORDER BY
        p.created DESC 
        LIMIT ?, ?";

        $stmt=$this->conn->prepare($query);

        $from_record_num=htmlspecialchars(strip_tags($from_record_num));
        $records_per_page=htmlspecialchars(strip_tags($records_per_page));
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords="%".$keywords."%";

        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
        $stmt->bindParam(4, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(5, $records_per_page, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt;
    }
    function count($keywords,$category,$price){
        $category=htmlspecialchars(strip_tags($category));
        $category=$category!=""?" and (c.id = ".$category.") ":"";

        $price=htmlspecialchars(strip_tags($price));
        $price=$price!=""?" and (p.price > ".explode("-", $price)[0]." and p.price < ".explode("-", $price)[1].") ":"";

        $query="SELECT 
        COUNT(*) as total_rows 
        FROM ".$this->table_name." p 
        LEFT JOIN
        categories c 
        ON p.category_id = c.id
        WHERE (p.name LIKE ? or c.name LIKE ? or p.description LIKE ?) ".
        $category.$price;

        $stmt=$this->conn->prepare($query);

        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords="%".$keywords."%";

        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        $stmt->execute();

        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        return $row["total_rows"];
    }
}
?>