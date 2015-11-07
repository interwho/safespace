<?php
namespace Invreon\SafeSpace\Services;

use HttpException;
use HttpRequest;

class SentimentAnalysisService
{
    /**
     * @param $text $string
     * @return boolean
     */
    public function isPositiveText($text)
    {
        $text = $this->makeTextUrlFriendly($text);

        $request = new HttpRequest(BASE_HAVEN_URL, HttpRequest::METH_GET);
        $request->addQueryData(array('text' => $text));

        try {
            $request->send();
            if ($request->getResponseCode() == 200) {
                return $this->analyzeSentimentResponse($request->getResponseBody());
            } else {
                return false;
            }
        } catch (HttpException $ex) {
            echo $ex;
        }
    }

    /**
     * @param $text
     * @return string
     */
    private function makeTextUrlFriendly($text)
    {
        return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $text), '-'));
    }

    /**
     * @param $responseBody
     * @return boolean
     */
    private function analyzeSentimentResponse($responseBody) {
        $negativeResults = $responseBody['negative'];

        if (!empty($negativeResults)) {
            return false;
        }

        return true;
    }
}
