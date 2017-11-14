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
     * @ login olan userin okul bilgileri ve okul id leri   !!
     * @version v 1.0  20.10.2017
     * @param array | null $args
     * @return array
     * @throws \PDOException
     */
    public function mobilwsdl($params = array()) {
      
        ini_set("soap.wsdl_cache_enabled", "0");
        $client = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");
        
        $_POST['tckimlikno'] *= 1; // Gönderilen talepte TC Kimlik Numarası integer olmalı.
        try {
            $requestData = array(// Formdan gelen değerler
                "TCKimlikNo" => $_POST['tckimlikno'],
                "Ad" => $_POST['ad'],
                "Soyad" => $_POST['soyad'],
                "DogumYili" => $_POST['dogumyili']
            );
            $result = $client->TCKimlikNoDogrula($requestData);
          
            
            if ($result->TCKimlikNoDogrulaResult) {
                echo "TC Kimlik Numarası Geçerli";
            } else {
                echo "TC Kimlik Numarası Hatalı";
            }
        } catch (Exception $ex) {
            echo $ex->faultstring;
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
