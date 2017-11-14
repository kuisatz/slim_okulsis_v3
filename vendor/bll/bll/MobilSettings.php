<?php
/**
 *  Framework 
 *
 * @link       
 * @copyright Copyright (c) 2017
 * @license   
 */

namespace BLL\BLL;

/**
 * Business Layer class for report Configuration entity
 */
class MobilSettings extends \BLL\BLLSlim{
    
    /**
     * constructor
     */
    public function __construct() {
        //parent::__construct();
    }
    
    /**
     * DAta insert function
     * @param array | null $params
     * @return array
     */
    public function insert($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('mobilSettingsPDO');
        return $DAL->insert($params);
    }
    
    /**
     * Data update function
     * @param array | null $params
     * @return array
     */
    public function update($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('mobilSettingsPDO');
        return $DAL->update($params);
    }
    
    /**
     * Data delete function
     * @param array | null $params
     * @return array
     */
    public function delete($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('mobilSettingsPDO');
        return $DAL->delete($params);
    }

    /**
     * get all data
     * @param array | null $params
     * @return array
     */
    public function getAll($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('mobilSettingsPDO');
        return $DAL->getAll($params);
    }
    
    
   
    
    public function gnlKullaniciMebKoduFindByTcKimlikNo($params = array()) {
 
        $DAL = $this->slimApp->getDALManager()->get('mobilSettingsPDO');
        $resultSet = $DAL->gnlKullaniciMebKoduFindByTcKimlikNo($params);  
        return $resultSet['resultSet'];
    }
 
    
    public function gnlKullaniciFindForLoginByTcKimlikNo($params = array()) {

    $DAL = $this->slimApp->getDALManager()->get('mobilSettingsPDO');
    $resultSet = $DAL->gnlKullaniciFindForLoginByTcKimlikNo($params);  
    return $resultSet['resultSet'];
    }
 
     
 
   /* public function mobilfirstdata($params = array()) {
    $DAL = $this->slimApp->getDALManager()->get('mobilSettingsPDO');
    return $DAL->mobilfirstdata($params);
   
    }
    */ 
    
    public function mobilUrlData($params = array()) {
    $DAL = $this->slimApp->getDALManager()->get('mobilSettingsPDO');
    $resultSet = $DAL->mobilUrlData($params);  
    return $resultSet['resultSet'];
    }
   
    /**
     * Function to get datagrid row count on user interface layer
     * @param array | null $params
        * pk zorunlu 
     * @return array
     */
    public function mobilwsdl($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('mobilSettingsPDO');
        $resultSet = $DAL->mobilwsdl($params);  
        return $resultSet['resultSet'];
    }
    
    
       /**
     * Function to get datagrid row count on user interface layer
     * @param array | null $params
        * pk zorunlu 
     * @return array
     */
    public function gnlKisiOkulListesix($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('mobilSettingsPDO');
        $resultSet = $DAL->gnlKisiOkulListesi($params);  
        return $resultSet['resultSet'];
    }
    /**
     * Function to get datagrid row count on user interface layer
     * @param array | null $params 
     * @return array
     */
    public function ogretmenDersProgramix($params = array()) {
    $DAL = $this->slimApp->getDALManager()->get('mobilSettingsPDO');
    $resultSet = $DAL->ogretmenDersProgrami($params);  
    return $resultSet['resultSet'];
    }
    
   
}

