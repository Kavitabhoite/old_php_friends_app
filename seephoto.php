<?php
$photo = $_GET['p'];
?>
<!DOCTYPE html> 
<html> 
<head> 
  <meta name=viewport content="user-scalable=no,width=device-width" />
  <link rel=stylesheet href=http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css />
  <script src=http://code.jquery.com/jquery-1.6.min.js></script>
  <script src=http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js>
  </script>
</head> 
<body> 
<div data-role="page" id="win2" data-add-back-btn="true">
  <div data-role="header">
    <h1></h1>
  </div>
  <div data-role="content">
    <p> <img src="photos/<?=$photo?>" width="100%" height="100%"></p>
  </div>
</div>
</body>
</html>