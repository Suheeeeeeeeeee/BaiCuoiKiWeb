<?php
require 'init.php';

 $song_id=$_POST["song_id"];
 $user_id=$_POST["user_id"];
 $status=$_POST["status"];

 $query= " SELECT * FROM ratings WHERE song_id='$song_id' AND user_id='$user_id'";
 $ratings = query($query);
 if($ratings && is_array($ratings ) && !empty($ratings)){
    if($ratings[0]['status'] == $status){  //User is delete their rating
        $query2="DELETE FROM ratings WHERE song_id='$song_id' AND user_id= '$user_id' ";
        query($query2);
        echo "delete".$status;  //Send response that the user is deleting rating
    } else{ //User is changing their rating
       $query3= "UPDATE ratings SET status = '$status' WHERE song_id='$song_id' AND user_id='$user_id' ";
       query($query3);
       echo "changeto".$status; //Send response that the user is change rating
    }
 }else{ //User has not rated the post yet
  $query1="INSERT INTO ratings VALUES('','$song_id','$user_id','$status')";
  query($query1);
  echo "new". $status;  //Send response that the user is insert new rating, whether it's like or dislike
  
 }
 

?>