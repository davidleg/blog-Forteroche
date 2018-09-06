<?php
namespace DLSite;

abstract class MailMessage
{
 
  protected $siteOwner;
  protected $mailOwner; 
  
  protected $idTo;
  protected $mailTo ;
  protected $nameTo;
  
  protected $lienMail;
	
  public function __construct($siteOwner, $mailOwner, $idTo, $mailTo, $nameTo )
  {

	  $this->setSiteOwner($siteOwner);
    $this->setMailOwner($mailOwner);
	  $this->setIdTo($idTo);
	  $this->setMailTo($mailTo);
	  $this->setNameTo($nameTo);
	
   	$lienMail ='';
	
  }



 abstract public function envoiMail() ;




 public function randChars($c, $l, $u = FALSE) 
{ 
	if (!$u) for ($s = '', $i = 0, $z = strlen($c)-1; $i < $l; $x = rand(0,$z), $s .= $c{$x}, $i++); 
	else for ($i = 0, $z = strlen($c)-1, $s = $c{rand(0,$z)}, $i = 1; $i != $l; $x = rand(0,$z), $s .= $c{$x}, $s = ($s{$i} == $s{$i-1} ? substr($s,0,-1) : $s), $i=strlen($s)); 
	return $s; 
} 

// SETTERS
	public function setSiteOwner($siteOwner)
  {
    $this->siteOwner = $siteOwner;
  }
	public function setMailOwner($mailOwner)
  {
    $this->mailOwner = $mailOwner;
  } 
 
   	public function setIdTo($idTo)
  {
    $this->idTo = $idTo;
  }
    public function setMailTo($mailTo)
  {
    $this->mailTo = $mailTo;
  }
    public function setNameTo($nameTo)
  {
    $this->nameTo = $nameTo;
  }
  
	public function setLienMail($lienMail)
  {
    $this->lienMail = $lienMail;
  } 
  
  
 // GETTERS
	public function siteOwner()
  {
    return $this->siteOwner;
  }
	public function mailOwner()
  {
    return $this->mailOwner;
  } 
  	
   	public function idTo()
  {
    return $this->idTo;
  }
    public function mailTo()
  {
    return $this->mailTo;
  }
    public function nameTo()
  {
    return $this->nameTo;
  }
  
   public function lienMail()
  {
    return $this->lienMail;
  }
  
}