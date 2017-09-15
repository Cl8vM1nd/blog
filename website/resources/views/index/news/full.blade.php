@extends('layouts.base-news')

@section('content')
@inject('file', 'App\Services\FileUploadService')
@inject('tags', 'App\Services\TagsService')

<div class="breadcrumbs">
   <i class="im im-link"></i>{!! $breadcrumb !!}
</div>

<div class="article">
   <div class="image-full"><img src="{{$file->getImageUrl($article->getImage())}}" alt=""></div>
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

       <div class="comments">
           <div id="disqus_thread"></div>
           <script>
               /**
                *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
               /*
                var disqus_config = function () {
                this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                };
                */
               (function() { // DON'T EDIT BELOW THIS LINE
                   var d = document, s = d.createElement('script');
                   s.src = 'https://blog-ifaist-com.disqus.com/embed.js';
                   s.setAttribute('data-timestamp', +new Date());
                   (d.head || d.body).appendChild(s);
               })();
           </script>
           <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
       </div>
   </div>
</div>

@endsection