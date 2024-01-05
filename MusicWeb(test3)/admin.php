<?php
require 'init.php';
$title= "Admin";

if(!is_admin()){
	redirect('login');
}

$section = $_GET['section'] ?? "dashboard";
$page_to_load= 'includes/'.strtolower($section).'.php';

define("ADMIN",true);
$delete=$_GET['delete']??'unknow';
 if(!empty($delete) && $delete='true' ){
	$id=$_GET['id']??0;
	 $user_delete= query($query="select *  from users where id='$id' ")  ;
	  
		 $query="delete  from users  where id = '$id'  limit 1";
		 query($query);
	   
		 if(!empty($user_delete['image'])&& file_exists($user_delete['image']))
		 unlink($user_delete['image']);
	$song_delete=query($query="select *  from songs where id='$id' ") ;
	  $query="delete  from songs  where user_id = '$id'  ";
	  query($query);
	 if( !empty($song_delete['image'])&& file_exists($song_delete['image']))
				unlink($song_delete['image']); // xóa tập tin
	 if( !empty($song_delete['file'])&& file_exists($song_delete['file']))
	 unlink($song_delete['file']); // xóa tập tin
   
 }


?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MusicBeats</title>
	<link rel="stylesheet" type="text/css" href="assets_admin/css/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="assets_admin/css/styles.css?2852">
</head>
<body>

	
	<div class="class_1" >
		<div class="class_2" >
			<div class="class_3" >
				<img src="<?=get_image(user('image'))?>" class="class_4" >
				<h1 class="class_5"  >
					<?=user('first_name')?> <?=user('last_name')?>
					<br >
				</h1>
			</div>
			<a href="admin.php" class="class_6"  >
				<div class="class_7" >
					<div class="class_8" >
						Dashboard
					</div>
					<div class="class_9" >
						<i  class="bi bi-list class_10">
						</i>
					</div>
				</div>
			</a>
			
			<a href="admin.php?section=users" class="class_6"  >
				<div class="class_7" >
					<div class="class_8" >
						Users
					</div>
					<div class="class_9" >
						<i  class="bi bi-people class_10">
						</i>
					</div>
				</div>
			</a>
			<a href="admin.php?section=songs" class="class_6"  >
				<div class="class_7" >
					<div class="class_8" >
						Songs
					</div>
					<div class="class_9" >
						<i  class="bi bi-vinyl-fill class_10">
						</i>
					</div>
				</div>
			</a>
			<a href="#" class="class_6"  >
				<div class="class_7" >
				</div>
			</a>
			<a href="#" class="class_6"  >
			</a>
			<a href="index.php" class="class_6"  >
				<div class="class_7" >
					<div class="class_8" >
						Front End
					</div>
					<div class="class_9" >
						<i  class="bi bi-globe-europe-africa class_10">
						</i>
					</div>
				</div>
			</a>
			<a href="logout.php" class="class_6"  >
				<div class="class_7" >
					<div class="class_8" >
						Logout
					</div>
					<div class="class_9" >
						<i  class="bi bi-box-arrow-right class_10">
						</i>
					</div>
				</div>
			</a>
		</div>
		<div class="class_11" >
			<h2 class="class_12"  >
			<?=ucwords($section)?>
			</h2>
			
			<!-- begin page content-->
			<?php
			if(file_exists($page_to_load)){
                require $page_to_load;
			}else{
                echo "Page not found";
			}


			?>
			<!-- end page content-->
		</div>
	</div>
	
</body>
</html>