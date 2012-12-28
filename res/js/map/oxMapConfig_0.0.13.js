/*
 *  map configuration for rendering a map
 * 
 *  author:    o'xkape, Mike Kunert <warum@oxkape.de>
 *  copyright: o'xkape <http://www.webkartografie.de> by <http://www.oxkape.de>
 *  date: 2012-12-17
 *
 */

window.oxMap = {};
window.oxMap.Config = {
    modules         : [
                        'OSM', 'OSM.CDmap','OSM.Filter'
                      ],
    wms             : 'GMap',
    type            : ['ROADMAP'],
    center          : [ 11.04401,50.97313 ],
    startLevel      : 8,
    numZoomLevels   : 8,
    custom          : {
        type: 'Image',
        size: {
                  w: 705
                , h: 567
        },
        bounds      : {
              w: 9.69132
            , s: 50.13531
            , e: 12.84027
            , n: 51.71852
        },
        imageType   : 'png',
        png         :{
              0: 'fileadmin/user_upload/browser/test_thueringen/thuer.level1_1.png'
            , 1: 'fileadmin/user_upload/browser/test_thueringen/thuer.level1_2.png'
            , 2: 'fileadmin/user_upload/browser/test_thueringen/thuer.level2_1.png'
            , 3: 'fileadmin/user_upload/browser/test_thueringen/thuer.level2_2.png'
        },
        numZoomLevels: 4,
        startLevel  : 8
    },

    filter          : '#oxMapFilter',
    filterItems     : '.oxMapFilter',

    mapID           : 'oxMapArea',
    mapControls     : [
                        'Navigation', 'PanZoom', 'LayerSwitcher'
                      ],
    mapMarkerEvent  : 'hover'//    click | hover | on (for drawing one point only)
};