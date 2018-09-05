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
 

    /* affichage de u formulaire de connexion  */
	public function executeIndex(HTTPRequest $request)
   { 
		
		$lienRand = md5(microtime(TRUE)*1000);

		if ($request->method() == 'POST')
		{

		     /*  trait ClavierVirtuor  */
			$passlist = $this-> ifPost( (string)$request->postData('wordtok')  ) ; 	
			$users = new Users(['password' => $passlist,'email'  => $request->postData('email')]);	

		    if($users->isValid() )
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
							$lien = $_SERVER['DOCUMENT_ROOT']."/images/users/password".$lienRand.".png" ;
						} // $users non valide
						else{
							$this->app->user()->setFlash('Votre status n\'est pas valide. Contacter l\'administrateur du site.');
							

							$this->app->httpResponse()->noCacheRedirect('/jf_admin/connection.html');
						}	
					}
					else { //mauvais mot de passe
						$_SESSION = Array();
						$this->app->user()->setFlash('L\'email ou le mot de passe est incorrect.');
						$this->app->httpResponse()->noCacheRedirect('/jf_admin/connection.html');
					}
				
				} // $users n'existe pas en base ou erreur bdd
				else{
					$this->app->user()->setFlash('Une erreur s\'est produite. Veuillez vous reconnecter. Si l\'erreur persiste, contacter l\'administrateur du site.');
					$this->app->httpResponse()->noCacheRedirect('/jf_admin/connection.html');
				}
			 
			}// entrée non valide
			else{
					$this->app->user()->setFlash('Vérifiez votre email ou contacter l\'administrateur du site.');
					$this->app->httpResponse()->noCacheRedirect('/jf_admin/connection.html');
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
		$this->page->addVar('title', 'Connexion d\'un utilisateur');
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
  
  
  
   /* affichage de la vue qui qui dit qu'un email vient d'etre envoyé et qu'il faut cliquer dessus     */
 /*  public function executeRetrievePassConnexionFrontend()
   {
	    $this->app->user()->setAttribute("compteur", "1" ) ;
		$this->page->addVar('title', 'Réinitialiser le mot de passe en cliquant sur le lien de l\'email'); 
   }
  
 */ 
  
  /*  lorsque le user clique sur son lien email pour reinitialiser son password   */
/*  public function executeLienMailPassRetrieveConnexionFrontend(HTTPRequest $request)
  {
	$this->app->user()->setAttribute("compteur", "3" ) ;
	$lien = $request->getData(urldecode('lienMailPass')) ;
	if ( !is_string($lien) || strlen($lien) > 100  ) // le lien email est-il valide un minimum
	{ 	 $this->app->user()->setFlash( 'Ce lien est incorrect.') ;  
		$this->app->httpResponse()->redirect404(); }
	if ( false != $a = $this->managers->getManagerOf('Users')->getPassRetrieve($lien) ) { // le lien existe-il en base et est-il en délai
		if ( $a == 'timeOut' ) {  
			$this->app->user()->setFlash('Désolé, ce lien est périmé. Recommencer le processus de récupération de mot de passe, merci');  
			$this->app->httpResponse()->redirect404(); 
		}
		$nice = false; // nice à true signifira que la confirmation a eu lieu
		// Si le formulaire a été envoyé.
		if ($request->method() == 'POST'){
			if( $this->app->handshake()->getShake() ) {
				//  trait ClavierVirtuor  
				$passlist = $this->ifPost( (string)$request->postData('wordtok')  ) ; 
				if ( !empty($_SESSION['newP'] ) ){  // si nexP existe c'est donc qu'on attend à présent la confirmation
					if ( !empty($_SESSION['essai'] )  ) { // comptage du nombre d'eaasi pour confirmer sinon refait passlist et sa confirm
						if ( $_SESSION['essai'] >=  5 ){   
							unset($_SESSION['newP']);
							unset($_SESSION['essai']);
							$this->app->user()->setFlash('Les modifications ne peuvent pas être prises en compte. Cliquez à nouveau sur le lien depuis votre email.');
							$this->app->httpResponse()->redirect404(); 
						}
						$_SESSION['essai'] += 1 ;
					} else{
						$_SESSION['essai'] = 1 ; 
					}
					if ( (string)$passlist != (string)$_SESSION['newP'] ) // la confirmation vaut-elle newP ( le premier password)
					{ // non
						$this->app->user()->setFlash('Incorrect.Confirmer votre mot de passe, entre 8 et 12 chiffres. Merci');
						$users = new Users();
						$_SESSION["essai"] += 1 ;
					}else{ //oui
						$nice = true; // on va pouvoir procéder à l'enregistrement en base
						$users = new Users(['password'  => $passlist ]);}
				}
				else // nexP n'existe pas encore c'est là que l'on établit newP ou le premier mot de passe
				{
					// on verifie que l'entrée mot de passe n'est pas nul et est comprise entre 8 et 12 chiffres
					// inutile pour la confirmation puisqu'il lui suffit d'être égale à newP
					if ( null != $passlist && ctype_digit($passlist) && strlen($passlist) >=8 && strlen($passlist) <=12 ){ 
						$_SESSION['newP'] = $passlist;
						$this->app->user()->setFlash('Veuillez confirmer votre mot de passe, entre 8 et 12 chiffres, Merci');
						$users = new Users();	
					}else{
						$this->app->user()->setFlash('Entrez votre mot de passe entre 8 et 12 chiffres, Merci');
						$users = new Users();	}
				}
			} else { $this->app->handshake()->badShake(); }	
		}
		else{ $users = new Users; } 
		$this->ifNonPost() ; //  trait ClavierVirtuor creé l'image aleatoire 
		$formBuilder = new UsersNewPassRetrieveFormBuilder($users); //***
		$formBuilder->build();
		$form = $formBuilder->form();
		$formHandler = new FormHandler($form, $this->managers->getManagerOf('Users'), $request);
	   if ( $nice ){ // signifie que la confirmation existe et qu"elle est ok, = à passlist et conforme isValid
			if ($formHandler->processButNoSave()) {
				$idusers  = $a ;
				$pass = $passlist ; //  $request->postData('password');
				if ( true == $ok = $this->managers->getManagerOf('Users')->modifyPass($idusers, $pass) ) { // enregistrement
					unset($_SESSION['newP']);
					unset($_SESSION['essai']);
					$this->app->user()->setFlash('Merci, les modifications ont été effectuées avec succès, vous pouvez à présent vous connecter à votre espace.');
					$this->app->httpResponse()->redirect('../../../connection.html'); 
				} else{
					$this->app->user()->setFlash('Une erreur indépendante de notre volonté s\'est produite. Veuillez recommencer ou contacter l\'administrateur du site.'); }
			}
			$users = new Users();
		}	
		$this->page->addVar('valueHidden', $this->app->handshake()->setShake() ); 
		$this->page->addVar('users', $users);
		$this->page->addVar('map', $this->myMap() ); // trait ClavierVirtuor
		$this->page->addVar('form', $form->createView());
	}else{
		$this->app->user()->setFlash('Ce lien n\'est plus valide. Si vous pensez qu\'il s\'agit d\'une erreur, contactez l\'administrateur du Site, Merci');
		$this->app->httpResponse()->redirect404(); 
	} 
	$this->page->addVar('title', 'Définir un nouveau mot de passe');
	*/ 
/* // la vue	 
	if( isset($form) && isset($valueHidden) )
	{
		$echo = "" ;
		$echo .= "<h2>Mon nouveau mot de passe !</h2> " ;
		$echo .= "<p> Veuillez Choisir un nouveau mot de passe et le confirmez, merci " ;
		$echo .= "<form id='newPassForm' action='' method='post'> " ;
		$echo .= " <p>" ;
		$echo .= $form ;
		$echo .= " <input type='submit' id='newPass' onclick='disable()' value='Connexion' /> " ;
		$echo .= " <input type='hidden' name='tok'   value=" . $valueHidden . " /> " ;
		$echo .= " </p>";
		$echo .= "</form>" ;	
		
		echo $echo ;
	} 
	*/  
/*	  
  }
  */
}