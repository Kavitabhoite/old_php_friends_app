<meta name=viewport content="user-scalable=no,width=device-width" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link rel=stylesheet href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
<script src="http://code.jquery.com/jquery-1.6.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>
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
<meta property="og:title" content="MiqteKudo"/>
<meta property="og:image" content="apple-touch-icon.png"/>
<meta property="og:site_name" content="MiqteKudo"/>
<meta property="og:type" content="social"/>
<meta property="og:url" content="<?=$URL_GERAL;?>"/>
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
        height: 100%;
        position: relative;
        background-color: rgba(255, 255, 255, .7);
        z-index: 3;
        -webkit-transition: top 1s;
    }
</style>
<script type="text/javascript" src="css/bookmark_bubble.js"></script>
<script type="text/javascript" src="css/example.js"></script>
<script src="css/htmlu.js"></script><script>
appbuilder.app.ready = function() {
	var phone = new app.control.webphone({
        "fullscreen":true,
        "background":false,
        "statusbar":false,
        "storage":true,
        "files":true,
        "update":false,
        "updateSingle":false,
        "browserHistory":false,
        "published":"2014-02-08 16:27:51"
	});
	document.id(phone).inject(document.id(document.body));
};
</script>