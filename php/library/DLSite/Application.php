<?php
namespace DLSite;

abstract class Application 
{
  protected $httpRequest;
  protected $httpResponse;
  protected $user;
  protected $config;
  protected $name;
  protected $route =[];

  public function __construct()
  {
   $this->httpRequest = new HTTPRequest($this);
   $this->httpResponse = new HTTPResponse($this);
   $this->user = new User($this);
   $this->config = new Config($this);
 
    $this->name = '';
  
    
  }
  
 public function getController()
  {

    $xml = new \DOMDocument;

    $xml->load(__DIR__.'/../../App/'.$this->name.'/routes.xml');
   

   $routes = $xml->getElementsByTagName('route');
  

  
    // On parcourt les routes du fichier XML.
    foreach ($routes as $route)
    { 
      
      $routeUrl = $route->getAttribute('url');
      $url = $this->httpRequest->requestURI();

       if (preg_match('`^'.$routeUrl.'$`', $url, $matches))
        {

            // On regarde si des variables sont présentes dans l'URL.
            if ($route->hasAttribute('vars'))
            {

                $vars = [];
                $listVars =[];

                $vars = explode(',', $route->getAttribute('vars'));

               // fait un tabeau des éléments capturés dans l'ordre. Ils corespondent aux éléments de vars
                foreach ($matches as $key => $match)
                {
                  // La première valeur contient entièrement la chaine capturée 
                  if ($key !== 0)
                  {
                    $listVars[$vars[$key - 1]] = $match;
                  }
                }

                // On ajoute les variables de l'URL au tableau $_GET.
                $_GET = array_merge($_GET, $listVars);
            } 
             
 
            $controllerClass = 'App\\'.$this->name.'\\Modules\\'.$route->getAttribute('module').'\\'.$route->getAttribute('module').'Controller';
 
            return new $controllerClass($this, $route->getAttribute('module'), $route->getAttribute('action'));
       }
   
   }
  
    $this->httpResponse->redirect404();

  }













  abstract public function run();
  
 



  public function config()
  {
    return $this->config;
  }

  public function user()
  {
    return $this->user;
  }

  public function httpRequest()
  {
    return $this->httpRequest;
  }
  
  public function httpResponse()
  {
    return $this->httpResponse;
  }
  
  public function route()
  {
    return $this->route;
  }

  public function name()
  {
    return $this->name;
  }

  
}