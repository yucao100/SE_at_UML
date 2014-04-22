/**
 *  @File			constants.js
 * 	@Authors		Jose Flores
 * 					jose.flores.152@gmail.com
 * 	
 * 	@Description	This is JavaScript/ jQuery Constants page, it contains 
 * 					the the global constants 
 * 
 * 	@changelog		
 * 	4/20/14			Wrote Constants.js
 */
	
//	ENUM
var STATE = { "NONE": 0 , 
			  "OK": 1 , 
			  "ERROR": 2 } ;

// 	PATHS
var apiPath = '/csr/_api/index.php' ;	// holds the location of the API

// 	TEMPLATES
// 	Holds the template for the tab button
var tabTemplate = "<li><a id='#{linkId}' href='#{href}'>" ;
	tabTemplate += "<span class='my-tab'>#{label}</span>" ;
	tabTemplate += "<span class='ui-icon ui-icon-close my-close-button '" ;
	tabTemplate += "role='presentation'>Remove Tab</span></a></li>" ;

//	ELEMENT HOLDERS
var tabs = null ;		// The element holding the jQuery UI tabs

//	COUNTERS
var	tabCounter = 0 ; 	// The number of tabs that have been created

//	An API Instance
var api = new Api( apiPath ) ;
	
	
    
