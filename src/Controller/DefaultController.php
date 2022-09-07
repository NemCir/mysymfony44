<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\GiftsService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends AbstractController
{
    public function __construct($logger)
    {
        //use $logger service
    }
    /**
     * @Route("/home/{id?}", name="default", name="home")
     */
    public function index(
        GiftsService $giftsService, Request $request, SessionInterface $session, User $user
    ): Response 
    {
        /*exit($request->cookies->get('PHPSESSID'));
        $this->addFlash('notice', 'Notice message!');
        $this->addFlash('warning', 'Warning message!');
        $session->set('name', 'Nemanja');
        exit($request->query->get('page', 1));//GET
        $request->request->get('page');//POST
        $entityManger = $this->getDoctrine()->getManager();
        $conn = $entityManger->getConnection();

        $sql = 'SELECT * FROM USER u WHERE u.id > :id';

        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['id' => -1]);
        dump($result->fetchAll());
        dump($user);die;//Just type home/1 and user with id 1 will be displayed
        */

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        dump($users);
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

    /**
     * @Route("/generate-url/{param?}", name="generate_url")
     */
    public function generate_url() {
        exit($this->generateUrl(
            'generate_url',//Mora da postoji ova ruta, gore u name npr.
            ['param' => 11],
            UrlGeneratorInterface::ABSOLUTE_URL
        ));
    }

    /**
     * @Route("/download")
     */
    public function download() {
        $path = $this->getParameter('download_directory');

        return $this->file($path.'file.pdf');
    }

    /**
     * @Route("/redirect-test")
     */
    public function redirectTest() {
        return $this->redirectToRoute('route_to_redirect', ['param' => 9]);
    }

    /**
     * @Route("/url-to-redirect/{param?}", name="route_to_redirect")
     */
    public function methodToRedirect() {
        exit('Test redirection');
    }

    /**
     * @Route("/forwarding-to-controller")
     */
    public function forwardingToController() {
        $response = $this->forward('App\Controller\DefaultController::methodForwardTo', ['p' => 3]);
        return $response;
    }

    /**
     * @Route("/url-to-forward-to/{p?}", name="route_to_forward_to")
     */
    public function methodForwardTo($p) {
        exit('Test controller forwarding - '.$p);
    }

    public function mostPopularPosts($number = 3) {
         // database call:
         $posts = ['post 1', 'post 2', 'posts 3', 'posts 4'];
         return $this->render('default/most_popular_posts.html.twig', [
            'posts' => $posts,
         ]);
    }
}

