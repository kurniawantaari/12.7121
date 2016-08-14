<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class GeneratorTable extends Model {

    public $subject;
    public $attributes = [];
    public $years = [];
    public $kdprop = [];
    public $kdkab = [];
    public $kdkec = [];
    public $kddesa = [];
    public $vvertikal;//= [];
       public $vhorizontal;//= [];
    public $location;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['subject', 'in', 'range' => ['ju', 'su', 'se']],
            ['subject', 'string', 'max' => 2, 'min' => 2],
            ['subject', 'each', 'rule' => ['default', 'value' => 'ju']],
            ['attributes', 'each', 'rule' => 'string'],
           // ['vvertikal', 'each', 'rule' => 'string'],
            //['vhorizontal', 'each', 'rule' => 'string'],
            ['years', 'each', 'rule' => 'string'],
            ['kdprop', 'each', 'rule' => ['string', 'max' => 2, 'min' => 2]],
            ['kdkab', 'each', 'rule' => ['string', 'max' => 2, 'min' => 2]],
            ['kdkec', 'each', 'rule' => ['string', 'max' => 3, 'min' => 3]],
            ['kddesa', 'each', 'rule' => ['string', 'max' => 3, 'min' => 3]],
             
        ];
    }

}
