<script type='text/javascript'>
 function changerPass(){
    var pass = document.getElementById('pass');
        pass.disabled = false;
        pass.value ="";
        document.getElementById('actionPass').innerHTML = " 6 à 8 chiffres uniquement";
 }

</script>
<form action="" method="post">
  <p>
   
    <?= isset($erreurs) && in_array(\Entity\Users::PSEUDOS_INVALIDE, $erreurs) ? 'Le pseudo est invalide.<br />' : '' ?>
    <label>Pseudo</label>
    <input type="text" name="pseudos" value="<?= isset($users) ? htmlspecialchars($users['pseudos']) : '' ?>" /><br />
    

    <?= isset($erreurs) && in_array(\Entity\Users::EMAIL_INVALIDE, $erreurs) ? 'L\'email est invalide.<br />' : '' ?>
    <label>Email</label>
    <input type="text" name="email" value="<?= isset($users) ? htmlspecialchars ($users['email']) : '' ?>" /><br />
    

    <?= isset($erreurs) && in_array(\Entity\Users::PASSWORD_INVALIDE, $erreurs) ? 'Le mot de passe est invalide. 8 à 10 chiffres uniquement<br />' : '' ?>
   <label>Mot dePasse</label>
   <input type="text" id="pass" name="password" value="" disabled />
  
   <span type="button" id='actionPass' onclick="changerPass()" >Changer le Pass</span><br />

    <br />


    <input type="hidden" name="id" value="<?= $users['id'] ?>" />
    <input type="submit" value="Envoyer" name="envoyer" />

  </p>
</form>