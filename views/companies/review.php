<?php
/**
 * Created by PhpStorm.
 * User: Ivany
 * Date: 14.05.2016
 * Time: 12:21
 * @var $array
 */

$company = new \app\models\Companies();
echo $company->build_tree($company->treeList(),0);