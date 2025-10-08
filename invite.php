<?php
include('conectar.php');

if(!isset($_GET['c']) || empty($_GET['c'])){
	header("Location: index.php");
	exit;
}
//== Get invite code from URL ===//
$code = $_GET['c'];

//== Get user info based on invite code ===//
$query_guy = "SELECT * FROM user WHERE code_user = ?";
$stmt_guy  = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $code);
$stmt_guy->execute();
$rs_guy	= $stmt_guy->get_result();
$exist_code = $rs_guy->num_rows;

//== If code does not exist, return to index ===//
if($exist_code < 1){
	header("Location: index.php");
	exit;
}

$infoguy= $rs_guy->fetch_array();
$stmt_guy->close();	

//== Get user info ===//
$nome_user	= $infoguy['nome_user'];
$login_user	= $infoguy['login_user'];
$senha_user	= $infoguy['senhamd5false_user'];
?>
<!DOCTYPE html>
<html manifest="cache.manifest">
<head>
  <title>Convite para MiqtëKudo!</title>
  <?php include('full_header.php'); ?>  
  <style type=text/css>
	body{
		background:url(back1.jpg);
		background-size:cover;
		background-attachment:fixed;
		font-family:Verdana, Geneva, sans-serif;
	}
	#transp {
		width: 100%;
		height: 80%;
		position: relative;
		background-color: rgba(255, 255, 255, .7);
	z-index: 3;
	-webkit-transition: top 1s;
	}
    div[data-role=navbar] .ui-btn .ui-btn-inner { 
      background:url(images/backsis.png) fixed;
    }
    div[data-role=navbar] .ui-btn .ui-icon { 
      width: 40px; 
      height: 40px; 
      margin-left: -20px; 
    }
    .circular_photo_user {
      width: 40px;
      height: 40px;
      border-radius: 40px;
      -webkit-border-radius: 50px;
      -moz-border-radius: 50px;
      background: url(photos/<?=$photo_user?>);
      background-size:contain;
      box-shadow: 0 0 8px rgba(0, 0, 0, .8);
      -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
      -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
    }
  </style>
</head>
<body>
<div data-role="page" style="background:url(back1.jpg) no-repeat; background-attachment:fixed; background-size:cover;" id="home">
	<table height="100%" style="padding-top:10px;" align="center" width="100%" border="0">
		<tr>
			<td align="center">
				<br>
				<br>
				<img src="logo.png" style="max-width:387px" width="95%">
			</td>
		</tr>
		<tr>
			<td align="center">
				<section id="transp">
					<!--- Welcomes the user and shows them their login and temporary password --->
					<h1>Olá, <?=$nome_user;?>!</h1>
					<table border="0">
						<tr>
							<td width="10" rowspan="5">&nbsp;</td>
							<td colspan="2">
								<h2>Você foi convidado/a participar do MiqtëKudo! Abaixo o seu login e senha, e o tutorial de como usar o app no seu telefone!</h2>
							</td>
							<td width="5" rowspan="5">&nbsp;</td>
						</tr>
						<tr>
							<td width="70" align="right"><h2>Login:</h2></td>
 							<td width="390"><h2><?=$login_user?></h2></td>
 						</tr>
						<tr>
							<td align="right"><h2>Senha:</h2></td>
							<td><h2><?=$senha_user?></h2></td>
						</tr>
						<tr>
							<!--- Password change notice --->
							<td colspan="2">
								<h3>* Você pode trocar a senha indo no seu perfil > Editar Perfil > Trocar Senha! *</h3>
							</td>
						</tr>
						<tr>
							<!--- Tutorial for "downloading" the app on iOS and Android --->
							<td colspan="2" align="center">
								<a href="downinfo.php?o=ios">
									<img src="images/tuto/useios.png" style="max-width:200px;" width="50%">
								</a>						
								<a href="downinfo.php?o=android">
									<img src="images/tuto/useandroid.png" style="max-width:200px;" width="50%">
								</a>
							</td>
						</tr>
					</table>
   				</section>
            </td>
	    </tr>
		<tr>
			<td>&nbsp;</td>
	    </tr>
    </table>
</div>
</body>
</html>
