<?php
namespace app\modules\coding\models\VML;
use Yii;
use yii\base\Model;
class PaymentsVML extends Model {
    public $id;
    public $paid;
    public $id_p1;
    public $id_user1;
    public $valint1;
    public $datetime;
    public $gateway;
    public $mellat_ref_id;
    public $mellat_res_code;
    public $mellat_sale_order_id;
    public $mellat_reference_id;
    public $irankish_token;
    public $irankish_result_code;
    public $irankish_reference_id;
    public $zarinpal_authority;
    public $zarinpal_ref_id;
    public $mellat_refs = [];
    public $mellat_sale_orders = [];
    public $mellat_references = [];
    public $irankish_references = [];
    public $zarinpal_refs = [];
    private $_model;
    public function rules() {
        return [
                [['paid', 'id_p1', 'id_user1', 'valint1', 'datetime'], 'required'],
                [['paid', 'id_p1', 'id_user1', 'valint1', 'gateway'], 'integer'],
                [['datetime'], 'safe'],
                [['mellat_ref_id', 'mellat_res_code', 'mellat_sale_order_id', 'mellat_reference_id', 'irankish_token', 'irankish_result_code', 'irankish_reference_id', 'zarinpal_authority', 'zarinpal_ref_id'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'paid' => Yii::t('coding', 'Paid'),
            'id_p1' => Yii::t('coding', 'Id P1'),
            'id_user1' => Yii::t('coding', 'Id User1'),
            'valint1' => Yii::t('coding', 'Valint1'),
            'datetime' => Yii::t('coding', 'Datetime'),
            'gateway' => Yii::t('coding', 'Gateway'),
            'mellat_ref_id' => Yii::t('coding', 'Mellat Ref ID'),
            'mellat_res_code' => Yii::t('coding', 'Mellat Res Code'),
            'mellat_sale_order_id' => Yii::t('coding', 'Mellat Sale Order ID'),
            'mellat_reference_id' => Yii::t('coding', 'Mellat Reference ID'),
            'irankish_token' => Yii::t('coding', 'Irankish Token'),
            'irankish_result_code' => Yii::t('coding', 'Irankish Result Code'),
            'irankish_reference_id' => Yii::t('coding', 'Irankish Reference ID'),
            'zarinpal_authority' => Yii::t('coding', 'Zarinpal Authority'),
            'zarinpal_ref_id' => Yii::t('coding', 'Zarinpal Ref ID'),
        ];
    }
    public function setModel($model) {
        $this->_model = $model;
    }
    public function getModel() {
        return $this->_model;
    }
}