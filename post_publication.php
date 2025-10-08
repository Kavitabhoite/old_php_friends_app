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
	//== Publication of a new post ==//
	case 'pub':
		//== Get data from form ==//
		$text 		= $_POST['text_pub'];
		$use_id	 	= $_POST['iu'];
		$event_id 	= $_POST['ie'];

		//== Insert into database ==//
		$query_insert	= "INSERT INTO publication_event (id_pub, ideve_pub, iduse_pub, text_pub) VALUES (NULL, ?, ?, ?)";
		$stmt_insert	= $conexao->prepare($query_insert);
		$stmt_insert->bind_param("iis",
		    $event_id, //=== Event ID
		    $use_id, //=== User ID
		    $text //=== Publication text
		);
		$stmt_insert->execute();
		$stmt_insert->close();
		
		header("Location: eventshow.php?i=".$event_id);
		exit();
	break;
	//== Publication of a new comment ==//
	case 'comment':
		//== Get data from form ==//
		$text     = $_POST['text_comment'];
		$use_id   = $_POST['iu'];
		$event_id = $_POST['ie'];
		$pub_id   = $_POST['ip'];

		//== Insert into database ==//
		$query_insert = "INSERT INTO comment_event (id_comment, ideve_comment, idpub_comment, iduse_comment, text_comment) VALUES (NULL, ?, ?, ?, ?)";
		$stmt_insert  = $conexao->prepare($query_insert);
		$stmt_insert->bind_param("iiis",
		    $event_id, //=== Event ID
		    $pub_id, //=== Publication ID
		    $use_id, //=== User ID
		    $text //=== Comment text
		);
		$stmt_insert->execute();
		
		header("Location: eventshow.php?i=".$event_id);
		exit();
	break;
}
?>
CARREGANDO...