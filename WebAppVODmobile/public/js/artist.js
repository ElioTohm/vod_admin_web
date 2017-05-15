var artist_id = null;
$('#AddArtist_btn').click(function () 
{
    $('.loadingif').show();
    var datasent =  {
            "artist_name": $("#Artist_Name").val(),
            "artist_image": $("#Artist_Image").val().replace(/^.*[\\\/]/, '')
        };

    $.ajax(
    {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : "/artists",
        type: "POST",
        contentType: "json",
        processData: false,
        data: JSON.stringify(datasent),
        success:function(data) 
        {
            $('.loadingif').hide();
            $("#Artist_Name").val("");
            $('#content').html(data);
        },
        error:function(data)
        {
            $('#content').html(data['responseText']);  
        }
    });
});

$(document).on('click', '.btn-danger', function() {
    if (confirm("Are you sure you want to delete!") == true) {
        $('.loadingif').show();
        var id = $(this).attr('id');
        var datasent =  {
                "artist_id" : id,
            };

        $.ajax(
        {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "/artists",
            type: "DELETE",
            contentType: "json",
            processData: false,
            data: JSON.stringify(datasent),
            success:function(data) 
            {
                $('.loadingif').hide();
                $('div[id='+ id + ']').remove();
            },
            error:function(data)
            {
                $('#artist_div').html(data['responseText']);  
            }
        });
    }
});
$(document).on('click', '.btn-primary', function(){
    artist_id = $(this).attr('id');
});
$('#UpdateArtist_btn').click(function()
{   
    $('.loadingif').show();
    var datasent =  {
            "artist_name": $("#Update_Artist_Name").val(),
            "artist_image": $("#Update_Artist_Image").val().replace(/^.*[\\\/]/, ''),
            "artist_id": artist_id
        };
    $.ajax(
    {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : "/artistsupate",
        type: "POST",
        contentType: "json",
        processData: false,
        data: JSON.stringify(datasent),
        success:function(data) 
        {
            $('.loadingif').hide();
            $("#Update_Artist_Name").val("");
            $("#Update_Artist_Image").val("");
            $('#content').html(data);
        },
        error:function(data)
        {
            $('#content').html(data['responseText']);  
        }
    });
});