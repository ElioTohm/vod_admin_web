
//ajax request to create add new Serie
$('#btn_addSerie').click(function () 
{
	// if($("form[name=form_addSerie]")[0].checkValidity()) {
	    var datasent =  {
	    	"imdbID" : $('#imdbID').val(),
	    };
	    var token = $('meta[name="csrf-token"]').attr('content');
	    $.ajaxSetup({
	      headers: {
	        'X-CSRF-TOKEN': token
	      }
    });
    
	$.ajax({
        type:'POST',
        url:'series',
		contentType: "json",
		processData: false,
        data: JSON.stringify(datasent),
        success:function(data){
        	$('#imdbID').val("");
        	$('#serie_list_div').html(data);
        }
    });
    // }
});

//delete serie
$(document).on('click', 'button.btn-danger[delete="serie"]', function() {
	var id = $(this).attr("imdbID");
	var datasent = {"imdbID" : id};
	var token = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': token
      }
    });

	$.ajax(
    {
        url : "series",
        type: "DELETE",
        contentType: "json",
			processData: false,
        data: JSON.stringify(datasent),
        success:function(data) 
        {
            $('div[imdbID='+ id +']').remove();
        }
    });
});