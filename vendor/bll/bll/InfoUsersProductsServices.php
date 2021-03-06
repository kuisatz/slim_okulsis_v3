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
class InfoUsersProductsServices extends \BLL\BLLSlim {

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
        $DAL = $this->slimApp->getDALManager()->get('infoUsersProductsServicesPDO');
        return $DAL->insert($params);
    }

    /**
     * Check Data function
     * @param array | null $params
     * @return array
     */
    public function haveRecords($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('infoUsersProductsServicesPDO');
        return $DAL->haveRecords($params);
    }

    /**
     * Data update function
     * @param array | null $params
     * @return array
     */
    public function update($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('infoUsersProductsServicesPDO');
        return $DAL->update($params);
    }

    /**
     * Data delete function
     * @param array | null $params
     * @return array
     */
    public function delete($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('infoUsersProductsServicesPDO');
        return $DAL->delete($params);
    }

    /**
     * get all data
     * @param array | null $params
     * @return array
     */
    public function getAll($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('infoUsersProductsServicesPDO');
        return $DAL->getAll($params);
    }

    /**
     * Function to fill datagrid on user interface layer
     * @param array | null $params
     * @return array
     */
    public function fillGrid($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('infoUsersProductsServicesPDO');
        $resultSet = $DAL->fillGrid($params);
        return $resultSet['resultSet'];
    }

    /**
     * Function to get datagrid row count on user interface layer
     * @param array | null $params
     * @return array
     */
    public function fillGridRowTotalCount($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('infoUsersProductsServicesPDO');
        $resultSet = $DAL->fillGridRowTotalCount($params);
        return $resultSet['resultSet'];
    }

    /**
     * Data delete action function
     * @param array | null $params
     * @return array
     */
    public function deletedAct($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('infoUsersProductsServicesPDO');
        return $DAL->deletedAct($params);
    }

    /**
     * public key / private key and value update function
     * @param array | null $params
     * @return array
     */
    public function makeActiveOrPassive($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('infoUsersProductsServicesPDO');
        return $DAL->makeActiveOrPassive($params);
    }

    /**
     * Data update function   
     * @param array $params
     * @return array
     */
    public function fillUserProductsServicesNpk($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('infoUsersProductsServicesPDO');
        $resultSet = $DAL->fillUserProductsServicesNpk($params);
        return $resultSet['resultSet'];
    }

    /**
     * Function to get datagrid row count on user interface layer
     * @param array | null $params
     * @return array
     */
    public function fillUserProductsServicesNpkRtc($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('infoUsersProductsServicesPDO');
        $resultSet = $DAL->fillUserProductsServicesNpkRtc($params);
        return $resultSet['resultSet'];
    }

    /**
     * Data update function   
     * @param array $params
     * @return array
     */
    public function fillUserProductsServicesNpkQuest($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('infoUsersProductsServicesPDO');
        $resultSet = $DAL->fillUserProductsServicesNpkQuest($params);    
        return $resultSet['resultSet'];         
    }

    /**
     * Function to get datagrid row count on user interface layer
     * @param array | null $params
     * @return array
     */
    public function fillUserProductsServicesNpkQuestRtc($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('infoUsersProductsServicesPDO');
        $resultSet = $DAL->fillUserProductsServicesNpkQuestRtc($params);
        return $resultSet['resultSet'];
    }

}
