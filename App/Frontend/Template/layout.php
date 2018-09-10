<?php  require_once('default_head.php') ; ?> 
  <body>
  
  <header>  
    

     <nav id="yout">
        <ul class="site-menu">  
          <li><a href="/">Accueil</a></li>
          <li><a href="/news.html">Chapitre</a></li>
          <?php if ($user->isAuthenticated()) { ?>
          <li><a href="/jf_admin/">Admin</a></li>
          <li><a href="../../../jf_admin/off.html">Deconnection</a> </li>
          <?php } ?>
        </ul>
        <img src="/images/team1.jpg" alt="John" >
      </nav>

     

  </header>
 
  <div class="content">

<div class="haut"></div>
 
  <div id="content-wrap">

      <section id="main">
         <p class="flash"><?php if ($user->hasFlash()) echo  $user->getFlash(); ?></p>
          
          <?= $content ?>
       </section>
  </div>
    
  

  <footer></footer>
   
</div>

  </body>
</html>