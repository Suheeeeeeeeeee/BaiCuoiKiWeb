<?php
   
    defined("ADMIN") or die("Access denied");

    $query="select count(*) as total from users where role = 'admin' ";  //Đếm số người dùng lưu vào total
	$admins = query($query);
	$total_admins= $admins['0']['total'];

	$query="select count(*) as total from users where role = 'user'";  
	$users = query($query);
	$total_users= $users['0']['total'];

	$query="select count(*) as total from songs";  
	$songs = query($query);
	$total_songs= $songs['0']['total'];

	$query="select sum(views) as total from songs";  
	$views = query($query);
	$total_views= $views['0']['total'];

?>
			<div class="class_13" >
				<div class="class_14" >
					<i  class="bi bi-person-fill-gear class_15">
					</i>
					<h1 class="class_16"  >
						<?=$total_admins?>
					</h1>
					<h1 class="class_17"  >
						Admins
					</h1>
				</div>
				<div class="class_14" >
					<i  class="bi bi-people class_15">
					</i>
					<h1 class="class_16"  >
					<?=$total_users?>
					</h1>
					<h1 class="class_17"  >
						Artists
						<br >
					</h1>
				</div>
				<div class="class_14" >
					<i  class="bi bi-vinyl-fill class_15">
					</i>
					<h1 class="class_16"  >
					<?=$total_songs?>
					</h1>
					<h1 class="class_17"  >
						Song
					</h1>
				</div>
				<div class="class_14" >
					<i  class="bi bi-bar-chart-line-fill class_15">
					</i>
					<h1 class="class_16"  >
					<?=$total_views?>
					</h1>
					<h1 class="class_17"  >
						Plays
					</h1>
				</div>
			</div>
			