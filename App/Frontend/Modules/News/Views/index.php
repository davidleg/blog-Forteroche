<h2 class="introPage">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</h2>
<?php
$i = 1;
foreach ($listeNews as $news)
{
?>
  <div class="nbNews">
  	 <a href="news-<?= $news['id'] ?>.html"><span class="rounded" ><?= $i ?></span></a>
  	 <span class="upDown"  onclick="cache('panel<?= $i ?>')" >-</span>
  	 <span class="upDown " onclick="vue('panel<?= $i ?>')" >+</span>
  </div>
  	<h2 class="titre"> <a href="news-<?= $news['id'] ?>.html"><?= $news['titre'] ?></a></h2>


  
  <div class="bluePanel" id="panel<?= $i ?>"  >
     <p><?= nl2br($news['contenu']) ?></p>
  </div>

  <hr/>

<?php $i++; ?>
<?php
}
?>

<script type="text/javascript">
 
 function vue(id){
 	var panneau = document.getElementById(id);
 	panneau.style.opacity = "1";
 	panneau.style.maxHeight = "400px";

 }

function cache(id){
	var intro = document.getElementById(id);
	intro.style.opacity = "0";
 	intro.style.maxHeight = "0";

 }
vue("panel1");
</script>