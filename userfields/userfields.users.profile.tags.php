<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.profile.tags
 * [END_COT_EXT]
 */

/**
 * Userfields plugin for Cotonti 0.9.26, PHP 8.4+ 
 * Filename: userfields.users.profile.tags.php
 *
 * Date: Jan 14Th, 2026
 *
 * @package userfields
 * @version 2.0.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff
 * @license BSD
 */





defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('userfields', 'plug');

global $db, $db_x, $db_userfield_types, $db_userfield_values, $usr, $t;

$db_userfield_types  = $db_x . 'userfield_types';
$db_userfield_values = $db_x . 'userfield_values';

$field_types  = userfields_get_field_types();            // Типы полей
$user_fields  = userfields_get_user_fields($usr['id']);  // Значения юзера

$fields_by_type = [];
foreach ($user_fields as $field) {
    $fields_by_type[$field['field_id']] = $field;
}

// Перебираем все типы полей
foreach ($field_types as $type) {
    $type_id    = $type['id'];
    $field_code = strtoupper($type['code']); // TELEGRAM, CELL_NUMBER и т.д.
    $existing   = isset($fields_by_type[$type_id]) ? $fields_by_type[$type_id]['value'] : null;

    $field_input = userfields_build_input("userfields_values[{$type_id}][value]", $type, $existing);
    $field_title = htmlspecialchars($type['title']);

    // Отдельные теги
    $t->assign([
        "USERFIELDS_{$field_code}"       => $field_input,
        "USERFIELDS_{$field_code}_TITLE" => $field_title,
    ]);

    // Для цикла
    $t->assign([
        'USERFIELDS_FIELD'       => $field_input,
        'USERFIELDS_FIELD_TITLE' => $field_title,
    ]);
    $t->parse('MAIN.USERFIELDS');
}



/* 
	интеграция в users.profile.tpl

<!-- IF {PHP|cot_plugin_active('userfields')} -->
<div class="row mb-3">
    <!-- IF {USERFIELDS_CELL_NUMBER} -->
    <div class="userfield">
        <label class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</label>
        <div class="userfield-value">{USERFIELDS_CELL_NUMBER}</div>
    </div>
    <!-- ENDIF -->
    <!-- IF {USERFIELDS_TELEGRAM} -->
    <div class="userfield">
        <label class="userfield-title">{USERFIELDS_TELEGRAM_TITLE}:</label>
        <div class="userfield-value">{USERFIELDS_TELEGRAM}</div>
    </div>
    <!-- ENDIF -->
<!-- BEGIN: USERFIELDS -->
<div>
  <label>{USERFIELDS_FIELD_TITLE}</label>
  {USERFIELDS_FIELD}
</div>
<!-- END: USERFIELDS -->
</div>
<!-- ENDIF -->
*/