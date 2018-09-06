<h2>Entrez votre adresse email</h2>
<script>
function disable()
{
	document.getElementById("go").disabled = true;
	var submitForm = document.getElementById("goForm"); 
	submitForm.submit() ;
	
}
</script>
<form id="goForm" action="" method="post">
  
 
    <?= isset($erreurs) && in_array(\Entity\Users::EMAIL_INVALIDE, $erreurs) ? 'L\'email est invalide.<br />' : '' ?> 
   <p><label>Email</label><br/>
  <input style=\'margin-left:10px;width:200px;\'  type="text" name="email" value="" </p>



   <p> <input type="submit"id="go" onclick="disable()" value="Connexion" /></p>
	
  
</form>
<br/>
