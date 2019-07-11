<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
<style type="text/css">
<?php 
    if(!isset($_GET["inner"])){ ?>
html{
    font-family:sans-serif;
    color:#000000;
    background-color:#FFFFFF;
    margin:0;
    border:none;
}
body{
    padding:0.5em;
}
html,body{
    overflow:hidden;
}
#articleLink{
    display:block;
    font-size:1.5em;
    font-weight:bold;
    margin-bottom:0.5em;
    color:#3040D0;
}
iframe{
    margin:0;
    padding:0;
    border:none;
    width:100%;
}
<?php } else { ?>
html,body{
    margin:0;
    padding:0;
    border:none;
    font-family:sans-serif;
    font-family:sans-serif;
    color:#000000;
    background-color:#FFFFFF;
    overflow:hidden;
}
<?php } ?>
</style>
<title>Commento.io</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1" />
</head>
<body>
<?php 
    if(!isset($_GET["embed"])){
        $frag=basename(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH));
        include '../_config.php';
        $conn = new mysqli($MySql_hostname, $MySql_username, $MySql_password, $MySql_databasename);
        $q = $conn->prepare("select title from articles where frag=?");
        $q->bind_param("s",$frag);
        $q->execute();
        $q->bind_result($title);
        $q->fetch();
        $q->close();
?>
        <a id="articleLink" href="/?p=<?=$frag ?>"><?=nl2br(htmlspecialchars($title)) ?></a>
<?php
    }
?>
<?php 
    if(isset($_GET["inner"])){ ?>
        <div id="commento" data-no-fonts="true"></div>
        <script src="https://cdn.commento.io/js/commento.js"></script>
        <script type="text/javascript">
            var aFixupInterval=setInterval(function(){
                var b=document.getElementById("commento").getElementsByClassName("commento-body");
                for(var i=0;i<b.length;i++){
                    var a=b[i].getElementsByTagName("a");
                    for(var j=0;j<a.length;j++){
                        if(a[j].ai_linkprocessed) continue;
                        a[j].target="__blank";
                        a[j].ai_linkprocessed=true;
                    }
                }
            },50);
            var err=function(){
                document.body.innerHTML="Commento has crashed :(";
                clearInterval(aFixupInterval);
            };
            window.onerror=err;
            window.addEventListener('error',err);
        </script>
    <?php } else { ?>
        <iframe id="container" src="/COMMENTO/?inner=true&embed=true"></iframe>
        <script type="text/javascript">
            setInterval(function(){
                try{
                    var x=document.getElementById("container");
                    x.style.height=x.contentDocument.getElementsByTagName("body")[0].clientHeight+"px";
                }catch(e){}
            },50);
        </script>
    <?php
        }
?>
</body>
</html>
