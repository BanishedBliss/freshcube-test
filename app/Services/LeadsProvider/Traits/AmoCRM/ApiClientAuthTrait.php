<?php

namespace App\Services\LeadsProvider\Traits\AmoCRM;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Client\LongLivedAccessToken;
use AmoCRM\Exceptions\InvalidArgumentException;

trait ApiClientAuthTrait
{
    protected function apiClientAuth(&$apiClient)
    {
        $authType = config('services.amocrm.auth_type');

        if ($authType == 'longterm')
        {
            $this->authLonglived($apiClient);
        }
        else if ($authType == 'refresh')
        {
            $this->authRefresh($apiClient);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function authLonglived(&$apiClient)
    {
        $apiClient = new AmoCRMApiClient();
        $longLivedAccessToken = new LongLivedAccessToken(
            config('services.amocrm.long_term_access_token')
        );
        $subdomain = config('services.amocrm.subdomain');
        $apiClient->setAccessToken($longLivedAccessToken)
            ->setAccountBaseDomain($subdomain . '.amocrm.ru');
    }

    protected function authRefresh(&$apiClient)
    {
        $apiClient = new AmoCRMApiClient(
            config('services.amocrm.client_id'),
            config('services.amocrm.client_secret'),
            config('services.amocrm.redirect_url')
        );
    }
}
