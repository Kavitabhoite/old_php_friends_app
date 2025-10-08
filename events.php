<?php
include('conectar.php');
include('rest.php');

//== Get user info ===//
$query_guy  = "SELECT * FROM user WHERE login_user = ?";
$stmt_guy   = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $logina_sess);
$stmt_guy->execute();
$rs_guy     = $stmt_guy->get_result();
$infoguy    = $rs_guy->fetch_array();
$stmt_guy->close();

$id_user    = $infoguy['id_user'];
$photo_user = $infoguy['photo_user'];

//== Check for events not confirmed yet ==//
$query_eventcont  = "SELECT * FROM event WHERE exist_event = 0 AND datatot_event >= CURRENT_DATE()";
$stmt_eventcont   = $conexao->prepare($query_eventcont);
$stmt_eventcont->execute();
$rs_eventcont     = $stmt_eventcont->get_result();
$eventscont       = $rs_eventcont->num_rows;
$stmt_eventcont->close();

//== Check for events confirmed by the user ==//
$query_confcont = "SELECT * FROM confirm_event WHERE useid_conf = ?";
$stmt_confcont  = $conexao->prepare($query_confcont);
$stmt_confcont->bind_param("i", $id_user);
$stmt_confcont->execute();
$rs_confcont    = $stmt_confcont->get_result();
$confcont       = $rs_confcont->num_rows;
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
  <div data-role="page" style="background:#71cb2e;" id="home">
    <table align="center" bgcolor="#38c03e" width="100%">
      <tr>
        <td width="24%" align="center">
          <a href="pri.php" data-transition="fade" data-prefetch><img src="images/logo_but_1.png" width="84" height="50"></a>
        </td>
        <td width="19%" align="center">
          <a href="#"><img src="<?=$calendimage;?>" width="40" style="-webkit-filter: drop-shadow(2px 2px 2px #222); filter:drop-shadow(2px 2px 2px #222);" ></a>
        </td>
        <td width="19%" align="center">
          <a href="membs.php"><img src="images/memb_but.png" width="40"><br></a>
        </td>
        <td width="19%" align="center">
          <a href="perfs.php">
            <div align="center" class="circular_photo_user"></div>        
          </a>
        </td>
        <td width="19%" align="center">
          <a href="logout.php"><img src="images/off_but.png" width="40"></a>
        </td>
      </tr>
    </table>  
    <table cellpadding="0" bgcolor="#fff" cellspacing="0" width="100%">
      <tr>
        <td>&nbsp;</td>
        <td>
          <h3>Eventos Programados</h3>
        </td>
        <td align="right">
          <a href="createevent.php" data-role="button" data-icon="plus" data-iconpos="notext"></a>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <!--- Start showing events ------------>
    <?php
      //== List of upcoming events ===//
      $q_list1    = "SELECT * FROM event WHERE datatot_event >= CURRENT_DATE() ORDER BY datatot_event ASC";
      $stmt_list1 = $conexao->prepare($q_list1);
      $stmt_list1->execute();
      $rs_list1   = $stmt_list1->get_result();
      $conteventsprox = $rs_list1->num_rows;
      
      if($conteventsprox == 0){
      ?>
        <table cellpadding="0" cellspacing="5" bgcolor="#ededed" width="100%">
          <tr>
            <td align="center">
              <p align="center">Não há nenhum evento programado! :(</p>
            </td>
          </tr>
        </table>
      <?php
      }else{    
        while($list1 = $rs_list1->fetch_array()){
          
        $id_event     = $list1['id_event'];
        $titulo_event = $list1['titulo_event'];
        $dia_event    = $list1['dia_event'];
        $mes_event    = $list1['mes_event'];
        $ano_event    = $list1['ano_event'];
        $hora_event   = $list1['hora_event'];
        $place_event  = $list1['place_event'];
        $desc_event   = $list1['desc_event'];
        $creator_event= $list1['creator_event'];
        $exist_event  = $list1['exist_event'];
        
        //== Get event creator photo ===//
        $q_list2    = "SELECT * FROM user WHERE id_user = ?";
        $stmt_list2 = $conexao->prepare($q_list2);
        $stmt_list2->bind_param("i", $creator_event);
        $stmt_list2->execute();
        $rs_list2   = $stmt_list2->get_result();
        $list2      = $rs_list2->fetch_array();
        $stmt_list2->close();          
        $photo_creator= $list2['photo_user'];
      ?>
        <a href="eventshow.php?i=<?=$id_event;?>" style="text-decoration:none; color:#000;">    
          <table cellpadding="0" cellspacing="5" bgcolor="#ededed" width="100%">
            <tr>
              <td width="15%" rowspan="4" align="center">
                <!--- Event's date --->
                <table border="0" height="79" style="background:url(images/calend_lone.png); background-size:cover; max-height:80px;" width="72px" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="18" align="center" valign="top">
                      <font face="Verdana, Geneva, sans-serif" color="#FFFFFF" size="-4"><?=$ano_event?></font>
                    </td>
                  </tr>
                  <tr>
                    <td height="19" align="center">
                      <font face="Verdana, Geneva, sans-serif" color="#FFFFFF"><?=$dia_event?></font>
                    </td>
                  </tr>
                  <tr>
                    <td height="42" align="center">
                      <font face="Verdana, Geneva, sans-serif" color="#FFFFFF">
                        <?php
                          switch($mes_event){
                              case 1:
                                echo "JAN";
                              break;
                              case 2:
                                echo "FEV";
                              break;
                              case 3:
                                echo "MAR";
                              break;
                              case 4:
                                echo "ABR";
                              break;
                              case 5:
                                echo "MAIO";
                              break;
                              case 6:
                                echo "JUN";
                              break;
                              case 7:
                                echo "JUL";
                              break;
                              case 8:
                                echo "AGO";
                              break;
                              case 9:
                                echo "SET";
                              break;
                              case 10:
                                echo "OUT";
                              break;
                              case 11:
                                echo "NOV";
                              break;
                              case 12:
                                echo "DEZ";
                              break;
                          }
                        ?>
                      </font>
                    </td>
                  </tr>
                </table>
                <!--- FIM DATA --->
              </td>
              <td width="65%">
                <?php if($exist_event == 1){ ?><font color="#FF0000"><?php } ?>
                <?=$titulo_event;?>
                <?php if($exist_event == 1){ ?> [ANULADO]</font><?php } ?>
              </td>
              <td width="20%" align="center" rowspan="4">
                <img src="photos/<?=$photo_creator;?>" style="
                width: 60px;
                height: 60px;
                border-radius: 40px;
                -webkit-border-radius: 50px;
                -moz-border-radius: 50px;
                background: url(photos/<?=$photo_creator;?>);
                background-size:contain;
                box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);">
              </td>
            </tr>
            <tr>
              <td>
              <!--- HOUR --->
              <table border="0" width="100%" cellspacing="0">
                <tr>
                  <td width="9%">
                    <img src="images/hour_icon.png">
                  </td>
                  <td width="91%">
                    <?=$hora_event;?>
                  </td>
                </tr>
              </table>
              <!--- HOUR ENDS --->
              </td>
            </tr>
            <tr>
              <td>
              <!--- PLACE --->
                <table border="0" width="100%" cellspacing="0">
                  <tr>
                    <td width="9%">
                      <img src="images/place_icon.png">
                    </td>
                    <td width="91%">
                      <?=$place_event;?>
                    </td>
                  </tr>
                </table>
              <!--- PLACE ENDS --->
              </td>
            </tr>
            <tr>
              <td>
                <?php
                  //== Show only the first 50 characters of the description ===//
                  if(strlen($desc_event) > 50) { 
                    $showDescription = "&quot;". substr($desc_event,0,50) . "...&quot;"; 
                  } else { 
                    $showDescription = "&quot;". $desc_event . "&quot;"; 
                  } 
                  echo $showDescription; 
                ?>
              </td>
            </tr>
            <tr>
              <td colspan="3">
                <hr width="100%">
              </td>
            </tr>
          </table>
        </a>  
    <?php
      } 
    }
    ?>  
  </div>
</body>
</html>