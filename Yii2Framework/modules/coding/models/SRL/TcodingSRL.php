<?php
namespace app\modules\coding\models\SRL;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\config\widgets\ArrayHelper;
use app\config\components\functions;
//
use app\modules\coding\models\DAL\Tcoding;
use app\modules\coding\models\DAL\ViewListKala;
use app\modules\coding\models\DAL\ViewListSupport;
use app\modules\coding\models\DAL\ViewListTakhfifat;
use app\modules\coding\models\DAL\ViewListVahedKala;
use app\modules\coding\models\DAL\Hesabha;
use app\modules\coding\models\VML\TcodingVML;
use app\modules\coding\models\DTL\TcodingDTL;
//
use app\modules\users\models\SRL\UsersSRL;
use app\modules\site\models\SRL\SiteSettingsSRL;
use app\modules\sms\models\SRL\SmsSRL;
//
class TcodingSRL {
    /**
     * @return TcodingDTL
     */
    public static function index($idnoe, $getParams = []) {

        $module = Yii::$app->getModule('coding');
        if (!is_numeric($idnoe) || !in_array($idnoe, $module->params['TconstItems'])) {
            return functions::httpNotFound();
        }

        $output = new TcodingDTL(['idnoe' => (int) $idnoe, 'module' => $module]);

        $query = Tcoding::find()
                ->select('m1.*')
                ->from('tcoding AS m1')
                ->where(['m1.deleted' => 0, 'm1.id_noe' => $idnoe])
                ->orderBy(['m1.id' => SORT_DESC]);

        $output->buttons[] = Html::a(Yii::t('app', 'Create'), ['create', 'idnoe' => $output->idnoe], ['class' => 'btn btn-sm btn-success']);

        switch ($output->idnoe) {
            case $output->module->params['VahedKala']:
                $output->title         = Yii::t('coding', 'Vahed Kala');
                $output->breadcrumbs[] = $output->title;
                $output->columns[]     = ['attribute' => 'id', 'label' => Yii::t('coding', 'ID')];
                $output->columns[]     = ['attribute' => 'name1', 'label' => Yii::t('coding', 'Title')];
                $output->columns[]     = ['class' => 'yii\grid\ActionColumn'];
                break;
            case $output->module->params['Kala']:
                $output->title         = Yii::t('coding', 'Kala');
                $output->breadcrumbs[] = $output->title;
                $output->columns[]     = ['attribute' => 'id', 'label' => Yii::t('coding', 'ID')];
                $output->columns[]     = ['attribute' => 'name1', 'label' => Yii::t('coding', 'Title')];
                $output->columns[]     = ['attribute' => 'id_p1', 'label' => Yii::t('coding', 'Vahed Kala'), 'pattern' => '{name1}', 'url' => ['/coding/tcoding/view', 'id' => '{id}']];
                $output->columns[]     = ['attribute' => 'valint3', 'label' => Yii::t('coding', 'Sale Price'), 'format' => 'toman'];
                $output->columns[]     = ['attribute' => 'valint1', 'label' => Yii::t('coding', 'Has Tax'), 'format' => 'bool'];
                $output->columns[]     = ['attribute' => 'valint2', 'label' => Yii::t('coding', 'Value Added'), 'format' => 'bool'];
                $output->columns[]     = ['class' => 'yii\grid\ActionColumn'];
                break;
            case $output->module->params['Discount']:
                $output->title         = Yii::t('coding', 'Discounts');
                $output->breadcrumbs[] = $output->title;
                $output->columns[]     = ['attribute' => 'id', 'label' => Yii::t('coding', 'ID')];
                $output->columns[]     = ['attribute' => 'name1', 'label' => Yii::t('coding', 'Title')];
                $output->columns[]     = ['attribute' => 'date1', 'label' => Yii::t('coding', 'Start Date'), 'format' => 'jdate'];
                $output->columns[]     = ['attribute' => 'date2', 'label' => Yii::t('coding', 'End Date'), 'format' => 'jdate'];
                $output->columns[]     = ['attribute' => 'valint1', 'label' => Yii::t('coding', 'Discount Type'), 'format' => ['b', 'coding', 'Percentage', 'Price']];
                $output->columns[]     = ['class' => 'yii\grid\ActionColumn'];
                break;
            case $output->module->params['Sale']:
                $output->title         = Yii::t('coding', 'Sale');
                $output->breadcrumbs[] = $output->title;
                $output->columns[]     = ['attribute' => 'id', 'label' => Yii::t('coding', 'ID')];
                $output->columns[]     = ['attribute' => 'id_p1', 'label' => Yii::t('coding', 'Product'), 'pattern' => '{name1}', 'url' => ['/coding/tcoding/view', 'id' => '{id}']];
                $output->columns[]     = ['attribute' => 'id_user1', 'label' => Yii::t('coding', 'Customer'), 'pattern' => '{fname} {lname}', 'url' => ['/users/users/view', 'id' => '{id}']];
                $output->columns[]     = ['attribute' => 'id_user1', 'label' => Yii::t('users', 'Mobile1'), 'pattern' => '{mobile1}'];
                $output->columns[]     = ['attribute' => 'id_user2', 'label' => Yii::t('coding', 'Marketer'), 'pattern' => '{fname} {lname}', 'url' => ['/users/users/view', 'id' => '{id}']];
                $output->columns[]     = ['attribute' => 'date1', 'label' => Yii::t('coding', 'Sale Date'), 'format' => 'jdate'];
                $output->columns[]     = [
                    'label'  => Yii::t('coding', 'Support To Date'),
                    'format' => 'jdate',
                    'value'  => function ($model) {
                        $support = self::getLastSupport($model->id);
                        return $support ? $support->date2 : null;
                    }
                ];
                $output->columns[] = [
                    'label'  => Yii::t('coding', 'Account Balance'),
                    'format' => 'toman',
                    'value'  => function ($model) {
                        $row = functions::queryOne("
                            SELECT (SUM(m1.bed) - SUM(m1.bes)) AS sum
                            FROM hesabha AS m1
                            WHERE m1.id_p1 = $model->id
                            AND m1.id_user1 = $model->id_user1
                        ");
                        return $row['sum'];
                    }
                ];
                if (true) {
                    $output->columns[] = [
                        'class'    => 'app\config\widgets\ActionColumn',
                        'template' => '{support} {accountancy} {send} {view} {delete}',
                        //  {plus} {minus} {accountancy} {update}
                        'buttons'  => [
                            'support' => function ($url, $model, $id) use ($output) {
                                return Html::a('<i class="fa fa-fw fa-support"></i>', ['index', 'idnoe' => $output->module->params['Bedehkari'], 'id_p1' => $model->id], ['title' => Yii::t('coding', 'Bedehkari'), 'class' => 'view']);
                            },
                            'accountancy' => function ($url, $model, $id) use ($output) {
                                return Html::a('<i class="fa fa-fw fa-bar-chart"></i>', ['/coding/hesabha/index', 'id_p1' => $model->id, 'id_user1' => $model->id_user1], ['title' => Yii::t('coding', 'Hesabdari'), 'class' => 'view']);
                            },
                            'send'     => function ($url, $model, $id) use ($output) {
                                return Html::a('<i class="fa fa-fw fa-paper-plane"></i>', $url, ['title' => Yii::t('coding', 'Send SMS'), 'data' => ['confirm' => Yii::t('coding', 'Are you sure?'), 'method' => 'post']]);
                            }
//                            'accountancy' => function ($url, $model, $id) use ($output) {
//                                return Html::a('<i class="fa fa-fw fa-bar-chart"></i>', ['index', 'idnoe' => $output->module->params['Hesabdari'], 'id_p1' => $model->id], ['title' => Yii::t('coding', 'Hesabdari')]);
//                            },
//                            'plus'             => function ($url, $model, $id) use ($output) {
//                                return Html::a('<i class="fa fa-fw fa-plus"></i>', ['index', 'idnoe' => $output->module->params['Daryaft'], 'id_p1' => $model->id], ['title' => Yii::t('coding', 'Daryaft')]);
//                            },
//                            'minus' => function ($url, $model, $id) use ($output) {
//                                return Html::a('<i class="fa fa-fw fa-minus"></i>', ['index', 'idnoe' => $output->module->params['Pardakht'], 'id_p1' => $model->id], ['title' => Yii::t('coding', 'Pardakht')]);
//                            },
                        ],
                    ];
                }
                break;
            case $output->module->params['NoeBedehkari']:
                $output->title         = Yii::t('coding', 'NoeBedehkari');
                $output->breadcrumbs[] = $output->title;
                $output->columns[]     = ['attribute' => 'id', 'label' => Yii::t('coding', 'ID')];
                $output->columns[]     = ['attribute' => 'name1', 'label' => Yii::t('coding', 'Title')];
                $output->columns[]     = ['attribute' => 'valint1', 'label' => Yii::t('coding', 'Support'), 'format' => 'bool'];
                $output->columns[]     = ['class' => 'yii\grid\ActionColumn'];
                break;
            case $output->module->params['Bedehkari']:
                $sale = null;
                if (isset($getParams['id_p1']) && is_numeric($getParams['id_p1'])) {
                    $sale = Tcoding::findOne([
                                'deleted' => 0,
                                'id'      => $getParams['id_p1'],
                                'id_noe'  => $output->module->params['Sale']
                    ]);
                    if (!$sale) {
                        return functions::httpNotFound();
                    }
                    $query->andWhere(['id_p1' => $sale->id]);
                }
                $output->title         = Yii::t('coding', 'Bedehkari');
                $output->breadcrumbs[] = $output->title;
                $output->columns[]     = ['attribute' => 'id', 'label' => Yii::t('coding', 'ID')];
                $output->columns[]     = ['attribute' => 'p1.p1.name1', 'label' => Yii::t('coding', 'Sale')];
                $output->columns[]     = ['attribute' => 'p2.name1', 'label' => Yii::t('coding', 'Type')];
                $output->columns[]     = ['attribute' => 'date1', 'label' => Yii::t('coding', 'From Date'), 'format' => 'jdate'];
                $output->columns[]     = ['attribute' => 'date2', 'label' => Yii::t('coding', 'To Date'), 'format' => 'jdate'];
                $output->columns[]     = ['attribute' => 'date3', 'label' => Yii::t('coding', 'Created At'), 'format' => 'jdate'];
                $output->columns[]     = ['attribute' => 'valint1', 'label' => Yii::t('coding', 'Price'), 'format' => 'toman'];
                $output->columns[]     = [
                    'class'    => 'app\config\widgets\ActionColumn',
                    'template' => $sale ? '{view}' : '{send} {view} {update} {delete}',
                    'buttons'  => [
                        'send' => function ($url, $model, $id) use ($output) {
                            return Html::a('<i class="fa fa-fw fa-paper-plane"></i>', $url, ['title' => Yii::t('coding', 'Send SMS'), 'data' => ['confirm' => Yii::t('coding', 'Are you sure?'), 'method' => 'post']]);
                        }
                    ],
                ];
                break;
            case $output->module->params['NoeDaryaftPardakht']:
                $output->title         = Yii::t('coding', 'NoeDaryaftPardakht');
                $output->breadcrumbs[] = $output->title;
                $output->columns[]     = ['attribute' => 'id', 'label' => Yii::t('coding', 'ID')];
                $output->columns[]     = ['attribute' => 'name1', 'label' => Yii::t('coding', 'Title')];
                $output->columns[]     = ['class' => 'yii\grid\ActionColumn'];
                break;
        }

        $output->dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'sort'       => false,
            'pagination' => ['defaultPageSize' => 10]
        ]);
        return $output;
    }
    /**
     * @param int $id Tcoding ID
     * @return TcodingDTL
     */
    public static function findModel($id, $for = 'view') {
        $module = Yii::$app->getModule('coding');
        $model  = Tcoding::findOne(['id' => $id, 'deleted' => 0, 'id_noe' => $module->params['TconstItems']]);
        if ($model == null) {
            return functions::httpNotFound();
        }
        $output = new TcodingDTL(['idnoe' => $model->id_noe, 'module' => $module, 'model' => $model]);
        if ($for == 'view') {
            $output->buttons[] = Html::a(Yii::t('app', 'Return'), ['index', 'idnoe' => $output->idnoe], ['class' => 'btn btn-sm btn-warning btn-return']);
            $output->buttons[] = Html::a(Yii::t('app', 'Create'), ['create', 'idnoe' => $output->idnoe], ['class' => 'btn btn-sm btn-success']);
            $output->buttons[] = Html::a(Yii::t('app', 'Update'), ['update', 'id' => $output->model->id], ['class' => 'btn btn-sm btn-primary']);
            $output->buttons[] = Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $output->model->id], ['class' => 'btn btn-sm btn-danger', 'data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'method' => 'post']]);
            switch ($output->idnoe) {
                case $output->module->params['VahedKala']:
                    $output->title         = $output->model->name1;
                    $output->breadcrumbs[] = ['label' => Yii::t('coding', 'Vahed Kala'), 'url' => ['index', 'idnoe' => $output->module->params['VahedKala']]];
                    $output->breadcrumbs[] = $output->title;
                    $output->columns[]     = ['attribute' => 'name1', 'label' => Yii::t('coding', 'Title')];
                    break;
                case $output->module->params['Kala']:
                    $output->title         = $output->model->name1;
                    $output->breadcrumbs[] = ['label' => Yii::t('coding', 'Kala'), 'url' => ['index', 'idnoe' => $output->module->params['Kala']]];
                    $output->breadcrumbs[] = $output->title;
                    $output->columns[]     = ['attribute' => 'name1', 'label' => Yii::t('coding', 'Title')];
                    $output->columns[]     = ['attribute' => 'id_p1', 'label' => Yii::t('coding', 'Vahed Kala'), 'pattern' => '{name1}', 'url' => ['/coding/tcoding/view', 'id' => '{id}']];
                    $output->columns[]     = ['attribute' => 'valint3', 'label' => Yii::t('coding', 'Sale Price'), 'format' => 'toman'];
                    $output->columns[]     = ['attribute' => 'valint1', 'label' => Yii::t('coding', 'Has Tax'), 'format' => 'bool'];
                    $output->columns[]     = ['attribute' => 'valint2', 'label' => Yii::t('coding', 'Value Added'), 'format' => 'bool'];
                    break;
                case $output->module->params['Discount']:
                    $output->title         = $output->model->name1;
                    $output->breadcrumbs[] = ['label' => Yii::t('coding', 'Discounts'), 'url' => ['index', 'idnoe' => $output->module->params['Discount']]];
                    $output->breadcrumbs[] = $output->title;
                    $output->columns[]     = ['attribute' => 'name1', 'label' => Yii::t('coding', 'Title')];
                    $output->columns[]     = ['attribute' => 'date1', 'label' => Yii::t('coding', 'Start Date'), 'format' => 'jdate'];
                    $output->columns[]     = ['attribute' => 'date2', 'label' => Yii::t('coding', 'End Date'), 'format' => 'jdate'];
                    $output->columns[]     = ['attribute' => 'valint1', 'label' => Yii::t('coding', 'Discount Type'), 'format' => ['b', 'coding', 'Percentage', 'Price']];
                    $output->columns[]     = [
                        'label'  => Yii::t('coding', 'Kala'),
                        'format' => 'raw',
                        'value'  => function($model) use ($output) {
                            $models = $model->getTcodings1()->where(['deleted' => 0, 'id_noe' => $output->module->params['DiscountItem']])->orderBy(['id' => SORT_ASC])->all();
                            $data   = [];
                            foreach ($models as $row) {
                                $prefix = '<a class="view" href="' . Url::to(['/coding/tcoding/view', 'id' => $row->id_p2]) . '">' . $row->p2->name1 . '</a>: ';
                                if ($model->valint1 === 1) {
                                    $data[] = $prefix . $row->valint1 . '%';
                                }
                                else if ($model->valint1 === 2) {
                                    $data[] = $prefix . functions::toman($row->valint1);
                                }
                            }
                            return implode('<br/>', $data);
                        }
                    ];
                    break;
                case $output->module->params['Sale']:
                    $output->title         = $output->model->p1->name1;
                    $output->breadcrumbs[] = ['label' => Yii::t('coding', 'Sale'), 'url' => ['index', 'idnoe' => $output->module->params['Sale']]];
                    $output->breadcrumbs[] = $output->title;
                    $output->buttons[0]    = Html::a(Yii::t('app', 'Return'), ['index', 'idnoe' => $output->idnoe], ['class' => 'btn btn-sm btn-warning btn-return']);
                    $output->buttons[1]    = Html::a(Yii::t('app', 'Create'), ['create', 'idnoe' => $output->idnoe], ['class' => 'btn btn-sm btn-success']);
                    $output->buttons[2]    = Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $output->model->id], ['class' => 'btn btn-sm btn-danger', 'data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'method' => 'post']]);
                    $output->buttons[3]    = Html::a(Yii::t('coding', 'Send SMS'), ['send', 'id' => $output->model->id], ['class' => 'btn btn-sm btn-default', 'data' => ['confirm' => Yii::t('coding', 'Are you sure?'), 'method' => 'post']]);
                    $output->columns[]     = ['attribute' => 'created_at', 'label' => Yii::t('coding', 'Created At'), 'format' => 'jdate'];
                    $output->columns[]     = ['attribute' => 'id_p1', 'label' => Yii::t('coding', 'Product'), 'pattern' => '{name1}', 'url' => ['/coding/tcoding/view', 'id' => '{id}']];
                    $output->columns[]     = ['attribute' => 'valint4', 'label' => Yii::t('coding', 'Component amount'), 'format' => 'toman'];
                    $output->columns[]     = ['attribute' => 'valint1', 'label' => Yii::t('coding', 'Count')];
                    $output->columns[]     = ['attribute' => 'id_user1', 'label' => Yii::t('coding', 'Customer'), 'pattern' => '{fname} / {lname}', 'url' => ['/users/users/view', 'id' => '{id}']];
                    $output->columns[]     = ['attribute' => 'id_user2', 'label' => Yii::t('coding', 'Marketer'), 'pattern' => '{fname} / {lname}', 'url' => ['/users/users/view', 'id' => '{id}']];
                    $output->columns[]     = ['attribute' => 'date1', 'label' => Yii::t('coding', 'Sale Date'), 'format' => 'jdate'];
                    $output->columns[]     = ['attribute' => 'date2', 'label' => Yii::t('coding', 'Free Warranty'), 'format' => 'jdate'];
                    $output->columns[]     = ['attribute' => 'valint2', 'label' => Yii::t('coding', 'Cost Per Station'), 'format' => 'toman'];
                    $output->columns[]     = ['attribute' => 'valint3', 'label' => Yii::t('coding', 'Cost Per Hour'), 'format' => 'toman'];
                    $output->columns[]     = ['attribute' => 'name2', 'label' => Yii::t('coding', 'Settle')];
                    $output->columns[]     = ['attribute' => 'valint5', 'label' => Yii::t('coding', 'Total Price'), 'format' => 'toman'];
                    $output->columns[]     = ['attribute' => 'id_p2', 'label' => Yii::t('coding', 'Discount'), 'pattern' => '{p1.name1}', 'url' => ['/coding/tcoding/view', 'id' => '{id_p1}']];
                    $output->columns[]     = ['attribute' => 'valint6', 'label' => Yii::t('coding', 'Discount Price'), 'format' => 'toman'];
                    $output->columns[]     = ['attribute' => 'valint7', 'label' => Yii::t('coding', 'Total Price With Discount'), 'format' => 'toman'];
                    $output->columns[]     = ['attribute' => 'valint8', 'label' => Yii::t('coding', 'Tax Price'), 'format' => 'toman'];
                    $output->columns[]     = ['attribute' => 'valint9', 'label' => Yii::t('coding', 'Complications Price'), 'format' => 'toman'];
                    $output->columns[]     = ['attribute' => 'valint10', 'label' => Yii::t('coding', 'The amount payable'), 'format' => 'toman'];
                    $output->columns[]     = [
                        'label'  => Yii::t('coding', 'Support To Date'),
                        'format' => 'jdate',
                        'value'  => function ($model) {
                            $sale = self::getLastSupport($model->id);
                            return $sale ? $sale->date2 : null;
                        }
                    ];
                    $output->columns[] = [
                        'label'  => Yii::t('coding', 'Account Balance'),
                        'format' => 'toman',
                        'value'  => function ($model) {
                            $row = functions::queryOne("
                                SELECT (SUM(m1.bed) - SUM(m1.bes)) AS sum
                                FROM hesabha AS m1
                                WHERE m1.id_p1 = $model->id
                                AND m1.id_user1 = $model->id_user1
                            ");
                            return $row['sum'];
                        }
                    ];
                    break;
                case $output->module->params['NoeBedehkari']:
                    $output->title         = $output->model->name1;
                    $output->breadcrumbs[] = ['label' => Yii::t('coding', 'NoeBedehkari'), 'url' => ['index', 'idnoe' => $output->module->params['NoeBedehkari']]];
                    $output->breadcrumbs[] = $output->title;
                    $output->columns[]     = ['attribute' => 'name1', 'label' => Yii::t('coding', 'Title')];
                    $output->columns[]     = ['attribute' => 'valint1', 'label' => Yii::t('coding', 'Support'), 'format' => 'bool'];
                    break;
                case $output->module->params['Bedehkari']:
                    $output->title         = $output->model->p2->name1;
                    $output->breadcrumbs[] = ['label' => Yii::t('coding', 'Bedehkari'), 'url' => ['index', 'idnoe' => $output->module->params['Bedehkari']]];
                    $output->breadcrumbs[] = $output->title;
                    $output->buttons[]     = Html::a(Yii::t('coding', 'Send SMS'), ['send', 'id' => $output->model->id], ['class' => 'btn btn-sm btn-default', 'data' => ['confirm' => Yii::t('coding', 'Are you sure?'), 'method' => 'post']]);
                    $output->columns[]     = ['attribute' => 'p1.p1.name1', 'label' => Yii::t('coding', 'Sale')];
                    $output->columns[]     = ['attribute' => 'p2.name1', 'label' => Yii::t('coding', 'Type')];
                    $output->columns[]     = ['attribute' => 'date1', 'label' => Yii::t('coding', 'From Date'), 'format' => 'jdate'];
                    $output->columns[]     = ['attribute' => 'date2', 'label' => Yii::t('coding', 'To Date'), 'format' => 'jdate'];
                    $output->columns[]     = ['attribute' => 'date3', 'label' => Yii::t('coding', 'Created At'), 'format' => 'jdate'];
                    $output->columns[]     = ['attribute' => 'valint1', 'label' => Yii::t('coding', 'Price'), 'format' => 'toman'];
                    $output->columns[]     = ['attribute' => 'name1', 'label' => Yii::t('coding', 'Desc1')];
                    $output->columns[]     = ['attribute' => 'name2', 'label' => Yii::t('coding', 'Desc2')];
                    break;
                case $output->module->params['NoeDaryaftPardakht']:
                    $output->title         = $output->model->name1;
                    $output->breadcrumbs[] = ['label' => Yii::t('coding', 'NoeDaryaftPardakht'), 'url' => ['index', 'idnoe' => $output->module->params['NoeDaryaftPardakht']]];
                    $output->breadcrumbs[] = $output->title;
                    $output->columns[]     = ['attribute' => 'name1', 'label' => Yii::t('coding', 'Title')];
                    break;
            }
        }
        return $output;
    }
    /**
     * @return TcodingDTL
     */
    public static function newViewModel($idnoe, $getParams = [], $inModule = null, $model = null) {

        $module = $inModule ? $inModule : Yii::$app->getModule('coding');
        if (!is_numeric($idnoe) || !in_array($idnoe, $module->params['TconstItems'])) {
            return functions::httpNotFound();
        }

        $output            = new TcodingDTL(['idnoe' => (int) $idnoe, 'module' => $module, 'viewmodel' => new TcodingVML()]);
        $output->title     = Yii::t('app', $model == null ? 'Create' : 'Update');
        $output->buttons[] = Html::a(Yii::t('app', 'Return'), ['index', 'idnoe' => $output->idnoe], ['class' => 'btn btn-sm btn-warning btn-return']);

        switch ($output->idnoe) {
            case $output->module->params['VahedKala']:
                $output->breadcrumbs[] = ['label' => Yii::t('coding', 'Vahed Kala'), 'url' => ['index', 'idnoe' => $output->idnoe]];
                if ($model != null) {
                    $output->breadcrumbs[] = ['label' => $model->name1, 'url' => ['view', 'id' => $model->id]];
                }
                $output->breadcrumbs[]              = $output->title;
                $output->viewmodel->labels['name1'] = Yii::t('coding', 'Title');
                $output->viewmodel->rules[]         = [['name1'], 'required'];
                $output->viewmodel->rules[]         = [['name1'], 'string', 'max' => 255];
                break;
            case $output->module->params['Kala']:
                $output->breadcrumbs[]              = ['label' => Yii::t('coding', 'Kala'), 'url' => ['index', 'idnoe' => $output->idnoe]];
                if ($model != null) {
                    $output->breadcrumbs[] = ['label' => $model->name1, 'url' => ['view', 'id' => $model->id]];
                }
                $output->breadcrumbs[]                = $output->title;
                $output->viewmodel->labels['name1']   = Yii::t('coding', 'Title');
                $output->viewmodel->labels['id_p1']   = Yii::t('coding', 'Vahed Kala');
                $output->viewmodel->labels['valint1'] = Yii::t('coding', 'Has Tax');
                $output->viewmodel->labels['valint2'] = Yii::t('coding', 'Value Added');
                $output->viewmodel->labels['valint3'] = Yii::t('coding', 'Sale Price');
                $output->viewmodel->rules[]           = [['name1', 'id_p1', 'valint3'], 'required'];
                $output->viewmodel->rules[]           = [['name1'], 'string', 'max' => 255];
                $output->viewmodel->rules[]           = [['id_p1', 'valint3'], 'integer'];
                $output->viewmodel->rules[]           = [['valint1', 'valint2'], 'boolean'];
                $output->viewmodel->hints['valint3']  = Yii::t('app', 'Toman');
                break;
            case $output->module->params['Sale']:
                $output->breadcrumbs[]                = ['label' => Yii::t('coding', 'Sale'), 'url' => ['index', 'idnoe' => $output->idnoe]];
                if ($model != null) {
                    $output->breadcrumbs[] = ['label' => $model->p1->name1, 'url' => ['view', 'id' => $model->id]];
                }
                $output->breadcrumbs[]                 = $output->title;
                $output->viewmodel->labels['id_p1']    = Yii::t('coding', 'Product');
                $output->viewmodel->labels['id_p2']    = Yii::t('coding', 'Discount');
                $output->viewmodel->labels['id_user1'] = Yii::t('coding', 'Customer');
                $output->viewmodel->labels['id_user2'] = Yii::t('coding', 'Marketer');
                $output->viewmodel->labels['date1']    = Yii::t('coding', 'Sale Date');
                $output->viewmodel->labels['date2']    = Yii::t('coding', 'Free Warranty');
                $output->viewmodel->labels['valint1']  = Yii::t('coding', 'Count');
                $output->viewmodel->labels['valint2']  = Yii::t('coding', 'Cost Per Station');
                $output->viewmodel->labels['valint3']  = Yii::t('coding', 'Cost Per Hour');
                $output->viewmodel->labels['valint4']  = Yii::t('coding', 'Component amount');
                $output->viewmodel->labels['name1']    = Yii::t('coding', 'Settle');
                $output->viewmodel->rules[]            = [['id_p1', 'id_user1', 'id_user2', 'valint1', 'date1', 'date2', 'valint2', 'valint3', 'valint4', 'name1'], 'required'];
                $output->viewmodel->rules[]            = [['id_p1', 'id_p2', 'id_user1', 'id_user2', 'valint1', 'valint2', 'valint3', 'valint4'], 'integer'];
                $output->viewmodel->rules[]            = [['date1', 'date2'], 'safe'];
                $output->viewmodel->rules[]            = [['name1'], 'string'];
                $output->viewmodel->hints['valint2']   = Yii::t('app', 'Toman');
                $output->viewmodel->hints['valint3']   = Yii::t('app', 'Toman');
                $output->viewmodel->hints['valint4']   = Yii::t('app', 'Toman');
                $output->viewmodel->date1              = functions::getdate();
                $output->viewmodel->date2              = functions::getdate(strtotime('+1 year'));
                break;
            case $output->module->params['Discount']:
                $output->breadcrumbs[]                 = ['label' => Yii::t('coding', 'Discounts'), 'url' => ['index', 'idnoe' => $output->idnoe]];
                if ($model != null) {
                    $output->breadcrumbs[] = ['label' => $model->name1, 'url' => ['view', 'id' => $model->id]];
                }
                $output->breadcrumbs[]                = $output->title;
                $output->viewmodel->labels['name1']   = Yii::t('coding', 'Title');
                $output->viewmodel->labels['date1']   = Yii::t('coding', 'Start Date');
                $output->viewmodel->labels['date2']   = Yii::t('coding', 'End Date');
                $output->viewmodel->labels['valint1'] = Yii::t('coding', 'Discount Type');
                $output->viewmodel->rules[]           = [['name1', 'date1', 'date2', 'valint1'], 'required'];
                $output->viewmodel->rules[]           = [['name1'], 'string', 'max' => 255];
                $output->viewmodel->rules[]           = [['date1', 'date2'], 'safe'];
                $output->viewmodel->rules[]           = [['valint1'], 'integer'];
                $output->viewmodel->rules[]           = [['valint1'], 'in', 'range' => [1, 2]];
                $output->viewmodel->rules[]           = [['models'], 'checkIsArray', 'skipOnError' => false, 'skipOnEmpty' => false];
                $output->viewmodel->models            = [];
                /* @var $models Tcoding[] */
                $models                               = self::getModels($output->module->params['Kala']);
                if (!$models) {
                    $output->viewmodel->addError('models', Yii::t('coding', 'No Kala was found.'));
                }
                foreach ($models as $model) {
                    $row                    = new TcodingVML();
                    $row->id                = $model->id;
                    $row->labels['valint1'] = $model->name1;
                    $row->labels['valint2'] = Yii::t('coding', 'Value {v}', ['v' => $model->name1]);
                    $row->rules[]           = [['valint1'], 'required'];
                    $row->rules[]           = [['valint1', 'valint2'], 'integer'];
                    $row->rules[]           = [['valint1'], 'in', 'range' => [0, 1]];
                    $row->rules[]           = [['valint2'], 'required', 'when' => function ($model) {
                            return $model->valint1 == 1;
                        }, 'whenClient'            => "function (attribute, value) {
                        var id = attribute.id.replace('valint2', 'valint1');
                        return $('#' + id).prop('checked');
                    }"];
                    $output->viewmodel->models[] = $row;
                }
                break;
            case $output->module->params['NoeBedehkari']:
                $output->breadcrumbs[] = ['label' => Yii::t('coding', 'NoeBedehkari'), 'url' => ['index', 'idnoe' => $output->idnoe]];
                if ($model != null) {
                    $output->breadcrumbs[] = ['label' => $model->name1, 'url' => ['view', 'id' => $model->id]];
                }
                $output->breadcrumbs[]                = $output->title;
                $output->viewmodel->labels['name1']   = Yii::t('coding', 'Title');
                $output->viewmodel->labels['valint1'] = Yii::t('coding', 'Support');
                $output->viewmodel->rules[]           = [['name1', 'valint1'], 'required'];
                $output->viewmodel->rules[]           = [['name1'], 'string', 'max' => 255];
                $output->viewmodel->rules[]           = [['valint1'], 'boolean'];
                break;
            case $output->module->params['Bedehkari']:
                if ($model == null) {
                    if (isset($getParams['id_p1']) && is_numeric($getParams['id_p1'])) {
                        $sale = Tcoding::findOne([
                                    'id'      => $getParams['id_p1'],
                                    'deleted' => 0,
                                    'id_noe'  => $output->module->params['Sale']
                        ]);
                        if ($sale !== null) {
                            $output->viewmodel->id_p1 = $sale->id;
                        }
                    }
                }
                else {
                    $output->viewmodel->id_p1 = $model->id;
                }
                $output->breadcrumbs[] = ['label' => Yii::t('coding', 'Bedehkari'), 'url' => ['index', 'idnoe' => $output->module->params['Bedehkari']]];
                if ($model != null) {
                    $output->breadcrumbs[] = ['label' => $model->p2->name1, 'url' => ['view', 'id' => $model->id]];
                }
                $output->breadcrumbs[]                = $output->title;
                $output->viewmodel->labels['valint1'] = Yii::t('coding', 'Price');
                $output->viewmodel->labels['id_p1']   = Yii::t('coding', 'Sale');
                $output->viewmodel->labels['id_p2']   = Yii::t('coding', 'Type');
                $output->viewmodel->labels['date1']   = Yii::t('coding', 'From Date');
                $output->viewmodel->labels['date2']   = Yii::t('coding', 'To Date');
                $output->viewmodel->labels['date3']   = Yii::t('coding', 'Created At');
                $output->viewmodel->labels['name2']   = Yii::t('coding', 'Desc');
                $output->viewmodel->rules[]           = [['valint1', 'id_p1', 'id_p2', 'date1', 'date2', 'date3'], 'required'];
                $output->viewmodel->rules[]           = [['valint1', 'id_p1', 'id_p2'], 'integer'];
                $output->viewmodel->rules[]           = [['date1', 'date2', 'date3'], 'safe'];
                $output->viewmodel->rules[]           = [['name2'], 'string'];
                $output->viewmodel->hints['valint1']  = Yii::t('app', 'Toman');
//                $output->other                        = $sale;
//                if ($model == null) {
//                    /* @var $support ViewListSupport */
//                    $support                  = self::getLastSupport($sale->id);
//                    $output->viewmodel->date1 = $support->date2;
//                    $output->viewmodel->date2 = $support->date2;
//                }
                break;
            case $output->module->params['NoeDaryaftPardakht']:
                $output->breadcrumbs[] = ['label' => Yii::t('coding', 'NoeDaryaftPardakht'), 'url' => ['index', 'idnoe' => $output->idnoe]];
                if ($model != null) {
                    $output->breadcrumbs[] = ['label' => $model->name1, 'url' => ['view', 'id' => $model->id]];
                }
                $output->breadcrumbs[]              = $output->title;
                $output->viewmodel->labels['name1'] = Yii::t('coding', 'Title');
                $output->viewmodel->rules[]         = [['name1'], 'required'];
                $output->viewmodel->rules[]         = [['name1'], 'string', 'max' => 255];
                break;
        }

        return $output;
    }
    /**
     * @param int $id Tcoding ID
     * @return TcodingDTL
     */
    public static function findViewModel($id) {
        $data2               = self::findModel($id, 'update');
        $data                = self::newViewModel($data2->idnoe, [], $data2->module, $data2->model);
        $data->model         = $data2->model;
        $data->viewmodel->id = $data->model->id;
        switch ($data->idnoe) {
            case $data->module->params['VahedKala']:
                $data->viewmodel->name1   = $data->model->name1;
                break;
            case $data->module->params['Kala']:
                $data->viewmodel->name1   = $data->model->name1;
                $data->viewmodel->id_p1   = $data->model->id_p1;
                $data->viewmodel->valint3 = $data->model->valint3;
                $data->viewmodel->valint1 = $data->model->valint1 == 1 ? 1 : 0;
                $data->viewmodel->valint2 = $data->model->valint2 == 1 ? 1 : 0;
                break;
            case $data->module->params['Sale']:
                return functions::httpNotFound();
            case $data->module->params['Discount']:
                $data->viewmodel->name1   = $data->model->name1;
                $data->viewmodel->date1   = $data->model->date1;
                $data->viewmodel->date2   = $data->model->date2;
                $data->viewmodel->valint1 = $data->model->valint1;
                $models                   = $data->model->getTcodings1()->where(['deleted' => 0, 'id_noe' => $data->module->params['DiscountItem']])->orderBy(['id' => SORT_ASC])->indexBy('id_p2')->all();
                foreach ($data->viewmodel->models as $row) {
                    if (isset($models[$row->id])) {
                        $row->valint1 = 1;
                        $row->valint2 = $models[$row->id]->valint1;
                    }
                }
                break;
            case $data->module->params['NoeBedehkari']:
                $data->viewmodel->name1   = $data->model->name1;
                $data->viewmodel->valint1 = $data->model->valint1;
                break;
            case $data->module->params['Bedehkari']:
                $data->viewmodel->id_p1   = $data->model->id_p1;
                $data->viewmodel->id_p2   = $data->model->id_p2;
                $data->viewmodel->date1   = $data->model->date1;
                $data->viewmodel->date2   = $data->model->date2;
                $data->viewmodel->date3   = $data->model->date3;
                $data->viewmodel->valint1 = $data->model->valint1;
                $data->viewmodel->name2   = $data->model->name2;
                break;
            case $data->module->params['NoeDaryaftPardakht']:
                $data->viewmodel->name1   = $data->model->name1;
                break;
        }
        return $data;
    }
    /**
     * @param TcodingDTL $data Tcoding Data Type Model
     * @return bool
     */
    public static function convert($data) {
        switch ($data->idnoe) {
            case $data->module->params['VahedKala']:
                $data->model->name1   = $data->viewmodel->name1;
                break;
            case $data->module->params['Kala']:
                $data->model->name1   = $data->viewmodel->name1;
                $data->model->id_p1   = $data->viewmodel->id_p1;
                $data->model->valint3 = $data->viewmodel->valint3;
                $data->model->valint1 = $data->viewmodel->valint1 == 1 ? 1 : 0;
                $data->model->valint2 = $data->viewmodel->valint2 == 1 ? 1 : 0;
                break;
            case $data->module->params['Sale']:
                $product              = ViewListKala::find()->select(['id', 'valint1', 'valint2'])->where(['id' => $data->viewmodel->id_p1])->one();
                if ($product == null) {
                    $data->viewmodel->addError('id_p1', Yii::t('coding', 'Kala Not Found!'));
                    return false;
                }
                /* @var $settings \app\modules\site\models\DAL\SiteSettings */
                $settings              = SiteSettingsSRL::get();
                $data->model->id_p1    = $data->viewmodel->id_p1;
                $data->model->id_p2    = $data->viewmodel->id_p2 ?: null;
                $data->model->id_user1 = $data->viewmodel->id_user1;
                $data->model->id_user2 = $data->viewmodel->id_user2;
                $data->model->id_user3 = $settings->id_user1; // kode hesab forosh
                $data->model->id_user4 = $settings->id_user2; // kode hesab poshtiban
                $data->model->valint1  = $data->viewmodel->valint1;
                $data->model->valint2  = $data->viewmodel->valint2;
                $data->model->valint3  = $data->viewmodel->valint3;
                $data->model->valint4  = $data->viewmodel->valint4;
                $data->model->date1    = $data->viewmodel->date1;
                $data->model->date2    = $data->viewmodel->date2;
                $data->model->name2    = $data->viewmodel->name1;
                $data->model->valint5  = $data->model->valint4 * $data->model->valint1; // Price * Count 
                $data->model->valint6  = 0; // Discount
                if ($data->model->id_p2) {
                    $discount = ViewListTakhfifat::find()
                            ->select(['valint1', 'valint2'])
                            ->where([
                                'id'    => $data->model->id_p2, // Discount Item
                                'id_p2' => $product->id, // Kala
                            ])
                            ->andWhere("'{$data->model->date1}' BETWEEN date1 AND date2") // Date Forosh
                            ->one();
                    if ($discount == null) {
                        $data->viewmodel->addError('id_p2', Yii::t('coding', 'Discount Not Found!'));
                        return false;
                    }
                    $price = 0;
                    if ($discount->valint1 == 1) { // Percent
                        $price = $data->model->valint5 / 100 * $discount->valint2;
                    }
                    else if ($discount->valint1 == 2) { // Price
                        $price = $data->model->valint1 * $discount->valint2;
                    }
                    $data->model->valint6 = $price; // Discount
                }
                $totalPrice            = $data->model->valint5 - $data->model->valint6; // Price - Discount
                $data->model->valint7  = $totalPrice > 0 ? $totalPrice : 0;
                $data->model->valint8  = $product->valint1 == 1 ? $data->model->valint7 / 100 * $settings->tax : 0; // Tax 
                $data->model->valint9  = $product->valint2 == 1 ? $data->model->valint7 / 100 * $settings->complications : 0; // Complications
                $data->model->valint10 = $data->model->valint7 + $data->model->valint8 + $data->model->valint9; // Total Price
                $data->model->save();
                
                $data->model->name1    = str_replace([
                    '#1', '#2'
                ], [
                    ' ' . $data->model->id . ' ',
                    ' ' . functions::toman($data->model->valint10) . ' ',
                ], 'بابت خرید فاکتور شماره#1به مبلغ#2');
                break;
            case $data->module->params['Discount']:
                if (!Model::validateMultiple($data->viewmodel->models)) {
                    return false;
                }
                $data->model->name1   = $data->viewmodel->name1;
                $data->model->date1   = $data->viewmodel->date1;
                $data->model->date2   = $data->viewmodel->date2;
                $data->model->valint1 = $data->viewmodel->valint1;
                break;
            case $data->module->params['NoeBedehkari']:
                $data->model->name1   = $data->viewmodel->name1;
                $data->model->valint1 = $data->viewmodel->valint1;
                break;
            case $data->module->params['Bedehkari']:
                $sale                 = Tcoding::findOne([
                            'id'      => $data->viewmodel->id_p1,
                            'deleted' => 0,
                            'id_noe'  => $data->module->params['Sale']
                ]);
                if (!$sale) {
                    $data->viewmodel->addError('id_p1', Yii::t('coding', 'Sale Not Found!'));
                    return false;
                }
                $type = Tcoding::findOne([
                            'id'      => $data->viewmodel->id_p2,
                            'deleted' => 0,
                            'id_noe'  => $data->module->params['NoeBedehkari']
                ]);
                if (!$type) {
                    $data->viewmodel->addError('id_p2', Yii::t('coding', 'NoeBedehkari Not Found!'));
                    return false;
                }
                $data->other           = $type;
                $data->model->id_user1 = $sale->id_user1;
                $data->model->id_user2 = $sale->id_user4;
                $data->model->id_p1    = $sale->id;
                $data->model->id_p2    = $type->id;
                $data->model->date1    = $data->viewmodel->date1;
                $data->model->date2    = $data->viewmodel->date2;
                $data->model->date3    = $data->viewmodel->date3;
                $data->model->name2    = $data->viewmodel->name2;
                $data->model->valint1  = $data->viewmodel->valint1;
                $data->model->save();
                $data->model->name1    = str_replace([
                    '#0', '#1', '#2', '#3', '#4'
                ], [
                    ' "' . $type->name1 . '" ',
                    ' ' . $data->model->id . ' ',
                    ' ' . functions::toman($data->model->valint1) . ' ',
                    ' ' . functions::tojdate($data->model->date1) . ' ',
                    ' ' . functions::tojdate($data->model->date2) . ' ',
                ], 'بابت#0شماره#1به مبلغ#2از تاریخ#3تا تاریخ#4');
                break;
            case $data->module->params['NoeDaryaftPardakht']:
                $data->model->name1   = $data->viewmodel->name1;
                break;
        }
        $saved = $data->model->save();
        if ($saved) {
            $data->viewmodel->id = $data->model->id;
            return true;
        }
        $data->viewmodel->addErrors($data->model->getErrors());
        return false;
    }
    /**
     * @param TcodingDTL $data
     * @return void
     */
    public static function loadItems($data) {
        switch ($data->idnoe) {
            case $data->module->params['Kala']:
                $data->viewmodel->p1s    = self::getVahedKala();
                break;
            case $data->module->params['Sale']:
                $data->viewmodel->p1s    = self::getKala();
                $data->viewmodel->p2s    = self::getDiscounts($data->viewmodel->id_p1, $data->viewmodel->date1);
                $data->viewmodel->users1 = UsersSRL::getItems();
                $data->viewmodel->users2 = UsersSRL::getItems();
                break;
            case $data->module->params['Discount']:
                $data->viewmodel->p1s    = [1 => Yii::t('coding', 'Percentage'), 2 => Yii::t('coding', 'Price')];
                break;
            case $data->module->params['Bedehkari']:
                $models                  = self::getModels($data->module->params['Sale']);
                $data->viewmodel->p1s    = ArrayHelper::map($models, 'id', function ($model) {
                            return "# $model->id / {$model->p1->name1}";
                        });
                $data->viewmodel->p2s = self::getItems($data->module->params['NoeBedehkari']);
                break;
        }
    }
    /**
     * @param TcodingDTL $data
     * @param array $postParams
     * @return void
     */
    public static function beforeValidate($data, $postParams = []) {
        switch ($data->idnoe) {
            case $data->module->params['VahedKala']:
                break;
            case $data->module->params['Kala']:
                break;
            case $data->module->params['Sale']:
                $data->viewmodel->date1 = functions::togdate($data->viewmodel->date1);
                $data->viewmodel->date2 = functions::togdate($data->viewmodel->date2);
                break;
            case $data->module->params['Discount']:
                $data->viewmodel->date1 = functions::togdate($data->viewmodel->date1);
                $data->viewmodel->date2 = functions::togdate($data->viewmodel->date2);
                Model::loadMultiple($data->viewmodel->models, $postParams);
                break;
            case $data->module->params['Bedehkari']:
                $data->viewmodel->date1 = functions::togdate($data->viewmodel->date1);
                $data->viewmodel->date2 = functions::togdate($data->viewmodel->date2);
                $data->viewmodel->date3 = functions::togdate($data->viewmodel->date3);
                break;
        }
    }
    /**
     * @param TcodingDTL $data
     * @return void
     */
    public static function afterSave($data, $type) {
        switch ($data->idnoe) {
            case $data->module->params['Discount']:
                Tcoding::updateAll([
                    'deleted'    => 1,
                    'updated_at' => $data->model->updated_at,
                    'updated_by' => $data->model->updated_by
                        ], [
                    'id_noe'  => $data->module->params['DiscountItem'],
                    'deleted' => 0,
                    'id_p1'   => $data->model->id
                ]);
                foreach ($data->viewmodel->models as $row) {
                    if ($row->valint1 == 1) {
                        $model             = new Tcoding();
                        $model->id_noe     = $data->module->params['DiscountItem'];
                        $model->deleted    = 0;
                        $model->created_at = $model->updated_at = $data->model->updated_at;
                        $model->created_by = $model->updated_by = $data->model->updated_by;
                        $model->id_p1      = $data->model->id;
                        $model->id_p2      = $row->id;
                        $model->valint1    = $row->valint2;
                        $model->save();
                    }
                }
                break;
            case $data->module->params['Sale']:
                if ($type == 'insert') {

                    self::addHesab([
                        'id_p1'    => $data->model->id,
                        'id_user1' => $data->model->id_user1,
                        'id_user2' => $data->model->id_user3,
                        'bed'      => $data->model->valint10,
                        'datetime' => $data->model->updated_at,
                        'desc'     => 'بابت خرید فاکتور شماره#1به مبلغ#2',
                    ]);

                    self::addHesab([
                        'id_p1'    => $data->model->id,
                        'id_user1' => $data->model->id_user3,
                        'id_user2' => $data->model->id_user1,
                        'bes'      => $data->model->valint10,
                        'datetime' => $data->model->updated_at,
                        'desc'     => 'بابت خرید فاکتور شماره#1به مبلغ#2',
                    ]);

                    $support = self::addSupport($data);
                    if ($support != null) {
                        self::addHesab([
                            'id_p1'    => $data->model->id,
                            'id_p2'    => $support->id,
                            'id_user1' => $data->model->id_user1,
                            'id_user2' => $data->model->id_user4,
                            'bed'      => 0,
                            'datetime' => $support->updated_at,
                            'date1'    => $support->date1,
                            'date2'    => $support->date2,
                            'desc'     => 'بابت "' . $support->p2->name1 . '" شماره#1به مبلغ#2از تاریخ#3تا تاریخ#4',
                        ]);

                        self::addHesab([
                            'id_p1'    => $data->model->id,
                            'id_p2'    => $support->id,
                            'id_user1' => $data->model->id_user4,
                            'id_user2' => $data->model->id_user1,
                            'bes'      => 0,
                            'datetime' => $support->updated_at,
                            'date1'    => $support->date1,
                            'date2'    => $support->date2,
                            'desc'     => 'بابت "' . $support->p2->name1 . '" شماره#1به مبلغ#2از تاریخ#3تا تاریخ#4',
                        ]);
                    }

                    /* @var $settings \app\modules\site\models\DAL\SiteSettings */
                    $settings = SiteSettingsSRL::get();
                    self::sendForoshSMS($data, $settings);
                }
                break;
            case $data->module->params['Bedehkari']:
                if ($type == 'insert') {

                    self::addHesab([
                        'id_p1'    => $data->model->id_p1,
                        'id_p2'    => $data->model->id,
                        'id_user1' => $data->model->id_user1,
                        'id_user2' => $data->model->id_user2,
                        'bed'      => $data->model->valint1,
                        'datetime' => $data->model->updated_at,
                        'date1'    => $data->model->date1,
                        'date2'    => $data->model->date2,
                        'desc'     => 'بابت "' . $data->other->name1 . '" شماره#1به مبلغ#2از تاریخ#3تا تاریخ#4',
                        'desc2'    => $data->model->name2,
                    ]);

                    self::addHesab([
                        'id_p1'    => $data->model->id_p1,
                        'id_p2'    => $data->model->id,
                        'id_user1' => $data->model->id_user2,
                        'id_user2' => $data->model->id_user1,
                        'bes'      => $data->model->valint1,
                        'datetime' => $data->model->updated_at,
                        'date1'    => $data->model->date1,
                        'date2'    => $data->model->date2,
                        'desc'     => 'بابت "' . $data->other->name1 . '" شماره#1به مبلغ#2از تاریخ#3تا تاریخ#4',
                        'desc2'    => $data->model->name2,
                    ]);

                    /* @var $settings \app\modules\site\models\DAL\SiteSettings */
                    $settings = SiteSettingsSRL::get();
                    self::sendSupportSMS($data, $settings);
                }
                break;
        }
    }
    public static function addHesab($data) {
        $modelA           = new Hesabha();
        $modelA->id_p1    = $data['id_p1'];
        $modelA->id_p2    = isset($data['id_p2']) ? $data['id_p2'] : null;
        $modelA->id_user1 = $data['id_user1'];
        $modelA->id_user2 = $data['id_user2'];
        $modelA->bed      = isset($data['bed']) ? $data['bed'] : 0;
        $modelA->bes      = isset($data['bes']) ? $data['bes'] : 0;
        $modelA->mab      = $modelA->bed + $modelA->bes;
        $modelA->desc1    = str_replace(['#1', '#2', '#3', '#4'], [
            ' ' . (isset($data['id_p2']) ? $data['id_p2'] : $data['id_p1']) . ' ',
            ' ' . functions::toman($modelA->mab) . ' ',
            isset($data['date1']) ? ' ' . functions::tojdate($data['date1']) . ' ' : '---',
            isset($data['date2']) ? ' ' . functions::tojdate($data['date2']) . ' ' : '---'
                ], $data['desc']);
        $modelA->desc2    = isset($data['desc2']) ? $data['desc2'] : null;
        $modelA->datetime = $data['datetime'];
        $modelA->save();
        return $modelA;
    }
    public static function addSupport($data) {
        $type = Tcoding::findOne([
                    'deleted' => 0,
                    'valint1' => 1,
                    'id_noe'  => $data->module->params['NoeBedehkari']
        ]);
        if (!$type) {
            return null;
        }
        $modelC             = new Tcoding();
        $modelC->id_noe     = $data->module->params['Bedehkari'];
        $modelC->deleted    = 0;
        $modelC->created_at = $modelC->updated_at = $data->model->updated_at;
        $modelC->created_by = $modelC->updated_by = $data->model->updated_by;
        $modelC->id_p1      = $data->model->id;
        $modelC->id_p2      = $type->id;
        $modelC->id_user1   = $data->model->id_user1;
        $modelC->id_user2   = $data->model->id_user4;
        $modelC->date1      = $data->model->date1;
        $modelC->date2      = $data->model->date2;
        $modelC->date3      = $data->model->updated_at;
        $modelC->valint1    = 0;
        $modelC->save();
        $modelC->name1      = str_replace([
            '#0', '#1', '#2', '#3', '#4'
                ], [
            ' "' . $type->name1 . '" ',
            ' ' . $modelC->id . ' ',
            ' ' . functions::toman($modelC->valint1) . ' ',
            ' ' . functions::tojdate($modelC->date1) . ' ',
            ' ' . functions::tojdate($modelC->date2) . ' '
                ], 'بابت#0شماره#1به مبلغ#2از تاریخ#3تا تاریخ#4');
        $modelC->save();
        return $modelC;
    }
    public static function sendForoshSMS($data, $settings) {
        $customer = $data->model->user1;
        if ($settings->sms_send_sale == 1 && strlen($customer->mobile1) == 11) {
            $from    = ['[fname]', '[lname]', '[id]', '[price]'];
            $to      = [$customer->fname, $customer->lname, $data->model->id, functions::toman($data->model->valint10)];
            $message = str_replace($from, $to, $settings->sms_message_sale);
            SmsSRL::send($customer->mobile1, $message);
        }
    }
    public static function sendSupportSMS($data, $settings) {
        $customer = $data->model->p1->user1;
        if ($settings->sms_send_support == 1 && strlen($customer->mobile1) == 11) {
            $from    = ['[fname]', '[lname]', '[id]', '[price]'];
            $to      = [$customer->fname, $customer->lname, $data->model->id, functions::toman($data->model->valint1)];
            $message = str_replace($from, $to, $settings->sms_message_support);
            SmsSRL::send($customer->mobile1, $message);
        }
    }
    /**
     * @param TcodingDTL $data
     * @param array $postParams
     * @param array $getParams
     * @return bool
     */
    public static function insert($data, $postParams = []) {
        if (!$data->viewmodel->load($postParams)) {
            return false;
        }
        self::beforeValidate($data, $postParams);
        if (!$data->viewmodel->validate()) {
            return false;
        }
        $data->model             = new Tcoding();
        $data->model->id_noe     = $data->idnoe;
        $data->model->deleted    = 0;
        $data->model->created_at = $data->model->updated_at = functions::getdatetime();
        $data->model->created_by = $data->model->updated_by = Yii::$app->user->id;
        $saved                   = self::convert($data);
        if ($saved) {
            self::afterSave($data, 'insert');
            return true;
        }
        return false;
    }
    /**
     * @param TcodingDTL $data
     * @param array $postParams
     * @return bool
     */
    public static function update($data, $postParams = []) {
        if (!$data->viewmodel->load($postParams)) {
            return false;
        }
        self::beforeValidate($data, $postParams);
        if (!$data->viewmodel->validate()) {
            return false;
        }
        $data->model->updated_at = functions::getdatetime();
        $data->model->updated_by = Yii::$app->user->id;
        $saved                   = self::convert($data);
        if ($saved) {
            self::afterSave($data, 'update');
            return true;
        }
        return false;
    }
    /**
     * @param TcodingDTL $data
     * @return TcodingDTL
     */
    public static function delete($data) {
        $data->model->deleted    = 1;
        $data->model->updated_at = functions::getdatetime();
        $data->model->updated_by = Yii::$app->user->id;
        $data->saved             = $data->model->save();
        $data->redirect          = ['index', 'idnoe' => $data->idnoe];
//        switch ($data->idnoe) {
//            case $data->module->params['Bedehkari']:
//                $data->redirect['id_p1'] = $data->model->id_p1;
//                break;
//        }
        return $data;
    }
    /**
     * @param int $id Sale ID
     * @return bool
     */
    public static function resendSaleSMS($id) {
        /* @var $module \app\modules\coding\Module */
        $module = Yii::$app->getModule('coding');

        /* @var $model Tcoding */
        $model = Tcoding::findOne(['id' => $id, 'deleted' => 0, 'id_noe' => $module->params['Sale']]);
        if ($model === null) {
            return [null];
        }

        /* @var $settings \app\modules\site\models\DAL\SiteSettings */
        $settings = SiteSettingsSRL::get();

        $customer = $model->user1;
        if ($settings->sms_send_sale == 1 && strlen($customer->mobile1) == 11) {
            $from    = ['[fname]', '[lname]', '[id]', '[price]'];
            $to      = [$customer->fname, $customer->lname, $model->id, functions::toman($model->valint10)];
            $message = str_replace($from, $to, $settings->sms_message_sale);
            $sent    = SmsSRL::send($customer->mobile1, $message);
            if ($sent) {
                return [true, $model];
            }
        }
        return [false, $model];
    }
    /**
     * @param int $id Support ID
     * @return bool
     */
    public static function resendSupportSMS($id) {
        /* @var $module \app\modules\coding\Module */
        $module = Yii::$app->getModule('coding');

        /* @var $model Tcoding */
        $model = Tcoding::findOne(['id' => $id, 'deleted' => 0, 'id_noe' => $module->params['Bedehkari']]);
        if ($model === null) {
            return [null];
        }

        /* @var $settings \app\modules\site\models\DAL\SiteSettings */
        $settings = SiteSettingsSRL::get();

        $customer = $model->p1->user1;
        if ($settings->sms_send_support == 1 && strlen($customer->mobile1) == 11) {
            $from    = ['[fname]', '[lname]', '[id]', '[price]'];
            $to      = [$customer->fname, $customer->lname, $model->id, functions::toman($model->valint1)];
            $message = str_replace($from, $to, $settings->sms_message_support);
            $sent    = SmsSRL::send($customer->mobile1, $message);
            if ($sent) {
                return [true, $model];
            }
        }
        return [false, $model];
    }
    /**
     * @param int $idnoe ID Noe
     * @return Tcoding[]
     */
    public static function getModels($idnoe) {
        return Tcoding::find()
                        ->where(['deleted' => 0, 'id_noe' => $idnoe])
                        ->orderBy(['id' => SORT_ASC])
                        ->all();
    }
    /**
     * @param int $idnoe ID Noe
     * @return array Tcoding List [id, name1]
     */
    public static function getItems($idnoe) {
        $models = self::getModels($idnoe);
        return ArrayHelper::map($models, 'id', 'name1');
    }
    /**
     * @return array
     */
    public static function getVahedKala() {
        $models = ViewListVahedKala::find()->orderBy(['id' => SORT_ASC])->all();
        return ArrayHelper::map($models, 'id', 'name1');
    }
    /**
     * @return array
     */
    public static function getKala() {
        $models = ViewListKala::find()->select(['id', 'name1'])->orderBy(['id' => SORT_ASC])->all();
        return ArrayHelper::map($models, 'id', 'name1');
    }
    /**
     * @param int $kalaId
     * @param string $date
     * @return array
     */
    public static function getDiscounts($kalaId, $date) {
        if ($kalaId && $date) {
            $models = ViewListTakhfifat::find()
                    ->select(['id', 'name1', 'valint1', 'valint2'])
                    ->where(['id_p2' => $kalaId])
                    ->andWhere("'$date' BETWEEN date1 AND date2")
                    ->orderBy(['id' => SORT_ASC])
                    ->all();
            return ArrayHelper::map($models, 'id', function ($model) {
                        if ($model->valint1 == 1) {
                            return "$model->name1 / $model->valint2%";
                        }
                        else {
                            return "$model->name1 / " . functions::toman($model->valint2);
                        }
                    });
        }
        return [];
    }
    /**
     * @param int $saleId Sale ID
     * @return ViewListSupport Support View Model
     */
    public static function getLastSupport($saleId) {
        return ViewListSupport::findBySql("
            SELECT view_list_support.*
            FROM view_list_support
            INNER JOIN tcoding ON view_list_support.id_p2 = tcoding.id AND tcoding.valint1 = 1
            WHERE view_list_support.id_p1 = $saleId
            ORDER BY view_list_support.date2 DESC
            LIMIT 1
        ")->one();
    }
    /**
     * @param int $hesabId Hesab ID
     * @return Tcoding
     */
    public static function getHesab($hesabId) {
        return Tcoding::find()
                        ->where([
                            'id'      => $hesabId,
                            'deleted' => 0,
                            'id_noe'  => 9
                        ])
                        ->one();
    }
    /**
     * 
     */
    public static function getAccountBalance($id) {
        $model = Tcoding::findOne([
                    'id'      => $id,
                    'deleted' => 0,
                    'id_noe'  => 9
        ]);
        if ($model == null) {
            return [false, 0, ['id_2' => Yii::t('coding', 'Hesab Not Found!')]];
        }
        $row     = functions::queryOne("
            SELECT (
                SELECT IFNULL(SUM(m4.valint1), 0)
                FROM tcoding AS m4
                WHERE m4.deleted = 0 AND m4.id_noe = 11 AND m4.id_p2 = $model->id
            ) AS valint2, (
                SELECT IFNULL(SUM(m3.valint2), 0)
                FROM tcoding AS m3
                WHERE m3.deleted = 0 AND m3.id_noe = 10 AND m3.id_p2 = $model->id
            ) AS valint3
        ");
        $valint1 = (int) $model->valint1;
        $valint2 = (int) $row['valint2'];
        $valint3 = (int) $row['valint3'];
        return [true, (($valint1 + $valint2) - $valint3), []];
    }
    /**
     * 
     */
    public static function getProductPrice($id) {
        $model = Tcoding::findOne([
                    'id'      => $id,
                    'id_noe'  => 2,
                    'deleted' => 0
        ]);
        if ($model == null) {
            return [false, 0, ['id_p1' => 'رکوردی یافت نشد!']];
        }
        return [true, $model->valint3, []];
    }
}