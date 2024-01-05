<?php
require 'init.php';
$title= "Artists";

$limit = 30;
$offset= ($page_number -1)* $limit;

$query= "select * from users where role='user' order by id desc limit $limit offset $offset"; //offset chỉ định hàng bắt đầu trong sql
$users= query($query);


?>

<?php
 require 'header.php';
 ?>

		<h1  class="class_15" >
			Artist Profiles
		</h1>
		
	
	<div class="class_16" >
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
	<div style="text-align: center;padding:10px;">No artists found</div>
	<?php
	endif;
	?>
	<div class="class_36" >
	<a href="artists.php?page=<?=($page_number-1)?>">
					<button  class="class_37" style="float:left">
						Prev page
					</button>
					<a href="artists.php?page=<?=($page_number+1)?>">
					<button type="button"  class="class_38" >
						Next page
					</button>
					</a>
					<div class="class_39" >
					</div>
				</div>
	</div>
		
	
	
		
<?php
 require 'footer.php';
 ?>