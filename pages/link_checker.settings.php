<?php
#
$addon = rex_addon::get('link_checker');

$form = rex_config_form::factory($addon->name);

$field = $form->addInputField('text', 'mytextfield', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('link_checker_config_mytextfield_label'));
$field->setNotice(rex_i18n::msg('link_checker_config_mytextfield_notice'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('link_checker_config'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
