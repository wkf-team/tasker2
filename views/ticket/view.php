<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\TicketTypeWidget;
use app\components\TicketPriorityWidget;
use app\components\TicketStatusWidget;
use app\components\TicketWorkflowWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Ticket */

$this->title =  $model->project->name.'-'.$model->id.'. '.$model->subject;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-view">

	<h1 style="display:inline;"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= TicketWorkflowWidget::widget(['model'=>$model]) ?>
    </p>
	
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">Детали</div>
                <div class="row">
                    <div class="col-lg-6">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'label'=>$model->attributeLabels()['ticket_type_id'],
                                    'format'=>'html',
                                    'value'=>function ($model) {
                                        return TicketTypeWidget::widget(['model'=>$model]).' '.$model->ticketType->name;
                                    },
                                ],
                                [
                                    'label'=>$model->attributeLabels()['priority_id'],
                                    'format'=>'html',
                                    'value'=>function ($model) {
                                        return TicketPriorityWidget::widget(['model'=>$model]).' '.$model->priority->name;
                                    },
                                ],
                                [
                                    'label'=>$model->attributeLabels()['status_id'],
                                    'format'=>'html',
                                    'value'=>function ($model) {
                                        return TicketStatusWidget::widget(['model'=>$model]);
                                    },
                                ],
                            ],
                            'options' => [
                                'class' => 'table'
                            ],
                        ]) ?>
                    </div>	
                    <div class="col-lg-6">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'parentTicket.subject:text:'.$model->attributeLabels()['parent_ticket_id'],
                                'iteration.due_date:date:'.$model->attributeLabels()['iteration_id'],
                                'initial_version',
                            ],
                            'options' => [
                                'class' => 'table'
                            ],
                        ]) ?>
                    </div>	
				</div>
			</div>
			<h2>Описание</h2>
			<p>
				<?= Html::encode($model->description)?>
			</p>
            <h2>Комментарии</h2>
            <div>
                
            </div>
		</div>
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">Участники</div>
				<?= DetailView::widget([
					'model' => $model,
					'attributes' => [
						'ownerUser.name:text:'.$model->attributeLabels()['owner_user_id'],
						'responsibleUser.name:text:'.$model->attributeLabels()['responsible_user_id'],
						'testerUser.name:text:'.$model->attributeLabels()['tester_user_id'],
						'authorUser.name:text:'.$model->attributeLabels()['author_user_id'],
					],
				]) ?>
			</div>
			<? if ($model->resolution_id) { ?>
				<div class="panel panel-default">
					<div class="panel-heading">Решение</div>
					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							'end_date:date',
							'resolution.name:text:'.$model->attributeLabels()['resolution_id'],
							'resolved_version',
						],
					]) ?>
				</div>
			<? } ?>
			<div class="panel panel-default">
				<div class="panel-heading">Даты и время</div>
				<?= DetailView::widget([
					'model' => $model,
					'attributes' => [
						'create_date:date',
						'estimate_start_date:date',
						'due_date:date',
						'story_points',
						'estimate_time',
						'worked_time',
					],
				]) ?>
			</div>
		</div>
	</div>

</div>
