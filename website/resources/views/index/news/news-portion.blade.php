@inject('cloud', 'App\Services\CloudService')
@inject('tags', 'App\Services\TagsService')
@foreach($news as $article)
   <div class="article">
      <a href="/news/{{$article->getId()}}">
         <div class="image"><img src="{{$cloud->getPublicUrl($article->getImage())}}" alt=""></div>
      </a>
         <div class="block">
            <div class="title">{!! $article->getTitle() !!}</div>
            <div class="content">{!! $article->getContent(360, ['img']) !!}</div>
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
            {{--<div class="count">
               <i class="im im-eye"></i>
            </div>--}}
         </div>
   </div>
      <hr class="style-seven">
@endforeach
