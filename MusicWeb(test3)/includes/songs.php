<?php
   
    defined("ADMIN") or die("Access denied");

    $limit = 4;
    $offset= ($page_number -1)* $limit;

	$query="select * from songs order by id desc limit $limit offset $offset";  
	$songs = query($query);

    if(!empty($songs)){
        foreach($songs as $key => $row){
            $id= $row['user_id'];
            $query= "select * from users where id= '$id' limit 1 ";
            $artist= query($query);
            if(!empty($artist)){
               $songs[$key]['artist']= $artist[0];
            }
        }
    }
	

	

?>
    <table class="item_class_0" style="text-align: center;" >
        
        <thead >
            <tr >
                <th scope="col" >
                    Id
                </th>
                
                <th scope="col" >
                    Title
                </th>
                <th scope="col" >
                    Artist
                </th>
                <th scope="col" >
                   Views
                </th>
                
                <th scope="col" >
                    Downloads
                </th>
                
                <th scope="col" >
                    Popularity
                </th>
                
                <th scope="col" >
                    Date
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
            if(!empty($songs)):
            ?>
           
             <?php
            foreach($songs as $song):
            ?>
                    <tr >
                    <th >
                    <?=$song['id']?>
                    </th>
                    
                    <td >
                        <a href="songs.php?id=<?=$song['id']?>">
                            <?=esc($song['title'])?>
                        </a>
                    </td>
                    <td >
                        <a href="profile.php?id=<?=$song['artist']['id']?>">
                            <?=esc($song['artist']['first_name'] ?? 'Unknown')?>
                            <?=esc($song['artist']['last_name'] ?? '')?>
                         </a>
                    </td>
                    
                    <td >
                    <?=esc($song['views'])?>
                    </td>
                    
                    <td >
                    <?=esc($song['downloads'])?>
                    </td>
                    
                    <td >
                    <?=esc($song['popularity'])?>
                    </td>
                    <td >
                    <?=date("jS M Y",strtotime($song['date']))?>
                    </td>
                    
                    <td >
                        <img src="<?=get_image($song['image'])?>" class="class_19" >
                    </td>
                    <td >
                        <a href="upload.php?id=<?=$song['id']?>&mode=edit">
                            <button class="class_20"  >
                                Edit
                            </button>
                        </a>
                        <a href="upload.php?id=<?=$song['id']?>&mode=delete">
                            <button class="class_21"  >
                                Delete
                            </button>
                        </a>
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
        <div class="class_23" >
        </div>
        <a href="admin.php?section=songs&page=<?=($page_number -1)?>">
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
        <a href="admin.php?section=songs&page=<?=($page_number +1)?>">
        <button class="class_25"  >
            Next page
        </button>
            </a>
    </div>
