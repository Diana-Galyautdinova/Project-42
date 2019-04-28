<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ConverterController extends AbstractController
{

    /**
     * @Route("/", name="converter")
     */
    public function index(Request $request)
    {
        $converters = [
            'from' => [
                'json' => [
                    'run' => 'json_decode',
                    'args' => [true]
                ],
                'serialize' => [
                    'run' => 'unserialize',
                    'args' => []
                ],
                'yaml' => [
                    'run' => '\Symfony\Component\Yaml\Yaml::parse',
                    'args' => []
                ],
            ],
            'to' => [
                'json' => [
                    'run' => 'json_encode',
                    'args' => []
                ],
                'serialize' => [
                    'run' => 'serialize',
                    'args' => []
                ],
                'yaml' => [
                    'run' => '\Symfony\Component\Yaml\Yaml::dump',
                    'args' => []
                ],
            ],
        ];

        $formats = array_keys($converters['from']);

        $from_format = $request->request->get('from-format', 'json');
        $from_text = $request->request->get('from-text', '');
        $to_format = $request->request->get('to-format', 'json');

        $from = $converters['from'][$from_format];
        $to = $converters['to'][$to_format];

        $to_text = $to['run'](
            $from['run']($from_text, ...$from['args']) ?: '',
            ...$to['args']
        ) ?: '';

        $data = compact('from_format', 'from_text', 'to_format', 'to_text', 'formats');

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'response' => $data
            ]);
        }
        return $this->render('Converter/index.html.twig', $data);
    }
}
