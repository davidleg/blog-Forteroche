<?php
namespace Model;

use \Entity\Users;

class UsersManagerPDO 
{

    protected $dao;
  
    public function __construct($dao)
   {
       $this->dao = $dao;
   }


	public function getLevel($email) 
	{
		$requete = $this->dao->prepare('SELECT * FROM blog_users WHERE email = :email');  
	    $requete->bindValue(':email', $email );
	    $usersLogArray='';

		if ( false == $requete->execute() ) 
		{ 	
			//trigger_error( " Désolé un problème de serveur de BDD Users-getLevel empêche une partie du //script de s'éxécuter, merci ", E_USER_WARNING);
			return $usersLogArray ;
		}
		
	    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Users');
	    
	    $usersLogArray = $requete->fetch();
	    $requete->closeCursor();
	    
	    return $usersLogArray ;
		
	}

	public function saveNewPass( $email, $pass )
	{

		$password = password_hash( $pass ,PASSWORD_DEFAULT );

		$reque = $this->dao->prepare('UPDATE blog_users SET password = :password WHERE email = :email');
		$reque->bindValue(':password', $password );
		$reque->bindValue(':email', (string)$email );
		
		if ( false == $reque->execute() ) 
		{ 
			//trigger_error( " Désolé un problème de serveur BDD empêche l'insertion du nouveau , merci ", E_USER_WARNING);
			return false ;
		}
		
		return true ;
	  
  	}

 
  public function getList()
  {
    $sql = 'SELECT id, pseudos, password, email, status, indate FROM blog_users' ;
    
    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Users');
    
    $listeUsers = $requete->fetchAll();
    
    foreach ($listeUsers as $users)
    {
      $users->setInDate(new \DateTime($users->indate()));
    }
    
    $requete->closeCursor();
    
    return $listeUsers;
  }

 
  public function getUnique($id)
  {

   $requete = $this->dao->prepare('SELECT id, pseudos, password, email, status, indate FROM blog_users WHERE id = :id');
    $requete->bindValue(':id', $id, \PDO::PARAM_INT);
    $requete->execute();
    
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Users');
    
    if ($users = $requete->fetch())
    {
      $users->setIndate(new \DateTime($users->indate()));
      return $users;
    }
    
    return null;
  }
  
  

  public function save(Users $users)
  {
   
   if ( $users->password() != "" ){
   		$password = password_hash(  $users->password() ,PASSWORD_DEFAULT );

   		$requete = $this->dao->prepare('UPDATE blog_users SET pseudos = :pseudos, email = :email, password = :password WHERE id = :id');

   		$requete->bindValue(':password', $password );
   
    }else{
    	$requete = $this->dao->prepare('UPDATE blog_users SET pseudos = :pseudos, email = :email  WHERE id = :id');
 
    }
   		$requete->bindValue(':pseudos', $users->pseudos() );
   		$requete->bindValue(':email', $users->email() );
   	 	$requete->bindValue(':id', $users->id(), \PDO::PARAM_INT);
    
    $requete->execute();

  }
  

  
}