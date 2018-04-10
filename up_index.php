<?php

DEFINE('MONMAXFILESIZE', 1048576); 

if ( isset ($_POST['delete_file']) ){
    $chemin = 'files/' . $_POST['delete_file'];
      if (file_exists($chemin)){
          unlink($chemin);
      }
}


if (!empty($_FILES)) {
  $I = count( $_FILES['fichier']['name']) ;
 
  for($i=0; $i < $I; $i++){
   $src = $_FILES['fichier'];
   $file_name = $src['name'][$i];
   $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
   $file_tmp_name = $src['tmp_name'][$i];
      
   $file_dest = 'files/' . 'image' . md5(uniqid($file_name)) .'.' .$file_extension;     
   $extensions_autorisees = array('JPG', 'JPEG', 'PNG', 'GIF');  
   if(!in_array( strtoupper($file_extension), $extensions_autorisees)){
        $error =  'Seuls les fichiers JPEG, PNG et GIF sont autorisés (fichier d\'extension)';        
      
  }    
  
     
  if (filesize($file_tmp_name) > MONMAXFILESIZE) {  
      $error = 'Le fichier est trop gros !'; 
  }
      
      
  if(!isset($error)) {     
      
      if(move_uploaded_file($file_tmp_name, $file_dest)){
        ?>
        <div class="alert alert-success" role="alert">
        Votre fichier est uploadé !
        </div> 
        <?php  
      }
      else{?>
        <div class="alert alert-danger" role="alert">
        Votre fichier est trop volumineux !
        </div> 
        <?php
      }
  }
 }
}

?>




<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Upload_fichiers</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">    
  <link rel="stylesheet" href="style_upload.css">
</head>
    
  <body>
   <h2 class="text-center">Uploader votre fichier</h2>      
   <div class="container"> 
   <?php if (isset($error)){
      echo 'Erreur';
   }?>   
     <form action="" method="post" enctype="multipart/form-data">
       <div class="form-group">
             <input type="hidden" name="MAX_FILE_SIZE" value="<?=MONMAXFILESIZE ?>"/>
             <input type="file" name="fichier[]" multiple="multiple"/> 
       </div>     
       <button type="submit" class="btn btn-default" value="Send">Envoyer</button>
    </form>
    <p><br></p>    
    <div class="row">
    <?php $f = scandir('files/');
    for($i=0; $i < count($f); $i++){
        if(($f[$i] == '.') || ($f[$i] == '..'))
        //if($f == ".." AND $f == ".")    
        continue;    
     ?>   
      <div class="card" style="width: 18rem;">
        <img class="card-img-top" src="files/<?php echo $f[$i]?>" alt="image">
          <div class="card-body">
            <h5 class="card-title"><?php echo $f[$i]?></h5>
          </div>      
          <form action="" method="post">   
          <input type="hidden" name="delete_file" value="<?= $f[$i] ?>"/>      
          <button type="submit" class="btn btn-danger" role="button">Supprimer</button>
          </form>  
      </div>
     <?php
    }              
     ?>   
    </div>   
   </div>
         
  </body>
</html>
