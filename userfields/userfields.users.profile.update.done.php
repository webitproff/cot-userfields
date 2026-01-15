<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.profile.update.done
 * [END_COT_EXT]
 */
 
/**
 * Userfields plugin for Cotonti 0.9.26, PHP 8.4+ импорт и сохранение при редактировании собственных полей пользователем
 * Filename: userfields.users.edit.update.done.php
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

$values = cot_import('userfields_values', 'P', 'ARR');

userfields_save_user_fields($usr['id'], $values);
