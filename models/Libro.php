<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "libro".
 *
 * @property int $id
 * @property string|null $titulo
 * @property string|null $imagen
 */
class Libro extends \yii\db\ActiveRecord
{
    public $archivo;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'imagen'], 'default', 'value' => null],
            [['titulo'], 'string', 'max' => 255],
            [['archivo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'archivo' => 'Imagen',
        ];
    }

}
