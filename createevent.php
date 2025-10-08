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
      background: url(photos/<?=$photo_user?>.jpg);
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
          <a href="events.php"><img src="<?=$calendimage;?>" width="40" style="-webkit-filter: drop-shadow(2px 2px 2px #222);filter:drop-shadow(2px 2px 2px #222);" ></a>
        </td>
        <td width="19%" align="center">
          <a href="membs.php"><img src="images/memb_but.png" width="40"><br></a>
        </td>
        <td width="19%" align="center">
          <a href=""perf.php""><div align="center" class="circular_photo_user"></div></a>
        </td>
        <td width="19%" align="center">
          <a href="logout.php"><img src="images/off_but.png" width="40"></a>
        </td>
      </tr>
    </table>  
    <!--- Start showing event's form ------------>
    <form action="eventform.php?a=new" method="post" data-ajax="false">
      <table cellpadding="0" cellspacing="5" bgcolor="#fff" width="100%">
        <tr>
          <td colspan="3">
            <table cellpadding="0" cellspacing="5" bgcolor="#fff" width="100%">
              <tr>
                <td colspan="3">
                  <input name="tit_new" type="text" id="tit_new" style="font-size:20px" placeholder="Titulo">
                  <input type="hidden" value="<?=$id_user;?>" name="creator" id="creator"></td>
              </tr>
              <tr>
                <td valign="top" width="15%" rowspan="3" align="center">
                  <!--- DATA EVENT --->
                  <table border="0" height="79" style="background:url(images/calend_lone.png); background-size:cover; max-height:80px;" width="72px" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="18" align="center" valign="top">
                        <font face="Verdana, Geneva, sans-serif" color="#FFFFFF" size="-4">
                          <input name="ano_new" type="text" id="ano_new" placeholder="Ano" style="font-size:9px; text-align:center; width:60px;" pattern="[0-9]*" value="<?php echo date("Y"); ?>">
                        </font>
                      </td>
                    </tr>
                    <tr>
                      <td height="19" align="center">
                        <font face="Verdana, Geneva, sans-serif" color="#FFFFFF">
                          <select name="dia_new" id="dia_new" style="width:70px;">                      
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                          </select>
                        </font>
                      </td>
                    </tr>
                    <tr>
                      <td height="42" align="center">
                        <font face="Verdana, Geneva, sans-serif" color="#FFFFFF">
                          <select name="mes_new" id="mes_new" style="width:70px;">                      
                            <option value="01">JAN</option>
                            <option value="02">FEV</option>
                            <option value="03">MAR</option>
                            <option value="04">ABR</option>
                            <option value="05">MAIO</option>
                            <option value="06">JUN</option>
                            <option value="07">JUL</option>
                            <option value="08">AGO</option>
                            <option value="09">SET</option>
                            <option value="10">OUT</option>
                            <option value="11">NOV</option>
                            <option value="12">DEZ</option>
                          </select>
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
                      <td width="93%">
                        <table width="100%" border="0">
                          <tr>
                            <td>
                              <input name="hour_new" type="text" id="hour_new" placeholder="Hora" pattern="[0-9]*" maxlength="2">
                            </td>
                            <td>
                              <b>:</b>
                            </td>
                            <td>
                              <input name="min_new" type="text" id="min_new" placeholder="Minuto" pattern="[0-9]*" maxlength="2">
                            </td>
                          </tr>
                        </table>
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
                      <td width="7%"><img src="images/place_icon.png"></td>
                      <td width="93%"><textarea name="place_new" id="place_new" placeholder="Local"></textarea></td>
                    </tr>
                  </table>
                  <!--- PLACE ENDS --->
                </td>
              </tr>
              <tr>
                <td>
                  <textarea name="desc_new" id="desc_new" style="width:90%;" placeholder="Descrição"></textarea>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <table border="0" bgcolor="#dcdcdc" width="100%">
        <tr>
          <td align="center">
            <!--- BUTTONS CONFIRM --->          
            <input data-icon="check" name="" type="submit" value="Criar">          
            <!--- BUTTONS CONFIRM END ---> 
          </td>
        </tr>
      </table> 
    </form>
  </div>
</body>
</html>
