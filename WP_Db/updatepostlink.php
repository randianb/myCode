<?php
require('db.php');

$tbPosts = $table_prefix.'posts';

//获取所有文章内容
$contents = $database->select($tbPosts, [
	"ID","post_content"
]);

foreach($contents as $con){

    //如果存在链接形式如 “/blog/233/”这种形式的链接
	if(preg_match('/\/blog\/(\d+)\/"/',$con['post_content'])){

        //转换链接为“233.html”
        $newCon = preg_replace('/\/blog\/(\d+)\/"/','/$1.html"',$con['post_content']);
        
        //更新数据库
        $database->update($tbPosts,[
            'post_content' => $newCon
        ],[
            'ID'=>$con['ID']
        ]);
	}
}

//输出转换结果
$datas = $database->select($tbPosts, [
	"post_content"
]);

print_r($datas);