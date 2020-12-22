<?php


namespace api\modules\v1\helpers;
use yii\helpers\Inflector;
use yii\helpers\HtmlPurifier;

/**
 * Secure Helpers
 *
 * @author Joey Wong <jokogane@yahoo.com>
 */
class JSecure
{

	/**
	 * Pre-process the input parameters 
	 * Convert all parameters' key names from camelcase to underscored 
	 * and purify the input data to prevent the XSS and SQL injection
	 *
	 * @access public
	 * @param array $params The input data
	 * @param boolean $withValue Whether process the value 
	 * @return array $ret The data after pre-processed
	 */
	public static function preProcess($params,$withValue=false) {
	
		if(is_array($params)){
			
			$ret = [];
			foreach($params as $k=>$v){
				
				$ret[Inflector::underscore($k)] = ($withValue) ? Inflector::underscore(HtmlPurifier::process($v)) : HtmlPurifier::process($v);	
				
			}
			return $ret;

		}	
		
		return [];
	}

}



