<?php

/* @var $this yii\web\Widget */
/* @var $model app\models\Ticket */

/*
1	Открыт
2	Переоткрыт
3	Блокирован
4	В работе
5	На тестировании
6	Решен
7	Закрыт
8	Не выполнен
9	Закрыт частично
10	Выполнен
*/

$embedIcon = "flag";
$fontColor = "black";
$backColor = "black";
switch ($model->status_id) {
	case 1:
		$embedIcon = "flag";
		$fontColor = "#000";
		$backColor = "#EEE";
		break;
	case 2:
		$embedIcon = "flag";
		$fontColor = "#D00";
		$backColor = "#FDD";
		break;
	case 3:
		$embedIcon = "flag";
		$fontColor = "#D00";
		$backColor = "#FDD";
		break;
	case 4:
		$embedIcon = "flag";
		$fontColor = "#AA0";
		$backColor = "#FFD";
		break;
	case 5:
		$embedIcon = "flag";
		$fontColor = "#AA0";
		$backColor = "#FFD";
		break;
	case 6:
		$embedIcon = "flag";
		$fontColor = "#0D0";
		$backColor = "#DFD";
		break;
	case 7:
		$embedIcon = "flag";
		$fontColor = "#0D0";
		$backColor = "#DFD";
		break;
	case 8:
		$embedIcon = "flag";
		$fontColor = "#D00";
		$backColor = "#FDD";
		break;
	case 9:
		$embedIcon = "flag";
		$fontColor = "#AA0";
		$backColor = "#FFD";
		break;
	case 10:
		$embedIcon = "flag";
		$fontColor = "#0D0";
		$backColor = "#DFD";
		break;
}
?>
<span
	style="color:<?= $fontColor ?>;background-color:<?= $backColor?>;"
	class="panel-heading badge">
	<!-- <span class="glyphicon glyphicon-<?= $embedIcon?>"></span> -->
	<?= $model->status->name ?>
</span>