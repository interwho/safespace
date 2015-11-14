<?php

namespace Invreon\SafeSpace\Controllers;

use Invreon\SafeSpace\Entities\User;
use Invreon\SafeSpace\Services\DoctrineService;
use Invreon\SafeSpace\Services\TweetFilterService;
use Abraham\TwitterOAuth\TwitterOAuth;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PageController
 * @package Invreon\SafeSpace\Controllers
 */
class PageController extends Controller
{
    public function home()
    {
        $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);

        $requestToken = $connection->oauth('oauth/request_token', array('oauth_callback' => TWITTER_OAUTH_CALLBACK));

        $user = new User();
        $user->setOAuthToken($requestToken['oauth_token']);
        $user->setOAuthSecret($requestToken['oauth_token_secret']);

        $em = (new DoctrineService())->getManager();
        $em->persist($user);
        $em->flush($user);

        $loginUrl = $connection->url('oauth/authorize', array('oauth_token' => $requestToken['oauth_token']));

        $context['login_url'] = $loginUrl;

        return $this->createResponse($this->render('Home.html.twig', $context));
    }

    public function about()
    {
        $context['active'] = $this->session->has('username');

        return $this->createResponse($this->render('About.html.twig', $context));
    }

    public function contact()
    {
        $context['active'] = $this->session->has('username');

        return $this->createResponse($this->render('Contact.html.twig', $context));
    }

    public function twitter(Request $request)
    {
        $requestToken = [];
        $requestToken['oauth_token'] = $request->get('oauth_token');
        $requestToken['oauth_verifier'] = $request->get('oauth_verifier');

        $context = [];

        if (isset($requestToken['oauth_token'])) {
            $doctrine = new DoctrineService();

            /** @var User $user */
            $user = $doctrine->getRepository('User')->findOneBy(['oauth_token' => $requestToken['oauth_token']]);

            $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $user->getOAuthToken(), $user->getOAuthSecret());

            $accessToken = $connection->oauth("oauth/access_token", array("oauth_verifier" => $requestToken['oauth_verifier']));

            // Grab full user information and store
            $user->setOAuthProvider($requestToken['oauth_verifier']);

            $user->setOAuthToken($accessToken['oauth_token']);
            $user->setOAuthSecret($accessToken['oauth_token_secret']);
            $user->setOAuthUid($accessToken['user_id']);
            $user->setUsername($accessToken['screen_name']);

            $em = (new DoctrineService())->getManager();
            $em->persist($user);
            $em->flush($user);

            // Grab tweets with a new connection
            $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $user->getOAuthToken(), $user->getOAuthSecret());

            $context['tweets'] = (new TweetFilterService())->searchAndFilterTweets($user->getUsername(), $connection);

            return $this->createResponse($this->render('Home.html.twig', $context));
        }

        return $this->createResponse($this->render('Home.html.twig', $context));
    }

    public function search(Request $request)
    {
        $searchString = $request->get('searchString');

        // Make connection
        $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

        $context['tweets'] = (new TweetFilterService())->searchAndFilterTweets($searchString, $connection);

        return $this->createResponse($this->render('Home.html.twig', $context));
    }
}
