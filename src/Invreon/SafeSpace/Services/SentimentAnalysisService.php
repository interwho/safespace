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
        $request = Request::get(BASE_HAVEN_URL . '&text=' . urlencode($text));

        try {
            $response = $request->send();
            if ($response->code == 200) {
                return $this->isPositiveResponse($response->body);
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    /**
     * @param $responseBody
     * @return boolean
     */
    private function isPositiveResponse($responseBody)
    {
        $positiveResults = $responseBody->positive;
        $negativeResults = $responseBody->negative;
        $score = $responseBody->aggregate->score;

        if (!empty($negativeResults)) {
            return false;
        }

        if (empty($positiveResults)) {
            return false;
        }

        if ($score >= 0) {
            return true;
        }

        return true;
    }
}
