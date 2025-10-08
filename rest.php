<?php
@session_start();
if (isset($_SESSION['logina']) && isset($_SESSION['senha'])){
   $logina_sess = $_SESSION['logina'];
}else{
   header("Location:index.php");
   exit();
}
?>
