<?php
require 'init.php';
$title= "Top 20";

$limit = 20;
$offset= ($page_number -1)* $limit;

$query= "select * from songs order by views desc limit $limit offset $offset";
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

		<h1 style="text-shadow: 0 0 0 #fff, 
                   1px 1px 1px #ff0000, 2px 2px 4px #ff0000; color:white
"  class="class_15" >
			Top 20 
		</h1>
	
	<div class="class_16" >
	<?php
		if(!empty($songs)):$num=0
		?>
		<?php
		foreach($songs as $song):$num++
		?>
		<a href="songs.php?id=<?=$song['id']?>" class="class_17" style="position:relative; left:0" >
		<div style="text-shadow: 0 0 0 #fff,-2px -2px 4px #ff0000, 2px 2px 4px #ff0000;color: white;background-color:whitesmoke;border-radius:50%; padding:5px; font-size:20px; position: absolute; width:40px;height:40px;top:0;right:0"><?=$num?></div>
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
	<div style="text-align: center;padding:10px;">No songs found</div>
	<?php
	endif;
	?>
	
	</div>
	
		
<?php
 require 'footer.php';
 ?>