<?php
include('conectar.php');
include('rest.php');
$user_ss = $_SESSION['logina'];

$query_guy 	= "SELECT * FROM user WHERE login_user = ?";
$stmt 		= $conexao->prepare($query_guy);
$stmt->bind_param("s", $user_ss);
$stmt->execute();
$result 	= $stmt->get_result();
$infoguy 	= $result->fetch_assoc();
$stmt->close();

$id_user	= $infoguy['id_user'];
$photo_user	= $infoguy['photo_user'];

//== Get step in the tutorial ===//
if (isset($_GET['step'])){
	$step = $_GET['step'];
} else {
	$step = 1;
}
?>
<!DOCTYPE html> 
<html> 
<head> 
	<?php include('full_header.php'); ?>
	<title>Tutorial MiqteKudo</title>
</head> 
<body topmargin="0" leftmargin="0"> 
	<div data-role="page" style="background:#71cb2e;" id="home" data-theme="b">
		<div>
			<?php
			switch($step){
				case 1:
					echo '<img src="images/tuto/1.png" width="100%">';
				break;
				case 2:
					echo '<img src="images/tuto/2.png" width="100%">';
				break;
				case 3:
					echo '<img src="images/tuto/3.png" width="100%">';
				break;
				case 4:
					echo '<img src="images/tuto/4.png" width="100%">';
				break;
				case 5:
					echo '<img src="images/tuto/5.png" width="100%">';
				break;
				case 6:
					echo '<img src="images/tuto/6.png" width="100%">';
				break;
				case 7:
					echo '<img src="images/tuto/7.png" width="100%">';
				break;
				case 8:
					echo '<img src="images/tuto/8.png" width="100%">';
				break;
				case 9:
					echo '<img src="images/tuto/9.png" width="100%">';
				break;
				case 10:
					echo '<img src="images/tuto/10.png" width="100%">';
				break;
				case 11:
					echo '<img src="images/tuto/11.png" width="100%">';
				break;
				case 12:
					echo '<img src="images/tuto/12.png" width="100%">';
				break;
				case 13:
					echo '<img src="images/tuto/13.png" width="100%">';
				break;
				case 14:
					echo '<img src="images/tuto/14.png" width="100%">';
				break;
			}
			?>
		</div>
		<div data-role=content align="center">
			<p>&nbsp;</p>
		</div>
		<div data-role="footer" data-position="fixed">		
			<div data-role="navbar">
				<ul>
					<li>
						<a href="<?php switch($step){ 
							case 1: echo "#"; break;
							case 2: echo "tuto.php?step=1"; break;
							case 3: echo "tuto.php?step=2"; break;
							case 4: echo "tuto.php?step=3"; break;
							case 5: echo "tuto.php?step=4"; break;
							case 6: echo "tuto.php?step=5"; break;
							case 7: echo "tuto.php?step=6"; break;
							case 8: echo "tuto.php?step=7"; break;
							case 9: echo "tuto.php?step=8"; break;
							case 10: echo "tuto.php?step=9"; break;
							case 11: echo "tuto.php?step=10"; break;
							case 12: echo "tuto.php?step=11"; break;
							case 13: echo "tuto.php?step=12"; break;
							case 14: echo "tuto.php?step=13"; break;									
							} ?>" data-transition="slideup" data-icon="arrow-l">
							Voltar
						</a>
						<?=$user_ss;?>
					</li>
					<li>
						<a href="<?php
							switch($step){ 
								case 1: echo "tuto.php?step=2"; break;
								case 2: echo "tuto.php?step=3"; break;
								case 3: echo "tuto.php?step=4"; break;
								case 4: echo "tuto.php?step=5"; break;
								case 5: echo "tuto.php?step=6"; break;
								case 6: echo "tuto.php?step=7"; break;
								case 7: echo "tuto.php?step=8"; break;
								case 8: echo "tuto.php?step=9"; break;
								case 9: echo "tuto.php?step=10"; break;
								case 10: echo "tuto.php?step=11"; break;
								case 11: echo "tuto.php?step=12"; break;
								case 12: echo "tuto.php?step=13"; break;
								case 13: echo "tuto.php?step=14"; break;
								case 14: echo "pri.php"; break;									
							} ?>" data-transition="slidedown" data-icon="arrow-r">
							<?php
							switch($step){
								case 14: echo "Usar MK!"; break;
								default: echo "Avan&ccedil;ar"; break;
							}
							?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>