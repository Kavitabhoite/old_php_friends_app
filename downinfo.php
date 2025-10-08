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
	a{
		color:#000;
		text-decoration:none;
	}
  </style>
</head>
<body>
	<div data-role="page" style="background:url(back1.jpg) no-repeat; background-attachment:fixed; background-size:cover;" id="home">
		<table height="100%" style="padding-top:20px;" align="center" width="100%" border="0">
			<tr>
				<td align="center">
					<p>
					<img src="logo.png" style="max-width:387px" width="95%">
				</td>
			</tr>
			<tr>
				<td align="center">
					<section id="transp">
						<p>
							<img src="images/appleicono.png" width="50%" style="max-width:100px">
						</p>
						<h2>
							<?php
								//--- Displays the correct form to "download" the app depending on the chosen Os ---//
								switch($_GET['o']){
									case 'ios':
										echo 'iOs';
									break;
									case 'android':
										echo 'Android';
									break;
								}
							?>
						</h2>
						<table border="0">
							<tr>
								<td width="10" rowspan="5">&nbsp;</td>
								<td colspan="2">
								<?php
									switch($_GET['o']){
										//--- Shows the tutorial for iOs / let the user choose which iOs ---//
										case 'ios': ?>
											<h2 align="center">Selecione a versão do seu sistema:<br> 
												<a href="downinfo.php?o=ios6">iOs 6</a> | <a href="downinfo.php?o=ios7">iOs 7</a>
											</h2>
										<?php
										break;
										//--- Shows the tutorial for iOs 6 ---//
										case 'ios6': ?>
											<table border="0" width="100%">
												<tr>
													<td align="center">
														<h2>Versão: iOs6</h2>
														<!-- Link to iOs7 version --->
														<h3><a href="downinfo.php?o=ios7">Ver iOs7</a></h3>
													</td>
												</tr>
												<tr>
													<td align="center">
														<!--- Info --->
														<table border="0" width="100%">
															<tr>
																<td align="center">
																	<img src="images/ios6tuto/1.jpg" width="211" height="317">
																</td>
															</tr>
															<tr>
																<td align="center">Abra o Safari</td>
															</tr>
														</table>
														<!--- Info --->
													</td>
												</tr>
												<tr>
													<td align="center">
														<!--- Info --->
														<table border="0" width="100%">
															<tr>
																<td align="center">
																	<img src="images/ios6tuto/2.jpg" width="211" height="317">
																</td>
															</tr>
															<tr>
																<!--- shows the old link (2013) to the app --->
																<td align="center">Entre http://www.mk.camk.net/</td>
															</tr>
														</table>
														<!--- Info --->
													</td>
												</tr>
												<tr>
													<td align="center">
														<!--- Info --->
														<table border="0" width="100%">
															<tr>
																<td align="center"><img src="images/ios6tuto/3.jpg" width="211" height="317">
															</td>
															</tr>
															<tr>
																<td align="center">Aperte no botão &quot;compartilhar (<img src="images/sharebuttonios6.png" width="30" height="26">)&quot;</td>
															</tr>
														</table>
														<!--- Info --->
													</td>
												</tr>
												<tr>
													<td align="center">
													<!--- Info --->
														<table border="0" width="100%">
														<tr>
															<td align="center"><img src="images/ios6tuto/4.jpg" width="211" height="317">
														</td>
														</tr>
														<tr>
															<td align="center">Selecione &quot;Adicionar à tela inicial&quot;</td>
														</tr>
													</table>
													<!--- Info --->
													</td>
												</tr>
												<tr>
													<td align="center">
														<!--- Info --->
														<table border="0" width="100%">
															<tr>
																<td align="center"><img src="images/ios6tuto/5.jpg" width="211" height="317">
															</td>
															</tr>
															<tr>
																<td align="center">Aperte em &quot;Adicionar&quot;</td>
															</tr>
														</table>
														<!--- Info --->
													</td>
												</tr>
												<tr>
													<td align="center">
														<!--- Info --->
														<table border="0" width="100%">
															<tr>
																<td align="center"><img src="images/ios6tuto/6.jpg" width="211" height="317">
															</td>
															</tr>
															<tr>
																<td align="center">Pronto! Agora é só abrir o app e aproveitá-lo! :D</td>
															</tr>
														</table>
														<!--- Info --->
													</td>
												</tr>
												<tr>
													<td align="center">
														<!--- Encouragement to ask for help --->
														<h3>Não conseguiu? Fale comigo! Ajudar-te-ei! :D</h3>
													</td>
												</tr>
											</table>
										<?php
										break;
										//--- Shows the tutorial for iOs 7 ---//
										case 'ios7': ?>
											<table border="0" width="100%">
												<tr>
													<td align="center">
														<!--- Info --->
														<table border="0" width="100%">
															<tr>
																<td align="center">
																<h2>Versão: iOs7</h2>
																<!-- Link to iOs6 version --->
																<h3><a href="downinfo.php?o=ios6">Ver iOs6</a></h3>
															</td>
															</tr>
															<tr>
																<td align="center">
																	<img src="images/ios7tuto/1.jpg" width="211">
																</td>
															</tr>
															<tr>
																<td align="center">Abra o Safari</td>
															</tr>
														</table>
														<!--- Info --->
													</td>
													</tr>
													<tr>
														<td align="center">
															<!--- Info --->
															<table border="0" width="100%">
																<tr>
																	<td align="center"><img src="images/ios7tuto/2.jpg" width="211" height="374">
																</td>
																</tr>
																<tr>
																	<!--- shows the old link (2013) to the app --->
																	<td align="center">Entre http://www.mk.camk.net/</td>
																</tr>
															</table>
															<!--- Info --->
														</td>
													</tr>
													<tr>
														<td align="center">
															<!--- Info --->
															<table border="0" width="100%">
																<tr>
																	<td align="center"><img src="images/ios7tuto/3.jpg" width="211" height="374">
																</td>
																</tr>
																<tr>
																	<td align="center">Aperte no botão &quot;compartilhar (<img src="images/sharebuttonios.png" width="32" height="28">)&quot;</td>
																</tr>
															</table>
															<!--- Info --->
														</td>
													</tr>
													<tr>
														<td align="center">
															<!--- Info --->
															<table border="0" width="100%">
																<tr>
																	<td align="center"><img src="images/ios7tuto/4.jpg" width="211" height="374">
																</td>
																</tr>
																<tr>
																	<td align="center">Selecione &quot;Adicionar à tela inicial (<img src="images/addtohomescreen.png" width="58" height="77">)&quot;</td>
																</tr>
															</table>
															<!--- Info --->
														</td>
													</tr>
													<tr>
														<td align="center">
															<!--- Info --->
															<table border="0" width="100%">
															<tr>
																<td align="center"><img src="images/ios7tuto/5.jpg" width="211" height="374">
															</td>
															</tr>
															<tr>
																<td align="center">Aperte em &quot;Adicionar&quot;</td>
															</tr>
															</table>
															<!--- Info --->
														</td>
													</tr>
													<tr>
														<td align="center">
															<!--- Info --->
															<table border="0" width="100%">
																<tr>
																	<td align="center"><img src="images/ios7tuto/6.jpg" width="211" height="374">
																</td>
																</tr>
																<tr>
																	<td align="center">Pronto! Agora é só abrir o app e aproveitá-lo! :D</td>
																</tr>
															</table>
															<!--- Info --->
														</td>
													</tr>
													<tr>
														<!-- - Encouragement to ask for help --->
														<td align="center">
														<h3>Não conseguiu? Fale comigo! Ajudar-te-ei! :D</h3>
													</td>
												</tr>
											</table>
											<?php
										break;
											//--- Shows the tutorial for Android ---//
										case 'android': ?>
											<table border="0" width="100%">
													<tr>
														<td align="center">
															<!--- Info --->
															<table border="0" width="100%">
																<tr>
																	<td align="center"><img src="images/androidtuto/1.png" width="211" height="352">
																	</td>
																</tr>
																<tr>
																	<td align="center">
																	Abra o navegador nativo do Android
																	</td>
																</tr>
															</table>
															<!--- Info --->
														</td>
													</tr>
													<tr>
														<td align="center">
															<!--- Info --->
															<table border="0" width="100%">
																<tr>
																	<td align="center"><img src="images/androidtuto/2.png" width="211" height="349">
																	</td>
																</tr>
																<tr>
																	<td align="center">Abra http://www.mk.camk.net/</td>
																</tr>
															</table>
															<!--- Info --->
														</td>
													</tr>
													<tr>
														<td align="center">
															<!--- Info --->
															<table border="0" width="100%">
																<tr>
																	<td align="center"><img src="images/androidtuto/3.png" width="211" height="352">
																	</td>
																</tr>
																<tr>
																	<td align="center">Aperte no botão &quot;favoritos&quot;</td>
																</tr>
															</table>
															<!--- Info --->
														</td>
													</tr>
													<tr>
														<td align="center">
															<!--- Info --->
															<table border="0" width="100%">
																<tr>
																	<td align="center"><img src="images/androidtuto/4.png" width="211" height="352">
																	</td>
																</tr>
																<tr>
																	<td align="center">Adicione o site aos seus favoritos</td>
																</tr>
															</table>
															<!--- Info --->
														</td>
													</tr>
													<tr>
														<td align="center">
															<!--- Info --->
															<table border="0" width="100%">
															<tr>
																<td align="center"><img src="images/androidtuto/5.png" width="211" height="352">
																</td>
															</tr>
															<tr>
																<td align="center">Adicione-o</td>
															</tr>
															</table>
															<!--- Info --->
														</td>
													</tr>
													<tr>
														<td align="center">
															<!--- Info --->
															<table border="0" width="100%">
															<tr>
																<td align="center"><img src="images/androidtuto/6.png" width="211" height="352">
																</td>
															</tr>
															<tr>
																<td align="center">Pressione &quot;ok&quot;</td>
															</tr>
															</table>
															<!--- Info --->
														</td>
													</tr>
													<tr>
														<td align="center">
															<!--- Info --->
															<table border="0" width="100%">
																<tr>
																	<td align="center"><img src="images/androidtuto/7.png" width="211" height="352">
																	</td>
																</tr>
																<tr>
																	<td align="center">Pressione e segure a página no seus favoritos</td>
																</tr>
															</table>
															<!--- Info --->
														</td>
													</tr>
													<tr>
														<td align="center">
															<!--- Info --->
															<table border="0" width="100%">
																<tr>
																	<td align="center"><img src="images/androidtuto/8.png" width="211" height="352">
																	</td>
																</tr>
																<tr>
																	<td align="center">Clique em &quot;Adicionar atalho ao início&quot;</td>
																</tr>
															</table>
															<!--- Info --->
														</td>
													</tr>
													<tr>
														<td align="center">
															<!--- Info --->
															<table border="0" width="100%">
																<tr>
																	<td align="center"><img src="images/androidtuto/9.png" width="211" height="352">
																	</td>
																</tr>
																<tr>
																	<td align="center">Agora é só abrir e aproveitar o app! :D</td>
																</tr>
															</table>
															<!--- Info --->
														</td>
													</tr>
													<tr>
														<td align="center">
															<h3>Não conseguiu? Fale comigo! Ajudar-te-ei! :D</h3>
														</td>
													</tr>
												</table>
										<?php
										break;
									}
									?>
								</td>
								<td width="5" rowspan="5">&nbsp;</td>
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
