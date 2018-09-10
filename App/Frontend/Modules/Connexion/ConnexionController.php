<?php
namespace App\Frontend\Modules\Connexion;

use \DLSite\BackController;
use \DLSite\HTTPRequest;
use \Entity\Users;
use \DLSite\MailMessage;
use \MailMessage\RetrievePassMailMessage;

class ConnexionController extends BackController
{
  
    /* si le user rentre son adresse mail pour avoir un nouveau password */
     public function executeNewPassConnexion(HTTPRequest $request)
    {
		// Si le formulaire a été envoyé.
		if ($request->method() == 'POST'){
			
				$email = str_replace(array("\n","\r",PHP_EOL),'',$request->postData('email'));
				$users = new Users([ 'email'  => $email]);
			
		        if($users->isValid() && count($users->erreurs(),1) == 0)
				{
					if ( true !=  $this->managers->getManagerOf('Users')->getLevel($email) ) { // aller chercher le mail et pass
						
						$this->app->user()->setFlash('Cet email ne correspond à aucun profil connu. Si vous pensez qu\'il s\'agit d\'une erreur, merci de contacter le Webmaster');
						$this->app->httpResponse()->redirect('news.html'); 	
					}

					// envoi du mail
					$siteOwner = $this->app->config()->get('siteOwner');
					$mailOwner = $this->app->config()->get('mailOwner');

					$retrievePass = new RetrievePassMailMessage ( $siteOwner, $mailOwner,  $users->id(), $users->email(), $users->pseudos() ) ; 
					
			
					if( true ==  $succesMail =  $retrievePass->envoiMail()  )
					{
				       
				        if( true == $returned =  $this->managers->getManagerOf('Users')->saveNewPass( $retrievePass->mailTo(), $retrievePass->pass() ) ){
 							$this->app->user()->setFlash('Un nouveau mot de passe a été envoyé à votre adresse mail, Merci');
 							$this->app->httpResponse()->redirect('/jf_admin/connection.html');
 						}
					}
				    else 
					{
					    $this->app->user()->setFlash('Le nouveau password n\' as pas pu être envoyé, merci de contacter le Webmaster');
						
					}
				}
				 else
			    {
			      	$this->page->addVar('erreurs', $users->erreurs());
			    }

        }else { 
			$users = new Users; 
		}

		$this->page->addVar('users', $users);
		$this->page->addVar('title', 'Réinitialiser mon mot de passe');
  }
  
  
  
}