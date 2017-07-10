$('#AddGenre_btn').click(function () 
{
    $('.loadingif').show();
    var datasent =  {
            "genre_name" : $("#Genre_Name").val(),
        };
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': token
      }
    });

    $.ajax(
    {
        url : "/genres",
        type: "POST",
        contentType: "json",
        processData: false,
        data: JSON.stringify(datasent),
        success:function(data) 
        {
            $('.loadingif').hide();
            $("#Genre_Name").val("");
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
                "genre_id" : id,
            };
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': token
          }
        });

        $.ajax(
        {
            url : "/genres",
            type: "DELETE",
            contentType: "json",
            processData: false,
            data: JSON.stringify(datasent),
            success:function(data) 
            {
                $('.loadingif').hide();
                $('a[id='+ id + ']').remove();
            },
            error:function(data)
            {
                $('#content').html(data['responseText']);  
            }
        });
    }
});
