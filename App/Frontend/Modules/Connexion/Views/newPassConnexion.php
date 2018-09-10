<h2  class="titre">Entrez votre adresse email</h2>
<script>
function disable()
{
	document.getElementById("go").disabled = true;
	var submitForm = document.getElementById("goForm"); 
	submitForm.submit() ;
	
}
</script>
<form   class="formfront"  id="goForm" action="" method="post">
  
 
  
   <label>Email</label><br/>
   <input  type="text" name="email" value="" </p>
   <p class="beware" ><?= isset($erreurs) && in_array(\Entity\Users::EMAIL_INVALIDE, $erreurs) ? 'L\'email est invalide.<br />' : '' ?></p>
   <br/>

   <p> <input class="commentBtn" type="submit"id="go" onclick="disable()" value="Connexion" /></p>
	
  
</form>
<br/>
