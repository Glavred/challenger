<?php $id = uniqid('ae_dictation') ?>

<div id="<?= $id ?>" class="select-one answer-editor-extension">
    <div class="content"></div>
    <div class="template content-template">
    </div>
</div>

<script>
    $(function () {
        $('#<?= $id ?>').answerEditorDictation();
    });
</script>
