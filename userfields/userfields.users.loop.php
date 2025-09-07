<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.loop
 * [END_COT_EXT]
 */

/**
 * Userfields plugin for Cotonti 0.9.26
 * Filename: userfields.users.loop.php
 * @package userfields
 * @version 1.9.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 https://github.com/webitproff
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('userfields', 'plug');

global $t, $urr;

$fields = userfields_get_user_fields((int)$urr['user_id']);
$field_rows_html = '';
$individual_fields = [];

if (is_array($fields) && !empty($fields)) {
    $field_rows_html .= '<div class="userfields-list">';
    
    foreach ($fields as $field) {
        $title = htmlspecialchars($field['field_title']);
        $formatted_value = userfields_format_value($field['field_type'], $field['value']);
        
        if ($formatted_value !== '' && $formatted_value !== null && !empty($field['field_code'])) {
            $field_code = strtoupper($field['field_code']);
            
            $field_rows_html .= '
                <div class="row mb-1">
                    <div class="col-5 fw-bold">' . $title . '</div>
                    <div class="col-7">' . $formatted_value . '</div>
                </div>';

            $individual_fields[$field_code] = [
                'value' => $formatted_value,
                'title' => $title
            ];

            $t->assign([
                'USERFIELDS_FIELD_TITLE' => $title,
                'USERFIELDS_FIELD' => $formatted_value
            ]);
            $t->parse('MAIN.USERS_ROW.USERFIELDS');
        }
    }
    
    $field_rows_html .= '</div>';
}

foreach ($individual_fields as $field_code => $data) {
    $t->assign([
        "USERFIELDS_{$field_code}" => $data['value'],
        "USERFIELDS_{$field_code}_TITLE" => $data['title'],
    ]);
}

$all_field_types = userfields_get_field_types();
foreach ($all_field_types as $type) {
    $field_code = strtoupper($type['code']);
    if (!isset($individual_fields[$field_code])) {
        $t->assign([
            "USERFIELDS_{$field_code}" => '',
            "USERFIELDS_{$field_code}_TITLE" => '',
        ]);
    }
}

$t->assign(['USERS_ROW_FIELD_ROWS_HTML' => $field_rows_html]);



/* интеграция в users.tpl
<!-- IF {PHP|cot_plugin_active('userfields')} -->
<!-- BEGIN: USERFIELDS -->
<div class="userfield">
  <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
  <span class="userfield-value">{USERFIELDS_FIELD}</span>
</div>
<!-- END: USERFIELDS -->
<hr>
<!-- IF {USERFIELDS_CELL_NUMBER} --> 
<div class="userfield">
  <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
  <span class="userfield-value">
    <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
  </span>
</div>
<!-- ENDIF -->
<hr>
{USERS_ROW_FIELD_ROWS_HTML}
<!-- ENDIF -->
*/

?>