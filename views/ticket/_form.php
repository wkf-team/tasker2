<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ticket-form">

	<? if ($model->errors) { ?>
	
	<div class="panel panel-danger">
		<div class="panel-heading">
			<?= \yii\helpers\Json::encode($model->errors) ?>
		</div>
	</div>
	
	<? } ?>

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'ticket_type_id')->dropDownList($model->getTicketTypeDictionary()) ?>
	
    <?= $form->field($model, 'project_id')->dropDownList($model->getProjectDictionary()) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'estimate_start_date')->textInput() ?>

    <?= $form->field($model, 'due_date')->textInput() ?>

    <?= $form->field($model, 'estimate_time')->textInput() ?>

    <?= $form->field($model, 'story_points')->textInput() ?>

    <?= $form->field($model, 'priority_id')->dropDownList($model->getPriorityDictionary()) ?>

    <?= $form->field($model, 'owner_user_id')->dropDownList($model->getUserDictionary()) ?>

    <?= $form->field($model, 'responsible_user_id')->dropDownList($model->getUserDictionary()) ?>

    <?= $form->field($model, 'tester_user_id')->dropDownList($model->getUserDictionary()) ?>

    <?= $form->field($model, 'parent_ticket_id')->dropDownList($model->getTicketDictionary(), ['prompt'=>'-']) ?>

    <?= $form->field($model, 'iteration_id')->dropDownList($model->getIterationDictionary(), ['prompt'=>'-']) ?>

    <?= $form->field($model, 'initial_version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resolved_version')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
