<?php
   
    defined("ADMIN") or die("Access denied");

    $limit = 2;
    $offset= ($page_number -1)* $limit;

	$query="select * from users order by id desc limit $limit offset $offset";  
	$users = query($query);
	

	

?>
    <table class="item_class_0" style="text-align: center;" >
        
        <thead >
            <tr >
                <th scope="col" >
                    Id
                </th>
                
                <th scope="col" >
                    Username
                </th>
                <th scope="col" >
                    First
                </th>
                
                <th scope="col" >
                    Last
                </th>
                
                <th scope="col" >
                    Role
                </th>
                
                <th scope="col" >
                    Email
                </th>
                
                <th  class="class_18">
                    Image
                </th>
                <th >
                    Action
                </th>
            </tr>
            
        </thead>
        
        <tbody >
            <?php
            if(!empty($users)):
            ?>
           
             <?php
            foreach($users as $user):
            ?>
                    <tr >
                    <th >
                    <?=$user['id']?>
                    </th>
                    
                    <td >
                        <?=esc($user['username'])?>
                    </td>
                    <td >
                    <?=esc($user['first_name'])?>
                    </td>
                    
                    <td >
                    <?=esc($user['last_name'])?>
                    </td>
                    
                    <td >
                    <?=esc($user['role'])?>
                    </td>
                    
                    <td >
                    <?=esc($user['email'])?>
                    </td>
                    
                    <td >
                        <img src="<?=get_image($user['image'])?>" class="class_19" >
                    </td>
                    <td >
                        <a href="setting.php?id=<?=$user['id']?>">
                            <button class="class_20"  >
                                Edit
                            </button>
                        </a>
                        <form action="admin.php" method="get">
                                <input type="hidden" name="section" value="users">
                                <input type="hidden" name="id" value="<?=$user['id']?>">
                                <input type="hidden" name="delete" value="true">
                                <button type="submit" class="class_21">
                                    Delete
                                </button>
                    </form>

                    </td>
                </tr>
                
                <?php
                endforeach
                ?>
                <?php
                endif
                ?>
            
        </tbody>
    </table>
    <div class="class_22" >
        
        <a href="admin.php?section=users&page=<?=($page_number -1)?>">
        <?php
            if($page_number !=0 && $page_number !=1){
                ?>
                <button class="class_24"  >
                    Prev page
                </button>
            <?php
            }
            ?>
        </a>
        <a href="admin.php?section=users&page=<?=($page_number +1)?>">
        <button class="class_25"  >
            Next page
        </button>
            </a>
    </div>
