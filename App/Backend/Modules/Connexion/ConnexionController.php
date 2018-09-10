<?php
namespace App\Backend\Modules\Connexion;

use \DLSite\BackController;
use \DLSite\HTTPRequest;
use \Entity\Users;
use \DLSite\MailMessage;
use \MailMessage\RetrievePassMailMessage;

class ConnexionController extends BackController
{
	
  /*  trait de pavé de connexion ( image + mappage) + verif   */
  use \DLSite\ClavierVirtuor; 
 

    /* affichage du formulaire de connexion  */
	public function executeIndex(HTTPRequest $request)
   { 
		
		$lienRand = md5(microtime(TRUE)*1000);

		if ($request->method() == 'POST')
		{

		     /*  trait ClavierVirtuor  */
			$passlist = $this-> ifPost( (string)$request->postData('wordtok')  ) ; 	
			$users = new Users(['password' => $passlist,'email'  => $request->postData('email')]);	

		   if($users->isValid() && count($users->erreurs(),1) == 0)
		    {
            	$time=time();
			    while(time()< $time + 3 );
            	$email    = $request->postData('email');
				$password = $passlist;

				//chercher le mail et pass
				if ( true == $userArray =$this->managers->getManagerOf("Users")->getLevel($email) )
				{ 	
				
					if (  password_verify( $password, $userArray["password"] ) ) {
			
						session_regenerate_id(true); 
					
						if ( true == $userArray["status"] )  {
							
							$this->app->user()->setFlash( 'Bienvenue '. $userArray["pseudos"] ) ;
							$this->app->user()->setAuthenticated( true ) ;
							$this->app->httpResponse()->redirect('/');	
							//chmod( $_SERVER['DOCUMENT_ROOT']."/images/users/password".$lienRand.".png", 0777  );
							unlink($_SERVER['DOCUMENT_ROOT']."/images/users/password".$lienRand.".png") ;

						} // $users non valide
						else{
							$this->app->user()->setFlash('Votre status n\'est pas valide. Contacter l\'administrateur du site.');
							unlink($_SERVER['DOCUMENT_ROOT']."/images/users/password".$lienRand.".png") ;

							$this->app->httpResponse()->noCacheRedirect('/jf_admin/connection.html');
						}	
					}
					else { //mauvais mot de passe
						$_SESSION = Array();
						$this->app->user()->setFlash('L\'email ou le mot de passe est incorrect.');
						unlink($_SERVER['DOCUMENT_ROOT']."/images/users/password".$lienRand.".png") ;
						$this->app->httpResponse()->noCacheRedirect('/jf_admin/connection.html');
					}
				
				} // $users n'existe pas en base ou erreur bdd
				else{
					$this->app->user()->setFlash('Une erreur s\'est produite. Veuillez vous reconnecter. Si l\'erreur persiste, contacter l\'administrateur du site.');
					unlink($_SERVER['DOCUMENT_ROOT']."/images/users/password".$lienRand.".png") ;
					$this->app->httpResponse()->noCacheRedirect('/jf_admin/connection.html');
				}
			 
			}// entrée non valide
			else
			{
				$this->page->addVar('erreurs', $users->erreurs());	
				//unlink($_SERVER['DOCUMENT_ROOT']."/images/users/password".$lienRand.".png") ;
				//$this->app->httpResponse()->noCacheRedirect('/jf_admin/connection.html');
			}

		} // pas de post
		else{
		  $users = new Users;
		  /*  trait ClavierVirtuor creé l'image aleatoire  */ 
		   $this->ifNonPost( $lienRand ) ;
		}
		
        $this->page->addVar('users', $users);
        $this->page->addVar('lienRand', $lienRand);
		$this->page->addVar('map', $this->myMap() ); // trait ClavierVirtuor
		$this->page->addVar('title', 'Connexion à mon compte');
	}
	
	



   /* deconnection du user, pas de prise ne compte erreur sauf trigger */
    public function executeOffConnexion(HTTPRequest $request)
   {
		if ($request->postExists('deconnexion')){
				
				$this->app->user()->setAuthenticated(false) ;
			
				$_SESSION = array();
				if( ini_get('session.use_cookies')) {
					$params = session_get_cookie_params();
					setcookie(session_name(), '', time()-420000, $params['path'], $params['domain'], $params['secure'], $params['httponly'] );
				}
				
				$this->app->user()->setFlash('Vous avez été déconnecté, à très bientôt, Merci');
				$this->app->httpResponse()->redirect('../');
			
		}elseif ($request->postExists('annuler')){
			$this->app->user()->setFlash('Vous êtes toujours connecté, et bien parmi nous, Merci');
			$this->app->httpResponse()->redirect('../'); 
		}
   }
 
 



    /* si le user rentre son adresse mail pour avoir un nouveau password */
     public function executeNewPassConnexion(HTTPRequest $request)
    {
		// Si le formulaire a été envoyé.
		if ($request->method() == 'POST'){
			
				$email = str_replace(array("\n","\r",PHP_EOL),'',$request->postData('email'));
				$users = new Users([ 'email'  => $email]);
			
		        if($users->isValid() )
				{
					if ( true !=  $this->managers->getManagerOf('Users')->getLevel($email) ) { // aller chercher le mail et pass
						
						$this->app->user()->setFlash('Cet email ne correspond à aucun profil connu. Si vous pensez qu\'il s\'agit d\'une erreur, merci de contacter le Webmaster');
						$this->app->httpResponse()->redirect('../../../'); 	
					}

					// envoi du mail
					$siteOwner = $this->app->config()->get('siteOwner');
					$mailOwner = $this->app->config()->get('mailOwner');

					$retrievePass = new RetrievePassMailMessage ( $siteOwner, $mailOwner,  $users->id(), $users->email(), $users->pseudos() ) ; 
					
			
					if( true ==  $succesMail =  $retrievePass->envoiMail()  )
					{
				       
				        if( true == $returned =  $this->managers->getManagerOf('Users')->saveNewPass( $retrievePass->mailTo(), $retrievePass->pass() ) ){
 							$this->app->user()->setFlash('Un nouveau mot de passe a été envoyé à votre adresse mail, Merci');
 							$this->app->httpResponse()->redirect('/connection.html');
 						}
					}
				    else 
					{
					    $this->app->user()->setFlash('Le nouveau password n\' as pas pu être envoyé, merci de contacter le Webmaster');
						
					}
				}// fin isValid

        }else { 
			$users = new Users; 
		}

		$this->page->addVar('users', $users);
		$this->page->addVar('title', 'Réinitialiser mon mot de passe');
  }
  



  
  /****************** Profil ******************/


public function executeProfil(HTTPRequest $request)
  {
    
    $manager = $this->managers->getManagerOf('Users');
    
    $this->page->addVar('title', 'Mon Profil');
    $this->page->addVar('listUsers', $manager->getList() );
    
  }



public function executeUpdate(HTTPRequest $request)
  {
	
	if ($request->postExists('pseudos'))
	{
	    //die ( "hell");
	    $users = new Users();
	    
	    $usersId = $request->postData('id');
		$users->setId($usersId);

		$users->setPseudos($request->postData('pseudos'));
		$users->setEmail($request->postData('email'));
        

        $pass = $request->postData('password');
        if ( $pass != ''  &&  ctype_digit($pass)  && strlen((string)$pass) >= 8 && strlen((string)$pass) <=10  )
        {
         	$users->setPassword($request->postData('password'));
	    }
	    else if ( $pass != ''  && ( !ctype_digit($pass)  ||  strlen((string)$pass) < 8 || strlen((string)$pass) >10  ) )
        {
         	$users->setPassword($request->postData('') );
	    }
	    else
	    { 
	    	$users->updatePass(''); 
	    }


	    if (  count($users->erreurs(),1) == 0    )
	    {
		    $this->managers->getManagerOf('Users')->save($users);
		    $this->app->user()->setFlash('Le profil a bien été modifié !');
		    $this->app->httpResponse()->redirect('/jf_admin/profil-update-'.$usersId.'.html');

	    }
	    else
	    {
	      	$this->page->addVar('erreurs', $users->erreurs());
	    }
	    
	    $this->page->addVar('users', $users);
	}
	else
    {
	  
	    $users = new Users ;
	    $data = $request->getData('id');
	    
	    $users = $this->managers->getManagerOf('Users')->getUnique($data) ;
	   
	    $this->page->addVar('users', $users );
	 }
	    
	    $this->page->addVar('title', 'Modification de mon Profil');
  }
 
 

}