<div class="container">
  <div class="alert alert-success alert-dismissible fade show alert-uploaded" role="alert">
    <strong>報告:</strong> CSVインポートが完了しました！
    <button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

  <?php echo $this->Form->create(
    'Post',
    array('type' => 'file', 'entype' => 'multipart/form-data')
  ); ?>

  <h2 class="mb-5 mt-5 text-center">csvファイルアップロード(DB更新)</h2>

  <?php
  echo $this->Form->input('table', array('class' => 'custom-select mb-4', 'label' => 'インポートするテーブル名', 'type' => 'select', 'options' => $tableList));
  ?>

  <div class="custom-file">
    <input type="file" class="custom-file-input" id="customFile" name="upfile">
    <label class="custom-file-label" for="customFile" data-browse="参照">csvファイルを選択...</label>
  </div>



  <div class="d-flex justify-content-center align-items-center">
    <?php echo $this->Form->submit(__('アップロード'), array('class' => 'btn btn-outline-primary mt-4', 'id' => 'upload', 'type' => 'button')); ?>
    <?php echo $this->Form->submit(__('キャンセル'), array('class' => 'btn btn-outline-success mt-4 ml-2', 'id' => 'uploadCansel', 'type' => 'button')); ?>
  </div>




</div>
</div>
<div class="csv-loader">
  <div class="row mt-4 ml-2">
    <div class="col-5">
      <div class="spinner-border text-secondary float-right" role="status">
        <span class="sr-only ">Loading...</span>
      </div>
    </div>

    <div class="col ml-n4">
      <h3 class="float-left">DBを更新中です...</h>
    </div>
  </div>
</div>
</div>
