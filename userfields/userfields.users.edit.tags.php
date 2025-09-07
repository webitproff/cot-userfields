<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.edit.tags
[END_COT_EXT]
==================== */

/**
 * Userfields plugin for Cotonti 0.9.26
 * Filename: userfields.users.edit.tags.php
 * @package userfields
 * @version 1.1.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('userfields', 'plug');

global $db, $db_x, $db_userfield_types, $db_userfield_values, $id, $t;

$db_userfield_types  = $db_x . 'userfield_types';
$db_userfield_values = $db_x . 'userfield_values';

// Все типы полей
$field_types = userfields_get_field_types();
// Значения конкретного пользователя (админ его редактирует)
$user_fields = $id ? userfields_get_user_fields($id) : [];

$fields_by_type = [];
foreach ($user_fields as $field) {
    $fields_by_type[$field['field_id']] = $field;
}

// Перебираем поля
foreach ($field_types as $type) {
    $type_id    = $type['id'];
    $field_code = strtoupper($type['code']);
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


/* интеграция в users.edit.tpl 

<!-- IF {PHP|cot_plugin_active('userfields')} -->

вот так циклом - то есть все сразу
<!-- BEGIN: USERFIELDS -->
<div>
  <label>{USERFIELDS_FIELD_TITLE}</label>
  {USERFIELDS_FIELD}
</div>
<!-- END: USERFIELDS -->

или вот так - выводим поля каждое индивидуально

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
</div>
<!-- ENDIF --> 
*/