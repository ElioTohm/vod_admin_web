//ajax request to create add new Movie
$('#btn_addCategory').click(function () 
{
	// if($("form[name=form_addMovie]")[0].checkValidity()) {
	    var datasent =  {
	    	"categorie_name" : $('#categorie_name').val(),
	    };
	    var token = $('meta[name="csrf-token"]').attr('content');
	    $.ajaxSetup({
	      headers: {
	        'X-CSRF-TOKEN': token
	      }
    });
	$.ajax({
        type:'POST',
        url:'categories',
		contentType: "json",
		processData: false,
        data: JSON.stringify(datasent),
        success:function(data){
        	console.log(JSON.stringify(data));
        }
    });
    // }
});

