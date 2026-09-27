

# Userfields Plugin for Cotonti 0.9.26
> ⚠️ **WARNING!**
>
> This extension has been declared **deprecated** and may break other plugins or modules.
>
> **Do not install it on a production site.**
>
> To use multiple additional fields for the users module, use either the USERS module’s own fields or the [Extrafields Users Custom](https://github.com/webitproff/xtradbrowusers-cotonti) plugin.

## Overview

The **Userfields** plugin for Cotonti CMS enables the creation and management of custom user fields (e.g., phone number, company name, address, Telegram) without modifying the `cot_users` table. It uses dedicated tables `cot_userfield_types` (field types) and `cot_userfield_values` (field values) for scalability and ease of use. Fields seamlessly integrate into user profiles, admin panels, and templates across various modules (user lists, articles, forums, Multistore module).


[![Cotonti Compatibility](https://img.shields.io/badge/Cotonti_Siena-0.9.26-orange.svg)](https://github.com/Cotonti/Cotonti)
[![PHP](https://img.shields.io/badge/PHP-8.4-purple.svg)](https://www.php.net/releases/8_4_0.php)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-blue.svg)](https://www.mysql.com/)
[![Bootstrap v5.3.8](https://img.shields.io/badge/Bootstrap-v5.3.8-blueviolet.svg)](https://getbootstrap.com/)




![Custom Userfields Plugin for Cotonti CMF](https://raw.githubusercontent.com/webitproff/cot-userfields/main/User-fields-Plugin-for-Cotonti_3.webp)

#### Key Features
- Create, edit, and delete field types with unique codes, titles, and sort orders via the admin panel.
- Store field values in a separate table linked to user IDs.
- Edit fields in user profiles (`users.profile.tpl`) and admin user editor (`users.edit.tpl`).
- Display fields in user lists (`users.tpl`), profile pages (`users.details.tpl`), and other templates (e.g., `page.tpl`, `mstore.tpl`, `forums.posts.tpl`) using Cotonti tags.
- Support for individual field tags (e.g., `{USERFIELDS_CELL_NUMBER}`), a loop for all fields (`<!-- BEGIN: USERFIELDS -->`), and an HTML block (`{USERFIELDS_ROWS_HTML}` or `{USERS_ROW_FIELD_ROWS_HTML}`).
- Automatically save field values during profile or user data updates.
- Sort fields by `order_num` parameter.
- Includes test fields (`cell_number`, `company_name`) for quick setup.
- User-friendly admin panel for field management.

##### Field Types:
- Text
- Integer
- Currency
- Decimal
- Textarea
- Dropdown
- Radio Buttons
- Checkbox
- Date/Time
- Country
- Number Range
- Checkbox List

### Requirements
- Cotonti CMS 0.9.26 or higher.
- PHP 8.4 or higher.
- Active `users` module.
- MySQL 8.0 with InnoDB support (for foreign keys).

## Installation

1. **Prepare Files**:
   - Download the source code from the [GitHub repository](https://github.com/webitproff/cot-userfields).
   - Extract `cot-userfields-main.zip` and upload the `userfields` folder to the `plugins` directory in your Cotonti root.

2. **Install via Admin Panel**:
   - Log into the Cotonti admin panel (`/admin.php`).
   - Navigate to **Administration > Extensions > User Fields**.
   - Find the **Userfields** plugin and click **Install**.
   - The plugin creates tables `cot_userfield_types` and `cot_userfield_values`, adding test fields: `cell_number` (Mobile Phone Number, order 1) and `company_name` (Company Name, order 2).
   - These test fields are examples; you can delete, edit, or create new ones as needed.

3. **Plugin Files**:
   - `userfields.setup.php` (plugin configuration).
   - `userfields.install.sql` (creates tables and test data).
   - `userfields.uninstall.sql` (removes tables).
   - `userfields.admin.php` (admin panel logic).
   - `userfields.admin.tpl` (admin panel template).
   - `userfields.ru.lang.php` (Russian localization).
   - `userfields.en.lang.php` (English localization).
   - `userfields.functions.php` (core functions).
   - `userfields.users.details.tags.php` (tags for public user profile page).
   - `userfields.users.profile.tags.php` (tags for profile editing).
   - `userfields.users.edit.tags.php` (tags for admin user editing).
   - `userfields.users.profile.update.done.php` (handles profile updates).
   - `userfields.users.edit.update.done.php` (handles admin user updates).
   - `userfields.users.loop.php` (displays fields in user lists).
   - `userfields.usertags.php` (integrates with `usertags` to display fields in any template where a username is visible, without guessing prefixes, e.g., `mstore.index.tpl`, `mstore.list.tpl`, `page.tpl`, `page.list.tpl`, `forums.posts.tpl`, etc.).

### Plugin Files and Structure

```
/userfields/
├── inc/
│   └── userfields.functions.php         # Core functions
├── lang/
│   ├── userfields.ru.lang.php           # Russian localization
│   ├── userfields.en.lang.php           # English localization
├── setup/
│   ├── userfields.install.sql           # SQL for creating tables
│   └── userfields.uninstall.sql         # SQL for dropping tables
├── tpl/
│   └── userfields.admin.tpl             # Template for admin panel
├── userfields.admin.php                 # Logic for managing fields
├── userfields.global.php                # Includes language files
├── userfields.setup.php                 # Plugin configuration and setup
├── userfields.users.details.tags.php    # Tags for public user profile page (users.details.tpl)
├── userfields.users.edit.tags.php       # Tags for admin user editing (users.edit.tpl)
├── userfields.users.edit.update.done.php # Handles updates by administrators
├── userfields.users.loop.php            # Displays fields in user lists (users.tpl)
├── userfields.users.profile.tags.php     # Tags for profile editing (users.profile.tpl)
├── userfields.users.profile.update.done.php # Handles updates by users
└── userfields.usertags.php              # Tags for integration into other modules and plugins without specific prefixes
```

4. **Uninstallation**:
   - In admin panel: **Administration > Extensions > Userfields > Uninstall**.
   - Executes `userfields.uninstall.sql`, removing tables.
   - Manually delete the `plugins/userfields` folder.

5. **Troubleshooting**:
   - Follow the installation instructions or seek help on the [support forum](https://abuyfile.com/en/forums/cotonti/custom/plugs/topic155).

## Managing Fields in Admin Panel

Access the admin panel at **Administration > Other > Userfields** (requires admin privileges).

### Interface
- **Title**: "Manage Additional User Fields".
- **Field Types List**: Table with columns: Code, Title, Sort Order, Edit, Delete.
- **Forms**: For adding/editing field types.

### Adding a Field Type
- Click **Add Field Type**.
- Form:
  - **Code**: Unique identifier (latin letters, numbers, underscore only; max 50 characters). Used in tags (e.g., `cell_number` → `USERFIELDS_CELL_NUMBER`). Required, must be unique.
  - **Title**: Display name (e.g., "Contact Phone"; max 100 characters). Required.
  - **Sort Order (order_num)**: Integer (e.g., 1 for first, 2 for second). Defines display order (lower number = higher priority). Required, defaults to 0.
- Click **Save**. Errors (duplicate code, empty fields) will be displayed.

### Editing a Field Type
- Click **Edit** next to a field.
- Update code, title, or sort order (code must remain unique).
- Click **Save**. Update template tags if the code changes.

### Deleting a Field Type
- Click **Delete** and confirm.
- Removes the field type and associated values in `cot_userfield_values` (via `ON DELETE CASCADE`).

### Field Definitions
- **id**: Auto-generated unique ID.
- **code**: Tag identifier (e.g., `USERFIELDS_CODE` for value, `USERFIELDS_CODE_TITLE` for title).
- **title**: Display name for forms and outputs.
- **order_num**: Controls display order.

### Filling Fields
- **By Users**: In profile (`users.profile.tpl`), fields appear as a table with title and input. Saved on profile update.
- **By Admins**: In user editor (`users.edit.tpl`), similar table for any user. Saved on user update.
- **Format**: Set in the plugin's admin panel. Fields are optional.

## Template Integration

The plugin integrates easily with the `users` module and other module templates (`mstore`, `page`, `forums`).

**Carefully read the instructions and use only one integration method for your templates.**

Tags use the field code in uppercase (e.g., create `cell_number` in the admin panel, use `{USERFIELDS_CELL_NUMBER}` in templates).

All tags must be wrapped in a conditional check: `<!-- IF {PHP|cot_plugin_active('userfields')} -->` to verify if the plugin is installed, preventing potential errors.

#### For each template, there are two integration methods: **loop** (automatic output of all fields) and **individual** (custom styling for specific fields).

---

### 1. Users Module Templates

#### users.profile.tpl (Profile Editing) - Use Only One Method!

**1. OR Loop (Automatic Output of All Fields) - For Lazy Users**:
- Automatically outputs all fields with titles and input fields in a loop (i.e., a simple list of all fields created in the admin panel).
- Inside `<form>` (e.g., after `{USERS_PROFILE_COUNTRY}`), add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="userfields-block">
      <!-- BEGIN: USERFIELDS -->
      <div>
          <label>{USERFIELDS_FIELD_TITLE}</label>
          {USERFIELDS_FIELD}
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```

**2. OR Individual (Custom Styling for Specific Fields) - Recommended, Not for Lazy Users**:
- Outputs specific fields with custom styling, using tags without specific prefixes (e.g., `{USERFIELDS_CELL_NUMBER}` for the phone number input field and `{USERFIELDS_CELL_NUMBER_TITLE}` for the field title, e.g., "Contact Phone," as set in the admin panel).
- Inside `<form>` (e.g., after `{USERS_PROFILE_COUNTRY}`), add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <label class="userfield-title text-primary">{USERFIELDS_CELL_NUMBER_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_CELL_NUMBER}</div>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield text-danger">
          <label class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_COMPANY_NAME}</div>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
- Outputs specific fields with custom styling and order. Each field can be styled individually, e.g., add icons, tooltips, colors, or sizes.

#### users.edit.tpl (Admin User Editing) - Use Only One Method!

**1. OR Loop (Automatic Output of All Fields) - For Lazy Users**:
- Automatically outputs all fields with titles and input fields in a loop (i.e., a simple list of all fields created in the admin panel).
- Inside `<form>` (e.g., after `{USERS_EDIT_COUNTRY}`), add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="userfields-block">
      <!-- BEGIN: USERFIELDS -->
      <div>
          <label>{USERFIELDS_FIELD_TITLE}</label>
          {USERFIELDS_FIELD}
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```

**2. OR Individual (Custom Styling for Specific Fields) - Recommended, Not for Lazy Users**:
- Outputs specific fields with custom styling, using tags without specific prefixes (e.g., `{USERFIELDS_CELL_NUMBER}` for the phone number input field and `{USERFIELDS_CELL_NUMBER_TITLE}` for the field title, e.g., "Contact Phone," as set in the admin panel).
- Inside `<form>` (e.g., after `{USERS_EDIT_COUNTRY}`), add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <label class="userfield-title text-primary">{USERFIELDS_CELL_NUMBER_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_CELL_NUMBER}</div>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield text-danger">
          <label class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_COMPANY_NAME}</div>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
- Outputs specific fields with custom styling and order. Each field can be styled individually, e.g., add icons, tooltips, colors, or sizes.

#### users.details.tpl (Public Profile Page) - Use Only One Method!

**1. OR Loop (Automatic Output of All Fields) - For Lazy Users**:
- Automatically outputs all fields with titles and values in a loop (i.e., a simple list of all fields filled in during profile editing).
- After `{USERS_DETAILS_COUNTRY_FLAG} {USERS_DETAILS_COUNTRY}`, add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="userfields-details">
      <h3>Additional Fields</h3>
      <!-- BEGIN: USERFIELDS_DETAILS -->
      <div class="userfield">
          <label class="userfield-title text-success">{USERFIELDS_FIELD_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_FIELD}</div>
      </div>
      <!-- END: USERFIELDS_DETAILS -->
  </div>
  <!-- ENDIF -->
  ```

**2. OR Individual (Custom Styling for Specific Fields) - Recommended, Not for Lazy Users**:
- Outputs specific fields with custom styling, using tags without specific prefixes (e.g., `{USERFIELDS_CELL_NUMBER}` for the phone number value and `{USERFIELDS_CELL_NUMBER_TITLE}` for the field title, e.g., "Contact Phone").
- After `{USERS_DETAILS_COUNTRY_FLAG} {USERS_DETAILS_COUNTRY}`, add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
- Each field can be styled individually, e.g., make the phone number clickable or add icons.

#### users.tpl (User List) - Use Only One Method

##### Uses logic from `userfields.users.loop.php`
- Inside the user loop `<!-- BEGIN: USERS_ROW -->` and `<!-- END: USERS_ROW -->`
- For example, after `{USERS_ROW_NAME}`, add:

**1. OR Loop (Automatic Output of All Fields) - For Lazy Users**:
- Automatically outputs all fields with titles and values in a loop.
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```

**2. OR Single Tag Pre-formatted HTML Block (For Extremely Lazy Users)**:
- Automatically outputs all fields with titles and values in a pre-formatted HTML block.
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <hr>
      {USERS_ROW_FIELD_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```

**3. OR Individual (Custom Styling for Specific Fields) - Recommended, Not for Lazy Users**:
- Outputs specific fields with custom styling, using tags without specific prefixes (e.g., `{USERFIELDS_CELL_NUMBER}` for the phone number value and `{USERFIELDS_CELL_NUMBER_TITLE}` for the field title, e.g., "Contact Phone").
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```

### 2. Other Modules (via usertags)

The plugin supports integration with other modules, generating tags without specific extension prefixes for the `USERFIELDS` loop and individual fields (e.g., `USERFIELDS_CELL_NUMBER`, `USERFIELDS_ROWS_HTML`). The logic is handled in `userfields.usertags.php`, ensuring no prefixes are used.

#### page.tpl (Article Page) - Use Only One Method

- For example, after `{PAGE_OWNER_NAME}` or in any suitable location, add:

**1. OR Loop (Automatic Output of All Fields) - For Lazy Users**:
- Automatically outputs all fields with titles and values in a loop.
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```

**2. OR Single Tag Pre-formatted HTML Block (For Extremely Lazy Users)**:
- Automatically outputs all fields with titles and values in a pre-formatted HTML block.
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <hr>
      {USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```

**3. OR Individual (Custom Styling for Specific Fields) - Recommended, Not for Lazy Users**:
- Outputs specific fields with custom styling, using tags without specific prefixes (e.g., `{USERFIELDS_CELL_NUMBER}` for the phone number value and `{USERFIELDS_CELL_NUMBER_TITLE}` for the field title, e.g., "Contact Phone").
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```

#### mstore.index.tpl / mstore.list.tpl (Product Lists) - Use Only One Method

- Inside the product loop `<!-- BEGIN: MSTORE_ROW -->` and `<!-- END: MSTORE_ROW -->` or `<!-- BEGIN: LIST_ROW -->` and `<!-- END: LIST_ROW -->`
- For example, after `{MSTORE_ROW_TITLE}`, add:

**1. OR Loop (Automatic Output of All Fields) - For Lazy Users**:
- Automatically outputs all fields with titles and values in a loop.
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```

**2. OR Single Tag Pre-formatted HTML Block (For Extremely Lazy Users)**:
- Automatically outputs all fields with titles and values in a pre-formatted HTML block.
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <hr>
      {USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```

**3. OR Individual (Custom Styling for Specific Fields) - Recommended, Not for Lazy Users**:
- Outputs specific fields with custom styling, using tags without specific prefixes (e.g., `{USERFIELDS_CELL_NUMBER}` for the phone number value and `{USERFIELDS_CELL_NUMBER_TITLE}` for the field title, e.g., "Contact Phone").
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```

#### mstore.tpl (Product Page) - Use Only One Method

- For example, after `{MSTORE_OWNER_NAME}`, add:

**1. OR Loop (Automatic Output of All Fields) - For Lazy Users**:
- Automatically outputs all fields with titles and values in a loop.
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```

**2. OR Single Tag Pre-formatted HTML Block (For Extremely Lazy Users)**:
- Automatically outputs all fields with titles and values in a pre-formatted HTML block.
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <hr>
      {USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```

**3. OR Individual (Custom Styling for Specific Fields) - Recommended, Not for Lazy Users**:
- Outputs specific fields with custom styling, using tags without specific prefixes (e.g., `{USERFIELDS_CELL_NUMBER}` for the phone number value and `{USERFIELDS_CELL_NUMBER_TITLE}` for the field title, e.g., "Contact Phone").
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```

#### forums.posts.tpl (Forum Posts) - Use Only One Method

**1. OR Loop (Automatic Output of All Fields) - For Lazy Users**:
- For example, after `{FORUMS_POSTS_ROW_USER_NAME}` in the post block, add:
- Automatically outputs all fields with titles and values in a loop.
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```

**2. OR Single Tag Pre-formatted HTML Block (For Extremely Lazy Users)**:
- Automatically outputs all fields with titles and values in a pre-formatted HTML block.
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <hr>
      {USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```

**3. OR Individual (Custom Styling for Specific Fields) - Recommended, Not for Lazy Users**:
- Outputs specific fields with custom styling, using tags without specific prefixes (e.g., `{USERFIELDS_CELL_NUMBER}` for the phone number value and `{USERFIELDS_CELL_NUMBER_TITLE}` for the field title, e.g., "Contact Phone").
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```

## Support
Discuss the plugin, ask questions, or get help in the [dedicated forum thread](https://abuyfile.com/en/forums/cotonti/custom/plugs/topic155).

## License
BSD License. Copyright (c) webitproff 2025.

2026, 4Th, Jan
fixed an error when viewing the comments administration page.
---


---

### 🇷🇺 Русский

# Плагин Userfields для Cotonti 0.9.26
> ⚠️ **ВНИМАНИЕ!**
>
> Расширение объявлено как **устаревшее** и такое, что может нарушить работу других плагинов или модулей.
> **Не использовать для установки на рабочий сайт.**
>
> Для использования множественных дополнительных полей для модуля пользователей использовать либо собственные поля модуля USERS, либо плагин [Extrafields Users Custom](https://github.com/webitproff/xtradbrowusers-cotonti).
## Описание

Плагин **Userfields** для CMS Cotonti позволяет создавать и управлять дополнительными пользовательскими полями (например, номер телефона, название компании, адрес, телеграм) без изменения таблицы `cot_users`. Использует таблицы `cot_userfield_types` (типы полей) и `cot_userfield_values` (значения полей) для масштабируемости и удобства. Поля интегрируются в профили пользователей, админ-панель и шаблоны (список пользователей, статьи, форумы, модуль Multistore).

![Плагин дополнительных полей для Cotonti CMF](https://raw.githubusercontent.com/webitproff/cot-userfields/main/User-fields-Plugin-for-Cotonti_3.webp)

#### Основные возможности
- Создание, редактирование и удаление типов полей с уникальными кодами, названиями и порядком сортировки через админ-панель.
- Хранение значений в отдельной таблице, привязанной к ID пользователя.
- Редактирование полей в профиле (`users.profile.tpl`) и админском редакторе (`users.edit.tpl`).
- Вывод полей в списках пользователей (`users.tpl`), страницах профиля (`users.details.tpl`) и других шаблонах (`page.tpl`, `mstore.tpl`, `forums.posts.tpl`) через теги Cotonti.
- Поддержка индивидуальных тегов (например, `{USERFIELDS_CELL_NUMBER}`), цикла для всех полей (`<!-- BEGIN: USERFIELDS -->`) и HTML-блока (`{USERFIELDS_ROWS_HTML}` или `{USERS_ROW_FIELD_ROWS_HTML}`).
- Автоматическое сохранение значений при обновлении профиля или данных пользователя.
- Сортировка полей по параметру `order_num`.
- Тестовые поля (`cell_number`, `company_name`) для быстрого старта.
- Удобная админ-панель для управления полями.

##### Типы полей: 

- Текст  
- Целое число  
- Валюта  
- Дробное число  
- Текстовая область  
- Выпадающий список  
- Радиокнопки  
- Чекбокс  
- Дата/Время  
- Страна  
- Диапазон чисел  
- Список чекбоксов  



### Требования
- Cotonti CMS 0.9.26 или выше.
- PHP 8.4+.
- Активный модуль `users`.
- MySQL 8.0 с поддержкой InnoDB (для внешних ключей).

## Установка

1. **Подготовка файлов**:
   - Скачайте исходный код с [репозитория на GitHub](https://github.com/webitproff/cot-userfields).
   - Распакуйте `cot-userfields-main.zip` и загрузите папку `userfields` в директорию `plugins` в корне Cotonti.

2. **Установка через админ-панель**:
   - Войдите в админ-панель (`/admin.php`).
   - Перейдите в **Администрирование > Расширения > User Fields**.
   - Найдите плагин **Userfields** и нажмите **Установить**.
   - Плагин создаёт таблицы `cot_userfield_types` и `cot_userfield_values`, добавляя тестовые поля: `cell_number` (Номер мобильного телефона, порядок 1) и `company_name` (Название компании, порядок 2).
   - Эти поля — примеры; их можно удалить, отредактировать или создать новые.

3. **Список файлов плагина**:
   - `userfields.setup.php` (конфигурация плагина).
   - `userfields.install.sql` (создание таблиц и тестовых данных).
   - `userfields.uninstall.sql` (удаление таблиц).
   - `userfields.admin.php` (логика админ-панели).
   - `userfields.admin.tpl` (шаблон админ-панели).
   - `userfields.ru.lang.php` (русская локализация).
   - `userfields.en.lang.php` (английская локализация).
   - `userfields.functions.php` (основные функции).
   - `userfields.users.details.tags.php` (теги для страницы профиля).
   - `userfields.users.profile.tags.php` (теги для редактирования профиля).
   - `userfields.users.edit.tags.php` (теги для админского редактирования).
   - `userfields.users.profile.update.done.php` (сохранение профиля).
   - `userfields.users.edit.update.done.php` (сохранение в админке).
   - `userfields.users.loop.php` (вывод в списке пользователей).
   - `userfields.usertags.php` (интеграция с `usertags`) выводим поля в любые шаблоны без угадывания префиксов для конкретного шаблона, поля выводим везде, где вы можете увидеть никнейм пользователя и универсальным способом, например mstore.index.tpl, mstore.list.tpl, page.tpl, page.list.tpl, forums.posts.tpl и.п..

### Структура файлов

```
/userfields/
├── inc/
│   └── userfields.functions.php         # Основные функции
├── lang/
│   ├── userfields.ru.lang.php           # Русская локализация
│   ├── userfields.en.lang.php           # Английская локализация
├── setup/
│   ├── userfields.install.sql           # SQL для создания таблиц
│   └── userfields.uninstall.sql         # SQL для удаления таблиц
├── tpl/
│   └── userfields.admin.tpl             # Шаблон для админ-панели
├── userfields.admin.php                 # Логика управления полями
├── userfields.global.php                # Подключение языковых файлов
├── userfields.setup.php                 # Конфигурация плагина
├── userfields.users.details.tags.php       # Теги для вывода полей на страницы публичного профиля пользователей users.details.tpl 
├── userfields.users.edit.tags.php          # Теги для админского редактирования users.edit.tpl
├── userfields.users.edit.update.done.php   # Сохранение изменений администратором
├── userfields.users.loop.php               # Вывод полей в списке пользователей users.tpl
├── userfields.users.profile.tags.php       # Теги для редактирования профиля users.profile.tpl
├── userfields.users.profile.update.done.php # Сохранение изменений пользователем
└── userfields.usertags.php                  # Теги для интеграции в другие модули и плагины на своих условиях без специальных преффиксов

```

4. **Деинсталляция**:
   - В админ-панели: **Администрирование > Расширения > Userfields > Деинсталлировать**.
   - Выполняется `userfields.uninstall.sql`, удаляющий таблицы.
   - Удалите папку `plugins/userfields` вручную.

5. **Устранение неполадок**:
   - читать инструкцию по установке или писать на <strong>[форуме поддержки](https://abuyfile.com/ru/forums/cotonti/custom/plugs/topic155)</strong>

## Управление полями в админ-панели

Админ-панель: **Администрирование > Другие > Userfields** .

### Интерфейс
- **Заголовок**: "Управление дополнительными полями пользователей".
- **Список типов полей**: Таблица с колонками: Код, Название, Порядок сортировки, Редактировать, Удалить.
- **Формы**: Для добавления/редактирования типов полей.

### Добавление типа поля
- Нажмите **Добавить тип поля**.
- Форма:
  - **Код (code)**: Уникальный идентификатор (латинские буквы, цифры, нижнее подчеркивание; макс. 50 символов). Используется в тегах (например, `cell_number` → `USERFIELDS_CELL_NUMBER`). Обязательное, уникальное.
  - **Название (title)**: Отображаемое имя (например, "Контактный телефон"; макс. 100 символов). Обязательное.
  - **Порядок сортировки (order_num)**: Целое число (1 — первый, 2 — второй). Определяет порядок вывода (меньше — выше). Обязательное, по умолчанию 0.
- Нажмите **Сохранить**. Ошибки (дубликат кода, пустые поля) будут отображены.

### Редактирование типа поля
- Нажмите **Редактировать** рядом с полем.
- Измените код, название или порядок (код должен быть уникальным).
- Нажмите **Сохранить**. Обновите теги в шаблонах, если код изменился.

### Удаление типа поля
- Нажмите **Удалить** и подтвердите.
- Удаляет тип поля и связанные значения в `cot_userfield_values` (через `ON DELETE CASCADE`).

### Определение полей
- **id**: Автоматический уникальный ID.
- **code**: Идентификатор для тегов (`USERFIELDS_CODE` — значение, `USERFIELDS_CODE_TITLE` — название).
- **title**: Название для форм и вывода.
- **order_num**: Порядок вывода.

### Заполнение полей
- **Пользователями**: В профиле (`users.profile.tpl`) поля отображаются как таблица с названием и полем ввода. Сохраняются при обновлении профиля.
- **Администраторами**: В редакторе (`users.edit.tpl`) — аналогичная таблица для любого пользователя. Сохраняется при обновлении.
- **Формат**: Устанавливается в админке плагина. Поля необязательные.

## Интеграция в шаблоны

Плагин интегрируется легко и просто в модуль `users` и также просто в шаблоны других модулей (`mstore`, `page`, `forums`). 

**Просто внимательно читайте инструкцию и используйте один какой-то способ интеграции в свои шаблоны.**

Теги используют код поля в верхнем регистре (например, в админке при создании поля пишем `cell_number` а выводим в шаблонах уже `{USERFIELDS_CELL_NUMBER}`).

Все теги обязательно должны оборачиваются в условие проверки функции`<!-- IF {PHP|cot_plugin_active('userfields')} -->` тут поля ваши `<!-- ENDIF -->` - так проверяем на уровне движка установлен ли плагин и исключаем ряд возможных глупых ошибок. 

#### Для каждого шаблона есть два способа интеграции: **циклом** (автоматический вывод всех полей) и **индивидуально** (кастомная стилизация конкретных полей).


---
### 1. Шаблоны модуля `users`

--
#### users.profile.tpl (Редактирование профиля) использовать один какой-то способ!!!

**1 ЛИБО Циклом (автоматический вывод всех полей) это для ленивых**:

- Выводит все поля автоматически с названием и ввода значений, в виде цикла <strong>(по-простому - списком, все поля, которые вы создали в админке)</strong>.
- Внутри `<form>` (например, после `{USERS_PROFILE_COUNTRY}`) добавьте:

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="userfields-block">
      <!-- BEGIN: USERFIELDS -->
      <div>
          <label>{USERFIELDS_FIELD_TITLE}</label>
          {USERFIELDS_FIELD}
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```



**2. ЛИБО Индивидуально (кастомная стилизация полей) рекомендуемый способ, не для ленивых**:

- Выводит конкретные поля с индивидуальной стилизацией, используя теги без специальных префиксов (например, просто `{USERFIELDS_CELL_NUMBER}` поле для ввода  и сохранения номера телефона и `{USERFIELDS_CELL_NUMBER_TITLE}` - название поля, например "Контактный телефон", которое вы указываетет в админке при создании поля).

- Внутри `<form>` (например, после `{USERS_PROFILE_COUNTRY}`) добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <label class="userfield-title text-primary">{USERFIELDS_CELL_NUMBER_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_CELL_NUMBER}</div>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield text-danger">
          <label class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_COMPANY_NAME}</div>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
- Выводит конкретные поля с индивидуальной стилизацией и порядком в списке. 
- Каждое поле вы можете индивидуально стилизировать, например, в оформление поля добавить иконку, разместить текст подсказки, добавить цвет и размер, и т.п..
--

#### users.edit.tpl (Админское редактирование) использовать один какой-то способ!!!

**1 ЛИБО Циклом (автоматический вывод всех полей) это для ленивых**:
- Выводит все поля автоматически с названием и ввода значений, в виде цикла <strong>(по-простому - списком, все поля, которые вы создали в админке)</strong>.

- Внутри `<form>` (например, после `{USERS_EDIT_COUNTRY}`) добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="userfields-block">
      <!-- BEGIN: USERFIELDS -->
      <div>
          <label>{USERFIELDS_FIELD_TITLE}</label>
          {USERFIELDS_FIELD}
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```


**2. ЛИБО Индивидуально (кастомная стилизация полей) рекомендуемый способ, не для ленивых**:

- Выводит конкретные поля с индивидуальной стилизацией, используя теги без специальных префиксов (например, просто `{USERFIELDS_CELL_NUMBER}` поле для ввода  и сохранения номера телефона и `{USERFIELDS_CELL_NUMBER_TITLE}` - название поля, например "Контактный телефон", которое вы указываетет в админке при создании поля).

- Внутри `<form>` (например, после `{USERS_EDIT_COUNTRY}`) добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <label class="userfield-title text-primary">{USERFIELDS_CELL_NUMBER_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_CELL_NUMBER}</div>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield text-danger">
          <label class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_COMPANY_NAME}</div>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
- Выводит конкретные поля с индивидуальной стилизацией и порядком в списке. 
- Каждое поле вы можете индивидуально стилизировать, например, в оформление поля добавить иконку, разместить текст подсказки, добавить цвет и размер, и т.п..

--

#### users.details.tpl (Страница публичного профиля) использовать один какой-то способ!!!

**1 ЛИБО Циклом (автоматический вывод всех полей) это для ленивых**:

- Выводит все поля автоматически с названием и значением, в виде цикла <strong>(по-простому - списком, всё, что было заполнено при редактировании профиля)</strong>.

- После `{USERS_DETAILS_COUNTRY_FLAG} {USERS_DETAILS_COUNTRY}` добавьте:

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="userfields-details">
      <h3>Дополнительные поля</h3>
      <!-- BEGIN: USERFIELDS_DETAILS -->
      <div class="userfield">
          <label class="userfield-title text-success">{USERFIELDS_FIELD_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_FIELD}</div>
      </div>
      <!-- END: USERFIELDS_DETAILS -->
  </div>
  <!-- ENDIF -->
  ```


**2. ЛИБО Индивидуально (кастомная стилизация полей) рекомендуемый способ, не для ленивых**:

- Выводит конкретные поля с индивидуальной стилизацией, используя теги без специальных префиксов (например, просто `{USERFIELDS_CELL_NUMBER}` значение номера телефона и `{USERFIELDS_CELL_NUMBER_TITLE}` - название поля, например "Контактный телефон").

- После `{USERS_DETAILS_COUNTRY_FLAG} {USERS_DETAILS_COUNTRY}` добавьте:

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
- Каждое поле вы можете индивидуально стилизировать, например, сделать кликабельный номер телефона, или в оформление поля добавить иконку и т.п..

--

#### users.tpl (Список пользователей) использовать один какой-то способ

##### используется логика `userfields.users.loop.php`

- Внутри цикла товаров `<!-- BEGIN: USERS_ROW -->` и `<!-- END: USERS_ROW -->`
- Например, после `{USERS_ROW_NAME}` добавьте:

**1 ЛИБО Циклом (автоматический вывод всех полей) это для ленивых**:

- Выводит все поля автоматически в виде цикла с названием и значением.

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```
  
  
**2 ЛИБО одним тегом предформатированный HTML-блок (для крайне ленивых)**

- Выводит все поля автоматически в виде цикла с названием и значением, но это уже <strong>предформатированный HTML-блок</strong>.

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <hr>
      {USERS_ROW_FIELD_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
  


**3 ЛИБО Индивидуально (кастомная стилизация полей) рекомендуемый способ, не для ленивых**:

- Выводит конкретные поля с индивидуальной стилизацией, используя теги без префиксов специальных (например, просто `{USERFIELDS_CELL_NUMBER}` значение номера телефона и `{USERFIELDS_CELL_NUMBER_TITLE}` - название поля, например "Контактный телефон").

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
  
--

### 2. Другие модули (через usertags)

Плагин поддерживает интеграцию с другими модулями, который генерирует теги без префиксов ваших расширений для цикла `USERFIELDS` и индивидуальных полей (например, `USERFIELDS_CELL_NUMBER`, `USERFIELDS_ROWS_HTML`). 
Ниже приведены исправленные интеграции, вся логика в `userfields.usertags.php`, без использования префиксов.

#### page.tpl (Страница статьи) использовать один какой-то способ 

- Например, после `{PAGE_OWNER_NAME}` или в любом удобном месте добавьте

**1 ЛИБО Циклом (автоматический вывод всех полей) это для ленивых**:

- Выводит все поля автоматически в виде цикла с названием и значением.

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```
  
**2 ЛИБО одним тегом предформатированный HTML-блок (для крайне ленивых)**

- Выводит все поля автоматически в виде цикла с названием и значением, но это уже <strong>предформатированный HTML-блок</strong>.

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <hr>
      {USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
  


**3 ЛИБО Индивидуально (кастомная стилизация полей) рекомендуемый способ, не для ленивых**:

- Выводит конкретные поля с индивидуальной стилизацией, используя теги без префиксов специальных (например, просто `{USERFIELDS_CELL_NUMBER}` значение номера телефона и `{USERFIELDS_CELL_NUMBER_TITLE}` - название поля, например "Контактный телефон").

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
  
--

#### mstore.index.tpl / mstore.list.tpl (Списки товаров) использовать один какой-то способ 

- Внутри цикла товаров `<!-- BEGIN: MSTORE_ROW -->` и `<!-- END: MSTORE_ROW -->` или `<!-- BEGIN: LIST_ROW -->` и `<!-- END: LIST_ROW -->`
- Например, после `{MSTORE_ROW_TITLE}` добавьте:

**1 ЛИБО Циклом (автоматический вывод всех полей) это для ленивых**:

- Выводит все поля автоматически в виде цикла с названием и значением.

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```
  
**2 ЛИБО одним тегом предформатированный HTML-блок (для крайне ленивых)**

- Выводит все поля автоматически в виде цикла с названием и значением, но это уже <strong>предформатированный HTML-блок</strong>.

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <hr>
      {USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```



**3 ЛИБО Индивидуально (кастомная стилизация полей) рекомендуемый способ, не для ленивых**:

- Выводит конкретные поля с индивидуальной стилизацией, используя теги без префиксов специальных (например, просто `{USERFIELDS_CELL_NUMBER}` значение номера телефона и `{USERFIELDS_CELL_NUMBER_TITLE}` - это название поля, например "Контактный телефон").

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
--

#### mstore.tpl (Страница товара) использовать один какой-то способ 

- Например, после `{MSTORE_OWNER_NAME}` добавьте:

**1 ЛИБО Циклом (автоматический вывод всех полей) это для ленивых**:

- Выводит все поля автоматически в виде цикла с названием и значением.

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```
  
**2 ЛИБО одним тегом предформатированный HTML-блок (для крайне ленивых)**

- Выводит все поля автоматически в виде цикла с названием и значением, но это уже <strong>предформатированный HTML-блок</strong>.

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <hr>
      {USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
  


**3 ЛИБО Индивидуально (кастомная стилизация полей) рекомендуемый способ, не для ленивых**:

- Выводит конкретные поля с индивидуальной стилизацией, используя теги без префиксов специальных (например, просто `{USERFIELDS_CELL_NUMBER}` значение номера телефона и `{USERFIELDS_CELL_NUMBER_TITLE}` - название поля, например "Контактный телефон").

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```


--

#### forums.posts.tpl (Посты форума) использовать один какой-то способ 

**1 ЛИБО Циклом (автоматический вывод всех полей) это для ленивых**:

- Например, после `{FORUMS_POSTS_ROW_USER_NAME}` в блоке поста добавьте:
- Выводит все поля автоматически в виде цикла с названием и значением
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```
**2 ЛИБО одним тегом предформатированный HTML-блок (для крайне ленивых)**

- Выводит все поля автоматически в виде цикла с названием и значением, но это уже <strong>предформатированный HTML-блок</strong>.
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <hr>
      {USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```


**3 ЛИБО Индивидуально (кастомная стилизация полей) рекомендуемый способ, не для ленивых**:

- Выводит конкретные поля с индивидуальной стилизацией, используя теги без префиксов специальных (например, просто `{USERFIELDS_CELL_NUMBER}` значение номера телефона и `{USERFIELDS_CELL_NUMBER_TITLE}` - название поля, например "Контактный телефон").

  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
  


--

## Поддержка
Обсуждение плагина, вопросы и помощь в [отдельной теме на форуме](https://abuyfile.com/ru/forums/cotonti/custom/plugs/topic155).

## Лицензия
BSD License. Copyright (c) webitproff 2025.
