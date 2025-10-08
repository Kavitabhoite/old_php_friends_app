<?php
include("conectar.php");
@session_start();
if (isset($_SESSION['logina']) && isset($_SESSION['senha'])){
	//=== if the user is logged in, skip login page
	header("Location: pri.php");
}
?>
<!DOCTYPE html>
<html manifest="cache.manifest">
<head>
	<?php
		//=== Full header for mobile devices ===//
		include('full_header.php');
	?>	
	<title>MiqteKudo - Login</title>
</head>
<body>
	<div data-role="page" style="background:url(back1.jpg) no-repeat; background-attachment:fixed; background-size:cover;" id="home">
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
						<h1>Loga-te!</h1>
						<form action="entrar.php" method="post" data-ajax="false">
							<table width="200" border="0">
								<tr>
									<td width="96">
										<label for="user">Nome:</label>
									</td>
									<td width="94">									
										<input type="text" autocapitalize="off" name="user" id="user">
									</td>
								</tr>
								<tr>
									<td>
										<label for="senha">Senha:</label>
									</td>
									<td>
										<input type="password" name="senha" id="senha">
									</td>
								</tr>
								<tr>
									<td align="center" colspan="2">
										<input name="Entrar" type="submit" id="Entrar" value="Entrar">
									</td>
								</tr>
							</table>
						</form>
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
