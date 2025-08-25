<!-- BEGIN: MAIN -->
<div class="container-fluid">
    <h2>{PHP.L.userfields}</h2>

    <!-- Вывод сообщений об успехе или ошибках -->
    {FILE "{PHP.cfg.themes_dir}/admin/{PHP.cfg.admintheme}/warnings.tpl"}

    <!-- Список типов полей -->
    <h3>{PHP.L.userfields_field_types}</h3>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>{PHP.L.userfields_code}</th>
                <th>{PHP.L.userfields_field_title}</th>
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
                <td>{FIELD_TYPE_ORDER}</td>
                <td><a href="{FIELD_TYPE_EDIT_URL}" class="btn btn-sm btn-primary">{PHP.L.userfields_edit}</a></td>
                <td><a href="{FIELD_TYPE_DELETE_URL}" class="btn btn-sm btn-danger" onclick="return confirm('{PHP.L.userfields_confirm_delete}')">{PHP.L.userfields_delete}</a></td>
            </tr>
            <!-- END: FIELD_TYPE_ROW -->
            <tr>
                <td colspan="5"><a href="{FIELD_TYPE_FORM_ACTION}" class="btn btn-sm btn-success">{PHP.L.userfields_add_field_type}</a></td>
            </tr>
        </tbody>
    </table>

    <!-- Форма добавления типа поля -->
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
                <label>{PHP.L.userfields_order}</label>
                <input type="number" name="order_num" value="{FIELD_TYPE_FORM_ORDER}" class="form-control" />
            </div>
            <button type="submit" class="btn btn-success">{PHP.L.userfields_save}</button>
            <a href="{FIELD_TYPE_CANCEL_URL}" class="btn btn-secondary">{PHP.L.userfields_cancel}</a>
        </form>
    </div>
    <!-- END: FIELD_TYPE_ADD_FORM -->

    <!-- Форма редактирования типа поля -->
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