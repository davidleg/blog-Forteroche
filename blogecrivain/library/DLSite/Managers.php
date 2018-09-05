<?php
namespace DLSite;

class Managers
{
  protected $api = null;
  protected $dao = null;
  protected $managers = [];

  public function __construct($api, $dao)
  {
    $this->api = $api;
    $this->dao = $dao;
  }

  public function getManagerOf($module)
  {
     if (!is_string($module) || empty($module))
      {
        throw new \InvalidArgumentException('Le module spécifié est invalide');
      }

      // si le modulePDO n'est pas déjà défini
      if (!isset($this->managers[$module]))
      {
       
        // on selectionnne le modulePDO
        $manager = '\\Model\\'.$module.'Manager'.$this->api;

        // on lui passe l'objet connexion et on stocke 
        $this->managers[$module] = new $manager($this->dao);
     
      }

      return $this->managers[$module];

  }




}