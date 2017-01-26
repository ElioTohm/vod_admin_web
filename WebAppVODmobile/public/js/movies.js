
//ajax request to create add new Movie
$('#btn_addMovie').click(function () 
{
	// if($("form[name=form_addMovie]")[0].checkValidity()) {
	    var datasent =  {
	    	"imdbID" : $('#imdbID').val(),
	    	"stream" : $('#stream').val(),
	    };
	    var token = $('meta[name="csrf-token"]').attr('content');
	    $.ajaxSetup({
	      headers: {
	        'X-CSRF-TOKEN': token
	      }
    });
    
	$.ajax({
        type:'POST',
        url:'movies',
		contentType: "json",
		processData: false,
        data: JSON.stringify(datasent),
        success:function(data){
        	$('#imdbID').val("");
	    	$('#stream').val("");
        	$('#movie_list_div').html(data);
        }
    });
    // }
});

//delete movie
$(document).on('click', 'button.btn-danger[delete="movie"]', function() {
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
        url : "movies",
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