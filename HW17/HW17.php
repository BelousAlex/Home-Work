<?php
require_once 'config.php';

if(isset($_GET['action'])){ 
    if($_GET['action'] == 'insert'){
        if($_POST['id_type'] == 1){
            $ad = new PrivatePersonAds($_POST);
            $ad->insert();
        } else {
            $ad = new CompanyAds($_POST);
            $ad->insert();
        }
        
    } elseif($_GET['action'] == 'change'){
        $ad = new Ads($_POST);
        $ad->change();
        
    } elseif($_GET['action'] == 'change_ad'){
        $ad = new Ads($_POST);
        $ad->change_ad();
        
    } elseif($_GET['action'] == 'delete'){
        $ad = new Ads($_POST);
        $ad->delete();
        
    } elseif($_GET['action'] == 'reset'){
        $ad = new Ads($_POST);
        $ad->reset();
    }
    
    elseif($_GET['action'] == 'fullAd'){
        $ad = new Ads($_POST);
        $ad->full_ad();
    }
    
} else {
    $main = AdsStore::instance();
    $main->getAllAdsFromDb();
    $main->writeOut();

    $smarty->display('HW17.tpl');
}