
'use strict';

window.oxMap.OSM = {

	configuration : {
		'wms'			: 'OSM',
		'type'			: 'Mapnik',
		'mapID'			: 'oxMapArea'
	},
	osmOptions : {
		controls	: [ new OpenLayers.Control.Attribution() ],
		projection	: new OpenLayers.Projection( "EPSG:4326" ),
		units		: 'degrees',
		allOverlays : true
	},
	map : null,
	wmsLayer : null,
	wms : {
		'OSM' : {
				'Osmarender': new OpenLayers.Layer.OSM.Osmarender(),
				'Mapnik'	: new OpenLayers.Layer.OSM.Mapnik()
				},
		'GMap': {
				'ROADMAP'	: new OpenLayers.Layer.Google( 'Google Streets', { numZoomLevels : 20 } )
				}
	},

	Render : function(){

		var self = this,
			options = self.configuration,
			mapLayerType, typeLength,
			mapLayer = [];

		options = $.extend( self.configuration, oxMap.Config );

		mapLayerType = options.type;
		typeLength = mapLayerType.length;

		if( !mapLayerType || typeLength < 1 ){
			new oxMap.Error( 'wms', options.wms + ' ' + options.type );
			return false;
		}

		self.osmOptions.controls = self.osmOptions.controls.concat( new oxMap.OSM.Controls( options.mapControls ) );

		for( var a = 0; a < typeLength; a += 1 ){
			mapLayer.push( self.wms[ options.wms ][ mapLayerType[a] ] );
		}

		oxMap.OSM.map = new OpenLayers.Map( options.mapID, self.osmOptions );
		oxMap.OSM.map.addLayers( mapLayer );
		oxMap.OSM.map.setCenter(
			oxMap.OSM.LonLat( options.center ),
			options.startLevel
		);

		//DEPRECATED
//		if( options.custom.bounds ){
//			oxMap.OSM.map.setOptions(
//				$.extend( oxMap.OSM.map.options, {
//					restrictedExtent : oxMap.Helper.OL.createBoundObject( options.custom.bounds, 'WGS84')
//				})
//			);
//		}

		oxMap.OSM.wmsLayer = mapLayer;

		oxMap.data = rawdata || (function(){ new oxMap.Error( 'data' ) })();

	},

	Controls : function( controls ){

		var a, b = controls.length,
		control = [],
		controlLayer;

		for( a = 0; a < b; a += 1 ){
			if( controls[a] === 'Navigation' ){
				controlLayer = new OpenLayers.Control.Navigation({
					zoomWheelEnabled	: false
				});
			}
			else{
				controlLayer = new OpenLayers.Control[ controls[ a ] ]();
			}
			control.push( controlLayer );
		}

		return control;

	},

	LonLat : function( aCoorPair ){

        if ( aCoorPair.length === 2 ){
            return new OpenLayers.LonLat( aCoorPair[ 0 ], aCoorPair[ 1 ] )
            			.transform( oxMap.Helper.OL.transformer.WGS84, oxMap.Helper.OL.transformer.map() );
        }
        return false;

	}

};