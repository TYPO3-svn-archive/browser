plugin.tx_browser_pi1 {
  displayList {
    master_templates {
        // 140703: empty statement: for proper comments only
      tableFields {
      }
        // image
      tableFields =
      tableFields {
          // 140707: empty statement: for proper comments only
        image {
        }
          // 3
        image =
        image {
            // key, default (single view), page, url
          3 = CASE
          3 {
            key {
              field = {$plugin.tx_browser_pi1.templates.listview.url.3.key}
            }
              // single view
            default = IMAGE
            default {
              file {
                  // current image || default image
                import =
                import {
                  stdWrap {
                      // 10: current image || 20: default image
                    cObject = COA
                    cObject {
                        // current image
                      10 = COA
                      10 {
                        if {
                          isTrue {
                            field = {$plugin.tx_browser_pi1.templates.listview.image.3.file}
                            listNum = {$plugin.tx_browser_pi1.templates.listview.image.3.listNum}
                          }
                        }
                        10 = TEXT
                        10 {
                          value = {$plugin.tx_browser_pi1.templates.listview.image.3.path}
                        }
                        20 = TEXT
                        20 {
                          field   = {$plugin.tx_browser_pi1.templates.listview.image.3.file}
                          listNum = {$plugin.tx_browser_pi1.templates.listview.image.3.listNum}
                        }
                      }
                        // default image
                      20 = TEXT
                      20 {
                        if {
                          isFalse {
                            field = {$plugin.tx_browser_pi1.templates.listview.image.3.file}
                            listNum = {$plugin.tx_browser_pi1.templates.listview.image.3.listNum}
                          }
                        }
                        value = {$plugin.tx_browser_pi1.templates.listview.image.3.default}
                      }
                    }
                  }
                }
                height = {$plugin.tx_browser_pi1.templates.listview.image.3.height}
                width = {$plugin.tx_browser_pi1.templates.listview.image.3.width}
              }
              altText = TEXT
              altText {
                field = {$plugin.tx_browser_pi1.templates.listview.image.3.seo}
                stdWrap {
                  stripHtml = 1
                  htmlSpecialChars = 1
                }
                listNum = {$plugin.tx_browser_pi1.templates.listview.image.3.listNum}
                listNum {
                  splitChar = 10
                }
              }
              titleText < .altText
              imageLinkWrap = 1
              imageLinkWrap {
                enable = 1
                typolink < plugin.tx_browser_pi1.displayList.master_templates.tableFields.typolinks.3.default
              }
              layoutKey = {$plugin.tx_browser_pi1.templates.listview.image.3.layoutKey}
              layout {
                data {
                  element = <img src="###SRC###" ###SOURCECOLLECTION### ###PARAMS### ###ALTPARAMS### ###SELFCLOSINGTAGSLASH###>
                  source.noTrimWrap = | data-###DATAKEY###="###SRC###"|
                }
                default {
                 element = <img src="###SRC###" width="###WIDTH###" height="###HEIGHT###" ###PARAMS### ###ALTPARAMS### ###BORDER### ###SELFCLOSINGTAGSLASH###>
                 source =
                }
                picture {
                  element = <picture>###SOURCECOLLECTION###<img src="###SRC###" ###PARAMS### ###ALTPARAMS### ###SELFCLOSINGTAGSLASH###></picture>
                  source = <source src="###SRC###" media="###MEDIAQUERY###" ###SELFCLOSINGTAGSLASH###>
                }
                srcset {
                  element = <img src="###SRC###" srcset="###SOURCECOLLECTION###" ###PARAMS### ###ALTPARAMS### ###SELFCLOSINGTAGSLASH###>
                  source = |*|###SRC### ###SRCSETCANDIDATE###,|*|###SRC### ###SRCSETCANDIDATE###
                }
              }
              sourceCollection {
                small {
                  width = 200
                  srcsetCandidate = 800w
                  mediaQuery = (min-device-width: 800px)
                  dataKey = small
                }
                smallHires {
                  if.directReturn = 1
                  width = 300
                  pixelDensity = 2
                  srcsetCandidate = 800w 2x
                  mediaQuery = (min-device-width: 800px) AND (foobar)
                  dataKey = smallHires
                  pictureFoo = bar
                }
              }
            }
              // without any link (record is available only in list views)
            notype < .default
            notype {
              imageLinkWrap >
            }
              // link to an internal page
            page < .default
            page {
              imageLinkWrap {
                typolink < plugin.tx_browser_pi1.displayList.master_templates.tableFields.typolinks.3.page
              }
            }
              // link to an external website
            url < .page
            url {
              imageLinkWrap {
                typolink < plugin.tx_browser_pi1.displayList.master_templates.tableFields.typolinks.3.url
              }
            }
              // tt_news type: Link internal Page
            1 < .page
              // tt_news type: Link external Url
            2 < .url
              // DEPRECATED! Use page!
            calpage < .page
              // DEPRECATED! Use url!
            calurl  < .url
              // DEPRECATED! Use default (record)!
            news < .default
              // DEPRECATED! Use page!
            newspage < .page
              // DEPRECATED! Use url!
            newsurl  < .url
          }
        }
      }
    }
  }
}