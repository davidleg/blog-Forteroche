<?php
namespace App\Backend\Modules\News;

use \DLSite\BackController;
use \DLSite\HTTPRequest;
use \Entity\News;
use \Entity\Comment;

class NewsController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Gestion des news');

    $manager = $this->managers->getManagerOf('News');
    $comments = $this->managers->getManagerOf('Comments')->commentSignalShow();


    $this->page->addVar('listeNews', $manager->getList());
    $this->page->addVar('nombreNews', $manager->count());
    $this->page->addVar('comments', $comments);
  }


  public function executeInsert(HTTPRequest $request)
  {
	    if ($request->postExists('auteur'))
	    {
	      	$this->processForm($request);
	    }
	    
	    $this->page->addVar('title', 'Ajout d\'une news');
  }
  
  public function processForm(HTTPRequest $request)
  {
	    $news = new News([
	      'auteur' => $request->postData('auteur'),
	      'titre' => $request->postData('titre'),
	      'contenu' => $request->postData('contenu')
	    ]);
	    
	    // L'identifiant de la news est transmis si on veut la modifier.
	    if ($request->postExists('id'))
	    {
	      	$news->setId($request->postData('id'));
	    }
	    
	    if ($news->isValid()  &&  count($news->erreurs(),1) == 0  )
	    {
		    $this->managers->getManagerOf('News')->save($news);
		      
		    $this->app->user()->setFlash($news->isNew() ? 'Le billet a bien été ajouté !' : 'Le billet a bien été modifié !');
	    }
	    else
	    {
	      	$this->page->addVar('erreurs', $news->erreurs());
	    }
	    
	    $this->page->addVar('news', $news);
  }


	public function executeUpdate(HTTPRequest $request)
  {
	    if ($request->postExists('auteur'))
	    {
	      	$this->processForm($request);
	    }
	    else
	    {
	     	 $this->page->addVar('news', $this->managers->getManagerOf('News')->getUnique($request->getData('id')));
	    }
	    
	    $this->page->addVar('title', 'Modification d\'une news');
  }

 public function executeDeleteAskNews(HTTPRequest $request) // demande confirmation de suppression
  {
	$newsId = $request->getData('id'); 
    $this->page->addVar('news', ' '. $newsId );

    if ($request->postExists('supprimer'))
    {
	 	$this->managers->getManagerOf('News')->delete($newsId);
    	$this->managers->getManagerOf('Comments')->deleteFromNews($newsId);
		$this->app->user()->setFlash('La news a bien été supprimée !');
 		$this->app->httpResponse()->redirect('/jf_admin/');
	}
    elseif ($request->postExists('annuler'))
    {
        $this->app->user()->setFlash('La news n\'a pas été supprimée, merci');
        $this->app->httpResponse()->redirect('/jf_admin/');
    }
 
  }
  

/**************** Comments  *****************************************/

 public function executeNewsComments(HTTPRequest $request)
 {
    $newsId = $request->getData('id'); 
  	$comments = $this->managers->getManagerOf('Comments')->getListOfAll($newsId) ;
    if ( $comments )
  	 {
	  	 $this->page->addVar('title', 'Les commentaires inspirés par le billet '. $newsId );
	  	 $this->page->addVar('comments', $comments );
	  	 $this->page->addVar('newsId', $newsId );
  	 }
  	 else{
  	   	 
  	   	 $this->app->user()->setFlash('Aucun commentaire pour la news' . $newsId );
		 $this->app->httpResponse()->redirect('.');
    }
  }


   public function executeUpdateComment(HTTPRequest $request)
  {
	    $this->page->addVar('title', 'Modification d\'un commentaire');
	    
	    if ($request->postExists('pseudo'))
	    {
		    $comment = new Comment([
		        'id' => $request->getData('id'),
		        'auteur' => $request->postData('pseudo'),
		        'contenu' => $request->postData('contenu'),
		        'status' => $request->postData('status'),
		        'raison' => $request->postData('raison'),
		        'news' =>$request->postData('news')
		    ]);
		      
		    if ($comment->isValid() &&  count($comment->erreurs(),1) == 0    )
		    {

		        $this->managers->getManagerOf('Comments')->save($comment);
		        
		        $this->app->user()->setFlash('Le commentaire a bien été modifié !');
		        
		        $this->app->httpResponse()->redirect('/news-'.$comment['news'].'.html');
		    }
		     else
		    {
	       		$this->page->addVar('erreurs', $comment->erreurs());
	    	}
	      
	    $this->page->addVar('comment', $comment);
	   
	    }
	    else
	    {
	      	$this->page->addVar('comment', $this->managers->getManagerOf('Comments')->get($request->getData('id')));
	    }
  }


   public function executeDeleteAskComment(HTTPRequest $request) // demande confirmation de suppression
  {
	
	$newsId = $request->getData('idnews');
	$commentsId  = $request->getData('id'); 
	$this->page->addVar('comments', ' '. $commentsId );
    
    if ($request->postExists('supprimer'))
    {
	    $this->managers->getManagerOf('Comments')->delete($commentsId);
	    $this->app->user()->setFlash('Le commentaire a bien été supprimé !');
	    $this->app->httpResponse()->redirect('/news-'.$newsId.'.html' );
	}
    elseif ($request->postExists('annuler'))
    {
        $this->app->user()->setFlash('Le commentaire n\'a pas été supprimée, merci');
        $this->app->httpResponse()->redirect('/news-'.$newsId.'.html' );
    }

  }
  

public function executeAjaxCommentSignal(HTTPRequest $request) //affiche si comment signalé
  {
	$nb = $this->managers->getManagerOf('Comments')->countSignal();
	exit( $nb );
  }


public function executeCommentSignalShow(HTTPRequest $request) //affiche les comments signalés
  {
	$newsId = $request->getData('id'); 
  	$comments = $this->managers->getManagerOf('Comments')->commentSignalShow() ;
    if ( $comments )
  	 {
	  	 $this->page->addVar('title', 'Les commentaires signalés');
	  	 $this->page->addVar('comments', $comments );
  	 }
  	 else{
  	   	 
  	   	 $this->app->user()->setFlash('Aucun commentaire signalé' );
		 $this->app->httpResponse()->redirect('.');
    }

  }



}