$(document).ready(function() {
    // Initiate layout and plugins

    // ---------------------- ADMINISTRATOR Javascript Custom Function -- start [ --------------------------
    // File name in input form
    if($('.ace-file-input input[type="file"]').size() > 0) {

        $('.ace-file-input input[type="file"]').change(function() {
            $('.ace-file-name').attr('data-title',$(this).val());
        });

        if ($('.image-alt').size() > 0) {
           $('.ace-file-name').attr('data-title',$('.image-alt').attr('alt'));
        }
    }

    // Date picker
    if ($('.date-picker').size() > 0 ) {
        $('.date-picker').datepicker();
    }

    $('#permissions_update input[class="checked"]').change(function(){
      if( $(this).is(':checked')) {
        $(this).attr('value',true);
      } else {
        $(this).attr('value',false);
      }
    });

    // Set method to check all or uncheck all on permission checkbox
    $('#permissions_update input[name^="check_all"]').change(function(){
      var $form  = $(this).parents('div.checkbox-handler');
      var $label = $(this).next('label');
      if( $(this).is(':checked')) {
          $form.find('input[class="checked"]:not(:disabled)').prop('checked',true);
          $form.find('input[class="checked"]:not(:disabled)').attr('value',true);
          $label.text('Unchecked All');
      } else {
          $form.find('input[class="checked"]:not(:disabled)').prop('checked',false);
          $form.find('input[class="checked"]:not(:disabled)').attr('value',false);
          $label.text('Check All');
      }
    });

    // Set to check if checkbox parent is all checked up or false on permission checkbox
    $('#permissions_update input[name^="check_all"]').each(function( index ) {
      //console.log( index + ": " + $( this ).text() );
      var $form    = $(this).parents('div.checkbox-handler');
      var $input   = $form.find('input[class="checked"]').length;
      var $checked = $form.find('input[class="checked"]:checked').length;
      var $label   = $(this).next('label');
      if ($input === $checked) {
        $(this).prop('checked',true);
        $label.text('Unchecked All');
      } else {
        $(this).prop('checked',false);
      }
    });

    // Send ajax post on permissions controller
    $('#permissions_update').submit(function(){
      var $form = $(this);
      $.ajax({
          method:'POST',
          url: $form.attr('action'),
          data:$form.serialize(),
          error: function(XMLHttpRequest, textStatus, errorThrown) {
              bootbox.alert(errorThrown, function(result) {
                //if (result === null) {
                //} else {
                //}
              });
          }
      }).done(function(message) {
          if (message.status == 200) {
            bootbox.alert(message.message, function(result) {});
            location.reload();
          }
      });
      return false;
    });

    // Set and find form Slug input from Name input
    if ($('input[id="name"], input[id="title"]').size() > 0 && $('input[id="slug"]').size() > 0) {
      // Detects if user type on the input
      $('input[id="name"], input[id="title"]').on('keyup blur',function(){
          var re  = /[^a-z0-9]+/gi;
          var re2 = /^-*|-*$/g;
          var value = $(this).val();
          value = value.replace(re2, '').toLowerCase();
          value = value.replace(re, '-');
          // Set Slug form
          $('input[id="slug"]').val(value);
      });
    }
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

    var FormInit = function () {
        // Handle tags form inputs
        var handleTagForm = function () {
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

            tag_input.on('added', function (e, value) { });
            tag_input.on('removed', function (e, value) { });
        }

        // Handle status form select
        var handleStatusForm = function () {
            $('#select_action').change(
                function () {
                    $(this).parents('form').submit();
                }
            );
        }

        return {
            //main function to initiate the module
            init: function () {
                handleStatusForm();
                handleTagForm();
            }
        };

    }();

    FormInit.init();
    // ---------------------- ADMINISTRATOR Javascript Custom Function -- end ] --------------------------


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
