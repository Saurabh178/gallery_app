@extends('layouts.app')

@section('content')
<div class="container">
        <a href="\" style="float: right;">Go to Album</a>

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="show"></div>
    
            <div class="card">

                <div id="errMsg"></div>

                <div class="card-body">

                <form method="POST" action="{{route('album.store')}}" enctype="multipart/form-data" id="form">
                    @csrf
                        <div class="form-group">
                            <label>Name of Album:</label>
                            <input type="text" name="album" class="form-control">
                        </div>

                        <div class="input-group control-group initial-add-more">
                            <input type="file" name="image[]" class="form-control" id="image">
                            <div class="input-group-btn">
                                <button class="btn btn-success btn-add-more" type="button">Add More</button>
                            </div>
                        </div>

                        <div class="copy" style="display: none;">
                            <div class="input-group control-group add-more" style="margin-top: 10px">
                                <input type="file" name="image[]" class="form-control" id="image">
                                <div class="input-group-btn">
                                    <button class="btn btn-danger remove" type="button">Remove</button>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<script type="text/javascript">
    
    $(document).ready(function(e){
        $('.btn-add-more').click(function(){
            var html = $('.copy').html();
            $('.initial-add-more').after(html);
        })

        $('body').on('click', '.remove', function(){
            $(this).parents('.control-group').remove();
        })

    });

</script>

<script type="text/javascript">
    
    $(document).ready(function(){
        $('#form').on('submit', (function(e){
            e.preventDefault();

        $.ajax({
            url: "/album",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,

            success: function(response){
                $('.show').html(response);
                $('#form')[0].reset();
                $('#errMsg').empty();
            },

            error: function(data){
                //console.log(data.responseJSON);
                $('#errMsg').empty();
                var error = data.responseJSON;
                $.each(error.errors, function(key, value){
                    $('#errMsg').append("<p class='text-center text-danger'>" + value + "</p>");
                });
            }
        });

        }));
    });

</script>
