
//ajax request to create add new Serie
$('#btn_addSerie').click(function () 
{
	if($("form[name=form_addSerie]")[0].checkValidity()) {
        $('.loadingif').show();
	    var datasent =  {
            "custom": false,
	    	"imdbID" : $('#imdbID').val(),
            "storage": $('#storage').val(),
	    };
        
    	$.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'/series',
    		contentType: "json",
    		processData: false,
            data: JSON.stringify(datasent),
            success:function(data){
            	$('#serie_list_div').html(data);
                $('.loadingif').hide();
            },
            error:function(data)
            {
                $('.loadingif').hide();
                $('#serie_list_div').html(data['responseText']);   
            }
        });
    }
});

//delete serie
$(document).on('click', 'button.btn-danger[delete="serie"]', function() {
    if (confirm("Are you sure you want to delete!") == true) {
    	var id = $(this).attr("imdbID");
    	var datasent = {"imdbID" : id};

    	$.ajax(
        {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "series",
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
                $('#serie_list_div').html(data['responseText']);     
            }
        });
    }
});

//add custom serie
$('#btn_addCustomSerie').click(function () 
{
    
    if($("form[name=form_addCustomSerie]")[0].checkValidity()) {
        $('.loadingif').show();
        var datasent =  {
            "custom": true,
            "Title" : $('#Title').val(),
            "storage": $('#storage').val(),
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
            "totalSeasons" : (($('#totalSeasons').val() === '') ? 1 : $('#totalSeasons').val()),
        };
    
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'/series',
            contentType: "json",
            processData: false,
            data: JSON.stringify(datasent),
            success:function(data){
                console.log(data);
                $('#serie_list_div').html(data);
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
                $('#serie_list_div').html(data['responseText']);   
            }
        });
    } else {
        alert("Please fill all info");
    }
});