<?php
require 'init.php';
$title="Signup";

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$errors=[];
	$email= addslashes($_POST['email']);  //tránh kí tự đặc biệt
	$username= addslashes($_POST['username']);
	$first_name= addslashes($_POST['first_name']);
	$last_name= addslashes($_POST['last_name']);
	$password= addslashes($_POST['password']);
	$retype_password= addslashes($_POST['retype_password']);
 
	//Xác định dữ liệu
	$query= "select id from users where email='$email' limit 1";
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errors['email']= "Invalid email";
	}else{
		if(query($query)){
			$errors['email']= "That email already exist";
		}
	}
	if(!preg_match("/^[a-zA-Z ]+$/",trim($username))){
		$errors['username']= "User name can only have letters and spaces";
	}
	if(!preg_match("/^[\p{L}0-9 \-\_\[\]\(\)\$]+$/u", trim($first_name))){
        $errors['first_name'] = "First name can only have letters, spaces, and hyphens";
    }
    
    if(!preg_match("/^[\p{L}0-9 \-\_\[\]\(\)\$]+$/u", trim($last_name))){
        $errors['last_name'] = "Last name can only have letters, spaces, and hyphens";
    }
    if(strlen($password) <8){
		$errors['password']= "Password must be atleast 8 characters long";
	}
	if(!($retype_password==$password)){
		$errors['retype_password']= " Retype Password is not equal to Password ";
	}
	if(empty($errors)){
		//save database
		//lưu password dưới dạng mã hóa
		$password= password_hash($password, PASSWORD_DEFAULT);
		$date= date("Y-m-d H:i:s");
        $role='user';

		$query="insert into users (username,first_name,last_name,email,password,role,date) values ('$username', '$first_name','$last_name','$email','$password','$role','$date')";
		query($query);
        message("Your profile was created!Please login to continue");
		redirect('login');

	}
}

?>
<?php
require 'header.php';
?>

<div class="class_68" style="background-color: transparent;">
		<div class="class_69" style="background-color: white;">
			<form method="post" style="height:auto" enctype="multipart/form-data" class="class_70" >
				<h1  class="class_71" >
					Sign up
				</h1>
				<img src="assets/images/pexels-photo-1649771.jpeg" class="class_72" >
                 <div style="color:red;padding:10px;">
                <?php
				if(!empty($errors)){
					echo implode("<br>",$errors);
				}
				?>

				 </div>

				<div class="class_28" >
					<label  class="class_73" >
						Username
					</label>
					<input value="<?=old_value('username')?>" placeholder="" type="text" name="username" class="class_13" >
				</div>
				<div class="class_28" >
					<label  class="class_74" >
						First Name
					</label>
					<input value="<?=old_value('first_name')?>" placeholder="" type="text" name="first_name" class="class_13" >
				</div>
				<div class="class_28" >
					<label  class="class_73" >
						Last Name
					</label>
					<input value="<?=old_value('last_name')?>" placeholder="" type="text" name="last_name" class="class_13" >
				</div>
				<div class="class_28" >
					<label  class="class_75" >
						Email
					</label>
					<input value="<?=old_value('email')?>" placeholder="" type="text" name="email" class="class_13" >
				</div>
				<div class="class_28" >
					<label  class="class_76" >
						Password
					</label>
					<input value="<?=old_value('password')?>" placeholder="" type="password" name="password" class="class_13" >
				</div>
				<div class="class_28" >
					<label  class="class_76" >
						Retype Password
					</label>
					<input value="<?=old_value('retype_password')?>" placeholder="" type="password" name="retype_password" class="class_13" >
				</div>
				
				<div style="padding: 10px;">Already have an account? <a href="login.php"> Login here</a></div>
				<button  class="class_77" >
					Sign-up
				</button>
			</form>
		</div>
	</div>
				
						
<?php
require 'footer.php';
?>