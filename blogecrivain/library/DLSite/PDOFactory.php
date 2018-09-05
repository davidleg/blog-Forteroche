<?php
namespace DLSite;

class PDOFactory
{
  public static function getMysqlConnexion()
  {
    $db = new \PDO('mysql:host=myportfofg352.mysql.db;dbname=myportfofg352', 'myportfofg352', '3TBZPP73tbzpp7');
    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    
   return $db;
  }
}