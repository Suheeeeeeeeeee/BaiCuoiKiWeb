<?php
require 'init.php';
$title="Settings";
if(!is_logged_in()){
	redirect('login');
}
$id= user('id');

if(is_admin()){
    $id=$_GET['id'] ?? user('id');
    $id= (int)$id;
}
$query= "select * from users where id='$id' limit 1";
$row= query($query);
if(!empty($row)){
	$row=$row[0];
	
}	


if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($row)){
	$errors=[];
	$email= addslashes($_POST['email']);  //tránh kí tự đặc biệt
	$username= addslashes($_POST['username']);
	$first_name= addslashes($_POST['first_name']);
	$last_name= addslashes($_POST['last_name']);
	$password= addslashes($_POST['password']);
	
 
	//Xác định dữ liệu
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errors['email']= "Invalid email";
	}
	if(!preg_match("/^[a-zA-Z ]+$/",trim($username))){
		$errors['username']= "User name can only have letters with spaces";
	}
	if(!preg_match("/^[\p{L}0-9 \-\_\[\]\(\)\$]+$/u", trim($first_name))){
        $errors['first_name'] = "First name can only have letters, spaces, and hyphens";
    }
    
    if(!preg_match("/^[\p{L}0-9 \-\_\[\]\(\)\$]+$/u", trim($last_name))){
        $errors['last_name'] = "Last name can only have letters, spaces, and hyphens";
    }
    
    
    if(!empty($password) && strlen($password) <8){
		$errors['password']= "Password must be atleast 8 characters long";
	}
	
    
    
    $folder= "uploads/";
    if(!file_exists($folder)){
		mkdir($folder,0777,true); //tạo thư mục với quyền truy cập cao nhất 0777, có thể có thư mục con
	}

	$image_string="";
	if(!empty($_FILES['image']['name'])){
		$allowed= ['image/jpeg','image/png','image/webp','image/jpg'];
		if(in_array($_FILES['image']['type'],$allowed)){
			$image= $folder . $_FILES['image']['name'];
			$image_string =", image= '$image' ";
			
		}else{
            $errors['image']= "Image type not supported";
		}
		}
	if(empty($errors)){
		//save database
		//lưu password dưới dạng mã hóa
        if(!empty($password)){
            $password= password_hash($password, PASSWORD_DEFAULT);
            $password_string= ", password = '$password'";
		
        }
        if(!empty($image)){
			move_uploaded_file($_FILES['image']['tmp_name'], $image);
            if(file_exists($row['image']))
                unlink($row['image']);
			
			   
		}
        $query="update users set username='$username',first_name='$first_name',last_name='$last_name',email='$email' $password_string $image_string where id='$id' limit 1";
		
        query($query);
        $query="select *from users where id='$id' limit 1 ";
        $row = query($query);
        if(!empty($row)){
            if(!is_admin()){
                auth($row[0]);
            }
           
        }
        if(is_admin()){
            $id=user('id');
            $query="update users set username='$username',first_name='$first_name',last_name='$last_name',email='$email' $password_string $image_string where id='$id' limit 1";
		    query($query);
            $query="select *from users where id='$id' limit 1 ";
            $row = query($query);
            auth($row[0]);
            redirect('admin');
        }
        message("Your profile was edited successfully!");
		redirect('profile');

	}
}
?>
<?php
require 'header.php';
?>

        <div class="class_60" >
            <h1  class="class_61" >
                &nbsp;Artist Settings
            </h1>
            <form  method="post" enctype="multipart/form-data" class="class_62" style="padding: 10px" >
                 <div style="color:red;padding:10px; text-align:center">
                <?php
				if(!empty($errors)){
					echo implode("<br>",$errors);
				}
				?>

				 </div>
            <div class="class_63" >
                    <img src="<?=get_image($row['image']) ?>" class="js-image class_31" >
                    <input onchange="display_image(this.files[0])" type="file" name="image"  class="class_32">
                </div>
                <div class="class_28" >
                    <label  class="class_64" >
                        Username
                    </label>
                    <input value="<?=old_value('username',$row['username'])?>" placeholder="" type="text" name="username" class="class_13" >
                </div>
                <div class="class_28" >
                    <label  class="class_64" >
                        First Name
                    </label>
                    <input value="<?=old_value('first_name',$row['first_name'])?>" placeholder="" type="text" name="first_name" class="class_13" >
                </div>
                <div class="class_28" >
                    <label  class="class_66" >
                        Last Name
                    </label>
                    <input value="<?=old_value('last_name',$row['last_name'])?>" placeholder="" type="text" name="last_name" class="class_13" >
                </div>
                <div class="class_28" >
                    <label  class="class_67" >
                        Email
                    </label>
                    <input value="<?=old_value('email',$row['email'])?>" placeholder="" type="text" name="email" class="class_13" >
                </div>
                <div class="class_28" >
                    <label  class="class_64" >
                        Password
                    </label>
                    <input placeholder="Leave empty to keep old password" type="text" name="password" class="class_13" >
                </div>
                <div class="class_36" >
                    <button  class="class_37" >
                        Save
                    </button>
                    <a href="profile.php">
                    <button type="button"  class="class_38" >
                        Cancel
                    </button>
                    </a>
                    <div class="class_39" >
                    </div>
                </div>
</form>
        </div>
        
<?php
require 'footer.php';
?>
<script>
	function display_image(file){
		document.querySelector(".js-image").src=URL.createObjectURL(file);
	}
	
</script>