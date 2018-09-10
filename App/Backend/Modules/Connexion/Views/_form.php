<script type='text/javascript'>
 function changerPass(){
    var pass = document.getElementById('pass');
        pass.disabled = false;
        pass.value ="";
        document.getElementById('actionPass').innerHTML = " 8 à 10 chiffres uniquement";
 }

</script>
<form  class="formfront"  action="" method="post">
  <p>
   
    
    <label>Pseudo</label><br/>
    <input type="text" name="pseudos" value="<?= isset($users) ? htmlspecialchars($users['pseudos']) : '' ?>" /><br />
    <p class="beware"><?= isset($erreurs) && in_array(\Entity\Users::PSEUDOS_INVALIDE, $erreurs) ? 'Le pseudo est invalide.<br />' : '' ?></p>

    

    
    <label>Email</label><br/>
    <input type="text" name="email" value="<?= isset($users) ? htmlspecialchars ($users['email']) : '' ?>" /><br />
    <p class="beware"><?= isset($erreurs) && in_array(\Entity\Users::EMAIL_INVALIDE, $erreurs) ? 'L\'email est invalide.<br />' : '' ?></p>



   <label>Mot dePasse</label><br/>
   <input type="text" id="pass" name="password" value="" disabled />
   <p class="beware"><?= isset($erreurs) && in_array(\Entity\Users::PASSWORD_INVALIDE, $erreurs) ? 'Le mot de passe est invalide. 8 à 10 chiffres uniquement<br />' : '' ?></p>
   <span type="button" class="tbnAsk" id='actionPass' onclick="changerPass()" >Je veux changer de mot de Passe</span><br />

    <br />


    <input type="hidden" name="id" value="<?= $users['id'] ?>" />
    <input type="submit" class="commentBtn" value="Envoyer" name="envoyer" />

  </p>
</form>