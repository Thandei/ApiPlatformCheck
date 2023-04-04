<?php namespace App\Service;

use App\Services\PrimitiveBrowserService;
use Exception;
class NetgsmService
{

    const credentialsCheckEndpoint = 'https://api.netgsm.com.tr/sms/header';
    const sendSMSEndpoint = 'https://api.netgsm.com.tr/sms/send/get';
    const getSMSEndpoint = 'https://api.netgsm.com.tr/sms/report';
    const getCreditsEndpoint = 'https://api.netgsm.com.tr/balance/list/xml';
    public function __construct(private PrimitiveBrowserService $primitiveBrowserService, private $netgsmUsername, private $netgsmPassword, private $netgsmHeader)
    {
    }

    public function checkCredentials($returnHeaders = FALSE): bool|array
    {

        try {
            $postCreds = ["usercode" => $this->netgsmUsername, "password" => $this->netgsmPassword];
            $checkURL = $this->primitiveBrowserService->setMethod("POST")->addJsonBody($postCreds)->navigate(self::credentialsCheckEndpoint);
            if (count($this->primitiveBrowserService->getErrors()) === 0) {
                $responseReturns = $checkURL->response('array');
                if (isset($responseReturns["msgheader"])) {
                    if ($returnHeaders === TRUE) {
                        return $responseReturns;
                    }
                    return TRUE;
                }
            }
        } catch (Exception $exception) {
            return FALSE;
        }

        return FALSE;
    }

    public function sendSMS(string $gsmNo, string $message): false|int
    {
        return $this->requestSMS($gsmNo, $message);
    }

    private function requestSMS(string $gsmNo, string $message): false|int
    {
        $formData = [
            "usercode" => $this->netgsmUsername,
            "password" => $this->netgsmPassword,
            "gsmno" => $gsmNo,
            "message" => $message,
            "msgheader" => $this->getHeader(),
        ];


        $sendResult = $this->primitiveBrowserService->setMethod("POST")->addBody($formData)->navigate(self::sendSMSEndpoint);
        $sendErrors = $this->primitiveBrowserService->getErrors();

        if (count($sendErrors) === 0) {
            $sendResponse = $sendResult->response();
            if (intval(substr($sendResponse, 0, 2)) === 0) {
                if (strlen($sendResponse) > 3) {
                    return intval(str_replace("00 ", "", $sendResponse));
                }

            }

        }


        return FALSE;
    }

    public function getSMS(int $smsCheckCode): bool
    {
        $getURL = self::getSMSEndpoint . '/?usercode=' . $this->netgsmUsername . '&password=' . $this->netgsmPassword . '&bulkid=' . $smsCheckCode . '&type=0&status=100&version=2';
        $checkResult = $this->primitiveBrowserService->setMethod('GET')->clearReqBody()->navigate($getURL);


        $checkResponse = $checkResult->response();
        $checkErrors = $checkResult->getErrors();

        if (count($checkErrors) === 0) {

            if (strlen($checkResponse) < 10) {
                return FALSE;
            }

            if (count(explode(" ", $checkResponse)) < 3) {
                return FALSE;
            }

            return TRUE;

        } else {
            return FALSE;
        }

    }

    public function getAvailableHeaders(): array
    {
        $myHeaders = $this->checkCredentials(TRUE);

        if (is_array($myHeaders)) {
            return $myHeaders;
        }

        return [];
    }

    public function getAvailableCredits(): null|string
    {

        $xmlForm = '<?xml version="1.0"?>
                    <mainbody>
                        <header>		
                            <usercode>' . $this->netgsmUsername . '</usercode>
                            <password>' . $this->netgsmPassword . '</password>
                            <stip>2</stip>      
                        </header>		
                    </mainbody>';
        $this->primitiveBrowserService->setMethod("POST")->addBody($xmlForm)->navigate(self::getCreditsEndpoint);
        $creditsResponse = $this->primitiveBrowserService->response();

        if ($creditsResponse !== NULL) {
            $resultCode = intval(mb_substr($creditsResponse, 0, 2));
            if ($resultCode === 0) {
                return str_replace("00 ", "", $creditsResponse);;
            }

        }

        return NULL;
    }

    private function getHeader(): string
    {
        return urldecode($this->netgsmHeader);
    }

    public static function checkPhoneValidity($phoneStr): bool
    {
        $clearPhone = NetgsmService::clearPhoneNumberSpaces($phoneStr);
        $clearCountryCode = '+90';
        $phoneWithoutCountryCode = str_replace($clearCountryCode, '', $clearPhone);
        if (is_numeric($phoneWithoutCountryCode)) {
            if (strlen($phoneWithoutCountryCode) === 10) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public static function clearPhoneNumberSpaces(string $phoneNumber): string
    {
        return str_replace(' ', '', $phoneNumber);
    }
}