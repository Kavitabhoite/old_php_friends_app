<?php
include('conectar.php');
include('rest.php');

//== Get user info ===//
$query_guy= "SELECT * FROM user WHERE login_user = ?";
$stmt_guy = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $logina_sess);
$stmt_guy->execute();
$rs_guy = $stmt_guy->get_result();
$infoguy= $rs_guy->fetch_array();
$stmt_guy->close();

$id_user= $infoguy['id_user'];
$photo_user = $infoguy['photo_user'];

//== Check for events not confirmed yet ==//
$query_eventcont= "SELECT * FROM event WHERE exist_event = 0 AND datatot_event >= CURRENT_DATE()";
$stmt_eventcont = $conexao->prepare($query_eventcont);
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

//== EVENT DATA

$id_event= $_GET['i'];

// Redirect if no event is specified
if(!isset($id_event) || empty($id_event)){
  header("Location: pri.php");
  exit;
}

//== Get event info ===//
$query_event  = "SELECT * FROM event WHERE id_event = ?";
$stmt_event   = $conexao->prepare($query_event);
$stmt_event->bind_param("i", $id_event);
$stmt_event->execute();
$rs_event   = $stmt_event->get_result();
$infoevent  = $rs_event->fetch_array();
$stmt_event->close();

$titulo_event = $infoevent['titulo_event']; // Event title
$dia_event    = $infoevent['dia_event']; // Event day
$mes_event    = $infoevent['mes_event']; // Event month
$ano_event    = $infoevent['ano_event']; // Event year
$hora_event   = $infoevent['hora_event']; // Event hour
$place_event  = $infoevent['place_event']; // Event place
$desc_event   = $infoevent['desc_event']; // Event description
$creator_event= $infoevent['creator_event']; // Event creator user ID
$exist_event  = $infoevent['exist_event']; // Event existence (0 = exists, 1 = canceled)
$datatot_event= new DateTime ($infoevent['datatot_event']); // Event full date (YYYY-MM-DD)
$current_date = new DateTime (date('Y-m-d')); // Current date (YYYY-MM-DD)

//== Get event creator info ===//
$q_list2    = "SELECT * FROM user WHERE id_user = ?";
$stmt_list2 = $conexao->prepare($q_list2);
$stmt_list2->bind_param("i", $creator_event); 
$stmt_list2->execute();
$rs_list2   = $stmt_list2->get_result();  
$list2      = $rs_list2->fetch_array();
$stmt_list2->close();

$photo_creator  = $list2['photo_user'];

//== Get user's situation regarding this event ===//
$q_list9    = "SELECT * FROM confirm_event WHERE eveid_conf = ? AND useid_conf = ?";
$stmt_list9 = $conexao->prepare($q_list9);
$stmt_list9->bind_param("ii", $id_event, $id_user);
$stmt_list9->execute();
$rs_list9   = $stmt_list9->get_result();
$list9      = $rs_list9->fetch_array();
$stmt_list9->close(); 
 
$mysitu = $list9['situation_conf']; // User's situation regarding this event (1 = going, 2 = not sure, 3 = not going)
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
          <a href="events.php"><img src="<?=$calendimage;?>" width="40" style="-webkit-filter: drop-shadow(2px 2px 2px #222);filter:drop-shadow(2px 2px 2px #222);" ></a>
        </td>
        <td width="19%" align="center">
          <a href="membs.php"><img src="images/memb_but.png" width="40"><br></a>
        </td>
        <td width="19%" align="center">
          <a href="perfs.php"><div align="center" class="circular_photo_user"></div></a>
        </td>
        <td width="19%" align="center">
          <a href="logout.php"><img src="images/off_but.png" width="40"></a>
        </td>
      </tr>
    </table>  
    <!--- Start showing event's infos ------------>
    <table cellpadding="0" cellspacing="5" bgcolor="#fff" width="100%">
      <tr>
        <td colspan="3">
          <table cellpadding="0" cellspacing="5" bgcolor="#fff" width="100%">
          <tr>
            <td colspan="3">
              <h2 <?php if($exist_event == 1){ echo 'style="color:#F00;"'; } ?>><?=$titulo_event;?><?php if($exist_event == 1){ echo ' [! ANULADO !]'; } ?></h2>
              <?php
                if($id_user == $creator_event){
              ?>
                <table border="0" width="50px">
                  <tr>
                    <td>
                      <a href="editevent.php?i=<?=$id_event;?>" data-role="button" data-icon="gear">Editar evento</a>
                    </td>
                  </tr>
                </table>
              <?php 
                }
              ?>
            </td>
          </tr>
          <tr>
            <td valign="top" width="15%" rowspan="3" align="center">
              <!--- DATA EVENT --->
                <table border="0" height="79" style="background:url(images/calend_lone.png); background-size:cover; max-height:80px;" width="72px" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="18" align="center" valign="top">
                      <font face="Verdana, Geneva, sans-serif" color="#FFFFFF" size="-4">
                        <?=$ano_event?>
                      </font>
                    </td>
                  </tr>
                  <tr>
                    <td height="19" align="center">
                      <font face="Verdana, Geneva, sans-serif" color="#FFFFFF">
                        <?=$dia_event?>
                      </font>
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
              <!--- HOUR --->
                <table border="0" width="100%" cellspacing="0">
                  <tr>
                    <td width="7%"><img src="images/hour_icon.png"></td>
                    <td width="93%"><?=$hora_event?></td>
                  </tr>
                </table>
              <!--- HOUR ENDS --->
              </td>
              <td valign="top" width="20%" align="center" rowspan="3">
                <img src="photos/<?=$photo_creator?>" style="width: 60px;
                    height: 60px;
                    border-radius: 40px;
                    -webkit-border-radius: 50px;
                    -moz-border-radius: 50px;
                    background: url(photos/<?=$photo_creator?>);
                    background-size:contain;
                    box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                    -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                    -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);">
              </td>
            </tr>
            <tr>
              <td>
              <!--- PLACE --->
                <table border="0" width="100%" cellspacing="0">
                  <tr>
                    <td width="7%"><img src="images/place_icon.png"></td>
                    <td width="93%"><?=$place_event?></td>
                  </tr>
                </table>
              <!--- PLACE ENDS --->
              </td>
            </tr>
            <tr>
              <td>"<?=$desc_event?>"</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <?php
      if($exist_event != 1){
    ?>
    <!--- Show people who confirmed -------------------->
    <table width="100%" cellspacing="6" bgcolor="#fff">
      <tr>
        <td width="98%"><h3>Confirmados:</h3></td>
      </tr>
      <tr>
        <td>
          <?php
            //== Get confirmed users info ===//
            $q_list3 = "SELECT * FROM confirm_event WHERE eveid_conf = ? AND situation_conf = 1";
            $stmt_list3 = $conexao->prepare($q_list3);
            $stmt_list3->bind_param("i", $id_event);
            $stmt_list3->execute();
            $rs_list3 = $stmt_list3->get_result();
            $nconfirm = $rs_list3->num_rows;
            
            //== If no one confirmed yet ==//
            if($nconfirm == 0){
          ?>
            Ninguém ainda confirmou a ida a este evento! :(
          <?php
            }else{            
              while($list3 = $rs_list3->fetch_array()){
          
                $useid_conf= $list3['useid_conf'];

                //== Get confirmed user info ===//
                $q_list4    = "SELECT * FROM user WHERE id_user = ?";
                $stmt_list4 = $conexao->prepare($q_list4);
                $stmt_list4->bind_param("i", $useid_conf);
                $stmt_list4->execute();
                $rs_list4 = $stmt_list4->get_result();
                $list4    = $rs_list4->fetch_array();
                $stmt_list4->close();

                $id_confirm   = $list4['id_user']; // Confirmed user ID
                $photo_confirm= $list4['photo_user']; // Confirmed user photo
                $nome_confirm = $list4['nome_user']; // Confirmed user name
          ?>
            <a href="perfs.php?i=<?=$id_confirm?>">
              <img title="<?=$nome_confirm?>" src="photos/<?=$photo_confirm?>" style="
                width: 50px;
                height: 50px;
                border-radius: 40px;
                -webkit-border-radius: 50px;
                -moz-border-radius: 50px;
                background: url(photos/<?=$photo_confirm?>);
                background-size:contain;
                box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);"></a>            
          <?php
              } 
            }
          ?>
        </td>
      </tr>
    </table> 
    <!--- Ends showing people who confirmed ------------------------->
    <?php
      }
    ?>
    <!--- Show people who're not sure yet -------------------->
    <?php
      //=== Look for people who are not sure (2) ===//
      $q_list5 = "SELECT * FROM confirm_event WHERE eveid_conf = ? AND situation_conf = 2";
      $stmt_list5 = $conexao->prepare($q_list5);
      $stmt_list5->bind_param("i", $id_event);
      $stmt_list5->execute();
      $rs_list5   = $stmt_list5->get_result();
      $nconfirm2  = $rs_list5->num_rows;
      
      if($nconfirm2 != 0){
    ?>
      <table width="100%" cellspacing="6" bgcolor="#fff">
        <tr>
          <td width="98%"><h3>Não sabe se vai:</h3></td>
        </tr>
        <tr>
          <td>
            <?php
              while($list5  = $rs_list5->fetch_array()){
              
              $useid_conf2  = $list5['useid_conf'];

              //=== Get information from user who's not sure yet ===/
              $q_list6 = "SELECT * FROM user WHERE id_user = ?";
              $stmt_list6 = $conexao->prepare($q_list6);
              $stmt_list6->bind_param("i", $useid_conf2);
              $stmt_list6->execute();
              $rs_list6   = $stmt_list6->get_result();
              $nconfirm2  = $rs_list6->num_rows;
              $list6      = $rs_list6->fetch_array();
              
              $photo_confirm2 = $list6['photo_user'];
              $id_confirm2    = $list6['id_user'];
              $nome_confirm2  = $list6['nome_user'];
            ?>
              <a href="perfs.php?i=<?=$id_confirm2?>">
                <img title="<?=$nome_confirm2?>" src="photos/<?=$photo_confirm2?>" style="
                width: 50px;
                height: 50px;
                border-radius: 40px;
                -webkit-border-radius: 50px;
                -moz-border-radius: 50px;
                background: url(photos/<?=$photo_confirm2?>);
                background-size:contain;
                box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);">
                </a>              
            <?php
              }
            ?>
          </td>
        </tr>
      </table> 
    <?php 
      }
    ?>
    <!--- Ends showing people who're not sure yet -------------------->
    <!--- Shows people who are not coming -------------------->
    <?php
      //=== Look for people who are not coming ===//
      $q_list7 = "SELECT * FROM confirm_event WHERE eveid_conf = ? AND situation_conf = 3";
      $stmt_list7 = $conexao->prepare($q_list7);
      $stmt_list7->bind_param("i", $id_event);
      $stmt_list7->execute();
      $rs_list7   = $stmt_list7->get_result();
      $nconfirm3  = $rs_list7->num_rows;
    
      if($nconfirm3 != 0){
      ?>
        <table width="100%" cellspacing="6" bgcolor="#fff">
          <tr>
            <td width="98%">
              <h3>Não vai:</h3>
            </td>
          </tr>
          <tr>
            <td>
              <?php
                while($list7    = $rs_list7->fetch_array()){
                
                  $useid_conf3  = $list7['useid_conf'];

                  //=== Get info of not coming user ===//
                  $q_list8 = "SELECT * FROM user WHERE id_user = ?";
                  $stmt_list8 = $conexao->prepare($q_list8);
                  $stmt_list8->bind_param("i", $useid_conf3);
                  $stmt_list8->execute();
                  $rs_list8   = $stmt_list8->get_result();
                  $nconfirm3  = $rs_list8->num_rows;
                  $list8      = $rs_list8->fetch_array();
                  $stmt_list8->close();
                  
                  $photo_confirm3 = $list8['photo_user'];
                  $id_confirm3    = $list8['id_user'];
                  $nome_confirm3  = $list8['nome_user'];
                  ?>
                  <a href="perfs.php?i=<?=$id_confirm3;?>">
                    <img title="<?=$nome_confirm3;?>" src="photos/<?=$photo_confirm3;?>" style="
                    width: 50px;
                    height: 50px;
                    border-radius: 40px;
                    -webkit-border-radius: 50px;
                    -moz-border-radius: 50px;
                    background: url(photos/<?=$photo_confirm3?>);
                    background-size:contain;
                    box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                    -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                    -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);">
                    </a>              
              <?php
                }
              ?>
            </td>
          </tr>
        </table> 
      <?php } ?>
    <!--- NOT COMING ENDS ------------------------->
    <!--- CHOOSE ------------------------------->
    <table bgcolor="#dcdcdc" width="100%">
      <tr>
        <td>
          <?php 
            if($exist_event == 1){
          ?>
          <p align="center">Este evento foi cancelado por seu criador! :'(</p>
          <?php
            }elseif($datatot_event < $current_date){
          ?>
          <p align="center">Este evento já passou!</p>
          <?php
            }else{
          ?>
            <table align="center" border="0">
              <tr>
                <td>
                  <!---- Options to choose ---->
                  <div class="ui-grid-b" data-role="controlgroup" data-type="horizontal" >
                    <div class="ui-block-a" style="text-align:right">
                      <a href="chang_situ.php?ie=<?=$id_event?>&iu=<?=$id_user;?>&ns=1"
                        <?php if($mysitu == 1){ echo 'style="background:#0C0;"'; } ?>
                        data-icon="check" data-role="button" data-ajax="false"> Eu vou!</a>
                    </div>
                    <div class="ui-block-b">
                      <a href="chang_situ.php?ie=<?=$id_event?>&iu=<?=$id_user?>&ns=2"
                      <?php if($mysitu == 2){ echo 'style="background:#FC0;"'; } ?>
                      data-icon="minus" data-role="button" data-ajax="false"> Não sei </a>
                    </div>
                    <div class="ui-block-c" style="text-align:left;">
                      <a href="chang_situ.php?ie=<?=$id_event?>&iu=<?=$id_user?>&ns=3"
                      <?php if($mysitu == 3){ echo 'style="background:#F00;"'; } ?>
                      data-icon="delete" data-role="button" data-ajax="false"> Não vou </a>
                    </div>
                  </div>
                  <!---- Options to choose ENDS ---->
                </td>
              </tr>
            </table>
          <?php
            }
          ?>
        </td>
      </tr>
    </table>
    <!-- CHOOSE ENDS ----------->
    <!--- COMMENT ------------->
    <form action="post_publication.php?a=pub" method="post" data-ajax="false">
        <table bgcolor="#e9e9e9" width="100%" border="0">
          <tr>
            <td width="1%">&nbsp;</td>
            <td colspan="2">
              <textarea name="text_pub" id="text_pub" width="100%"></textarea>
            </td>
            <td width="3%">&nbsp;</td>
          </tr>
          <tr>
            <td width="1%">&nbsp;</td>
            <td width="85%">
              <input name="iu" type="hidden" id="iu" value="<?=$id_user?>">
              <input name="ie" type="hidden" id="ie" value="<?=$id_event?>">
            </td>
            <td width="11%" align="right">
              <input name="Envoyer" type="submit" value="Postar" align="right" width="50px">
            </td>
            <td width="3%">&nbsp;</td>
          </tr>
        </table>
    </form>
    <!--- COMMENT ENDS ----------------->
    <!--- SHOW COMMENTS -------->
    <table bgcolor="#d8d8d8" cellspacing="5" border="0" width="100%">
      <?php
      //== Get comments info ===//
      $q_list10     = "SELECT * FROM publication_event WHERE ideve_pub = ?";
      $stmt_list10  = $conexao->prepare($q_list10);
      $stmt_list10->bind_param("i", $id_event);
      $stmt_list10->execute();
      $rs_list10    = $stmt_list10->get_result();
      $nconfirmpub  = $rs_list10->num_rows;
      $stmt_list10->close();
      
      if($nconfirmpub == 0){
      ?>
        <tr>
          <td colspan="4" align="center">
            Não há nenhuma publicação neste evento!
          </td>
        </tr>
      <?php
      }else{
        while($list10 = $rs_list10->fetch_array()){
        
        $id_pub   = $list10['id_pub']; // Publication ID
        $ideve_pub= $list10['ideve_pub']; // Event ID
        $iduse_pub= $list10['iduse_pub']; // User ID who posted
        $text_pub = $list10['text_pub']; // Publication text

        //== Get info of user who posted ===//
        $q_list11 = "SELECT * FROM user WHERE id_user = ?";
        $stmt_list11 = $conexao->prepare($q_list11);
        $stmt_list11->bind_param("i", $iduse_pub);
        $stmt_list11->execute();
        $rs_list11   = $stmt_list11->get_result();
        $list11      = $rs_list11->fetch_array(); 
        $stmt_list11->close();
        
        $photo_pub= $list11['photo_user'];
        ?>
        <tr>
          <td width="16%">
            <!--- User photo who posted ---->
            <table border="0">
              <tr>
                <td>
                  <a href="perfs.php?i=<?=$iduse_pub;?>"><img src="photos/<?=$photo_pub;?>" alt="" style="
                  width: 50px;
                  height: 50px;
                  border-radius: 40px;
                  -webkit-border-radius: 50px;
                  -moz-border-radius: 50px;
                  background: url(photos/<?=$photo_pub;?>);
                  background-size:contain;
                  box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                  -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                  -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);"></a>
                </td>
                <td>
                  <font size="+6">:</font>
                </td>
              </tr>
            </table>
            <!--- User photo who posted ENDS ---->
          </td>
          <td colspan="2" align="left">
            <?=$text_pub;?>
          </td>
          <?php if($iduse_pub == $id_user){ ?>
            <td>
            <!---- Delete publication ---->
              <table style="vertical-align:bottom" border="0">
                <tr>
                  <td>(</td>
                  <td>
                    <form data-ajax="false" method="post" action="delet_pub.php?a=pub">
                      <input name="pi" type="hidden" id="pi" value="<?=$id_pub?>">
                      <input name="ie" type="hidden" id="ie" value="<?=$id_event?>">
                      <input name="ui" type="hidden" id="ui" value="<?=$iduse_pub?>">
                      <button type="submit" data-icon=delete data-iconpos=notext></button>
                    </form>
                  </td>
                  <td>)</td>
                </tr>
              </table>
              <!---- Delete publication ENDS ---->            
          </td>
          <?php
                }
            ?>
        </tr>
    <?php
      $q_list12     = "SELECT * FROM comment_event WHERE idpub_comment = ?";
      $stmt_list12  = $conexao->prepare($q_list12);
      $stmt_list12->bind_param("i", $id_pub);
      $stmt_list12->execute();
      $rs_list12    = $stmt_list12->get_result();
      $nconfirmcom  = $rs_list12->num_rows;
      
      if($nconfirmcom != 0){
        while($list12 = $rs_list12->fetch_array()){
      
          $id_comment   = $list12['id_comment']; // Comment ID
          $ideve_comment= $list12['ideve_comment']; // Event ID
          $iduse_comment= $list12['iduse_comment']; // User ID who commented
          $idpub_comment= $list12['idpub_comment']; // Publication ID
          $text_comment = $list12['text_comment']; // Comment text

          //== Get info of user who commented ===//
          $q_list13 = "SELECT * FROM user WHERE id_user = ?";
          $stmt_list13 = $conexao->prepare($q_list13);
          $stmt_list13->bind_param("i", $iduse_comment);
          $stmt_list13->execute();
          $rs_list13   = $stmt_list13->get_result();
          $list13      = $rs_list13->fetch_array(); 
          $stmt_list13->close();
          
          $photo_com= $list13['photo_user'];
      ?>
          <tr>
            <td>&nbsp;</td>
            <!---- User photo who commented ---->
            <td width="16%">
              <table border="0">
                <tr>
                  <td>
                    <a href="perfs.php?i=<?=$iduse_comment;?>"><img src="photos/<?=$photo_com;?>" alt="" style="
                    width: 50px;
                    height: 50px;
                    border-radius: 40px;
                    -webkit-border-radius: 50px;
                    -moz-border-radius: 50px;
                    background: url(photos/<?=$photo_com?>);
                    background-size:contain;
                    box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                    -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                    -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);"></a>
                  </td>
                  <td>
                    <font size="+6">:</font>
                  </td>
                </tr>
              </table>
            </td>
            <!---- User photo who commented ENDS ---->
            <!---- Comment text ---->
            <td colspan="2" align="left">
              <?=$text_comment;?>
            </td>
            <?php
              //==== Option to delete comment if it's the user's own comment ===//
              if($iduse_comment == $id_user){ ?>
            <td>
                <table style="vertical-align:bottom" border="0">
                  <tr>
                    <td>(</td>
                    <td>
                      <form data-ajax="false" method="post" action="delet_pub.php?a=comment">
                        <input name="ci" type="hidden" id="pi" value="<?=$id_comment?>">
                        <input name="ui" type="hidden" id="ui" value="<?=$iduse_comment?>">
                        <input name="ie" type="hidden" id="ie" value="<?=$id_event?>">
                        <button type="submit" data-icon=delete data-iconpos=notext></button>
                      </form>
                    </td>
                    <td>)</td>
                  </tr>
                </table>
            </td>
              <?php
                }
              //==== Option to delete comment ENDS ===//
              ?>
            <!---- Comment text ENDS ---->
          </tr>
      <?php
        } 
      }
      ?>
        <!--- COMMENT FORM -------->
        <tr>
          <td>&nbsp;</td>
          <td width="16%" valign="top">
            <!--- User photo ---->
            <table border="0">
              <tr>
                <td>
                  <a href="perfs.php?i=<?=$id_user;?>"><img src="photos/<?=$photo_user;?>" alt="" style="
                  width: 50px;
                  height: 50px;
                  border-radius: 40px;
                  -webkit-border-radius: 50px;
                  -moz-border-radius: 50px;
                  background: url(photos/<?=$photo_user;?>);
                  background-size:contain;
                  box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                  -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                  -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);"></a>
                </td>
                <td>
                  <font size="+6">:</font>
                </td>
              </tr>
            </table>
          </td>
          <td align="left" colspan="2" valign="top">
            <form action="post_publication.php?a=comment" data-ajax="false" method="post">
                <table width="90%" align="left" border="0">
                  <tr>
                    <td>
                      <textarea name="text_comment" id="text_comment" width="70%"></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input name="ie" type="hidden" id="ie" value="<?=$id_event;?>">
                      <input type="hidden" value="<?=$id_pub;?>" name="ip" id="ip">
                      <input type="hidden" value="<?=$id_user;?>" name="iu" id="iu">  
                      <input name="Envoyer" type="submit" value="Comentar" align="right" width="50px" height="200">
                    </td>
                  </tr>
                </table>
            </form>
          </td>
        </tr>
        <!--- COMMENT FORM ENDS -------->
        <?php
          }
        }
        ?>
    </table>
    <!--- COMMENTS END --------->
  </div>
</body>
</html>