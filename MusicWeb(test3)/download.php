<?php
    require 'init.php';

    $id=$_GET['id'] ?? 0;
    $id= (int)$id;

    $query= "select * from songs where id='$id' limit 1";
    $song= query($query);
    $query1="update songs set downloads=downloads+1 where id='$id' limit 1";
    $download= query($query1);

    if(!empty($song)){
        $file = $song[0]['file'];
        if(file_exists($file)){
            header("Content-Description: File Transfer");
            header("Content-Type:".mime_content_type($file));
            header('Content-Transfer-Encoding: binary');
            header('Content-Disposition: attachment; filename="'.basename($file).'"'); //download
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit();
    
        }else{
            echo "that file does not exist";
        }
    }else{
        echo "could not file that song";
    }
?>