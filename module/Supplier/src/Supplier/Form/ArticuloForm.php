<?php
namespace Supplier\Form;

use Zend\Form\Form;

class ArticuloForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct($name);
        
        
        $this->setAttributes(array(
            'action'=>"",
            'method' => 'post'
        ));
        
        
        $this->add(array(
            'name' => 'articulo',
            'options' => array(
                'label' => 'Articulo: ',
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'input form-control',
                'required'=>'required'
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Enviar',
                'title' => 'Enviar',
                'class' => 'btn btn-success'
            ),
        ));
        
       
        
    }
}