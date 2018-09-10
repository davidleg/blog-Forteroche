<script type="text/javascript">

function signaler(id){
	var signal = document.getElementById("signal"+id);
  if ( signal.style.opacity == "1" ){
        cacher(id);
   }else{
        signal.style.maxHeight = "300px";
        signal.style.opacity =  "1";
    }
}
function cacher(id){
   var texarae = document.getElementById("texarea"+id);
        texarae.value = "";
	var signal = document.getElementById("signal"+id);
        signal.style.maxHeight = "0"; 
        signal.style.opacity=  "0";   
}
function envoyer(id){

    var retour ='';
	  var txarea = document.getElementById("texarea"+id);
   // var vas = encodeURI(txarea.value);
 

	  var urlEnvoie = "http://blogecrivain.myportfolio.ovh/signaler-"+id+".html" ;
    var req   = new XMLHttpRequest();
        req.onload = function() {
             retour = req.responseText;
             document.getElementById("signal"+id).innerHTML = retour;
         };
        req.onerror = function(data){
            retour = "Votre signalement n\'a pas abouti. Réessayer plus tard, merci";
         };
        req.open('POST', urlEnvoie, true); 
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        req.send(encodeURI('raison='+txarea.value+'&id='+id));
    
}

</script>


<p class="pnews">Par <em><?= $news['auteur'] ?></em>, le <?= $news['dateAjout']->format('d/m/Y à H\hi') ?></p>

<h2 class="titre" > <?= $news['titre'] ?></h2>

<div class="panelShow"><p class="pnews" ><?= nl2br($news['contenu']) ?></p></div>

<?php if ($news['dateAjout'] != $news['dateModif']) { ?>
  <p  class="pnews"   style="text-align:right;"><small><em>Modifiée le <?= $news['dateModif']->format('d/m/Y à H\hi') ?></em></small></p>
<?php } ?>

<p><a  class="pnews" href="commenter-<?= $news['id'] ?>.html">Ajouter un commentaire</a></p>

<?php
if (empty($comments))
{
?>
<p class="pnews" >Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
<?php
}

foreach ($comments as $comment)
{
?>
<fieldset>
 <p class="pnews">
    Posté par <strong><?= htmlspecialchars($comment['auteur']) ?></strong>, le <?= $comment['date']->format('d/m/Y à H\hi') ?>
 </p>

<legend>
   
    <?php if ($user->isAuthenticated()) { ?> -
      <strong><a  class="fieldsetBtn"  href="jf_admin/comment-update-<?= $comment['id'] ?>.html">Modifier</a></strong> |
       <strong><a  class="fieldsetBtn" href="jf_admin/comment-delete-ask-<?= $news['id'] ?>-<?= $comment['id'] ?>.html">Supprimer</a></strong> |
    <?php } ?>
    
     <strong><a class="fieldsetBtn" href="javascript:void(0)" onclick="signaler(<?= $comment['id'] ?>)" > Signaler </a></strong><br/>
  </legend><br/>

  <div id="signal<?= $comment['id'] ?>" class="panelSignal" >
  	
    	<textarea id="texarea<?= $comment['id'] ?>" name="signale" cols="50" rows="3" placeHolder="Expliquez en quelques mots,les raisons de ce signalement, merci" maxlength="350" required ></textarea><br/> 
    	
      <input type="button"  class="fieldsetBtn" id="btnEnvoie<?= $comment['id'] ?>"   value="Envoyer" name="envoyer" onclick="envoyer(<?= $comment['id'] ?>)" />
    	
      <input type="button" class="fieldsetBtn" id="btnCacher<?= $comment['id'] ?>" value="Annuler" name="Annuler" onclick="cacher(<?= $comment['id'] ?>)" />
      
  </div>
  

  <div class="panelComment"><p class="pnews"><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p></div>
</fieldset>
<?php
}
?>
