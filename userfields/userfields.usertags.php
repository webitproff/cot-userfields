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
 * @version 1.0.3
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('userfields', 'plug', 'functions');

if (is_array($user_data) && !empty($user_data)) {
    // Проверяем возможные ключи для user_id
    $user_id = isset($user_data['user_id']) ? (int)$user_data['user_id'] : 
               (isset($user_data['msitem_ownerid']) ? (int)$user_data['msitem_ownerid'] : 0);
    
    if ($user_id > 0) {
        $user_fields = userfields_get_user_fields($user_id);
        
        foreach ($user_fields as $field) {
            $field_code = strtoupper($field['field_code']);
            $temp_array["USERFIELDS_{$field_code}"] = htmlspecialchars($field['value']);
            $temp_array["USERFIELDS_{$field_code}_TITLE"] = htmlspecialchars($field['field_title']);
        }
    }
}
?>