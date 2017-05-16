var clipobject;

//delete clip
$(document).on('click', 'button.btn-danger[delete="clip"]', function() {
    if (confirm("Are you sure you want to delete!") == true) {
        var id = $(this).attr("id");
        var datasent = {"id" : id};
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': token
          }
        });

        $.ajax(
        {
            url : "/clips",
            type: "DELETE",
            contentType: "json",
                processData: false,
            data: JSON.stringify(datasent),
            success:function(data) 
            {
                $('tr[id='+ id +']').remove();
            },
            error:function(data)
            {
                $('.loadingif').hide();
                $('#clip_list_div').html(data['responseText']); 
            }
        });
    } 

    
});

//add custom clip
$('#btn_addCustomClip').click(function () 
{
    var artist_id = $(this).attr('artist_id');

    if($("form[name=form_addCustomClip]")[0].checkValidity()) {
        $('.loadingif').show();
        var datasent =  {
            "Title" : $('#Title').val(),
            "Stream" : $('#uniStream').val().replace(/^.*[\\\/]/, ''),
            "Subtitle": (($('#Subtitle2').val() === '') ? null : $('#Subtitle2').val().replace(/^.*[\\\/]/, '')),
            "Artist_id": artist_id,
        };
        var token = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': token
            },
            type:'POST',
            url:'/clips',
            contentType: "json",
            processData: false,
            data: JSON.stringify(datasent),
            success:function(data){
                $('#clip_list_div').html(data);
                $('#Title').val("");
                $('#ID').val("");
                $('#Stream').val("");
                $('.loadingif').hide();

            },
            error:function(data)
            {
                $('.loadingif').hide();
                console.log(data);
                $('#clip_list_div').html(data['responseText']);  
            }
        });
    } else {
        alert("Please fill all info");
    }
});

$(document).on('click', '[update="clip"]', function() {
    var id = $(this).attr("id");
    var datasent =  {"id" : id};
    $.ajax(
    {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : "/clip",
        type: "POST",
        contentType: "json",
        processData: false,
        data: JSON.stringify(datasent),
        success:function(data) 
        {
            console.log(data);

            $('.loadingif').hide();
            $('#Titleupdate').val(data.clip.Title);
            $('#Streamupdatetxt').val(data.clip.stream);
            $('#Subtitle2updatetxt').val(data.clip.Subtitle);

            $('#multiselectupdate').val(data.genres);
            $('.select2-selection__rendered').html('');
            clipobject = data.clip;
        },
        error:function(data)
        {
            $('.loadingif').hide();
            $('#clip_list_div').html(data['responseText']);  
        }
    });
});

$(document).on('click', '#btn_UpdateCustomClip', function() {
    
    console.log($('#multiselectupdate').val());
    var artist_id = $(this).attr('artist_id')
    var datasent =  {
            'id' : clipobject.id,
            'Title' : (($('#Titleupdate').val() === '') ? null : $('#Titleupdate').val()),
            'Stream' : (($('#Streamupdate').val() === '') ? null : $('#Streamupdate').val().replace(/^.*[\\\/]/, '')),
            'Subtitle' : (($('#Subtitle2update').val() === '') ? $('#Subtitle2updatetxt').val() : $('#Subtitle2update').val().replace(/^.*[\\\/]/, '')),
            'Artist_id': artist_id, 
        };

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : "/clipsudpate",
        type: "POST",
        contentType: "json",
        processData: false,
        data: JSON.stringify(datasent),
        success:function(data) 
        {
            $('#clip_list_div').html(data);
        },
        error:function(data)
        {
            $('.loadingif').hide();
            $('#clip_list_div').html(data['responseText']);  
        }
    });
});

//add multiple clips
$('#btn_UpdateMultiClip').click(function () 
{
    var artist_id = $(this).attr('artist_id');

    if($("form[name=form_AddClip_Multiple]")[0].checkValidity()) {
        $('.loadingif').show();
        var file_names = [];

        $.each($('#MultiStream').prop("files"), function(k,v){
            file_names.push(v['name']);

        });
        console.log(datasent);

        var datasent =  {
            "Stream" : file_names,
            "Artist_id": artist_id,
        };
        console.log(datasent);
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'/multiclips',
            contentType: "json",
            processData: false,
            data: JSON.stringify(datasent),
            success:function(data){
                $('#clip_list_div').html(data);
                $('#Title').val("");
                $('#ID').val("");
                $('#Stream').val("");
                $('.loadingif').hide();

            },
            error:function(data)
            {
                $('.loadingif').hide();
                console.log(data);
                $('#clip_list_div').html(data['responseText']);  
            }
        });
    } else {
        alert("Please fill all info");
    }
});


$(".js-example-basic-multiple").select2();



