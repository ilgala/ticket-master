<?php

namespace App\Exceptions\Concerns;

use App\Jobs\SendMailException;

trait WithEmail
{
    public function report(): void
    {
        dispatch(new SendMailException);
    }
}
