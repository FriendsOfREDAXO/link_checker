<?php
class link_checker_source extends \rex_yform_manager_dataset
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

    public function indexUrl()
    {
        $this->setValue('lastcheckeddate', date('Y-m-d H:i:s'));
        $this->save();
        try {
            $socket = rex_socket::factoryUrl($this->getUrl());
            $response = $socket->doGet();
            
            $doc = new DOMDocument();
            @$doc->loadHTML($response->getBody());
            $xpath = new DOMXpath($doc);

            $nodes = $xpath->query('//a');

            $protocol = explode("/", $this->getUrl())[0];
            $server = explode("/", $this->getUrl())[2];

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
                if (str_starts_with($node->getAttribute('href'), "file:")) {
                    continue;
                }
                if (str_starts_with($node->getAttribute('href'), "http")) {
                    $href = $node->getAttribute('href');
                } else {
                    $href = $protocol . "//" . $server . $node->getAttribute('href');
                }

                $link = link_checker::getByUrl($href);

                if (!$link) {
                    $link = link_checker::create();
                    $link->setValue('url', $href);
                }
                $link->setValue('lastseendate', date('Y-m-d H:i:s'));
                $link->save();
            }
        } catch(rex_socket_exception $e) {
            return $e->getMessage();
        }
        return;
    }


    public static function getSitemapAsJson($domain)
    {
        $sitemap = @simplexml_load_file($domain . "sitemap.xml");
        if ($sitemap) {
            return json_decode(json_encode($sitemap), true);
        }
    }

    public static function getSitemaps()
    {
        $domains = rex_yrewrite::getDomains();

        $sitemaps = [];
        foreach ($domains as $domain) {
            $sitemaps[$domain->getUrl()] = self::getSitemapAsJson($domain->getUrl());
        }

        return $sitemaps;
    }

    public static function populateBySitemap()
    {
        $sitemaps = self::getSitemaps();

        foreach ($sitemaps as $sitemap) {
            if ($sitemap && array_key_exists('url', $sitemap)) {
                foreach ($sitemap['url'] as $url) {
                    $source = self::getByUrl($url['loc']);

                    if (!$source) {
                        $source = self::create();
                        $source->setValue('firstseendate', date('Y-m-d H:i:s'));
                    }

                    $source->setValue('url', $url['loc']);
                    $source->setValue('lastseendate', date('Y-m-d H:i:s'));
                    $source->save();
                }
            }
        }
        
        return;
    }
}
