<?php 

/**
 * Service APIs Testing Class
 *
 * Run the test: ./vendor/bin/codecept run 
 * Run the test with steps: ./vendor/bin/codecept run --steps
 *
 * @author Joey Wong <jokogane@yahoo.com>
 */

class CreateServiceCest
{
   
	public $uniqueServiceName;
	public $specId;
	public $createdTime;
	
    /**
     * Test the creating service from API
     * 
     * @access public
	 * @param ApiTester $I The API tester
     * @return void
     */
    public function createService(ApiTester $I)
    {
	    
	    //Test creating a service with unique service name and keeping that to test the retrieve API
	    $this->uniqueServiceName = 'Test_Service_'.date('ymdhis');
	   	    
        $I->sendPost('/service/create', [
	          'serviceName' => $this->uniqueServiceName, 
	          'owner' => 'Joey',
	          'description' => 'This is a service which created by a test program',
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['message' => 'OK']);
        
        //Get the service id which come back from server-side
        list($id) = $I->grabDataFromResponseByJsonPath('$.data.id');
        list($createdTime) = $I->grabDataFromResponseByJsonPath('$.data.createdAt');
        $this->specId = $id;
        
    }

    /**
     * Retrieve service from API
     * 
     * @access public
	 * @param ApiTester $I The API tester
     * @return void
     */   
    public function getService(ApiTester $I){
	    
	    //Test the retrieve API to get the record correctly with the created service id.
	    $I->sendGet('/service/' . $this->specId);
	    $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	    $I->seeResponseIsJson();
	    $I->seeResponseContainsJson(['message' => 'OK']);
	    //list($serviceName) = $I->grabDataFromResponseByJsonPath('$.data.serviceName');
	    $I->seeResponseContainsJson(['data' => ['serviceName'=>$this->uniqueServiceName]]);
    }
    
 
     /**
     * List services from API
     * 
     * @access public
	 * @param ApiTester $I The API tester
     * @return void
     */          
     public function listServices(ApiTester $I){
	    
	     $I->sendGet('/service');
		 $I->seeResponseJsonMatchesJsonPath('$.data.items[*].serviceName');
		 $I->seeResponseJsonMatchesJsonPath('$.data.pages.totalCount');
		
    }   


    /**
     * Search service from API
     * 
     * @access public
	 * @param ApiTester $I The API tester
     * @return void
     */       
    public function searchServices(ApiTester $I){
	    
	     $I->sendGet('/service?keyword='.$this->uniqueServiceName);
		 $I->seeResponseJsonMatchesJsonPath('$.data.items[*].serviceName');
		 $I->seeResponseJsonMatchesJsonPath('$.data.pages.totalCount');
		 $I->seeResponseContainsJson(['data' => [
	    								'serviceName'=>$this->uniqueServiceName,
	    							 ]]);
    }   
 
     
     /**
     * Edit service from API
     * 
     * @access public
	 * @param ApiTester $I The API tester
     * @return void
     */   
    public function editService(ApiTester $I){
	    
	    //Edit the service details to new
	    $newServiceName = 'Edited_Service_'.date('ymdhis');
	    $newOwner = 'Codeception';
	    $newDescription = 'Edited by test editor';
	    
	    $I->sendPost('/service/update/' . $this->specId, [
		      'serviceName' => $newServiceName,
	          'owner' => $newOwner,
	          'description' => $newDescription,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['message' => 'OK']);
        
        //Check whether updated successfully
        $I->sendGet('/service/' . $this->specId);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	    $I->seeResponseIsJson();
	    $I->seeResponseContainsJson(['message' => 'OK']);
	    $I->seeResponseContainsJson(['data' => [
	    								'serviceName'=>$newServiceName,
	    								'owner' => $newOwner,
										'description' => $newDescription
	    							]]);
	
	    
    }


 
    
    
}
