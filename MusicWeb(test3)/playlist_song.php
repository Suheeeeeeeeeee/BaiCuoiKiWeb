<?php
   require 'init.php';
   $title="Playlist-song";
     if(!is_logged_in()){
             redirect('index');
     }
    $playlist_id=$_GET['playlist_id'];
    
   $id=user('id');
    $query="SELECT songs.*
    FROM playlist_song
    JOIN songs ON playlist_song.song_id = songs.id
    WHERE playlist_song.playlist_id = '$playlist_id'; ";
    $playlist=query($query);
    if($playlist==false){
      $playlist=[];
    }

?>
<style>
.container{
    min-height: 500px;
}
</style>
  <?php
    require 'header.php';
  ?>
  <div class="container">
  <?php
     foreach($playlist as $playlists):
  ?>
   <div  style="display:inline-block;background-color: lightgray;width: 300px; margin:10px;text-align:center;border-radius: 27px">
            <img style="width:100%;height:100px;border-radius: 27px 27px 0px 0px;" src="<?=$playlists['image']?>" alt="">   
            <br>
            <p><b><?= $playlists['title'] ?></b></p>   
            <audio controls="" class="class_35" >
            <source src="<?=$playlists['file']?>" type="audio/mpeg" >
            </audio>
    <div style="margin: 10px; ">
        <form method="GET" action="delete_playlist_song.php">
        <input type="hidden" name="id" value="<?=$playlists['id']?>" >
        <input type="hidden" name="delete" value="delete">
        <input type="hidden" name="playlist_id" value="<?=$playlist_id?>">
    <button style="border-radius: 10px; border:none" class="delete-playlist-button" data-playlist-id="<?= $playlists['id'] ?>">Delete song</button>
    </form>
        
                </div>
   </div>
<?php
  endforeach
?>

  </div>
  
<?php
  require 'footer.php';
?>