<!-- BEGIN: MAIN -->
<div class="container-fluid">
    <h2>{PHP.L.userfields}</h2>

    <!-- Display success or error messages -->
    {FILE "{PHP.cfg.themes_dir}/admin/{PHP.cfg.admintheme}/warnings.tpl"}

    <!-- List of field types -->
    <h3>{PHP.L.userfields_field_types}</h3>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>{PHP.L.userfields_code}</th>
                <th>{PHP.L.userfields_field_title}</th>
                <th>{PHP.L.userfields_type}</th>
                <th>{PHP.L.userfields_params}</th>
                <th>{PHP.L.userfields_order}</th>
                <th>{PHP.L.userfields_edit}</th>
                <th>{PHP.L.userfields_delete}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: FIELD_TYPE_ROW -->
            <tr>
                <td>{FIELD_TYPE_CODE}</td>
                <td>{FIELD_TYPE_TITLE}</td>
                <td>{FIELD_TYPE_TYPE}</td>
                <td>{FIELD_TYPE_PARAMS}</td>
                <td>{FIELD_TYPE_ORDER}</td>
                <td><a href="{FIELD_TYPE_EDIT_URL}" class="btn btn-sm btn-primary">{PHP.L.userfields_edit}</a></td>
                <td><a href="{FIELD_TYPE_DELETE_URL}" class="btn btn-sm btn-danger" onclick="return confirm('{PHP.L.userfields_confirm_delete}')">{PHP.L.userfields_delete}</a></td>
            </tr>
            <!-- END: FIELD_TYPE_ROW -->
            <tr>
                <td colspan="7"><a href="{FIELD_TYPE_FORM_ACTION}" class="btn btn-sm btn-success">{PHP.L.userfields_add_field_type}</a></td>
            </tr>
        </tbody>
    </table>

    <!-- Add form -->
    <!-- BEGIN: FIELD_TYPE_ADD_FORM -->
    <div class="p-3 mb-4 bg-primary-subtle text-primary-emphasis">
        <h3>{PHP.L.userfields_add_field_type}</h3>
        <form action="{FIELD_TYPE_FORM_ACTION}" method="post">
            <div class="mb-2">
                <label>{PHP.L.userfields_code}</label>
                <input type="text" name="code" value="{FIELD_TYPE_FORM_CODE}" maxlength="50" class="form-control" />
            </div>
            <div class="mb-2">
                <label>{PHP.L.userfields_field_title}</label>
                <input type="text" name="title" value="{FIELD_TYPE_FORM_TITLE}" maxlength="100" class="form-control" />
            </div>
            <div class="mb-2">
                <label>{PHP.L.userfields_type}</label>
                <select name="field_type" class="form-select">
                    <!-- Options from lang -->
                    <option value="input" selected>{PHP.L.userfields_type_input}</option>
                    <option value="inputint">{PHP.L.userfields_type_inputint}</option>
                    <option value="currency">{PHP.L.userfields_type_currency}</option>
                    <option value="double">{PHP.L.userfields_type_double}</option>
                    <option value="textarea">{PHP.L.userfields_type_textarea}</option>
                    <option value="select">{PHP.L.userfields_type_select}</option>
                    <option value="radio">{PHP.L.userfields_type_radio}</option>
                    <option value="checkbox">{PHP.L.userfields_type_checkbox}</option>
                    <option value="datetime">{PHP.L.userfields_type_datetime}</option>
                    <option value="country">{PHP.L.userfields_type_country}</option>
                    <option value="range">{PHP.L.userfields_type_range}</option>
                    <option value="checklistbox">{PHP.L.userfields_type_checklistbox}</option>
                </select>
            </div>
            <div class="mb-2">
                <label>{PHP.L.userfields_params}</label>
                <textarea name="field_params" class="form-control">{FIELD_TYPE_FORM_PARAMS}</textarea>
                <small>{PHP.L.userfields_params_hint}</small>
            </div>
            <div class="mb-2">
                <label>{PHP.L.userfields_order}</label>
                <input type="number" name="order_num" value="{FIELD_TYPE_FORM_ORDER}" class="form-control" />
            </div>
            <button type="submit" class="btn btn-success">{PHP.L.userfields_save}</button>
            <a href="{FIELD_TYPE_CANCEL_URL}" class="btn btn-secondary">{PHP.L.userfields_cancel}</a>
        </form>
    </div>
    <!-- END: FIELD_TYPE_ADD_FORM -->

    <!-- Edit form -->
    <!-- BEGIN: FIELD_TYPE_EDIT_FORM -->
    <div class="p-3 mb-4 bg-warning-subtle text-warning-emphasis">
        <h3>{PHP.L.userfields_edit} {PHP.L.userfields_field_type}</h3>
        <form action="{FIELD_TYPE_FORM_ACTION}" method="post">
            <input type="hidden" name="id" value="{FIELD_TYPE_FORM_ID}" />
            <div class="mb-2">
                <label>{PHP.L.userfields_code}</label>
                <input type="text" name="code" value="{FIELD_TYPE_FORM_CODE}" maxlength="50" class="form-control" />
            </div>
            <div class="mb-2">
                <label>{PHP.L.userfields_field_title}</label>
                <input type="text" name="title" value="{FIELD_TYPE_FORM_TITLE}" maxlength="100" class="form-control" />
            </div>
            <div class="mb-2">
                <label>{PHP.L.userfields_type}</label>
                <select name="field_type" class="form-select">
                    <option value="input" {FIELD_TYPE_FORM_TYPE|selected($this, 'input')}>{PHP.L.userfields_type_input}</option>
                    <option value="inputint" {FIELD_TYPE_FORM_TYPE|selected($this, 'inputint')}>{PHP.L.userfields_type_inputint}</option>
                    <option value="currency" {FIELD_TYPE_FORM_TYPE|selected($this, 'currency')}>{PHP.L.userfields_type_currency}</option>
                    <option value="double" {FIELD_TYPE_FORM_TYPE|selected($this, 'double')}>{PHP.L.userfields_type_double}</option>
                    <option value="textarea" {FIELD_TYPE_FORM_TYPE|selected($this, 'textarea')}>{PHP.L.userfields_type_textarea}</option>
                    <option value="select" {FIELD_TYPE_FORM_TYPE|selected($this, 'select')}>{PHP.L.userfields_type_select}</option>
                    <option value="radio" {FIELD_TYPE_FORM_TYPE|selected($this, 'radio')}>{PHP.L.userfields_type_radio}</option>
                    <option value="checkbox" {FIELD_TYPE_FORM_TYPE|selected($this, 'checkbox')}>{PHP.L.userfields_type_checkbox}</option>
                    <option value="datetime" {FIELD_TYPE_FORM_TYPE|selected($this, 'datetime')}>{PHP.L.userfields_type_datetime}</option>
                    <option value="country" {FIELD_TYPE_FORM_TYPE|selected($this, 'country')}>{PHP.L.userfields_type_country}</option>
                    <option value="range" {FIELD_TYPE_FORM_TYPE|selected($this, 'range')}>{PHP.L.userfields_type_range}</option>
                    <option value="checklistbox" {FIELD_TYPE_FORM_TYPE|selected($this, 'checklistbox')}>{PHP.L.userfields_type_checklistbox}</option>
                </select>
            </div>
            <div class="mb-2">
                <label>{PHP.L.userfields_params}</label>
                <textarea name="field_params" class="form-control">{FIELD_TYPE_FORM_PARAMS}</textarea>
                <small>{PHP.L.userfields_params_hint}</small>
            </div>
            <div class="mb-2">
                <label>{PHP.L.userfields_order}</label>
                <input type="number" name="order_num" value="{FIELD_TYPE_FORM_ORDER}" class="form-control" />
            </div>
            <button type="submit" class="btn btn-primary">{PHP.L.userfields_save}</button>
            <a href="{FIELD_TYPE_CANCEL_URL}" class="btn btn-secondary">{PHP.L.userfields_cancel}</a>
        </form>
    </div>
    <!-- END: FIELD_TYPE_EDIT_FORM -->
</div>

<!-- END: MAIN -->
