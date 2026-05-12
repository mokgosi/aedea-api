<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

use App\Entity\Contact;
use App\Service\RecaptchaService;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ContactProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(
            service: 'api_platform.doctrine.orm.state.persist_processor'
        )]
        private readonly ProcessorInterface $persistProcessor,
        private readonly RequestStack $requestStack,
        private readonly RecaptchaService $recaptchaService,
    ) {
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): mixed {

        /*
         |--------------------------------------------------------------------------
         | Ensure Contact Entity
         |--------------------------------------------------------------------------
         */

        if (!$data instanceof Contact) {
            return $data;
        }

        /*
         |--------------------------------------------------------------------------
         | Get Request Data
         |--------------------------------------------------------------------------
         */

        $request = $this->requestStack
            ->getCurrentRequest();

        $payload = json_decode(
            $request->getContent(),
            true
        );

        $recaptchaToken =
            $payload['recaptchaToken']
            ?? null;

        /*
         |--------------------------------------------------------------------------
         | Verify reCAPTCHA
         |--------------------------------------------------------------------------
         */

        if (
            !$recaptchaToken ||
            !$this->recaptchaService
                ->verify($recaptchaToken)
        ) {

            throw new BadRequestHttpException(
                'Invalid captcha.'
            );
        }

        /*
         |--------------------------------------------------------------------------
         | Continue Persisting Contact
         |--------------------------------------------------------------------------
         */

        return $this->persistProcessor
            ->process(
                $data,
                $operation,
                $uriVariables,
                $context
            );
    }
}