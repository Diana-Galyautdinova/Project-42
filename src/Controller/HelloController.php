<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{
    /**
     * @Route("/hello/world")
     */
    public function world()
    {
        return new Response(  	'<html><body>Hello world</body></html>' 	);
    }
}

