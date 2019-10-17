@extends('layouts.app')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/wangEditor.css') }}">
@stop
@section('content')

  <div class="container">
    <div class="col-md-10 offset-md-1">
      <div class="card ">

        <div class="card-body">
          <h2 class="">
            <i class="far fa-edit"></i>
            @if($topic->id)
            编辑话题
            @else
            新建话题
            @endif
          </h2>

          <hr>

          @if($topic->id)
            <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
              <input type="hidden" name="_method" value="PUT">
          @else
            <form action="{{ route('topics.store') }}" method="POST" onsubmit="" accept-charset="UTF-8">
          @endif

              <input type="hidden" name="_token" value="{{ csrf_token() }}">

              @include('shared._error')

              <div class="form-group">
                <input class="form-control" type="text" name="title" value="{{ old('title', $topic->title ) }}" placeholder="请填写标题" required />
              </div>

              <div class="form-group">
                <select class="form-control" name="category_id" required>
                  <option value="" hidden disabled  {{ $topic->id ? '' : 'selected' }}>请选择分类</option>
                  @foreach ($categories as $value)
                  <option value="{{ $value->id }}" {{ $topic->category_id == $value->id ? 'selected' : '' }} >{{ $value->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group" id="editor_box"></div>
                <textarea name="body" id='editor_content' style="display:none;"></textarea>
              <div class="well well-sm">
                <button type="submit" id="topicsSubBut" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i> 保存</button>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>


@section('scripts')
  <script type="text/javascript" src="{{ asset('js/wangEditor.js') }}"></script>

  <script>
    $(document).ready(function() {
      // var editor = new Simditor({
      //   textarea: $('#editor'),
      //   upload: {
      //     url: '{{ route('topics.upload_image') }}',
      //     params: {
      //       _token: '{{ csrf_token() }}'
      //     },
      //     fileKey: 'upload_file',
      //     connectionCount: 3,
      //     leaveConfirm: '文件上传中，关闭此页面将取消上传。'
      //   },
      //   pasteImage: true,
      // });

      var E = window.wangEditor;
      var editor = new E('#editor_box');  // 两个参数也可以传入 elem 对象，class 选择器

      //这里注意，下面的/news/upload是我的路由部分，主要是上传图片的后端代码
      editor.customConfig.uploadImgServer = '{{ route('topics.upload_image') }}' ; // 上传图片到服务器
      // 将图片大小限制为 3M
      editor.customConfig.uploadImgMaxSize = 2 * 1024 * 1024;
      // 限制一次最多上传 5 张图片
      editor.customConfig.uploadImgMaxLength = 3;
      editor.customConfig.customAlert = function (info) {
          // info 是需要提示的内容
          alert(info);
      }
      editor.customConfig.uploadImgParams = {
        // 如果版本 <=v3.1.0 ，属性值会自动进行 encode ，此处无需 encode
        // 如果版本 >=v3.1.1 ，属性值不会自动 encode ，如有需要自己手动 encode
        _token: '{{ csrf_token() }}'
      }
      //定义上传的filename，即上传图片的名称
      editor.customConfig.uploadFileName = 'upload_file[]';
      editor.customConfig.showLinkImg = false;
      //开启wangEditor的错误提示，有利于我们更快的找到出错的地方
      editor.customConfig.debug=false;
      editor.create();
      var content_box='{!! old('body',rep_br( $topic->body)) !!}';
      editor.txt.html(content_box);

      $('#topicsSubBut').on('click',function(){
        $('#editor_content').html(editor.txt.html());
      });
    });
  </script>
@stop
@endsection