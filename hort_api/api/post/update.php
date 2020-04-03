<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-with');

include_once('../../config/Database.php');
include_once('../../models/Post.php');

//Instantiate DB & CONNECT
$database = new Database();
$db = $database->connect();

//Instantiate post object
$post = new Post($db);

//Get raw posted data using postman
$data = json_decode(file_get_contents("php://input"));

//Set the ID to be updated
$post->postID = $data->postID;

$post->postCreator = $data->postCreator;
$post->title = $data->title;
$post->content = $data->content;

//Update post using method we created in the model
if($post->update()) {
    echo json_encode(
        array('message' => 'Post Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Post Not Updated')
    );
}

?>