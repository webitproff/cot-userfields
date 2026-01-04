<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=usertags.main
 * [END_COT_EXT]
 */

/**
 * Userfields plugin for Cotonti 0.9.26
 * Filename: userfields.usertags.php
 * @package userfields
 * @version 1.5.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('userfields', 'plug');

global $t;

if (!isset($t) || !$t instanceof XTemplate) {
    // Если $t не определён или не является объектом шаблона, просто выходим
    return;
}

if (is_array($user_data) && !empty($user_data)) {
    // Check possible keys for user_id
    $user_id = isset($user_data['user_id']) ? (int)$user_data['user_id'] : 
               (isset($user_data['msitem_ownerid']) ? (int)$user_data['msitem_ownerid'] : 0);
    
    if ($user_id > 0) {
        $user_fields = userfields_get_user_fields($user_id);
        $userfields_loop_data = [];
        $individual_fields = [];
        $field_rows_html = '';

        if (is_array($user_fields) && !empty($user_fields)) {
            $field_rows_html .= '<div class="userfields-list">';
            
            foreach ($user_fields as $field) {
                $title = htmlspecialchars($field['field_title']);
                $formatted_value = userfields_format_value($field['field_type'], $field['value']);

                if ($formatted_value !== '' && $formatted_value !== null && !empty($field['field_code'])) {
                    $field_code = strtoupper($field['field_code']);

                    // Сохраняем для индивидуальных тегов
                    $individual_fields[$field_code] = [
                        'value' => $formatted_value,
                        'title' => $title
                    ];

                    // Сохраняем для цикла USERFIELDS
                    $userfields_loop_data[] = [
                        'USERFIELDS_FIELD_TITLE' => $title,
                        'USERFIELDS_FIELD' => $formatted_value
                    ];

                    // Добавляем данные в HTML-строку для USERFIELDS_ROWS_HTML
                    $field_rows_html .= '
                        <div class="row mb-1">
                            <div class="col-5 fw-bold">' . $title . '</div>
                            <div class="col-7">' . $formatted_value . '</div>
                        </div>';
                }
            }
            
            $field_rows_html .= '</div>';
        }

        // Назначаем индивидуальные теги через t->assign
        foreach ($individual_fields as $field_code => $data) {
            $t->assign([
                "USERFIELDS_{$field_code}" => $data['value'],
                "USERFIELDS_{$field_code}_TITLE" => $data['title'],
            ]);
        }

        // Очищаем неиспользуемые индивидуальные теги
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

        // Назначаем данные для цикла USERFIELDS
        if (!empty($userfields_loop_data)) {
            foreach ($userfields_loop_data as $loop_item) {
                $t->assign($loop_item);
                $t->parse('MAIN.USERFIELDS');
            }
        }

        // Присваиваем HTML-строку для USERFIELDS_ROWS_HTML
        $t->assign(['USERFIELDS_ROWS_HTML' => $field_rows_html]);
    }
}


/* интеграция в mstore.list.tpl, mstore.tpl, page.news.tpl и так далее
<!-- IF {PHP|cot_plugin_active('userfields')} -->
<div class="row mb-3">
    <!-- BEGIN: USERFIELDS -->
    <div class="userfield">
        <span class="userfield-title text-primary">{USERFIELDS_FIELD_TITLE}:</span>
        <span class="userfield-value">{USERFIELDS_FIELD}</span>
    </div>
    <!-- END: USERFIELDS -->

    <!-- IF {USERFIELDS_CELL_NUMBER} -->
    <div class="userfield">
        <span class="userfield-title text-danger">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
        <span class="userfield-value">
            <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
        </span>
    </div>
    <!-- ENDIF -->
    <hr>
    {USERFIELDS_ROWS_HTML}
</div>
<hr>
<!-- ENDIF -->	 */
?>
