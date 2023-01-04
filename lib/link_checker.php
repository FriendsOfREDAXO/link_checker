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
        rex_yform_manager_dataset::query()->where("url", $url)->findOne();
    }

    public static function findLinks($url)
    {
        try {
            $socket = rex_socket::factoryUrl($url);
            $response = $socket->doGet();

            $doc = new DOMDocument();
            $doc->loadHTML($response->getBody()); //helps if html is well formed and has proper use of html entities!

            $xpath = new DOMXpath($doc);

            $nodes = $xpath->query('//a');

            dump($nodes);
            exit;
            foreach ($nodes as $node) {
                $href = $node->getAttribute('href');
                $link = self::getByUrl($href);
                            
                if (!$link) {
                    $link = self::create();
                }
                $link->setValue('url', $href);
                $link->setValue('lastseen', "NOW()");
                $link->save();
                            
                return;
            }
        } catch(rex_socket_exception $e) {
            return $e->getMessage();
        }
    }
    

    public static function check($url)
    {
        try {
            $socket = rex_socket::factoryUrl($url);
            $response = $socket->doGet();

            $link = self::getByUrl($url);
            if (!$link) {
                $link = self::create();
            }

            $link->setValue('url', $url);
            $link->setValue('status', $response->getStatusCode());
            $link->save();
            
            return;
        } catch(rex_socket_exception $e) {
            return $e->getMessage();
        }
    }
}
