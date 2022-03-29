$(document).on('change', '.btn-group input', function() {
  $('.btn-group input:checked').each(function(index, element) {
    var $el = $(element);
    var thisName = $el.attr('name');
    var thisVal  = $el.attr('value');
    $('select[name="'+thisName+'"]').val(thisVal).trigger('change');
  });
});
$(document).on('woocommerce_update_variation_values', function() {
  $('.btn-group input').each(function(index, element) {
    var $el = $(element);
    var thisName = $el.attr('name');
    var thisVal  = $el.attr('value');
    $el.removeAttr('disabled');
    if($('select[name="'+thisName+'"] option[value="'+thisVal+'"]').is(':disabled')) {
      $el.prop('disabled', true);
    }
  });
});