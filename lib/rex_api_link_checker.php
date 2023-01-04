<?php

class rex_api_link_checker extends rex_api_function
{
    protected $published = true;

    public function execute()
    {
        if (!rex_backend_login::hasSession()) {
            exit;
        }
        if (rex_get('url', 'string')) {
            link_checker::indexUrl(rex_get('url', 'string'));
        } else {
            $next = link_checker::findNextCheckUrl();
            $next->checkUrl();
        }
        exit;
    }
}
