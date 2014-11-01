plugin.tx_browser_pi1 {
  template {
      // default file
    file = EXT:browser/res/html/default.tmpl
    css {
      browser = EXT:browser/res/html/default.css
      browser {
          // [Boolean] 0 (default): CSS as external file, 1: CSS inline
        inline = 0
      }
      jquery_ui = EXT:browser/res/js/jquery/ui/smoothness/jquery-ui-1.8.14.custom.css
      jquery_ui {
          // [Boolean] 0 (default): CSS as external file, 1: CSS inline
        inline = 0
      }
    }
    extensions {
        // table, list, main, margin, table_until_3-9-6
      browser =
      browser {
        table {
          name = Browser: Table (without any view)
          file = EXT:browser/res/html/default.tmpl
        }
        list {
          name = Browser: List (without any view)
          file = EXT:browser/res/html/default_ul.tmpl
        }
          // #44131
        main {
          name      = Browser: Main
          file      = EXT:browser/res/html/main.tmpl
          csvViews  = all
        }
          // #44131
        margin {
          name      = Browser: Margin
          file      = EXT:browser/res/html/margin.tmpl
          csvViews  = all
        }
          // #60530
        newsletter {
          name      = Browser: Newsletter
          file      = EXT:browser/res/html/newsletter.html
          csvViews  = all
        }
        table_until_3-9-6 {
          name = Browser: Table (until version 4.0)
          file = EXT:browser/res/html/until_3.9.6/default.tmpl
        }
      }
    }
    add_parameter {
      comment   = Array for adding parameter to navigation elements.
      tutorial  = http://typo3.org/extensions/repository/view/browser_tut_navigation_en/current/
        // Default parameter
      browser = COA
      browser {
          // showUid
        10 = TEXT
        10 {
          dataWrap        = &tx_browser_pi1[showUid]={GP:tx_browser_pi1|showUid}
          if.isTrue.data  = GP:tx_browser_pi1|showUid
        }
          // azTab
        20 = TEXT
        20  {
          dataWrap        = &tx_browser_pi1[azTab]={GP:tx_browser_pi1|azTab}
          if.isTrue.data  = GP:tx_browser_pi1|azTab
        }
          // indexBrowserTab
        21 = TEXT
        21  {
          dataWrap        = &tx_browser_pi1[indexBrowserTab]={GP:tx_browser_pi1|indexBrowserTab}
          if.isTrue.data  = GP:tx_browser_pi1|indexBrowserTab
        }
          // mode
        30 = TEXT
        30  {
          dataWrap        = &tx_browser_pi1[mode]={GP:tx_browser_pi1|mode}
          if.isTrue.data  = GP:tx_browser_pi1|mode
        }
          // pointer
        40 = TEXT
        40  {
          dataWrap        = &tx_browser_pi1[pointer]={GP:tx_browser_pi1|pointer}
          if.isTrue.data  = GP:tx_browser_pi1|pointer
        }
          // sort
        50 = TEXT
        50  {
          dataWrap        = &tx_browser_pi1[sort:tx_browser_pi1|sort]={GP:tx_browser_pi1|sort}
          if.isTrue.data  = GP:tx_browser_pi1|sort
        }
          // sword
        60 = TEXT
        60  {
          dataWrap        = &tx_browser_pi1[sword]={GP:tx_browser_pi1|sword}
          if.isTrue.data  = GP:tx_browser_pi1|sword
        }
      }
    }
  }
}