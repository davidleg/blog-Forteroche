<?php
namespace App\Frontend;

use \DLSite\Application;

class FrontendApplication extends Application
{
 
 
 public function __construct()
  {
    parent::__construct();

    $this->name = 'Frontend';
  }


   public function run()
  {

        $controller = $this->getController();
    

      if( preg_match('`^ajax`', $controller->action() )  )
      {
           $controller->execute();
      }
      else {
        $controller->execute();
        $this->httpResponse->setPage($controller->page());
        $this->httpResponse->send();
      }


/*

        $controller->execute();
        $this->httpResponse->setPage($controller->page());
        $this->httpResponse->send();
*/    

  }
  
}