@extends('layouts.default')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  <form method = "POST" enctype="multipart/form-data" action = "{{route('posts.store') }}" >
      @csrf
      <div class="form-group">
        <label>
          画像:
          <input type = "file" name = "image0">
        </label>
      </div>
      <div class="form-group">
        <label>
          画像:
          <input type = "file" name = "image1">
        </label>
      </div>
      <div class="form-group">
        <label>
          画像:
          <input type = "file" name = "image2">
        </label>
      </div>
      <div class="form-group">
        <label>
          画像:
          <input type = "file" name = "image3">
        </label>
      </div>
      <div class="form-group">
        <label for = "tags">タグ:</label>
          <input class="form-control" type = "text" name = "tags" id = "tags"placeholder = "#kawasaki #ネイキッド" >
      </div>
      <div>
        <label for = "comment">コメント:</label>
          <textarea class="form-control" name = "comment" cols="50" rows="10" id = "comment"></textarea>
      </div>
      <div class = "mt-3">
        <input type = "submit" value = "投稿">
      </div>
  </form>
  <script>
    window.onload = () => {
      // input要素（type="file"）のノードリスト（ノードの配列みたいなものです）を取得して、for文で各input要素にイベントハンドラーを設定します
      for (const input of document.querySelectorAll('input[type="file"]')) {
        input.addEventListener('change', (event) => {
          // 対象のinput要素で選択されたファイル情報を取得
          const file = event.target.files[0];
          // ファイル情報が有効であれば
          if (file) {
            // input要素の親要素の親要素（div）を取得
            const block = event.currentTarget.parentNode.parentNode;
            // div要素の子要素の中にimg要素が含まれていれば削除
            for (const child of block.children) {
              if (child.tagName === 'IMG') {
                child.remove();
              }
            }
            // img要素を新規作成し（src属性に選択した画像ファイルのURLをセット）、div要素の子要素として追加
            const element = document.createElement('img');
            element.setAttribute('src', URL.createObjectURL(file));
            element.style.width = "150px";
            block.appendChild(element);
          }
        });
      }
    }
  </script>  
@endsection
