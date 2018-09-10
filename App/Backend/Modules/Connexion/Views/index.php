<script>
function disable()
{
	document.getElementById("connexion").disabled = true;
	var submitForm = document.getElementById("goForm"); 
	submitForm.submit() ;	
}
function bloc ( lettre ) {
if ( document.formulaire.password.value.length < 12 ) document.formulaire.password.value = document.formulaire.password.value + lettre;
if ( document.formulaire.wordtok.value.length < 12 ) document.formulaire.wordtok.value = document.formulaire.wordtok.value + lettre;
}

</script>
<h2 class='titreAdmin'>Connection à mon Compte</h2>

<form class="formfront" id="goForm" name="formulaire" action=""  method="post">

	
	<label>Email</label><br/>
	<input  type="text" name="email" value="" </p>
     <p class="beware"><?= isset($erreurs) && in_array(\Entity\Users::EMAIL_INVALIDE, $erreurs) ? 'L\'email est invalide.<br />' : '' ?></p>
	

	<label>Mot de passe</label><br/>
    <input type="password" name="password"  value=""  readonly="readonly" disabled />
    <p class="beware"><?= isset($erreurs) && in_array(\Entity\Users::PASSWORD_INVALIDE, $erreurs) ? 'Le mot de passe est invalide.<br />' : '' ?></p>


    <p style='margin:20px 20px 20px 0;'>
		<?php echo '<img id="pad" src="../../images/users/password'.$lienRand.'.png" usemap="#map" border="1px #CCC solid" /> '; ?> 
	</p>

	<p><?= $map     ?></p> 
	
	<input type="reset"  class="commentBtn" name="corriger" id="corriger" value="Corriger" />
    <input type="submit" class="commentBtn" name="connexion" id="connexion" onclick="disable()" value="Connexion" />
	<input type="hidden" name='wordtok'   value='' />
	
  
</form>
<a  class="pNews" href="../../nouveau-mot-de-passe.html">J'ai oublié mon mot de passe</a>