@extends('layouts.default')

@section('content')

    <h2>現在の画像</h2>
    
    @php
        foreach([0,1,2,3] as $num){
            eval('$flag=($post->image'.$num.'!=="");');
            if($flag){
                print '<div data-target = "#cl" data-slide-to=';
                eval('print $num' . ';');
                print '>';
                print '<img src = " '.url('/').'/storage/';
                eval('print $post->image'.$num.';');
                print '"';
                print 'alt = image';
                eval('print $num' . ';');
                print '>';
                print '</div>';
            }
        }
    @endphp
    
    <form method = "POST" action = "{{ route('posts.update_image', $post) }}" enctype = "multipart/form-data">
        @csrf
        @method('patch')
        <div>
            <label>
                画像を選択：
                <input type = "file" name = "image0">
            </label>
        </div>
         <div>
            <label>
                画像を選択：
                <input type = "file" name = "image1">
            </label>
        </div>
         <div>
            <label>
                画像を選択：
                <input type = "file" name = "image2">
            </label>
        </div>
         <div>
            <label>
                画像を選択：
                <input type = "file" name = "image3">
            </label>
        </div>
        <input type = "submit" value = "更新">
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