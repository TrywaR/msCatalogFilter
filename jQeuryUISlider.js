// html
// <div id="price_slider"></div>
// <input id="filter_price_from" type="text" name="price_from" value="0">
// <input id="filter_price_to" type="text" name="price_to" value="100000">
// html x

$(function(){
  // price_slider
  var min_value = 0;
  var max_value = 100000;
  $( "#price_slider" ).slider({
    values: [ 0, max_value ],
    max: max_value,
    change: function( event, ui ) {
      var values = $( "#price_slider" ).slider( "values" )
      $('#filter_price_from').val(values[0])
      $('#filter_price_to').val(values[1])
      $('.ajax-start').click()
    }
  });

  const filter_price_to = document.querySelector('#filter_price_to')
  const filter_price_from = document.querySelector('#filter_price_from')

  filter_price_to.addEventListener('input', updatePriceSliderValue)
  filter_price_from.addEventListener('input', updatePriceSliderValue)

  function updatePriceSliderValue(e) {
    $('#price_slider').slider('option', 'values', [ $('#filter_price_from').val(), $('#filter_price_to').val() ]);
  }

  $(document).on('click', '.ajax-reset', function() {
    $('#price_slider').slider('option', 'values', [ min_value, max_value ]);
  })
  // price_slider x
})
