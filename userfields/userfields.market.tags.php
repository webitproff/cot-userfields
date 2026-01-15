<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=market.tags,markettags.main
 * [END_COT_EXT]
 */

/**
 * Userfields plugin for Cotonti 0.9.26, PHP 8.4+
 * Filename: userfields.market.tags.php
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

// Глобальные переменные, доступные в market.tags
global $t, $item,$item_data;

if (!isset($t) || !$t instanceof XTemplate) {
    return;
}

// В модуле market автор страницы нам нужен

$user_id = isset($item['fieldmrkt_ownerid']) ? (int)$item['fieldmrkt_ownerid'] : 
           (isset($item_data['fieldmrkt_ownerid']) ? (int)$item_data['fieldmrkt_ownerid'] : 0);

if ($user_id <= 0) {
    return;
}

// Загружаем пользовательские поля
$user_fields = userfields_get_user_fields($user_id);

if (empty($user_fields) || !is_array($user_fields)) {
    return;
}

// Подготовка данных для тегов
$userfields_loop_data = [];
$individual_fields = [];
$field_rows_html = '<div class="userfields-list">';

foreach ($user_fields as $field) {
    if (empty($field['field_code'])) {
        continue;
    }

    $title = htmlspecialchars($field['field_title']);
    $value = userfields_format_value($field['field_type'], $field['value']);

    if ($value === '' || $value === null) {
        continue;
    }

    $code = strtoupper($field['field_code']);

    // Сохраняем для индивидуальных тегов USERFIELDS_КОД и USERFIELDS_КОД_TITLE
    $individual_fields[$code] = [
        'value' => $value,
        'title' => $title
    ];

    // Для цикла <!-- BEGIN: USERFIELDS -->
    $userfields_loop_data[] = [
        'USERFIELDS_FIELD_TITLE' => $title,
        'USERFIELDS_FIELD'      => $value
    ];

    // Готовый HTML для вставки целиком через {USERFIELDS_ROWS_HTML}
    $field_rows_html .= '
        <div class="row mb-1">
            <div class="col-5 fw-bold">' . $title . '</div>
            <div class="col-7">' . $value . '</div>
        </div>';
}

$field_rows_html .= '</div>';

// Назначаем индивидуальные теги
foreach ($individual_fields as $code => $data) {
    $t->assign([
        "USERFIELDS_{$code}"        => $data['value'],
        "USERFIELDS_{$code}_TITLE"  => $data['title'],
    ]);
}

// Очищаем теги тех полей, которых у пользователя нет (чтобы не висели старые значения)
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

// Парсим цикл USERFIELDS
foreach ($userfields_loop_data as $loop) {
    $t->assign($loop);
    $t->parse('MAIN.USERFIELDS');
}

// Готовый HTML-блок
$t->assign('USERFIELDS_ROWS_HTML', $field_rows_html);