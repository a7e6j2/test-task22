<?php
	
namespace api\modules\v1\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Inflector;
use api\modules\v1\models\User;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "services".
 *
 * @property string $id
 * @property string $service_name Service Name
 * @property string $owner Owner
 * @property string $description
 * @property int $created_at Created date
 * @property int $updated_at
 * @property int $created_by
 * @property int $status
 */


/**
 *@OA\Schema(
 *  schema="RestResponse",
 *  @OA\Property(
 *     property="code",
 *     type="integer",
 *     description="Status code"
 *  ),
 *  @OA\Property(
 *     property="message",
 *     type="string",
 *     description="Message"
 *  )
 *)
 */


/**
 *@OA\Schema(
 *  schema="Service",
 *  @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="Service ID"
 *  ),
 *  @OA\Property(
 *     property="serviceName",
 *     type="string",
 *     description="Service Name"
 *  ),
 *  @OA\Property(
 *     property="owner",
 *     type="string",
 *     description="Service owner"
 *  ),
 *  @OA\Property(
 *     property="description",
 *     type="string",
 *     description="Description"
 *  ),
 *  @OA\Property(
 *     property="createdAt",
 *     type="integer",
 *     format="date-time",
 *     description="Created datetime"
 *  ),
 *  @OA\Property(
 *     property="updatedAt",
 *     type="integer",
 *     format="date-time",
 *     description="Updated datetime"
 *  ),
 *  @OA\Property(
 *     property="createdBy",
 *     type="integer",
 *	   format="string",
 *     description="Creator"
 *  ),
 *  @OA\Property(
 *     property="status",
 *     type="integer",
 * 	   format="string",
 *     description="Status"
 *  ),
 *  @OA\Property(
 *     property="creatorName",
 *     type="string",
 * 	   format="string",
 *     description="Creator name (from user table)(Virtual field)"
 *  ),
 *  @OA\Property(
 *     property="createdDatetime",
 *     type="string",
 * 	   format="string",
 *     description="Formatted created datetime(Virtual field)"
 *  ),
 *  @OA\Property(
 *     property="updatedDatetime",
 *     type="string",
 * 	   format="string",
 *     description="Formatted updated datetime(Virtual field)"
 *  ),
 *  @OA\Property(
 *     property="statusText",
 *     type="string",
 * 	   format="string",
 *     description="Status text (Virtual field)"
 *  )
 *)
 */
 
 
 /**
 *@OA\Schema(
 *  schema="Pagination",
 *  @OA\Property(
 *     property="totalCount",
 *     type="integer",
 *     description="Total records"
 *  ),
 *  @OA\Property(
 *     property="pageCount",
 *     type="integer",
 *     description="Total pages"
 *  ),
 * @OA\Property(
 *     property="currentPage",
 *     type="integer",
 *     description="Current Page"
 *  ),
 * @OA\Property(
 *     property="perPage",
 *     type="integer",
 *     description="Record count per page"
 *  )
 *)
 */


 /**
 *@OA\Schema(
 *  schema="ServiceSearch",
 *  @OA\Property(
 *     property="items",
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/Service")
 *  ),
 *  @OA\Property(
 *     property="pages",
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/Pagination")
 *  ),
 *)
 */
 
class Service extends \yii\db\ActiveRecord
{
	
	
	const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
	
	const SCENARIO_DEFAULT = 'default';
	const SCENARIO_CREATE = 'create';
	const SCENARIO_UPDATE = 'update';
	
	public $created_date; 
	public $updated_date; 
	public $creator_name;
	public $status_text;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }
    
    public function behaviors()
    {
	     return [
		     	      
	        //TimestampBehavior automatically fills the specified attributes with the current timestamp.
	        'timestamp' => [
	            'class' => 'yii\behaviors\TimestampBehavior',
	            
	        ],
	        
	        
	     ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_name', 'owner', 'description', 'created_by'], 'required', 'on' => self::SCENARIO_CREATE],
            [['service_name', 'owner', 'description','status'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['description'], 'string'],
            [['created_date', 'update_date','creator_name','status_text'], 'safe'],
            [['created_by', 'status'], 'integer'],
            [['service_name', 'owner'], 'string', 'max' => 120],
            [['service_name'], 'unique'],
            [['id'], 'unique'],
            
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_name' => 'Service Name',
            'owner' => 'Owner',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Modified At',
            'created_by' => 'Created By',
            'status' => 'Status',
        ];
    }
    

    public function scenarios()
    {
        return [
	        self::SCENARIO_DEFAULT => ['service_name', 'owner', 'description', 'created_by'],
            self::SCENARIO_CREATE => ['service_name', 'owner', 'description', 'created_by'],
            self::SCENARIO_UPDATE => ['service_name', 'owner', 'description','status']
        ];
    }
    
  
	//Formatted the output field names to camelcase
	public function fields() 
	{
	
        $formattedFields =[];
        foreach (parent::fields() as $key => $name){
            $formattedFields[Inflector::variablize($key)] = $name;
        }
      
        $formattedFields['createdDatetime'] = 'created_date';
        $formattedFields['updatedDatetime'] = 'updated_date';
		$formattedFields['creatorName'] = 'creator_name';
		$formattedFields['statusText'] = 'status_text';
        return $formattedFields;
    }
    
    
    public function beforeSave($insert) 
    {

    	//if parent beforeSave() failes dont allow saving
	    if (!parent::beforeSave($insert)) {
	
	        return false;

	    }
	    
	    if ($insert) {
		    //Set the status to ACTIVE for the new registered service
		    $this->status = SELF::STATUS_ACTIVE;
		    $this->_prepareVirtualFields();
		}
		
		return true;
	}
    
     /**
     * Afterfind event for prepare the virtual fields.
     *
     */   
    public function afterFind()
    {
		parent::afterFind();
		
		$this->_prepareVirtualFields();
		
	    
    }
    
    /**
     * Prepare some virtual fields for display.
     * 
     * @return void
     */
    public function _prepareVirtualFields(){
	    
	    $this->status_text = ($this->status == 1 ) ? "ACTIVE" : "INACTIVE";    
		$this->created_date = \Yii::t('app', Yii::$app->formatter->asDateTime($this->created_at));
		$this->updated_date = \Yii::t('app', Yii::$app->formatter->asDateTime($this->updated_at));
		$this->creator_name = (isset($this->admin->display_name))? $this->admin->display_name: '';
    }
    
     /**
     * Table relationship between to the User table
     * 
     * @return void
     */   
    public function getAdmin()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
    
    
    
    
 
    
    
}
