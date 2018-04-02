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
//         print_r($decodePostData['hora']);
        
        
//         $date = new DateTime('2000-01-01');
//         echo $date->format('Y-m-d H:i:s');
        
        $date = date_create($decodePostData['hora']);
       $horaIngresada= date_format($date, 'Y-m-d H:i:s');
//         exit;
        
        try {       
            $time = new DateTime();
            $filter = new Decrypt();
            $filter->setKey('key');
            $result = $filter->filter($decodePostData['token']);
//             print_r($result);exit;
            $res = array();
//             $validaToken = $this->getGuardarTokenModel()->validaToken($result);
            $tiempo=$this->getGuardarTokenModel()->validaFechaHora($result,$decodePostData);
//             print_r("     ---- hora base  ---> ");
//              print_r( strtotime ($tiempo[0]['hora']));
//             print_r("       ------------      ");
            $date = date_create($tiempo[0]['hora']);
            $horaBase= date_format($date, 'Y-m-d H:i:s');
            $date->modify('20 minutes');
            $hora = (date_format($date, 'Y-m-d H:i:s'));
//             print_r(date_format($date, 'Y-m-d H:i:s'));
            
            if($decodePostData['fecha'] == $tiempo[0]['fecha']){
//                 print_r("    verdadero en fecha    ");
                if($horaIngresada>=$horaBase && $horaIngresada<=$hora){
                   
                    $validaToken = $this->getGuardarTokenModel()->validaToken($result);
                    $res['status'] = true;
//                     print_r("    verdadero hora");
                }
//                 $res['status'] = false;
            }
        
        
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