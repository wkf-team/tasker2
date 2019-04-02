<?
namespace app\components;

use yii\base\Widget;

class TicketWorkflowWidget extends Widget
{
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('ticket-workflow', ['model'=>$this->model]);
    }
}
?>