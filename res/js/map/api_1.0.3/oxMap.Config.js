/*
 *  map configuration for rendering a map
 * 
 *  author:    o'xkape, Mike Kunert <warum@oxkape.de>
 *  copyright: o'xkape <http://www.webkartografie.de> by <http://www.oxkape.de>
 *  date: 2012-02-20
 *  
 * */

window.oxMap = {};
window.oxMap.Config = {

  modules         : [
                      'Error', 'OSM', 'OSM.CDmap','OSM.Filter'
                    ],
  wms             : 'GMap',
  type            : ['ROADMAP'],
  center          : [ 11.04401,50.97313 ],//[ 9.555442525, 48.933978799 ],//
  startLevel      : 8,
  numZoomLevels   : 8,
  custom          : {
    type: 'Image',
    size: {
      w: 705,
      h: 567
    },
    bounds: {
      w: 9.69132,
      s: 50.13531,
      e: 12.84027,
      n: 51.71852
    },
    imageType: 'png',
    png:{
      0: 'img/thuer.level1.png',
      1: 'img/thuer.level1_2.png',
      2: 'img/thuer.level2.png',
      3: 'img/thuer.level2.png'
    },
    svg: {
      0: 'img/thuer.level1.svg',
      1: 'img/thuer.level1.svg',
      2: 'img/thuer.level2.svg',
      3: 'img/thuer.level2.svg'
    },
    numZoomLevels: 4,
    startLevel : 8
  },

  filter          : '#oxMapFilter',
  filterItems     : '.oxMapFilter',

  mapID           : 'oxMapArea',
  mapControls     : [
                      'Navigation', 'PanZoom', 'LayerSwitcher'
                    ],
  mapMarkerEvent  : 'hover'//    click | hover | on (for drawing one point only)
};