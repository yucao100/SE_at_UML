<?php
	/**
	 *  @File			api.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This api needs the libraryand configuration file to 
	 * 					be included before it is.
	 * 
	 * 	@changelog		
	 * 	4/19/14			__construct, getWidgetInstance, getWidget, isSuccess
	 * 					isNotAllowed, isNotFound, isBadSyntax, getMethodList
	 * 					were finalized Version 1.
	 * 	4/18/14			__construct, getWidgetInstance, getWidget, isSuccess
	 * 					isNotAllowed, isNotFound, isBadSyntax, getMethodList
	 * 					were started.
	 */

	// 	DEFINE GUARD
	if ( !defined( 'api' ) )  {
		
		define( 'api' , TRUE ) ;
		
		/**
		 * 	api
		 * 
		 * 	This is tha application API, It will be used for all 
		 * 	application communications. 	
		 */
		class api {
			
			private $A ;
			
			/**
			 * The constructor
			 * 
			 * 	The API constructor
			 * 
			 * 	@param	$A			The global configuration, needed for 
			 * 						file path information
			 */
			public function __construct( $A ) {
				$this->A = $A ;
			}
			
			private function apiLog(){}
			
			// MYSQL FUNCTIONS
			
			private function mysqlAdd() {}
					
			private function mysqlDrop() {}
			
			private function mysqlEdit() {}
			
			private function mysqlGet() {}
			
			private function mysqlAuthenticate() {}
			
			// USER FUNCTIONS
			
			private function userAdd() {}
					
			private function userDrop() {}
			
			private function userEdit() {}
			
			private function userGet() {}
			
			private function userLogin() {}
			
			private function userLogout() {}
			
			/**
			 * 	getWidgetInstance
			 * 
			 * 	this function fetches a widget instance
			 * 
			 * 	@param	$arr			The widget name and parameters
			 * 	
			 * 	@catch	$e				Catches any exception
			 * 							and then returns isNotFound
			 * 
			 * 	@return isSuccess		The widget is found and being 
			 * 							returned
			 * 	@return isNotFound		An error occured and the widget 
			 * 							could not be returned
			 */
			private function getWidgetInstance( $arr ) {
				try {
					$widget = getWGT( $this->A , $arr ) ;
				}
				catch ( Exception $e ) {
					$this->apiLog( $arr , $e ) ;
					return $this->isNotFound() ;					 
				}
				
				return $this->isSuccess( null , $widget ) ;
			}
			// GRAPHING FUNCTIONS
			
			
			////
			//	PUBLIC API METHODS
			////
			
			// API MANAGEMENT FUNTIONS
			
			/**
			 * 	isSuccess	
			 * 
			 * 	This function returns the appropriate success message as
			 * 	the response
			 * 
			 * 	@param	$message		Additionsal $messages to add to 
			 * 							the code
			 * 	@param	$value			The values to return
			 */
			public function isSuccess( $message , $value ) {
				
				//  Setting success without response
				if ( $message == null ) {
					return array( 'code' => array( 200 , 'OK' ) , 
								  'return' => $value ) ;
				}
				//  Setting success with response
				else if ( $message != null )	{
					return array( 'code' => array( 204 , 'No Content' , $message ) , 
								  'return' => $value ) ;
				}
			}
			
			/**
			 * 	isNotAllowed
			 * 
			 * 	This function returns a method not allowed message
			 * 
			 * 	@return 				405	JSON sting
			 */
			public function isNotAllowed( ) {
				 return array( 'code' => array( 405 , 'Method Not Allowed' , 'A request was made using method that is not enabled by the API Interface, call getMethodList for existing API methods.') ,
							   'return' => null ) ;
			 }
			
			/**
			 * 	isBadSyntax
			 * 
			 * 	This function returns a Bad request message
			 * 
			 * 	@return					400 JSON string
			 */
			public function isBadSyntax() {
				return array( 'code' => array( 400 , 'Bad Request' , 'The request cannot be fulfilled due to bad syntax.' ) ,
							  'return' => null ) ;
			}
			
			/**
			 * 	isNotFound
			 * 
			 * 	This function returns Not found message
			 * 
			 * 	@return					404 JSON message
			 */
			public function isNotFound() {
				return array( 'code' => array( 404 , 'Resource Not Found' ) ,
							  'return' => array( 'The requested resource could not be found but may be available again in the future.' ) ) ;
			}
			
			/**
			 * 	getMethodList
			 * 
			 * 	This function generates a list of all the available API 
			 * 	methods
			 * 
			 * 	@return 				A JSON success message with the 
			 * 							available API methods
			 */ 
			public function getMethodList() {
				//	List of public methods that are needed but are not part of API
				$blackList = array( '__construct' ) ;
				
				$result = array( ) ;
				
				// 	Get all public methods from API
				$list = getPublicMethods( $this->A , 'api' ) ;
				
				// Check to see if there are no methods, should never 
				// happen unless someone has deleted the api functions 
				// except for this one or they have added all the other 
				// functions to the black list
				if ( count( $list ) <= count( $blackList ) )
					$result[ 0 ] = null ;
				else	
					foreach ( $list as $item )
						// prevent deny values from pupulating
						if ( !in_array( $item , $blackList ) )
							array_push( $result , $item ) ;
					
				return $this->isSuccess( null , $result ) ;
			}
			
			/**
			 * 	getWidget
			 * 
			 * 	This function generates a success message with the html 
			 * 	widget
			 * 
			 * 	@param 	$parameters		The widget name and parameters 
			 * 							needed to create a widget
			 * 
			 * 	@return					a JSON message string
			 */
			public function getWidget( $parameters ) {
				// error checking parameters
				if ( is_array( $parameters ) ) {
					$arr = $parameters ;
				}
				// the arguments were not in an array
				else {
					$arr[ 0 ] = $parameters ;
					$arr[ 1 ] = null ;
				}
				switch ( trim( $arr[ 0 ] ) ) {
					// Missing WGT name
					case '' :
						return $this->isBadSyntax() ;
												
					// Returning available widgets	
					case 'getWidgetList' :
						return $this->isSuccess( null , getDirectoryList( $this->A , $this->A[ 'D_WGT' ]) ) ;
							
					// Finding Widget
					default :
						// 	Including specified widget from generated list
						$arrOfWidgets = getDirectoryList( $this->A , $this->A[ 'D_WGT' ] ) ;
						
						// parse widget list
						foreach( $arrOfWidgets as $value ) {
							// 	If the widget isfound
							if ( $value == $arr[ 0 ] ) {
								// return the widget and codes
								return $this->getWidgetInstance( $arr ) ;
							}
						}
						
						// 	Widget was not found status being returned
						return $this->isNotFound() ;
				}
			}
			
			// COMMENT FUNCTIONS
			
			//public function addcomment() {}
					
			//public function deleteComment() {}
			
			//public function updateComment() {}
			
			//public function getComment() {}
			
			
		}
	
	}
	
?>
