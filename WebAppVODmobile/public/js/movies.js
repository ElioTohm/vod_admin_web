
//ajax request to create add new Movie
$('#btn_addMovie').click(function () 
{
    $('.loadingif').show();    
	if($("form[name=form_addMovie]")[0].checkValidity()) {
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
            url:'/movies',
        	contentType: "json",
        	processData: false,
            data: JSON.stringify(datasent),
            success:function(data){
            	$('#imdbID').val("");
            	$('#stream').val("");
            	$('#movie_list_div').html(data);
                $('.loadingif').hide();
            }
        });
    }
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
        url : "/movies",
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

//add custom movie
btn_addCustomMovie
$('#btn_addCustomMovie').click(function () 
{
    $('.loadingif').show();
    if($("form[name=form_addCustomMovie]")[0].checkValidity()) {
        var datasent =  {
            "Title" : $('#Title').val(),
            "imdbID" : $('#ID').val(),
            "Year" : (($('#Year').val() === '') ? 0 : $('#Year').val()),
            "Rated" : (($('#Ratings').val() === '') ? 0 : $('#Ratings').val()),
            "Released" : (($('#Released').val() === '') ? new Date().toJSON().slice(0,10).replace(/-/g,'-') : $('#Released').val()),
            "Runtime" : (($('#Runtime').val() === '') ? 0 : $('#Runtime').val()),
            "Director" : (($('#Director').val() === '') ? 0 : $('#Director').val()),
            "Writer" : (($('#Writer').val() === '') ? 0 : $('#Writer').val()),
            "Actors" : (($('#Actors').val() === '') ? 0 : $('#Actors').val()),
            "Plot" : (($('#Plot').val() === '') ? 0 : $('#Plot').val()),
            "Language" : (($('#Language').val() === '') ? 0 : $('#Language').val()),
            "Country" : (($('#Country').val() === '') ? 0 : $('#Country').val()),
            "Awards" : (($('#Awards').val() === '') ? 0 : $('#Awards').val()),
            "Poster" : (($('#Poster').val() === '') ? 0 : $('#Poster').val()),
            "Stream" : $('#Stream').val(),
        };
        console.log(datasent);
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': token
          }
        });
    
        $.ajax({
            type:'POST',
            url:'/custommovies',
            contentType: "json",
            processData: false,
            data: JSON.stringify(datasent),
            success:function(data){
                console.log(data);
                $('#movie_list_div').html(data);
                $('#Title').val("");
                $('#ID').val("");
                $('#Year').val("");
                $('#Ratings').val("");
                $('#Released').val("");
                $('#Runtime').val("");
                $('#Director').val("");
                $('#Writer').val("");
                $('#Actors').val("");
                $('#Plot').val("");
                $('#Language').val("");
                $('#Country').val("");
                $('#Awards').val("");
                $('#Poster').val("");
                $('#Stream').val("");
                $('.loadingif').hide();

            }
        });
    } else {
        alert("Please fill all info");
    }
});
