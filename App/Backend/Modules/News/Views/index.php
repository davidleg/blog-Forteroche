
<div id="textSignal" ><a href="" id="aSignal" >Signalement :<span id="nbSignal"></span></a></div>


<h2 class="pushMargin">Vous avez actuellement <?= $nombreNews ?> billets :</h2>

<table class="tableAdmin">
  <tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>
<?php

$tabNewsIdFromComment=[];

foreach($comments as $comment ){
    array_push($tabNewsIdFromComment,$comment['news']);
}

foreach ($listeNews as $news)
{
   
    if( in_array($news['id'],$tabNewsIdFromComment )  ){
        $cooleur = '<tr style="background-color:rgba(150,0,0,0.1);" >';
    }
    else{
    	$cooleur = '<tr style="background-color:rgba(250,250,250,1);" >';
    } 

 	echo $cooleur.'<td>', $news['auteur'], '</td>
 	<td>', $news['titre'], '</td><td>le ', $news['dateAjout']->format('d/m/Y à H\hi'), '</td>
 	<td>', ($news['dateAjout'] == $news['dateModif'] ? '-' : 'le '.$news['dateModif']->format('d/m/Y à H\hi')), '</td>
	<td><a class="pleft" href="news-update-', $news['id'], '.html"><i class="fa fa-edit fa-lg "></i></a> 
	    <a class="pleft"   href="news-delete-ask-', $news['id'], '.html"><i class="fa fa-window-close fa-lg"></i></a>
	    <a class="pleft"   href="news-comments-', $news['id'], '.html"> <i class="fa fa-sitemap fa-lg"></i></a> 
  </td>
	</tr>', "\n";
   
}
?>
</table>

<script type="text/javascript">
	
  (function checkSignal()
        {
    retourSignal ='';
    textSignal= document.getElementById("textSignal");
    nbSignal  = document.getElementById("nbSignal");
    aSignal  = document.getElementById("aSignal");
    var urlEnvoie = "http://blogecrivain.myportfolio.ovh/jf_admin/comment-signal.html" ;
    var req   = new XMLHttpRequest();
              
        req.onload = function() {
            retourSignal = this.responseText;
             nbSignal.innerHTML = retourSignal;
            if ( retourSignal > 0){
	            textSignal.style.backgroundColor ="red";
                aSignal.href="/jf_admin/comment-signal-show.html";
            }
	        else{
	        	textSignal.style.backgroundColor ="green";
	        }

          };
        req.onerror = function(data){
            retourSignal = "Erreur";
           };

        req.open('GET', urlEnvoie, true);
        req.send();

   })()
</script>