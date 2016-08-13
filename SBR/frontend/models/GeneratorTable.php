<?php

namespace frontend\models;

use Yii;
use yii\base\DynamicModel;

/**
 * ContactForm is the model behind the contact form.
 */
class GeneratorTable extends DynamicModel {

    public $subject;
    public $attributes = [];
    public $years = [];
    public $kdprop = [];
    public $kdkab = [];
    public $kdkec = [];
    public $kddesa = [];
    public $variables = [];
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
            ['years', 'each', 'rule' => 'string'],
            ['kdprop', 'each', 'rule' => ['string', 'max' => 2, 'min' => 2]],
            ['kdkab', 'each', 'rule' => ['string', 'max' => 2, 'min' => 2]],
            ['kdkec', 'each', 'rule' => ['string', 'max' => 3, 'min' => 3]],
            ['kddesa', 'each', 'rule' => ['string', 'max' => 3, 'min' => 3]],
                // [['variables'], 'string', 'required'],
        ];
    }

}
