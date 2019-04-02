<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Ticket', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'subject',
            //'description',
            //'create_date',
            //'estimate_start_date',
            'due_date',
            // 'end_date',
            // 'estimate_time',
            // 'worked_time',
            // 'story_points',
            'priority_id',
            'status_id',
            // 'resolution_id',
            // 'ticket_type_id',
            // 'author_user_id',
            'owner_user_id',
            // 'tester_user_id',
            // 'responsible_user_id',
            // 'parent_ticket_id',
            // 'iteration_id',
            // 'project_id',
            // 'initial_version',
            // 'resolved_version',
            // 'order_num',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
