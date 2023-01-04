<?php
class link_checker extends \rex_yform_manager_dataset
{
    public function getLastSeenDate() :string
    {
        return $this->getValue('lastseendate');
    }
    public function getLastCheckedDate() :string
    {
        return $this->getValue('lastcheckeddate');
    }
    public function getFirstSeenDate() :string
    {
        return $this->getValue('firstseendate');
    }
    public function getUrl() :string
    {
        return $this->getValue('url');
    }

    public static function getByUrl($url)
    {
        return self::query()->where("url", $url)->findOne();
    }

    public static function findNextCheckUrl()
    {
        return self::query()->orderBy("lastcheckeddate", "ASC")->findOne();
    }

    public static function indexUrl($url)
    {
        try {
            $socket = rex_socket::factoryUrl($url);
            $response = $socket->doGet();
            
            $doc = new DOMDocument();
            @$doc->loadHTML($response->getBody());
            $xpath = new DOMXpath($doc);

            $nodes = $xpath->query('//a');

            $protocol = explode("/", $url)[0];
            $server = explode("/", $url)[2];

            foreach ($nodes as $node) {
                if ($node->getAttribute('href') == "") {
                    continue;
                }
                if (str_starts_with($node->getAttribute('href'), "tel:")) {
                    continue;
                }
                if (str_starts_with($node->getAttribute('href'), "mailto:")) {
                    continue;
                }
                if (str_starts_with($node->getAttribute('href'), "skype:")) {
                    continue;
                }
                if (str_starts_with($node->getAttribute('href'), "#")) {
                    continue;
                }
                if (str_starts_with($node->getAttribute('href'), "http")) {
                    $href = $node->getAttribute('href');
                } else {
                    $href = $protocol . "//" . $server . $node->getAttribute('href');
                }

                $link = self::getByUrl($href);

                if (!$link) {
                    $link = self::create();
                }
                $link->setValue('url', $href);
                $link->setValue('lastseendate', date('Y-m-d H:i:s'));
                $link->save();
            }
        } catch(rex_socket_exception $e) {
            return $e->getMessage();
        }
        return;
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
