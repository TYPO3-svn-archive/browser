/**
 * @description map_toggle.js: toggle the map
 * @author (c) 2015 - Dirk Wildt <http://wildt.at.die-netzmacher.de/>
 * @version 6.0.8
 * @since 6.0.8
 */

$( document ).ready( function( )
{

  var labelSlidedown = "Show the map";
  var labelSlideup = "Hide the map";
  var lnDeSlidedown = "Karte einblenden";
  var lnDeSlideup = "Karte ausblenden";

  var htmlLang = $( 'html' ).attr( 'lang' ).substr(0, 2);

  if( htmlLang === "de" ) {
    labelSlidedown = lnDeSlidedown;
    labelSlideup = lnDeSlideup;
  }
  $( ".maptoggle button" ).html( labelSlideup );

  $( ".maptoggle" ).toggle(
          function( ) {
            $( ".mapview" ).slideUp( 'slow' );
            $( ".maptoggle button" ).html( labelSlidedown );
          },
          function( ) {
            $( ".mapview" ).slideDown( 'slow' );
            $( ".maptoggle button" ).html( labelSlideup );
          }
  );
} );