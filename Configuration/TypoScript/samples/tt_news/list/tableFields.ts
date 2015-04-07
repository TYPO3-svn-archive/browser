plugin.tx_browser_pi1 {
  views {
    list {
      1000 {
        tt_news {
          datetime = TEXT
          datetime {
            field = tt_news.datetime
            strftime {
              cObject = TEXT
              cObject {
                value   = %m/%d/%y
                lang.de = %d.%m.%y
              }
            }
          }
          image < plugin.tx_browser_pi1.displayList.master_templates.tableFields.image.0
          title < plugin.tx_browser_pi1.displayList.master_templates.tableFields.header.0
        }
      }
    }
  }
}
