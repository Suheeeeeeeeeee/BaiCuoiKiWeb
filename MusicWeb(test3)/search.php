<?php
require 'init.php';
$title= "Search";

$limit = 30;
$find= $_GET['q'] ?? null;

if(!empty($find)){
    $find='%'.$find.'%';
    $query= "select * from songs where title like '$find' order by id desc limit $limit"; 
    $query1= " select * from users where first_name like '$find' or last_name like '$find' or username like '$find' order by id desc limit $limit";
    $songs= query($query);
    $users= query($query1);
}

if(!empty($songs)){
	foreach($songs as $key => $row){
		$id= $row['user_id'];
		$query= "select * from users where id= '$id' limit 1 ";
        $artist= query($query);
        if(!empty($artist)){
           $songs[$key]['artist']= $artist[0];
		}
	}
}
?>

<?php
 require 'header.php';
 ?>

		<h1  class="class_15" >
			Search results
		</h1>
		
	
	<div class="class_16" >
	<?php
		if(!empty($songs)):
		?>
		<?php
		foreach($songs as $song):
		?>
		<a href="songs.php?id=<?=$song['id']?>" class="class_17" >
			<img src="<?= get_image($song['image']) ?>"  backup="" class="class_18 item_class_3">
			<h3  class="class_19" >
			<?=esc($song['title']) ?>
			</h3>
			<div class="class_20" >
				<i class="bi bi-person-fill class_21"></i>
				<div  class="class_22" >
					<?=$song['artist']['first_name'] ?? 'Unknown'?>
					<?=$song['artist']['last_name'] ?? ''?>
				</div>
			</div>
		</a>
    <?php
	endforeach;
	?>
	<?php
	else:
	?>
	<div style="text-align: center;padding:10px; color: black;">No songs found</div>
	<?php
	endif;
	?>
	
    <?php
		if(!empty($users)):
		?>
		<?php
		foreach($users as $user):
		?>
		<a href="profile.php?id=<?=$user['id']?>" class="class_17" >
			<img src="<?= get_image($user['image']) ?>"  backup="" class="class_18 item_class_3">
			<h3  class="class_19" >
			        <?=$user['first_name']?>
					<?=$user['last_name'] ?>
			</h3>
			
		</a>
    <?php
	endforeach;
	?>
	<?php
	else:
	?>
	<div style="text-align: center;padding:10px; color: black;">No artists found</div>
	<?php
	endif;
	?>
	</div>
		
	
	
		
<?php
 require 'footer.php';
 ?>