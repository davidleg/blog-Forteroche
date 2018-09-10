<?php
namespace App\Backend;

use \DLSite\Application;

class BackendApplication extends Application
{
  

  public function __construct()
  {
    parent::__construct();

    $this->name = 'Backend';
  }

  public function run()
  {
   
    if ($this->user->isAuthenticated())
    {
      
      $controller = $this->getController();
    }
   else
    {
      $controller = new Modules\Connexion\ConnexionController($this, 'Connexion', 'index');
      
    }

    if( preg_match('`^ajax`', $controller->action() )  )
    {
         $controller->execute();
    }
    else {
      $controller->execute();
      $this->httpResponse->setPage($controller->page());
      $this->httpResponse->send();
    }



  }


}