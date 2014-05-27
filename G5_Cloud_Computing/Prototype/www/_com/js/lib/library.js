/**
 *  @File			library.js
 * 	@Authors		Jose Flores
 * 					jose.flores.152@gmail.com
 * 	
 * 	@Description	This is JavaScript/ jQuery custom library, it contains 
 * 					the function for this application
 * 
 * 	@changelog		
 * 	4/20/14			Wrote library.js, API class, converted addTab to use 
 * 					API
 */
 
/**
 * 	Api
 * 
 * 	This class holds the API
 */
function Api( apiPath ) {
	// 	Variables
	var path = apiPath ;
	var lastCall =  null ;
	var lastResponse = null ;	
	// 	FUNCTIONS
	/**
	 * 
	 * 	call
	 * 
	 * 	This function generates a JSON API string and submits it to the 
	 * 	API
	 */
	this.call = function ( order , call , argv ) {
		//	VARIABLES
		var request ;	// Will hold the JSON string request
		
		//	Generate andd store call
		lastCall = [{"order":order,"call":call,"parameter":argv}] ;

		// 	Send API request
		$.ajax({
			type: "POST",
			url: path , 				// 	Target API
			dataType : 'json',
			data: { JSON : lastCall } ,			//	The API string
			async: false ,				// 	Wait for a response
			cache: false 				//	Do not store results
		})
		//	Upon completion of the request
		.done( function( tmp ) {		
			// 	Store results
			lastResponse = tmp ;	
		}) ;

		if ( this.state() == STATE.OK ) 
			return true ;
		else
			return false ;			
	} ;
	
	/**
	 * 	state
	 * 
	 * 	This function determines wether the last API call was succesful
	 * 	or not
	 * 
	 * 	@return		NONE			The API has not been called yer
	 * 	@return 	OK				The return code was that of success
	 * 	@return 	ERROR			The return code signifies an error	
	 */
	this.state = function () {
		var json ;
		// 	Check if the API is still in the initial state
		if ( lastResponse == null )
			return STATE.NONE ;
		
		//	store the obj in a tmp object
		json = lastResponse ;
		
		// 	Check if the api had returned success
		if ( json[0][ 'code' ][0] >= 200 &&
			 json[0][ 'code' ][0] < 300 )
				// reurn succes
				return STATE.OK ;
		
		// 	Notify of Error
		return STATE.ERROR ;
	} ;
	
	/**
	 * 	data
	 * 
	 * 	This function gets the returned data
	 * 
	 * 	@return true, size, data	There are [size] elements of data 
	 * 								returned
	 * 	@return false, null, null	There was no data returned
	 */
	this.data = function (){
		
		// 	Set default return 
		var arr = [ false , 
					null ,
					null ] ;

		//	store the obj in a tmp object
		json = lastResponse ;
		
		//	Check to make sure there is a returned value
		if ( lastResponse[0]['code'][0] == 200 ) {
			
			// 	The success indicator
			arr[ 0 ] = true ;
			
			// 	Getting the number of values, due to a string being an 
			// 	array  .lenght can not simply be used. rather the implicit 
			//	array check must be used. followed by a manual setting of 
			//	1 to indicate an array of 1 string
			if ( json[0]['values']  instanceof Array ) {
				arr[ 1 ] = json[0]['values'].length ;
			}
			else {
				arr[ 1 ] = 1 ;
			}
			
			//	Storing the data
			arr[ 2 ] = json[0]['values'] ;
		}
		
		return arr ;
	} ;
}

/**
 * 	toolbar_menu_item
 * 
 * 	This is the toolbar menu function switch, it handles the operations
 * 	in the toolbar-menu PHP widget.
 * 
 * 	@param 	0			Add a tab to the profile
 * 	@param 	*			Do nothing
 */
function toolbar_menu_item( item ) {
	// Determine operation
	switch( item ) { 
		// Create a tab
		case '0' :
			addTab();
			break ;
			
		
		// Do nothing
		default : 
			break ;
	}
}

/**
 * 	addTab
 * 
 * 	This function adds a tab to the profile 
 */
function addTab() {
	
	// 	Call the profile-generator widget
	api.call( 1 , 'getWidget' , [ 'profile-generator' ] , null ) ;
	
	// 	Get the data returned
	var tmp = api.data() ;
	
	// 	Generate the tab button
	var msg = '' ,		
		label = tabCounter,
		id = "tabs-" + tabCounter,
		li = $( tabTemplate.replace( /#\{linkId\}/g, "link-" + id ).replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) );	

	// 	Attach the profile
	tabs.find( ".ui-tabs-nav" ).append( li );
	tabs.append( "<div id='" + id + "'>" + tmp[2] + "</div>" );
	tabs.tabs( "refresh" );
	
	// 	Set focus to newest tab created
	$("#link-" + id).trigger('click');
	
	// update the number of tabs created
	tabCounter++;
}
