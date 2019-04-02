<?
namespace app\components;

use yii\base\Widget;

class TicketTypeWidget extends Widget
{
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('ticket-type', ['model'=>$this->model]);
    }
}
?>