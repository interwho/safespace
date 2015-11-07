<?php
namespace Invreon\SafeSpace\Services;

use Httpful\Request;
use Symfony\Component\Config\Definition\Exception\Exception;

class SentimentAnalysisService
{
    /**
     * @param $text $string
     * @return boolean
     */
    public function isPositiveText($text)
    {
        $text = $this->makeTextUrlFriendly($text);
        $request = Request::get(BASE_HAVEN_URL . '&text=' . $text);

//        $request = new HttpRequest(BASE_HAVEN_URL, HttpRequest::METH_GET);
//        $request->addQueryData(array('text' => $text));

        try {
//            $request->send();
            $response = $request->send();
            if ($response->code == 200) {
                return $this->isPositiveResponse($response->body);
            } else {
                return false;
            }
//            if ($request->getResponseCode() == 200) {
//                return $this->isPositiveResponse($request->getResponseBody());
//            } else {
//                return false;
//            }
        } catch (Exception $ex) {
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
    private function isPositiveResponse($responseBody) {
        $negativeResults = $responseBody->negative;

        if (!empty($negativeResults)) {
            return false;
        }

        return true;
    }
}
