<?
namespace app\components;

use yii\base\Widget;

class TicketPriorityWidget extends Widget
{
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('ticket-priority', ['model'=>$this->model]);
    }
}
?>