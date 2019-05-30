<?php
namespace app\modules;
interface SRL {
    public static function searchModel();
    public static function newViewModel();
    public static function loadItems($data);
    public static function insert($data);
    public static function findModel($id);
    public static function findViewModel($id);
    public static function update($data);
    public static function delete($id);
    public static function getModels();
    public static function getItems();
}