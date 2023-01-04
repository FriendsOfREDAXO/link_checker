<?php

class rex_api_link_checker extends rex_api_function
{
    protected $published = true;

    public function execute()
    {
        if (rex_get('url', 'string')) {
            link_checker::findLinks(rex_get('url', 'string'));
        }
        exit;
    }
}
