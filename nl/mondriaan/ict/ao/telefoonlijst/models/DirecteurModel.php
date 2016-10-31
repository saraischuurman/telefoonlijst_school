<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models;

/**
 * Description of DirecteurModel
 *
 * @author KOOH02
 */
class DirecteurModel 
{
    private $action;
    private $control;
    private $db;
            
    public function __construct( $control, $action)// vanuit bezoekercontroller wordt het recht opgehaald en automatisch ingevuld
    {
        $this->action = $action;
        $this->control = $control;
        $this->db = new \PDO(DATA_SOURCE_NAME,DB_USERNAME,DB_PASSWORD);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        $this->startSession();
    }
    
    public function isGerechtigd()
    {
        if(isset($_SESSION['gebruiker']) && !empty($_SESSION['gebruiker']))
        {
            $gebruiker = $_SESSION['gebruiker'];
            if($gebruiker->getRecht() ==='directeur')
            {
                return true;
            }
            else 
            {
                return false;
            }
        }
    }
    public function uitloggen()
    {
        $_SESSION = array();
        session_destroy();
    }
    public function getGebruiker()
    {
        if(isset($_SESSION))
        {
            return $_SESSION['gebruiker'];
        }
    }
    private function startSession()
    {
        if(!isset($_SESSION))
        {
           session_start(); 
        }
    }
    public function getContacten()
    {
        $sql = 'SELECT `contacten`.*, `afdelingen`.`naam` AS afdelings_naam, `afdelingen`.`afkorting` '
                . 'AS afdelings_afkorting FROM `contacten`, `afdelingen` '
                . 'WHERE `contacten`.`recht`=\'medewerker\' '
                . 'AND `afdelingen`.`id`=`contacten`.`afdelings_id` '
                . 'ORDER BY afdelings_afkorting DESC, achternaam ASC';
        
        try
        {
            $stmnt = $this->db->prepare($sql);
            $stmnt->execute();
            if(count($stmnt)===1)
            {
                $contacten = $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__.'\db\COntact');
                return $contacten;
            }
            return  REQUEST_FAILURE_DATA_INVALID;
        } 
        catch (PDOException $ex) 
        {
            return  REQUEST_FAILURE_DATA_INVALID;
        }
   
        
    }
    public function getAfdelingen()
    {
        $sql = 'SELECT * FROM `afdelingen` ORDER BY afkorting ASC';
        $stmnt = $this->db->prepare($sql);
        $stmnt->execute();
        $afdelingen = $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__.'\db\Afdeling');
        return $afdelingen;
        
    }
}
