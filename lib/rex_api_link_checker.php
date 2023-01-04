<?php

class rex_api_link_checker extends rex_api_function
{
    protected $published = true;

    public function execute()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        
        if (!rex_backend_login::hasSession()) {
            exit;
        }
        if (rex_get('url', 'string')) {
            $next = link_checker::getByUrl(rex_get('url', 'string'));
            if ($next) {
                $next->checkUrl();
            }
            exit;
        }
        if (rex_get('source', 'string')) {
            $next = link_checker_source::getByUrl(rex_get('url', 'string'));
            if ($next) {
                $next->indexUrl();
            }
            exit;
        }
        $next = link_checker_source::findNextCheckUrl();
        if ($next) {
            $next->indexUrl();
        }
    
        $next = link_checker::findNextCheckUrl();
        if ($next) {
            $next->checkUrl();
        }
        exit;
    }
}
