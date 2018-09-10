<?php
namespace App\Frontend\Modules\News;

use \DLSite\BackController;
use \DLSite\HTTPRequest;
use \Entity\Comment;


class NewsController extends BackController
{
 
  public function executeIntro(HTTPRequest $request)
  {

  }
  public function executeIndex(HTTPRequest $request)
  {

    $nombreNews = $this->app->config()->get('nombre_news');
    $nombreCaracteres = $this->app->config()->get('nombre_caracteres');


    // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Tous les Chapitres');
    
    // On récupère le manager des news.
    $manager = $this->managers->getManagerOf('News');
    
   
   $listeNews = $manager->getList(0, $nombreNews);

    foreach ($listeNews as $news)
    {
      if (strlen($news->contenu()) > $nombreCaracteres)
      {
        $debut = substr($news->contenu(), 0, $nombreCaracteres);
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
        
        $news->setContenu($debut);
      }
    }
    
    // On ajoute la variable $listeNews à la vue.
    $this->page->addVar('listeNews', $listeNews);

    
  }

   public function executeShow(HTTPRequest $request)
  {
    $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
    
    if (empty($news))
    {
      $this->app->httpResponse()->redirect404();
    }
    
    $this->page->addVar('title', $news->titre());
    $this->page->addVar('news', $news);
    $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
  }



 public function executeInsertComment(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Ajout d\'un commentaire');
    
    if ($request->postExists('pseudo'))
    {

      $comment = new Comment([

        'news' => $request->getData('news'),
        'auteur' => $request->postData('pseudo'),
        'contenu' => $request->postData('contenu')
      ]);
      
     
      if ($comment->isValid() )
      {
        $this->managers->getManagerOf('Comments')->save($comment);
        
        $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
        
        $this->app->httpResponse()->redirect('news-'.$request->getData('news').'.html');
      }
      else
      {
        $this->page->addVar('erreurs', $comment->erreurs());
      }
      
      $this->page->addVar('comment', $comment);
    }
  }
  

   
 public function executeAjaxSignaler(HTTPRequest $request)
 {
    if (isset($_POST['raison']) && isset($_POST['id']) )
    {	
        $raison = $_POST['raison'];
        $id = $_POST['id'];
       
        $comment = new Comment();
        $comment->setId($id);
        $comment->setRaison($raison);
        $comment->setStatus("2");

        
        //if (  count($comment->erreurs(),1) != 0  )

        if ( $raison == ""  ||  ( $raison !="" && !is_string($raison)   ) )
                {
		      	exit("Votre message est invalide ! ");
        }

    		if ( $this->managers->getManagerOf('Comments')->signaler($comment) )
    		{
    			exit("Merci pour votre implication");
    		}

            exit("Désolé, le signalement n\'a pas pu aboutir.");
        }

    }
  
}