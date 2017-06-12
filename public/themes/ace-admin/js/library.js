$(document).ready(function() {
    // Initiate layout and plugins

    // ------------------------ Datatables [GLOBAL] ------------------------------- //
    /*
    $('#datatable-table > thead > tr > th:first-child input[type="checkbox"]').on('click',function(){
        if( $(this).prop('checked') === true) {
            alert($('#datatable-table > tbody > tr > td').find('input[type="checkbox"]').html());
        } else {

        }
    })
    */

    $('#datatable-table').on('click', 'thead > tr > th:first-child input[type=checkbox]', function() {
        var check_boxes = $('#datatable-table > tbody > tr > td:first-child input[type="checkbox"]');
        if( $(this).prop('checked') === true) {
            check_boxes.each(function() { $(this).prop('checked',true); });
        } else {
            check_boxes.each(function() { $(this).prop('checked',false); });
        }
    });

    // ------------------------ Tags Form input ------------------------------- //

    var tag_input = $('#form-field-tags');
    var tag_input_url = tag_input.data('rel');

    try {
        tag_input.tag(
          {
            placeholder:tag_input.attr('placeholder'),
            //enable typeahead by specifying the source array
            //source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
            source: function(query, process) {
              //$.ajax({url: base_ADM + 'remote_source.php?q='+encodeURIComponent(query)})
              $.ajax({url: tag_input_url + '?q='+encodeURIComponent(query)}).done(function(result_items) {
                //tag_input.data('tag').add (result_items);
                process(result_items);
              });
            }
          }
        )

        //programmatically add a new
        //var $tag_obj = $('#form-field-tags').data('tag');
        //$tag_obj.add('Programmatically Added');
    }
    catch(e) {
        //display a textarea for old IE, because it doesn't support this plugin or another one I tried!
        tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
        //$('#form-field-tags').autosize({append: "\n"});
    }

    tag_input.on('added', function (e, value) { })
    tag_input.on('removed', function (e, value) { })

});
//------------------------- jQuery Extend Function ---------------------------------//
// public function to get a paremeter by name from URL and return the value
$.extend({
    getURLParameter: function (paramName) {
        var searchString = window.location.search.substring(1),
            i, val, params = searchString.split("&");

        for (i = 0; i < params.length; i++) {
            val = params[i].split("=");
            if (val[0] == paramName) {
                return unescape(val[1]);
            }
        }
        return null;
    }
});
