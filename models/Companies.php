<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Companies".
 *
 * @property integer $id
 * @property string $name
 * @property integer $salary
 * @property integer $parentId
 */
class Companies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Companies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salary','name'],'required'],
            [['salary', 'parentId'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }
    public function treeList (){

        $sql = "SELECT c.id, c.name, c.salary, c.parentId,
           (SELECT SUM(salary) FROM Companies WHERE parentId = c.id OR id = c.id) AS totalSum FROM Companies as c";

        $posts = Yii::$app->db->createCommand($sql)
            ->queryAll();

        if   (!is_null($posts)) {

            $cats = array();

            foreach ($posts as $cat) {
                $cats[$cat['parentId']][$cat['id']] = $cat;
            }

            return $cats;
        }
    }

    function build_tree($cats,$parent_id){
        $array = [];
        if(is_array($cats) and isset($cats[$parent_id])){
            $tree = '<ul>';
            $Allsalary = 0;
            foreach($cats[$parent_id] as $cat){
                $array [$cat['id']] = $cat['salary'];
                $Allsalary += $array[$cat['salary']];
                $tree .= '<li>'.$cat['name'].' #'.$cat['salary'].' #'.$cat['totalSum'];
                $tree .=  $this->build_tree($cats,$cat['id']);
                $tree .= '</li>';
            }
            $tree .= '</ul>';
        } else return null;
        return $tree;
    }

    public function review (){
        $data = self::find()->all();
        return $data;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'salary' => Yii::t('app', 'Salary'),
            'parentId' => Yii::t('app', 'Parent ID'),
        ];
    }
}
