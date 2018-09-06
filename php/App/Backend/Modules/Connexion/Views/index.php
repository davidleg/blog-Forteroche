<h2>Connection à mon Compte</h2>
<script>
<!--
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
-->
</script>

<form id="goForm" name="formulaire" action=""  method="post">
 

	<p style='float:right;margin-top:5px;margin-right:20%;'>
		<?php echo '<img id="pad" src="../../images/users/password'.$lienRand.'.png" usemap="#map" border="3px #CCC solid" /> '; ?> 
	</p>
	


	 <?= isset($erreurs) && in_array(\Entity\Users::EMAIL_INVALIDE, $erreurs) ? 'L\'email est invalide.<br />' : '' ?>
	<p><label>Email</label><br/>
		<input style=\'margin-left:10px;width:200px;\'  type="text" name="email" value="" </p>

	
    <?= isset($erreurs) && in_array(\Entity\Users::PASSWORD_INVALIDE, $erreurs) ? 'Le mot de passe est invalide.<br />' : '' ?>
	<p><label>Mot de passe</label><br/>
		<input style=\'margin-left:10px;width:200px;\' type="password" name="password"  value=""  readonly="readonly" disabled />

	<p><?= $map ?></p> 
	
	<input style='margin-left:10px;' type="reset" name="corriger" id="corriger" value="Corriger" />
    <input type="submit" name="connexion" id="connexion" onclick="disable()" value="Connexion" />
	<input type="hidden" name='wordtok'   value='' />
	
  
</form>
<br/>
<p> <a href="../../nouveau-mot-de-passe.html">J'ai oublié mon mot de passe</a></p>