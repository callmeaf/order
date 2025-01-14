<?php

namespace Callmeaf\Order\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class UserHasNotDefaultAddressException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: __('callmeaf-order::v1.errors.user_has_not_default_address'), $code ?: Response::HTTP_FORBIDDEN, $previous);
    }
}

