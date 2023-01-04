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
}
