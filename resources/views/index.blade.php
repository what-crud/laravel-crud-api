@foreach($posts as $post)

    {{$post->title}} - {{$post->category->name}}<br>

@endforeach


{{$posts->links()}}
