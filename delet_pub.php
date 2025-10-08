<?php
include('conectar.php');
include('rest.php');

//== Check if the action is set, if not, return to main page ==//
if(!isset($_GET['a'])){
	header("Location: pri.php");
	exit();
}

//== Get action type ==//
switch($_GET['a']){
	//== Deletion of a post ==//
	case 'pub':
		$pub_id 	= $_POST['pi'];
		$use_id	 	= $_POST['ui'];
		$event_id 	= $_POST['ie'];

		//== Get user info ===//
		$query_guy  = "SELECT * FROM user WHERE login_user = ?";
		$stmt_guy   = $conexao->prepare($query_guy);
		$stmt_guy->bind_param("s", $logina_sess);
		$stmt_guy->execute();
		$rs_guy = $stmt_guy->get_result();
		$infoguy= $rs_guy->fetch_array();
		$stmt_guy->close();
								
		$id_user	= $infoguy['id_user'];

		//== Check if the user deleting the post is the one who created it ==//
		if($use_id == $id_user){
			$query_delete1 = "DELETE FROM publication_event WHERE id_pub = ?";
			$stmt_delete1  = $conexao->prepare($query_delete1);
			$stmt_delete1->bind_param("i", $pub_id);
			$stmt_delete1->execute();
			$stmt_delete1->close();

			$query_delete2 = "DELETE FROM comment_event WHERE idpub_comment = ?";
			$stmt_delete2  = $conexao->prepare($query_delete2);
			$stmt_delete2->bind_param("i", $pub_id);
			$stmt_delete2->execute();
			$stmt_delete2->close();

			header("Location: eventshow.php?i=".$event_id);
			exit();
		}else{
			//== If not, just return to event page ==//
			header("Location: eventshow.php?i=".$event_id);
			exit();
		}
	break;
	//== Deletion of a comment ==//
	case 'comment':
		$com_id   = $_POST['ci'];
		$use_id	  = $_POST['ui'];
		$event_id = $_POST['ie'];

		//== Get user info ===//
		$query_guy  = "SELECT * FROM user WHERE login_user = ?";
		$stmt_guy   = $conexao->prepare($query_guy);
		$stmt_guy->bind_param("s", $logina_sess);
		$stmt_guy->execute();
		$rs_guy = $stmt_guy->get_result();
		$infoguy= $rs_guy->fetch_array();
		$stmt_guy->close();
								
		$id_user	= $infoguy['id_user'];

		//== Check if the user deleting the comment is the one who created it ==//
		if($use_id == $id_user){
			$query_delete1 = "DELETE FROM comment_event WHERE id_comment = ?";
			$stmt_delete1  = $conexao->prepare($query_delete1);
			$stmt_delete1->bind_param("i", $com_id);
			$stmt_delete1->execute();
			$stmt_delete1->close();

			header("Location: eventshow.php?i=".$event_id);
			exit();
		}else{
			header("Location: eventshow.php?i=".$event_id);
			exit();
		}
	break;
}
?>
CARREGANDO...