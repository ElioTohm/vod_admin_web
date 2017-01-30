
//ajax request to create add new Episode
$('#btn_addEpisode').click(function () 
{
    // if($("form[name=form_addepisode]")[0].checkValidity()) {
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
        }
    });
    // }
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
        }
    });
});