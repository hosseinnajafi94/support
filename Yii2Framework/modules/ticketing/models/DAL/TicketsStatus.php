<?php
namespace app\modules\ticketing\models\DAL;
use Yii;
/**
 * This is the model class for table "tickets_status".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property string $title
 *
 * @property Tickets[] $tickets
 */
class TicketsStatus extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'tickets_status';
    }
    public function rules() {
        return [
                [['title'], 'required'],
                [['title'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('ticketing', 'ID'),
            'title' => Yii::t('ticketing', 'Title'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets() {
        return $this->hasMany(Tickets::className(), ['status_id' => 'id']);
    }
}