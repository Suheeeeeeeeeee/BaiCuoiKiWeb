<?php
require 'init.php';
$title= "Latest";

$limit = 12;
$offset= ($page_number -1)* $limit;

$query= "select * from songs order by id desc limit $limit offset $offset"; //offset chỉ định hàng bắt đầu trong sql
$songs= query($query);

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
			Latest
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
	<div style="text-align: center;padding:10px; color: black">No songs found</div>
	<?php
	endif;
	?>
	<div class="class_36" >
	<a href="latest.php?page=<?=($page_number-1)?>">
	<?php
					if($page_number !=0 && $page_number !=1){
						?>
						<button  class="class_37" style="float:left">
						Prev page
					</button>
					<?php
					}
					?>
					<a href="latest.php?page=<?=($page_number+1)?>">
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