<?php

if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
    rex_yform_manager_dataset::setModelClass(
        'rex_link_checker',
        link_checker::class
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_link_checker_source',
        link_checker_source::class
    );
}


if (rex::isBackend()) {
    rex_view::addJsFile($this->getAssetsUrl('link_checker_background.js'));
}
