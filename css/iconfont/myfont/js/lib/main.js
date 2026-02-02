
$(document).ready(function(){

    $('.selectpicker').selectpicker();    

    val = $('.selectpicker option:selected').val();
    $('.all-icons i').css( "font-size", val + "px" );
    $('#content').removeClass().addClass("size"+val);

    $('.selectpicker').change(function(){
        val = $('.selectpicker option:selected').val();
		if(val == 'free') {
			$('.all-icons i').removeAttr( 'style');
		} else {
			$('.all-icons i').css( "font-size", val + "px" );
		}

    });

    $('#s1').change(function() {
       if($(this).is(":checked")) {
          $('body').addClass("dark");
          return;
       }
      $('body').removeClass("dark");
    });

}) // Ready








