<?php
namespace app\modules\coding\models\SRL;
use Yii;
use yii\data\ActiveDataProvider;
use app\modules\coding\models\DAL\Hesabha;
use app\modules\coding\models\DAL\Tcoding;
use app\modules\coding\models\VML\HesabhaVML;
use app\modules\users\models\SRL\UsersSRL;
use app\config\components\functions;
use app\config\widgets\ArrayHelper;
class HesabhaSRL {
    /**
     * @return ActiveDataProvider
     */
    public static function searchModel($id_p1, $id_p2, $id_user1) {
        $query        = Hesabha::find()->orderBy(['id' => $id_p1 || $id_p2 || $id_user1 ? SORT_ASC : SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'sort'       => false,
            'pagination' => $id_p1 || $id_p2 || $id_user1 ? false : ['defaultPageSize' => 10]
        ]);
        $query->andFilterWhere(['id_p1' => $id_p1]);
        $query->andFilterWhere(['id_p2' => $id_p2]);
        $query->andFilterWhere(['id_user1' => $id_user1]);
        return $dataProvider;
    }
    /**
     * @return Hesabha
     */
    public static function findModel($id) {
        return Hesabha::findOne($id);
    }
    /**
     * @return HesabhaVML Hesabha View Model
     */
    public static function newViewModel() {
        $model = new HesabhaVML();
        return $model;
    }
    /**
     * @param HesabhaVML $data Hesabha View Model
     * @return void
     */
    public static function loaditems($data) {
        $rows = Tcoding::find()->from('view_list_h2 AS m1')->where('m1.valint1 > 0')->all();
        $data->ps    = ArrayHelper::map($rows, 'id', 'name1');
        $data->ps2   = TcodingSRL::getItems(8);
        $data->users = UsersSRL::getItems();
    }
    /**
     * @param HesabhaVML $data Hesabha View Model
     * @param array $postParams Post Params
     * @return bool
     */
    public static function insert($data, $postParams = []) {
        if (!$data->load($postParams)) {
            return false;
        }
        $data->date1 = functions::togdate($data->date1);
        if (!$data->validate()) {
            return false;
        }
        $id_p1 = null;
        $id_p2 = null;
        $f     = $data->id_user1;
        $k     = $data->id_user2;
        $desc  = null;

        if ($data->id_p2) {
            $row1 = Tcoding::find()
                    ->from('view_list_h2 AS m1')
                    ->where(['m1.id' => $data->id_p2])
                    ->andWhere('m1.valint1 > 0')
                    ->one();
            $data->valint1 = functions::toman($row1->valint1);
            if (!$row1) {
                $data->addError('id_p2', Yii::t('coding', 'Sale Not Found!'));
                return false;
            }
            if ($row1->valint1 < $data->mab) {
                $data->addError('mab', Yii::t('coding', 'مبلغ نمی تواند بیشتر از {n} باشد', ['n' => functions::toman($row1->valint1)]));
                return false;
            }
            $row = Tcoding::findOne($row1->id);
            if ($row) {
                $desc = $row->name1;
                if ($row->id_noe == 5) {
                    $f     = $row->id_user3;
                    $k     = $row->id_user1;
                    $id_p1 = $row->id;
                    $id_p2 = null;
                }
                else if ($row->id_noe == 7) {
                    $sale  = $row->p1;
                    $f     = $sale->id_user4;
                    $k     = $sale->id_user1;
                    $id_p1 = $row->id_p1;
                    $id_p2 = $row->id;
                }
            }
        }

        $modelA           = new Hesabha();
        $modelA->id_p1    = $id_p1;
        $modelA->id_p2    = $id_p2;
        $modelA->id_p3    = $data->id_p3;
        $modelA->name1    = $data->name1;
        $modelA->date1    = $data->date1;
        $modelA->id_user1 = $f;
        $modelA->id_user2 = $k;
        $modelA->bed      = $data->mab;
        $modelA->bes      = 0;
        $modelA->mab      = $data->mab;
        $modelA->desc1    = $desc;
        $modelA->desc2    = $data->desc2;
        $modelA->datetime = functions::getdatetime();
        $modelA->save();

        $data->id = $modelA->id;

        $modelB           = new Hesabha();
        $modelB->id_p1    = $id_p1;
        $modelB->id_p2    = $id_p2;
        $modelB->id_p3    = $data->id_p3;
        $modelB->name1    = $data->name1;
        $modelB->date1    = $data->date1;
        $modelB->id_user1 = $k;
        $modelB->id_user2 = $f;
        $modelB->bed      = 0;
        $modelB->bes      = $data->mab;
        $modelB->mab      = $data->mab;
        $modelB->desc1    = $desc;
        $modelB->desc2    = $data->desc2;
        $modelB->datetime = $modelA->datetime;
        $modelB->save();


        if ($data->id_user1 != $f) {
            $modelC           = new Hesabha();
            $modelC->id_p1    = null;
            $modelC->id_p2    = null;
            $modelC->id_user1 = $data->id_user1;
            $modelC->id_user2 = $f;
            $modelC->bed      = $data->mab;
            $modelC->bes      = 0;
            $modelC->mab      = $data->mab;
            $modelC->desc1    = $desc;
            $modelC->desc2    = $data->desc2;
            $modelC->datetime = $modelA->datetime;
            $modelC->save();

            $modelD           = new Hesabha();
            $modelD->id_p1    = null;
            $modelD->id_p2    = null;
            $modelD->id_user1 = $f;
            $modelD->id_user2 = $data->id_user1;
            $modelD->bed      = 0;
            $modelD->bes      = $data->mab;
            $modelD->mab      = $data->mab;
            $modelD->desc1    = $desc;
            $modelD->desc2    = $data->desc2;
            $modelD->datetime = $modelA->datetime;
            $modelD->save();
        }

        if ($data->id_user2 != $k) {
            $modelE           = new Hesabha();
            $modelE->id_p1    = null;
            $modelE->id_p2    = null;
            $modelE->id_user1 = $k;
            $modelE->id_user2 = $data->id_user2;
            $modelE->bed      = $data->mab;
            $modelE->bes      = 0;
            $modelE->mab      = $data->mab;
            $modelE->desc1    = $desc;
            $modelE->desc2    = $data->desc2;
            $modelE->datetime = $modelA->datetime;
            $modelE->save();

            $modelF           = new Hesabha();
            $modelF->id_p1    = null;
            $modelF->id_p2    = null;
            $modelF->id_user1 = $data->id_user2;
            $modelF->id_user2 = $k;
            $modelF->bed      = 0;
            $modelF->bes      = $data->mab;
            $modelF->mab      = $data->mab;
            $modelF->desc1    = $desc;
            $modelF->desc2    = $data->desc2;
            $modelF->datetime = $modelA->datetime;
            $modelF->save();
        }


        return true;
    }
    /**
     * 
     */
    public static function find($id) {
        $row = Tcoding::findOne($id);
        if ($row) {
            $row1 = Tcoding::find()
            ->from('view_list_h2 AS m1')
            ->where(['m1.id' => $id])
            ->andWhere('m1.valint1 > 0')
            ->one();
            if ($row1) {
                if ($row->id_noe == 5) {
                    return [functions::toman($row1->valint1), $row->id_user3, $row->id_user1];
                }
                if ($row->id_noe == 7) {
                    $parent = $row->p1;
                    return [functions::toman($row1->valint1), $parent->id_user4, $parent->id_user1];
                }
            }
        }
        return ["", ""];
    }
}