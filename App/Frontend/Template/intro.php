<?php  require_once('default_head.php') ; ?>  
  <body>
  
  <header>  
   <div class="hero-image">
      <div class="hero-text">
        <h1>Le blog de Jean Forteroche</h1>
        <p>Ecrivain à succès, Jean Forteroche vous fait découvrir son dernier roman dans un format inédit en ligne. Suivez l'intrigue pas à pas..</p>
        <button><a style ="text-decoration:none;color:white;" href="/news.html"> Chapitre </a></button>
      </div>

     <nav id="itro" >
        <ul>
          <li><a href="/">Accueil</a></li>
          <li><a href="/news.html">Chapitre</a></li>
          <?php if ($user->isAuthenticated()) { ?>
          <li><a href="/jf_admin/">Admin</a></li>
          <li><a href="../../../jf_admin/off.html">Deconnection</a> </li>
        
          <?php } ?>
        </ul>
      </nav>
      
      <button id="toggleCard" class="open-button"  onclick="showModal()" >Contact</button>
    
  </div>

<div id="myModal" class="modal"  onclick="hideModal()">
       <div class="card" id="jfCard"  >
            <img src="/images/team2.jpg" alt="John" style="width:100%">
            <h1>Jean Forteroche</h1>
            <p class="titleCard">Ecrivain, auteur de Best Seller</p>
            <p>Vous souhaitez me joindre, engager la discussion? contacter moi, nous avons tant à lire..</p>
            <a class="aCard" href="#"><i class="fa fa-dribbble"></i></a> 
            <a class="aCard"href="#"><i class="fa fa-twitter"></i></a> 
            <a class="aCard"href="#"><i class="fa fa-linkedin"></i></a> 
            <a class="aCard"href="#"><i class="fa fa-facebook"></i></a> 
            <p><button class="buttonCard">Contact</button></p>
        </div>
</div>
</header>

<div class="content">
 
 <section id="presentation" > 
    
      <img src="/images/team1.jpg" alt="John" >
     <h3 > Bonjour, quel plaisir de vous retrouver, mon nouveau Livre se dévoile ici. Bonne lecture !</h3> 

   </section>  

     

      <div class="slideshow-container">

        <div class="mySlides">
          <q>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod consectetur adipiscing elit,tempor incididunt ut labore et dolore magna aliqua.</q>
          <p class="author">- John Keats</p>
        </div>

        <div class="mySlides">
          <q>consectetur adipiscing elit,Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</q>
          <p class="author">- Ernest Hemingway</p>
        </div>

        <div class="mySlides">
          <q>sed do eiusmod Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua adipiscing e.</q>
          <p class="author">- Thomas A. Edison</p>
        </div>

      <div class="dot-container">
        <span class="dot" onclick="currentSlide(1)"></span> 
        <span class="dot" onclick="currentSlide(2)"></span> 
        <span class="dot" onclick="currentSlide(3)"></span> 
      </div>
</div>

      
  <div id="content-wrap">
     <section id="main">
        <?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>
          
        <?= $content ?>
      </section>
   </div>
    




<footer></footer>
   
</div>
<script type="text/javascript" >


/*           SLIDE   */
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1} 
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none"; 
    }
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" activeP", "");
    }
  slides[slideIndex-1].style.display = "block"; 
  dots[slideIndex-1].className += " activeP";
}
function plusUn(){
  plusSlides(1);
}
var defile = setInterval(plusUn,5000);



var modal = document.getElementById('myModal');
var btn   = document.getElementById('toggleCard');
var card  = document.getElementById('jfCard');

 function showModal(){
    modal.style.display = "block";
    jfCard.style.opacity = "1";
   // btn.style.opacity = "0";
}
function hideModal() {
    modal.style.display = "none";
    card.style.opacity = "0";
  //  btn.style.opacity = "1";
}



</script>



  </body>
</html>