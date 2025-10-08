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

$id_user    = $infoguy['id_user'];
$photo_user = $infoguy['photo_user'];

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

//=== If no profile is specified, show own profile ===//
if(isset($_GET['i']) || !empty($_GET['i'])){
  // Look for specific profile  
  $id_perf = (int)$_GET['i'];
}else{
	// Show own profile
	$id_perf = (int)$id_user;
}

//== Get profile info ===//
$query_perf = "SELECT * FROM user WHERE id_user = ?";
$stmt_perf   = $conexao->prepare($query_perf);
$stmt_perf->bind_param("i", $id_perf);
$stmt_perf->execute();
$rs_perf = $stmt_perf->get_result();
$infoperf= $rs_perf->fetch_array();
$stmt_perf->close();
                          
$id_usera		  = $infoperf['id_user'];
$nome_usera		= $infoperf['nome_user'];
$apel_usera		= $infoperf['apel_user'];
$photo_usera	= $infoperf['photo_user'];

//== Counts all events ==//
$query_conteve  = "SELECT * FROM event";
$stmt_conteve   = $conexao->prepare($query_conteve);
$stmt_conteve->execute();
$rs_conteve     = $stmt_conteve->get_result();
$total_events   = $rs_conteve->num_rows;
$stmt_conteve->close();

//== Counts events created and confirmed by the user ==//
$query_evemy = "SELECT * FROM event WHERE creator_event = ?";
$stmt_evemy  = $conexao->prepare($query_evemy);
$stmt_evemy->bind_param("i", $id_usera);
$stmt_evemy->execute();
$rs_evemy    = $stmt_evemy->get_result();
$my_events   = $rs_evemy->num_rows;
$stmt_evemy->close();

//== Counts events confirmed by the user ==//
$query_confir = "SELECT * FROM confirm_event WHERE useid_conf = ? AND situation_conf = 1";
$stmt_confir  = $conexao->prepare($query_confir);
$stmt_confir->bind_param("i", $id_usera);
$stmt_confir->execute();
$rs_confir    = $stmt_confir->get_result();
$conf_events  = $rs_confir->num_rows;
$stmt_confir->close();

//== Calculate assiduity ==//
if($total_events != 0){
  $assid = $conf_events * 100 / $total_events;
}else{
	$assid = '0';
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
          <a href="membs.php"><img src="images/memb_but.png" style="<?php        
            if($id_perf != $id_user){
              echo 'style="-webkit-filter: drop-shadow(2px 2px 2px #222);filter:drop-shadow(2px 2px 2px #222);"'; 
            }	  
            ?>" width="40"><br></a>
        </td>
        <td width="19%" align="center">
          <a href="perfs.php"><div align="center" class="circular_photo_user"
            <?php
              if($id_perf == $id_user || $id_perf == ''){
                  echo 'style="-webkit-filter: drop-shadow(2px 2px 2px #222);filter:drop-shadow(2px 2px 2px #222);"';
              }	  
              ?>></div>
        </td>
        <td width="19%" align="center">
          <a href="logout.php"><img src="images/off_but.png" width="40"></a>
        </td>
      </tr>
    </table>  
  
    <!--- Start showing profile's info ------------>
    <table cellpadding="0" cellspacing="5" bgcolor="#fff" width="100%">
      <tr>
        <td height="10px">&nbsp;</td>
      </tr>
      <tr>
        <td width="13%" align="center">
          <a href="seephoto.php?p=<?=$photo_usera?>" data-transition=fade>
            <img src="photos/<?=$photo_usera?>" style="width: 80px;
            height: 80px;
            border-radius: 40px;
            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            background: url(photos/<?=$photo_creator?>);
            background-size:contain;
            box-shadow: 0 0 8px rgba(0, 0, 0, .8);
            -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
            -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);">
          </a>
        </td>
        <td valign="top" width="87%">
          <h2><?=$nome_usera;?></h2>
          <h3><?php if($apel_usera != ""){ echo '*' . $apel_usera . '*'; } ?></h3>
        </td>      
      </tr>
      <tr>
        <td colspan="2">
          <?php
            if($id_user == $id_perf){
          ?>
            <table border="0" width="50px">
              <tr>
                <td><a href="editperf.php" data-role="button" data-icon="gear" data-ajax="false">Editar perfil</a></td>
              </tr>
            </table>
          <?php 
            }
          ?>
        </td>
      </tr>
    </table>
    <!--- End showing profile's info ------------>
    <!---- Statistics ------------------------>
    <table bgcolor="#FFFFFF" border="0" width="100%">
      <tr>
        <!--- Created events --->
        <td width="33%">          
          <table border="0" width="100%">
            <tr>
              <td align="center">
                <strong>Eventos Criados:</strong>
              </td>
            </tr>
            <tr>
              <td align="center">
                <strong><?=$my_events?></strong>
              </td>
            </tr>
          </table>          
        </td>
        <!--- Created events ends --->
        <td width="1%">
          <hr style="width: 1px; height: 50px;">
        </td>
        <!--- Confirmed events --->
        <td width="33%">
          <table border="0" width="100%">
            <tr>
              <td align="center">
                <strong>Eventos Participados:</strong>
              </td>
            </tr>
            <tr>
              <td align="center">
                <strong><?=$conf_events?></strong>
              </td>
            </tr>
          </table>
        </td>   
        <!--- Confirmed events ends --->     
        <td width="1%">
          <hr style="width: 1px; height: 50px;">
        </td>
        <!--- Assiduity --->
        <td width="33%">
          <table border="0" width="100%">
            <tr>
              <td align="center">
                <strong>Assiduidade:</strong>
              </td>
            </tr>
            <tr>
              <td align="center">
                <strong><?=round($assid,2);?>%</strong>
              </td>
            </tr>
          </table>
        </td>
        <!--- Assiduity ends --->
      </tr>
    </table>
    <!---- Statistics ends ------------------------>
    <!---- Last event created by the user ------------------------>
    <table bgcolor="#ededed" border="0" width="100%">
      <tr>
        <td>
          <h2>Último evento criado:</h2>
        </td>
      </tr>
    </table>
    <?php
      //== Get last event created by the user ===//
      $q_list1 = "SELECT * FROM event WHERE creator_event = ? ORDER BY id_event DESC LIMIT 1";
      $stmt_list1 = $conexao->prepare($q_list1);
      $stmt_list1->bind_param("i", $id_usera);
      $stmt_list1->execute();
      $rs_list1 = $stmt_list1->get_result();
      $conteventsprox = $rs_list1->num_rows;
      $stmt_list1->close();
    
      if($conteventsprox == 0){
      // If user has never created any event
        ?>
            <table cellpadding="0" cellspacing="5" bgcolor="#ededed" width="100%">
              <tr>
                <td align="center">
                  <p align="center">Este usuário nunca criou nenhum evento! :/</p>
                </td>
              </tr>
            </table>
      <?php
      }else{
      // Show last event created by the user
      
        while($list1 = $rs_list1->fetch_array()){
                                    
          $id_event		  = $list1['id_event']; // Event ID
          $titulo_event	= $list1['titulo_event']; // Event Title
          $dia_event		= $list1['dia_event']; // Event Day
          $mes_event		= $list1['mes_event']; // Event Month
          $ano_event		= $list1['ano_event']; // Event Year
          $hora_event		= $list1['hora_event']; // Event Hour
          $place_event	= $list1['place_event']; // Event Place
          $desc_event		= $list1['desc_event']; // Event Description
          $creator_event= $list1['creator_event']; // Event Creator
          $exist_event	= $list1['exist_event']; // Is it active (1 = Yes, 0 = No)
          $datatot_event= $list1['datatot_event']; // Event Full Date

          //== Get event creator info ===//
          $q_list2 = "SELECT * FROM user WHERE id_user = ?";
          $stmt_list2 = $conexao->prepare($q_list2);
          $stmt_list2->bind_param("i", $creator_event);
          $stmt_list2->execute();
          $rs_list2 = $stmt_list2->get_result();
          $list2 = $rs_list2->fetch_array();
          $stmt_list2->close();
                                    
          $photo_creator		= $list2['photo_user'];
        ?>
          <a href="eventshow.php?i=<?=$id_event;?>" style="text-decoration:none; color:#000;">            
            <table cellpadding="0" cellspacing="5" bgcolor="#ededed" width="100%">
              <tr>
                <!--- DATA EVENT --->
                <td width="15%" rowspan="4" align="center">
                  <table border="0" height="79" style="background:url(images/calend_lone.png); background-size:cover; max-height:80px;" width="72px" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="18" align="center" valign="top"><font face="Verdana, Geneva, sans-serif" color="#FFFFFF" size="-4"><?=$ano_event?></font></td>
                    </tr>
                    <tr>
                      <td height="19" align="center"><font face="Verdana, Geneva, sans-serif" color="#FFFFFF"><?=$dia_event?></font></td>
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
                </td> 
                <!--- FIM DATA --->
                <td width="65%">
                  <?php if($exist_event == 1){ echo '<font color="#FF0000">'; } ?><?=$titulo_event?>
                  <?php if($exist_event == 1){ echo '[ANULADO]'; } ?>
                </td>
              </tr>
              <tr>
                <!--- HOUR --->
                <td>                
                  <table border="0" width="100%" cellspacing="0">
                    <tr>
                      <td width="9%">
                        <img src="images/hour_icon.png">
                      </td>
                      <td width="91%">
                        <?=$hora_event?>
                      </td>
                    </tr>
                  </table>          
                </td>
                <!--- HOUR ENDS --->
              </tr>
              <tr>
                <!--- PLACE --->
                <td>                
                  <table border="0" width="100%" cellspacing="0">
                    <tr>
                      <td width="9%">
                        <img src="images/place_icon.png">
                      </td>
                      <td width="91%">
                        <?=$place_event?>
                      </td>
                    </tr>
                  </table>
                </td>
                <!--- PLACE ENDS --->
              </tr>
              <tr>
                <td>
                  <?php
                    if(strlen($desc_event) > 50) { 
                      $showDescription = "&quot;". substr($desc_event,0,50) . "...&quot;"; 
                    }else{ 
                      $showDescription = "&quot;". $desc_event . "&quot;"; 
                    } 
                    echo $showDescription; 
                  ?>
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