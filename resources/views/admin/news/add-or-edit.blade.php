@extends('layouts.admin-base')
@section('content')

<div id="setupNews">
    <div class="newsAction">
        <a href="{{ route('admin::news.index') }}"><img src="/img/back.png" alt="Go back"></a>
    </div>
</div>

<div id="animatedModal">
    <!--THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID  class="close-animatedModal" -->
    <div class="close-animatedModal">
        CLOSE MODAL
    </div>

    <div class="modal-content">
        <!--Your modal content goes here-->
    </div>
</div>

<div class="row">
    {{ Form::open(array('route' => $action, 'method' => 'post', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')) }}

    <div class="col-sm-8 col-sm-offset-2 form">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($nId))
            <input type="hidden" name="id" id="newsId" value="{{ $nId }}">
        @endif

        <div class="form-group">
            <label for="inputTitle"  class="col-sm-2 control-label form-label">Title</label>
            <div class="col-sm-10">
                <input type="text" name="title" class="form-control" id="inputTitle" placeholder="Title" value="{{ $nTitle ?? '' }}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputImage"  class="col-sm-2 control-label form-label">Main image</label>
            <div class="col-sm-5">
                <input type="file" name="image" class="form-control" id="inputImage" placeholder="Image" >
            </div>
            <div class="col-sm-5">
                <input type="text" name="imageTitle" class="form-control" id="inputTitle" placeholder="imageTitle" value="{{ $nImageTitle?? '' }}">
            </div>
        </div>

        <div class="form-group">
            <label for="text-editor-content"  class="col-sm-2 control-label form-label">Content</label>
            <div class="col-sm-10">
                {{--EDITOR--}}
                <button type="button" class="text-editor-button" id="text-editor-b">B</button>
                <button type="button" class="text-editor-button" id="text-editor-i">I</button>
                <button type="button" class="text-editor-button" id="text-editor-u">U</button>
                <a id="demo01" href="#animatedModal"><button type="button" class="text-editor-button" id="text-editor-img">img</button></a>
                <textarea class="form-control" name="content" id="text-editor-content" placeholder="Content" rows="15" >{{ $nContent ?? ''}}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="text-editor-tags"  class="col-sm-2 control-label form-label">Tags</label>
            <div class="col-sm-10">
                <input type="text" name="tags" class="form-control" id="inputTags" value="{{ $nTags ?? '' }}" data-role="tagsinput">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-1 col-sm-offset-2 submit-button">
                {{ Form::submit($nButton ?? 'Add News!', ['class' => 'btn btn-success news-button'])  }}
            </div>
        </div>

    </div>

    {{ Form::close() }}
</div>
@endsection