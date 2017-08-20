@extends('layouts.base-news')

@section('content')
@inject('cloud', 'App\Services\CloudService')
@inject('tags', 'App\Services\TagsService')

<div class="breadcrumbs">
   <i class="im im-link"></i>{!! $breadcrumb !!}
</div>

<div class="article">
   <div class="image-full"><img src="{{$cloud->getPublicUrl($article->getImage())}}" alt=""></div>
   <div class="block">
      <div class="title">{!! $article->getTitle() !!}</div>
      <div class="content">{!! $article->getContent() !!}</div>
      <div class="tags">
         @if(count($article->getTags()) >= 1)
            TAGS:
            @foreach($news = $article->getTags()->toArray() as $tag)
               @if($news[count($news) - 1] == $tag)
                  <a href="{{route('news.search.byTag', $tag->getTag()->getId())}}">{{$tag->getTag()->getName()}}</a>
               @else
                  <a href="{{route('news.search.byTag', $tag->getTag()->getId())}}">{{$tag->getTag()->getName()}}</a>,
               @endif
            @endforeach
         @endif
      </div>
      <div class="date">
         <i class="fa fa-calendar"><span>{{$article->getCreatedAt()->format('d-m-Y')}}</span></i>
      </div>
   </div>
</div>

@endsection