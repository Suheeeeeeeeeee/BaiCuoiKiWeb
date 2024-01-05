<?php
require 'init.php';
echo '<link rel="stylesheet" href="assets/css/index.css">';
$title= "Home";

$limit = 12;
$offset= ($page_number -1)* $limit;

$query= "select * from songs limit $limit offset $offset"; //offset chỉ định hàng bắt đầu trong sql
$songs= query($query);

if(!empty($songs)){
	foreach($songs as $key => $row){
		$id= $row['user_id'];
		$query= "select * from users where id= '$id' limit 1";
        $artist= query($query);
        if(!empty($artist)){
           $songs[$key]['artist']= $artist[0];
		}
	}
}
//add to playlist
if(is_logged_in()){
	$user_id=user('id');
	$query="select *from playlist where user_id='$user_id'";
	$playlist=query($query);
}


if ($_SERVER['REQUEST_METHOD']=="POST"){
	$song_id=$_POST['id'];
	$playlist_id=$_POST['playlist_id'];
	$query="insert into playlist_song (playlist_id,song_id) value('$playlist_id','$song_id')";
	query($query);
}
?>


<?php
 require 'header.php';
 ?>
	<div class="class_14" >
		<h1  class="class_15" >
			Music Beats
		</h1>
	</div>
	<div class="class_16" >
	<?php
		if(!empty($songs)):
		?>

		<?php
		foreach($songs as $song):
		?>
		<div class="song" style="display: inline-block;">
		<a style="margin:0px;border-radius: 10px 10px 0px 0px " href="songs.php?id=<?=$song['id']?>" class="class_17" >
			<img src="<?= get_image($song['image']) ?>"  backup="" class="class_18 item_class_3">
		<h3  class="class_19" >
			<?=esc($song['title']) ?>
		</h3>
		</a>
			<div class="class_20" style="border-radius: 0px 0px 10px 10px" >
				<i class="bi bi-person-fill class_21"></i>
				<div  class="class_22" >
					<?=$song['artist']['first_name'] ?? 'Unknown'?>
					<?=$song['artist']['last_name'] ?? ''?>
				</div>


				<?php
					if(is_logged_in()):
					?>	
									<div id="container">
						<button  class="addToPlaylistButton"  id="showPlaylistButton" data-playlist-id="<?=$id?>">Add to playlist</button>
						
						<form method="post" style="width:100px" data-playlist-id="<?=$id?>" id="playlistContainer" class="hidden">
						<?php
							foreach($playlist as $playlists):
							?>
							<ul >
								<button type="submit" name="playlist_id" value="<?=$playlists['id']?>">
								<li>
									<?= $playlists['name'];?> 
								</li>
								<input type="hidden" name="id" value="<?=$song['id']?>" >
								
								
								</button>
								
							</ul>
							<?php
								endforeach
								?>
								</form>
								
					</div>	
					<?php
					endif
					?>

					<?php
					$id++;
					?>

			</div>
	</div>
		
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
	<a href="index.php?page=<?=($page_number-1)?>">
	                <?php
					if($page_number !=0 && $page_number !=1){
						?>
						<button  class="class_37" style="float:left">
						Prev page
					</button>
					<?php
					}
					?>
					<a href="index.php?page=<?=($page_number+1)?>">
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
 <script src="assets/js/playlist.js"></script>