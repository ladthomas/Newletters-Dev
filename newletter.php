<?php
try
{
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host=localhost;dbname=ladthomas;charset=utf8', 'root', '');
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}
if(isset($_GET["id"])){
    $ReqSelect = $bdd->prepare("SELECT * FROM userdb WHERE id =".$_GET['id']);
    $ReqSelect->execute();
    $data = $ReqSelect->fetch();
    $count = $ReqSelect->rowCount();
    if($count == 1){


    
    $ReqShowCategorie = $bdd->prepare("SELECT * FROM `categories`");
    $ReqShowCategorie->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="Assets/css/main.css">
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>Document</title>
    </head>
<style>

        textarea{
            border-radius: 20px;
            padding:20px;
            resize:none;
            margin-top:10px;
        }
        .sousHeader a {
        text-decoration: none;
        background-color: #312929;
        color: white;
        margin:20px;
        position: relative;
        right: 10px;
    }
    .sousHeader {
        width: 100%;
        background-color: #312929;
    }
    input {
        border:0px;
        width:200px;
        height:30px;
        background-color: white;
        margin:20px;
        padding:10px;
        border-radius:10px;
    }
    select {
        border:0px;
        width:200px;
        height:30px;
        border-radius:10px;
        padding:5px;
        background-color: white;
        margin:20px;
    }
</style>
<body>
<div class="header">
        <center>
            <a class="" href="#">ACTUALITES</a>

            <a href="#">COURANTS MUSICAUX</a>

            <img src="./Assets/IMAGES/665307d67b6f5375d30c6f46cd020420 (2).jpg" class="img-header"    alt="" srcset="">

            <a href="#">BIOGRAPHIE</a>

            <a href="topten.html">TOP 10</a>

            <span>

            <a href="#"><i class='fa fa-search' style='font-size:24px'></i></a>

            <a style ="padding-left: 0px;" href="#"><i class="fa fa-user" style="font-size:23px"></i></a>

            </span>            
        </center>
    </div>
<div class="sousHeader">
    <center>
        <?php 
    if(isset($_GET['id']) AND $_GET['id'] > 0){
?><span style="color:red;text-transform:uppercase;"><?= $data['nom'] ?></span>
<a href="userspace.php?id=<?= $_GET['id'] ?>">Actualités</a>
 <?php
if($data['is_Admin'] == "yes"){
    ?>
    <a href="articlesList.php?id=<?= $_GET['id'] ?>">Liste des articles</a>
    <a href="userList.php?id=<?= $_GET['id'] ?>">Liste des utilisateurs</a>
    <a href="categoryList.php?id=<?= $_GET['id'] ?>">Liste des Categories</a>
    <a  style="color: #FFFA47;" href="newletter.php?id=<?= $_GET['id'] ?>">NewsLetter</a>
    <?php
}
?>
    
    <a href="profilUpdate.php?id=<?= $_GET['id'] ?>">Profil</a>
    <a href="postArticles.php?id=<?= $_GET['id'] ?>">Poster Articles</a>
    <a href="login.php">Deconnexion</a>
<?php
}else{
?>    
<a href="login.php">Connexion</a>
<?php
}
?>
    </center>
<hr>
    <center>
    <h3 style="color:white;">SYSTEME DE NEWSLETTER</h3>
    <div id="classic" style="display:none;">
    <?php
    $ShowUserScrib = $bdd->prepare("SELECT * FROM `usernewsletter`");
    $ShowUserScrib ->execute();
     while($showMail = $ShowUserScrib->fetch())
     { 
    ?>
    
    <?php
         if( $showMail["categorie"] == "Classic" )
            { 
               echo "/".$showMail["mail"];
            }
    ?>
    

    <?php   
    }
    ?>
    </div>

    <div id="RNB" style="display:none;">
    <?php
    $ShowUserScrib = $bdd->prepare("SELECT * FROM `usernewsletter`");
    $ShowUserScrib ->execute();
     while($showMail = $ShowUserScrib->fetch())
     { 
    ?>
    
    <?php
         if($showMail["categorie"] == "RNB" ){
                echo "/".$showMail["mail"]; 
            }
    ?>
    

    <?php   
    }
    ?>
    </div>

    <div id="RAP" style="display:none;">
    <?php
    $ShowUserScrib = $bdd->prepare("SELECT * FROM `usernewsletter`");
    $ShowUserScrib ->execute();
     while($showMail = $ShowUserScrib->fetch())
     { 
    ?>
    
    <?php
         if($showMail["categorie"] == "RAP" ){
                echo "/".$showMail["mail"]; 
            }
    ?>
    

    <?php   
    }
    ?>
    </div>

    <div id="DJ" style="display:none;">
    <?php
    $ShowUserScrib = $bdd->prepare("SELECT * FROM `usernewsletter`");
    $ShowUserScrib ->execute();
     while($showMail = $ShowUserScrib->fetch())
     { 
    ?>
    
    <?php
         if($showMail["categorie"] == "DJ" ){
                echo "/".$showMail["mail"]; 
            }
    ?>
    

    <?php   
    }
    ?>
    </div>


    
    <form action="" id="searchForm">
    <select name="" id="cat">
    <?php
    
    while ($dataReqShowCategorie = $ReqShowCategorie->fetch()){
        ?>
        <option value=""><?= $dataReqShowCategorie['nom'] ?></option>
    <?php
        
    }
        ?>
    </select>
    <br>
    <input type="text" name="subtitle" id="subtitle"placeholder="Subtitle...">
    <input type="email" name="senderMail" id="senderMail" value="<?= $data["email"] ?>"><br>
    <textarea id="s" name="s" id="" cols="30" rows="10" placeholder="Votre Messages ici..."></textarea>
    <br>
    <input type="submit" value="Envoyez" class="btn-btn-sbmit">  
    </form>
    <div id="result"></div>
    </center>
</body>
</html>
<?php
}
}
?>
<script>
$( "#searchForm" ).submit(function( event ) {
 
 // Stop form from submitting normally
 event.preventDefault();

 // Get some values from elements on the page:
 var Classic = document.getElementById("classic").innerHTML;
 var DJ = document.getElementById("DJ").innerHTML;
 var RNB = document.getElementById("RNB").innerHTML;
 var RAP = document.getElementById("RAP").innerHTML;


 var msg = document.getElementById("s").value;
 var cat = document.getElementById("cat");
 var texte = cat.options[cat.selectedIndex].text;
 var subtitle = document.getElementById("subtitle").value;
 var senderMail = document.getElementById("senderMail").value;

 
 if(texte == "RNB"){
 var elemRNB = RNB.split('/');
 var settings = {
  "url": "http://167.86.100.164:5000/send_message",
  "method": "POST",
  "timeout": 0,
  "headers": {
    "Content-Type": "application/json",
  },
  "data": JSON.stringify({
    "subject": subtitle,
    "message": msg,
    "sender_mail": senderMail,
    "recipients_mail": elemRNB
  }),
};
$.ajax(settings).done(function (response) {
  console.log(response);
});
 }


 if(texte  == "Classic"){
var elemClassic = Classic.split('/');
var settings = {
  "url": "http://167.86.100.164:5000/send_message",
  "method": "POST",
  "timeout": 0,
  "headers": {
    "Content-Type": "application/json",
  },
  "data": JSON.stringify({
    "subject": subtitle,
    "message": msg,
    "sender_mail": senderMail,
    "recipients_mail": elemClassic
  }),
};
$.ajax(settings).done(function (response) {
  console.log(response);
});

 }


 if(texte  == "DJ"){
 var elemDJ = DJ.split('/');
 var settings = {
  "url": "http://167.86.100.164:5000/send_message",
  "method": "POST",
  "timeout": 0,
  "headers": {
    "Content-Type": "application/json",
  },
  "data": JSON.stringify({
    "subject": subtitle,
    "message": msg,
    "sender_mail": senderMail,
    "recipients_mail": elemDJ
  }),
};
$.ajax(settings).done(function (response) {
  console.log(response);
});


 }


 if(texte  == "RAP"){
 var elemRAP = RAP.split('/');
var settings = {
  "url": "http://167.86.100.164:5000/send_message",
  "method": "POST",
  "timeout": 0,
  "headers": {
    "Content-Type": "application/json",
  },
  "data": JSON.stringify({
    "subject": subtitle,
    "message": msg,
    "sender_mail": senderMail,
    "recipients_mail": elemRAP
  }),
};
$.ajax(settings).done(function (response) {
  console.log(response);
});
 }

});
 

</script>