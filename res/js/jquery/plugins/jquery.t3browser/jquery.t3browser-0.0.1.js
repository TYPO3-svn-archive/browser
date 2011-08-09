/**
 * jQuery t3browser Plugin 0.0.1
 *
 * http://docs.jquery.com/Plugins/t3browser
 *
 * Copyright (c) 2011 Dirk Wildt
 * http://wildt.at.die-netzmacher.de/
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

;(function( $ )
{
  
  var settings = {
    messages: {
      errMissingTagPropertyLabel: "Tag is missing:",
      errMissingTagPropertyPrmpt: "A HTML tag with an attribute {0} is missing. AJAX can't work!",
      infMissingTagPropertyLabel: "Be aware of a proper HTMLtemplate:",
      infMissingTagPropertyPrmpt: "Please add something like <div id=\"{0}\" to your template.",
      hlpPageObjectLabel:   "Be aware of a proper TYPO3 page object:",
      hlpPageObjectPrmpt:   "Check the page object and the current typeNum.",
      hlpUrlLabel:          "Be aware of a proper URL:",
      hlpUrlPrmpt:          "Check the requested URL manually: {0}",
      hlpUrlSelectorLabel:  "Be aware of the jQuery selector:",
      hlpUrlSelectorPrmpt:  "The request takes content into account only if this selector gets a result: {0}",
      hlpGetRidOfLabel:     "Get rid of this messages?",
      hlpGetRidOfPrmpt:     "Deactivate the jQuery plugin t3browser. But you won't have any AJAX support.",
    },
    templates: {
      uiErr:  '<div class="ui-widget">' + 
                '<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">' + 
                  '<p>' + 
                    '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>' +
                    '<strong>{0}</strong> ' +
                    '{1}' +
                  '</p>' +
                '</div>' +
              '</div>',
      uiInf:  '<div class="ui-widget">' + 
                '<div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">' + 
                  '<p>' + 
                    '<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' +
                    '<strong>{0}</strong> ' +
                    '{1}' +
                  '</p>' +
                '</div>' +
              '</div>',
    }
  };

  var methods = {
    init :    function( settings_ ) 
              {
                return this.each(function() {        
                  // If settings_ exist, lets merge them
                  // with our default settings
                  if ( settings_ ) { 
                    $.extend( settings, settings_ );
                  }
                });
              },
    show :    function( )
              {
              },
    hide :    function( )
              {
              },
    update :  function( html_element, url, html_element_wi_selector )
              {
                  // update():  replace the content of the given html element with the content 
                  //            of the requested url. The content is the content of the html element with selector.

                return this.each( function ( )
                {
                  if( !$( "#update-prompt" ).length ) {
                    $( "body" ).prepend( '<div id="#update-prompt"></div>' );
                  }
                  if( !$( html_element ).length ) {
                    err_prompt( "#update-prompt", settings.messages.errMissingTagPropertyLabel, settings.messages.errMissingTagPropertyPrmpt );
                    inf_prompt( "#update-prompt", settings.messages.hlpMissingTagPropertyLabel, settings.messages.hlpMissingTagPropertyPrmpt );
                  }
                  alert( "length " + $( html_element ).length );
                  alert( "selector " + $( html_element ).selector );
                  alert( "context " + $( html_element ).context.nodeName );
                  alert( "length " + $( "#update-prompt" ).length );
                  alert( "selector " + $( "#update-prompt" ).selector );
                  alert( "context " + $( "#update-prompt" ).context.nodeName );
                  cover_wi_loader( html_element );
                
                    // Fade out the error element
                  $("#update-prompt:visible").slideUp( 'fast' );
                  $("#update-prompt div").remove( );

                    // Send the AJAX request
                    // Replace the content of the html element with the delivered data
// :TODO: Testen ob html_element existiert, sonst Fehlermeldung
                  var url_wi_selector = url + " " + html_element_wi_selector;
                  $( html_element ).load(url_wi_selector, function( response, status, xhr )
                  {
                    if (status == "error")
                    {
                      err_prompt( "#update-prompt", xhr.status, xhr.statusText );
                      inf_prompt( "#update-prompt", settings.messages.hlpPageObjectLabel, settings.messages.hlpPageObjectPrmpt );
                      prompt = format( settings.messages.hlpUrlPrmpt, url);
                      inf_prompt( "#update-prompt", settings.messages.hlpUrlLabel, prompt );
                      prompt = format( settings.messages.hlpUrlSelectorPrmpt, html_element_wi_selector);
                      inf_prompt( "#update-prompt", settings.messages.hlpUrlSelectorLabel, prompt );
                      inf_prompt( "#update-prompt", settings.messages.hlpGetRidOfLabel, settings.messages.hlpGetRidOfPrompt );
                        // Fade in the error element
                      $("#update-prompt:hidden").slideDown( 'fast' );
//      var msg = "Sorry but there was an error: ";
//      var msg1 = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>';
//      var msg2 = '</strong>';
//      var msg3 = '</p></div></div>';
//      var prompt = "Did you configured a proper page object?\n Please check this URL: \n" + url;
      //var infPrompt = jQuery.t3browser.format( this.templates['uiInfo'], this.messages['hlpPageObjectLabel'], this.messages['hlpPageObjectPrompt']);
        //alert("'" + str + "'");
//      $("#update-prompt").html(msg1 + xhr.statusText + ' (' + xhr.status + '): ' + msg2 + prompt + msg3);
      //$("#update-prompt").html(infPrompt);
  // Testen ob #update-prompt existiert, sonst alert oder add
//  $("#update-prompt").slideDown( 'fast' );
//alert(settings.messages.hlpPageObjectLabel);
  //alert(msg + " | " + xhr.status + " | " + xhr.statusText);
    }
  //alert('2');
                      // Fade out the loader
                    $( "#tx-browser-pi1-loader" ).fadeOut( 500, function( )
                    {
                      $( this ).remove( );
                    });
                      // Remove the opacity of the html element
                    $( html_element ).removeClass( "opacity08" );
                      // Initiate the ui button layout again
                    $( "input:submit, input:button, a.backbutton", ".tx-browser-pi1" ).button( );
//alert('3');
                  });
                    // Send the AJAX request
                });
                
                  // Cover the current html element with the loader *.gif
                function cover_wi_loader( html_element ) {
                    // Add an opacity to the html element
                  $( html_element ).addClass( "opacity08" );

                    // Cover the html element with a loading gif
                  $( html_element ).prepend( "\t<div id='tx-browser-pi1-loader'></div>\n" );   
                    // Get the size of the html element
                  var heightWiPx      = $( html_element ).css( "height" );
                  var widthWiPx       = $( html_element ).css( "width" );
                  var marginBottomPx  = "-" + $( html_element ).css( "width" );
                    // Set the loader to the size of the html element
                  $( "#tx-browser-pi1-loader" ).css( "height",        heightWiPx      );
                  $( "#tx-browser-pi1-loader" ).css( "width",         widthWiPx       );
                  $( "#tx-browser-pi1-loader" ).css( "margin-bottom", marginBottomPx  );
                    // Fade in the loader
                  $( "#tx-browser-pi1-loader" ).fadeIn( 150 );
                    // Cover the html element with a loading gif
                };
                  // Cover the current html element with the loader *.gif
                  
                function err_prompt( selector, label, prompt ) {
                  element = format( settings.templates.uiErr, label, prompt); 
                  $( selector ).append( element );
                }; 

                function inf_prompt( selector, label, prompt ) {
                  element = format( settings.templates.uiInf, label, prompt); 
                  $( selector ).append( element );
                }; 

                function format( source, params ) {
                  if ( arguments.length == 1 )
                  {
                    return function() {
                      var args = $.makeArray(arguments);
                      args.unshift(source);
                      return $.t3browser.format.apply( this, args );
                    };
                  }
                  if ( arguments.length > 2 && params.constructor != Array  )
                  {
                    params = $.makeArray(arguments).slice(1);
                  }
                  if ( params.constructor != Array )
                  {
                    params = [ params ];
                  }
                  $.each(params, function(i, n)
                  {
                    source = source.replace(new RegExp("\\{" + i + "\\}", "g"), n);
                  });
                  return source;
                };              
              },
                // update( )
    url_autoQm: function( url, param )
              {
                  // Concatenate the url and the param in dependence of a question mark.
                  // If url contains a question mark, param will added with ?param
                  // otrherwise with &param

                if(url.indexOf("?") >= 0)
                {
                  url = url + "&" + param;
                }
                if(!(url.indexOf("?") >= 0))
                {
                  url = url + "?" + param;
                }
                return url;
              },
                // url_autoQm
  };
  
  $.fn.t3browser = function( method )
  {
      // Method calling logic
      // See http://docs.jquery.com/Plugins/Authoring#Plugin_Methods
    
      // Return executed method
    if ( methods[method] ) 
    {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    }
    
      // Set default values
    if ( typeof method === "object" || ! method )
    {
      return methods.init.apply( this, arguments );
    }
    
      // Error: No proper method, no arguments 
    $.error( "Method " +  method + " does not exist on jQuery.t3browser" );
      // Method calling logic
  };

})( jQuery );
