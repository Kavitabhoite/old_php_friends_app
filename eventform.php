<?php
include('conectar.php');
include('rest.php');

//== Redirect if no action is specified ==//
if(!isset($_GET['a'])){
	header("Location: events.php");
	exit();
}

switch($_GET['a']){
	//== Edit event ==//
	case 'edit':
		$id_event	 = $_POST['id_event'];
		$creator	 = $_POST['creator'];
		$tit_new 	 = $_POST['tit_new'];
		$ano_new	 = $_POST['ano_new'];
		$dia_new	 = $_POST['dia_new'];
		$mes_new	 = $_POST['mes_new'];
		$hour_new	 = $_POST['hour_new'];
		$min_new	 = $_POST['min_new'];
		$place_new	 = $_POST['place_new'];
		$desc_new	 = $_POST['desc_new'];
		$datatot_new = $ano_new . "-" . $mes_new . "-" . $dia_new;
		$time_new	 = $hour_new . ":" . $min_new;

		// Prepare the SQL statement for updating an event using mysqli
		$query_edit	= "UPDATE event SET titulo_event=?, dia_event=?, mes_event=?, ano_event=?, datatot_event=?, hora_event=?, place_event=?, desc_event=? WHERE id_event = ? AND creator_event = ?";
		$stmt_edit 	= $conexao->prepare($query_edit);
		$stmt_edit->bind_param(
			"siiissssss",
			$tit_new,      // Title of the event
			$dia_new,      // Day of the event (numeric)
			$mes_new,      // Month of the event (numeric)
			$ano_new,      // Year of the event (numeric)
			$datatot_new,  // Full date of the event (formatted string)
			$time_new,     // Time of the event
			$place_new,    // Location where the event will take place
			$desc_new,     // Description of the event
			$id_event,       // Unique identifier for the event
			$creator       // Name or identifier of the event creator
		);
		$stmt_edit->execute();
		$stmt_edit->close();

		header("Location: eventshow.php?i=".$id_event);
		exit();
	break;
	//== New event ==//
	case 'new':
	
		$creator	 = $_POST['creator'];
		$tit_new 	 = $_POST['tit_new'];
		$ano_new	 = $_POST['ano_new'];
		$dia_new	 = $_POST['dia_new'];
		$mes_new	 = $_POST['mes_new'];
		$hour_new	 = $_POST['hour_new'];
		$min_new	 = $_POST['min_new'];
		$place_new	 = $_POST['place_new'];
		$desc_new	 = $_POST['desc_new'];
		$datatot_new = $ano_new . "-" . $mes_new . "-" . $dia_new;
		$time_new	 = $hour_new . ":" . $min_new;
		$exist_new	 = 0;

		// Prepare the SQL statement for inserting a new event using mysqli
		$query_edit = "INSERT INTO event (titulo_event, dia_event, mes_event, ano_event, datatot_event, hora_event, place_event, desc_event, creator_event, exist_event) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt 		= $conexao->prepare($query_edit);
		$stmt->bind_param(
			"siiisssssi",
			$tit_new,      // Title of the event
			$dia_new,      // Day of the event (numeric)
			$mes_new,      // Month of the event (numeric)
			$ano_new,      // Year of the event (numeric)
			$datatot_new,  // Full date of the event (formatted string)
			$time_new,     // Time of the event
			$place_new,    // Location where the event will take place
			$desc_new,     // Description of the event
			$creator,      // Name or identifier of the event creator
			$exist_new     // Existence flag (0 for active, 1 for canceled)
		);
		$stmt->execute();
		$stmt->close();
		$conexao->close();

		header("Location: events.php");
	break;
	//== Cancel event ==//
	case 'anular':	
		$id_event = $_POST['ie'];
		$creator  = $_POST['creator'];

		$query = "UPDATE event SET exist_event=? WHERE id_event = ? AND creator_event = ?";
		$stmt = $conexao->prepare($query);
		$exist_event = 1;
		$stmt->bind_param(
			"iis",           
			$exist_event,    // Existence flag (1 for canceled)
			$id_event,       // Unique identifier for the event
			$creator         // Name or identifier of the event creator
		);
		$stmt->execute();
		$stmt->close();
		$conexao->close();

		header("Location: eventshow.php?i=".$id_event);
		exit();			
	break;
	//== Restore event ==//
	case 'restaurar':			
		$id_event = $_POST['ie'];
		$creator  = $_POST['creator'];

		$query = "UPDATE event SET exist_event=? WHERE id_event = ? AND creator_event = ?";
		$stmt = $conexao->prepare($query);
		$exist_event = 0;
		$stmt->bind_param(
			"iis",           
			$exist_event,    // Existence flag (0 for active)
			$id_event,       // Unique identifier for the event
			$creator         // Name or identifier of the event creator
		);
		$stmt->execute();
		$stmt->close();
		$conexao->close();

		header("Location: eventshow.php?i=".$id_event);
		exit();		
	break;
	//== Default action: redirect to events page ==//
	default:
		header("Location: events.php");
	break;
}
?>
CARREGANDO...