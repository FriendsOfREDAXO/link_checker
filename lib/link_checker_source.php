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
                $count = count($sitemap['url']);
                foreach ($sitemap['url'] as $url) {
                    $source = self::getByUrl($url['loc']);

                    if (!$source) {
                        $source = self::create();
                        $source->setValue('firstseendate', date('Y-m-d H:i:s'));
                    }

                    $source->setValue('url', $$url['loc']);
                    $source->setValue('lastseendate', date('Y-m-d H:i:s'));
                    $source->save();
                }
            }
        }
        
        return $urls;
    }
}
