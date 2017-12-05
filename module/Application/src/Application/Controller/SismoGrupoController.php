<?php
/**
 * @autor JuanMS
 * Controlador para las peticiones de sismos
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\SismoGrupoService;

class SismoGrupoController extends AbstractActionController
{

    private $sismoGrupoService;

    public function getSismoService(){
    	return $this->sismoGrupoService = new SismoGrupoService();
    }

    public function buscarSismosAction(){
        echo "HOLA BUSCAR SISMOS ";exit;
    	/**$request = $this->getRequest();
    	if ($request->isPost()) {
    		$postData       = $this->getRequest()->getContent();
    		$decodePostData = json_decode($postData, true);
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $decodePostData,
            )));
            //echo print_r($decodePostData);exit;
        	//return $response; exit;
            
            // PARSEAMOS JSON A ARRAY PHP
            $result = $this->getUsuarioService()->addUsuario($decodePostData);

            echo print_r($result);exit;
    	}**/

    	
    }

}