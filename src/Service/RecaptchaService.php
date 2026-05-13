<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RecaptchaService
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $recaptchaSecret
    ) {
    }

    public function verify( string $token ): bool 
    { 

        if (!$token) {
            return false;
        }

        $response =
            $this->httpClient->request(
                'POST',
                'https://www.google.com/recaptcha/api/siteverify',
                [
                    'body' => [
                        'secret' => $this->recaptchaSecret,
                        'response' => $token,
                    ],
                ]
            );

        $data = $response->toArray();

        return $data['success'] ?? false;
    }
}