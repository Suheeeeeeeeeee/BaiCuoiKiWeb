<?php
require 'init.php';
echo '<link rel="stylesheet" href="css/bootstrap.css">';
echo '<link rel="stylesheet" href="css/bootstrap.min.css">';
echo  '<link rel="stylesheet" href="css/all.min.css">';
 echo '<link rel="stylesheet" href="css/fontawesome.min.css">';
$title="Songs";

//Hiện khi click vào bài hát ở trang Home
$song_id= $_GET['id'] ?? 0;
$song_id=(int)$song_id;

$query= "select * from songs where id='$song_id' limit 1";
$song= query($query);

if(!empty($song)){
	$song=$song[0];

    $id= $song['user_id'];
    $query= "select * from users where id='$id' limit 1";
    $row= query($query);
    if(!empty($row)){
        $row= $row[0];
    }
	if(user('id') != $song['user_id'])	//tăng số view khi không là artist
	     add_page_view($song['id']);
	//add_song_download($song['id']);
}

//phần comment
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
				
			$user_id=$_POST['user_id']?? user('id');
		$song_id=$_POST['song_id'];
		$comment=$_POST['comment'];
		$user_name=$_POST['username'];
		$avt=$_POST['image'];
		// $query="update comments set user_id='$id',song_id='$song_id',comments='$comment' where user_id='$id'  ";
		$query= "insert into comments (user_id,username,image,song_id,comment) values ('$user_id','$user_name','$avt','$song_id','$comment')";
		query($query);
		}

		$query="select*from comments where song_id='$song_id' order by id desc ";
		$user_comment=query($query);
		if($user_comment==false){
			$user_comment=[];
		}
//PHẦN RATING

		$user_id=user('id');
		
		$query2= "SELECT COUNT(*) AS likes FROM ratings WHERE song_id= '$song_id' AND status='like'";
        $likeCount=query($query2);
		$likesCount=$likeCount[0]['likes'];

		$query3= "SELECT COUNT(*) AS dislikes FROM ratings WHERE song_id= '$song_id' AND status='dislike'";
        $dislikeCount=query($query3);
        $dislikesCount=$dislikeCount[0]['dislikes'];

		$query4= "SELECT status FROM ratings WHERE song_id='$song_id' AND user_id='$user_id' ";
		$statuss=query($query4);
		if($statuss && is_array($statuss) && !empty($statuss)){
            $status= $statuss[0]['status'];   //Current user's rating status
         
		}else{
			$status=0;
		}
		
		
       ?>
	
    <style media="screen">
		.shadow-textarea textarea.form-control::placeholder {
		font-weight: 300;
		}
		.shadow-textarea textarea.form-control {
		padding-left: 0.8rem;	
		} 
		label{
		color: black;
		}
        .selected{
			color:red;
			outline: 1px solid black;
		}
    </style>



<?php
require 'header.php';
?>

		<div class="class_40" >
			<h1  class="class_41" >
				Now Playing
			</h1>
			

			<?php
			if(!empty($row)):
			?>
			<div class="class_42" style="display:block;" >
				<div class="class_43" >
					<img src="<?= get_image($song['image']) ?>" class="class_44" style="min-width: 400px;height:auto">
					<h1  class="class_45" style="margin-bottom: 0px;">
						<a href="profile.php?id=<?=$row['id']?>">
					    <?=$row['first_name']?> <?=$row['last_name']?>
					</a>
					</h1>
					
					<div class="class_46" style="display:block" >
                    <?php
				   if(!empty($song)):
				   ?>
                         <div class="class_51" style="width:100%" >
                
							<div class="class_52" >
								<img src="<?= get_image($row['image']) ?>" class="class_53" >
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
								
							</div>
							<div style="color:black; text-align:center;">Page views: <?=$song['views']?></div>
							<div style="color:black; text-align:center;">Downloads: <?=$song['downloads']?></div>
							
							<div class="post">
								<button class="like <?php if($status == 'like') echo "selected"; ?>" data-song-id=<?php echo $song_id ?>>
								<i class="fa-solid fa-heart"></i>
								<span class= "likes_count<?php echo $song_id; ?>" data-count= <?php echo $likesCount; ?>> <?php echo $likesCount; ?></span>
							</button>
								<button class="dislike <?php if($status == 'dislike') echo "selected"; ?>" data-song-id=<?php echo $song_id ?>>
								<i class="fa-solid fa-heart-crack"></i>
									<span class= "dislikes_count<?php echo $song_id; ?>" data-count= <?php echo $dislikesCount; ?>> <?php echo $dislikesCount; ?></span>
								</button>
							</div>

							
						
                             <div>
							 <a href="download.php?id=<?=$song['id']?>">
									<button  class="class_37" >
										Download
									</button>
							    </a>
							 </div>
								
						
						<?php
						else:
						?>
						<div style=" color:black;padding: 10px; text-align:center">No song found! <br><a href="upload.php">Upload a song</a></div>
						<?php
						endif;
						?>
						</div>
					
					
				</div>
				
				<div class="class_50">
				<div  class="form-group shadow-textarea" style="display: inline;" >
						<div style="color:black"><h2>Comment</h2></div>
						</div>
						<?php
							if(is_logged_in()):
						?>
						
						<form style="display: inline-block;"  method="post" >
									<input type="hidden" name="user_id" value="<?=user('id')?>">
									<input type="hidden" name="username" value="<?=user('username')?>">
									<input type="hidden" name="image" value="<?=user('image')?>">
									<input type="hidden" name="song_id" value="<?=$song_id?>">
									
									<textarea name="comment" style="display: inline-block; vertical-align:bottom;margin-right:10px;" class="form-control z-depth-1" id="exampleFormControlTextarea6" rows="3" cols="100" placeholder="Write something here..."></textarea>
									
									<button  style="height:30px; margin-top: 10px" type="submit" >
										Send
									</button>
									
									
									
									
									
									
						</form> <br>
							<?php
								else:
							?>   <label for="">You must have login to comment</label>
								<br>
								<?php
								endif
								?>
								
								<div class="comment" style="overflow-y: auto; height: 200px">
								<?php
									foreach($user_comment as $user_comments):
									?>
									<label for=""><img style="height: 50px;width:50px" src="<?=$user_comments['image']?>" alt=""></label>
									<a href="profile.php?id=<?=$user_comments['user_id']?>"><label for=""><?=$user_comments['username']?>:</label></a>
									<label style="padding:10px;" for=""><?=$user_comments['comment']?></label> <br> 
									<?php
										endforeach;
									?>
								</div>
					
						</div>
					
               </div>
					<?php
					endif;
					?>
				</div>
				
						
<?php
require 'footer.php';
?>
<script src="jquery-3.2.1.min.js"></script>

<script type="text/javascript">
	$('.like, .dislike').click(function(){  //Xác minh sự kiện
       var data = {   //Dữ liệu được gửi đi thông qua Ajax
		song_id: $(this).data('song-id'),
		user_id: <?php echo $user_id; ?>,
		status: $(this).hasClass('like') ? 'like' : 'dislike',
	   };
	   $.ajax({
		url: 'script.php',
		type: 'post',
		data: data,
		success: function(response){     //Sau khi request hoành thành, hàm sucess được gọi và nhận phản hồi
			var song_id = data['song_id'];
			var likes= $('.likes_count'+ song_id);
			var likesCount = likes.data('count');
			var dislikes= $('.dislikes_count'+ song_id);
			var dislikesCount = dislikes.data('count');

			var likeButton = $(".like[data-song-id=" +song_id + "]" );
			var dislikeButton = $(".dislike[data-song-id=" +song_id + "]" );
             if(response == 'newlike'){
				likes.html(likesCount + 1);
				likeButton.addClass('selected');
			 }
			 else if(response == 'newdislike'){
                dislikes.html(dislikesCount + 1);
				dislikeButton.addClass('selected');
			 }
			 else if(response == 'changetolike'){
				likes.html(parseInt($('.likes_count' + song_id).text()) + 1);
				dislikes.html(parseInt($('.dislikes_count' + song_id).text()) - 1);
				likeButton.addClass('selected');
				dislikeButton.removeClass('selected');
				
            }
			else if(response == 'changetodislike'){
				likes.html(parseInt($('.likes_count' + song_id).text()) - 1);
				dislikes.html(parseInt($('.dislikes_count' + song_id).text()) + 1);
				likeButton.removeClass('selected');
				dislikeButton.addClass('selected');
				
		}
		else if(response == 'deletelike'){
			likes.html(parseInt($('.likes_count' + song_id).text()) - 1);
			likeButton.removeClass('selected');
		}
		else if(response == 'deletedislike'){
			dislikes.html(parseInt($('.dislikes_count' + song_id).text()) - 1);
			dislikeButton.removeClass('selected');
		}
	   }
	})
	})

</script>