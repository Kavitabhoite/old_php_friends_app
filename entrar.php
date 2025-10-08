<?php
include("conectar.php");

$user	= $_POST['user'];
$senha 	= md5($_POST['senha']);

$sql_logar 	= "SELECT * FROM user WHERE login_user = ? AND senha_user = ?";
$stmt 		= $conexao->prepare($sql_logar);
$stmt->bind_param("ss", $user, $senha);
$stmt->execute();
$result = $stmt->get_result();
$fet_logar = $result->fetch_array();
$num_logar = $result->num_rows;

$query_visit 	= "SELECT * FROM user WHERE login_user = ? AND senha_user = ?";
$stmt_visit 	= $conexao->prepare($query_visit);
$stmt_visit->bind_param("ss", $user, $senha);
$stmt_visit->execute();
$result_visit 	= $stmt_visit->get_result();
$infovisit 		= $result_visit->fetch_array();

$visits = $infovisit['visit_user'];

//=== If no user found ===//
if ($num_logar == 0){
?>
	<!DOCTYPE html>
	<html manifest="cache.manifest">
	<head>
		<meta name="viewport" content="user-scalable=no,width=device-width" />
		<title>Miqt&euml; Kudo</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel=stylesheet
		href=http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css />
		<script src=http://code.jquery.com/jquery-1.6.min.js></script>
		<script src=http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js>
		</script>
		<meta name="format-detection" content="telephone=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="HandheldFriendly" content="true">
		<link rel="icon" href="favicon.ico">
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="apple-touch-icon" href="apple-touch-icon.png" />
		<link rel="apple-touch-icon-precomposed" href="apple-touch-icon.png" />
		<meta name="apple-mobile-web-app-status-bar-style" content="green" />
		<meta name="mobile-web-app-capable" content="yes">
		<link rel="shortcut icon" sizes="196x196" href="apple-touch-icon.png">
		<link rel="shortcut icon" sizes="128x128" href="apple-touch-icon.png">
		<meta property="og:title" content="NHS App"/>
		<meta property="og:image" content="apple-touch-icon.png"/>
		<meta property="og:site_name" content="AppBuilder"/>
		<meta property="og:type" content="product"/>
		<meta property="og:url" content="http://10.0.0.103/MiqteKudo"/>
		<link rel="stylesheet" type="text/css" href="css/html.css" /> 
		<link rel="stylesheet" href="css/dialog.css" media="screen" />
		<link rel="stylesheet" href="css/dialog-variants.css" media="screen" />
		<style type="text/css">
			body{
				background:url(back1.jpg);
				background-size:cover;
				background-attachment:fixed;
			}
			#transp {
				width: 100%;
				height: 80%;
				position: relative;
				background-color: rgba(255, 255, 255, .7);
				z-index: 3;
				-webkit-transition: top 1s;
			}
		</style>
		<script type="text/javascript" src="css/bookmark_bubble.js"></script>
		<script type="text/javascript" src="css/example.js"></script>
		<script src="css/htmlu.js"></script>
		<script>
			appbuilder.app.ready = function() {
				var phone = new app.control.webphone({
					"fullscreen": true,
					"background": false,
					"statusbar": false,
					"storage": true,
					"files": true,
					"update": false,
					"updateSingle": false,
					"browserHistory": false,
					"published": "2014-02-08 16:27:51"
				});
				document.id(phone).inject(document.id(document.body));
			};
		</script>
	</head>
	<body>
		<div data-role=page style="background:url(back1.jpg) no-repeat; background-attachment:fixed; background-size:cover;" id="home">
			<table height="100%" style="padding-top:10px;" align="center" width="100%" border="0">
				<tr>
					<td align="center">
						<br><br>
						<img src="logo.png" style="max-width:387px" width="95%">
					</td>
				</tr>
				<tr>
					<td align="center">
						<section id="transp">
							<h1>Ocorreu um erro!</h1>
							<table width="100%" border="0">
								<tr>
								<td width="190" align="center">
									<h2>
										Seu login ou senha n&atilde;o est&atilde;o correctos!<br>
										<a href="index.php" style="text-decoration:none; color:#000;" data-transition="fade">Clique aqui para voltar!</a>
									</h2>
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
<?php
}else{
	session_start();
	$_SESSION['logina']	= $user;
	$_SESSION['senha'] 	= $senha;
 
	$cookieLifetime = 365 * 24 * 60 * 60; // A year in seconds
	setcookie(session_name(),session_id(),time()+$cookieLifetime);

	if($visits != 1){
		//=== If this is the first visit, update visit_user to 1 and go to tutorial ===//
		$update_query = "UPDATE user SET visit_user = 1 WHERE login_user = ?";
		$stmt_update = $conexao->prepare($update_query);
		$stmt_update->bind_param("s", $user);
		$stmt_update->execute();
		$stmt_update->close();

		header("Location: tuto.php?step=1");
		exit;
	}else{
		//=== If this is not the first visit, go to main page ===//
		header("Location: pri.php");
		exit;
	} 
}
?>
	<p align="center">
		<font face="Verdana, Geneva, sans-serif">CARREGANDO...</font>
	<br />
</p>