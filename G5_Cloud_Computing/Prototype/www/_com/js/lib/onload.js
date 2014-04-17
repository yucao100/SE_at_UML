 // toolbar-menu
    var tabTemplate = "<li><a id='#{linkId}' href='#{href}'><span style='float: left; margin: 0em; min-width: 25px;'>#{label}</span><span class='ui-icon ui-icon-close' style='float: left; margin: 0em;' role='presentation'>Remove Tab</span></a></li>",
		tabCounter = 2;
	var api = '../_api/index.php' ;
    var tabs ;	
    
    //menubar switch
	function toolbar_menu_item( item ) {
		switch( item ) { 
			case '0' :
				addTab();
			break ;
			
			default :
			break ;
			
			
		}
		
		
		
		////$("#toolbar-menu-ul li").css( 'display' , 'block') ;
		//$('#toolbar-menu-ul li a span').trigger('mouseleave');
		//$('#toolbar-menu-ul li').css( 'background' , 'red' ) ;
		//$('.footer').trigger('mouseenter');
		//$("#toolbar-menu-ul").children().toggleClass("hovered");
		

	}
	
	
	//tab functions
	function addTab() {
		var msg = '' ,
			label = tabCounter,
			id = "tabs-" + tabCounter,
			li = $( tabTemplate.replace( /#\{linkId\}/g, "link-" + id ).replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) );
        
        $.ajax({
			type: "POST",
			url: api , 
			data: { ACTION : 'PROFILE' } ,
			cache: false 
		})
		.done( function( tmp ) {
			tabs.find( ".ui-tabs-nav" ).append( li );
			tabs.append( "<div id='" + id + "'>" + tmp + "</div>" );
			tabs.tabs( "refresh" );
			$("#link-" + id).trigger('click');
			tabCounter++;
		}) ;
    }

//onload function
$(function() {
    
    //enable buttons 
    $( "input[type=submit], a.button, button" ) 
		.button()
			.click(function( event ) {
				event.preventDefault();
			});
    
    // enable tabs
    tabs = $( "#tabs" ).tabs();	
    
    // close icon: removing the tab on click
    tabs.delegate( "span.ui-icon-close", "click", function() {
		var panelId = $( this ).closest( "li" ).remove().attr( "aria-controls" );
		
		$( "#" + panelId ).remove();
		
		tabs.tabs( "refresh" );
    });
    
});

