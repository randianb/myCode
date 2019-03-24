<?php
require('db.php');


$tbPosts = $table_prefix.'posts';
$tbOption = $table_prefix.'options';
$imgRegex = '/(http(s?)+:\/\/((?!www.waitsun)\w|\.|\/|-|_)+?(jpg|jpeg|gif|png))"/i';
$savePath = 'images/'; #图片存放目录，须777权限
$count=0;

$contents = $database->select($tbPosts, [
	"post_content"
],[
    'post_status'=>'publish'
]);
foreach($contents as $con){
    //echo $con['post_content'];
    preg_match_all($imgRegex, $con['post_content'], $matches);

    //print_r($matches);
    foreach($matches[1] as $key=>$img){
        if($key >0){
            dlfile($img);
        }
    }
}

$contents = $database->select($tbOption, [
	"option_value"
],['option_name'=>'dux']);
foreach($contents as $con){
    preg_match_all($imgRegex, $con['option_value'], $matches);
    
    foreach($matches[1] as $key=>$img){
        if($key >0 &&  $img){
            dlfile($img);
        }
    }
}


function dlfile($file_url)
{
    global $savePath;
    
    $save_to = $savePath.preg_replace('/http(s?):\/\//','',$file_url);
    $save_to_arr = explode("/",$save_to);
    $save_to_path = str_replace(end($save_to_arr),'',$save_to);

    if(!file_exists($save_to_path)){
        mkdir($save_to_path,0777,true);
    }
    if(is_dir($save_to_path) && !file_exists($save_to)){
        $content = file_get_contents($file_url);
        file_put_contents($save_to, $content);
    }
}
