jQuery('.composite_data').on('wc-composite-initializing', function (event, composite) {
  composite.actions.add_action('component_summary_content_updated', function () {
    jQuery('.quantity').addQty()
  }, 100)
  composite.actions.add_action('component_selection_changed', function () {
    jQuery('.quantity').addQty()
  }, 100)
})
