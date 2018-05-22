<?php
return array(
    'application'=> array(
        "allow"=>array(
            'voluntario/',
            'voluntario/profile',
            'voluntario/voluntarySimulacrumIndividual'
        ),
        "deny"=>array(
               'crud'
        )
    ),
//     'voluntario'=> array(
//         "allow"=>array(
//             'Application\Controller\Index',
//             'Application\Controller\Profile'
//         ),
//         "deny"=>array(
  
//         )
//     ),
);
?>