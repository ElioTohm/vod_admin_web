
//activate client
$(document).on('click', 'button.btn-primary[activate="client"]', function() {
    var id = $(this).attr("clientid");
    var datasent = {"clientID" : id};
    var token = $('meta[name="csrf-token"]').attr('content');
    console.log(token);
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': token
      }
    });

    $.ajax(
    {
        url : "clients",
        type: "POST",
        contentType: "json",
            processData: false,
        data: JSON.stringify(datasent),
        success:function(data) 
        {
            // $('div[imdbID='+ id +']').remove();
        }
    });
});

//delete client
$(document).on('click', 'button.btn-danger[delete="client"]', function() {
	var id = $(this).attr("clientid");
	var datasent = {"clientID" : id};
	var token = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': token
      }
    });

	$.ajax(
    {
        url : "clients",
        type: "DELETE",
        contentType: "json",
			processData: false,
        data: JSON.stringify(datasent),
        success:function(data) 
        {
            $('div[clientid='+ id +']').remove();
        }
    });
});