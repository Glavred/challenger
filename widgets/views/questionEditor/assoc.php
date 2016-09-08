<?php $id = uniqid('qe_assoc') ?>

<div id="<?= $id ?>" class="assoc question-editor-extension">
    <div class="content"></div>
    <div class="template content-template">
        <div class="items"></div>
        <div class="row">
            <div class="col-md-12">
                <br>
                <a class="btn btn-default add">Добавить пару</a>
            </div>
        </div>
    </div>
    <div class="template item-template item row">
        <div class="col-xs-5 col-md-6"><input type="text" class="form-control"></div>
        <div class="col-xs-5 col-md-5"><input type="text" class="form-control"></div>
        <div class="col-xs-2 col-md-1"><a class="btn btn-danger btn-xs remove pull-left">Удалить</a></div>
    </div>
</div>

<script>
    $(function () {
        $('#<?= $id ?>').questionEditorAssoc();
    });
</script>
