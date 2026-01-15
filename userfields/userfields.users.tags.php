<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.tags,usertags.main
 * [END_COT_EXT]
 */

/**
 * Userfields plugin for Cotonti 0.9.26, PHP 8.4+ вывод дополнительных полей пользователя на страницах (page) 
 * Filename: userfields.users.tags.php
 *
 * Date: Jan 14Th, 2026
 *
 * @package userfields
 * @version 2.0.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('userfields', 'plug');
/* 
// В профиле почти всегда используется $urr
global $t, $urr;

if (!isset($t) || !$t instanceof XTemplate) {
    return;
}

// В users.tags текущий пользователь всегда в $urr['user_id']
$user_id = isset($urr['user_id']) ? (int)$urr['user_id'] : 0;

if ($user_id <= 0) {
    return;
}

$user_fields = userfields_get_user_fields($user_id);

if (empty($user_fields) || !is_array($user_fields)) {
    return;
}

$userfields_loop_data = [];
$individual_fields = [];
$field_rows_html = '<div class="userfields-list">';

foreach ($user_fields as $field) {
    if (empty($field['field_code'])) continue;

    $title = htmlspecialchars($field['field_title']);
    $value = userfields_format_value($field['field_type'], $field['value']);

    if ($value === '' || $value === null) continue;

    $code = strtoupper($field['field_code']);

    $individual_fields[$code] = ['value' => $value, 'title' => $title];

    $userfields_loop_data[] = [
        'USERFIELDS_FIELD_TITLE' => $title,
        'USERFIELDS_FIELD'      => $value
    ];

    $field_rows_html .= '
        <div class="row mb-1">
            <div class="col-5 fw-bold">' . $title . '</div>
            <div class="col-7">' . $value . '</div>
        </div>';
}

$field_rows_html .= '</div>';

foreach ($individual_fields as $code => $data) {
    $t->assign([
        "USERFIELDS_{$code}"        => $data['value'],
        "USERFIELDS_{$code}_TITLE"  => $data['title'],
    ]);
}

$all_field_types = userfields_get_field_types();
foreach ($all_field_types as $type) {
    $code = strtoupper($type['code']);
    if (!isset($individual_fields[$code])) {
        $t->assign([
            "USERFIELDS_{$code}"        => '',
            "USERFIELDS_{$code}_TITLE"  => '',
        ]);
    }
}

foreach ($userfields_loop_data as $loop) {
    $t->assign($loop);
    $t->parse('MAIN.USERFIELDS');
}

$t->assign('USERFIELDS_ROWS_HTML', $field_rows_html);
 */