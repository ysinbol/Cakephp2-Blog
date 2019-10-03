$(window).on('load', function () {
  var value = $('#regionSelect option:selected').val();
  var method = 'ajax_SetPrefList';
  ajax_setSelectBoxAdress(value, method);

  value = '北海道';
  method = 'ajax_SetCityList';
  ajax_setSelectBoxAdress(value, method);
});

$(document).ready(function () {
  // 郵便番号取得
  ajax_displayAdress();
  // エラーメッセージを赤色にする。
  $('#inputZipErrorMsg').css('color', 'red');

  // 地方選択->地方毎の県名一覧をリストにセット
  $('#regionSelect').change(function () {
    var value = $('#regionSelect option:selected').val();
    var method = 'ajax_SetPrefList';
    ajax_setSelectBoxAdress(value, method);
  });

  // 県名選択->県名毎の市区町村一覧をリストにセット
  $('#prefSelect').change(function () {
    var value = $('#prefSelect option:selected').text();
    var method = 'ajax_SetCityList';
    ajax_setSelectBoxAdress(value, method);
  });
});

// 郵便番号を取得し、住所入力欄に自動で住所を表示する。
function ajax_displayAdress() {
  $('#zipcode').change(function () {
    var inputZipcode = $('#zipcode').val();
    if (inputZipcode.match(/[^0-9.,-]+/)) {
      $('#inputZipErrorMsg').text('※半角数字で入力してください。').show();
      return;
    }
    $.ajax({
      url: "http://blog.dev1/cakephp/users/ajax_AdressDisplay",
      type: "POST",
      data: {
        zipcode: inputZipcode
      },
      dataType: "json",
      error: function (jqXHR, textStatus, errorThrown) {
      },
      success: function (data) {
      }
      // 成功後
    }).done(function (data) {
      if ($.type(data) === "string") {
        $('#inputZipErrorMsg').text(data).show();
        return;
      }
      $('#inputZipErrorMsg').hide();

      // 都道府県のセレクトボックスに郵便番号検索でヒットした都道府県をセット。
      var pref = data[0]['Zipcode']['pref'];
      var prefIndex = data[1]['Prefecture']['id'];
      var prefStr = prefIndex + '';
      $("#pref option[value='" + prefStr + "']").prop('selected', true);

      // Object.values(データ).join()は連想配列のvalueだけを配列から文字列に変換して連結させる。
      var fullAdress = Object.values(data[0]['Zipcode']).join('');
      var cityAndStreetAdress = [data[0]['Zipcode']['city'], data[0]['Zipcode']['street']].join('');
      $('#adress').val(cityAndStreetAdress);
      // 失敗後
    }).fail(function (data) {
    });
  });
}

function ajax_setSelectBoxAdress(inputValue, methodURL) {
  $.ajax({
    url: "http://blog.dev1/cakephp/users/" + methodURL,
    type: "POST",
    data: {
      value: inputValue,
    },
    dataType: "json",
    error: function (jqXHR, textStatus, errorThrown) {
    },
    success: function (data) {
    }
    // 成功後
  }).done(function (data) {

    var list = data;
    // array(array(list))で入ってくるので
    for ($i = 0; $i < list.length; $i++) {
      // [0][0]にセクレターidが入ってくる。都道府県ないしは市区町村リストを一旦消去。
      $('#' + data[$i][0] + '> option').remove();

      // [0][1]にリストが入ってくる
      $.each(data[$i][1], function (index, value) {
        // もらってきたリストを追加しまくる。
        $('#' + data[$i][0]).append($('<option>').html(value).val(index));
      })
    }

    // 失敗後
  }).fail(function (data) {
  });
}
