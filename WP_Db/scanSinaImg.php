<?php
require('db.php');

$contents = $database->select("wp_posts", [
	"post_content"
],[
    //'LIMIT'=>[7,1]
]);

foreach($contents as $con){
    //echo $con['post_content'];
    preg_match('/(http[s]+:\/\/[^\s]*sinaimg[^\s]*)"/i', $con['post_content'], $matches);

    //print_r($matches);
    foreach($matches as $key=>$img){
        if($key >0)
            echo $img.'<br/>';
    }
}
