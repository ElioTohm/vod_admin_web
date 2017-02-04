
//ajax request to create add new Episode
$('#btn_addEpisode').click(function () 
{
    if($("form[name=form_addepisode]")[0].checkValidity()) {
        $('.loadingif').show();
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
            url:'/episodes',
            contentType: "json",
            processData: false,
            data: JSON.stringify(datasent),
            success:function(data){
                $('#imdbID').val("");
                $('#stream').val("");
                $('#episode_list_div').html(data);
                $('.loadingif').hide();
            }
        });
    }
});

//delete episode
$(document).on('click', 'button.btn-danger[delete="episode"]', function() {
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
        
    });
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
            "Director" : (($('#episodeDirector').val() === '') ? 'N/A' : $('#episodeDirector').val()),
            "Writer" : (($('#episodeWriter').val() === '') ? 'N/A' : $('#episodeWriter').val()),
            "Actors" : (($('#episodeActors').val() === '') ? 'N/A' : $('#episodeActors').val()),
            "Plot" : (($('#episodePlot').val() === '') ? 'N/A' : $('#episodePlot').val()),
            "Language" : (($('#episodeLanguage').val() === '') ? 'N/A' : $('#episodeLanguage').val()),
            "Country" : (($('#episodeCountry').val() === '') ? 'N/A' : $('#episodeCountry').val()),
            "Awards" : (($('#episodeAwards').val() === '') ? 'N/A' : $('#episodeAwards').val()),
            "Poster" : (($('#episodePoster').val() === '') ? 'N/A' : $('#episodePoster').val()),
            "seriesID" : $('#btn_addCustomEpisode').attr('seriesid'),
            "Episode" : (($('#episodeEpisode').val() === '') ? 'N/A' : $('#episodeEpisode').val()),
            "Season" : (($('#episodeSeason').val() === '') ? 'N/A' : $('#episodeSeason').val()),
            "Stream" : $('#episodeStream').val(),
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
                console.log(data);
                $('#episode_list_div').html(data);
            }
        });
    } else {
        alert("Please fill all info");
    }
});


//update movie
$(document).on('click', '#updateserie_btn', function() {
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
            "totalSeasons" : (($('#totalSeasons').val() === '') ? 1 : $('#totalSeasons').val()),
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
            $('#episode_list_div').html(data);
        }
    });
});