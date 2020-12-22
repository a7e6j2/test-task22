<?php

namespace api\modules\v1\controllers;

use yii;
use yii\web;
use api\modules\v1\Controller;
use api\modules\v1\models\ServiceSearch;
use api\modules\v1\models\Service;
use api\modules\v1\helpers\JSecure;


/**
 * @OA\Info(
 *   version="1.0",
 *   title="Test Task API V1.0",
 *   description="Tavex full stack developer test task",
 *   @OA\Contact(
 *     name="Joey Wong",
 *     email="jokogane@yahoo.com",
 *   ),
 * ),
 * @OA\Server(
 *   url="http://api-test.joey.im/v1",
 *   description="test server",
 * )
 */
class ServiceController extends Controller
{

    public $modelClass = 'api\modules\v1\models';

    /**
     * @OA\Get(path="/service",
     *   summary="Get all services with filterable,sortable and pagination functions",
     *   tags={"service"},
     *   @OA\Parameter(
     *     name="keyword",
     *     in="query",
     *     required=false,
     *     description="The term for searching the combination of the service name,owner,description and creator name, if you want to only filter the reccords in a specified field, you only need to use ?fieldName=value, eg: ?owner=joey",
     *     @OA\Schema(
     *       type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="page",
     *     in="query",
     *     required=false,
     *     description="Go to page",
     *     @OA\Schema(
     *       type="string",
     *		 default=1,
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="sort",
     *     in="query",
     *     required=false,
     *     description="Sortable setting, eg: ?sort=-serviceName is sorted by serviceName in DESC, and ?sort=+id is sorted by id in ASC",
     *     @OA\Schema(
     *       type="string",
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="field",
     *     in="query",
     *     required=false,
     *     description="Only shows the fields what you need, eg: ?field=serviceName,status",
     *     @OA\Schema(
     *       type="string",
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="pageSize",
     *     in="query",
     *     required=false,
     *     description="Re-define the page size",
     *     @OA\Schema(
     *       type="integer",
     *       default=100,
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns the services",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ServiceSearch"),
     *     ),
     *   ),
     * )
     */

    /**
     * List all services with filterable,sortable and pagination.
     * 
     * @param array $_POST Service data (Reference to OpenAPI)
     * @return mixed $service Response
     */
    public function actionIndex()
    {

        $searchModel = new ServiceSearch();
        $securedParams = JSecure::preProcess(\Yii::$app->request->queryParams, true);

        //Overwrite the query parameters with pre-proceessed 
        \Yii::$app->request->queryParams = $securedParams;

        $dataProvider = $searchModel->search($securedParams);



        return $this->message($dataProvider);
    }

    /**
     * @OA\Post(
     *     path="/service/create",
     *     summary="Create a service",
     *	   tags={"service"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="serviceName",
     *                     type="string",
     *					   description="Service name",
     *					  
     *                 ),
     *                 @OA\Property(
     *                     property="owner",
     *                     type="string",
     *					   description="Owner",
     *					  
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *					   description="Service description",
     *					  
     *                 ),
     *                 example={"serviceName": "daily_cron_01", "owner": "Joey Wong","description":"this is a cron service"}
     *             )
     *         )
     *     ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns the services",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Service"),
     *     )
     *   ),
     *   @OA\Response(response=409, description="if service exists or missed required data"),
     * )
     */



    /**
     * Create a service 
     * 
     * @param array $_POST Service data (Reference to OpenAPI)
     * @return mixed $service Response
     * @throws 409 if the validation will not passed.
     */
    public function actionCreate()
    {
        $service = new Service();
        $service->setScenario(Service::SCENARIO_CREATE);

        //Convert the parameters' key names from camelcase to underscored_word which matched the database field names.
        $securedParams = JSecure::preProcess(\Yii::$app->getRequest()->getBodyParams());

        $service->load($securedParams, '');

        //Randomized the creator id for service (because I did not create the admin system)
        $service->created_by = rand(1, 10);

        //if service exists or missed required data
        if (!$service->save()) {

            \Yii::$app->response->statusCode = 409;
            return $this->message($service);
        }


        return $this->message($service);
    }



    /**
     * @OA\Post(path="/service/update/{id}",
     *   summary="Update a service, replace the {id} with your service id",
     *   tags={"service"},
     *   @OA\Parameter(name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="serviceName",
     *                     type="string",
     *					   description="Service name",
     *					  
     *                 ),
     *                 @OA\Property(
     *                     property="owner",
     *                     type="string",
     *					   description="Owner",
     *					  
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *					   description="Service description",
     *					  
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="integer",
     *					   description="status",
     *					  
     *                 ),
     *                 example={"serviceName": "edited_daily_cron_01", "owner": "Joey Wong","description":"this is a cron service","status":0}
     *             )
     *         )
     *     ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns the services",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Service"),
     *     ),
     *   ),
     *   @OA\Response(response=409, description="if service name duplicated or missed required data"),
     *   @OA\Response(response=404, description="if service not exists"),
     * )
     * )
     */

    /**
     * Updates an existing Services model.
     * 
     * @param string $id
     * @return mixed
     * @throws 404 if the model cannot be found
     * @throws 409 if the service name exists
     */
    public function actionUpdate($id)
    {
        $service = $this->findModel($id);


        //Convert the parameters' key names from camelcase to underscored_word which matched the database field names.
        $securedParams = JSecure::preProcess(\Yii::$app->getRequest()->getBodyParams());

        $service->setScenario(Service::SCENARIO_UPDATE);

        if ($service->load($securedParams, '') && $service->save()) {

            return $this->message($service);
        }
        \Yii::$app->response->statusCode = 409;
        return $this->message($service);
    }

    /**
     * @OA\Get(path="/service/{id}",
     *   summary="View a service, replace the {id} with your service id",
     *   tags={"service"},
     *   @OA\Parameter(name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns the services",
     *     @OA\JsonContent(ref="#/components/schemas/Service"),
     *   ),
     *   @OA\Response(response=404, description="if service not exists"),
     * )
     */


    /**
     * Get specified service 
     * 
     * @param string $id Service id
     * @return mixed $service Response
     * @throws 404 if the record has not been found
     */
    public function actionView($id)
    {

        $service = $this->findModel($id);
        if ($service === null) {

            \Yii::$app->response->statusCode = 404;
            return $this->message($service);
        }


        return $this->message($service);
    }

    /**
     * Find the model by primary key
     * 
     * @param string $id
     * @return mixed $service  Service record set
     * @throws NotFoundHttpException if the record has not been found
     */
    protected function findModel($id)
    {

        if (($service = Service::findOne($id)) !== null) {

            return $service;
        }

        throw new yii\web\NotFoundHttpException('The requested record does not exist.');
    }

    /**
     * Error handler
     *
     * @return Error Yii::$app->getErrorHandler()->exception  Exception
     */
    public function actionError()
    {
        return \Yii::$app->getErrorHandler()->exception;
    }
}
