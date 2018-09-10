<!DOCTYPE html>
<html>
  <head>
    <title>
      <?= isset($title) ? $title : 'Le blog de Jean Forteroche' ?>
    </title>
    
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="favicon.ico" />
    <link rel="stylesheet" href="/css/styleBlog.css" type="text/css" />
    <!-- Add icon library -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  
  <body>

    <header>
       
        <nav id="youtAdmin">
          <ul>
            <li><a href="/">Site</a></li>
            <?php if ($user->isAuthenticated()) { ?>
            <li><a href="/jf_admin/">Admin</a></li>
            <li><a href="/jf_admin/profil.html">Profil</a></li>
            <?php } ?>
          </ul>
        </nav>

    </header>
 
 <div class="content">

     <div class="haut"></div>

     <div >
       <?php 
          if ( $user->isAuthenticated())  
          { 
              echo '<p><a href="/jf_admin/off.html"><i class="fa fa-power-off fa-2x pnav"></i></a> 
                   <span ><a class="pnav"  href="/jf_admin/news-insert.html"><span class="fa fa-clone fa-lg "></span> Ajoutez un Chapitre</a></span></p>' ;
          }
          ?>
      </div> 

      <div id="content-wrap">
        <section id="main">
         <p class="flash"> <?php if ($user->hasFlash()) echo $user->getFlash(); ?></p>
          
          <?= $content ?>
        </section>
      </div>
    


      <footer></footer>
    </div>
  </body>
</html>