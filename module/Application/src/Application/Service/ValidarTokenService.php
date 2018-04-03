<?php
namespace Application\Service;

use Application\Model\TokenModel;
use Zend\Filter\Decrypt;
use Zend\Filter\Encrypt;
use Zend\Form\Element\DateTime;
use DateInterval;

class ValidarTokenService
{

    private $guardarToken;

    private function getGuardarTokenModel()
    {
        return $this->guardarToken = new TokenModel();
    }

    public function generarToken($arrayResponse, $id)
    {
        // var_dump($arrayResponse,$id);
        
//         var_dump($arrayResponse,$id);
        
//         exit;
        // ['datos'][0]['id']
        $numero = rand(1, 100);
//         var_dump(rand(1, 100));exit;
        
        $fi = new Encrypt();
        $fi->setKey('key');
        $result = $fi($arrayResponse['correo'] . "/" .  $id['datos'][0]['nombre']. "/" . $id['datos'][0]['id'] . "/" . $numero);
        
        $guardaToken = $this->getGuardarTokenModel()->addToken($result, $id['datos'][0]['id'], $arrayResponse);
  
        // $filter = new Decrypt();
        // $filter->setKey('key');
        // $result2 = $filter->filter($result);
        
        // print_r("-----Des-----sss-------------------------->" . $result2);
        
        // exit;
        return $result;
    }
    
  

    public function validaToken($decodePostData)
    {
//         prINT_R($DECODEPOSTDATA);
//         EXIT;
//         $date = new DateTime('2000-01-01');
//         echo $date->format('Y-m-d H:i:s');
        try {  
            $date = date_create($decodePostData['hora']);
            $horaIngresada= date_format($date, 'Y-m-d H:i:s');
            
            //         exit;
            $time = new DateTime();
            $filter = new Decrypt();
            $filter->setKey('key');
            $result = $filter->filter($decodePostData['token']);
//             print_r($result);exit;
            $res = array();
            if(!empty($result)){
//                 print_r("tiene token");
                $validaToken = $this->getGuardarTokenModel()->validaToken($result);
                $tiempo=$this->getGuardarTokenModel()->validaFechaHora($result,$decodePostData);
                //             print_r("     ---- hora base  ---> ");
                //              print_r( strtotime ($tiempo[0]['hora']));
                //             print_r("       ------------      ");
                $date = date_create($tiempo[0]['hora']);
                $horaBase= date_format($date, 'Y-m-d H:i:s');
                $date->modify('20 minutes');
                $hora = (date_format($date, 'Y-m-d H:i:s'));
                //             print_r(date_format($date, 'Y-m-d H:i:s'));
                
//                 $datos = explode('/', $id, 4);
//                 $resultado = count($datos);
                
//                 print_r($datos);
                if($decodePostData['fecha'] == $tiempo[0]['fecha']){
                    //                 print_r("    verdadero en fecha    ");
                    if($horaIngresada>=$horaBase && $horaIngresada<=$hora){
                        
                        $validaToken = $this->getGuardarTokenModel()->validaToken($result);
                       
//                        print_r($result);
//                        if($validaToken){
//                            $actualiza= $this->getGuardarTokenModel()->updateFechaHora($decodePostData,$datos);
                           $res['status'] = true;
//                        }
                        
                    }
                    //                 $res['status'] = false;
                }
                
            }
// else{
//             print_r(" no tiene token");
//             }
//             exit;
//          
        
        
//             print_r($validaToken);exit;
        
        
        } catch (\Exception $e) {
            $res['status'] = false;
            print_r("Error");
        }
      
//         print_r($res);exit;
        return $res;
    }

    public function updateToken($id)
    {
        
        // print_r($id);
        return $this->getGuardarTokenModel()->updateToken($id);
    }
}
?>