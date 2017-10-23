@extends('layouts.admin-base')
@section('content')
@inject('tags', 'App\Services\TagsService')
@inject('file', 'App\Services\FileUploadService')

<div id="setupNews">
    <div class="newsAction">
        <a href="{{ route('admin::news.add') }}"><img src="/img/news.add.png" alt="addNews"></a>
    </div>
</div>

<div class="row">
    <table class="table table-bordered news-table">
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Content</th>
            <th>Image</th>
            <th>Tags</th>
            <th>CreatedAt</th>
            <th>UpdatedAt</th>
            <th>Action</th>
        </tr>
            @if(count($news) > 0)
                @foreach($news as $item)
                    <tr>
                        <td>
                            {{ $item->getId() }}
                        </td>
                        <td>
                            {{ $item->getTitle(20) }}
                        </td>
                        <td>
                            {{ $item->getContent(120, ['all']) }}
                        </td>
                        <td>
                            <a href="{{$file->getImageUrl($item->getImage())}}" target="_blank"><img src="{{ $file->getImageUrl($item->getImage()) }}" width="100px"></a>
                        </td>
                        <td>
                            {{ count($item->getTags()->toArray()) ? $tags->tagsToString($item) : 'No tags'}}
                        </td>
                        <td>
                            {{ $item->getCreatedAt()->format('d-m-Y H:i:s') }}
                        </td>
                        <td>
                            {{ $item->getUpdatedAt()->format('d-m-Y H:i:s') }}
                        </td>
                        <td>
                            <a href="{{ route('news.show', $item->getId()) }}" target="_blank"><img src="/img/news.view.png" alt=""></a>
                            <a href="{{ route('admin::news.edit', $item->getId()) }}"><img src="/img/news.edit.png" alt=""></a>
                            <a href="{{ route('admin::news.delete', $item->getId()) }}" class="news-delete" id="{{ $item->getId() }}" _token="{{ csrf_token() }}"><img src="/img/news.delete.png" alt=""></a>
                        </td>
                    </tr>
                @endforeach
            @else
            <tr>
                <td>
                        No news.
                </td>
            </tr>
            @endif
    </table>
</div>
<div class="row">
    <div class="col-sm-2 col-sm-offset-5">
        {{ $news->links() }}
    </div>
</div>
@endsection