<?
namespace app\components;

use yii\base\Widget;

class TicketStatusWidget extends Widget
{
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('ticket-status', ['model'=>$this->model]);
    }
}
?>