plugin.tx_browser_pi1 {
  displayList {
    master_templates {
        // 140703: empty statement: for proper comments only
      tableFields {
      }
        // typolinks_1
      tableFields =
      tableFields {
          // 140707: empty statement: for proper comments only
        typolinks {
        }
          // 1
        typolinks =
        typolinks {
            // default (single view), page, url
          1 =
          1 {
              // typolink for a record (single view)
            default =
            default {
                // url, target, class, title
              parameter{
                cObject = COA
                cObject {
                    // url
                  10 = COA
                  10 {
                    10 = TEXT
                    10 {
                      if {
                        isTrue = {$plugin.tx_browser_pi1.templates.listview.url.1.singlePid}
                      }
                      value = {$plugin.tx_browser_pi1.templates.listview.url.1.singlePid}
                    }
                    20 = TEXT
                    20 {
                      if {
                        isFalse = {$plugin.tx_browser_pi1.templates.listview.url.1.singlePid}
                      }
                      data = page:uid
                    }
                  }
                    // target
                  20 = TEXT
                  20 {
                    value       = -
                    noTrimWrap  = | ||
                  }
                    // class
                  30 = TEXT
                  30 {
                    value       = linktosingle
                    noTrimWrap  = | ||
                  }
                    // title
                  40 = TEXT
                  40 {
                    field = {$plugin.tx_browser_pi1.templates.listview.header.1.list} // {$plugin.tx_browser_pi1.templates.listview.header.1.single}
                    stdWrap {
                      stripHtml = 1
                      htmlSpecialChars = 1
                    }
                    noTrimWrap  = | "|"|
                  }
                }
              }
              additionalParams {
                wrap  = &tx_browser_pi1[{$plugin.tx_browser_pi1.templates.listview.url.1.showUid}]=|
                field = {$plugin.tx_browser_pi1.templates.listview.url.1.record}
              }
              forceAbsoluteUrl = {$plugin.tx_browser_pi1.templates.listview.url.1.forceAbsoluteUrl}
              forceAbsoluteUrl {
                scheme = {$plugin.tx_browser_pi1.templates.listview.url.1.forceAbsoluteUrlScheme}
              }
              useCacheHash = 1
            }
              // link to an internal page. 10: teaser_title, 20: title
            page < .default
            page {
              parameter.cObject {
                10 >
                10 = TEXT
                10 {
                  field = {$plugin.tx_browser_pi1.templates.listview.url.1.page}
                }
                30 {
                  value = internal
                }
              }
              additionalParams >
            }
              // link to an external website. 10: teaser_title, 20: title
            url < .page
            url {
              parameter.cObject {
                10 {
                  field = {$plugin.tx_browser_pi1.templates.listview.url.1.url}
                }
                20 {
                  value       = _blank
                  noTrimWrap  = | ||
                }
                30 {
                  value = external
                }
              }
            }
          }
        }
      }
    }
  }
}