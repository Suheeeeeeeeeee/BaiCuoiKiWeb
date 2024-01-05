<?php

session_start();

//get page number
$page_number=$_GET['page'] ?? 1;
$page_number= (int)$page_number;
if($page_number < 1){
   $page_number=1;
}

function is_logged_in():bool
{
   if(!empty($_SESSION['USER']) && is_array($_SESSION['USER'])) {
return true;
   }
   return false;
}

function is_admin():bool
{
   if(!empty($_SESSION['USER']) && is_array($_SESSION['USER'])) {
       if($_SESSION['USER']['role']=='admin'){
         return true;
       }
   }
   return false;
}


function auth($row)
{
  $_SESSION['USER']=$row;
   
}
function get_image($path){
   if(file_exists($path ?? ''))
   return $path;
   
   return 'assets/images/no_image.jpg';
}
function get_avt($path){
   if(file_exists($path ?? ''))
   return $path;
   
   return 'assets/images/no_avt.jpg';
}
function user($key)
{
   if(!empty( $_SESSION['USER'][$key])){
      return $_SESSION['USER'][$key];
   } 
 return '';
   
}
function esc($str){
   return htmlspecialchars($str);
}
//Điều hướng
function redirect($page){
    header("Location: $page.php");
    die;
}
function message($message="", $delete = false){
if(!empty($message)){
   $_SESSION['message'] = $message;
}else{
   if(!empty($_SESSION['message'])){
      $msg= $_SESSION['message'];
      if($delete){
         unset($_SESSION['message']);
      }
   return $msg;
   }
}
return "";
}
      function add_page_view($song_id){
      $query="update songs set views=views+1 where id='$song_id' limit 1";
      query($query);

      $query="select views, downloads, date from songs where id='$song_id' limit 1";
      $row= query($query);
      if(!empty($row)){
         $now=time();
         $days=round(($now - strtotime($row[0]['date'])) / (60*60*24));  //tính số ngày

         $popularity =0;
         if($days>0)
             $popularity= ($row[0]['views']+ $row[0]['downloads']) / $days;

         $query="update songs set popularity= '$popularity' where id='$song_id' limit 1";
         query($query);
      }
}


function add_song_download($song_id)
{
   $query="update songs set downloads=downloads+1 where id='$song_id' limit 1";
   query($query);

   $query="select views, downloads, date from songs where id='$song_id' limit 1";
      $row= query($query);
      if(!empty($row)){
         $now=time();
         $days=round(($now - strtotime($row[0]['date'])) / (60*60*24));  //tính số ngày

         $popularity =0;
         if($days>0)
             $popularity= ($row[0]['views']+ $row[0]['downloads']) / $days;

         $query="update songs set popularity= '$popularity' where id='$song_id' limit 1";
         query($query);
      }
}



function old_value($key,$default=""){
   if(!empty($_POST[$key])){
      return $_POST[$key];
   }
   
   return $default;
}

function query($query){
    /* con is created inside the connection.php file */
    global $con;
    $result= mysqli_query($con,$query);
    if(!is_bool($result)){
      if(mysqli_num_rows($result) >0){
         $rows=[];
         while($row = mysqli_fetch_assoc($result)){
            $rows[]= $row;
         }
         return $rows;
      }
    }
    return false;
}

function create_tables(){
   $query = "CREATE TABLE IF NOT EXISTS `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(30) NOT NULL,
      `first_name` varchar(30) NOT NULL,
      `last_name` varchar(30) NOT NULL,
      `email` varchar(100) NOT NULL,
      `password` varchar(255) NOT NULL,
      `role` varchar(6) NOT NULL,
      `date` datetime NOT NULL,
      PRIMARY KEY (`id`),
      KEY `username` (`username`),
      KEY `email` (`email`)
     ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

   query($query);
   
   $query = "CREATE TABLE IF NOT EXISTS `songs` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` varchar(30) NOT NULL,
      `file` varchar(1024) NOT NULL,
      `image` varchar(1024) NOT NULL,
      `title` varchar(100) NOT NULL,
      `views` int(11) DEFAULT 0 NOT NULL,
      `downloads` int(11) DEFAULT 0 NOT NULL,
      `popularity` int(11) DEFAULT 0 NOT NULL,
      `date` datetime NULL,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      KEY `title` (`title`),
      KEY `views` (`views`),
      KEY `popularity` (`popularity`),
      KEY `downloads` (`downloads`)
     ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
   query($query);
}
?>