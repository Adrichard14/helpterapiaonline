<?php

class PagSeguroWebhookHandler
{
    private $accountEmail;
    private $accountToken;

    private $supportEmail;

    private $code;
    private $type;
    private $xml = [];

    /**
     * PagseguroWebhookHandler constructor.
     * @param string $accountEmail
     * @param string $accountToken
     */
    public function __construct($accountEmail, $accountToken)
    {
        $this->accountEmail = $accountEmail;
        $this->accountToken = $accountToken;
    }

    /**
     * @throws UnacceptableNotificationTypeException
     * @throws UnauthorizedWebhookException
     * @throws UnexpectedResultException
     */
    public function load()
    {
        $this->code = POST::notificationCode();
        $this->type = POST::notificationType();
        if (!$this->isAcceptable()) {
            throw new UnacceptableNotificationTypeException("Tipo de notificação ignorada: {$this->type}");
        }
        $this->extractXml();
        $this->enableCORS();
    }

    protected function enableCORS()
    {
        if (PagSeguroConfigWrapper::PAGSEGURO_ENV == "production") {
            header("access-control-allow-origin: https://pagseguro.uol.com.br");
        } else {
            header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
        }
    }

    protected function isAcceptable()
    {
        return $this->code && $this->type && $this->type === "transaction";
    }

    public function isPaymentPending()
    {
        return intval($this->xml["status"]) === 1;
    }

    public function isPaymentUnderAnalysis()
    {
        return intval($this->xml["status"]) === 2;
    }

    public function isPaymentDone()
    {
        return intval($this->xml["status"]) === 3;
    }

    public function isPaymentAvailable()
    {
        return intval($this->xml["status"]) === 4;
    }

    public function isPaymentInDispute()
    {
        return intval($this->xml["status"]) === 5;
    }

    public function isPaymentRefunded()
    {
        return intval($this->xml["status"]) === 6;
    }

    public function isPaymentCancelled()
    {
        return intval($this->xml["status"]) === 7;
    }

    public function hasStatus()
    {
        return isset($this->xml["status"]);
    }

    public function hasError()
    {
        return isset($this->xml["error"]["code"]);
    }

    public function getNotificationCode()
    {
        return $this->code;
    }

    public function getNotificationType()
    {
        return $this->type;
    }

    public function getReference()
    {
        return isset($this->xml["reference"]) ? $this->xml["reference"] : null;
    }

    /**
     * @return DateTime|null
     * @throws Exception
     */
    public function getEventDate()
    {
        return isset($this->xml["date"])
            ? new DateTime($this->xml["date"])
            : null;
    }

    /**
     * @return DateTime|null
     * @throws Exception
     */
    public function getLastEventDate()
    {
        return isset($this->xml["lastEventDate"])
            ? new DateTime($this->xml["lastEventDate"])
            : null;
    }

    public function getErrorCode()
    {
        return $this->hasError() ? $this->xml["error"]["code"] : null;
    }

    public function getErrorMessage()
    {
        return $this->hasError() ? $this->xml["error"]["message"] : null;
    }

    public function getXml()
    {
        return $this->xml;
    }
    protected function getEndpoint()
    {
        $preUrl = PagSeguroConfigWrapper::PAGSEGURO_ENV == "production"
            ? "https://ws.pagseguro.uol.com.br"
            : "https://ws.sandbox.pagseguro.uol.com.br";
        return "$preUrl/v2/transactions/notifications/{$this->code}?email={$this->accountEmail}&token={$this->accountToken}";
    }

    /**
     * @throws UnauthorizedWebhookException
     * @throws UnexpectedResultException
     */
    protected function extractXml()
    {
        $curl = curl_init($this->getEndpoint());
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        if ($result == 'Unauthorized') {
            throw new UnauthorizedWebhookException("CURL: Unauthorized");
        }
        $this->xml = xml2array(simplexml_load_string($result));
        if (!is_array($this->xml)) {
            throw new UnexpectedResultException("O XML retornado da PagSeguro não pôde ser convertido em array. Veja a seguir o que foi recuperado via CURL: <quote>$result</quote>");
        }
    }

    public function setSupportEmail($email)
    {
        $this->supportEmail = $email;
    }

    public function sendSupportEmail($subject, $content)
    {
        Newsletter::send($subject, $content, $this->supportEmail);
    }
}
