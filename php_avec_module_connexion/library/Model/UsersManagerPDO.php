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


	public function getLevel($email) // ok connexion retrieve pass
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






/*
 protected function add(Users $users) // plus utile
  {	
	$requete = $this->dao->prepare('SELECT email FROM users WHERE email = :email');
    $requete->bindValue(':email', $users->email());
    $requete->execute();
	$email = $requete->fetch() ;
   
    if ( empty($email) ) 
	{ 
	  
		$requet = $this->dao->prepare('INSERT INTO users SET email = :email, indate = NOW(), outdate = NOW()');
		$requet->bindValue(':email', $users->email());
		$requet->execute();
		
		$idUser = $this->dao->lastInsertId();
		$_SESSION['use'] = $idUser ;
		
		return true;
   
    }
	else
	{
		return false ;
	}
  }
  */
 /* 
   public function getPseudos() // affiche les pseuods déjà pris ajax,  inscription etape 2
  {	
	$requete = $this->dao->prepare('SELECT pseudos FROM users');
  
    $requete->execute();
	
	$pseudos = Array() ;
	$i=0;
	while($a = $requete->fetch(\PDO::FETCH_ASSOC) ) 
	{
		$pseudos[$i] = $a['pseudos'];
		$i++;
	}
    $requete->closeCursor();
	return $pseudos ;
   
  }
 */
  /*
  protected function newPseudo(Users $users) // nécessité de verifier car l'ajax affiche les pseudos déjà pris mais n'oblige pas de ne pas les prendre, inscription etape 2
  {	
	$this->dao->beginTransaction();
	
	$requete = $this->dao->prepare('SELECT * FROM users WHERE pseudos = :pseudos FOR UPDATE' );
    $requete->bindValue(':pseudos', $users->pseudos());
	if ( false == $requete->execute() ) 
	{ 
		trigger_error( " Désolé un problème de serveur de BDD Users-newPseudo 1 empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
		$this->dao->rollBack();
		return false ;
	}
	$pseudon = $requete->fetch(\PDO::FETCH_ASSOC) ;
    $requete->closeCursor();
   
   if (  !empty($pseudon)  )
	{
		$this->dao->rollBack();
		return false;
	}
	elseif ( empty($pseudon) ) 
	{ 
		$idusers = (int)$_SESSION['usersId'] ;
		$requet = $this->dao->prepare('UPDATE users SET pseudos = :pseudos WHERE idusers = :idusers' );
		$requet->bindValue(':pseudos', $users->pseudos());
		$requet->bindValue(':idusers', $idusers );
		if ( false == $requet->execute() ) 
		{ 
			trigger_error( " Désolé un problème de serveur de BDD Users-newPseudo 2 empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
			$this->dao->rollBack();
			return false ;
		}
		$this->dao->commit();
		return true; 
	} 
  } 
*/
/*
   protected function addEtape2(Users $users)
  {
	if ( 	!empty( $_SESSION['mailTo']) && 
			!empty( $_SESSION['usersId']) && 
			!empty( $_SESSION['newP'] )  &&
			!empty( $_SESSION['genreSearchMember'] )  &&
			!empty( $_SESSION['ageSearchMember'] )     &&
			!empty( $_SESSION['regionSearchMember'] )   &&
			!empty( $_SESSION['relationSearchMember'] )   &&
			!empty( $_SESSION['orientationSearchMember'] ) 
			) // + motUsers, pseudo, slogan
	{ 
		$returned = [];
		
		$usersLid = $users->motUsers() ." avec ". $users->pseudos() ;
		$usersLid = preg_replace( '#\s\s+#', ' ',  $usersLid );
		$usersLid = preg_replace( '#[^a-zA-Z0-9éèêëÊËïîÎÏöôÖÔùûüÜÛàâäÄÂç!?-]#', '-',  $usersLid ); 
		$strToReplace = array("é", "è", "ë", "ê", "Ë", "Ê", "ï", "î", "Î", "Ï", "ö", "ô", "Ö", "Ô", "ù", "ü", "û", "Ü", "Û", "à", "â", "ä", "Â", "Ä", "ç" ) ;
		$strByReplace = array("e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "u", "u", "u", "u", "u", "a", "a", "a", "a", "a", "c" ) ;  
		$usersLid = str_replace($strToReplace, $strByReplace, $usersLid ) ; 
		
		$usersLid = ucFirst( strtolower($usersLid )   ) ;
		$password = password_hash( (string)$_SESSION['newP'] ,PASSWORD_DEFAULT );
		$status = 'attending' ;
		$idusers = (int)$_SESSION['usersId'] ;
		
		$this->dao->beginTransaction();
			
		$requete = $this->dao->prepare('UPDATE users SET lidusers = :lidusers, 
										motUsers = :motUsers, slogan= :slogan, 
										password = :password, indate = NOW(), outdate = NOW(), 
										status = :status WHERE idusers = :idusers' );
		$requete->bindValue(':lidusers', (string)$usersLid );
		$requete->bindValue(':motUsers', $users->motUsers());
		$requete->bindValue(':slogan', $users->slogan());
		$requete->bindValue(':password', (string)$password );
		$requete->bindValue(':status', (string)$status );
		$requete->bindValue(':idusers', $idusers );
		if ( false == $requete->execute())
		{ 
			$returned["prog"] = 'E22' ;
			trigger_error( " Désolé un problème de serveur de BDD Users-addEtape2 n°1 empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
			$this->dao->rollBack();
			return $returned ;
		}
		
		$requet = $this->dao->prepare('INSERT INTO searchmember SET idusersSearchMember = :idusersSearchMember, 
										genreSearchMember = :genreSearchMember, pseudoSearchMember = :pseudoSearchMember, 
										ageSearchMember = :ageSearchMember, regionSearchMember = :regionSearchMember, 
										relationSearchMember = :relationSearchMember, orientationSearchMember = :orientationSearchMember, 
										statusSearchMember = :statusSearchMember, indateSearchMember = NOW()');
		$requet->bindValue(':idusersSearchMember', (int)$idusers );
		$requet->bindValue(':genreSearchMember', (string)$_SESSION['genreSearchMember'] );
		$requet->bindValue(':pseudoSearchMember', (string)$users->pseudos() );
		$requet->bindValue(':ageSearchMember', (string)$_SESSION['ageSearchMember'] );
		$requet->bindValue(':regionSearchMember', (string)$_SESSION['regionSearchMember'] );
		$requet->bindValue(':relationSearchMember', (string)$_SESSION['relationSearchMember'] );	
		$requet->bindValue(':orientationSearchMember', (string)$_SESSION['orientationSearchMember'] );
		$requet->bindValue(':statusSearchMember', (string)$status );
		if ( false == $requet->execute())
		{ 
			$returned["prog"] = 'E23' ;
			trigger_error( " Désolé un problème de serveur de BDD Users-addEtape2 n°2 empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
			$this->dao->rollBack();
			return $returned ;
		}
	
		$reque = $this->dao->prepare('INSERT INTO pending SET idusersPending = :idusersPending, statusPending = :statusPending');
		$reque->bindValue(':idusersPending', (int)$idusers );
		$reque->bindValue(':statusPending', (string)$status );
		
		if ( false == $reque->execute())
		{ 
			$returned["prog"] = 'E24' ;
			trigger_error( " Désolé un problème de serveur de BDD Users-addEtape2 n°3 empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
			$this->dao->rollBack();
			return $returned ;
		}
		
		$returned["prog"] = 'ok' ;
		$returned["idusers"] = $idusers ;
		$returned["mailTo"]  = (string)$_SESSION['mailTo'];
		$returned["nameTo"]  = $users->pseudos() ;
		$returned["passTo"]  = (string)$_SESSION['newP'] ;
		$this->dao->commit();
	
	 }
	 else
	 {
		$returned["prog"] = "Mail21" ;
		trigger_error( " Désolé un problème de serveur de BDD Users-addEtape2 n°4 empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
	 }
	
	return $returned ;

  }
  */
  /*
  public function envoiValidationMailMessageTo($idusers, $sent, $status) 
  {
	$this->dao->beginTransaction();
	
	$requete = $this->dao->prepare('UPDATE pending SET sentPending = :sentPending, statusPending = :statusPending WHERE idusersPending = :idusersPending');
	$requete->bindValue(':sentPending', (string)$sent );
    $requete->bindValue(':statusPending', (string)$status );
	$requete->bindValue(':idusersPending', (int)$idusers );
	if ( false == $requete->execute() ) 
	{ 
		trigger_error( " Désolé un problème de serveur de BDD Users-envoiValidationMailMessage 1 empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
		$this->dao->rollBack();
		return false ;
	}
	
	$requete = $this->dao->prepare('UPDATE searchmember SET statusSearchMember = :statusSearchMember WHERE idusersSearchMember = :idusersSearchMember');
    $requete->bindValue(':statusSearchMember', (string)$status );
	$requete->bindValue(':idusersSearchMember', (int)$idusers );
	if ( false == $requete->execute() ) 
	{ 
		trigger_error( " Désolé un problème de serveur de BDD Users-envoiValidationMailMessage 2 empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
		$this->dao->rollBack();
		return false ;
	}
	
	$level = 2 ;
	$requete = $this->dao->prepare('UPDATE users SET level = :level WHERE idusers = :idusers');
	$requete->bindValue(':level', (int)$level );
	$requete->bindValue(':idusers', (int)$idusers );
	if ( false == $requete->execute() ) 
	{ 
		trigger_error( " Désolé un problème de serveur de BDD Users-envoiValidationMailMessage 3 empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
		$this->dao->rollBack();
		return false ;
	}
	$this->dao->commit();
	return true ;
 
 }
  */
 /*
  public function checkLienMailFrom($lienMail) 
  {
	$returned = 'ok' ;
	
	$requete = $this->dao->prepare('SELECT * FROM pending WHERE sentPending = :sentPending');
	$requete->bindValue(':sentPending', (string)$lienMail );
	if ( false == $requete->execute() ) 
	{ 
		$returned = 'P1' ; 
	}
	$pending = $requete->fetch(\PDO::FETCH_ASSOC) ;
    $requete->closeCursor();
	
    if ( empty($pending) ) 
	{
		$returned = 'P2';    
	} 
	else
	{	
		$time = time();
		$timePending = new \DateTime($pending['indatePending']);
		$timestampsPending = $timePending->getTimestamp();
		if( (int)$time > ((int)$timestampsPending + (60*60*25))  ) 
		{
			$returned = 'timeOut' ;	
		}
		$_SESSION['idusers'] = $pending['idusersPending'];  
		
	}
	
	return $returned ;
  }	
	*/
  /*
  public function deleteUsersLienMailTimeOut($idusers)
 {
	$this->dao->beginTransaction();
	$returned = 'ok';
	
	$requete = $this->dao->prepare('DELETE FROM pending WHERE idusersPending = :idusersPending');
	$requete->bindValue(':idusersPending', (int)$idusers );
	if ( false == $requete->execute() ) 
	{ 
		$returned = 'P21' ; 
		$this->dao->rollBack();
		return $returned ;
	}
    $requete->closeCursor();
	
	$requete = $this->dao->prepare('DELETE FROM searchmember WHERE idusersSearchMember = :idusersSearchMember');
	$requete->bindValue(':idusersSearchMember', (int)$idusers );
	if ( false == $requete->execute() ) 
	{ 
		$returned = 'P22' ; 
		$this->dao->rollBack();
		return $returned ;
	}
    $requete->closeCursor();
	
	$requete = $this->dao->prepare('DELETE FROM users WHERE idusers = :idusers');
	$requete->bindValue(':idusers', (int)$idusers );
	if ( false == $requete->execute() ) 
	{ 
		$returned = 'P23' ; 
		$this->dao->rollBack();
		return $returned ;
	}
    $requete->closeCursor();
	
	
	$this->dao->commit();
	return $returned ;
 }
  */
 /*
  public function validatingUsersLienMail($idusers)
  {
	$this->dao->beginTransaction();
	$returned = 'ok';
	
	$requete = $this->dao->prepare('DELETE FROM pending WHERE idusersPending = :idusersPending');
	$requete->bindValue(':idusersPending', (int)$idusers );
	if ( false == $requete->execute() ) 
	{ 
		$returned = 'V1' ; 
		$this->dao->rollBack();
		return $returned ;
	}
    $requete->closeCursor();

	
	$requete = $this->dao->prepare('UPDATE searchmember SET statusSearchMember = :statusSearchMember WHERE idusersSearchMember = :idusersSearchMember');
	$requete->bindValue(':statusSearchMember', 'validating' );
	$requete->bindValue(':idusersSearchMember', (int)$idusers );
	if ( false == $requete->execute() ) 
	{ 
		$returned = 'V2' ; 
		$this->dao->rollBack();
		return $returned ;
	}
    $requete->closeCursor();
	
	
	$level = '3' ;
	$requete = $this->dao->prepare('UPDATE users SET level = :level WHERE idusers = :idusers');
	$requete->bindValue(':level', (int)$level );
	$requete->bindValue(':idusers', (int)$idusers );
	if ( false == $requete->execute() ) 
	{ 
		$returned = 'V3' ; 
		$this->dao->rollBack();
		return $returned ;
	}
    $requete->closeCursor();
	
	
	$this->dao->commit();
	return $returned ;
 }
 */
 /*
    
 public function envoiRetrievePassMailMessage( $idusers, $lien, $pass  ) // ok connexionControlle nouveauPassConnexion mémorise en base le lien à valider à l'utilisateur dans son email
 {
	$returned = 'ok';
	$this->dao->beginTransaction();
	
	$reque = $this->dao->prepare('SELECT * FROM passretrieve WHERE idusersPassretrieve = :idusersPassretrieve  FOR UPDATE ');
	$reque->bindValue(':idusersPassretrieve', (string)$idusers );
	if ( false == $reque->execute() ) 
	{ 
		trigger_error( " Désolé un problème de serveur de BDD Users-envoiRetrievePassMailMessage 1 empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
		$this->dao->rollBack();
		return false ;
	}
	$a = $reque->fetch(\PDO::FETCH_ASSOC) ;
    $reque->closeCursor();
	
	if ( empty($a) ) 
	{
		$requete = $this->dao->prepare('INSERT INTO passretrieve SET idusersPassretrieve = :idusersPassretrieve, lienPassretrieve = :lienPassretrieve, indatePassretrieve = NOW() ');
		$requete->bindValue(':idusersPassretrieve', (string)$idusers );
		$requete->bindValue(':lienPassretrieve', (string)$lien );
		if ( false == $requete->execute() ) 
		{ 
			trigger_error( " Désolé un problème de serveur de BDD Users-envoiRetrievePassMailMessage 2 empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
			$this->dao->rollBack();
			return false ;
		}
		
		$password = password_hash( $pass ,PASSWORD_DEFAULT ); // remplace le mot de passe actuel par un nouveau provisoir inconnue de l'utilisateur, pour l'obliger à aller au bout
		$requet = $this->dao->prepare('UPDATE users SET password = :password WHERE idusers = :idusers');
		$requet->bindValue(':password', (string)$password );
		$requet->bindValue(':idusers', (string)$idusers );
		if ( false == $requet->execute() ) 
		{ 
			trigger_error( " Désolé un problème de serveur de BDD Users-envoiRetrievePassMailMessage 3 empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
			$this->dao->rollBack();
			return false ;
		}
	}
	else
	{
		$returned = "doublon" ;
	}
	$this->dao->commit();
	return $returned ;
 }
  */
 /*
 /*

  public function getPassRetrieve($lien) // ok connexionController getPassRetrieve, le user clique sur son lien mail
   {
    $this->dao->beginTransaction();

	$reque = $this->dao->prepare('SELECT * FROM passretrieve WHERE lienPassretrieve = :lienPassretrieve  FOR UPDATE ');
	$reque->bindValue(':lienPassretrieve', (string)$lien );
	if ( false == $reque->execute() ) 
	{ 
		trigger_error( " Désolé un problème de serveur de BDD Users-getPassRetrieve 1 empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
		$this->dao->rollBack();
		return false ;
	}
	$a = $reque->fetch(\PDO::FETCH_ASSOC) ;
    $reque->closeCursor();
	
	$time = time();
	$timePassRetrieve = new \DateTime( $a['indatePassretrieve']  );
	$timestampsPassRetrieve = $timePassRetrieve->getTimestamp();
	if( (int)$time > ((int)$timestampsPassRetrieve + (60*60*25))  ) 
	{
		$requet = $this->dao->prepare('DELETE FROM passretrieve WHERE lienPassretrieve = :lienPassretrieve');
		$requet->bindValue(':lienPassretrieve', (int)$lien );
		if ( false == $requet->execute() ) 
		{ 
			trigger_error( " Désolé un problème de serveur de BDD Users-getPassRetrieve 2 empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
			$this->dao->rollBack();
			return false ;
		}
		$returned = 'timeOut';
		return $returned ;
	}
	
	$returned = (string)$a['idusersPassretrieve'] ;
	$this->dao->commit();
	return $returned ;
	
   }
   
   */
   
   
  
  
  
  
  
  /*
  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM users')->fetchColumn();
  }

  public function delete($idusers)
  {
    $this->dao->exec('DELETE FROM users WHERE idusers = '.(int) $idusers);
  }

  //util
  public function getList($debut = -1, $limite = -1)
  {
    $sql = 'SELECT idusers, lidusers, motUsers, name, pseudos, password, email, level, indate, outdate FROM users ORDER BY idusers DESC';
    
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
    
    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Users');
    
    $listeUsers = $requete->fetchAll();
    
    foreach ($listeUsers as $users)
    {
      $users->setInDate(new \DateTime($users->indate()));
      $users->setOutDate(new \DateTime($users->outdate()));
    }
    
    $requete->closeCursor();
    
    return $listeUsers;
  }
*/

/*
  // util 
  public function getUnique($idusers)
  {
    $requete = $this->dao->prepare('SELECT idusers, lidusers, motUsers, name, pseudos, password, email, level, indate, outdate FROM users WHERE idusers = :idusers');
    $requete->bindValue(':idusers', (int) $idusers, \PDO::PARAM_INT);
    $requete->execute();
    
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Users');
    
    if ($users = $requete->fetch())
    {
      $users->setIndate(new \DateTime($users->indate()));
      $users->setOutdate(new \DateTime($users->outdate()));
      
      return $users;
    }
    
    return null;
  }
  */
  /*
  protected function modify(Users $users)
  {
   	$usersLid = $users->motUsers() ." avec ". $users->pseudo() ;
	$usersLid = preg_replace( '#\s\s+#', ' ',  $usersLid );
	$usersLid = preg_replace( '#[^a-zA-Z0-9éèêëÊËïîÎÏöôÖÔùûüÜÛàâäÄÂç!?-]#', '-',  $usersLid ); 
	$strToReplace = array("é", "è", "ë", "ê", "Ë", "Ê", "ï", "î", "Î", "Ï", "ö", "ô", "Ö", "Ô", "ù", "ü", "û", "Ü", "Û", "à", "â", "ä", "Â", "Ä", "ç" ) ;
	$strByReplace = array("e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "u", "u", "u", "u", "u", "a", "a", "a", "a", "a", "c" ) ;  
	$usersLid = str_replace($strToReplace, $strByReplace, $usersLid ) ; 
	$usersLid = ucFirst( strtolower($usersLid )   ) ;

   $password = password_hash(  $users->password() ,PASSWORD_DEFAULT );

    $requete = $this->dao->prepare('UPDATE users SET lidusers = :lidusers, motUsers = :motUsers, pseudos = :pseudos, password = :password, outdate = NOW() WHERE idusers = :idusers');
    $requete->bindValue(':lidusers', (string)$usersLid );
	$requete->bindValue(':motUsers', $users->motUsers());
    $requete->bindValue(':pseudos', $users->pseudos());
    $requete->bindValue(':password', $password );
    $requete->bindValue(':idusers', $users->idusers(), \PDO::PARAM_INT);
    
    $requete->execute();
  }
  */
 
/*
  public function ajaxGetMonProfil($q)
  {	

	$requete = $this->dao->prepare('SELECT a.motUsers, a.slogan, a.pseudos, a.email, 
										   b.genreSearchMember, b.ageSearchMember, b.relationSearchMember, b.orientationSearchMember, b.regionSearchMember, b.photoSearchMember, b.statusSearchMember
									FROM users a
									INNER JOIN searchmember b
										ON a.idusers = b.idusersSearchMember
									WHERE a.idusers = :idusers');
							
    $requete->bindValue(':idusers', (int)$q );
	$oneUser =[];
    if ( false == $requete->execute() ) 
	{ 	
		return $oneUser ;
	}
	$oneUser = $requete->fetch(\PDO::FETCH_ASSOC) ;
    $requete->closeCursor();

	return $oneUser ; 
	
/*	$p_idusers = 140;
	$requete = $this->dao->prepare('CALL one_user(?)' ) ;     // ??								
    $requete->bindParam(1, $p_idusers, \PDO::PARAM_INT );
  
    if ( false == $requete->execute() ) 
	{ 
		die ( "non") ;
	}
	$p_photo = $requete->fetch() ;
   die ( var_dump($p_photo )) ;
 */
   /*
  }
  */
  /*
   public function ajaxGetMesPhotosProfil($q)
  {	

	$requete = $this->dao->prepare('SELECT idUpload, nameUpload, titleUpload, descriptionUpload 	
									FROM upload 
									WHERE idusersUpload = :idusers');
							
    $requete->bindValue(':idusers', (int)$q );
	$userPhotos =[];
    if ( false == $requete->execute() ) 
	{ 	
		trigger_error( " Désolé un problème de serveur de BDD Users-ajaxGetMesPhotosProfil empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
		return $userPhotos ;
	}
	$userPhotos = $requete->fetchAll(\PDO::FETCH_ASSOC) ;
	return $userPhotos ; 
  }
  */
  /*
   public function modifierMonProfilPDO(Users $users)
  {
   
    $requete = $this->dao->prepare('UPDATE users SET slogan = :slogan, outdate = NOW() WHERE idusers = :idusers');
	$requete->bindValue(':slogan', $users->slogan());
    $requete->bindValue(':idusers', $_SESSION['idusers'], \PDO::PARAM_INT);
    if ( false == $requete->execute() ) 
	{ 
		trigger_error( " Désolé un problème de serveur de BDD Users-modifierMonProfilPDO empêche une partie du script de s'éxécuter, merci ", E_USER_WARNING);
		return false ;
	}
    $requete->closeCursor();
	return true ;
  }
  */
  
  
}