(function() {

  var canvas = new fabric.Canvas('canvas');
  
  canvas.backgroundColor = 'white';

  //var image = $('input[name="image_temp"]').val();  
  //if ($('input[name="image_temp"]').value()) {
    //alert('asdf');
  //}
/*
  fabric.Image.fromURL('http://localhost/dentsu.digital/uploads/gallery/4a95b5f9dcc17addd5c8c17b1227f6ff.jpg', function(oImg) {
    oImg.set('selectable',false);
    canvas.add(oImg);
    canvas.centerObject(oImg);
  });
*/

$('#canva-row').hide();
$('.item-handler').hide();

if (document.getElementById('fileupload') != null) {
  document.getElementById('fileupload').onchange = function handleImage(e) {
    var reader = new FileReader();

    $('#canva-row').show();
    $('.item-handler').show();

    reader.onload = function (event) { 
      
        //console.log('fdsf');

        // resizeCanvas();

        $('.button-submit').show({duration:'260',easing:'easeInOutBack'});

        var imgObj = new Image();
        imgObj.src = event.target.result;
        imgObj.onload = function () {
            // start fabricJS stuff
            
            var image = new fabric.Image(imgObj);

            //console.log(image.width);
            //console.log(image.height);

            resizeCanvas(image.width,image.height);

            /*
            image.set({
                left: 250,
                top: 250,
                angle: 20,
                padding: 10,
                cornersize: 10
            });
            */

            image.set('selectable',false);
            //image.scale(getRandomNum(0.1, 0.25)).setCoords();
            canvas.add(image);
            canvas.centerObject(image);
            // end fabricJS stuff
        }
        
    }
    reader.readAsDataURL(e.target.files[0]);
  }
}
  // resize the canvas to fill browser window dynamically
  window.addEventListener('resize', resizeCanvas, false);

  function resizeCanvas(itemHandlerWidth='',itemHandlerHeight='') {
    if (itemHandlerWidth == '' && document.getElementById('canva-row') != null) {
      canvas.setWidth(document.getElementById('canva-row').offsetWidth );
    } else {
      canvas.setWidth(itemHandlerWidth);
      canvas.setHeight(itemHandlerHeight);      
    }
  }

  resizeCanvas();
  
  initAligningGuidelines(canvas);
  initCenteringGuidelines(canvas);
  
  canvas.observe('object:modified', function (e) {
    /*** this is for locking the rotate modification of a object selected ***/
    //var activeObject = e.target;
    //activeObject.straighten(45);    
  });

  // load image from menu to canva
  $('.menu img, .menu > img').on('click', function (){
    drawObject(this.src);
  })

  function drawObject(imageSrc) {
    fabric.Image.fromURL(imageSrc, function (oImg) {
      // scale image down before adding it onto canvas
      canvas.add(oImg.set({ left : 110, top: 110}).scale(0.5));
    });
  }

  // save image to png
  $('#saveToPng').on('click', function () {
    //var group = new fabric.Group(canvas.getObjects());
    canvas.setActiveGroup(new fabric.Group(canvas.getObjects())).renderAll();

    var cropZone = canvas.getActiveGroup();
    
    // dont save select helper
    canvas.discardActiveObject().renderAll();
    canvas.discardActiveGroup().renderAll();

    var cropDestination = document.createElement('canvas');
    var context = cropDestination.getContext('2d');
    cropDestination.width = cropZone.width + 60;
    cropDestination.height = cropZone.height + 60;
    
    var cropSourceLeft = cropZone.left - (cropZone.width / 2) - 30;
    var cropSourceTop = cropZone.top - (cropZone.height / 2) - 30;

    if(cropSourceLeft < 0){
      cropSourceLeft = 0;
    }
    if(cropSourceTop < 0){
      cropSourceTop = 0;
    }

    context.drawImage(
      canvas.getElement(),
      cropSourceLeft,
      cropSourceTop,
      cropZone.width + 60,
      cropZone.height + 60,
      0,
      0,
      cropZone.width + 60,
      cropZone.height + 60
    );

    Canvas2Image.saveAsJPEG(cropDestination);
  });

  // delete selected object
  $('#delete').on('click', function () {
    canvas.remove(canvas.getActiveObject());
  });

    // add text to canva
    $('#addText').on('click', function () {
        var text = new fabric.Text($('#canvaText').val(), {left : 210, top: 110});
        canvas.add(text);
    });
    $("#text-bold").click(function() {        
      var activeObject = canvas.getActiveObject();
      if (activeObject && activeObject.type === 'text') {
        activeObject.fontWeight = (activeObject.fontWeight == 'bold' ? '' : 'bold');            
        canvas.renderAll();
      }
    });
  $("#text-italic").click(function() {       
      var activeObject = canvas.getActiveObject();
      if (activeObject && activeObject.type === 'text') {
          activeObject.fontStyle = (activeObject.fontStyle == 'italic' ? '' : 'italic');            
        canvas.renderAll();
      }
    });
  $("#text-strike").click(function() {        
      var activeObject = canvas.getActiveObject();
      if (activeObject && activeObject.type === 'text') {
          activeObject.textDecoration = (activeObject.textDecoration == 'line-through' ? '' : 'line-through');
        canvas.renderAll();
      }
    });
  $("#text-underline").click(function() {         
      var activeObject = canvas.getActiveObject();
      if (activeObject && activeObject.type === 'text') {
          activeObject.textDecoration = (activeObject.textDecoration == 'underline' ? '' : 'underline');
        canvas.renderAll();
      }
    });
  $("#text-left").click(function() {          
      var activeObject = canvas.getActiveObject();
      if (activeObject && activeObject.type === 'text') {
          activeObject.textAlign = 'left';
        canvas.renderAll();
      }
    });
  $("#text-center").click(function() {        
      var activeObject = canvas.getActiveObject();
      if (activeObject && activeObject.type === 'text') {
          activeObject.textAlign = 'center';            
        canvas.renderAll();
      }
    });
  $("#text-right").click(function() {         
      var activeObject = canvas.getActiveObject();
      if (activeObject && activeObject.type === 'text') {
          activeObject.textAlign = 'right';         
        canvas.renderAll();
      }
    });   
  $("#font-family").change(function() {
      var activeObject = canvas.getActiveObject();
      if (activeObject && activeObject.type === 'text') {
        activeObject.fontFamily = this.value;
        canvas.renderAll();
      }
    });   
    $('#text-bgcolor').miniColors({
        change: function(hex, rgb) {
          var activeObject = canvas.getActiveObject();
          if (activeObject && activeObject.type === 'text') {
              activeObject.backgroundColor = this.value;
            canvas.renderAll();
          }
        },
        open: function(hex, rgb) {
            //
        },
        close: function(hex, rgb) {
            //
        }
    });     
    $('#text-fontcolor').miniColors({
        change: function(hex, rgb) {
          var activeObject = canvas.getActiveObject();
          if (activeObject && activeObject.type === 'text') {
              activeObject.fill = this.value;
              canvas.renderAll();
          }
        },
        open: function(hex, rgb) {
            //
        },
        close: function(hex, rgb) {
            //
        }
    });    
    $('#text-strokecolor').miniColors({
        change: function(hex, rgb) {
          var activeObject = canvas.getActiveObject();
          if (activeObject && activeObject.type === 'text') {
              activeObject.strokeStyle = this.value;
              canvas.renderAll();
          }
        },
        open: function(hex, rgb) {
            //
        },
        close: function(hex, rgb) {
            //
        }
    });


    function getRandomNum(min, max) {
        return Math.random() * (max - min) + min;
    }

    function onObjectSelected(e) {  
        var selectedObject = e.target;
        $("#text-string").val("");
        selectedObject.hasRotatingPoint = true
        if (selectedObject && selectedObject.type === 'text') {
            //display text editor           
            $("#texteditor").css('display', 'block');
            $("#text-string").val(selectedObject.getText());            
            $('#text-fontcolor').miniColors('value',selectedObject.fill);
            $('#text-strokecolor').miniColors('value',selectedObject.strokeStyle);  
            $("#imageeditor").css('display', 'block');
        }
        else if (selectedObject && selectedObject.type === 'image'){
            //display image editor
            $("#texteditor").css('display', 'none');    
            $("#imageeditor").css('display', 'block');
    }
    }
    function onSelectedCleared(e){
         $("#texteditor").css('display', 'none');
         $("#text-string").val("");
         $("#imageeditor").css('display', 'none');
    }
    function setFont(font){
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.fontFamily = font;
            canvas.renderAll();
        }
    }
    function removeWhite(){
      var activeObject = canvas.getActiveObject();
      if (activeObject && activeObject.type === 'image') {            
          activeObject.filters[2] =  new fabric.Image.filters.RemoveWhite({hreshold: 100, distance: 10});//0-255, 0-255
          activeObject.applyFilters(canvas.renderAll.bind(canvas));
      }         
    }


  $('#send_image').click(function(e) {
    // Prevent own default clicking
    e.preventDefault();

    // default form var
    var userform = $(this).next('.msg');

    canvas.discardActiveGroup();
    canvas.discardActiveObject();
    canvas.renderAll();
    
      $.ajax({
         url: 'response?type=fabric',
         type: 'POST',
         dataType : 'json', // what type of data do we expect back from the server
         data: {
            data: canvas.toDataURL('image/png'),
            _token: $('meta[name="csrf-token"]').attr('content')
         },
         complete: function(data, status) {
          var msg = $.parseJSON(data.responseText);

            //userform.find('.msg').empty();
            //userform.find('.msg')

            userform.empty();
            userform
            .html('<div class=\"alert alert-danger msg\">'
            +'<button class=\"close\" data-close=\"alert\"></button>'
            +msg.result.text+'</div>');       

            if (msg.result.code === 1) {          
              setTimeout(function() {
                // Do something after 5 seconds
                window.location.href = base_URL + 'gallery';
              }, 2000);
            }

            if(status=='success') {
                alert('saved!');
            }
            // alert('Error has been occurred');
         }
      });
   });

})();


