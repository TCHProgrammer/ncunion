<?php
namespace common\components;
use yii\base\Component;
use Yii;
use common\models\InfoSite;

class DateComponent extends Component{

    public function init(){
        parent::init();
    }

    public function month($unix){
        $monthList = [
            'Января',
            'Февраля',
            'Марта',
            'Апреля',
            'Мая',
            'Июня',
            'Июля',
            'Августа',
            'Сентября',
            'Октября',
            'Ноября',
            'Декабря',
        ];

        $date =  date('d', $unix) . ' ' . $monthList[date('n', $unix) - 1] . date(' Y, в H:i', $unix);

        return $date;
    }
}