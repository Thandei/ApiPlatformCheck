<?php namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PrimitiveBrowserService
{

    // Default Constraints
    const defaultUserAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36';
    const defaultRequestMethod = 'GET';

    private string $reqUserAgent = '';
    private string $reqMethod = '';
    private array $reqHeaders = [];
    private array $reqErrors = [];
    private $reqResponse = NULL;
    private $jsonBody = NULL;
    private $requestBody = NULL;
    private $authBasic = NULL;

    // Request Variables
    public function __construct(private HttpClientInterface $httpClient)
    {
        $this->reqUserAgent = self::defaultUserAgent;
        $this->reqMethod = self::defaultRequestMethod;

        // Prepare to navigation
        $this->reqHeaders['User-Agent'] = self::defaultUserAgent;
    }

    public function navigate(string $url): static
    {

        $this->reqErrors = [];
        $this->reqResponse = NULL;

        try {

            $requestOptions = [
                'headers' => $this->reqHeaders,
            ];


            if ($this->jsonBody !== NULL) {
                $requestOptions["json"] = $this->jsonBody;
            }

            if ($this->requestBody !== NULL) {
                $requestOptions["body"] = $this->requestBody;
            }

            if ($this->authBasic !== NULL) {
                $requestOptions["auth_basic"] = $this->authBasic;
            }

            $this->reqResponse = $this->httpClient->request(
                $this->reqMethod,
                $url,
                $requestOptions,
            );


        } catch (TransportExceptionInterface $e) {
            $this->addError("Web browser returned an transport exception. " . $e->getMessage());
        } catch (ClientExceptionInterface $e) {
            $this->addError("Web browser returned an client exception. " . $e->getMessage());
        } catch (RedirectionExceptionInterface $e) {
            $this->addError("Web browser returned an redirection exception. " . $e->getMessage());
        } catch (ServerExceptionInterface $e) {
            $this->addError("Web browser returned an server exception. " . $e->getMessage());
        } catch (DecodingExceptionInterface $e) {
            $this->addError("Web browser returned an decoding exception. " . $e->getMessage());
        }
        return $this;
    }

    public function withAuthBasic(string $username, string $password): static
    {
        $this->authBasic = [$username, $password];
        return $this;
    }

    public function response($returnMethod = 'raw')
    {

        if ($this->reqResponse !== NULL) {
            return match ($returnMethod) {
                'array' => $this->reqResponse->toArray(),
                default => $this->reqResponse->getContent(),
            };
        }
        return NULL;
    }

    public function clearReqBody(): static
    {
        $this->requestBody = NULL;
        $this->jsonBody = NULL;
        return $this;
    }

    private function addError(string $errorString): void
    {
        $this->reqErrors[] = $errorString;
    }

    public function getErrors(): array
    {
        return $this->reqErrors;
    }

    public function getUserAgent(): string
    {
        return $this->reqUserAgent;
    }

    public function setUserAgent(string $userAgent): static
    {
        $this->reqUserAgent = $userAgent;
        $this->reqHeaders["User-Agent"] = $userAgent;
        return $this;
    }

    public function setMethod(string $requestMethod): static
    {
        $this->reqMethod = $requestMethod;
        return $this;
    }

    public function getMethod(): string
    {
        return $this->reqMethod;
    }

    public function addJsonBody(array $jsonData): static
    {
        $this->requestBody = NULL;
        $this->jsonBody = $jsonData;
        return $this;
    }

    public function addBody($formData): static
    {
        $this->jsonBody = NULL;
        $this->requestBody = $formData;
        return $this;
    }

    public function addRequestHeader(string $headerName, string $headerValue): static
    {
        $this->reqHeaders[] = [$headerName => $headerValue];
        return $this;
    }

    public function getRequestHeaders(): array
    {
        return $this->reqHeaders;
    }

}