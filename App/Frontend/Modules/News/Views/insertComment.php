<h2 class="titre" >Ajouter un commentaire</h2>
<div class="pageComment">

    
	<form class="formfront" action="" method="POST">
	  
	   
	    <label>Notre nom :</label><br/>
	    <input type="text" name="pseudo" value="<?= isset($comment) ? htmlspecialchars($comment['auteur']) : '' ?>" /><br />
	    <p class="beware" ><?= isset($erreurs) && in_array(\Entity\Comment::AUTEUR_INVALIDE, $erreurs) ? 'Le nom est invalide.<br />' : '' ?></p>
	    <br/><br/>
	 
	   
	    <label>Commentaire :</label><br/>
	    <textarea name="contenu" rows="7" cols="50"><?= isset($comment) ? htmlspecialchars($comment['contenu']) : '' ?></textarea><br />
	     <p class="beware" ><?= isset($erreurs) && in_array( \Entity\Comment::CONTENU_INVALIDE, $erreurs)? 'Le commentaire est invalide.<br />' : '' ?></p>
	     <br/><br/>

	    <input type="submit" class="commentBtn" value="Commenter" />
	  
	</form>

<div class="panelComment" > <h3 >Merci pour vos commentaires. Grâce à vous, ce site vivant fourmille d'idées.</h3></div>

</div>