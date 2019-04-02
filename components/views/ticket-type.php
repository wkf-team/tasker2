<?php

/* @var $this yii\web\Widget */
/* @var $model app\models\Ticket */

$embedIcon = "flag";
$fontColor = "black";
switch ($model->ticket_type_id) {
	case 1:
		$embedIcon = "flag";
		$fontColor = "blue";
		break;
	case 2:
		$embedIcon = "book";
		$fontColor = "green";
		break;
	case 3:
		$embedIcon = "file";
		$fontColor = "black";
		break;
	case 4:
		$embedIcon = "warning-sign";
		$fontColor = "orange";
		break;
}
?>
<span
	class="glyphicon glyphicon-<?= $embedIcon?>"
	style="color:<?= $fontColor ?>;"
	title="<?= $model->ticketType->name ?>"
></span>
