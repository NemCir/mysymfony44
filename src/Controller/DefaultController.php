<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\GiftsService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_default")
     */
    public function index(GiftsService $giftsService): Response
    {
        //$this->addFlash('notice', 'Notice message!');
        //$this->addFlash('warning', 'Warning message!');
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
       
        return $this->render('default/index.html.twig', [ 
            'controller_name' => 'DefaultController',
            'users' => $users,
            'random_gift' => $giftsService->gifts,
        ]);
    }

    /**
     * @Route("/blog/{page?}", name="blog_list", requirements={"page"="\d+"})
     */
    public function index2() {
        return new Response('Advanced route 2');
    }

    /**
     * @Route(
     *      "/articles/{_locale}/{year}/{slug}/{category}", 
     *      defaults={"category": "computers"},
     *      requirements={
     *          "_locale":"en|fr",
     *          "category":"computers|rtv",
     *          "year":"\d+"
     *      }
     * )
     */
    public function index3() {
        return new Response('Advanced route 3');
    }

    /**
     * @Route(
     *      {
     *          "nl":"/over-ons",
     *          "en":"/about-us"
     *      }, name="about_us"
     * )
     */
    public function index4() {
        return new Response('Translated routes');
    }

    /**
     * @Route("/cookiepage")
     */
    public function index5() {
        $cookie = new Cookie('my_cookie', 'cookie value', time() + 35);

        $res = new Response();
        $res->headers->setCookie($cookie);
        //$res->headers->clearCookie('my_cookie');
        $res->send();

        return $res;
    }
}
