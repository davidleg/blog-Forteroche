<?php
namespace Entity;

use \DLSite\Entity;

class Users extends Entity
{
  protected $pseudos,
            $password,
			      $email,
			      $status,
            $indate;

  const PSEUDOS_INVALIDE = 2;
  const PASSWORD_INVALIDE = 3;
  const EMAIL_INVALIDE = 5;
  const STATUS_INVALIDE = 6;

  public function isValid()
  {
    return true ;
  }

  

  // SETTERS //
  public function setPseudos($pseudos)
  {
    if (!is_string($pseudos) || empty($pseudos))
    {
      $this->erreurs[] = self::PSEUDOS_INVALIDE;
    }

    $this->pseudos = $pseudos;
  }

  public function setPassword($password)
  {
    if (!is_string($password) || empty($password))
    {
      $this->erreurs[] = self::PASSWORD_INVALIDE;
    }

    $this->password = $password;
  }
  
  
  public function setEmail($email)
  {
    if (!is_string($email) || empty($email))
    {
      $this->erreurs[] = self::EMAIL_INVALIDE;
    }

    $this->email = $email;
  }
  
  
  
   public function setStatus($status)
  {
    if (!is_int($status) || empty($status))
    {
      $this->erreurs[] = self::STATUS_INVALIDE;
    }

    $this->status = $status;
  }
 

  public function setIndate(\DateTime $indate)
  {
    $this->indate = $indate;
  }



  // GETTERS //

  public function pseudos()
  {
    return $this->pseudos;
  }

  public function password()
  {
    return $this->password;
  }
  
   public function email()
  {
    return $this->email;
  }
 
  public function status()
  {
    return $this->status;
  }
  
  public function indate()
  {
    return $this->indate;
  }

}