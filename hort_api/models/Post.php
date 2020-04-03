<?php
class Post {
    //DB CONN
    private $conn;
    private $table = 'posts';

    //Post properties
    public $postID;
    public $postCreator;
    public $postTime;
    public $title;
    public $content;

    //Construct with DB
    public function __construct($db) 
    {
        $this->conn = $db;
    }



    //Get beneficiaries
    public function read() {
        //Query
        $query= 'SELECT
        postID, postCreator, postTime, title, content
        FROM ' . $this->table . '
        ORDER BY postTime DESC';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //execute
        $stmt->execute();

        return $stmt;

    }



    //Get single post
    public function read_single () {
        //Query
        $query= 'SELECT
        postID, postCreator, postTime, title, content
        FROM ' . $this->table . '
        WHERE postID = ?
        LIMIT 0,1';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(1, $this->postID);

        //execute
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //SET PROPERTIES 
        $this->postID = $row['postID'];
        $this->postCreator = $row['postCreator'];
        $this->postTime = $row['postTime'];
        $this->title = $row['title'];
        $this->content = $row['content'];

    }



    //CREATE POST
    public function create() {
        //create query
        $query = 'INSERT INTO ' . $this->table . '
        SET
        postCreator = :postCreator,
        title = :title,
        content = :content';

        //PREPARE STMT
        $stmt = $this->conn->prepare($query);

        //Clean DATA
        $this->postCreator = htmlspecialchars(strip_tags($this->postCreator));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));

        //bind data
        $stmt->bindParam(':postCreator', $this->postCreator);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        
        //Execute query
        if($stmt->execute()) {
            return true;
        }
        
        //print error if goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }


    
    //UPDATE POST
    public function update() {
        //query
        $query = 'UPDATE ' . $this->table . '
        SET
        postCreator = :postCreator,
        title = :title,
        content = :content
        WHERE
        postID = :postID';

        //PREPARE STMT
        $stmt = $this->conn->prepare($query);

        //Clean DATA       
        $this->postCreator = htmlspecialchars(strip_tags($this->postCreator));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));

        $this->postID = htmlspecialchars(strip_tags($this->postID));

        //bind data        
        $stmt->bindParam(':postCreator', $this->postCreator);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);

        $stmt->bindParam(':postID', $this->postID);
        
        //Execute query
        if($stmt->execute()) {
            return true;
        }
        
        //print error if goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }


    //DELETE POST
    public function delete() {
        //Delete query
        $query = 'DELETE FROM ' .$this->table .' WHERE postID = :postID';

        //prepare stmt
        $stmt = $this->conn->prepare($query);

        //clean id
        $this->postID = htmlspecialchars(strip_tags($this->postID));

        //BIND DATA
        $stmt->bindParam(':postID', $this->postID);

        //Execute query
        if($stmt->execute()) {
            return true;
        }

        //print error
        print_r("Error: %s.\n", $stmt->error);

        return false;
    }

}

?>