
<?php

//Define the routes
return [

    'GET service' => 'service/index',

    'POST service/create' => 'service/create',

    'PUT,POST service/update/{id}' => 'service/update',

    'GET service/{id}' => 'service/view',

    
];
