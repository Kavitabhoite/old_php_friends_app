<?php
include('conectar.php');
include('rest.php');

//== Get user info ===//
$query_guy  = "SELECT * FROM user WHERE login_user = ?";
$stmt_guy   = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $logina_sess);
$stmt_guy->execute();
$rs_guy = $stmt_guy->get_result();
$infoguy= $rs_guy->fetch_array();
$stmt_guy->close();

$id_user   = $infoguy['id_user'];
$photo_user= $infoguy['photo_user'];
$apel_user = $infoguy['apel_user'];

//== Check for events not confirmed yet ==//
$query_eventcont  = "SELECT * FROM event WHERE datatot_event >= CURRENT_DATE()";
$stmt_eventcont   = $conexao->prepare($query_eventcont);
$stmt_eventcont->execute();
$rs_eventcont = $stmt_eventcont->get_result();
$eventscont   = $rs_eventcont->num_rows;
$stmt_eventcont->close();

//== Check for events confirmed by the user ==//
$query_confcont = "SELECT * FROM confirm_event WHERE useid_conf = ?";
$stmt_confcont  = $conexao->prepare($query_confcont);
$stmt_confcont->bind_param("i", $id_user);
$stmt_confcont->execute();
$rs_confcont  = $stmt_confcont->get_result();
$confcont     = $rs_confcont->num_rows;
$stmt_confcont->close();

//== Check whether there is an event that has not been confirmed yet ==//
$contafinal = $eventscont - $confcont;

//== Change the calendar icon if there are unconfirmed events ==//
if($contafinal <= 0){
  $calendimage = 'images/calend_but.png';
}else{
  $calendimage = 'images/calend_but_alert.png';
}
?>
<!DOCTYPE html> 
<html> 
<head> 
  <?php include('important_head.php'); ?>  
  <style type=text/css>
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
<body topmargin="0" leftmargin="0"> 
  <div data-role=page style="background:#71cb2e;" id=home>
    <table align="center" bgcolor="#38c03e" width="100%">
        <tr>
          <td width="24%" align="center">
            <a href="pri.php" data-transition="fade" data-prefetch><img src="images/logo_but_1.png" width="84" height="50"></a>
          </td>
          <td width="19%" align="center">
            <a href="events.php"><img src="<?=$calendimage;?>" width="40"></a>
          </td>
          <td width="19%" align="center">
            <a href="membs.php"><img src="images/memb_but.png" width="40"><br></a>
          </td>
          <td width="19%" align="center">
            <a href="perfs.php">
              <div align="center" class="circular_photo_user" style="-webkit-filter: drop-shadow(2px 2px 2px #222);filter:drop-shadow(2px 2px 2px #222);" ></div>
            </a>
          </td>
          <td width="19%" align="center">
            <a href="logout.php"><img src="images/off_but.png" width="40"></a>
          </td>
        </tr>
    </table> 

    <form id="FormUser" action="userform.php?a=edit" method="post" data-ajax="false">
      <!--- Start showing the user's infos ------------>
      <table cellpadding="0" cellspacing="5" bgcolor="#fff" width="100%">
        <tr>
          <td height="10px" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td width="17%" rowspan="3" align="center">
            <img src="photos/<?=$photo_user?>" style="
            width: 80px;
            height: 80px;
            border-radius: 40px;
            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            background: url(photos/<?=$photo_creator?>);
            background-size:contain;
            box-shadow: 0 0 8px rgba(0, 0, 0, .8);
            -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
            -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);">
          </td>
          <td>
            <a href="photochanger.php" style="text-decoration:none; color:#000;" data-ajax="false">
              Para alterar sua foto clique aqui!
            </a>
          </td>
        </tr>
        <tr>
          <td valign="top" width="58%">
            Apelido:<br>
            <input name="apel_new" style="max-width:80%" type="text" id="apel_new" placeholder="Apelido - Opcional" value="<?php if($apel_user != ""){ echo $apel_user; } ?>">
          </td>    
        </tr>
        <tr>
          <td valign="top" width="58%">
            Senha (se quiser alterá-la digite uma nova, senão, deixe em branco!)<br>
            <input name="senha_new" style="max-width:80%" type="password" id="senha_new" value="">
          </td>    
        </tr>    
      </table>
        
      <table border="0" bgcolor="#dcdcdc" width="100%">
        <tr>
          <td align="center">
            <table border="0" width="100%" style="max-width:300px" align="center">
              <tr>
                <td>
                  <div class="ui-grid-b" data-role="controlgroup" data-type="horizontal" >
                    <div class="ui-block-a" style="text-align:left;">
                      <input class="ui-block-a" style="background:#0C0;" data-icon="grid" data-ajax="false" type="submit" value="Salvar">
                    </div>          
                    <div class="ui-block-b" style="text-align:left;">
                      <a href="perfs.php" data-icon="back" data-role="button" data-ajax="false"> Voltar </a>
                    </div>   
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </form>
  </div>
</body>
</html>
