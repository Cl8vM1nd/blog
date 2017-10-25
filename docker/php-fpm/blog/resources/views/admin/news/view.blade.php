@extends('layouts.admin-base')
@section('content')

<div id="setupNews">
    <div class="newsAction">
        <a href="{{ route('admin::news.index') }}"><img src="/img/back.png" alt="Go back"></a>
    </div>
</div>

<div class="row">

    <div class="col-sm-12 form form-horizontal">
        <div class="form-group">
            <label for="inputTitle"  class="col-xs-2 control-label form-label">Title</label>
            <div class="col-xs-10">
                <input type="text" name="title" class="form-control" id="inputTitle" placeholder="Title" value="{{ $nTitle ?? '' }}" disabled>
            </div>
        </div>

        <div class="form-group">
            <label for="inputContent"  class="col-xs-2 control-label form-label">Content</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="content" id="inputContent" placeholder="Content" rows="5" disabled>{{ $nContent ?? ''}}</textarea>
            </div>
        </div>

    </div>

</div>
@endsection