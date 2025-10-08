<?php
include('conectar.php');
include('rest.php');

//=== If there is no action, return to main page ===//
if(!isset($_GET['a'])){
	header("Location: pri.php");
	exit();
}

//== Perform action based on the 'a' parameter ==//
switch($_GET['a']){
	//=== Edit profile information ===//
	case 'edit':

		//== Get current user info ===//
		$query_guy = "SELECT * FROM user WHERE login_user = ?";
		$stmt_guy   = $conexao->prepare($query_guy);
		$stmt_guy->bind_param("s", $logina_sess);
		$stmt_guy->execute();
		$rs_guy = $stmt_guy->get_result();
		$infoguy= $rs_guy->fetch_array();
		$stmt_guy->close();

		$id_guy		= $infoguy['id_user'];                        
		$senha_guy	= $infoguy['senha_user'];
		
		//This gets all the other information from the form 
		$apel_new  = $_POST['apel_new'];
		$senha_new = $_POST['senha_new'];

		// If the password field is empty, keep the old password
		if($senha_new == ''){
			$senha_fim = $senha_guy;
		}else{
			// If a new password is provided, hash it
			// MD5 used to be common, but now it's recommended to use stronger hashing algorithms
			// To preserve the original code, I kept MD5 here
			$senha_fim = md5($senha_new);
		}

		$query_update = "UPDATE user SET apel_user = ?, senha_user = ? WHERE id_user = ?";
		$stmt_update = $conexao->prepare($query_update);
		$stmt_update->bind_param(
			"ssi",
			$apel_new, // === New "Nickname" === //
			$senha_fim, // === New or old "Password" (hashed) === //
			$id_guy // === User ID to identify which record to update === //
		);
		$stmt_update->execute();
		$stmt_update->close();

		header("Location: perfs.php");
		exit();
	break;
	//=== Edit profile photo ===//
	case 'editphoto':
		function findexts ($filename){ 
			$filename 	= strtolower($filename); 
			// Use explode() instead of split()
			// Originally $exts = split("[/\\.]", $filename);
			$exts 		= explode(".", $filename); 
			$n 			= count($exts)-1; 
			$exts 		= $exts[$n]; 
			return $exts; 
		}

		//== Get current user info ===//
		$query_guy = "SELECT * FROM user WHERE login_user = ?";
		$stmt_guy   = $conexao->prepare($query_guy);
		$stmt_guy->bind_param("s", $logina_sess);
		$stmt_guy->execute();
		$rs_guy = $stmt_guy->get_result();
		$infoguy= $rs_guy->fetch_array();
		$stmt_guy->close();

		$id_guy		= $infoguy['id_user'];                        
		$senha_guy	= $infoguy['senha_user'];

		//This gets the photo URL from the form
		$photo_old 	= $_POST['photo_old'];
		
		// If no new photo is uploaded, keep the old one
		if($_FILES['photo_new']['name'] == ''){
			$photo_fim = $photo_old;
			header("Location: perfs.php");
			exit();
		}else{
			if ($_FILES['photo_new']['error'] !== UPLOAD_ERR_OK) {
				die("Upload Error Code: " . $_FILES['photo_new']['error']);
			}
			// If a new photo is uploaded, process it		
			$ext 	= findexts($_FILES['photo_new']['name']); // Get the file extension	
			$ran 	= rand();
			$ran2 	= $ran.".";
			$target = "photos/";
			$target = $target . $ran2.$ext; 
			echo $target;	

			if(move_uploaded_file($_FILES['photo_new']['tmp_name'], $target)){
				// If there was an old photo (not the default 'nonem.jpg'), delete it
				if($photo_old != 'nonem.jpg'){					
					unlink('photos/' .$photo_old);					
				}
				$photo_fim = $ran2.$ext;
				$query_update = "UPDATE user SET photo_user = ? WHERE id_user = ?";
				$stmt_update = $conexao->prepare($query_update);
				$stmt_update->bind_param(
					"si",
					$photo_fim, // New photo filename
					$id_guy // User ID
				);
				$stmt_update->execute();
				$stmt_update->close();

				header("Location: perfs.php");
				exit();
			}else{
				echo "Houve um problema ao subir a foto.";
			}
		}
	break;
	//=== New user ===//
	case 'new':
		//This gets all the other information from the form		
		$nome		 = $_POST['nome'];
		$login	 	 = $_POST['login'];
		$senha_new	 = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 6 ); // New random password
		$code_new	 = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDE#@%FGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 10 ); // New random code
		$photo_none  = 'nonem.jpg'; // Default photo
		$apel_none	 = ''; // Default nickname
		$senha_final = md5($senha_new); // Hash the new password
		$visit_none = 0; // Initial visit count

		$query_insert = "INSERT INTO user(nome_user,login_user,apel_user,senha_user,photo_user,visit_user,code_user,senhamd5false_user) VALUES (?,?,?,?,?,?,?,?)";
		$stmt_insert = $conexao->prepare($query_insert);
		$stmt_insert->bind_param(
			"sssssiss",
			$nome, // === Name === //
			$login, // === Login === //
			$apel_none, // === Default "Nickname" === //
			$senha_final, // === Hashed Password === //
			$photo_none, // === Default Photo === //
			$visit_none, // === Initial Visit Count, redirects the new user to the tutorial === //
			$code_new, // === Random Code === //
			$senha_new // === Plain Password for reference (not secure) === //
		);
		$stmt_insert->execute();
		$stmt_insert->close();

		header("Location: membs.php");
		exit();		
	break;
}
?>