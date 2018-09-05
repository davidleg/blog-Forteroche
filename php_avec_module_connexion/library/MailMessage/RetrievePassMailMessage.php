<?php
namespace MailMessage;

use \DLSite\MailMessage;

class RetrievePassMailMessage extends MailMessage
{
	
  Protected $pass = "";
 
  public function __construct($siteOwner, $mailOwner, $idTo, $mailTo, $nameTo )
  {
    parent::__construct($siteOwner, $mailOwner, $idTo, $mailTo, $nameTo) ;
	$lien = md5(microtime(TRUE)*1000);
	$this->setLienMail($lien);
	
  }

 
 public function envoiMail()
 {
	$value = $this->randChars("1234567890", 8, TRUE ) ;
	$this->setPass( (string)$value)  ;
	
	$from    = htmlspecialchars($this->mailOwner() ) ;
	$EmailTo = htmlspecialchars($this->mailTo() ) ;
	$Subject = 'Votre nouveau mot de passe' ; ;
	
	$Body  = "";
	$Body .= "Bonjour  ";
	$Body .= htmlspecialchars( $this->nameTo() );
	$Body .= "\n";
	$Body .= "Merci d'avoir choisi ";
	$Body .= htmlspecialchars( $this->siteOwner() );
	$Body .= "\n";
    $Body .= "Vous avez choisi de réinitialiser votre mot de passe. ";
	$Body .= "\n";
	$Body .= "votre nouveau mot de passe à 8 chiffres est :";
	$Body .= "\n";
	$Body .= $value;
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
	
	if(  mail($EmailTo, $Subject, $Body, "From:".$from ) ){
		$succesMail = true ;
	} else {
		$succesMail = false ;
	}
	return $succesMail ;
}

 
public function setPass($string)
{
	$this->pass = $string ;
}
public function pass()
{
	return $this->pass ;
}

  
}