<?php
return array(
    'admin'=> array(
        "allow"=>array(
               'usuarios'
        ),
        "deny"=>array(
               'crud'
        )
    ),
    'voluntario'=> array(
        "allow"=>array(
            'crud',
            'usuarios'
        ),
        "deny"=>array(
  
        )
    ),
);
?>