<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.tags
 * [END_COT_EXT]
 */

/**
 * Userfields plugin for Cotonti 0.9.26, PHP 8.4+ вывод дополнительных полей пользователя на странице публичного профиля пользователя 
 * Filename: userfields.users.details.tags.php
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

require_once cot_incfile('userfields', 'plug', 'functions');

global $t, $urr;

$fields = userfields_get_user_fields($urr['user_id']);

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
    $t->parse('MAIN.USERFIELDS_DETAILS');
}

/* 
интеграция в users.details.tpl
	<!-- IF {PHP|cot_plugin_active('userfields')} -->
	<hr>
	<div class="row mb-3">
	индивидуальное поле
		<!-- IF {USERFIELDS_CELL_NUMBER} -->
		<div class="userfield">
			<span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
			<span class="userfield-value">
				<a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">
					{USERFIELDS_CELL_NUMBER}
				</a>
			</span>
		</div>
		<!-- ENDIF -->
		<hr> либло циклом
		<!-- BEGIN: USERFIELDS_DETAILS -->
		<div class="userfield">
		  <label class="userfield-title text-success">{USERFIELDS_FIELD_TITLE}:</label>
		  <div class="userfield-value">{USERFIELDS_FIELD}</div>
		</div>
		<!-- END: USERFIELDS_DETAILS -->
	<hr>
	<!-- ENDIF -->	
 */
