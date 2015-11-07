<?php

namespace Invreon\SafeSpace\Controllers;

use Invreon\SafeSpace\Entities\User;
use Invreon\SafeSpace\Services\DoctrineService;
use Invreon\SafeSpace\Services\TwigService;
use Abraham\TwitterOAuth\TwitterOAuth;
use Symfony\Component\HttpFoundation\Request;
use Invreon\SafeSpace\Repositories\UserRepository;

/**
 * Class PageController
 * @package Invreon\SafeSpace\Controllers
 */
class PageController extends Controller
{
    public function home()
    {
        $twigService = new TwigService();
        $twigService->setTwigDirectory('Public');

        $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);

        $requestToken = $connection->oauth('oauth/request_token', array('oauth_callback' => TWITTER_OAUTH_CALLBACK));

        $user = new User();
        $user->setOAuthToken($requestToken['oauth_token']);
        $user->setOAuthSecret($requestToken['oauth_token_secret']);

        /** @var UserRepository $userRepository */
        $userRepository = (new DoctrineService())->getRepository('User');

        $userRepository->create($user);

        $loginUrl = $connection->url('oauth/authorize', array('oauth_token' => $requestToken['oauth_token']));

        $context['login_url'] = $loginUrl;

        return $this->createResponse($twigService->render('Home.html.twig', $context));
    }

    public function about()
    {
        $twigService = new TwigService();
        $twigService->setTwigDirectory('Public');

        $context['active'] = $this->session->has('username');

        return $this->createResponse($twigService->render('About.html.twig', $context));
    }

    public function login()
    {
        $twigService = new TwigService();
        $twigService->setTwigDirectory('Public');

        $context['active'] = $this->session->has('username');

        return $this->createResponse($twigService->render('Login.html.twig', $context));
    }

    public function twitter(Request $request)
    {
        $twigService = new TwigService();
        $twigService->setTwigDirectory('Public');

        $requestToken = [];
        $requestToken['oauth_token'] = $request->get('oauth_token');
        $requestToken['oauth_verifier'] = $request->get('oauth_verifier');

        $context = [];

        if (isset($requestToken['oauth_token']) && isset($requestToken['oauth_token'])) {
            $doctrine = new DoctrineService();

            $entityManager = $doctrine->getManager();
            /** @var User $user */
            $user = $entityManager->getRepository('User')->findOneBy(['oauth_token' => $requestToken['oauth_token']]);

            $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $user->getOAuthToken(), $user->getOAuthSecret());

            $access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $requestToken['oauth_verifier']));

            var_dump($access_token); die();
//            $user->setOAuthUid( $requestToken['oauth_token']);

            // obtaining the entity manager
            $user->setOAuthProvider($access_token);
            $entityManager->persist($user);
            $entityManager->flush();

            $context['user'] = $connection->get("account/verify_credentials");

            return $this->createResponse($twigService->render('Home.html.twig', $context));
        }

        return $this->createResponse($twigService->render('Home.html.twig', $context));
    }
}
