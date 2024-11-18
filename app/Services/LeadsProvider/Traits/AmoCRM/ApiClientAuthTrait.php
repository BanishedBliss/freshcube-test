<?php

namespace App\Services\LeadsProvider\Traits\AmoCRM;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Client\LongLivedAccessToken;
use AmoCRM\Exceptions\InvalidArgumentException;

trait ApiClientAuthTrait
{
    /**
     * Настраивает параметры аутентификации для библиотеки
     * работы с API AmoCRM.
     * Использует долгосрочный или обновляемый ключ из
     * настроек конфигурации веб приложения.
     *
     * @param $apiClient
     * @return void
     */
    protected function apiClientAuth(&$apiClient): void
    {
        $authType = config('services.amocrm.auth_type');

        if ($authType == 'longterm')
        {
            $this->authLonglived($apiClient);
        }
        else if ($authType == 'refresh')
        {
            die('На данный момент приложение не поддерживает работу с обновляемым ключом!');
            //$this->authRefresh($apiClient);
        }
    }

    /**
     * Настраивает аутентификацию с помощью долгосрочного ключа.
     * Документация: https://github.com/amocrm/amocrm-api-php?tab=readme-ov-file#авторизация-с-долгоживущим-токеном
     */
    protected function authLonglived(&$apiClient)
    {
        $apiClient = new AmoCRMApiClient();
        try {
            $longLivedAccessToken = new LongLivedAccessToken(
                config('services.amocrm.long_term_access_token')
            );
        } catch (InvalidArgumentException $e) {
            die($e->getMessage());
        }
        $subdomain = config('services.amocrm.subdomain');
        $apiClient->setAccessToken($longLivedAccessToken)
            ->setAccountBaseDomain($subdomain . '.amocrm.ru');
    }

    /**
     * Настраивает аутентификацию с помощью обновляемого ключа.
     */
    /*protected function authRefresh(&$apiClient)
    {
        $apiClient = new AmoCRMApiClient(
            config('services.amocrm.client_id'),
            config('services.amocrm.client_secret'),
            config('services.amocrm.redirect_url')
        );
    }*/
}
