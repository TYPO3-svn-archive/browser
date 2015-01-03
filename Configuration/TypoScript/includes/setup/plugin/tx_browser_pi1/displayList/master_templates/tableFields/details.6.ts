plugin.tx_browser_pi1 {
  displayList {
    master_templates {
        // 140703: empty statement: for proper comments only
      tableFields {
      }
        // details
      tableFields =
      tableFields {
          // 140707: empty statement: for proper comments only
        details {
        }
          // 6
        details =
        details {
            // link to the single view (record), internal page, external URL or no link (empty value)
          6 = CASE
          6 {
            key {
              field = {$plugin.tx_browser_pi1.templates.listview.url.6.key}
            }
              // link to the single view (record)
            default = TEXT
            default {
              value = details
              lang {
                de = Mehr
                en = details
              }
              stdWrap {
                stripHtml         = 1
                htmlSpecialChars  = 0
                crop              = 30|...|1
                noTrimWrap        = ||&nbsp;&raquo|
              }
              typolink < plugin.tx_browser_pi1.displayList.master_templates.tableFields.typolinks.6.default
              required = 1
            }
              // without any link (record is available only in list views)
            notype = TEXT
            notype {
              value =
            }
              // link to an internal page
            page < .default
            page {
              typolink < plugin.tx_browser_pi1.displayList.master_templates.tableFields.typolinks.6.page
            }
              // link to an external website
            url < .page
            url {
              value = homepage
              lang {
                de = Homepage
                en = homepage
              }
              typolink < plugin.tx_browser_pi1.displayList.master_templates.tableFields.typolinks.6.url
            }
          }
        }
      }
    }
  }
}