<?php

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Post.php');

//Instantiate DB & CONNECT
$database = new Database();
$db = $database->connect();

//Instantiate post object
$post = new Post($db);
 
//Get ID'
$post->postID = isset($_GET['postID']) ? $_GET['postID'] : die();

//Get post
$post->read_single();

//Create array
$post_arr = array (
    'postID' => $post->postID,
    'postCreator' => $post->postCreator,
    'postTime' => $post->postTime,
    'title' => $post->title,
    'content' => $post->content
);

//Make json
print_r(json_encode($post_arr));
?>