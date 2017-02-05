//ajax request to create add new Movie
$('#btn_addMovie').click(function () 
{
    $('.loadingif').show();    
	if($("form[name=form_addMovie]")[0].checkValidity()) {
	    var datasent =  {
	    	"imdbID" : $('#imdbID').val(),
	    	"stream" : $('#stream').val().replace(/^.*[\\\/]/, ''),
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
            },
            error:function(data)
            {
                $('.loadingif').hide();
                console.log(data);
                $('#movie_list_div').html(data['responseText']);   
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
        },
        error:function(data)
        {
            $('.loadingif').hide();
            console.log(data);
            $('#movie_list_div').html(data['responseText']); 
        }
    });
});

//add custom movie
$('#btn_addCustomMovie').click(function () 
{
    if($("form[name=form_addCustomMovie]")[0].checkValidity()) {
        $('.loadingif').show();
        var id = $('#Title').val();
        var formdata = new FormData($("form[name=form_addCustomMovie]")[0]);
        var datasent =  {
            "Title" : $('#Title').val(),
            "Year" : (($('#Year').val() === '') ? 'N/A' : $('#Year').val()),
            "Rated" : (($('#Ratings').val() === '') ? 'N/A' : $('#Ratings').val()),
            "Released" : (($('#Released').val() === '') ? new Date().toJSON().slice(0,10).replace(/-/g,'-') : $('#Released').val()),
            "Runtime" : (($('#Runtime').val() === '') ? 'N/A' : $('#Runtime').val()),
            "Director" : (($('#Director').val() === '') ? 'N/A' : $('#Director').val()),
            "Writer" : (($('#Writer').val() === '') ? 'N/A' : $('#Writer').val()),
            "Actors" : (($('#Actors').val() === '') ? 'N/A' : $('#Actors').val()),
            "Plot" : (($('#Plot').val() === '') ? 'N/A' : $('#Plot').val()),
            "Language" : (($('#Language').val() === '') ? 'N/A' : $('#Language').val()),
            "Country" : (($('#Country').val() === '') ? 'N/A' : $('#Country').val()),
            "Awards" : (($('#Awards').val() === '') ? 'N/A' : $('#Awards').val()),
            "Poster" : (($('#Poster').val() === '') ? 'N/A' : $('#Poster').val()),
            "Stream" : $('#Stream').val().replace(/^.*[\\\/]/, ''),
        };
        console.log(formdata);
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

            },
            error:function(data)
            {
                $('.loadingif').hide();
                console.log(data);
                $('#movie_list_div').html(data['responseText']);  
            }
        });
    } else {
        alert("Please fill all info");
    }
});


//update movie
$(document).on('click', '#updatemovie_btn', function() {
    $('.loadingif').show();
    var id = $(this).attr("imdbID");
    var datasent =  {
            "originalID" : id,
            "Title" : $('#Title').val(),
            "imdbID" : $('#ID').val(),
            "Year" : (($('#Year').val() === '') ? 'N/A' : $('#Year').val()),
            "Rated" : (($('#Ratings').val() === '') ? 'N/A' : $('#Ratings').val()),
            "Released" : (($('#Released').val() === '') ? new Date().toJSON().slice(0,10).replace(/-/g,'-') : $('#Released').val()),
            "Runtime" : (($('#Runtime').val() === '') ? 'N/A' : $('#Runtime').val()),
            "Director" : (($('#Director').val() === '') ? 'N/A' : $('#Director').val()),
            "Writer" : (($('#Writer').val() === '') ? 'N/A' : $('#Writer').val()),
            "Actors" : (($('#Actors').val() === '') ? 'N/A' : $('#Actors').val()),
            "Plot" : (($('#Plot').val() === '') ? 'N/A' : $('#Plot').val()),
            "Language" : (($('#Language').val() === '') ? 'N/A' : $('#Language').val()),
            "Country" : (($('#Country').val() === '') ? 'N/A' : $('#Country').val()),
            "Awards" : (($('#Awards').val() === '') ? 'N/A' : $('#Awards').val()),
            "Poster" : (($('#Poster').val() === '') ? 0 : $('#Poster').val()),
            "Stream" : $('#Stream').val(),
        };
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': token
      }
    });

    $.ajax(
    {
        url : "/updatemovies",
        type: "POST",
        contentType: "json",
            processData: false,
        data: JSON.stringify(datasent),
        success:function(data) 
        {
            $('.loadingif').hide();
            $('#moviedetail_div').html(data);
        },
        error:function(data)
        {
            $('.loadingif').hide();
            $('#movie_list_div').html(data['responseText']);  
        }
    });
});