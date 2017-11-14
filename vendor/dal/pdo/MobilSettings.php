<?php

/**
 *  Framework 
 *
 * @link       
 * @copyright Copyright (c) 2017
 * @license   
 */

namespace DAL\PDO;
require_once('SOAP/Client.php');
/**
 * Class using Zend\ServiceManager\FactoryInterface
 * created to be used by DAL MAnager
 * @
 * @author Okan CIRAN
 */
class MobilSettings extends \DAL\DalSlim {

    /**     
     * @author Okan CIRAN 
     * @version v 1.0  20.10.2017
     * @param array | null $args
     * @return array
     * @throws \PDOException
     */
    public function delete($params = array()) {
        try {             
        } catch (\PDOException $e /* Exception $e */) {             
        }
    }

    /** 
     * @author Okan CIRAN 
     * @version v 1.0  20.10.2017  
     * @param array | null $args  
     * @return array
     * @throws \PDOException
     */
    public function getAll($params = array()) {
        try { 
        } catch (\PDOException $e /* Exception $e */) {   
        }
    }

    /** 
     * @author Okan CIRAN 
     * @version v 1.0  20.10.2017
     * @return array
     * @throws \PDOException
     */
    public function insert($params = array()) {
        try { 
        } catch (\PDOException $e /* Exception $e */) { 
        }
    }

    /** 
     * @author Okan CIRAN 
     * @version v 1.0  20.10.2017
     * @param array | null $args  
     * @return array
     * @throws \PDOException
     */
    public function update($params = array()) {
        try { 
        } catch (\PDOException $e /* Exception $e */) { 
        }
    }
    
    /** 
     * @author Okan CIRAN
     * @ login olan userin rol bilgileri ve okul id leri   !!
     * @version v 1.0  20.10.2017
     * @param array | null $args
     * @return array
     * @throws \PDOException
     */
    public function gnlKisiTumRollerFindByID1($params = array()) {
        try {
            $pdo = $this->slimApp->getServiceManager()->get('pgConnectFactory'); 
            $sql = "   
                DECLARE @return_value int;

                EXEC @return_value = [dbo].[PRC_GNL_Kisi_TumRoller_FindByID]
                    @KisiID =  '".$params['kisiId']."' ;

                SELECT  
                    null as KisiID , 
                    'LUTFEN SEÇİNİZ...' as adsoyad,
                    '' as [TCKimlikNo]  

                union 
                SELECT 'Return Value' = @return_value;
 
                 "; 
            $statement = $pdo->prepare($sql);            
         //echo debugPDO($sql, $params);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $errorInfo = $statement->errorInfo();
            if ($errorInfo[0] != "00000" && $errorInfo[1] != NULL && $errorInfo[2] != NULL)
                throw new \PDOException($errorInfo[0]);
            return array("found" => true, "errorInfo" => $errorInfo, "resultSet" => $result);
        } catch (\PDOException $e /* Exception $e */) {    
            return array("found" => false, "errorInfo" => $e->getMessage());
        }
    }
  
    /** 
     * @author Okan CIRAN
     * @ login olan userin okul bilgileri ve okul id leri   !!
     * @version v 1.0  20.10.2017
     * @param array | null $args
     * @return array
     * @throws \PDOException
     */
    public function mobilUrlData($params = array()) {
        try {
            $pdo = $this->slimApp->getServiceManager()->get('pgConnectFactoryMobil'); 
            $sql = "  
            SET NOCOUNT ON; 
            SELECT * FROM (       
                SELECT   
                    -1 AS id , 
                    NULL AS [proxy],
                    NULL AS [logo],
                    'LÜTFEN SEÇİNİZ !' AS [abbrevation],
                    NULL AS [schoolName] ,
                    NULL AS combologo
                     
                UNION   

                SELECT   
                    id,
                    [proxy],
                    [logo],
                    [abbrevation],
                    [schoolName],
                    combologo
                FROM  BILSANET_MOBILE.[dbo].[Mobil_Settings]
                WHERE active =0 AND deleted =0 
                ) as ssss 
            ORDER BY id 
            SET NOCOUNT OFF; 
                 "; 
            $statement = $pdo->prepare($sql);   
   //  echo debugPDO($sql, $params);
            $statement->execute(); 
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $errorInfo = $statement->errorInfo();
            if ($errorInfo[0] != "00000" && $errorInfo[1] != NULL && $errorInfo[2] != NULL)
                throw new \PDOException($errorInfo[0]);
            return array("found" => true, "errorInfo" => $errorInfo, "resultSet" => $result);
        } catch (\PDOException $e /* Exception $e */) {    
            return array("found" => false, "errorInfo" => $e->getMessage());
        }
    }
    
    /** 
     * @author Okan CIRAN
     * @ wsdl den EncryptPassword  !!
     * @version v 1.0  20.10.2017
     * @param array | null $args
     * @return array
     * @throws \PDOException
     */
    public function mobilwsdlEncryptPassword($params = array()) {
       try {
        $client = new \Zend\Soap\Client("http://ws.okulsis.net/MobileLogin.asmx?wsdl");
       
        $PswrD='-1111111111111111111111111';
            if ((isset($params['PswrD']) && $params['PswrD'] != "")) {           
                $PswrD = $params['PswrD'];               
            }
    
        $result = $client-> EncryptPassword( array('key' => '193+pMXyM+m9NA8OykD8ZrqY+0noc+t3zz8x8t3BcvkI=',
                            'password' => $PswrD, 'array' => array(1,2)) );
         
       $key = $result->EncryptPasswordResult ; 
     
       return array("found" => true,  "resultSet" => $key);
            
            if ($result->EncryptPasswordResult) {
             //   echo "TC Kimlik Numarası Gecerli";
            } else {
             //   echo "TC Kimlik Numarası Hatalı";
            }
        } catch (Exception $ex) {
              $ex->faultstring;
        }
    }

        /** 
     * @author Okan CIRAN
     * @ wsdl den EncryptPassword  !!
     * @version v 1.0  20.10.2017
     * @param array | null $args
     * @return array
     * @throws \PDOException
     */
    public function mobilwsdlDecryptPassword($params = array()) {
       try {
        $client = new \Zend\Soap\Client("http://ws.okulsis.net/MobileLogin.asmx?wsdl");
       
        $PswrD='-1111111111111111111111111';
            if ((isset($params['PswrD']) && $params['PswrD'] != "")) {           
                $PswrD = $params['PswrD'];               
            }
    
        $result = $client-> DecryptPassword( array('key' => '193+pMXyM+m9NA8OykD8ZrqY+0noc+t3zz8x8t3BcvkI=',
                            'password' => $PswrD, 'array' => array(1,2)) );
         
       $key = $result->DecryptPasswordResult ; 
     
       return array("found" => true,  "resultSet" => $key);
            
            if ($result->EncryptPasswordResult) {
             //   echo "TC Kimlik Numarası Gecerli";
            } else {
             //   echo "TC Kimlik Numarası Hatalı";
            }
        } catch (Exception $ex) {
              $ex->faultstring;
        }
    }

    /** 
     * @author Okan CIRAN
     * @ login olan userin menusunu dondurur  !!
     * @version v 1.0  27.10.2017
     * @param array | null $args
     * @return array
     * @throws \PDOException
     */
    public function mobilMenu1($params = array()) {
        try {
            $pdo = $this->slimApp->getServiceManager()->get('pgConnectFactory'); 
            $parent=0;
            if ((isset($params['ParentID']) && $params['ParentID'] != "")) {           
                $parent = $params['ParentID'];               
            }
            
            $sql = "   
                   SELECT [ID]
                        ,[MenuID]
                        ,[ParentID]
                        ,[MenuAdi]
                        ,[Aciklama]
                        ,[URL]
                        ,[RolID]
                        ,[SubDivision] 
                        ,[ImageURL] 
                        ,[divid] 
                    FROM [dbo].[GNL_Mobil_Menuleri]
                    where active = 0 AND deleted = 0 AND 
                        [RolID] = ".intval($params['RolID'])."  
                       /* AND [ParentID] = ".intval($parent)." */
                    order by MenuID
                 "; 
            $statement = $pdo->prepare($sql);            
     //   echo debugPDO($sql, $params);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $errorInfo = $statement->errorInfo();
            if ($errorInfo[0] != "00000" && $errorInfo[1] != NULL && $errorInfo[2] != NULL)
                throw new \PDOException($errorInfo[0]);
            return array("found" => true, "errorInfo" => $errorInfo, "resultSet" => $result);
        } catch (\PDOException $e /* Exception $e */) {    
            return array("found" => false, "errorInfo" => $e->getMessage());
        }
    }
    
  
   
  
  
}
