<?php

/** @var yii\web\View $this */

$this->title = 'Short link generator';

$form = \yii\widgets\ActiveForm::begin([
        'id' => 'form-generate-link',
        'action' => '/link/generate',
        'method' => 'post',
        'options' => [
            'class' => 'form-inline',
            'enctype' => 'multipart/form-data'
        ],
]);
?>

    <div class="d-flex">
        <input type="text" name="url" id="url" class="form-control"/>
        <button type="submit" class="btn btn-primary">OK</button>
    </div>

<?php
    \yii\widgets\ActiveForm::end();
?>

<div class="ajax-result">
    <img src="" alt="qr-code">
    <h4 class="link"></h4>
</div>
<div class="alert alert-danger"></div>
