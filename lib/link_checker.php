<?php
class link_checker extends \rex_yform_manager_dataset
{
    public function getName() :string
    {
        return $this->getValue('name');
    }
    public function getLastSeenDate() :string
    {
        return $this->getValue('lastseendate');
    }
    public function getUpdateDate() :string
    {
        return $this->getValue('updatedate');
    }
    public function getUrl() :string
    {
        return $this->getValue('url');
    }
    public function getStatusCode() :string
    {
        return $this->getValue('status_code');
    }
    public function getRedirectUrl() :string
    {
        return $this->getValue('finalurl');
    }

    public static function getByUrl($url)
    {
        return self::query()->where("url", $url)->findOne();
    }

    public static function findNextCheckUrl()
    {
        return self::query()->orderBy("updatedate", "ASC")->findOne();
    }

    public function checkUrl()
    {
        $this->setValue('updatedate', date('Y-m-d H:i:s'));
        $this->save();
        try {
            $socket = rex_socket::factoryUrl($this->getUrl());
            $response = $socket->doGet();

            $this->setValue('status_code', $response->getStatusCode());
            $this->save();
        } catch(rex_socket_exception $e) {
            return $e->getMessage();
        }
        
        return "success";
    }
}
