<?php

// test commit for branch slim2
require 'vendor/autoload.php';


use \Services\Filter\Helper\FilterFactoryNames as stripChainers;

/* $app = new \Slim\Slim(array(
  'mode' => 'development',
  'debug' => true,
  'log.enabled' => true,
  )); */

$app = new \Slim\SlimExtended(array(
    'mode' => 'development',
    'debug' => true,
    'log.enabled' => true,
    'log.level' => \Slim\Log::INFO,
    'exceptions.rabbitMQ' => true,
    'exceptions.rabbitMQ.logging' => \Slim\SlimExtended::LOG_RABBITMQ_FILE,
    'exceptions.rabbitMQ.queue.name' => \Slim\SlimExtended::EXCEPTIONS_RABBITMQ_QUEUE_NAME
        ));
 
/**
 * "Cross-origion resource sharing" kontrolüne izin verilmesi için eklenmiştir
 * @author Okan CIRAN
 * @since 25.10.2017
 */
$res = $app->response();
$res->header('Access-Control-Allow-Origin', '*');
$res->header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
$app->add(new \Slim\Middleware\MiddlewareInsertUpdateDeleteLog());
$app->add(new \Slim\Middleware\MiddlewareHMAC());
$app->add(new \Slim\Middleware\MiddlewareSecurity());
$app->add(new \Slim\Middleware\MiddlewareMQManager());
$app->add(new \Slim\Middleware\MiddlewareBLLManager());
$app->add(new \Slim\Middleware\MiddlewareDalManager());
$app->add(new \Slim\Middleware\MiddlewareServiceManager());
$app->add(new \Slim\Middleware\MiddlewareMQManager());

 
 
/**
 *  * Okan CIRAN
 * @since 25.10.2017
 */
$app->get("/gnlKullaniciMebKoduFindByTcKimlikNo_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $vtc = NULL; 
    if (isset($_GET['tc'])) {
        $stripper->offsetSet('tc', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['tc']));
    }
    $vcid = NULL;
   if (isset($_GET['CID'])) {
        $stripper->offsetSet('CID', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['CID']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('tc')) {
        $vtc = $stripper->offsetGet('tc')->getFilterValue();
    }
    if ($stripper->offsetExists('CID')) {
        $vcid = $stripper->offsetGet('CID')->getFilterValue();
    }
   
    $resDataInsert = $BLL->gnlKullaniciMebKoduFindByTcKimlikNo(array( 
        'url' => $_GET['url'], 
        'tc' => $vtc, 
        'Cid' => $vcid, 
        ));
    $app->response()->header("Content-Type", "application/json");
    $app->response()->body(json_encode($resDataInsert));
}
);

 
/**
 *  * Okan CIRAN
 * @since 25.10.2017
 */
$app->get("/gnlKullaniciFindForLoginByTcKimlikNo_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $vtc = NULL;     
    if (isset($_GET['tc'])) {
        $stripper->offsetSet('tc', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['tc']));
    }
    $vsifre = NULL;
    if (isset($_GET['sifre'])) {
        $stripper->offsetSet('sifre', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['sifre']));
    }
    $vDeviceID = NULL;     
    if (isset($_GET['deviceID'])) {
        $stripper->offsetSet('deviceID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['deviceID']));
    }
   
    $stripper->strip();
    if ($stripper->offsetExists('tc')) {
        $vtc = $stripper->offsetGet('tc')->getFilterValue();
    }
    if ($stripper->offsetExists('sifre')) {
        $vsifre = $stripper->offsetGet('sifre')->getFilterValue();
    }
    if ($stripper->offsetExists('deviceID')) {
        $vDeviceID = $stripper->offsetGet('deviceID')->getFilterValue();
    }
   
    $resDataInsert = $BLL->gnlKullaniciFindForLoginByTcKimlikNo(array( 
        'url' => $_GET['url'], 
        'tc' => $vtc,  
        'sifre' => $vsifre, 
        'DeviceID' => $vDeviceID, 
        
        ));
    $app->response()->header("Content-Type", "application/json");
    $app->response()->body(json_encode($resDataInsert));
}
);
 

/**
 *  * Okan CIRAN
 * @since 25.10.2017
 */
$app->get("/mobilfirstdata_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $vkisiId = NULL;     
    if (isset($_GET['kisiId'])) {
        $stripper->offsetSet('kisiId', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiId']));
    }
    $vtc = NULL;   
    if (isset($_GET['tc'])) {
        $stripper->offsetSet('tc', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['tc']));
    }
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
   
    if ($stripper->offsetExists('kisiId')) {
        $vkisiId = $stripper->offsetGet('kisiId')->getFilterValue();
    }
    if ($stripper->offsetExists('tc')) {
        $vtc = $stripper->offsetGet('tc')->getFilterValue();
    }
   
    $resDataInsert = $BLL->mobilfirstdata(array( 
        'url' => $_GET['url'], 
        'kisiId' => $vkisiId,  
        'tcno' => $vtc,  
        'Cid' => $vCid, 
        ));
   // $app->response()->header("Content-Type", "application/json");
   // $app->response()->body(json_encode($resDataInsert));
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(
            "OkulKullaniciID" => $menu["OkulKullaniciID"],
            "OkulID" => $menu["OkulID"],
            "KisiID" => $menu["KisiID"],
            "RolID" =>  ($menu["RolID"]),
            "OkulAdi" => html_entity_decode($menu["OkulAdi"]), 
            "MEBKodu" => html_entity_decode($menu["MEBKodu"]), 
            "ePosta" => html_entity_decode($menu["ePosta"]),
            "DersYiliID" =>  ($menu["DersYiliID"]),
            "EgitimYilID" =>  ($menu["EgitimYilID"]),
            "EgitimYili" =>  ($menu["EgitimYili"]), 
            "DonemID" =>  ($menu["DonemID"]), 
            "dbn" =>  ($menu["dbnamex"]),  
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus)); 
    
}
);
  
/**
 * Okan CIRAN
 * @since 26-09-2017 
 */
$app->get("/mobilMenu_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();        
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $headerParams = $app->request()->headers();
    
     
    $vParent = 0;
    if (isset($_GET['parentID'])) {
        $stripper->offsetSet('parentID', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                                                                $app, 
                                                                $_GET['parentID']));
    }
    $vRolID = NULL;
    if (isset($_GET['RolID'])) {
        $stripper->offsetSet('RolID', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                                                                $app, 
                                                                $_GET['RolID']));
    }
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    } 
    
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
   
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('parentID')) 
        {$vParent = $stripper->offsetGet('parentID')->getFilterValue(); }    
    if ($stripper->offsetExists('RolID')) 
        {$vRolID = $stripper->offsetGet('RolID')->getFilterValue(); }  
    
    $resDataMenu = $BLL->mobilMenu(array('ParentID' => $vParent,      
                                            'RolID' => $vRolID, 
                                            'ParentID' => $vParent,
                                            'Cid' => $vCid,
                                           ) ); 
    $menus = array();
    foreach ($resDataMenu as $menu){
        $menus[]  = array(
            "ID" => $menu["ID"],
            "MenuID" => $menu["MenuID"],
            "ParentID" => $menu["ParentID"],
            "MenuAdi" => html_entity_decode($menu["MenuAdi"]),
            "Aciklama" => html_entity_decode($menu["Aciklama"]),
            "URL" => $menu["URL"],
            "SubDivision" => $menu["SubDivision"],
            "ImageURL" => $menu["ImageURL"], 
            "divid" => $menu["divid"], 
            "iconcolor" => $menu["iconcolor"], 
            "iconclass" => $menu["iconclass"], 
            "collapse" => $menu["collapse"],  
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
  
});
 

/**
 * Okan CIRAN
 * @since 26-09-2017 
 */
$app->get("/gnlKisiOkulListesi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();        
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $headerParams = $app->request()->headers(); 
     
    $vkisiId = NULL;     
    if (isset($_GET['kisiId'])) {
        $stripper->offsetSet('kisiId', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiId']));
    } 
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('kisiId')) {
        $vkisiId = $stripper->offsetGet('kisiId')->getFilterValue();
    } 
    $resDataMenu = $BLL->gnlKisiOkulListesi(array(      
                                            'kisiId' => $vkisiId, 
                                            'dbnamex' => $vdbnamex,
                                            'Cid' => $vCid,
                                           ) ); 
    $menus = array();
    foreach ($resDataMenu as $menu){
        $menus[]  = array(
             "OkulID" => $menu["OkulID"], 
             "OkulAdi" => html_entity_decode($menu["OkulAdi"]), 
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
  
});

/**
 *  * Okan CIRAN
 * @since 03.10.2017
 */
$app->get("/ogretmenDersProgrami_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $vkisiId = NULL;     
    if (isset($_GET['kisiId'])) {
        $stripper->offsetSet('kisiId', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiId']));
    }
    $vOkulID = NULL;     
    if (isset($_GET['OkulID'])) {
        $stripper->offsetSet('OkulID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['OkulID']));
    }
      
    $vdersYiliID= NULL;     
    if (isset($_GET['dersYiliID'])) {
        $stripper->offsetSet('dersYiliID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['dersYiliID']));
    }   
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    } 
    
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('kisiId')) {
        $vkisiId = $stripper->offsetGet('kisiId')->getFilterValue();
    }
    if ($stripper->offsetExists('OkulID')) {
        $vOkulID = $stripper->offsetGet('OkulID')->getFilterValue();
    }
    if ($stripper->offsetExists('dersYiliID')) {
        $vdersYiliID = $stripper->offsetGet('dersYiliID')->getFilterValue();
    }
   
    $resDataInsert = $BLL->ogretmenDersProgrami(array( 
        'url' => $_GET['url'], 
        'kisiId' => $vkisiId,  
        'OkulID' => $vOkulID,  
        'dersYiliID' => $vdersYiliID,  
        'dbnamex' => $vdbnamex, 
         'Cid' => $vCid, 
        ));
 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array( 
            
            "HaftaGunu" => $menu["HaftaGunu"],
            "DersSirasi" => $menu["DersSirasi"],
            "SinifDersID" => $menu["SinifDersID"], 
            "DersKodu" => html_entity_decode($menu["DersKodu"]), 
            "DersAdi" => html_entity_decode($menu["DersAdi"]), 
            "SinifKodu" => html_entity_decode($menu["SinifKodu"]), 
             "Aciklama" => html_entity_decode($menu["Aciklama"]), 
         
            "SubeGrupID" =>  ($menu["SubeGrupID"]),
            "BaslangicSaati" =>  ($menu["BaslangicSaati"]),
            "BitisSaati" =>  ($menu["BitisSaati"]), 
            "DersBaslangicBitisSaati" =>  ($menu["DersBaslangicBitisSaati"]), 
            "SinifOgretmenID" =>  ($menu["SinifOgretmenID"]),
            "DersHavuzuID" =>  ($menu["DersHavuzuID"]),
            "SinifID" =>  ($menu["SinifID"]),
            "DersID" =>  ($menu["DersID"]),
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
    
    
    
    
} 
);
  
/**
 *  * Okan CIRAN
 * @since 03.10.2017
 */
$app->get("/ogretmenDersProgramiDersSaatleri_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $vkisiId = NULL;     
    if (isset($_GET['kisiId'])) {
        $stripper->offsetSet('kisiId', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiId']));
    }
    $vsinifID = NULL;     
    if (isset($_GET['sinifID'])) {
        $stripper->offsetSet('sinifID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['sinifID']));
    }
    $vtarih = NULL;     
    if (isset($_GET['tarih'])) {
        $stripper->offsetSet('tarih', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['tarih']));
    }  
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    } 
    
     $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('kisiId')) {
        $vkisiId = $stripper->offsetGet('kisiId')->getFilterValue();
    }
    if ($stripper->offsetExists('sinifID')) {
        $vsinifID = $stripper->offsetGet('sinifID')->getFilterValue();
    }
    if ($stripper->offsetExists('tarih')) {
        $vtarih = $stripper->offsetGet('tarih')->getFilterValue();
    }
   
    $resDataInsert = $BLL->ogretmenDersProgramiDersSaatleri(array( 
        'url' => $_GET['url'], 
        'kisiId' => $vkisiId,  
        'sinifID' => $vsinifID, 
        'tarih' => $vtarih,  
        'dbnamex' => $vdbnamex,  
         'Cid' => $vCid, 
        ));
 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(  
            
            "BaslangicSaati" => $menu["BaslangicSaati"],
            "BitisSaati" => $menu["BitisSaati"],
            "DersSirasi" => $menu["DersSirasi"], 
            "DersKodu" => html_entity_decode($menu["DersKodu"]), 
            "DersAdi" => html_entity_decode($menu["DersAdi"]), 
            "Aciklama" => html_entity_decode($menu["Aciklama"]),  
            "DersID" =>  ($menu["DersID"]),
            "HaftaGunu" =>  html_entity_decode($menu["HaftaGunu"]),
                        
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
    
    
    
    
} 
);

/**
 *  * Okan CIRAN
 * @since 03.10.2017
 */
$app->get("/ogretmenDersPrgDersSaatleriOgrencileri_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $vkisiId = NULL;     
    if (isset($_GET['kisiId'])) {
        $stripper->offsetSet('kisiId', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiId']));
    }
    $vsinifID = NULL;     
    if (isset($_GET['sinifID'])) {
        $stripper->offsetSet('sinifID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['sinifID']));
    }
    $vtarih = NULL;     
    if (isset($_GET['tarih'])) {
        $stripper->offsetSet('tarih', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['tarih']));
    }
    $vdersSirasi= NULL;     
    if (isset($_GET['dersSirasi'])) {
        $stripper->offsetSet('dersSirasi', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['dersSirasi']));
    } 
    $vdersYiliID= NULL;     
    if (isset($_GET['dersYiliID'])) {
        $stripper->offsetSet('dersYiliID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['dersYiliID']));
    }       
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    } 
    
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('kisiId')) {
        $vkisiId = $stripper->offsetGet('kisiId')->getFilterValue();
    }
    if ($stripper->offsetExists('sinifID')) {
        $vsinifID = $stripper->offsetGet('sinifID')->getFilterValue();
    }
    if ($stripper->offsetExists('tarih')) {
        $vtarih = $stripper->offsetGet('tarih')->getFilterValue();
    }
    if ($stripper->offsetExists('dersSirasi')) {
        $vdersSirasi = $stripper->offsetGet('dersSirasi')->getFilterValue();
    }
    if ($stripper->offsetExists('dersYiliID')) {
        $vdersYiliID = $stripper->offsetGet('dersYiliID')->getFilterValue();
    }
   
    $resDataInsert = $BLL->ogretmenDersPrgDersSaatleriOgrencileri(array( 
        'url' => $_GET['url'], 
        'kisiId' => $vkisiId,  
        'sinifID' => $vsinifID, 
        'tarih' => $vtarih,  
        'dersSirasi' => $vdersSirasi,  
        'dersYiliID' => $vdersYiliID,  
        'dbnamex' => $vdbnamex,  
         'Cid' => $vCid, 
        ));
 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(   
            "OgrenciID" => $menu["OgrenciID"],
            "Tarih" => $menu["Tarih"],
            "DersSirasi" => $menu["DersSirasi"], 
            "DersYiliID" =>  ($menu["DersYiliID"]),
            "Numarasi" => html_entity_decode($menu["Numarasi"]),
            "Adsoyad" => html_entity_decode($menu["adsoyad"] ), 
          //  "Adi" => html_entity_decode($menu["Adi"] ), 
          //  "Soyadi" => html_entity_decode($menu["Soyadi"]),  
          //  "TCKimlikNo" =>  html_entity_decode($menu["TCKimlikNo"]),
            "CinsiyetID" =>  html_entity_decode($menu["CinsiyetID"]),
            "DevamsizlikKodID" =>  html_entity_decode($menu["DevamsizlikKodID"]),
            "Aciklama" =>  html_entity_decode($menu["Aciklama"]), 
            "Fotograf" =>  ($menu["Fotograf"]),  
                        
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
    
    
    
    
} 
);

/**
 *  * Okan CIRAN
 * @since 03.10.2017
 */
$app->get("/ogretmenVeliRandevulari_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $vkisiId = NULL;     
    if (isset($_GET['kisiId'])) {
        $stripper->offsetSet('kisiId', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiId']));
    }       
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    } 
    
     $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('kisiId')) {
        $vkisiId = $stripper->offsetGet('kisiId')->getFilterValue();
    } 
   
    $resDataInsert = $BLL->ogretmenVeliRandevulari(array( 
        'url' => $_GET['url'], 
        'kisiId' => $vkisiId,  
        'dbnamex' => $vdbnamex,  
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(   
            "VeliRandevuID" => $menu["VeliRandevuID"],
            "SinifOgretmenID" => $menu["SinifOgretmenID"],
            "VeliID" => $menu["VeliID"], 
            "BasZamani" =>  ($menu["BasZamani"]),
            "BitZamani" =>  ($menu["BitZamani"]), 
            "Aciklama" => html_entity_decode($menu["Aciklama"]), 
            "Onay" =>  ($menu["Onay"]),  
            "Ogretmen_Adi" =>  html_entity_decode($menu["Ogretmen_Adi"]),
            "Ogretmen_Soyadi" =>  html_entity_decode($menu["Ogretmen_Soyadi"]),
            "Ogrenci_Adi" =>  html_entity_decode($menu["Ogrenci_Adi"]),
            "Ogrenci_Soyadi" =>  html_entity_decode($menu["Ogrenci_Soyadi"]),  
            "Veli_Adi" =>  html_entity_decode($menu["Veli_Adi"]),
            "Veli_Soyadi" =>  html_entity_decode($menu["Veli_Soyadi"]),  
             "DersAdi" =>  html_entity_decode($menu["DersAdi"]),
            "Ders_Ogretmen" =>  html_entity_decode($menu["Ders_Ogretmen"]),  
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus)); 
} 
);


/** 
 *  * Okan CIRAN
 * @since 05.10.2017
 * rest servislere eklendi
 */
$app->get("/InsertDevamsizlik_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory(); 
    $BLL = $app->getBLLManager()->get('mblLoginBLL');  
    $headerParams = $app->request()->headers();
      
    $vKisiId = NULL;     
    if (isset($_GET['kisiId'])) {
        $stripper->offsetSet('kisiId', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiId']));
    }
    $vDersYiliID= NULL;     
    if (isset($_GET['DersYiliID'])) {
        $stripper->offsetSet('DersYiliID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['DersYiliID']));
    } 
    $vSinifID = NULL;     
    if (isset($_GET['SinifID'])) {
        $stripper->offsetSet('SinifID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['SinifID']));
    }
    $vDersID = NULL;     
    if (isset($_GET['DersID'])) {
        $stripper->offsetSet('DersID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['DersID']));
    }
    $vDersSirasi= NULL;     
    if (isset($_GET['DersSirasi'])) {
        $stripper->offsetSet('DersSirasi', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['DersSirasi']));
    }  
    $vDonemID = NULL;     
    if (isset($_GET['DonemID'])) {
        $stripper->offsetSet('DonemID', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['DonemID']));
    } 
    $vOkulOgretmenID = NULL;     
    if (isset($_GET['OkulOgretmenID'])) {
        $stripper->offsetSet('OkulOgretmenID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['OkulOgretmenID']));
    } 
    $vTarih = NULL;     
    if (isset($_GET['Tarih'])) {
        $stripper->offsetSet('Tarih', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['Tarih']));
    }
    $vXmlData = NULL;     
    if (isset($_GET['XmlData'])) {
        $stripper->offsetSet('XmlData', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL1, 
                $app, $_GET['XmlData']));
    }
    $vSinifDersID = NULL;     
    if (isset($_GET['SinifDersID'])) {
        $stripper->offsetSet('SinifDersID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['SinifDersID']));
    }  
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    } 
    
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('kisiId')) {
        $vKisiId = $stripper->offsetGet('kisiId')->getFilterValue();
    }
    if ($stripper->offsetExists('DersYiliID')) {
        $vDersYiliID = $stripper->offsetGet('DersYiliID')->getFilterValue();
    }
    if ($stripper->offsetExists('SinifID')) {
        $vSinifID = $stripper->offsetGet('SinifID')->getFilterValue();
    }
    if ($stripper->offsetExists('DersID')) {
        $vDersID = $stripper->offsetGet('DersID')->getFilterValue();
    }
    if ($stripper->offsetExists('DersSirasi')) {
        $vDersSirasi = $stripper->offsetGet('DersSirasi')->getFilterValue();
    } 
    if ($stripper->offsetExists('DonemID')) {
        $vDonemID = $stripper->offsetGet('DonemID')->getFilterValue();
    }
    if ($stripper->offsetExists('OkulOgretmenID')) {
        $vOkulOgretmenID = $stripper->offsetGet('OkulOgretmenID')->getFilterValue();
    }
    if ($stripper->offsetExists('Tarih')) {
        $vTarih = $stripper->offsetGet('Tarih')->getFilterValue();
    }
    if ($stripper->offsetExists('XmlData')) {
        $vXmlData = $stripper->offsetGet('XmlData')->getFilterValue();
    }
    if ($stripper->offsetExists('SinifDersID')) {
        $vSinifDersID = $stripper->offsetGet('SinifDersID')->getFilterValue();
    }
   
    $resDataInsert = $BLL->insertDevamsizlik(array(
            'OgretmenID' => $vKisiId,  
            'DersYiliID' => $vDersYiliID, 
            'SinifID' => $vSinifID, 
            'DersID' => $vDersID,  
            'DersSirasi' => $vDersSirasi,  
            'DonemID' => $vDonemID, 
            'OkulOgretmenID' => $vOkulOgretmenID,  
            'SinifDersID' => $vSinifDersID,  
            'Tarih' => $vTarih,  
            'XmlData' => $vXmlData,   
            'dbnamex' => $vdbnamex, 
            'Cid' => $vCid, 
             ));
        
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($resDataInsert)); 
    
}
);


/**
 *  * Okan CIRAN
 * @since 09.10.2017
 */
$app->get("/VeliOgrencileri_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $vkisiId = NULL;     
    if (isset($_GET['kisiId'])) {
        $stripper->offsetSet('kisiId', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiId']));
    }
    $vdersYiliID= NULL;     
    if (isset($_GET['dersYiliID'])) {
        $stripper->offsetSet('dersYiliID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['dersYiliID']));
    }           
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    } 
    
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('kisiId')) {
        $vkisiId = $stripper->offsetGet('kisiId')->getFilterValue();
    }
    if ($stripper->offsetExists('dersYiliID')) {
        $vdersYiliID = $stripper->offsetGet('dersYiliID')->getFilterValue();
    } 
   
    $resDataInsert = $BLL->veliOgrencileri(array( 
        'url' => $_GET['url'], 
        'kisiId' => $vkisiId,  
        'dersYiliID' => $vdersYiliID,  
        'dbnamex' => $vdbnamex, 
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(  
            "OgrenciID" => $menu["OgrenciID"],
            "SinifID" => $menu["SinifID"],
            "DersYiliID" => $menu["DersYiliID"], 
            "SinifKodu" =>  ($menu["SinifKodu"]),            
            "SinifAdi" => html_entity_decode($menu["SinifAdi"]), 
            "Numarasi" =>  ($menu["Numarasi"]),  
            "OgrenciOkulBilgiID" =>   ($menu["OgrenciOkulBilgiID"]),
            "KisiID" =>   ($menu["KisiID"]),
            "CinsiyetID" =>   ($menu["CinsiyetID"]),
            "Adi" =>  html_entity_decode($menu["Adi"]),             
            "Soyadi" =>  html_entity_decode($menu["Soyadi"]),
            "AdiSoyadi" =>  html_entity_decode($menu["Adi_Soyadi"]),             
            "TCKimlikNo" =>  html_entity_decode($menu["TCKimlikNo"]),
            "ePosta" =>   ($menu["ePosta"]), 
            "OkulID" =>   ($menu["OkulID"]), 
            "OgrenciSeviyeID" =>   ($menu["OgrenciSeviyeID"]), 
            "Fotograf" =>   ($menu["Fotograf"]), 
        );
    } 
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus)); 
    
} 
);


/**
 *  * Okan CIRAN
 * @since 09.10.2017
 */
$app->get("/OgrenciDevamsizlikListesi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $vkisiId = NULL;     
    if (isset($_GET['kisiId'])) {
        $stripper->offsetSet('kisiId', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiId']));
    }
    $vdersYiliID= NULL;     
    if (isset($_GET['dersYiliID'])) {
        $stripper->offsetSet('dersYiliID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['dersYiliID']));
    }    
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
     $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('kisiId')) {
        $vkisiId = $stripper->offsetGet('kisiId')->getFilterValue();
    }
    if ($stripper->offsetExists('dersYiliID')) {
        $vdersYiliID = $stripper->offsetGet('dersYiliID')->getFilterValue();
    } 
   
    $resDataInsert = $BLL->ogrenciDevamsizlikListesi(array( 
        'url' => $_GET['url'], 
        'kisiId' => $vkisiId,  
        'dersYiliID' => $vdersYiliID,  
        'dbnamex' => $vdbnamex, 
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(   
            "OgrenciDevamsizlikID" => $menu["OgrenciDevamsizlikID"],
            "DersYiliID" => $menu["DersYiliID"],
            "OgrenciID" => $menu["OgrenciID"], 
         //   "DevamsizlikKodID" =>  ($menu["DevamsizlikKodID"]),  
            "DevamsizlikPeriyodID" =>  ($menu["DevamsizlikPeriyodID"]),  
            "Tarih" => $menu["Tarih"], 
            "rownum" =>  ($menu["rownum"]),  
            "DevamsizlikPeriyodID" =>  ($menu["DevamsizlikPeriyodID"]), 
            "DevamsizlikAdi" => html_entity_decode($menu["DevamsizlikAdi"]), 
            "GunKarsiligi" => html_entity_decode($menu["GunKarsiligi"]), 
            "Aciklama" => html_entity_decode($menu["Aciklama"]),  
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus)); 
} 
);



/**
 *  * Okan CIRAN
 * @since 09.10.2017
 */
$app->get("/Kurumyoneticisisubelistesi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    
    $vdersYiliID= NULL;     
    if (isset($_GET['dersYiliID'])) {
        $stripper->offsetSet('dersYiliID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['dersYiliID']));
    }            
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
     $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('dersYiliID')) {
        $vdersYiliID = $stripper->offsetGet('dersYiliID')->getFilterValue();
    } 
   
    $resDataInsert = $BLL->kurumyoneticisisubelistesi(array( 
        'url' => $_GET['url'],  
        'DersYiliID' => $vdersYiliID,  
        'dbnamex' => $vdbnamex,  
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(   
            "SinifID" => $menu["SinifID"],
            "DersYiliID" => $menu["DersYiliID"],
            "SeviyeID" => $menu["SeviyeID"], 
            "SinifKodu" =>  ($menu["SinifKodu"]),            
            "SinifAdi" => html_entity_decode($menu["SinifAdi"]), 
            "Sanal" =>  ($menu["Sanal"]),  
            "SubeGrupID" =>   ($menu["SubeGrupID"]),
            "SeviyeKodu" =>   ($menu["SeviyeKodu"]), 
            "SinifOgretmeni" =>  html_entity_decode($menu["SinifOgretmeni"]),             
            "MudurYardimcisi" =>  html_entity_decode($menu["MudurYardimcisi"]),
            "Aciklama" =>  html_entity_decode($menu["Aciklama"]),             
            
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus)); 
      
} 
);


/**
 *  * Okan CIRAN
 * @since 09.10.2017
 */
$app->get("/Kysubeogrencilistesi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    
    $vSinifID= NULL;     
    if (isset($_GET['sinifID'])) {
        $stripper->offsetSet('sinifID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['sinifID']));
    }       
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }   
    if ($stripper->offsetExists('sinifID')) {
        $vSinifID = $stripper->offsetGet('sinifID')->getFilterValue();
    } 
   
    $resDataInsert = $BLL->kysubeogrencilistesi(array( 
        'url' => $_GET['url'],  
        'SinifID' => $vSinifID,  
        'dbnamex' => $vdbnamex,  
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(   
            "OgrenciSeviyeID" => $menu["OgrenciSeviyeID"],
            "OgrenciID" => $menu["OgrenciID"],
            "SinifID" => $menu["SinifID"], 
            "OgrenciID" =>  ($menu["OgrenciID"]),            
            "Numarasi" => html_entity_decode($menu["Numarasi"]), 
            "KisiID" =>  ($menu["KisiID"]),  
            "CinsiyetID" =>   ($menu["CinsiyetID"]), 
            "Adi" =>  html_entity_decode($menu["Adi"]),             
            "Soyadi" =>  html_entity_decode($menu["Soyadi"]),
            "TCKimlikNo" =>  html_entity_decode($menu["TCKimlikNo"]),             
            "ePosta" =>  html_entity_decode($menu["ePosta"]),             
            "SeviyeID" =>   ($menu["SeviyeID"]),
            "Aciklama" =>  html_entity_decode($menu["Aciklama"]),   
            "Fotograf" =>   ($menu["Fotograf"]), 
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
     
} 
);
 

/**
 *  * Okan CIRAN
 * @since 09.10.2017
 */
$app->get("/KySubeOgrenciDersListesi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    
    $vOgrenciSeviyeID= NULL;     
    if (isset($_GET['ogrenciSeviyeID'])) {
        $stripper->offsetSet('ogrenciSeviyeID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['ogrenciSeviyeID']));
    }            
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('ogrenciSeviyeID')) {
        $vOgrenciSeviyeID = $stripper->offsetGet('ogrenciSeviyeID')->getFilterValue();
    } 
    $resDataInsert = $BLL->KySubeOgrenciDersListesi(array( 
        'url' => $_GET['url'],  
        'OgrenciSeviyeID' => $vOgrenciSeviyeID,  
        'dbnamex' => $vdbnamex,
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(   
            "DersAdi" =>  html_entity_decode($menu["DersAdi"]), 
            "HaftalikDersSaati" =>   ($menu["HaftalikDersSaati"]), 
            "Donem1_DonemNotu" =>   ($menu["Donem1_DonemNotu"]),             
            "Donem2_DonemNotu" =>   ($menu["Donem2_DonemNotu"]),
            "YilSonuNotu" =>   ($menu["YilSonuNotu"]), 
            "YilSonuPuani" =>   ($menu["YilSonuPuani"]), 
            
         //   "OgrenciSeviyeID" => $menu["OgrenciSeviyeID"],
         //   "DersHavuzuID" => $menu["DersHavuzuID"],
         //   "Numarasi" => $menu["Numarasi"], 
        //    "AdiSoyadi" =>  html_entity_decode($menu["AdiSoyadi"]),            
        //    "DersKodu" =>  ($menu["Numarasi"]), 
           
        //    "DonemID" =>   ($menu["DonemID"]), 
           
         //   "PuanOrtalamasi" =>   ($menu["PuanOrtalamasi"]),             
        //    "Donem1_PuanOrtalamasi" =>   ($menu["Donem1_PuanOrtalamasi"]),             
        //    "Donem2_PuanOrtalamasi" =>   ($menu["Donem2_PuanOrtalamasi"]),
         //   "AktifDonemNotu" =>   ($menu["AktifDonemNotu"]),   
        //    "YetistirmeKursuNotu" =>   ($menu["YetistirmeKursuNotu"]),             
        //    "YetistirmeKursuNotu" =>   ($menu["YetistirmeKursuNotu"]), 
          
           
        //    "YilsonuToplamAgirligi" =>   ($menu["YilsonuToplamAgirligi"]), 
        //    "OdevAldi" =>    ($menu["OdevAldi"]), 
        //    "ProjeAldi" =>   ($menu["ProjeAldi"]), 
        //    "OgrenciDersID" =>   ($menu["OgrenciDersID"]), 
        //    "OgrenciDonemNotID" =>   ($menu["OgrenciDonemNotID"]), 
         //   "PuanOrtalamasi" =>   ($menu["PuanOrtalamasi"]), 
         //   "Hesaplandi" =>   ($menu["Hesaplandi"]), 
         //   "KanaatNotu" =>   ($menu["KanaatNotu"]), 
        //    "Sira" =>   ($menu["Sira"]), 
         //   "EgitimYilID" =>   ($menu["EgitimYilID"]), 
            
         //   "Perf1OdevAldi" =>   ($menu["Perf1OdevAldi"]), 
        //    "Perf2OdevAldi" =>   ($menu["Perf2OdevAldi"]), 
         //   "Perf3OdevAldi" =>   ($menu["Perf3OdevAldi"]), 
         //   "Perf4OdevAldi" =>   ($menu["Perf4OdevAldi"]), 
        //    "Perf5OdevAldi" =>   ($menu["Perf5OdevAldi"]), 
        //    "AltDers" =>   ($menu["AltDers"]), 
        //    "YillikProjeAldi" =>   ($menu["YillikProjeAldi"]), 
         //   "YetistirmeKursunaGirecek" =>  ($menu["YetistirmeKursunaGirecek"]),             
        //    "OgretmenAdiSoyadi" =>   html_entity_decode($menu["OgretmenAdiSoyadi"]),
        //    "isPuanNotGirilsin" =>   ($menu["isPuanNotGirilsin"]),
       //     "isPuanNotHesapDahil" =>   ($menu["isPuanNotHesapDahil"]),
         //   "AgirlikliYilSonuNotu" =>   ($menu["AgirlikliYilSonuNotu"]),
         //   "AgirlikliYilsonuPuani" =>   ($menu["AgirlikliYilsonuPuani"]),
         //   "PBYCOrtalama" =>   ($menu["PBYCOrtalama"]),
        //    "DersSabitID" =>   ($menu["DersSabitID"]), 
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
     
} 
);

/**
 *  * Okan CIRAN
 * @since 09.10.2017
 */
$app->get("/Ogretmensinavlistesi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    
    $vKisiId = NULL;     
    if (isset($_GET['kisiID'])) {
        $stripper->offsetSet('kisiID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiID']));
    }
    $vOgretmenID= NULL;     
    if (isset($_GET['ogretmenID'])) {
        $stripper->offsetSet('ogretmenID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['ogretmenID']));
    } 
    $vOkulID = NULL;     
    if (isset($_GET['okulID'])) {
        $stripper->offsetSet('okulID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['okulID']));
    }
    $vEgitimYilID = NULL;     
    if (isset($_GET['egitimYilID'])) {
        $stripper->offsetSet('egitimYilID', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['egitimYilID']));
    }          
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
     $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('kisiID')) {
        $vKisiId = $stripper->offsetGet('kisiID')->getFilterValue();
    }
    if ($stripper->offsetExists('ogretmenID')) {
        $vOgretmenID = $stripper->offsetGet('ogretmenID')->getFilterValue();
    }
    if ($stripper->offsetExists('okulID')) {
        $vOkulID = $stripper->offsetGet('okulID')->getFilterValue();
    }
    if ($stripper->offsetExists('egitimYilID')) {
        $vEgitimYilID = $stripper->offsetGet('egitimYilID')->getFilterValue();
    } 
   
    $resDataInsert = $BLL->Ogretmensinavlistesi(array( 
        'url' => $_GET['url'],  
        'KisiID' => $vKisiId,  
        'OgretmenID' => $vOgretmenID,  
        'OkulID' => $vOkulID,  
        'EgitimYilID' => $vEgitimYilID,  
        'dbnamex' => $vdbnamex,  
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(   
            "Donem" =>  html_entity_decode($menu["Donem"]), 
            "SinavTarihi" =>   ($menu["SinavTarihi"]), 
            "SinavBitisTarihi" =>   ($menu["SinavBitisTarihi"]),             
            "SinavTurAdi" =>   html_entity_decode($menu["SinavTurAdi"]),
            "SinavKodu" =>   html_entity_decode($menu["SinavKodu"]), 
            "SinavAciklamasi" =>   html_entity_decode($menu["SinavAciklamasi"]), 
   
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus)); 
} 
);


/**
 *  * Okan CIRAN
 * @since 09.10.2017
 */
$app->get("/Yakinisinavlistesi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    
    $vKisiId = NULL;     
    if (isset($_GET['kisiID'])) {
        $stripper->offsetSet('kisiID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiID']));
    }
    $vOgretmenID= NULL;     
    if (isset($_GET['ogretmenID'])) {
        $stripper->offsetSet('ogretmenID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['ogretmenID']));
    } 
    $vOkulID = NULL;     
    if (isset($_GET['okulID'])) {
        $stripper->offsetSet('okulID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['okulID']));
    }
    $vEgitimYilID = NULL;     
    if (isset($_GET['egitimYilID'])) {
        $stripper->offsetSet('egitimYilID', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['egitimYilID']));
    }          
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
     $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('kisiID')) {
        $vKisiId = $stripper->offsetGet('kisiID')->getFilterValue();
    }
    if ($stripper->offsetExists('ogretmenID')) {
        $vOgretmenID = $stripper->offsetGet('ogretmenID')->getFilterValue();
    }
    if ($stripper->offsetExists('okulID')) {
        $vOkulID = $stripper->offsetGet('okulID')->getFilterValue();
    }
    if ($stripper->offsetExists('egitimYilID')) {
        $vEgitimYilID = $stripper->offsetGet('egitimYilID')->getFilterValue();
    } 
   
    $resDataInsert = $BLL->yakinisinavlistesi(array( 
        'url' => $_GET['url'],  
        'KisiID' => $vKisiId,  
        'OgretmenID' => $vOgretmenID,  
        'OkulID' => $vOkulID,  
        'EgitimYilID' => $vEgitimYilID,  
        'dbnamex' => $vdbnamex,  
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(   
            "Donem" =>  html_entity_decode($menu["Donem"]), 
            "SinavTarihi" =>   ($menu["SinavTarihi"]), 
            "SinavBitisTarihi" =>   ($menu["SinavBitisTarihi"]),             
            "SinavTurAdi" =>   html_entity_decode($menu["SinavTurAdi"]),
            "SinavKodu" =>   html_entity_decode($menu["SinavKodu"]), 
            "SinavAciklamasi" =>   html_entity_decode($menu["SinavAciklamasi"]), 
   
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus)); 
     
} 
);

/**
 *  * Okan CIRAN
 * @since 23.10.2017
 */
$app->get("/KurumYoneticisiSinavListesi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    
    $vKisiId = NULL;     
    if (isset($_GET['kisiID'])) {
        $stripper->offsetSet('kisiID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiID']));
    }
    $vOgretmenID= NULL;     
    if (isset($_GET['ogretmenID'])) {
        $stripper->offsetSet('ogretmenID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['ogretmenID']));
    } 
    $vOkulID = NULL;     
    if (isset($_GET['okulID'])) {
        $stripper->offsetSet('okulID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['okulID']));
    }
    $vEgitimYilID = NULL;     
    if (isset($_GET['egitimYilID'])) {
        $stripper->offsetSet('egitimYilID', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['egitimYilID']));
    }          
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
     $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('kisiID')) {
        $vKisiId = $stripper->offsetGet('kisiID')->getFilterValue();
    }
    if ($stripper->offsetExists('ogretmenID')) {
        $vOgretmenID = $stripper->offsetGet('ogretmenID')->getFilterValue();
    }
    if ($stripper->offsetExists('okulID')) {
        $vOkulID = $stripper->offsetGet('okulID')->getFilterValue();
    }
    if ($stripper->offsetExists('egitimYilID')) {
        $vEgitimYilID = $stripper->offsetGet('egitimYilID')->getFilterValue();
    } 
   
    $resDataInsert = $BLL->kurumYoneticisiSinavListesi(array( 
        'url' => $_GET['url'],  
        'KisiID' => $vKisiId,  
        'OgretmenID' => $vOgretmenID,  
        'OkulID' => $vOkulID,  
        'EgitimYilID' => $vEgitimYilID, 
        'dbnamex' => $vdbnamex, 
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(   
            "Donem" =>  html_entity_decode($menu["Donem"]), 
            "SinavTarihi" =>   ($menu["SinavTarihi"]), 
            "SinavBitisTarihi" =>   ($menu["SinavBitisTarihi"]),             
            "SinavTurAdi" =>   html_entity_decode($menu["SinavTurAdi"]),
            "SinavKodu" =>   html_entity_decode($menu["SinavKodu"]), 
            "SinavAciklamasi" =>   html_entity_decode($menu["SinavAciklamasi"]), 
   
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
     
} 
);


/**
 *  * Okan CIRAN
 * @since 23.10.2017
 */
$app->get("/GelenMesajListesi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    
    $vKisiId = NULL;     
    if (isset($_GET['kisiID'])) {
        $stripper->offsetSet('kisiID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiID']));
    }    
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }    
    if ($stripper->offsetExists('kisiID')) {
        $vKisiId = $stripper->offsetGet('kisiID')->getFilterValue();
    }
      
    $resDataInsert = $BLL->gelenMesajListesi(array( 
        'url' => $_GET['url'],  
        'KisiID' => $vKisiId,   
        'dbnamex' => $vdbnamex,
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(  
            "MesajID" =>   ($menu["MesajID"]), 
            "ReceiverID" =>   ($menu["ReceiverID"]), 
            "Okundu" =>   ($menu["Okundu"]),             
            "OkunduguTarih" =>    ($menu["OkunduguTarih"]),
            "Silindi" =>    ($menu["Silindi"]), 
            "MesajOncelikID" =>   ($menu["MesajOncelikID"]), 
            "Tarih" =>   ($menu["Tarih"]), 
            "SenderID" =>   ($menu["SenderID"]), 
            "RowNum" =>   ($menu["RowNum"]),  
            "Konu" =>   html_entity_decode($menu["Konu"]), 
            "Mesaj" =>   html_entity_decode($menu["Mesaj"]), 
            "SenderAdi" =>   html_entity_decode($menu["SenderAdi"]), 
            "SenderSoyadi" =>   html_entity_decode($menu["SenderSoyadi"]), 
            "SenderAdiSoyadi" =>   html_entity_decode($menu["SenderAdiSoyadi"]),  
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
     
} 
);

/**
 *  * Okan CIRAN
 * @since 23.10.2017
 */
$app->get("/GidenMesajListesi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    
    $vKisiId = NULL;     
    if (isset($_GET['kisiID'])) {
        $stripper->offsetSet('kisiID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiID']));
    }  
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    } 
    if ($stripper->offsetExists('kisiID')) {
        $vKisiId = $stripper->offsetGet('kisiID')->getFilterValue();
    }
      
    $resDataInsert = $BLL->gidenMesajListesi(array( 
        'url' => $_GET['url'],  
        'KisiID' => $vKisiId,  
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(   
            "MesajID" =>   ($menu["MesajID"]), 
            "MesajOncelikID" =>   ($menu["MesajOncelikID"]), 
            "Konu" =>   html_entity_decode($menu["Konu"]), 
            "Tarih" =>   ($menu["Tarih"]), 
            "ReceiverNames" =>   html_entity_decode($menu["ReceiverNames"]), 
            "RowNum" =>   ($menu["RowNum"]),             
          
           
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
     
} 
);
/**
 *  * Okan CIRAN
 * @since 23.10.2017
 */
$app->get("/GelenMesajDetay_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    
    $vMesajID = NULL;     
    if (isset($_GET['mesajID'])) {
        $stripper->offsetSet('mesajID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['mesajID']));
    } 
    $vKisiId = NULL;     
    if (isset($_GET['kisiID'])) {
        $stripper->offsetSet('kisiID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiID']));
    }  
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue(); }
    if ($stripper->offsetExists('kisiID')) 
        {$vKisiId = $stripper->offsetGet('kisiID')->getFilterValue(); }      
    if ($stripper->offsetExists('mesajID')) {
        $vMesajID = $stripper->offsetGet('mesajID')->getFilterValue();
    }
      
    $resDataInsert = $BLL->GelenMesajDetay(array( 
        'url' => $_GET['url'],  
        'MesajID' => $vMesajID,  
        'KisiID' => $vKisiId,   
        'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(  
            "MesajID" =>   ($menu["MesajID"]), 
         //   "ReceiverID" =>   ($menu["ReceiverID"]), 
          //  "Okundu" =>   ($menu["Okundu"]),             
          //  "OkunduguTarih" =>    ($menu["OkunduguTarih"]),
          //  "Silindi" =>    ($menu["Silindi"]), 
         //   "MesajOncelikID" =>   ($menu["MesajOncelikID"]), 
            "Tarih" =>   ($menu["Tarih"]), 
        //    "SenderID" =>   ($menu["SenderID"]), 
         //   "RowNum" =>   ($menu["RowNum"]),  
            "Konu" =>   html_entity_decode($menu["Konu"]), 
            "Mesaj" =>   html_entity_decode($menu["Mesaj"]), 
        //    "SenderAdi" =>   html_entity_decode($menu["SenderAdi"]), 
        //    "SenderSoyadi" =>   html_entity_decode($menu["SenderSoyadi"]), 
            "SenderAdiSoyadi" =>   html_entity_decode($menu["SenderAdiSoyadi"]), 
             
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
     
} 
);
/**
 *  * Okan CIRAN
 * @since 24.10.2017
 */
$app->get("/OdevListesiOgretmen_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    
    $vOgretmenID= NULL;     
    if (isset($_GET['ogretmenID'])) {
        $stripper->offsetSet('ogretmenID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['ogretmenID']));
    }  
        
    $vdersYiliID= NULL;     
    if (isset($_GET['dersYiliID'])) {
        $stripper->offsetSet('dersYiliID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['dersYiliID']));
    }            
           
   $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
     $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    } 
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }     
    if ($stripper->offsetExists('dersYiliID')) {
        $vdersYiliID = $stripper->offsetGet('dersYiliID')->getFilterValue();
    } 
    if ($stripper->offsetExists('ogretmenID')) {
        $vOgretmenID = $stripper->offsetGet('ogretmenID')->getFilterValue();
    } 
    $resDataInsert = $BLL->odevListesiOgretmen(array( 
        'url' => $_GET['url'],  
        'OgretmenID' => $vOgretmenID,   
        'DersYiliID' => $vdersYiliID,   
        'dbnamex' => $vdbnamex,  
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(  
            "OdevTanimID" =>   ($menu["OdevTanimID"]), 
            "OgretmenAdi" =>   html_entity_decode($menu["OgretmenAdi"]), 
            "SinifKodu" =>   html_entity_decode($menu["SinifKodu"]), 
            "SeviyeID" =>   ($menu["SeviyeID"]), 
            "SeviyeAdi" =>   html_entity_decode($menu["SeviyeAdi"]), 
            "DersBilgisi" =>   html_entity_decode($menu["DersBilgisi"]), 
            "Tanim" =>   html_entity_decode($menu["Tanim"]),
            "Tarih" =>   ($menu["Tarih"]),             
            "TeslimTarihi" =>    ($menu["TeslimTarihi"]),
            "OdevTipID" =>    ($menu["OdevTipID"]), 
            "TanimDosyaAdi" =>   html_entity_decode($menu["TanimDosyaAdi"]), 
            "TanimDosyaID" =>   ($menu["TanimDosyaID"]), 
            "TanimYuklemeTarihi" =>   ($menu["TanimYuklemeTarihi"]), 
            "TanimDosya" =>   ($menu["TanimDosya"]), 
            "TanimBoyut" =>   ($menu["TanimBoyut"]),
            "VerildigiOgrenciSayisi" =>   ($menu["VerildigiOgrenciSayisi"]), 
            "BakanOgrenciSayisi" =>   ($menu["BakanOgrenciSayisi"]),  
            "YapanOgrenciSayisi" =>   ($menu["YapanOgrenciSayisi"]),  
            "OnayOgrenciSayisi" =>   ($menu["OnayOgrenciSayisi"]),  
             
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
     
} 
);
 
 
/**
 *  * Okan CIRAN
 * @since 24.10.2017
 */
$app->get("/OdevListesiOgrenciveYakin_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    
    $vOgrenciID= NULL;     
    if (isset($_GET['ogrenciID'])) {
        $stripper->offsetSet('ogrenciID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['ogrenciID']));
    }  
        
    $vEgitimYilID= NULL;     
    if (isset($_GET['egitimYilID'])) {
        $stripper->offsetSet('egitimYilID', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['egitimYilID']));
    }            
           
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
  
    if ($stripper->offsetExists('egitimYilID')) {
        $vEgitimYilID = $stripper->offsetGet('egitimYilID')->getFilterValue();
    }
  
    if ($stripper->offsetExists('ogrenciID')) {
        $vOgrenciID = $stripper->offsetGet('ogrenciID')->getFilterValue();
    }
      
    $resDataInsert = $BLL->odevListesiOgrenciveYakin(array( 
        'url' => $_GET['url'],  
        'OgrenciID' => $vOgrenciID,   
        'EgitimYilID' => $vEgitimYilID,
        'dbnamex' => $vdbnamex, 
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(  
            "OgrenciOdevID" =>   ($menu["OdevTanimID"]), 
          //  "OgrenciID" =>   ($menu["OgrenciID"]), 
          // "OdevTanimID" =>   ($menu["OdevTanimID"]),   
            "OgrenciCevap" =>   html_entity_decode($menu["OgrenciCevap"]), 
            "OgrenciGordu" =>    ($menu["OgrenciGordu"]),
         //   "OgrenciOnay" =>    ($menu["OgrenciOnay"]),
            "OgrenciTeslimTarihi" =>   ($menu["OgrenciTeslimTarihi"]), 
            "OgretmenDegerlendirme" =>   html_entity_decode($menu["OgretmenDegerlendirme"]), 
        //    "OdevOnayID" =>   ($menu["OdevOnayID"]),  
            "OgretmenAdi" =>   html_entity_decode($menu["OgretmenAdi"]),  
            "DersAdi" =>   html_entity_decode($menu["DersAdi"]),  
            "Tanim" =>   html_entity_decode($menu["Tanim"]), 
            "Tarih" =>   ($menu["Tarih"]), 
            "TeslimTarihi" =>   ($menu["TeslimTarihi"]),  
        );
    } 
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
     
} 
);



/**
 *  * Okan CIRAN
 * @since 24.10.2017
 */
$app->get("/OdevListesiKurumYoneticisi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
     
    $vdersYiliID= NULL;     
    if (isset($_GET['dersYiliID'])) {
        $stripper->offsetSet('dersYiliID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['dersYiliID']));
    }            
           
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
     $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
  
    if ($stripper->offsetExists('dersYiliID')) {
        $vdersYiliID = $stripper->offsetGet('dersYiliID')->getFilterValue();
    }
    
    $resDataInsert = $BLL->odevListesiKurumYoneticisi(array( 
        'url' => $_GET['url'],   
        'DersYiliID' => $vdersYiliID, 
        'dbnamex' => $vdbnamex, 
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(  
            "OdevTanimID" =>   ($menu["OdevTanimID"]), 
            "OgretmenAdi" =>   html_entity_decode($menu["OgretmenAdi"]), 
            "SinifKodu" =>   html_entity_decode($menu["SinifKodu"]),  
            "SeviyeAdi" =>   html_entity_decode($menu["SeviyeAdi"]), 
            "DersBilgisi" =>   html_entity_decode($menu["DersBilgisi"]), 
            "Tanim" =>   html_entity_decode($menu["Tanim"]),
            "Tarih" =>   ($menu["Tarih"]),             
            "TeslimTarihi" =>    ($menu["TeslimTarihi"]), 
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
     
} 
);

/**
 *  * Okan CIRAN
 * @since 24.10.2017
 */
$app->get("/OgretmenDersProgramiListesi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
     
    $vdersYiliID= NULL;     
    if (isset($_GET['dersYiliID'])) {
        $stripper->offsetSet('dersYiliID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['dersYiliID']));
    } 
    $vOgretmenID= NULL;     
    if (isset($_GET['ogretmenID'])) {
        $stripper->offsetSet('ogretmenID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['ogretmenID']));
    }  
    $vDonemID= NULL;     
    if (isset($_GET['donemID'])) {
        $stripper->offsetSet('donemID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['donemID']));
    }  
           
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); } 
  
    if ($stripper->offsetExists('dersYiliID')) {
        $vdersYiliID = $stripper->offsetGet('dersYiliID')->getFilterValue();
    }
    if ($stripper->offsetExists('ogretmenID')) {
        $vOgretmenID = $stripper->offsetGet('ogretmenID')->getFilterValue();
    }
    if ($stripper->offsetExists('donemID')) {
        $vDonemID = $stripper->offsetGet('donemID')->getFilterValue();
    }
    
    $resDataInsert = $BLL->ogretmenDersProgramiListesi(array( 
        'url' => $_GET['url'],   
        'DersYiliID' => $vdersYiliID,   
        'OgretmenID' => $vOgretmenID,   
        'DonemID' => $vDonemID,  
        'dbnamex' => $vdbnamex,   
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(  
            "HaftaGunu" =>   ($menu["HaftaGunu"]), 
            "DersSirasi" =>    ($menu["DersSirasi"]), 
            "SinifDersID" =>    ($menu["SinifDersID"]),  
            "DersAdi" =>   html_entity_decode($menu["DersAdi"]), 
            "SinifKodu" =>   html_entity_decode($menu["SinifKodu"]), 
            "SubeGrupID" =>    ($menu["SubeGrupID"]),
            "BaslangicSaati" =>   ($menu["BaslangicSaati"]),             
            "BitisSaati" =>    ($menu["BitisSaati"]),  
            "DersBaslangicBitisSaati" =>    ($menu["DersBaslangicBitisSaati"]), 
            "SinifOgretmenID" =>    ($menu["SinifOgretmenID"]), 
            "DersHavuzuID" =>    ($menu["DersHavuzuID"]), 
            "SinifID" =>    ($menu["SinifID"]), 
            "DersID" =>    ($menu["DersID"]),  
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
     
} 
);
 
/**
 *  * Okan CIRAN
 * @since 24.10.2017
 */
$app->get("/OgrenciVeYakiniDersProgramiListesi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
     
    $vogrenciSeviyeID= NULL;     
    if (isset($_GET['ogrenciSeviyeID'])) {
        $stripper->offsetSet('ogrenciSeviyeID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['ogrenciSeviyeID']));
    } 
    $vKisiID= NULL;     
    if (isset($_GET['ogrenciID'])) {
        $stripper->offsetSet('ogrenciID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['ogrenciID']));
    } 
    $vsinifID= NULL;     
    if (isset($_GET['sinifID'])) {
        $stripper->offsetSet('sinifID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['sinifID']));
    }  
    $vDonemID= NULL;     
    if (isset($_GET['donemID'])) {
        $stripper->offsetSet('donemID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['donemID']));
    }  
           
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
     $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); } 
  
    if ($stripper->offsetExists('ogrenciSeviyeID')) {
        $vogrenciSeviyeID = $stripper->offsetGet('ogrenciSeviyeID')->getFilterValue();
    }
    if ($stripper->offsetExists('ogrenciID')) {
        $vKisiID = $stripper->offsetGet('ogrenciID')->getFilterValue();
    }
    if ($stripper->offsetExists('sinifID')) {
        $vsinifID = $stripper->offsetGet('sinifID')->getFilterValue();
    }
    if ($stripper->offsetExists('donemID')) {
        $vDonemID = $stripper->offsetGet('donemID')->getFilterValue();
    }
    
    $resDataInsert = $BLL->ogrenciVeYakiniDersProgramiListesi(array( 
        'url' => $_GET['url'],   
        'OgrenciSeviyeID' => $vogrenciSeviyeID,   
        'OgrenciID' => $vKisiID,  
        'SinifID' => $vsinifID,   
        'DonemID' => $vDonemID,   
        'dbnamex' => $vdbnamex, 
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(  
            "BaslangicSaati" =>   ($menu["BaslangicSaati"]), 
            "BitisSaati" =>    ($menu["BitisSaati"]), 
            "DersSaati" =>    ($menu["DersSaati"]),  
            "DersSirasi" =>    ($menu["DersSirasi"]),
            "Gun1_SinifDersID" =>   html_entity_decode($menu["Gun1_SinifDersID"]), 
            "Gun2_SinifDersID" =>   html_entity_decode($menu["Gun2_SinifDersID"]), 
           
            "Gun3_SinifDersID" =>   html_entity_decode($menu["Gun3_SinifDersID"]), 
            "Gun4_SinifDersID" =>   html_entity_decode($menu["Gun4_SinifDersID"]), 
            "Gun5_SinifDersID" =>   html_entity_decode($menu["Gun5_SinifDersID"]), 
            "Gun6_SinifDersID" =>   html_entity_decode($menu["Gun6_SinifDersID"]), 
            "Gun7_SinifDersID" =>   html_entity_decode($menu["Gun7_SinifDersID"]), 
            
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
     
} 
);
 
/**
 * Okan CIRAN
 * @since 26-09-2017 
 */
$app->get("/KurumPersoneliSinifListesi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();        
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $headerParams = $app->request()->headers(); 
     
    $vdersYiliID = '-1';     
    if (isset($_GET['dersYiliID'])) {
        $stripper->offsetSet('dersYiliID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['dersYiliID']));
    }
   
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
     $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); } 
    if ($stripper->offsetExists('dersYiliID')) {
        $vdersYiliID = $stripper->offsetGet('dersYiliID')->getFilterValue();
    } 
    $resDataMenu = $BLL->kurumPersoneliSinifListesi(array(      
                                            'DersYiliID' => $vdersYiliID, 
                                            'dbnamex' => $vdbnamex, 
                                            'Cid' => $vCid, 
                                           ) ); 
    $menus = array();
    foreach ($resDataMenu as $menu){
        $menus[]  = array(
             "SinifID" => $menu["SinifID"], 
             "SinifKodu" => html_entity_decode($menu["SinifKodu"]), 
             "SinifAdi" => html_entity_decode($menu["SinifAdi"]), 
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
  
});
 
/**
 *  * Okan CIRAN
 * @since 24.10.2017
 */
$app->get("/KurumPersoneliDersProgramiListesi_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
      
    $vsinifID= NULL;     
    if (isset($_GET['sinifID'])) {
        $stripper->offsetSet('sinifID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['sinifID']));
    }  
    $vDonemID= NULL;     
    if (isset($_GET['donemID'])) {
        $stripper->offsetSet('donemID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['donemID']));
    }  
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
     $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    } 
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); } 
    if ($stripper->offsetExists('sinifID')) {
        $vsinifID = $stripper->offsetGet('sinifID')->getFilterValue();
    }
    if ($stripper->offsetExists('donemID')) {
        $vDonemID = $stripper->offsetGet('donemID')->getFilterValue();
    }
    
    $resDataInsert = $BLL->kurumPersoneliDersProgramiListesi(array( 
        'url' => $_GET['url'],    
        'SinifID' => $vsinifID,   
        'DonemID' => $vDonemID, 
        'dbnamex' => $vdbnamex,  
         'Cid' => $vCid, 
        )); 
  
    $menus = array();
    foreach ($resDataInsert as $menu){
        $menus[]  = array(  
            "BaslangicSaati" =>   ($menu["BaslangicSaati"]), 
            "BitisSaati" =>    ($menu["BitisSaati"]), 
            "DersSaati" =>    ($menu["DersSaati"]),  
            "DersSirasi" =>    ($menu["DersSirasi"]),
            "Gun1_SinifDersID" =>   html_entity_decode($menu["Gun1_SinifDersID"]), 
            "Gun2_SinifDersID" =>   html_entity_decode($menu["Gun2_SinifDersID"]),  
            "Gun3_SinifDersID" =>   html_entity_decode($menu["Gun3_SinifDersID"]), 
            "Gun4_SinifDersID" =>   html_entity_decode($menu["Gun4_SinifDersID"]), 
            "Gun5_SinifDersID" =>   html_entity_decode($menu["Gun5_SinifDersID"]), 
            "Gun6_SinifDersID" =>   html_entity_decode($menu["Gun6_SinifDersID"]), 
            "Gun7_SinifDersID" =>   html_entity_decode($menu["Gun7_SinifDersID"]), 
            
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
     
} 
);

/**
 * Okan CIRAN
 * @since 25-10-2017 
 */
$app->get("/SinifSeviyeleriCombo_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();        
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $headerParams = $app->request()->headers(); 
     
    $vdersYiliID= null;     
    if (isset($_GET['dersYiliID'])) {
        $stripper->offsetSet('dersYiliID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['dersYiliID']));
    }
   
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); } 
    if ($stripper->offsetExists('dersYiliID')) {
        $vdersYiliID = $stripper->offsetGet('dersYiliID')->getFilterValue();
    } 
    $resDataMenu = $BLL->sinifSeviyeleriCombo(array(      
                                            'DersYiliID' => $vdersYiliID, 
                                            'dbnamex' => $vdbnamex, 
                                            'Cid' => $vCid, 
                                           ) ); 
    $menus = array();
    foreach ($resDataMenu as $menu){
        $menus[]  = array(
             "SeviyeID" => $menu["SeviyeID"], 
             "SeviyeAdi" => html_entity_decode($menu["SeviyeAdi"]),   
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
  
});

/**
 * Okan CIRAN
 * @since 25-10-2017 
 */
$app->get("/SinifSeviyeleri_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();        
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $headerParams = $app->request()->headers(); 
     
    $vdersYiliID= null;     
    if (isset($_GET['dersYiliID'])) {
        $stripper->offsetSet('dersYiliID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['dersYiliID']));
    }
    $vseviyeID= null;     
    if (isset($_GET['seviyeID'])) {
        $stripper->offsetSet('seviyeID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['seviyeID']));
    }
   
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
     $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); } 
    if ($stripper->offsetExists('dersYiliID')) {
        $vdersYiliID = $stripper->offsetGet('dersYiliID')->getFilterValue();
    } 
     if ($stripper->offsetExists('seviyeID')) {
        $vseviyeID = $stripper->offsetGet('seviyeID')->getFilterValue();
    }  
    
    $resDataMenu = $BLL->sinifSeviyeleri(array(      
                                            'DersYiliID' => $vdersYiliID, 
                                            'SeviyeID' => $vseviyeID,
                                            'dbnamex' => $vdbnamex,
                                            'Cid' => $vCid, 
                                           ) ); 
    $menus = array();
    foreach ($resDataMenu as $menu){
        $menus[]  = array(
             "SinifID" => $menu["SinifID"], 
             "DersYiliID" => $menu["DersYiliID"], 
             "SeviyeID" => $menu["SeviyeID"], 
             "SinifKodu" => html_entity_decode($menu["SinifKodu"]),   
             "SinifAdi" => html_entity_decode($menu["SinifAdi"]),   
             "SinifMevcudu" => $menu["SinifMevcudu"],  
             "HaftalikDersSaati" => html_entity_decode($menu["HaftalikDersSaati"]),   
                 
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
  
});



/**
 * Okan CIRAN
 * @since 25-10-2017 
 */
$app->get("/GnlProfil_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();        
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $headerParams = $app->request()->headers(); 
     
    $vKisiId = NULL;     
    if (isset($_GET['kisiID'])) {
        $stripper->offsetSet('kisiID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiID']));
    }     
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
     $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
    if ($stripper->offsetExists('kisiID')) {
        $vKisiId = $stripper->offsetGet('kisiID')->getFilterValue();
    } 
    $resDataMenu = $BLL->gnlProfil(array(      
                                        'KisiID' => $vKisiId,  
                                        'dbnamex' => $vdbnamex,  
                                        'Cid' => $vCid, 
                                           ) ); 
    $menus = array();
    foreach ($resDataMenu as $menu){
        $menus[]  = array(
             "KisiID" => $menu["KisiID"], 
             "CinsiyetID" => $menu["CinsiyetID"], 
             "TCKimlikNo" => $menu["TCKimlikNo"], 
             "Adi" => html_entity_decode($menu["Adi"]),   
             "Soyadi" => html_entity_decode($menu["Soyadi"]),   
             "ePosta" => $menu["ePosta"],  
             "AdiSoyadi" => html_entity_decode($menu["AdiSoyadi"]),   
             "Yasamiyor" => $menu["Yasamiyor"], 
             "TCKimlikNo" => $menu["TCKimlikNo"], 
            // EPostaSifresi 
                 
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
  
});

/**
 * Okan CIRAN
 * @since 25-10-2017 
 */
$app->get("/KurumVePersonelDevamsizlik_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();        
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $headerParams = $app->request()->headers(); 
     
    $vtarih = NULL;     
    if (isset($_GET['tarih'])) {
        $stripper->offsetSet('tarih', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['tarih']));
    } 
    $vdersYiliID= null;     
    if (isset($_GET['dersYiliID'])) {
        $stripper->offsetSet('dersYiliID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['dersYiliID']));
    }
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
  
    if ($stripper->offsetExists('tarih')) {
        $vtarih = $stripper->offsetGet('tarih')->getFilterValue();
    }
     if ($stripper->offsetExists('dersYiliID')) {
        $vdersYiliID = $stripper->offsetGet('dersYiliID')->getFilterValue();
    } 
    
    $resDataMenu = $BLL->kurumVePersonelDevamsizlik(array(      
                                            'Tarih' => $vtarih,  
                                            'DersYiliID' => $vdersYiliID,  
                                            'dbnamex' => $vdbnamex, 
                                            'Cid' => $vCid, 
                                           ) ); 
    $menus = array();
    foreach ($resDataMenu as $menu){
        $menus[]  = array(
            "Tarih" => $menu["Tarih"],  
            "Adi" => html_entity_decode($menu["Adi"]),   
            "Soyadi" => html_entity_decode($menu["Soyadi"]), 
            "Adsoyad" => html_entity_decode($menu["adsoyad"] ),
            "Numarasi" => $menu["Numarasi"], 
            "OgrenciDevamsizlikID" => $menu["OgrenciDevamsizlikID"], 
            "DersYiliID" => $menu["DersYiliID"],  
            "DevamsizlikKodID" => $menu["DevamsizlikKodID"], 
            "DevamsizlikPeriyodID" => $menu["DevamsizlikPeriyodID"], 
            "Aciklama" => html_entity_decode($menu["Aciklama"]),  
            "DevamsizlikKodu" => html_entity_decode($menu["DevamsizlikKodu"]),  
            "DevamsizlikAdi" => html_entity_decode($menu["DevamsizlikAdi"]),  
            "DevamsizlikPeriyodu" => html_entity_decode($menu["DevamsizlikPeriyodu"]),  
            "rownum" => $menu["rownum"],   
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
  
});


/**
 * Okan CIRAN
 * @since 25-10-2017 
 */
$app->get("/MuhBorcluSozlesmeleri_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();        
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $headerParams = $app->request()->headers(); 
     
    $vOgrenciID = NULL;     
    if (isset($_GET['ogrenciID'])) {
        $stripper->offsetSet('ogrenciID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['ogrenciID']));
    }   
    $vdersYiliID= null;     
    if (isset($_GET['dersYiliID'])) {
        $stripper->offsetSet('dersYiliID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['dersYiliID']));
    }
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
   
    if ($stripper->offsetExists('dersYiliID')) {
        $vdersYiliID = $stripper->offsetGet('dersYiliID')->getFilterValue();
    } 
    if ($stripper->offsetExists('ogrenciID')) {
        $vOgrenciID = $stripper->offsetGet('ogrenciID')->getFilterValue();
    }
    
    $resDataMenu = $BLL->muhBorcluSozlesmeleri(array(      
                                            'OgrenciID' => $vOgrenciID,  
                                            'DersYiliID' => $vdersYiliID,  
                                            'dbnamex' => $vdbnamex, 
                                            'Cid' => $vCid, 
                                           ) ); 
    $menus = array();
    foreach ($resDataMenu as $menu){
        $menus[]  = array(
            "OdenecekTutarKDVHaric" => $menu["OdenecekTutarKDVHaric"],  
            "OdenecekKDV" => $menu["OdenecekKDV"],  
             "OdenecekTutarKDVDahil" => $menu["OdenecekTutarKDVDahil"],  
             "YakinTuru" => html_entity_decode($menu["YakinTuru"]),  
             "BorcluBanka" => html_entity_decode($menu["BorcluBanka"]),  
             "TaahhutnameNo" => $menu["TaahhutnameNo"],  
             "IslemNumarasi" => $menu["IslemNumarasi"],  
             "OdemeSekliAciklama" =>html_entity_decode( $menu["OdemeSekliAciklama"]),  
             "TaahhutnameTarihi" => $menu["TaahhutnameTarihi"],  
             "ToplamTutar" => $menu["ToplamTutar"],  
             "Pesinat" => $menu["Pesinat"],  
             "NetTutar" => $menu["NetTutar"],  
             "ToplamOdenen" => $menu["ToplamOdenen"],  
             "KalanTutar" => $menu["KalanTutar"],  
             "ToplamIndirim" => $menu["ToplamIndirim"],  
             "ToplamIndirimYuzdesi" => $menu["ToplamIndirimYuzdesi"],  
             "IndirimliTutar" => $menu["IndirimliTutar"],  
             "PesinatOdemeTarihi" => $menu["PesinatOdemeTarihi"],
             "PesinatAlindi" => $menu["PesinatAlindi"], 
            "SozlesmelerAciklama" => html_entity_decode($menu["SozlesmelerAciklama"]),   
            "BorcluAdiSoyadi" => html_entity_decode($menu["BorcluAdiSoyadi"]), 
            "TaksitSayisi" => $menu["TaksitSayisi"],
            "BorcluSozlesmeID" => $menu["BorcluSozlesmeID"],
            
            
            
             
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
  
});


/**
 * Okan CIRAN
 * @since 25-10-2017 
 */
$app->get("/MuhBorcluOdemePlani_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();        
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $headerParams = $app->request()->headers(); 
     
    $vBorcluSozlesmeID = NULL;     
    if (isset($_GET['borcluSozlesmeID'])) {
        $stripper->offsetSet('borcluSozlesmeID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['borcluSozlesmeID']));
    }   
    
    $vdbnamex = NULL;
    if (isset($_GET['dbn'])) {
        $stripper->offsetSet('dbn', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                                                                $app, 
                                                                $_GET['dbn']));
    }  
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('dbn')) 
        {$vdbnamex = $stripper->offsetGet('dbn')->getFilterValue(); }  
   
    if ($stripper->offsetExists('borcluSozlesmeID')) {
        $vBorcluSozlesmeID = $stripper->offsetGet('borcluSozlesmeID')->getFilterValue();
    } 
   
    $resDataMenu = $BLL->muhBorcluOdemePlani(array(      
                                            'BorcluSozlesmeID' => $vBorcluSozlesmeID,   
                                            'dbnamex' => $vdbnamex, 
                                            'Cid' => $vCid, 
                                           ) ); 
    $menus = array();
    foreach ($resDataMenu as $menu){
        $menus[]  = array(
             "TaksitNo" => $menu["TaksitNo"],  
             "OdemeTarihi" => $menu["OdemeTarihi"],             
             "TaksitTutari" => $menu["TaksitTutari"],  
             "Odendi" =>  ($menu["Odendi"]),  
             "OdemeAciklamasi" => html_entity_decode($menu["OdemeAciklamasi"]),  
             "Odendi_aciklama" => html_entity_decode($menu["Odendi_aciklama"]),  
             "OdenenTutar" => $menu["OdenenTutar"],  
              
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
  
});

/**
 * Okan CIRAN
 * @since 25-10-2017 
 */
$app->get("/DashboarddataDersProgrami_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();        
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $headerParams = $app->request()->headers(); 
     
    $vkisiId = NULL;     
    if (isset($_GET['kisiId'])) {
        $stripper->offsetSet('kisiId', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiId']));
    }
    $vRolId = NULL;     
    if (isset($_GET['rolId'])) {
        $stripper->offsetSet('rolId', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['rolId']));
    }
    $vKurumID = NULL;     
    if (isset($_GET['kurumID'])) {
        $stripper->offsetSet('kurumID', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kurumID']));
    }
    
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    } 
    if ($stripper->offsetExists('kisiId')) {
        $vkisiId = $stripper->offsetGet('kisiId')->getFilterValue();
    } 
    if ($stripper->offsetExists('kurumID')) {
        $vKurumID = $stripper->offsetGet('kurumID')->getFilterValue();
    } 
    if ($stripper->offsetExists('rolId')) {
        $vRolId = $stripper->offsetGet('rolId')->getFilterValue();
    } 
   
    $resDataMenu = $BLL->dashboarddataDersProgrami(array(      
                                            'KisiID' => $vkisiId,   
                                            'KurumID' => $vKurumID, 
                                            'RolID' => $vRolId,  
                                            'Cid' => $vCid, 
                                           ) ); 
    $menus = array();
    foreach ($resDataMenu as $menu){
        $menus[]  = array(
            "DersSaati" => $menu["DersSaati"],   
            "SinifAdi" => html_entity_decode($menu["SinifAdi"]),  
            "ogretmen" => html_entity_decode($menu["ogretmen"]),   
            "ogrenci" => html_entity_decode($menu["ogrenci"]),   
             
            "Alan1" => html_entity_decode($menu["Alan1"]),  
            "Alan2" => html_entity_decode($menu["Alan2"]),  
            "Alan3" => html_entity_decode($menu["Alan3"]),  
            "Alan4" => html_entity_decode($menu["Alan4"]),  
            
        );
    }
    
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
  
});

 
/**
 * Okan CIRAN
 * @since 25-10-2017 
 */
$app->get("/DashboardIconCounts_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory();        
    $BLL = $app->getBLLManager()->get('mblLoginBLL'); 
    $headerParams = $app->request()->headers(); 
     
    $vkisiId = NULL;     
    if (isset($_GET['kisiId'])) {
        $stripper->offsetSet('kisiId', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiId']));
    }
    $vRolId = NULL;     
    if (isset($_GET['rolId'])) {
        $stripper->offsetSet('rolId', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['rolId']));
    }
    
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
     if ($stripper->offsetExists('kisiId')) {
        $vkisiId = $stripper->offsetGet('kisiId')->getFilterValue();
    } 
    if ($stripper->offsetExists('rolId')) {
        $vRolId = $stripper->offsetGet('rolId')->getFilterValue();
    } 
   
    $resDataMenu = $BLL->dashboardIconCounts(array(      
                                            'KisiID' => $vkisiId,   
                                            'RolID' => $vRolId,  
                                            'Cid' => $vCid, 
                                           ) ); 
    $menus = array();
    foreach ($resDataMenu as $menu){
        $menus[]  = array(
             "adet" => $menu["adet"],   
             "tip" => html_entity_decode($menu["tip"]),  
             "aciklama" => html_entity_decode($menu["aciklama"]),   
              "url" => $menu["url"],
        );
    }
 
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($menus));
  
});

 /** 
 *  * Okan CIRAN
 * @since 05.10.2017
 * rest servislere eklendi
 */
$app->get("/SendMesajDefault_mbllogin/", function () use ($app ) {
    $stripper = $app->getServiceManager()->get('filterChainerCustom');
    $stripChainerFactory = new \Services\Filter\Helper\FilterChainerFactory(); 
    $BLL = $app->getBLLManager()->get('mblLoginBLL');  
    $headerParams = $app->request()->headers();
      
    $vKisiId = NULL;     
    if (isset($_GET['kisiId'])) {
        $stripper->offsetSet('kisiId', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['kisiId']));
    } 
    $vKonu = NULL;     
    if (isset($_GET['konu'])) {
        $stripper->offsetSet('konu', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['konu']));
    }
    $vMesaj = NULL;     
    if (isset($_GET['mesaj'])) {
        $stripper->offsetSet('mesaj', $stripChainerFactory->get(stripChainers::FILTER_PARANOID_LEVEL2, 
                $app, $_GET['mesaj']));
    } 
    $vCid = NULL;   
    if (isset($_GET['cid'])) {
        $stripper->offsetSet('cid', $stripChainerFactory->get(stripChainers::FILTER_ONLY_NUMBER_ALLOWED, 
                $app, $_GET['cid']));
    }
    $stripper->strip();
    if ($stripper->offsetExists('cid')) {
        $vCid = $stripper->offsetGet('cid')->getFilterValue();
    }
    if ($stripper->offsetExists('konu')) 
        {$vKonu = $stripper->offsetGet('konu')->getFilterValue();         
    }  
    if ($stripper->offsetExists('kisiId')) {
        $vKisiId = $stripper->offsetGet('kisiId')->getFilterValue();
    }
    if ($stripper->offsetExists('mesaj')) {
        $vMesaj = $stripper->offsetGet('mesaj')->getFilterValue();
    } 
   
    $resDataInsert = $BLL->sendMesajDefault(array(
            'KisiID' => $vKisiId,  
            'Konu' => $vKonu, 
            'Mesaj' => $vMesaj,  
            'Cid' => $vCid, 
             ));
        
    $app->response()->header("Content-Type", "application/json"); 
    $app->response()->body(json_encode($resDataInsert)); 
    
}
);

$app->run();
