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
                $('div[id='+ id +']').remove();
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
    if($("form[name=form_addCustomClip]")[0].checkValidity()) {
        $('.loadingif').show();
        
        var id = $('#Title').val();
        var datasent =  {
            "Title" : $('#Title').val(),
            "Poster" : (($('#Poster').val() === '') ? 'N/A' : $('#Poster').val().replace(/^.*[\\\/]/, '')),
            "Stream" : $('#Stream').val().replace(/^.*[\\\/]/, ''),
            "Genre" : $("#addgenre").val(),
            "Subtitle": (($('#Subtitle2').val() === '') ? null : $('#Subtitle2').val().replace(/^.*[\\\/]/, '')),
        };
        console.log(datasent);
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
            var poster = data.clip.Poster.split('/');
            if (poster[poster.length - 1] !== 'A') {
                poster = poster[poster.length - 1];
            } else {
                poster = "";
            }

            $('.loadingif').hide();
            $('#Titleupdate').val(data.clip.Title);
            $('#Posterupdatetxt').val(poster);
            $('#Streamupdatetxt').val(data.clip.stream);
            $('#Subtitle2updatetxt').val(data.clip.Subtitle);

            $('#multiselectupdate').val(data.genres);
            $('.select2-selection__rendered').html('');
            for (var i = 0; i < data.genres.length; i++) {
                $('.select2-selection__rendered').append('<li class="select2-selection__choice" title="Action"><span class="select2-selection__choice__remove" role="presentation">×</span>'+data.genres[i]+'</li>');
            }
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

    var datasent =  {
            'id' : clipobject.id,
            'Title' : (($('#Titleupdate').val() === '') ? null : $('#Titleupdate').val()),
            'Poster' : (($('#Posterupdate').val() === '') ? $('#Posterupdatetxt').val() : $('#Posterupdate').val().replace(/^.*[\\\/]/, '')),
            'Stream' : (($('#Streamupdate').val() === '') ? null : $('#Streamupdate').val()),
            'Subtitle' : (($('#Subtitle2update').val() === '') ? $('#Subtitle2updatetxt').val() : $('#Subtitle2update').val().replace(/^.*[\\\/]/, '')),
            'Genre' : $('#multiselectupdate').val(),
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



$(".js-example-basic-multiple").select2();



