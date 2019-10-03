$(document).ready(function () {
  // 虫眼鏡がクリックされたら検索窓を開く
  $('#search').on('click', function () {
    $('.search_form').toggle();
  });

  // ログアウト時の確認
  $('.loginOrlogout').on('click', function (e) {
    var logText = $('.loginOrlogout').text();
    if (logText === 'Logout') {
      if (!confirm('本当にログアウトしますか？')) {
        e.preventDefault();
      }
      $(this).unbind('submit').submit()
    }
  })

  // ファイルの名前をファイル投稿フォーム欄にカンマ区切りで表示
  $('.custom-file-input').on('change', handleFileSelect);
  function handleFileSelect(evt) {
    var files = evt.target.files;

    var output = [];
    for (var i = 0, f; f = files[i]; i++) {
      output.push(escape(f.name), ', ');
    }
    $(this).next('.custom-file-label').html(output);
  }

  // 画像ポップアップ
  popupImg();


  // 閉じるボタンか画像以外の範囲をクリックしたら画像をフェードアウト
  $('.popupbg,.close_image').click(function () {
    $('.popup_wrapper:visible').fadeOut(function () {
      $('.background-img').fadeOut();
      $('.popupbg').fadeOut();
    });
  });

  // editページで画像単体削除
  ajax_deleteImg();

  // アップロードしたファイルの進捗状況を表示
  ajax_displayLoadingCsv();

  $('.addTag').click(function (e) {
    e.preventDefault();
    ajax_addTag(e);
  });

  // タグ・カテゴリーのリンク
  // $('.category-link,.tag-link,.category-link-nav').on('click', function (e) {
  //   var text = $(this).text().replace(/\s+/g, "");
  //   $('#PostKeyword').val(text);
  //   $('#PostIndexForm').submit();
  // });

  $('.blog-post').on('click', function () {
    var url = $(this).attr('href');
    window.location.href = url;
  });

  // プロフィールイメージを書き換える
  resizeImageDisplayThumbnail();


  // 二重送信防止
  $('.submit').on('click', function () {
    $(this).css('pointer-events', 'none');
  });
});

function popupImg() {
  $('.pop').click(function (e) {
    // リンク飛びを防ぐ
    e.preventDefault();

    // idを取得
    var id = $(this).attr('href');
    var img = $(this).next().find('.img');

    // 次の画像群と前の画像群を取得
    var nextImage = $(this).nextAll('.popup_wrapper:first').nextAll('.popup_wrapper:first');
    var prevImage = $(this).prevAll('.popup_wrapper:first');

    // 次の画像がなければ次へのボタンを隠す。
    if (!nextImage.length) {
      $(this).nextAll('.popup_wrapper:first').find('.next_btn').hide();
    }
    // 前の画像がなければ前へのボタンを隠す。
    if (!prevImage.length) {
      $(this).nextAll('.popup_wrapper:first').find('.prev_btn').hide();
    }

    // 画像のid・画像のサイズ・wrapperを取得
    var imgId = $(img).attr('Id');
    var imgSize = getImageSizeById(imgId);
    var popup_wrapper = $(this).next();

    // wrapperのwidth,heightを画像のwidth,heightに変更
    setPopupStyle(popup_wrapper, img, imgSize);
    // 白い敷き紙を画像のサイズに拡縮して、次・前へボタンを画像の中央位置に揃える
    popupAnimate(imgSize);

    // 画像と背景画像をフェードイン
    $('.popupbg').fadeIn();
    $('.background-img').fadeIn(function () {
      $('.spiner_wrapper').show()
      $('.spiner_wrapper').fadeOut(function () {
        $(id).fadeIn();
      });
    });

    // フェードインにかかる時間
    var fadeInDelayTime = 750;

    // 次へボタン
    $('.next_btn').click(function () {
      // 次の画像群
      var nextImage = $(this).parent().nextAll('.popup_wrapper:first');

      // 次の次の画像がなければ次の画像は次へボタンを非表示。
      if (!$(nextImage).nextAll('.popup_wrapper:first').length) {
        $(nextImage).find('.next_btn').hide();
      }

      //次の画像のサイズ・idを取得し、白い敷き紙の画像を表示する画像のサイズに合わせる。
      img = $(nextImage).find('.img');
      imgSize = getImageSizeById(img.attr('Id'));
      setPopupStyle(nextImage, img, imgSize);

      // 今表示している画像をfadeOutして次の画像群をfadeIn
      $(this).parent().hide();
      $('.spiner_wrapper').show();
      popupAnimate(imgSize);

      setTimeout(() => {
        $('.spiner_wrapper').fadeOut(function () {
          nextImage.fadeIn();
        })
      }, fadeInDelayTime);
    });

    // 前へボタン
    $('.prev_btn').click(function () {
      var prevImage = $(this).parent().prevAll('.popup_wrapper:first');
      // 前の前の画像が無ければ前の画像は前へボタンを非表示
      if (!$(prevImage).prevAll('.popup_wrapper:first').length) {
        $(prevImage).find('.prev_btn').hide();
      }

      img = $(prevImage).find('.img');
      imgSize = getImageSizeById(img.attr('Id'));
      setPopupStyle(prevImage, img, imgSize);

      // 今表示している画像をfadeOutして前の画像群をfadeIn
      $(this).parent().hide();
      $('.spiner_wrapper').show();
      popupAnimate(imgSize);

      setTimeout(() => {
        $('.spiner_wrapper').fadeOut(function () {
          prevImage.fadeIn();
        })
      }, fadeInDelayTime);
    });
  })


}

// idからimgタグのwidthとheightを取得
function getImageSizeById(id) {
  var element = document.getElementById(id);

  // 取得したidの読み込みが完了しているか
  if (element.complete) {
    // 高さと横の長さを取得
    var width = element.naturalWidth;
    var height = element.naturalHeight;
  }

  return { width: width, height: height };
}

// backgroundの白い画像を、表示する画像のサイズに合わせる
function popupAnimate(imgSize) {
  $('.background-img').animate({
    width: imgSize.width,
    height: imgSize.height,
    'margin-top': (-imgSize.height / 2),
    'margin-left': (-imgSize.width / 2)
  });

  // 次・前へボタンを画像の中央、左右端に配置
  var btnSize = 25;
  var offsetMarginTop = imgSize.height / 2 - btnSize;
  $('.next_btn,.prev_btn').css({
    'margin-top': offsetMarginTop,
  });
  $('.next_btn').css({ 'margin-right': -btnSize / 2 });
  $('.prev_btn').css({ 'margin-left': -btnSize / 2 });

  // スピナーを上下中央に配置
  $('.spiner_wrapper > .spiner').css({
    'margin-top': offsetMarginTop
  })
}

// popup_wrapperの縦横を画像の縦横サイズと合わせる
function setPopupStyle(popup_wrapper, img, imgSize) {
  $(popup_wrapper).css({
    'width': imgSize.width,
    'height': imgSize.height + 100,
    'margin-top': -imgSize.height / 2,
    'margin-left': -imgSize.width / 2
  });

  $('.spiner_wrapper').css({
    'width': imgSize.width,
    'height': imgSize.height + 100,
    'margin-top': -imgSize.height / 2,
    'margin-left': -imgSize.width / 2
  });

  $(img).css({
    'width': imgSize.width,
    'height': imgSize.height,
  });
}

// アップロードされた画像をリサイズしてサムネイル表示
function resizeImageDisplayThumbnail() {
  // アップロードするファイルを選択
  $('input[type=file]').change(function () {
    var file = $(this).prop('files')[0];

    // 画像以外は処理を停止
    if (file.type.indexOf("image") < 0) {
      alert("画像ファイルを指定してください。");
      return false;
    }
    console.log("aa");
    var reader = new FileReader();
    reader.onload = function () {
      $('.profileImage').attr('src', reader.result);
      var fixedWidth = 200;        //fixed width
      var fixedHeght = 200;        //fixed height
      var sl = '.profileImage'; //selector
      $(sl).each(function () {
        var w = $(this).width();
        var h = $(this).height();
        $(this).width(fixedWidth);
        $(this).height(fixedHeght);
      });
    }
    reader.readAsDataURL(file);
  });
}

// editページで画像を個別に削除する。
function ajax_deleteImg() {
  $('.deleteImg').click(function (e) {
    e.preventDefault();
    if (!confirm("本当に削除してもよろしいですか？")) {
      return;
    }
    var imgId = $(this).attr('id');
    console.log(imgId);
    $.ajax({
      url: "http://blog.dev1/cakephp/posts/ajax_DeleteAttachmentsEdit",
      type: "POST",
      data: {
        value: imgId,
      },
      dataType: "json",
      error: function (jqXHR, textStatus, errorThrown) {
      },
      success: function (data) {
      }
      // 成功後
    }).done(function (data) {
      $('#' + imgId).prev().hide();
      $('#' + imgId).hide();
      $('img[name=' + imgId + ']').hide();
      // 失敗後
    }).fail(function (data) {
    });
  });
}

function ajax_displayLoadingCsv(params) {
  var jqxhr;
  $('#upload').click(function (e) {
    $('#uploadCansel').show();

    // フォームデータを取得
    var formdata = new FormData($('#PostCsvuploadForm').get(0));
    var file = $('#customFile')[0].files[0];
    if (!file) {
      alert('csvファイルを選択してください。');
      return;
    }
    e.preventDefault();
    $('.csv-loader').show();
    // POSTでアップロード
    jqxhr = $.ajax({
      url: "http://blog.dev1/cakephp/posts/ajax_UploadCsv",
      type: "POST",
      data: formdata,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json"
    })
      .done(function (data, textStatus, errorThrown) {
        $('.csv-loader').hide();
        if (data['error']) {
          alert(data['text']);
          return;
        }
        $('.alert-uploaded').fadeIn();
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
        console.log(textStatus);
        console.log(errorThrown);
      });
    $('#uploadCansel').on('click', function () {
      jqxhr.abort();
    });

  });


}

function ajax_addTag(e) {
  var tagName = $('.tagCreate').val();
  $.ajax({
    url: "http://blog.dev1/cakephp/posts/ajax_setTags",
    type: "POST",
    data: { value: tagName },
    dataType: "json"
  })
    .done(function (data, textStatus, errorThrown) {

    })
    .fail(function (jqXHR, textStatus, errorThrown) {

    });
}
