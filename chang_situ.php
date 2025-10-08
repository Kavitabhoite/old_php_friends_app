<?php
include('conectar.php');
$newsitu = $_GET['ns'];
$eveid	 = $_GET['ie'];
$useid	 = $_GET['iu'];

//== Check if the user has already confirmed this event ==//
$query_exist = "SELECT * FROM confirm_event WHERE eveid_conf = ? AND useid_conf = ?";
$stmt_exist  = $conexao->prepare($query_exist);
$stmt_exist->bind_param("ii",
    $eveid, //=== Event ID
    $useid //=== User ID
);
$stmt_exist->execute();
$res_exist	 = $stmt_exist->get_result();
$existir_tru = $res_exist->num_rows; 
$stmt_exist->close();

//== If not, insert the confirmation, if so, update it ==//
if($existir_tru == 0){
    $query_update = "INSERT INTO confirm_event(id_conf, eveid_conf, useid_conf, situation_conf) VALUES (NULL, ?, ?, ?)";
    $stmt_update  = $conexao->prepare($query_update);
    $stmt_update->bind_param("iis",
        $eveid, //=== Event ID
        $useid, //=== User ID
        $newsitu //=== New situation
    );
    $stmt_update->execute();
    $stmt_update->close();

    header("Location: eventshow.php?i=".$eveid);
    exit();
}else{

    $query_update = "UPDATE confirm_event SET situation_conf=? WHERE eveid_conf = ? AND useid_conf = ?";
    $stmt_update  = $conexao->prepare($query_update);
    $stmt_update->bind_param("sii",
        $newsitu, //=== New situation
        $eveid, //=== Event ID
        $useid //=== User ID
    );
    $stmt_update->execute();
    $stmt_update->close(); 

    header("Location: eventshow.php?i=".$eveid);
    exit();
}
?>
CARREGANDO...