<?php
namespace DLSite;

class HTTPResponse extends ApplicationComponent
{
  protected $page;

  public function addHeader($header)
  {
    header($header);
  }

  public function redirect($location)
  {
    header('Location: '.$location);
    exit;
  }

  public function noCacheRedirect($location)
  {
    header('Pragma: no-cache');
    header('Expires: Sat, 26 Jul 2009 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D,d M Y H:i:s') . 'GMT');
    header('Cache-Control: no-cache,must-revalidate');
    header('Location: '.$location);
    exit;
  }
  
 public function redirect404()
  {
    $this->page = new Page($this->app);
    $this->page->setContentFile(__DIR__.'/../../Errors/404.html');
    
    $this->addHeader('HTTP/1.0 404 Not Found');
    
    $this->send();
  }




  public function send()
  {
    // Actuellement, cette ligne a peu de sens dans votre esprit.
    // Promis, vous saurez vraiment ce qu'elle fait d'ici la fin du chapitre
    // (bien que je suis sûr que les noms choisis sont assez explicites !).
    exit($this->page->getGeneratedPage());
  }

  public function setPage(Page $page)
  {
    $this->page = $page;
  }

  // Changement par rapport à la fonction setcookie() : le dernier argument est par défaut à true
  public function setCookie($name, $value = '', $expire = 0, $path = null, $domain = null, $secure = false, $httpOnly = true)
  {
    setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
  }
}