<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.edit.update.done
 * [END_COT_EXT]
 */

/**
 * Userfields plugin for Cotonti 0.9.26
 * Filename: userfields.users.edit.update.done.php
 * @package userfields
 * @version 1.0.3
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */
 
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('userfields', 'plug');

$values = cot_import('userfields_values', 'P', 'ARR');

userfields_save_user_fields($id, $values);
?>