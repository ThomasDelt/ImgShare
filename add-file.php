 <?php

 define("CONST_MAX_SIZE", 2097152);
 define("CONST_FILE_DIR","upload/");
 define("CONST_ERROR_SIZE", "errorSize");
 define("CONST_ERROR_UPLOAD", "errorUpload");
 define("CONST_ERROR_EXTENSION", "errorExtension");
 define("CONST_ERROR_NOFILE", "errorNoFile");
 define("CONST_SUCCESS", "ok");
 $tabExt = array('jpg','gif','png','jpeg','bmp');    // Extensions autorisees
 $info = @getimagesize($_FILES['img']['tmp_name']);

 if( !empty($_FILES['img']['name']) && $info){
 	$fileName 	= $_FILES['img']['name'];
 	$file 		= $_FILES["img"]["tmp_name"];
 	$fileSize 	= $_FILES['img']['size'];
 	$fileType 	= $_FILES['img']['type'];
 	$ip = get_ip();
 	header("Content-type: image/png");
 	//On récupère l'extension de l'image
 	$temporary = explode(".", $fileName);
	$fileExtension = strtolower(end($temporary));

	//Contrôle de la taille et de l'extension
 	if($fileSize < CONST_MAX_SIZE){
 		if(in_array($fileExtension,$tabExt)){
 			$idUnique = uniqid();
 			$fichier = $idUnique.".".$fileExtension;
 			if(move_uploaded_file($file, CONST_FILE_DIR.$fichier)){
 				//Création de la miniature
 				$size = GetImageSize(CONST_FILE_DIR . $fichier );
				$width = $size[ 0 ];
				$height = $size[ 1 ];
				$dest_h = 175;
				$dest_w = 255;
				$miniature = ImageCreateTrueColor( $dest_w, $dest_h);
				if($fileExtension == "png"){
					$image = imagecreatefrompng(CONST_FILE_DIR . $fichier);
					ImageCopyResampled( $miniature, $image, 0, 0, 0, 0, $dest_w, $dest_h, $width, $height );
					imagepng( $miniature, CONST_FILE_DIR . 'mini/' . $fichier, 0, PNG_NO_FILTER );
				}
				else if($fileExtension == "jpg" || $fileExtension == "jpeg"){
					$image = imagecreatefromjpeg( CONST_FILE_DIR . $fichier);
					ImageCopyResampled( $miniature, $image, 0, 0, 0, 0, $dest_w, $dest_h, $width, $height );
					imagejpeg( $miniature, CONST_FILE_DIR . 'mini/' . $fichier, 100 );
				}
				else if($fileExtension == "gif"){
					$image = imagecreatefromgif( CONST_FILE_DIR . $fichier);
					ImageCopyResampled( $miniature, $image, 0, 0, 0, 0, $dest_w, $dest_h, $width, $height );
					imagegif( $miniature, CONST_FILE_DIR . 'mini/' . $fichier, 100 );
				}
				

 				//Requete SQL pour stocker les chemins
 				$finalName = CONST_FILE_DIR.$idUnique.".".$fileExtension ;
 				$miniature = CONST_FILE_DIR."mini/".$idUnique.".".$fileExtension; 
 				$pdo = new PDO('mysql:host=localhost;dbname=imgshare', 'root', '');
 				$sql =$pdo->prepare('INSERT INTO images(nom,ip_client,miniature) VALUES(:nom, :ip,:miniature)');
 				$sql->bindValue(":nom", $finalName);
 				$sql->bindValue(":ip", $ip);
 				$sql->bindValue(":miniature", $miniature);
 				$sql->execute();
 				echo CONST_SUCCESS;
 			} 
 			else{
 				echo CONST_ERROR_UPLOAD ;
 			}
 		}
 		else{
 			echo CONST_ERROR_EXTENSION ;
 		}
 	}
 	else {
 		echo CONST_ERROR_SIZE ;
 	}
 }else{
 	echo CONST_ERROR_NOFILE;
 }
 function get_ip() {
	// IP si internet partagé
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	}
	// IP derrière un proxy
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	// Sinon : IP normale
	else {
		return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
	}
}
