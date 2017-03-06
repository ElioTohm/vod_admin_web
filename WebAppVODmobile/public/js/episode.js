
//ajax request to create add new Episode
$('#btn_addEpisode').click(function () 
{
    if($("form[name=form_addepisode]")[0].checkValidity()) {
        $('.loadingif').show();
        var datasent =  {
            "imdbID" : $('#imdbID').val(),
            "stream" : $('#stream').val().replace(/^.*[\\\/]/, ''),
            "Subtitle" : $('#Subtitle').val().replace(/^.*[\\\/]/, ''),
            "seriesID" : $('#updateserie_btn').attr('serieID'),
        };
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': token
          }
        });
        
        $.ajax({
            type:'POST',
            url:'/episodes',
            contentType: "json",
            processData: false,
            data: JSON.stringify(datasent),
            success:function(data){
                $('#imdbID').val("");
                $('#stream').val("");
                $('#episode_list_div').html(data);
                $('.loadingif').hide();
            },
            error:function(data) {
                $('.loadingif').hide();
                $('#episode_list_div').html(data['responseText']);
            },
        });
    }
});

//delete episode
$(document).on('click', 'button.btn-danger[delete="episode"]', function() {
    if (confirm("Are you sure you want to delete!") == true) {
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
            url : "/episodes",
            type: "DELETE",
            contentType: "json",
            processData: false,
            data: JSON.stringify(datasent),
            success:function(data) 
            {
                $('div[imdbID='+ id +']').remove();
            },
            error:function(data) {
                $('.loadingif').hide();
                $('#episode_list_div').html(data['responseText']);
            },
            
        });
    }
});


//add custom episodes
$('#btn_addCustomEpisode').click(function () 
{
    if($("form[name=form_addCustomEpisode]")[0].checkValidity()) {
        $('.loadingif').show();
        var datasent =  {
            "Title" : $('#episodeTitle').val(),
            "imdbID" : $('#episodeID').val(),
            "Year" : (($('#episodeYear').val() === '') ? new Date().getYear() : $('#episodeYear').val()),
            "Rated" : (($('#episodeRatings').val() === '') ? 'N/A' : $('#episodeRatings').val()),
            "Released" : (($('#episodeReleased').val() === '') ? new Date().toJSON().slice(0,10).replace(/-/g,'-') : $('#episodeReleased').val()),
            "Runtime" : (($('#episodeRuntime').val() === '') ? 'N/A' : $('#episodeRuntime').val()),
            "Director" : 'N/A',
            "Writer" : 'N/A',
            "Actors" : 'N/A',
            "Plot" : 'N/A',
            "Language" : 'N/A',
            "Country" : 'N/A',
            "Awards" : 'N/A',
            "Poster" : (($('#episodePoster').val() === '') ? 'N/A' : $('#episodePoster').val()),
            "seriesID" : $('#btn_addCustomEpisode').attr('seriesid'),
            "Episode" : (($('#episodeEpisode').val() === '') ? 'N/A' : $('#episodeEpisode').val()),
            "Season" : (($('#episodeSeason').val() === '') ? 'N/A' : $('#episodeSeason').val()),
            "Stream" : $('#episodeStream').val().replace(/^.*[\\\/]/, ''),
            "Subtitle" : (($('#Subtitle2').val() === '') ? 'N/A' : $('#Subtitle2').val().replace(/^.*[\\\/]/, '')),
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
            url:'/customepisodes',
            contentType: "json",
            processData: false,
            data: JSON.stringify(datasent),
            success:function(data){
                $('.loadingif').hide();
                $('#episode_list_div').html(data);
            },
            error:function(data) {
                $('.loadingif').hide();
                $('#episode_list_div').html(data['responseText']);
            },
        });
    } else {
        alert("Please fill all info");
    }
});


// Update a serie
$(document).on('click', '#updateserie_btn', function() {
    $('.loadingif').show();
    var id = $(this).attr("serieID");
    var datasent =  {
            "id" : id,
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
            "Poster" : (($('#Poster').val() === '') ? 0 : $('#Poster').val()),
            "totalSeasons" : (($('#totalSeasons').val() === '') ? 1 : $('#totalSeasons').val()),
            "Genre" : $(".js-example-basic-multiple").val(),
        };
        console.log(datasent);
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': token
      }
    });

    $.ajax(
    {
        url : "/updateseries",
        type: "POST",
        contentType: "json",
        processData: false,
        data: JSON.stringify(datasent),
        success:function(data) 
        {
            $('.loadingif').hide();
            console.log(datasent);
            $('#episode_list_div').html(data);
        },
        error:function(data) 
        {
            $('.loadingif').hide();
            $('#episode_list_div').html(data['responseText']);
        },
    });
});


//update a episode
$(document).on('click', '.updateepisode', function() {
    $('.loadingif').show();
    console.log($('#Stream[imdbID='+$(this).attr("imdbID")+']').val());
    var datasent =  {
            "seriesID" : $(this).attr("seriesID"),
            "Title" : $(this).attr("Title"),
            "imdbID" : $(this).attr("imdbID"),
            "Stream" : (($('#Stream[imdbID='+$(this).attr("imdbID")+']').val() === '') ? (($("#Streamtext").val() === '' ? null : $("#Streamtext").val())) : $('#Stream[imdbID='+$(this).attr("imdbID")+']').val().replace(/^.*[\\\/]/, '')),
            "Subtitle": (($('#Subtitle').val() === '') ? (($("#Subname").val() === '' ? null : $("#Subname").val())) : $('#Subtitle').val().replace(/^.*[\\\/]/, '')),
        };
    console.log(datasent);
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': token
      }
    });

    $.ajax(
    {
        url : "/updateepisodes",
        type: "POST",
        contentType: "json",
        processData: false,
        data: JSON.stringify(datasent),
        success:function(data) 
        {
            $('.loadingif').hide();
            $('#episode_list_div').html(data);
        },
        error:function(data) 
        {
            $('.loadingif').hide();
            $('#episode_list_div').html(data['responseText']);
        },
    });
});