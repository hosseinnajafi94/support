<?php
namespace app\config\components;
class Datatable {
    public $draw;
    public $columns;
    public $searchColumns;
    public $order;
    public $sort;
    public $start;
    public $length;
    public $recordsTotal;
    public $recordsFiltered;
    public function __construct($post, $config) {
        $this->draw = 1;
        $this->columns = $config['columns'];
        $this->order = $this->columns[0];
        $this->sort = SORT_DESC;
        $this->start = 0;
        $this->length = 1;
        $this->recordsTotal = 0;
        $this->recordsFiltered = 0;
        $this->searchColumns = [];
        $this->load($post);
    }
    public function load($post) {
        if (isset($post['draw']) && is_numeric($post['draw'])) {
            $this->draw = (int) $post['draw'];
        }
        if (isset($post['order']) && isset($post['order'][0])) {
            if (isset($post['order'][0]['column']) && isset($this->columns[$post['order'][0]['column']])) {
                $this->order = $this->columns[$post['order'][0]['column']];
            }
            if (isset($post['order'][0]['dir'])) {
                if ($post['order'][0]['dir'] === 'asc') {
                    $this->sort = SORT_ASC;
                }
                else if ($post['order'][0]['dir'] === 'desc') {
                    $this->sort = SORT_DESC;
                }
            }
        }
        if (isset($post['start']) && is_numeric($post['start'])) {
            $this->start = $post['start'];
        }
        if (isset($post['length']) && is_numeric($post['length'])) {
            $this->length = $post['length'];
        }
        if (isset($post['columns']) && is_array($post['columns'])) {
            foreach ($post['columns'] as $index => $column) {
                if (isset($column['search']) && isset($column['search']['value'])) {
                    $this->searchColumns[] = $column['search']['value'];
                }
            }
        }
    }
    public function run($query) {
        $this->recordsTotal = (int) $query->count();
        $query->offset($this->start);
        $query->limit($this->length);
        foreach ($this->columns as $index => $column) {
            if (isset($this->searchColumns[$index])) {
                $query->andFilterWhere(['like', $column, $this->searchColumns[$index]]);
//                if (strpos($column, 'id') !== false) {
//                    $query->andFilterWhere([$column => $this->searchColumns[$index]]);
//                }
//                else {
//                }
            }
        }
        $this->recordsFiltered = (int) $query->count();
        $query->orderBy([$this->order => $this->sort]);
        return $query->asArray()->all();
    }
    public function toArray() {
        return [
            'draw' => $this->draw,
            'recordsTotal' => $this->recordsTotal,
            'recordsFiltered' => $this->recordsFiltered
        ];
    }
}