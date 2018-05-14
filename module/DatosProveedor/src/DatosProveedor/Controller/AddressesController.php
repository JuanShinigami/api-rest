<?php
namespace DatosProveedor\Controller;

use DatosProveedor\Services\DistrictService;
use DatosProveedor\Services\NeighborhoodService;

class AddressesController extends BaseController
{
	public function indexAction(){
	    echo "index Addresses";exit;
	}
	// Municipios y delegaciones
    public function getalldistrictAction()
    {
    	$districtService = new DistrictService();
    	$request          = $this->getRequest();
        $response         = $this->getResponse();

        if($request->isPost()) {
            $inf = $request->getPost();
            //print_r($inf);exit;
            $district = $districtService->fetchAll($inf['id_state']);
            	
            if($district) {
            	$response->setContent(\Zend\Json\Json::encode(array('response' => "ok", "data" => $district)));
            } else {
            	$response->setContent(\Zend\Json\Json::encode(array('response' => "fail", "data" => "Error desconosido, consulta al administrador *.*")));
            }
        }

        return $response;
    }
    
    // Colonias
    public function getallneighborhoodAction()
    {
    	$neighborhoodService = new NeighborhoodService();
    	$request              = $this->getRequest();
    	$response             = $this->getResponse();
    
    	if($request->isPost()){
    		$inf = $request->getPost();
    		//print_r($inf);exit;
    		$neighborhood = $neighborhoodService->fetchAll($inf['id_district']);
    		 
    		if($neighborhood){
    			$response->setContent(\Zend\Json\Json::encode(array('response' => "ok", "data" => $neighborhood)));
    		}else{
    			$response->setContent(\Zend\Json\Json::encode(array('response' => "fail", "data" => "Error desconosido, consulta al administrador *.*")));
    		}
    	}
    
    	return $response;
    }
 
}
