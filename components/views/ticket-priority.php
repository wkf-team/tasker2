<?php

/* @var $this yii\web\Widget */
/* @var $model app\models\Ticket */

$embedIcon = "arrow-up";
$fontColor = "black";
switch ($model->priority_id) {
	case 1:
		$embedIcon = "arrow-down";
		$fontColor = "grey";
		break;
	case 2:
		$embedIcon = "arrow-up";
		$fontColor = "black";
		break;
	case 3:
		$embedIcon = "circle-arrow-up";
		$fontColor = "orange";
		break;
	case 4:
		$embedIcon = "exclamation-sign";
		$fontColor = "red";
		break;
}
?>
<span
	class="glyphicon glyphicon-<?= $embedIcon?>"
	style="color:<?= $fontColor ?>;"
	title="<?= $model->priority->name?>"
></span>