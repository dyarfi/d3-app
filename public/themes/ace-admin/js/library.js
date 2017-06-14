$(document).ready(function() {
    // Initiate layout and plugins
    // TABLE -----------------------------------------

        if ($('#dynamic-table').size() > 0 && $.fn.dataTable) {
          //initiate dataTables plugin
          var oTable1 =
          $('#dynamic-table')
          //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
          .dataTable( {
            bAutoWidth: false,
            "aoColumns": [
              { "bSortable": false },
              // It seems depends on column count or will be alerting some error
              null, null, null, null,
              { "bSortable": false }
            ],
            // set the initial value
            "iDisplayLength": 10,
            "aaSorting": [],
            //,
            //"sScrollY": "200px",
            //"bPaginate": false,

            //"sScrollX": "100%",
            //"sScrollXInner": "120%",
            //"bScrollCollapse": true,
            //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
            //you may want to wrap the table inside a "div.dataTables_borderWrap" element

            //"iDisplayLength": 50
            } );
          //oTable1.fnAdjustColumnSizing();


          //TableTools settings
          TableTools.classes.container = "btn-group btn-overlap";
          TableTools.classes.print = {
            "body": "DTTT_Print",
            "info": "tableTools-alert gritter-item-wrapper gritter-info gritter-center white",
            "message": "tableTools-print-navbar"
          }

          //initiate TableTools extension
          var tableTools_obj = new $.fn.dataTable.TableTools( oTable1, {
            //"sSwfPath": base_url +"/assets/swf/copy_csv_xls_pdf.swf",
            "sRowSelector": "td:not(:last-child)",
            "sRowSelect": "multi",
            "fnRowSelected": function(row) {
              //check checkbox when row is selected
              try { $(row).find('input[type=checkbox]').get(0).checked = true }
              catch(e) {}
            },
            "fnRowDeselected": function(row) {
              //uncheck checkbox
              try { $(row).find('input[type=checkbox]').get(0).checked = false }
              catch(e) {}
            },
            "sSelectedClass": "success",
                "aButtons": [
                    {
                      "sExtends": "print",
                      "sToolTip": "Print view",
                      "sButtonClass": "btn btn-white btn-primary  btn-bold",
                      "sButtonText": "<i class='fa fa-print bigger-110 grey'></i>",

                      "sMessage": "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small>Optional Navbar &amp; Text</small></a></div></div>",

                      "sInfo": "<h3 class='no-margin-top'>Print view</h3>\
                            <p>Please use your browser's print function to\
                            print this table.\
                            <br />Press <b>escape</b> when finished.</p>",
                    }
                ]
            });
          //we put a container before our table and append TableTools element to it
            $(tableTools_obj.fnContainer()).appendTo($('.tableTools-container'));

          //also add tooltips to table tools buttons
          //addding tooltips directly to "A" buttons results in buttons disappearing (weired! don't know why!)
          //so we add tooltips to the "DIV" child after it becomes inserted
          //flash objects inside table tools buttons are inserted with some delay (100ms) (for some reason)
          setTimeout(function() {
            $(tableTools_obj.fnContainer()).find('a.DTTT_button').each(function() {
              var div = $(this).find('> div');
              if(div.length > 0) div.tooltip({container: 'body'});
              else $(this).tooltip({container: 'body'});
            });
          }, 200);



          //ColVis extension
          var colvis = new $.fn.dataTable.ColVis( oTable1, {
            "buttonText": "<i class='fa fa-search'></i>",
            "aiExclude": [0, 6],
            "bShowAll": true,
            //"bRestore": true,
            "sAlign": "right",
            "fnLabel": function(i, title, th) {
              return $(th).text();//remove icons, etc
            }

          });

          //style it
          $(colvis.button()).addClass('btn-group').find('button').addClass('btn btn-white btn-info btn-bold')

          //and append it to our table tools btn-group, also add tooltip
          $(colvis.button())
          .prependTo('.tableTools-container .btn-group')
          .attr('title', 'Show/hide columns').tooltip({container: 'body'});

          //and make the list, buttons and checkboxed Ace-like
          $(colvis.dom.collection)
          .addClass('dropdown-menu dropdown-light dropdown-caret dropdown-caret-right')
          .find('li').wrapInner('<a href="javascript:void(0)" />') //'A' tag is required for better styling
          .find('input[type=checkbox]').addClass('ace').next().addClass('lbl padding-8');



          /////////////////////////////////
          //table checkboxes
          $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

          //select/deselect all rows according to table header checkbox
          $('#dynamic-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
            var th_checked = this.checked;//checkbox inside "TH" table header

            $(this).closest('table').find('tbody > tr').each(function(){
              var row = this;
              if(th_checked) tableTools_obj.fnSelect(row);
              else tableTools_obj.fnDeselect(row);
            });
          });

          //select/deselect a row when the checkbox is checked/unchecked
          $('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
            var row = $(this).closest('tr').get(0);
            if(!this.checked) tableTools_obj.fnSelect(row);
            else tableTools_obj.fnDeselect($(this).closest('tr').get(0));
          });


        $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
            e.stopImmediatePropagation();
            e.stopPropagation();
            e.preventDefault();
          });


          //And for the first simple table, which doesn't have TableTools or dataTables
          //select/deselect all rows according to table header checkbox
          var active_class = 'active';
          $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
            var th_checked = this.checked;//checkbox inside "TH" table header

            $(this).closest('table').find('tbody > tr').each(function(){
              var row = this;
              if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
              else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
            });
          });

          //select/deselect a row when the checkbox is checked/unchecked
          $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
            var $row = $(this).closest('tr');
            if(this.checked) $row.addClass(active_class);
            else $row.removeClass(active_class);
          });



          /********************************/
          //add tooltip for small view action buttons in dropdown menu
          $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

          //tooltip placement on right or left
          function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            if ($parent.size > 0) {
              var off1 = $parent.offset();
              var w1 = $parent.width();

              var off2 = $source.offset();
              //var w2 = $source.width();

              if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            }
            return 'left';
          }
        }

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

    $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
        e.stopImmediatePropagation();
        e.stopPropagation();
        e.preventDefault();
    });

    // $.fn.dataTableExt.sErrMode = 'throw';

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

    // jCrop Init
    if (typeof FormImageCrop === 'object') {
        FormImageCrop.init();
    }

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
