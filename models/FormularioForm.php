<?php

namespace app\models;

use yii\base\Model;


class formularioForm extends Model{
 
    public $valora;
    public $valorb;

    public function rules(){
        return[
            [['valora','valorb'], 'required'],
            ['valora','number'],['valorb','number'],
        ];
    }

}


?>