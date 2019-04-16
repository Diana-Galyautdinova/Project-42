<?php

namespace App\Controller;

use Memcached;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GuestBookController extends AbstractController
{
    /**
     * @var \Memcached
     */
    protected $memcached;

    protected $key = 'guest.book';

    public function __construct()
    {
        $this->memcached = new Memcached();
        $this->memcached->addServer('127.0.0.1', 11211);
    }

    /**
     * @Route("/guest/book/{page}", name="page", requirements={"page"="\d+"})
     */
    public function list($page)
    {
        $template = ($page > 0 && $page <= 3) ? 'index' . $page . '.html.twig' : 'index1.html.twig';
        return $this->render(
            $template, [
                'comments' => $this->memcached->get($this->key),
                'page' => $page,
            ]
        );
    }

    /**
     * @Route("/guest/book/save")
     */
    public function save(Request $request)
    {
        if ($request->query->get('text')) {
            /** @var array[] $comments */
            $comments = $this->memcached->get($this->key);
            $comments[] = [
                'text' => $request->query->get('text'),
                'time' => time(),
            ];

            $this->memcached->set($this->key, $comments);
        }

        return $this->redirect('/guest/book/'.$request->query->get('page'));
    }

}

