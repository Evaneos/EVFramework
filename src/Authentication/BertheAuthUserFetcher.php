<?php

namespace EVFramework\Authentication;

use Berthe\Fetcher;

class BertheAuthUserFetcher extends Fetcher
{
    public function filterByEmail($email)
    {
        $this->addFilter('email', Fetcher::TYPE_LOWERED_EQ, $email);

        return $this;
    }
}
