<?php
require 'init.php';
$title="Login";
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$errors=[];
	$email= addslashes($_POST['email']);  //tránh kí tự đặc biệt
	$password= addslashes($_POST['password']);
	
	$query= "select * from users where email='$email' limit 1";
	$row= query($query);
	
    if(!empty($row)){
		$row = $row[0];
    	 if(password_verify($password, $row['password'])){
		//xac thuc
		auth($row);
        redirect('profile');
	 }else{
		$errors['email']="Wrong email or password";
	 }
		}else{
			$errors['email']="Wrong email or password";
		}
}




?>
<?php
require 'header.php';
?>

<div class="class_68" style="background-color: transparent;">
		<div class="class_69" style="background-color: white;">
			<form method="post" enctype="multipart/form-data" class="class_70"  >
				<h1  class="class_71" >
					Login
				</h1>
				<img src="assets/images/pexels-photo-1649771.jpeg" class="class_72" >
				<div style="color:red;padding:10px;">
                <?php
				if(!empty(message())){
					echo message('',true);
				}
				
				if(!empty($errors)){
					echo implode("<br>",$errors);
				}
				
				?>

				 </div>
				<div class="class_28" >
					<label  class="class_75" >
						Email
					</label>
					<input placeholder="" type="text" name="email" class="class_13" >
				</div>
				<div class="class_28" >
					<label  class="class_76" >
						Password
					</label>
					<input placeholder="" type="password" name="password" class="class_13" >
				</div>
				<div style="padding: 10px;">Don't have an account? <a href="signup.php"> Signup here</a></div>
				<button  class="class_77" >
					Login
				</button>
			</form>
		</div>
	</div>
				
						
<?php
require 'footer.php';
?>