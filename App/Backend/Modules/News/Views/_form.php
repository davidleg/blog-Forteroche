
<script src="/tinymce/js/tinymce/tinymce.min.js"></script>
  <script>
tinymce.init({
  selector: '#texarea',
  height: 300,
  width: 800,
  menubar: true,
  language: "fr_FR",  
  plugins: 'print preview searchreplace autolink visualblocks visualchars fullscreen image link media  paste codesample code table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
 
  toolbar: 'insert | undo redo |  formatselect | bold italic backcolor forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',

});
</script>
<form  class="formfront"  action="" method="post">
  
   
    <label>Auteur</label><br/>
    <input type="text" name="auteur" value="<?= isset($news) ? htmlspecialchars($news['auteur']) : '' ?>" /><br />
    <p class="beware"><?= isset($erreurs) && in_array(\Entity\News::AUTEUR_INVALIDE, $erreurs) ? 'L\'auteur est invalide.<br />' : '' ?></p>
    
   
    <label>Titre</label><br />
    <input type="text" name="titre" value="<?= isset($news) ? htmlspecialchars ($news['titre']) : '' ?>" /><br />
     <p class="beware"><?= isset($erreurs) && in_array(\Entity\News::TITRE_INVALIDE, $erreurs) ? 'Le titre est invalide.<br />' : '' ?></p>


    <label>Contenu</label><br />
    <textarea id="texarea" name="contenu" ><?= isset($news) ? htmlspecialchars ($news['contenu']) : '' ?></textarea>
    <p class="beware"><?= isset($erreurs) && in_array(\Entity\News::CONTENU_INVALIDE, $erreurs) ? 'Le contenu est invalide.<br />' : '' ?></p>






<?php
if(isset($news) && !$news->isNew())
{
?>
    <input type="hidden" name="id" value="<?= $news['id'] ?>" />
    <input class="commentBtn" type="submit" value="Modifier" name="modifier" />
<?php
}
else
{
?>
    <input class="commentBtn" type="submit" value="Ajouter" />
<?php
}
?>
  </p>
</form>