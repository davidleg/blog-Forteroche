<h2 class="pushMargin">Modifier le commentaire <?= $comment['id'] ?> </h2>

<?php if($comment['date']){ ?>
<p>Date création : <span>le <?= $comment['date'] ?></span></p><br />
<?php } ?>
<form   class="formfront" action="" method="post">
 
 
    <label>Pseudo</label></br />
    <input type="text" name="pseudo" value="<?= htmlspecialchars($comment['auteur']) ?>" /><br />
    <p class="beware"><?= isset($erreurs) && in_array(\Entity\Comment::AUTEUR_INVALIDE, $erreurs) ? 'L\'auteur est invalide.<br />' : '' ?></p>


    <label>Contenu</label><br />
    <textarea name="contenu" rows="7" cols="50"><?= htmlspecialchars($comment['contenu']) ?></textarea><br />
    <p class="beware"><?= isset($erreurs) && in_array(\Entity\Comment::CONTENU_INVALIDE, $erreurs) ? 'Le contenu est invalide.<br />' : '' ?></p>


    <label>Status, 1 ok, 2 signalé, 3 dépublié</label><br/>
    <input type="text" name="status" value="<?= htmlspecialchars($comment['status']) ?>" /> <br />
   <p class="beware"><?= isset($erreurs) && in_array(\Entity\Comment::STATUS_INVALIDE, $erreurs) ? 'Le status est invalide, chiffre uniquement, 1 pour commnentaire non signalé, 2 pour signaler, 3 pour juste dépublier sans supprimer.<br />' : '' ?></p>


    <label>Raison</label><br />
    <input type="text" name="raison" value="<?= htmlspecialchars($comment['raison']) ?>" /> <br />
    <p class="beware"><?= isset($erreurs) && in_array(\Entity\Comment::RAISON_INVALIDE, $erreurs) ? 'La raison est invalide.<br />' : '' ?></p>


    <input type="hidden" name="news" value="<?= $comment['news'] ?>" />
    <input type="submit" class="commentBtn" value="Modifier" />
  </p>
</form>