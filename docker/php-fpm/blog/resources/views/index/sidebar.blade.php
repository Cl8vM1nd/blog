@inject('tags', 'App\Services\TagsService')
<div class="about-me">
    <div class="title">About Me</div>
    <div class="my-photo">
        <img src="/img/my-img.jpg" alt="">
    </div>
    I am a pass-ionate Site Relia-bility Engineer with 7 years experience.
    I am real fan of KISS and SOLID code. Try to use all last useful features if I can. Love DevOps <img src="/img/docker.png" width="34px" class="docker" />.
    In my free time you can find me somewhere on laracasts.com. Follow me ladies ;)
</div>

<div class="follow-me">
    <div class="title">Follow ME</div>
    <a href="https://vk.com/cl8vm1nd" target="_blank"><i class="im im-vk"></i></a>
    <a href="https://www.facebook.com/cl8vm1nd" target="_blank"><i class="im im-facebook-like"></i></a>
    <a href="https://github.com/Cl8vM1nd" target="_blank"><i class="im im-github"></i></a>
    <a href="https://twitter.com/cl8vm1nd" target="_blank"><i class="im im-twitter"></i></a>
    <a href="https://instagram.com/ilyaandkate" target="_blank"><i class="im im-instagram"></i></a>
</div>
<div class="tags">
    <div class="title">Tags</div>
    @foreach($tags->getTagList() as $tag)
        {!! $tag !!} </br>
    @endforeach
</div>
