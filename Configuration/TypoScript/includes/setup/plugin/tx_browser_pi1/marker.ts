plugin.tx_browser_pi1 {
    // markers can use TEXT or COA
  marker =
  marker {
      // value will allocated while runtime. Value will be the title content of the flexform/plugin
    my_title = TEXT
    my_title {
      value =
      wrap = <h1>|</h1>
    }
      // value will allocated while runtime. Value will be the prompt content of the flexform/plugin
    my_prompt = TEXT
    my_prompt {
      value =
      wrap = <p>|</p>
    }
        // markers can use TEXT or COA
    my_url = TEXT
    my_url {
      typolink {
        parameter = {page:uid}
        parameter {
          insertData = 1
        }
        returnLast = url
      }
    }
        // markers can use TEXT or COA
    my_reset = TEXT
    my_reset {
      value = Reset
      lang {
        de = Zur&uuml;cksetzen
        en = Reset
      }
    }
        // markers can use TEXT or COA
    my_search = TEXT
    my_search {
      value = Search
      lang {
        de = Suchen
        en = Search
      }
    }
        // markers can use TEXT or COA
    my_search_legend = TEXT
    my_search_legend {
      data = LLL:EXT:browser/pi1/locallang.xml:label_search_legend
    }
        // markers can use TEXT or COA
    my_csv_export = TEXT
    my_csv_export {
      value = Export
      lang {
        de = Export
        en = Export
      }
    }
        // markers can use TEXT or COA
    my_week = TEXT
    my_week {
      value = week
      lang {
        de = Woche
        en = week
      }
    }
  }
}