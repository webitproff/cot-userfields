<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.tags
 * Tags=users.details.tpl:{USERFIELDS_FIELDS}
 * [END_COT_EXT]
 */

/**
 * Userfields plugin for Cotonti 0.9.26
 * Filename: userfields.users.details.tags.php
 * @package userfields
 * @version 1.1.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('userfields', 'plug', 'functions');

$fields = userfields_get_user_fields($urr['user_id']);

$dl_html = '<dl class="row">';

foreach ($fields as $field) {
    $field_title = htmlspecialchars($field['field_title']);
    $formatted_value = userfields_format_value($field['field_type'], $field['value']);

    $dl_html .= '<dt class="col-sm-4">' . $field_title . '</dt>';
    $dl_html .= '<dd class="col-sm-8">' . $formatted_value . '</dd>';
}

$dl_html .= '</dl>';

$t->assign('USERFIELDS_FIELDS', $dl_html);
?>