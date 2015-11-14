<?php

namespace Invreon\SafeSpace\Controllers;

use Invreon\SafeSpace\Entities\User;
use Invreon\SafeSpace\Services\DoctrineService;
use Invreon\SafeSpace\Services\SentimentAnalysisService;
use Invreon\SafeSpace\Services\TwigService;
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
        $twigService = new TwigService();
        $twigService->setTwigDirectory('Public');

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

        return $this->createResponse($twigService->render('Home.html.twig', $context));
    }

    public function about()
    {
        $twigService = new TwigService();
        $twigService->setTwigDirectory('Public');

        $context['active'] = $this->session->has('username');

        return $this->createResponse($twigService->render('About.html.twig', $context));
    }

    public function contact()
    {
        $twigService = new TwigService();
        $twigService->setTwigDirectory('Public');

        $context['active'] = $this->session->has('username');

        return $this->createResponse($twigService->render('Contact.html.twig', $context));
    }

    public function twitter(Request $request)
    {
        $twigService = new TwigService();
        $twigService->setTwigDirectory('Public');

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

            $context['tweets'] = $this->searchAndFilterTweets($user->getUsername(), $connection);

            return $this->createResponse($twigService->render('Home.html.twig', $context));
        }

        return $this->createResponse($twigService->render('Home.html.twig', $context));
    }

    public function search(Request $request)
    {
        $twigService = new TwigService();
        $twigService->setTwigDirectory('Public');

        $searchString = $request->get('searchString');

        // Make connection
        $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

        $context['tweets'] = $this->searchAndFilterTweets($searchString, $connection);

        return $this->createResponse($twigService->render('Home.html.twig', $context));
    }

    /**
     * Sends a request to twitter for tweets, and filters out negative ones
     * @param $searchString string
     * @param $connection TwitterOAuth
     * @return array
     */
    private function searchAndFilterTweets($searchString, $connection)
    {
        $recentTweets = $connection->get("search/tweets", array(
                "q" => "@" . $searchString
            )
        );

        $parsedTweets = $this->parseSearchResults($recentTweets->statuses);

        return $this->grabPositiveTweets($parsedTweets, $searchString);
    }

    /**
     * Turns array of $tweet search objects to an array of text
     * @param $tweets
     * @return array
     */
    private function parseSearchResults($tweets)
    {
        $textArray = [];

        $size = count($tweets);

        for ($i = 0; $i < $size; $i++) {
            array_push($textArray, $tweets[$i]->text);
        }

        return $textArray;
    }

    /**
     * Filters an array of texts by removing the search string and using
     * the sentiment analysis service
     * @param $username
     * @param $tweetArray
     * @return array
     */
    private function grabPositiveTweets($tweetArray, $username)
    {
        $sentimentService = new SentimentAnalysisService();

        $positiveTweets = [];
        foreach ($tweetArray as $tweet) {
            $tweet = urldecode($tweet);
            // replace username that was in search
            $pureText = str_replace('@' . $username, "", $tweet);
            if ($sentimentService->isPositiveText($pureText)) {
                array_push($positiveTweets, $tweet);
            }
        }

        return $positiveTweets;
    }
}
