@extends('layouts.app')

@section('content')

    <div class="container">
        <!--Add Image-->

        <!-- Button trigger modal -->
        @if(Auth::check() && Auth::user()->user_type == 'admin')
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
            Add Photos
            </button>
        @endif

        <!--Add Image Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{$albums->name}}'s Album</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                
                <form method="POST" action="{{route('album.image')}}" enctype="multipart/form-data" id="form">
                    @csrf
                        <div class="form-group">
                            <input type="hidden" name="id" value="{{$albums->id}}" class="form-control">
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
        <!--Add Image Modal Ends Here-->

        <a href="\">
            <button type="button" class="btn btn-success" style="float: right;">Go to Album</button>
        </a>


        @if(Session::has('message'))
            <div class="alert alert-success">{{Session::get('message')}}</div>
        @endif
        <h2 class="text-center">{{$albums->name}}({{$albums->images->count()}})</h2>
        <div class="row">
            @foreach($albums->images as $image)
            <div class="col-sm-4">
                <div class="item">
                    <img src="{{asset('storage/'.$image->name)}}" class="img-thumbnail" style="width: 300px; height: 200px;">
                </div>

                <!-- Button trigger modal -->
                @if(Auth::check() && Auth::user()->user_type == 'admin')
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{$image->id}}">
                     Delete
                    </button>
                @endif

                <!-- Modal -->
                <div class="modal fade" id="exampleModal{{$image->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">

                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <div class="modal-body">
                        Do you Really want to Delete?
                      </div>

                      <div class="modal-footer">
                        <form method="POST" action="{{route('image.delete')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$image->id}}">
                            <button class="btn btn-danger" type="submit">Delete</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </form>
                      </div>

                    </div>
                  </div>
                </div>
                <!--Modal Ends-->



            </div>
            @endforeach
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

<style type="text/css">
    .item{
        left: 0;
        top: 0;
        position: relative;
        overflow: hidden;
        margin-top: 50px;
    }

    .item img{
        transition: 0.6s ease;
        -webkit-transition: 0.6s ease;
    }

    .item img:hover{
        transform: scale(1.2);
        -webkit-transform: scale(1.2);
    }
    
    .centered{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        color: #fff;
        font-size: 24px;
    }

    .img-thumbnail{
        border-radius: 0px;
        border: 0px;
    }

</style>