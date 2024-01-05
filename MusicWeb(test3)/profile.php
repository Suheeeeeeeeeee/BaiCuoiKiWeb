<?php
require 'init.php';
$title="Profile";
if(!is_logged_in()){
	redirect('login');
}
$id= $_GET['id'] ?? user('id');
$id=(int)$id;
$query= "select * from users where id='$id' limit 1";
$row= query($query);
if(!empty($row)){
	$row=$row[0];
	$user_id= $row['id'];
	$query= "select * from songs where user_id='$user_id' order by id desc limit 10";
	$songs= query($query);

	$query= "select count(*) as total from songs where user_id='$user_id'";
	$total_songs= query($query);
	$total_songs= $total_songs[0]['total'];

	$query= "select sum(views) as total from songs where user_id='$user_id'";
	$total_views= query($query);
	$total_views= $total_views[0]['total'];

	$query= "select sum(downloads) as total from songs where user_id='$user_id'";
	$total_downloads= query($query);
	$total_downloads= $total_downloads[0]['total'];
}	


?>
<?php
require 'header.php';
?>

		<div class="class_40" >
			<h1  class="class_41" >
				Artist Profile
			</h1>
			<div style="color:red;padding:10px;text-align:center">
                <?php
				if(!empty(message())){
					echo message('',true);
				}
				?>
				</div>
			<?php
			if(!empty($row)):
			?>
			<div class="class_42" >
				<div class="class_43" >
					<img src="<?= get_image($row['image']) ?>" class="class_44" >
					<h1  class="class_45" style="margin-bottom: 0px;">
						<?=$row['first_name']?> <?=$row['last_name']?>
					</h1>
					<div class="class_45" style="margin-bottom: 10px;" >
						<?=$row['username']?> 
					</div>
					<div class="class_46" >
						<div class="class_47" >
							<i class="bi bi-vinyl-fill class_48">
							</i>
							<h3  class="class_49" >
								<?= $total_songs ?> Songs
							</h3>
						</div>
						<div class="class_47" >
							<i  class="bi bi-bar-chart-line-fill class_48">
							</i>
							<h3  class="class_49" >
							<?= $total_views?> Plays
							</h3>
						</div>
						<div class="class_47" >
							<i  class="bi bi-cloud-download-fill class_48">
							</i>
							<h3  class="class_49" >
							<?= $total_downloads?> Downloads
							</h3>
						</div>
					</div>
					<?php
					if(user('id')==$row['id']):
					?>
						<a href="setting.php">
						<button  class="class_37" >
							Edit Profile
						</button>
						</a>
					<?php
					endif;
					?>
				</div>
				<div class="class_50" >
                   <?php
				   if(!empty($songs)):
				   ?>
                    <?php
				   foreach($songs as $song):
				   ?>

						<div class="class_51" >
							<div class="class_52" >
								<img src="<?= get_image($song['image']) ?>" class="class_53" >
							</div>
							
							<div class="class_54" >
								<h3  class="class_55" style="text-align: left;">
									<?=esc($song['title']) ?>
								</h3>
								
								<div class="class_56" >
									<audio controls="" class="class_35" >
										
										<source src="<?= $song['file'] ?>" type="audio/mpeg" >
										</audio>
									</div>
								</div>
								<?php
									if(user('id')==$row['id']):
									?>
								<div class="class_57" >
									<a href="upload.php?mode=edit&id=<?=$song['id']?>">
									<button  class="class_58" >
										Edit
									</button>
									</a>
									<a href="upload.php?mode=delete&id=<?=$song['id']?>">
									<button  class="class_59" >
										Delete
									</button>
									</a>
								</div>
								<?php
									endif;
									?>
							</div>
						<?php
						endforeach
						?>
						<?php
						else:
						?>
						<div style=" color:black;padding: 10px; text-align:center">No songs found! <br><a href="upload.php">Upload a song</a></div>
						<?php
						endif;
						?>
						</div>
					</div>
					<?php
					endif;
					?>
				</div>
				
				
						
<?php
require 'footer.php';
?>