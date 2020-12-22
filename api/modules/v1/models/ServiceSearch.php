<?php
	
namespace api\modules\v1\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\Service;
use api\modules\v1\models\User;




class ServiceSearch extends Service
{
	
	public $keyword;

	public function rules()
    {
        return [
            [['id', 'service_name', 'owner', 'description','keyword','creatorName'], 'safe'],
            [['created_by', 'status'], 'integer'],
        ];
    }
    
    
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
	

    public function search($params)
    {
	   
        $query = Service::find()->joinWith('admin');;
		
		
		//Replace the sortable virtual fields to real fields 
		if(isset($params['sort'])){
			$params['sort'] = str_replace(['created_datetime','updated_datetime','status_text'],['created_at','updated_at','status'],$params['sort']);
		}
		
	
			
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
			'pagination' => ['pageSize' => (isset($params['page_size'])) ? intval($params['page_size']) : Yii::$app->params['pageSize']],
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

  
        $query->andFilterWhere([
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'service_name', $this->service_name])
            ->andFilterWhere(['like', 'owner', $this->owner])
            ->andFilterWhere(['like', 'description', $this->description]);
            
        if($this->keyword != ''){
			
			$query->orFilterWhere(['like', 'service_name', $this->keyword])
				  ->orFilterWhere(['like', 'owner', $this->keyword])
				  ->orFilterWhere(['like', 'description', $this->keyword])
				  ->orFilterWhere(['like', 'display_name', $this->keyword]);
		}

        return $dataProvider;
    }
    

   
	
}
   