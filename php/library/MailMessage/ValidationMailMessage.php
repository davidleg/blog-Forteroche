<?php
namespace MailMessage;

use \OCFram\MailMessage;

class ValidationMailMessage extends MailMessage
{

  protected $pass ='';
  
  public function __construct($siteOwner, $mailOwner, $idTo, $mailTo, $nameTo, $passTo ) // passe par session !
  {
    parent::__construct($siteOwner, $mailOwner, $idTo, $mailTo, $nameTo) ;
	$lien = md5(microtime(TRUE)*1000);
	$this->setLienMail($lien);
	$this->setPass($passTo);
	
  }
 public function setPass($pass)
 {
	 $this->pass = $pass ;
 }
 public function pass()
 {
	 return $this->pass ;
 }
 public function envoiMail()
 {
	$from    = htmlspecialchars($this->mailOwner() ) ;
	$EmailTo = htmlspecialchars($this->mailTo() ) ;
	$Subject = 'Valider votre inscription' ; ;
	
	$Body  = "";
	$Body .= "Bonjour  ";
	$Body .= htmlspecialchars( $this->nameTo() );
	$Body .= "\n";
	$Body .= "Merci d'avoir choisi ";
	$Body .= htmlspecialchars( $this->siteOwner() );
	$Body .= "\n";
    $Body .= "Valider votre inscription en cliquant sur ce lien dans les 24h ";
	$Body .= "\n";
	$Body .= "http://localhost/pending/".urlencode($this->lienMail() ) .".html";
	$Body .= "\n";
	$Body .= "Pour rappel votre mot de passe est : ".$this->pass() ;
	$Body .= "Un conseil : une fois connecté à votre espace membre, changez votre mot de passe ";
	$Body .= "\n";
	$Body .= "A très bientôt sur : ";
	$Body .= htmlspecialchars( $this->siteOwner() );
	$Body .= "\n";
	$Body .= "__________________";
	$Body .= "\n";
	$Body .= "Ceci est un email automatique. ";
	$Body .= "\n";
	$Body .= "Pour toutes questions, utilisez le formulaire en ligne. ";
	$Body .= "\n";
	$Body .= " Aucune demande n'est traitée via cet email" ;
	$Body .= "\n";
/*	
	if(  mail($EmailTo, $Subject, $Body, "From:".$from ) ){
		$succesMail = true ;
	} else {
		$succesMail = false ;
	}
	
	return $succesMail ;
*/	
	
	//die(  (string)$Body    );
	return true ;
}


  
}