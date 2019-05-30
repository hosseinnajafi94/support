<?php
namespace app\modules\coding\models\DAL;
use Yii;
use app\modules\users\models\DAL\Users;
/**
 * This is the model class for table "payments".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property int $paid
 * @property int $id_p1
 * @property int $id_user1
 * @property int $valint1
 * @property string $datetime
 * @property int $gateway
 * @property string $mellat_ref_id
 * @property string $mellat_res_code
 * @property string $mellat_sale_order_id
 * @property string $mellat_reference_id
 * @property string $irankish_token
 * @property string $irankish_result_code
 * @property string $irankish_reference_id
 * @property string $zarinpal_authority
 * @property string $zarinpal_ref_id
 *
 * @property Tcoding $p1
 * @property Users $user1
 */
class Payments extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'payments';
    }
    public function rules() {
        return [
                [['paid', 'id_p1', 'id_user1', 'valint1', 'datetime'], 'required'],
                [['paid', 'id_p1', 'id_user1', 'valint1', 'gateway'], 'integer'],
                [['datetime'], 'safe'],
                [['mellat_ref_id', 'mellat_res_code', 'mellat_sale_order_id', 'mellat_reference_id', 'irankish_token', 'irankish_result_code', 'irankish_reference_id', 'zarinpal_authority', 'zarinpal_ref_id'], 'string', 'max' => 255],
                [['id_p1'], 'exist', 'skipOnError' => true, 'targetClass' => Tcoding::className(), 'targetAttribute' => ['id_p1' => 'id']],
                [['id_user1'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user1' => 'id']],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('coding', 'ID'),
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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getP1() {
        return $this->hasOne(Tcoding::className(), ['id' => 'id_p1']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser1() {
        return $this->hasOne(Users::className(), ['id' => 'id_user1']);
    }
}