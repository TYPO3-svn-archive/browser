plugin.tx_browser_pi1 {
  views {
    list {
      1000 {
        htmlSnippets =
        htmlSnippets {
          marker {
            filter = TEXT
            filter {
              value (
              <div class="filter">
                ###TT_NEWS.DATETIME###
                ###TT_NEWS_CAT.TITLE###
              </div>
)
            }
          }
        }
      }
    }
  }
}