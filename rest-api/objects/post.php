<?php
class Post{
    private $conn;
    private $table_name="posts";

    public $id;
    public $title;
    public $text;
    public $user_id;
    public $user_firstname;
    public $user_lastname;
    public $topic_id;
    public $topic_name;
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
        title=:title, text=:text, user_id=:user_id, topic_id=:topic_id, created=:created
        ";
        
        $stmt = $this->conn->prepare($query);

        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->text=htmlspecialchars(strip_tags($this->text));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->topic_id=htmlspecialchars(strip_tags($this->topic_id));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":text", $this->text);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":topic_id", $this->topic_id);
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
        t.name as topic_name, u.firstname as user_firstname, u.lastname as user_lastname,
        p.id, p.title,  p.text,  p.user_id,  p.topic_id,  p.created 
        FROM ".$this->table_name." p 
            LEFT JOIN 
            topics t 
            ON p.topic_id=t.id
            LEFT JOIN 
            users u 
            ON p.user_id=u.id
        WHERE p.id=:id 
        LIMIT 0,1";

        $stmt=$this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if(!empty($row)){
            $this->title=$row["title"];
            $this->text=$row["text"];
            $this->topic_id=$row["topic_id"];
            $this->topic_name=$row["topic_name"];
            $this->user_id=$row["user_id"];
            $this->user_firstname=$row["user_firstname"];
            $this->user_lastname=$row["user_lastname"];
        }
    }
    function update(){
        $query="UPDATE ".$this->table_name." 
        SET title=:title, text=:text, topic_id=:topic_id, user_id=:user_id 
        WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->text=htmlspecialchars(strip_tags($this->text));
        $this->topic_id=htmlspecialchars(strip_tags($this->topic_id));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":text", $this->text);
        $stmt->bindParam(":topic_id", $this->topic_id);
        $stmt->bindParam(":user_id", $this->user_id);

        if ($stmt->execute()) {
            return true; 
        } 
        return false;
    }
    function searchPaging($attr_arr,$from_record_num,$records_per_page){
        $attr_arr['topic']=htmlspecialchars(strip_tags($attr_arr['topic']));
        $attr_arr['topic']=$attr_arr['topic']!=""?" and (t.id = ".$attr_arr['topic'].") ":"";

        $attr_arr['user_id']=htmlspecialchars(strip_tags($attr_arr['user_id']));
        $attr_arr['user_id']=$attr_arr['user_id']!=""?" and (u.id = ".$attr_arr['user_id'].") ":"";

        $query="SELECT 
        t.name as topic_name, u.firstname as user_firstname, u.lastname as user_lastname,
        p.id, p.title,  p.text,  p.user_id,  p.topic_id,  p.created 
        FROM " . $this->table_name . " p 
        LEFT JOIN 
        topics t 
        ON p.topic_id=t.id
        LEFT JOIN 
        users u 
        ON p.user_id=u.id
        WHERE (p.title LIKE ? or p.text LIKE ? or t.name LIKE ?) ".
        $attr_arr['topic'].$attr_arr['user_id']."
        ORDER BY
        p.created DESC 
        LIMIT ?, ?";

        $stmt=$this->conn->prepare($query);

        $from_record_num=htmlspecialchars(strip_tags($from_record_num));
        $records_per_page=htmlspecialchars(strip_tags($records_per_page));
        $attr_arr['keywords']=htmlspecialchars(strip_tags($attr_arr['keywords']));
        $attr_arr['keywords']="%".$attr_arr['keywords']."%";

        $stmt->bindParam(1, $attr_arr['keywords']);
        $stmt->bindParam(2, $attr_arr['keywords']);
        $stmt->bindParam(3, $attr_arr['keywords']);
        $stmt->bindParam(4, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(5, $records_per_page, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt;
    }
    function count($attr_arr){
        $attr_arr['topic']=htmlspecialchars(strip_tags($attr_arr['topic']));
        $attr_arr['topic']=$attr_arr['topic']!=""?" and (t.id = ".$attr_arr['topic'].") ":"";

        $attr_arr['user_id']=htmlspecialchars(strip_tags($attr_arr['user_id']));
        $attr_arr['user_id']=$attr_arr['user_id']!=""?" and (u.id = ".$attr_arr['user_id'].") ":"";

        $query="SELECT 
        COUNT(*) as total_rows 
        FROM ".$this->table_name." p 
        LEFT JOIN 
        topics t 
        ON p.topic_id=t.id
        LEFT JOIN 
        users u 
        ON p.user_id=u.id
        WHERE (p.title LIKE ? or p.text LIKE ? or t.name LIKE ?) ".
        $attr_arr['topic'].$attr_arr['user_id'];

        $stmt=$this->conn->prepare($query);

        $attr_arr['keywords']=htmlspecialchars(strip_tags($attr_arr['keywords']));
        $attr_arr['keywords']="%".$attr_arr['keywords']."%";

        $stmt->bindParam(1, $attr_arr['keywords']);
        $stmt->bindParam(2, $attr_arr['keywords']);
        $stmt->bindParam(3, $attr_arr['keywords']);

        $stmt->execute();

        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        return $row["total_rows"];
    }
}
?>