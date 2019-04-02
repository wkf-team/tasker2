<?php

use yii\helpers\Html;
use app\components\TicketTypeWidget;
use app\components\TicketPriorityWidget;
use app\components\TicketStatusWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Ticket */

$statusPanel = "panel-default";
?>

<div class="ticket-list-view-item">
	<div class="row">
		<div class="col-xs-6">
			<span class="<?= $statusPanel?>">
				<?= TicketTypeWidget::widget(['model'=>$model]) ?>
				<?= TicketPriorityWidget::widget(['model'=>$model]) ?>
				<span class="h3">
					<?= Html::a($model->project->name.'-'.$model->id, ['view', 'id'=>$model->id]) ?>
					<?= $model->subject ?>
				</span>
				<?= TicketStatusWidget::widget(['model'=>$model]) ?>
			</span>
			<span class="panel-info">
				<?
				//show label for each parent ticket
				$it = $model;
				$maxlen = 24;
				while ($it->parentTicket) {
                    if ($it->parentTicket->id == $it->id) {
                        echo "recoursive link!";
                        break;
                    }
					$it = $it->parentTicket;
					$itLabel = (strlen($it->subject) > $maxlen) ? substr($it->subject, 0, $maxlen).'...' : $it->subject;
					//display
					?>
					<span class="panel-heading badge"><?= $itLabel ?></span>
					<?
				}
				?>
			</span>
		</div>
		<div class="panel-info col-xs-6 text-right">
			<span class="panel-heading badge glyphicon glyphicon-user"> <?= $model->ownerUser->name ?></span>
		</div>
	</div>
	<p><i><?= strlen($model->description) > ($maxlen = 30) ? substr($model->description, 0, $maxlen)."..." : $model->description ?></i></p>

</div>
