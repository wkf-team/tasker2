<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\Widget */
/* @var $model app\models\Ticket */


/* <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> */
$actions = $model->getWorkflowActions();
foreach ($actions as $action) {
	$classes = 'btn ';
	switch ($action->step_name) {
	case 'fail': $classes .= 'btn-danger '; break;
	case 'blocked': $classes .= 'btn-danger '; break;
	case 'close': $classes .= 'btn-default '; break;
	default: $classes .= 'btn-success ';
	}
	$classes .= 'wf_action'.
				(strpos($action->input_data, 'resolution') !== false ?' wf_resolution' : '').
				(strpos($action->input_data, 'comment') !== false ?' wf_comment' : '');
	?>
	<?= Html::a($action->button_name,
		['ticket/workflow-step', 'id'=>$model->id,	'action'=>$action->step_name],
		['class'=>$classes]); ?>
<? } ?>
<div class="form" id="resolution" title="Уточните">

	<?php $form = ActiveForm::begin(['options'=>['id'=>'ticket-form']]); ?>

	<?= $form->field($model, 'resolution_id')->dropDownList($model->getResolutionDictionary(), ['class'=>'wfc_resolution']) ?>
	
	<?= $form->field($model, 'worked_time')->textInput(['class'=>'wfc_resolution']) ?>
	
	<?
	$back_resolved = $model->resolved_version;
	$model->resolved_version = $model->project->next_version;
	echo $form->field($model, 'resolved_version')->textInput(['class'=>'wfc_resolution']);
	$model->resolved_version = $back_resolved;
	?>
	
	<?
	$comment = new \app\models\Comment();
	echo $form->field($comment, 'text')->textarea(['class'=>'wfc_comment']);
	?>
	
	<?php
	/*echo $form->labelEx($model,'resolution_id', array('class'=>'wfc_resolution'));
	echo $form->dropDownList($model,'resolution_id', Html::listData(Resolution::model()->findAll(), 'id', 'name'), array('class'=>'wfc_resolution'));
	echo $form->error($model,'resolution_id');
	
	echo $form->label($model,'worked_time', array('class'=>'wfc_resolution'));
	echo $form->textField($model, 'worked_time', array('class'=>'wfc_resolution'));
	
	$back_resolved = $model->resolved_version;
	$model->resolved_version = $model->project->next_version;
	echo $form->label($model,'resolved_version', array('class'=>'wfc_resolution'));
	echo $form->textField($model, 'resolved_version', array('class'=>'wfc_resolution'));
	$model->resolved_version = $back_resolved;
	
	$comment = new Comment();
	echo $form->label($comment,'text', array('class'=>'wfc_comment'));
	echo $form->textArea($comment,'text',array('maxlength'=>1000, 'class'=>'wfc_comment'));*/
	?>

	<?php ActiveForm::end(); ?>

</div><!-- form -->
<script>
<?php $this->beginBlock("workflow"); ?>
$(function () {
	$(".wf_action").click(function (ev, ui){
		var action = $(ev.target).closest(".wf_action");
		if (action.hasClass("wf_resolution") || action.hasClass("wf_comment")) {
			if (action.hasClass("wf_resolution")) $(".wfc_resolution").show();
			else $(".wfc_resolution").hide();
			if (action.hasClass("wf_comment")) $(".wfc_comment").show();
			else $(".wfc_comment").hide();
			ev.preventDefault();
			//TODO make action
			$("#resolution").find("form").attr("action", action.attr("href"));
			$("#resolution").dialog('open');
		}
	});
	$("#resolution").dialog({
		autoOpen	: false,
		modal		: true,
		position	: { my: "left top", at: "right bottom", of: ".wf_action:last" },
		buttons		: {
			OK		: function () {
				var activeForm = $("#resolution").find("form");
				$.post(activeForm.get(0).action, activeForm.serialize(), function() {location.reload(); });
			},
			Cancel	: function () {$("#resolution").dialog("close");}
		}
	});
});
<? $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks["workflow"]);
?>