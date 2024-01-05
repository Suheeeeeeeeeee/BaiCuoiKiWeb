<?php
require 'init.php';
 $id= $_GET['id'];
 

 $playlist_id=$_GET['playlist_id'];
 
 $query="delete  from playlist_song where song_id='$id'";
 query($query);
 header("Location: playlist_song.php?playlist_id=$playlist_id");
 exit();
?>