<?php
namespace app\modules\coding\models\DTL;
class TcodingDTL extends \yii\base\Component {
    /**
     * @var int Noe ID
     */
    public $idnoe = 0;
    /**
     * @var string Title ( index, create, view, update )
     */
    public $title = null;
    /**
     * @var string Title ( view, update )
     */
    public $title2 = null;
    /**
     * @var array Redirect
     */
    public $redirect = [];
    /**
     * @var array Breadcrumbs
     */
    public $breadcrumbs = [];
    /**
     * @var array Buttons
     */
    public $buttons = [];
    /**
     * @var array Columns
     */
    public $columns = [];
    /**
     * @var \app\modules\coding\models\DAL\Tcoding Tcoding Model ( view )
     */
    public $model = null;
    /**
     * @var \app\modules\coding\models\VML\TcodingVML Tcoding View Model ( create / update )
     */
    public $viewmodel = null;
    /**
     * @var \yii\data\ActiveDataProvider Data Provider
     */
    public $dataProvider = null;
    /**
     * @var \app\modules\coding\Module Module
     */
    public $module = null;
    /**
     * @var bool
     */
    public $saved = false;
    /**
     * @var mixed
     */
    public $other = null;
}