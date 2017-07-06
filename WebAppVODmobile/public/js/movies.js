$(document).ready(function () {
    //ajax request to create add new Movie
$('#btn_addMovie').click(function () 
{
    $('.loadingif').show();    
    if($("form[name=form_addMovie]")[0].checkValidity()) {
        var datasent =  {
            "custom": false,
            "imdbID" : $('#imdbID').val(),
            "stream" : $('#stream').val().replace(/^.*[\\\/]/, ''),
            "Subtitle": (($('#Subtitle').val() === '') ? null : $('#Subtitle').val().replace(/^.*[\\\/]/, '')),
        };

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'/movies',
            contentType: "json",
            processData: false,
            data: JSON.stringify(datasent),
            success:function(data){
                $('#imdbID').val("");
                $('#stream').val("");
                $('#content').html(data);
                $('.loadingif').hide();
            },
            error:function(data)
            {
                $('.loadingif').hide();
                console.log(data);
                $('#content').html(data['responseText']);   
            }
        });
    }
});

//delete movie
$(document).on('click', 'button.btn-danger[delete="movie"]', function() {
    if (confirm("Are you sure you want to delete!") == true) {
        var id = $(this).attr("imdbID");
        var datasent = {"imdbID" : id};

        $.ajax(
        {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
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
                $('#content').html(data['responseText']); 
            }
        });
    } 

    
});

//add custom movie
$('#btn_addCustomMovie').click(function () 
{
    if($("form[name=form_addCustomMovie]")[0].checkValidity()) {
        $('.loadingif').show();
        var id = $('#Title').val();
        var formdata = new FormData($("form[name=form_addCustomMovie]")[0]);
        var datasent =  {
            "custom": true,
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
            "Subtitle": (($('#Subtitle2').val() === '') ? null : $('#Subtitle2').val().replace(/^.*[\\\/]/, '')),
        };
    
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'/movies',
            contentType: "json",
            processData: false,
            data: JSON.stringify(datasent),
            success:function(data){
                $('#content').html(data);
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
                $('#content').html(data['responseText']);  
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
        "id" : $(this).attr("Movieid"),
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
        "Stream" : $('#Stream').val().replace(/^.*[\\\/]/, ''),
        "Genre" : $(".js-example-basic-multiple").val(),
        "Subtitle": (($('#Subtitle').val() === '') ? (($("#Subname").val() === '' ? null : $("#Subname").val())) : $('#Subtitle').val().replace(/^.*[\\\/]/, '')),
    };

    $.ajax(
    {
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url : "/updatemovies",
        type: "POST",
        contentType: "json",
            processData: false,
        data: JSON.stringify(datasent),
        success:function(data) 
        {
            $('.loadingif').hide();
            $('#content').html(data);
        },
        error:function(data)
        {
            $('.loadingif').hide();
            $('#content').html(data['responseText']);  
        }
    });
});
});
