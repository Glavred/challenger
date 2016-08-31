<?php $id = uniqid('ae_select_one') ?>

<div id="<?= $id ?>" class="select-one answer-editor-extension">
    <div class="content"></div>
    <div class="template content-template">
        <div class="items"></div>
    </div>
    <div class="template item-template item row">
        <div class="col-xs-2 col-md-1"><input type="radio" name="<?= $id ?>" class="pull-right"></div>
        <div class="col-xs-10 col-md-11"><span class="text"></span></div>
    </div>
</div>

<script>
    $(function () {
        $('#<?= $id ?>').answerEditorSelectOne();
    });
</script>
