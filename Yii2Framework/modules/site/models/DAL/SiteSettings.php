<?php
namespace app\modules\site\models\DAL;
use Yii;
use app\modules\users\models\DAL\Users;
/**
 * This is the model class for table "site_settings".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property string $logo
 * @property string $favicon
 * @property string $title
 * @property string $phone1
 * @property string $phone2
 * @property string $address
 * @property string $mobile1
 * @property string $mobile2
 * @property string $mobile3
 * @property string $subtitle1
 * @property string $subtitle2
 * @property string $version
 * @property string $enamad
 * @property string $samandehi
 * @property int $default_gateway
 * @property string $mellat_terminal
 * @property string $mellat_username
 * @property string $mellat_password
 * @property string $irankish_merchant_id
 * @property string $irankish_sha1Key
 * @property string $zarinpal_merchant_id
 * @property int $email_send_sale
 * @property int $email_send_support
 * @property string $email_message_sale
 * @property string $email_message_support
 * @property int $sms_send_sale
 * @property int $sms_send_support
 * @property string $sms_message_sale
 * @property string $sms_message_support
 * @property int $tax
 * @property int $complications
 * @property int $id_user1
 * @property int $id_user2
 * @property int $valint1 حداقل درصد پرداخت هزینه
 *
 * @property Users $user1
 * @property Users $user2
 */
class SiteSettings extends \yii\db\ActiveRecord {
    public $users = [];
    public static function tableName() {
        return 'site_settings';
    }
    public function rules() {
        return [
                [['title', 'phone1', 'phone2', 'address', 'mobile1', 'mobile2', 'mobile3', 'subtitle1', 'subtitle2', 'version', 'enamad', 'samandehi', 'default_gateway', 'mellat_terminal', 'mellat_username', 'mellat_password', 'irankish_merchant_id', 'irankish_sha1Key', 'zarinpal_merchant_id', 'email_send_sale', 'email_send_support', 'email_message_sale', 'email_message_support', 'sms_send_sale', 'sms_send_support', 'sms_message_sale', 'sms_message_support', 'tax', 'complications', 'id_user1', 'id_user2', 'valint1'], 'required'],
                [['address', 'subtitle1', 'subtitle2', 'enamad', 'samandehi', 'email_message_sale', 'email_message_support', 'sms_message_sale', 'sms_message_support'], 'string'],
                [['default_gateway', 'email_send_sale', 'email_send_support', 'sms_send_sale', 'sms_send_support', 'tax', 'complications', 'id_user1', 'id_user2', 'valint1'], 'integer'],
                [['logo', 'favicon', 'title', 'phone1', 'phone2', 'mobile1', 'mobile2', 'mobile3', 'version', 'mellat_terminal', 'mellat_username', 'mellat_password', 'irankish_merchant_id', 'irankish_sha1Key', 'zarinpal_merchant_id'], 'string', 'max' => 255],
                [['id_user1'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user1' => 'id']],
                [['id_user2'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user2' => 'id']],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('site', 'ID'),
            'logo' => Yii::t('site', 'Logo'),
            'favicon' => Yii::t('site', 'Favicon'),
            'title' => Yii::t('site', 'Title'),
            'phone1' => Yii::t('site', 'Phone1'),
            'phone2' => Yii::t('site', 'Phone2'),
            'address' => Yii::t('site', 'Address'),
            'mobile1' => Yii::t('site', 'Mobile1'),
            'mobile2' => Yii::t('site', 'Mobile2'),
            'mobile3' => Yii::t('site', 'Mobile3'),
            'subtitle1' => Yii::t('site', 'Subtitle1'),
            'subtitle2' => Yii::t('site', 'Subtitle2'),
            'version' => Yii::t('site', 'Version'),
            'enamad' => Yii::t('site', 'Enamad'),
            'samandehi' => Yii::t('site', 'Samandehi'),
            'default_gateway' => Yii::t('site', 'Default Gateway'),
            'mellat_terminal' => Yii::t('site', 'Mellat Terminal'),
            'mellat_username' => Yii::t('site', 'Mellat Username'),
            'mellat_password' => Yii::t('site', 'Mellat Password'),
            'irankish_merchant_id' => Yii::t('site', 'Irankish Merchant ID'),
            'irankish_sha1Key' => Yii::t('site', 'Irankish Sha1 Key'),
            'zarinpal_merchant_id' => Yii::t('site', 'Zarinpal Merchant ID'),
            'email_send_sale' => Yii::t('site', 'Email Send Sale'),
            'email_send_support' => Yii::t('site', 'Email Send Support'),
            'email_message_sale' => Yii::t('site', 'Email Message Sale'),
            'email_message_support' => Yii::t('site', 'Email Message Support'),
            'sms_send_sale' => Yii::t('site', 'Sms Send Sale'),
            'sms_send_support' => Yii::t('site', 'Sms Send Support'),
            'sms_message_sale' => Yii::t('site', 'Sms Message Sale'),
            'sms_message_support' => Yii::t('site', 'Sms Message Support'),
            'tax' => Yii::t('site', 'Tax'),
            'complications' => Yii::t('site', 'Complications'),
            'id_user1' => Yii::t('site', 'Id User1'),
            'id_user2' => Yii::t('site', 'Id User2'),
            'valint1' => Yii::t('site', 'Valint1'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser1() {
        return $this->hasOne(Users::className(), ['id' => 'id_user1']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser2() {
        return $this->hasOne(Users::className(), ['id' => 'id_user2']);
    }
}