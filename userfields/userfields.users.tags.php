<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.tags
 * [END_COT_EXT]
 */

/**
 * Userfields plugin for Cotonti 0.9.26
 * Filename: userfields.users.loop.php
 * @package userfields
 * @version 1.1.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

/* defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('userfields', 'plug', 'functions');

global $t, $urr;

$fields = userfields_get_user_fields((int)$urr['user_id']);

foreach ($fields as $field) {
    $field_code = strtoupper($field['field_code']);
    $formatted_value = userfields_format_value($field['field_type'], $field['value']);
    $field_title = htmlspecialchars($field['field_title']);

    // Отдельные теги
    $t->assign([
        "USERFIELDS_{$field_code}"       => $formatted_value,
        "USERFIELDS_{$field_code}_TITLE" => $field_title,
    ]);

    // Для цикла
    $t->assign([
        'USERFIELDS_FIELD'       => $formatted_value,
        'USERFIELDS_FIELD_TITLE' => $field_title,
    ]);
    $t->parse('MAIN.USERFIELDS');
}
 */