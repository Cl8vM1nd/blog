@extends('layouts.admin-base')
@section('content')

<div class="block">
    <div class="title">Latest News<a href="{{ route('admin::news.add') }}" title="Add article"><img src="../img/news.add.png"/></a></div>
    <ul>
        @foreach($news as $article)
            <li>
                <div class="content">{{$article->getTitle()}}</div>
            </li>
        @endforeach
    </ul>
</div>

<div class="block">
    <div class="title">Top Tags</div>
    <ul>
        @foreach($tags as $tag)
            <li>
                <div class="content">{!! $tag !!}</div>
            </li>
        @endforeach
    </ul>
</div>

@endsection