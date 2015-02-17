<?php
/**
 * Simps MVC Framework (http://github.com/edwardcasbon/simps)
 *
 * @link 	http://github.com/edwardcasbon/simps
 * @author 	Edward Casbon <edward@edwardcasbon.co.uk>
 */

/**
 * Simple Exception for handling Simps application errors.
 */
class Simps_Exception extends Exception {
	
	/**
	 * Constructor.
	 *
	 * Handle the exception.
	 */
	public function __construct ($message, $statusCode, $attribs, $code = 0, Exception $previous = null) {
		$this->handleException($message, $statusCode);
		parent::__construct($message, $code, $previous);
	}
	
	/**
	 * Handle the exception.
	 *
	 * Redirect to error pages depending on the status code 
	 * of the exception.
	 *
	 * @todo Update to handle error on the page rather than redirect
	 * to the error pages.
	 */
	public function handleException ($message, $statusCode) {
		switch($statusCode) {
			case 404: 
				Simps_Controller::redirect(array("controller" => "error", "action" => "not-found"));
				break;
			case 500:
			default:
				Simps_Controller::redirect(array("controller" => "error", "action" => "error"));
				break;
		}
        
		// Set the header
		header("HTTP/1.1 " . $statusCode . " " . $this->_requestStatus($statusCode));
		
	}
	
	protected function _requestStatus ($statusCode) {
		switch($statusCode) {
			case 200: 
				return "OK";
				break;
				
			case 404: 
				return "Not Found";
				break;
				
			case 405: 
				return "Method Not Allowed";
				break;
			
			case 500:
				return "Internal Server Error";
				break;
		}
	}
}