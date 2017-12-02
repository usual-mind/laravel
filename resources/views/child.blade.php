@extends('layouts.app')

@section('title', 'Laravel 学院')
    @section('sidebar')
        @parent
            <p>        Laravel 学院致力于提供优质的Laravel 中文学习
            </p>

    @endsection
@section('content')
    <p>这里是主题内容，完善中。。。</p>

    {{ $name or 'Default' }} hha<br>
    {!! $name !!}

@endsection



<script>
    //  渲染json
    var app = @json(['one' => 'ss','two' => 'dff']);
    console.log(app);
</script>

