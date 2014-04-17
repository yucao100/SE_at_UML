$(function() {
    var tabTitle = $( "#tab_title" ),
      tabContent = $( "#tab_content" ),
      tabTemplate = "<li><a id='#{linkId}' href='#{href}'><span style='float: left; margin: 0em; min-width: 25px;'>#{label}</span><span class='ui-icon ui-icon-close' style='float: left; margin: 0em;' role='presentation'>Remove Tab</span></a></li>",
      tabCounter = 2;
 
    var tabs = $( "#tabs" ).tabs();
 
    
   
    // actual addTab function: adds new tab using the input from the form above
    function addTab() {
      var label = tabCounter,
        id = "tabs-" + tabCounter,
        li = $( tabTemplate.replace( /#\{linkId\}/g, "link-" + id ).replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) );
        
 
      tabs.find( ".ui-tabs-nav" ).append( li );
      tabs.append( "<div id='" + id + "'><p>" + tabCounter + "</p></div>" );
      tabs.tabs( "refresh" );
      $("#link-" + id).trigger('click');
      tabCounter++;
    }
 
    // addTab button
    $( "#add_tab" )
      .button()
      .click(function() {
        addTab();
        
      });
 
    // close icon: removing the tab on click
    tabs.delegate( "span.ui-icon-close", "click", function() {
      var panelId = $( this ).closest( "li" ).remove().attr( "aria-controls" );
      $( "#" + panelId ).remove();
      tabs.tabs( "refresh" );
    });
 
    tabs.bind( "keyup", function( event ) {
      if ( event.altKey && event.keyCode === $.ui.keyCode.BACKSPACE ) {
        var panelId = tabs.find( ".ui-tabs-active" ).remove().attr( "aria-controls" );
        $( "#" + panelId ).remove();
        tabs.tabs( "refresh" );
      }
    });
  });
