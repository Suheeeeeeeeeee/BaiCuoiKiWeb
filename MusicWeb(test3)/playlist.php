<?php
require 'init.php';
echo ' <link rel="stylesheet" href="css/bootstrap.css">';
echo '<link rel="stylesheet" href="css/bootstrap.min.css">';
echo '<link rel="stylesheet" href="css/all.min.css">';
echo ' <link rel="stylesheet" href="css/fontawesome.min.css">';

$title='Playlist';

if(!is_logged_in()){
  redirect('index');
}
if ($_SERVER['REQUEST_METHOD']=="POST"){
$user_id=$_POST['user_id'];
$name=$_POST['name'];  
$query="insert into playlist (user_id,name) value('$user_id','$name')";
query($query);
}
$id=user('id');
$query="select *from playlist where user_id ='$id' ";
$playlist=query($query);
if($playlist==false){
  $playlist=[];
}
$delete=$_GET['delete'] ??'none' ;
   if( $delete=='delete' ){
       $id= $_GET['id'];
       $query="delete  from playlist_song where playlist_id='$id'";
       query($query);
       $query="delete  from playlist where id='$id'";
       query($query);
       
   }

?>

<style>
    .container {
    min-width: 100%;
    height: 490px;
    margin:0px;
    padding: 0px;

}
    .zoom {
    transition: transform .2s;
    margin: 0 auto;
    color: white;
    padding: 0px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    cursor: pointer;
    position: relative;
  }
 
  .img{
    width: 150px;
    height: 150px;
    border: 1px solid ;
    border-radius: 10px;
    background-color: gray;
    display: flex;
    justify-content: center;
  
    
     
  }
  .img p{
    margin-top: 20px;
    color: white;
  }
  /*Hiệu ứng zoom*/
  .zoom:hover {
    transform: scale(1.09);
    
  }
  .zoom i{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
   color: white;
  }
  
  
  .zoom:hover p{
    color: black;
  }
  
  .zoom:hover i{
    
    color: black;
  }

  .img:hover{
    border:none;
  }
  .img-container {
   
    max-width: 100%;  /* Responsive để min-width: 20-40% */
    padding-top: 10px;
    padding-left: 20px;
    padding-bottom: 70px;
    display: inline-block;
  }


  .hidden {
    display: none;
}
#playlistContainer {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    background-color: black;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 300px; /* Điều này có thể được điều chỉnh tùy thuộc vào yêu cầu của bạn */
    box-sizing: border-box;
    text-align: center;
}
#playlistContainer div {
    margin-bottom: 10px;
}
#playlistContainer input {
    width: 100%;
}
#playlistContainer button{
   width: 100%;
}
#playlistContainer label{
   color:white
}
  
 
</style>

<?php
require 'header.php';
?>

<div class="container" >
    <?php //Tạo mới playlist?>
  <div class="img-container" >
       <button  id="showPlaylistButton" class="zoom" style="border:none; display:inline-block">
       <div class="img">
                <p>Tạo playlist mới</p>
                <br><i id="icon" class="fa-solid fa-circle-plus fa-2xl" ></i>
            </div>
       
       </button>
            <form method="post" id="playlistContainer" class="hidden">  
            <div>
                <label style="text-align: center;" for="">Tạo playlist mới</label>
                <input type="hidden" name="user_id" value="<?=user('id')?>">
              <input style="margin-top:10px;margin-bottom:10px" type="text" name="name" placeholder="Nhập tên playlist">
              <button  type="submit">Tạo mới</button>
              </div>
      </form> 
      </div>
      <?php
       foreach($playlist as $playlists):
      ?>  
  
    <div class="img-container" >
        <a href="playlist_song.php?playlist_id=<?=$playlists['id']?>" class="zoom" >
            <div class="img" >
            <p><?=$playlists['name']?></p>
                <br><i class="fa-regular fa-circle-play fa-2xl"></i>
          
                <div style="position:absolute;margin-top: 100px;">
                   <form method="GET" action="delete_playlist.php" >
                  <input type="hidden" name="id" value="<?=$playlists['id']?>" >
                  <input type="hidden" name="delete" value="delete">
                <button style="border-radius: 10px; border:none"  class="delete-playlist-button" data-playlist-id="<?= $playlists['id'] ?>">Delete </button>
                </form>
                   
               
                </div>

            </div>
        </a>
    </div>
          <?php
        endforeach;
          ?>
    
</div>

<?php
require 'footer.php';
?>
<script >
  document.addEventListener('DOMContentLoaded', function() {
  var showPlaylistButton = document.getElementById('showPlaylistButton');
  var playlistContainer = document.getElementById('playlistContainer');

  showPlaylistButton.addEventListener('click', function(event) {
    // Ngăn chặn sự kiện lan toả và mở rộng
    event.stopPropagation();

    // Hiển thị hoặc ẩn form
    playlistContainer.classList.toggle('hidden');
  });

  // Đóng form khi click ra ngoài
  document.addEventListener('click', function() {
    playlistContainer.classList.add('hidden');
  });

  // Ngăn chặn sự kiện click từ form lan toả đến document
  playlistContainer.addEventListener('click', function(event) {
    event.stopPropagation();
  });
});
</script>
