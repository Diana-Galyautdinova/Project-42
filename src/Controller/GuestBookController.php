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
        if ($page == 1) {
            return $this->render(
                'index1.html.twig', [
                    'comments' => $this->memcached->get($this->key),
                ]
            );
        }
        else if ($page == 2) {
            return $this->render(
                'index2.html.twig', [
                    'comments' => $this->memcached->get($this->key),
                ]
            );
        }
        else if ($page == 3) {
            return $this->render(
                'index3.html.twig', [
                    'comments' => $this->memcached->get($this->key),
                ]
            );
        }
    }

    /**
     * @Route("/guest/book/save")
     */
    public function save(Request $request)
    {
        /** @var array[] $comments */
        if ($request->query->get('text')) {
            $comments = $this->memcached->get($this->key);
            $comments[] = [
                'text' => $request->query->get('text'),
                'time' => time(),
            ];

            $this->memcached->set($this->key, $comments);
        }

        return $this->redirect('/guest/book');
    }

}

