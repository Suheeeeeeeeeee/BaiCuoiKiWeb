<?php
require 'init.php';
 $id= $_GET['id'];
 $query="delete  from playlist where id='$id'";
 query($query);
 redirect('playlist');
?>