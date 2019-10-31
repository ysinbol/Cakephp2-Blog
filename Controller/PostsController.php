<?php
App::uses('AppController', 'Controller');
App::uses('File', 'Utility');
App::uses('Folder', 'Utility');
/**
 * Posts Controller
 *
 * @property Post $Post
 * @property PaginatorComponent $Paginator
 */
class PostsController extends AppController
{
	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Search.Prg');
	public $presetVars = true;
	public $uses = array('Post', 'User', 'Attachment', 'Tag', 'Category');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('index', 'view');
		$this->set('userid', $this->Auth->user('id'));

		// カテゴリー一覧
		$this->set('categorieList', $this->Category->find('all', array(
			'fields' => array('Category.name'),
		)));
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->Post->recursive = 1;
		// searchのバリテーションチェック
		$this->Prg->commonProcess();

		// 検索条件のconditionsをpaginateに渡している。
		$this->paginate = array(
			'conditions' => $this->Post->parseCriteria($this->passedArgs),
			'order' => array('popularity' => 'desc'),
			'limit' => $this->paginateLimit,
		);
		$this->set('posts', $this->paginate());

		$conditions = array('conditions' => $this->Post->parseCriteria($this->passedArgs));
		$postsCount = $this->Post->find('count', $conditions);
		$this->_setisPaginationDisplay($postsCount);
	}


	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null)
	{
		if (!$this->Post->exists($id)) {
			throw new NotFoundException(__('Invalid post'));
		}
		$options = array('conditions' => array('Post.' . $this->Post->primaryKey => $id));
		$post = $this->Post->find('first', $options);

		$this->set('post', $post);
		$isOwner = $this->_isApproval($id);
		$this->set('isOwner', $isOwner);

		//サイドバーのユーザー情報
		$user_id = $this->Post->query("SELECT user_id from posts where id = ${id};");
		$user_id = $user_id[0]['posts']['user_id'];
		$user = $this->Post->User->find('first', array('conditions' => array('User.id' => $user_id), 'recursive' => 1, 'contain' => 'Profileimage'));

		$this->set('user', $user);
		$this->_setRelatedArticle($post);

		$this->paginate = array(
			'conditions' => $this->Post->parseCriteria($this->passedArgs),
			'order' => array('id' => 'desc'),
			'limit' => $this->paginateLimit,
		);
		$this->set('posts', $this->paginate());

		$this->_poplularityCalculation($post);
		$this->_setArticlesBeforeAndAfter($id);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add($categoryId = null)
	{

		if ($this->request->is('post')) {
			$this->Post->create();
			$this->request->data['Post']['user_id'] = $this->Auth->user('id');
			// アップされたファイル情報をattachmentsに保存する
			$this->_addAttachments();
			// サムネイル画像がアップされていなかったら空の配列を削除する
			$this->_deleteEmptyThumbnail();


			// セーブを出来るか
			if ($this->Post->saveAll(($this->request->data), array('deep' => true))) {
				$this->Session->setFlash(__('記事が投稿されました。'), 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));

				return $this->redirect(array('action' => 'index'));
			} else {
				$this->log($this->Post->validationErrors, LOG_DEBUG);
				$this->_displayValErrorMessage($this->Post->validationErrors);
			}
		}
		// セレクトボックスにリストを渡す。
		$this->_setUsers();
		$this->_setCategories($categoryId);
		$this->_setTags();
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null)
	{
		if (!$this->Post->exists($id)) {
			throw new NotFoundException(__('Invalid post'));
		}

		// 管理者または著者以外は編集できない
		if (!$this->_isApproval($id)) {
			$this->Flash->error(__('You do not have the authority.'));
			return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {

			// サムネイルの削除
			if ($this->_deleteThumbnailEdit($id)) {
				return $this->redirect(array('action' => 'edit' . DS . $id));
			}

			$this->_deleteEmptyThumbnail();
			$this->_addAttachments();

			if ($this->Post->saveAll($this->request->data)) {
				$this->Session->setFlash(__('編集内容を保存しました。'), 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->log($this->Post->validationErrors, LOG_DEBUG);
				$this->_displayValErrorMessage($this->Post->validationErrors);
			}
		}

		// viewに現在の記事のレコードデータを渡す。
		$options = array('conditions' => array('Post.' . $this->Post->primaryKey => $id));
		$this->set('post', $this->Post->find('first', $options));
		$this->request->data = $this->Post->find('first', $options);

		$this->_setTags();
		$this->_setUsers();
		$this->_setCategories();
	}


	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null)
	{
		if (!$this->Post->exists($id)) {
			throw new NotFoundException(__('Invalid post'));
		}

		// 管理者か著者以外は削除できない
		if (!$this->_isApproval($id)) {
			$this->Flash->error(__('You do not have the authority.'));
			return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
		}

		//デバッグ中
		$this->request->allowMethod('post', 'delete');
		if (!$this->Post->delete($id, true)) {
			$this->Session->setFlash(__('記事を削除出来ませんでした。'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-danger'
			));
			$this->_displayValErrorMessage($this->Post->validationErrors);
		} else {
			$this->Session->setFlash(__('記事を削除しました。'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-success'
			));
		}

		return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
	}

	public function csvupload()
	{
		$this->_setTables();
	}

	//------------非アクションの関数------------

	// 管理者ユーザー、または記事のオーナーか
	public function _isApproval($id)
	{
		// 管理者か (1がadmin/2がマネージャー)
		$groupId = $this->Auth->user('group_id');
		if ($groupId == 1 || $groupId == 2) {
			return true;
		}

		// 記事のオーナーか
		$this->Post->id = $id;
		if ($this->Post->field('user_id') === $this->Auth->user('id')) {
			return true;
		}

		return false;
	}




	// 編集時に画像がアップされていない状態で保存する場合は画像を削除しない
	public function _editDeleteImages($id = null)
	{
		// アップロードされている画像の名前が無いなら削除しない。
		$imageName = $this->request->data('Post.Image.0')['name'];
		if ($imageName === '') return;

		// 削除する
		$this->_deleteImages($id);
	}

	// ファイルの数だけファイルのデータをattachmentsテーブルに挿入する。
	public function _addAttachments()
	{
		// 画像の数を取得
		$attachmentsCount = count($this->request->data['Attachment']['Attachment']);

		// ファイルの名前を取得
		$attachmentName = $this->request->data['Attachment']['Attachment'][0]['name'];
		// 画像とサムネが投稿されていなかったらAttachmentを削除
		if ($attachmentName === '') {
			unset($this->request->data['Attachment']);
			return;
		}

		// アップ予定のファイルの数だけAttachmentsテーブルにレコードを挿入する
		for ($i = 0; $i < $attachmentsCount; $i++) {
			// 記事内に投稿された画像を保存
			$this->request->data['Attachment']["${i}"]['model'] = 'Post';
			$this->request->data['Attachment']["${i}"]['attachment'] = $this->request->data['Attachment']['Attachment']["${i}"];
		}

		// アップされた一時ファイル情報を削除しないとレコードを挿入出来なかったので削除。
		unset($this->request->data['Attachment']['Attachment']);
	}

	// edit画面で、画像を個別に削除する
	public function _deleteAttachmentsEdit($post_id = null)
	{
		//記事のidに該当するレコードの取得
		$attachmentsData = $this->Post->Attachment->find('all', array(
			'conditions' => array('foreign_key' => $post_id)
		));
		$attachmentsCount = count($attachmentsData);

		// ボタンが押されたかどうか調べる
		for ($i = 0; $i < $attachmentsCount; $i++) {
			// 記事の中にある画像のidを取り出す
			$id = $attachmentsData["${i}"]['Attachment']['id'];
			// この画像に付随されたボタンが押されたか
			if (isset($this->request->data[$id])) {

				$this->Post->Attachment->delete($id);
				return true;
			}
		}
		// ボタンが押されていない
		return false;
	}

	public function ajax_DeleteAttachmentsEdit()
	{
		// Ajax以外の通信の場合
		if (!$this->request->is('ajax')) {
			throw new BadRequestException();
		}

		// view描画しない(MissingView対策)
		$this->autoRender = false;

		$imgId = $this->request->data['value'];

		$this->Post->Attachment->delete($imgId);
		return json_encode('処理成功');
	}

	// サムネイルがアップされなければ空のサムネイルファイルを削除する。
	public function _deleteEmptyThumbnail()
	{
		$thumbnailName = $this->request->data['Thumbnail']['thumbnailimage']['name'];
		if ($thumbnailName === '') {
			unset($this->request->data['Thumbnail']);
			return;
		}
	}

	// editでサムネイルに付属した削除ボタンを押したらサムネ画像を削除する。
	public function _deleteThumbnailEdit($post_id = null)
	{
		$options = array('conditions' => array('Post.' . $this->Post->primaryKey => $post_id));
		$post = $this->Post->find('first', $options);
		$thumbnail_id = $post['Thumbnail']['id'];
		if (isset($this->request->data[$thumbnail_id])) {
			$this->Post->Thumbnail->delete($thumbnail_id);
			return true;
		}

		return false;
	}

	public function _fileEncode()
	{
		$detectOrder = 'ASCII,JIS,UTF-8,CP51932,SJIS-win';
		setlocale(LC_ALL, 'ja_JP.UTF-8');

		//ファイルのパスを取得
		$tmpName = $_FILES["upfile"]["tmp_name"];
		$buffer = file_get_contents($tmpName);

		if (!$encoding = mb_detect_encoding($buffer, $detectOrder, true)) {
			// 文字コードの自動判定に失敗
			unset($buffer);
			throw new RuntimeException('Character set detection failed');
		}
		file_put_contents($tmpName, mb_convert_encoding($buffer, 'UTF-8', $encoding));
		unset($buffer);
		return $tmpName;
	}

	//---------------------set関数---------------------//

	// ユーザーの連想配列データをviewに渡す
	public function _setUsers()
	{
		$users = $this->Post->User->find('list'); //主キ(id)ーをkeyでvalueがnameになってる連想配列を取ってくる
		$this->set(compact('users')); //配列のデータをviewに渡してる compact関数は配列にしてviewに渡してくれる
	}

	// カテゴリーの連想配列データをviewに渡す
	public function _setCategories($categoryId = null)
	{
		if ($categoryId == null) {
			$categoryId = 1;
		}
		$this->set('value', $categoryId);
		$categories = $this->Post->Category->find('list'); //同じく
		$this->set(compact('categories'));
	}

	// タグの連想配列データをviewに渡す
	public function _setTags()
	{
		$tags = $this->Post->Tag->find('list');
		$this->set(compact('tags'));
	}

	// テーブル一覧をセット
	public function _setTables()
	{
		$tables = $this->Post->query("SHOW TABLES;");
		$tableList = array();

		// listに変換
		foreach ($tables as $key => $value) {
			$column = array_column($value, 'Tables_in_cakephp');
			$tableList[] = $column[0];
		}
		$this->set(compact('tableList'));
	}

	public function _setArticlesBeforeAndAfter($id)
	{
		$posts = $this->Post->find('list'); //idの連想配列を取得

		$ids = array_keys($posts); //連想配列を単純な配列に変換
		$idx = array_search($id, $ids); //記事IDが配列の何番目かを取得
		debug($ids[$idx - 1]);

		$option = array('conditions' => array('Post.id' => $ids[$idx + 1]), 'recursive' => -1);
		$afterArticle = $this->Post->find('first', $option);
		$option = array('conditions' => array('Post.id' => $ids[$idx + -1]), 'recursive' => -1);
		$beforeArticle = $this->Post->find('first', $option);

		$this->set('nextArticle', $afterArticle);
		$this->set('prevArticle', $beforeArticle);
	}

	public function _setRelatedArticle($post)
	{
		$categoryId = $post['Category']['id'];
		$tagsId = array('OR' => array());
		foreach ($post['Tag'] as $tags) {
			array_push($tagsId['OR'], array('PostsTag.tag_id' => $tags['id']));
		}

		// こういう形
		// $or = array(
		// 	'OR' => array(
		// 		array('PostsTag.tag_id' => $tagsId[0]),
		// 		array('PostsTag.tag_id' => $tagsId[1]),
		// 		array('PostsTag.tag_id' => $tagsId[2])
		// 	)
		// );


		// 関連記事取得(同一カテゴリーでタグがどれかに当てはまれば取ってくる)
		$relatedArticles = $this->Post->find('all', array(
			'fields' => 'DISTINCT *',
			'conditions' => array(
				'Category.id' => $categoryId,
				'NOT' => array('Post.id' => $post['Post']['id']),
			),
			'joins' => array(
				array(
					'table' => 'posts_tags',
					'alias' => 'PostsTag',
					'type' => 'INNER',
					'conditions' => array(
						$tagsId,
						'PostsTag.post_id = Post.id'
					),
				)
			),
			'contain' => array('Category', 'Thumbnail', 'Tag'),
			'recursive' => 2
		));
		$articlePostsCount = 8;
		// 関連記事が８つ以下ならカテゴリーだけと同じな記事も取得する
		if (count($relatedArticles) < $articlePostsCount) {
			$postsId = array('NOT' => array());
			foreach ($relatedArticles as $posts) {
				array_push($postsId['NOT'], array('Post.id' => $posts['Post']['id']));
			}
			$addRelatedArticles =  $this->Post->find('all', array(
				'fields' => 'DISTINCT *',
				'conditions' => array(
					'Category.id' => $categoryId,
					'NOT' => array('Post.id' => $post['Post']['id']),
					$postsId
				),
				'contain' => array('Category', 'Thumbnail', 'Tag'),
				'recursive' => 2
			));
			$relatedArticles = array_merge($relatedArticles, $addRelatedArticles);
		}

		$relatedArticles = array_slice($relatedArticles, 0, $articlePostsCount);
		$this->set('relatedArticles', $relatedArticles);
	}

	public function _poplularityCalculation($post)
	{
		// 投稿日時が何日経ってるかを計算
		$todaysDate = new DateTime(date('Y-m-d'));
		$postDate = new DateTime($post['Post']['created']);
		$diff = $todaysDate->diff($postDate);
		$accesscount = $post['Post']['accesscount'];

		switch ($diff->days) {
			case 0:
				$popularity = $accesscount * 4;
				break;
			case 1:
				$popularity = $accesscount * 3;
				break;
			case 2:
				$popularity = $accesscount * 2.25;
				break;
			case 3:
				$popularity = $accesscount * 1.75;
				break;
			case $diff->days > 3 && $diff->days <= 7:
				$popularity = $accesscount * 1.5;
				break;
			case $diff->days > 7 && $diff->days <= 30:
				$popularity = $accesscount * 1.2;
				break;
			default:
				$popularity = $accesscount;
				break;
		}

		$post['Post']['accesscount'] += 1;
		$post['Post']['popularity'] = $popularity;
		$this->Post->save($post);
	}

	public function ajax_UploadCsv()
	{
		if ($this->request->is('ajax')) {

			$time_start = microtime(true);


			$this->autoRender = false;
			// 対象テーブル読み込み
			$this->loadModel('Zipcode');

			// 該当テーブルのカラム名と属性を取得
			$tableType = $this->Zipcode->getColumnTypes();

			// エンコード
			$fileName = $this->_fileEncode();

			// ファイルを開く
			$fp = fopen($fileName, 'rb');

			// saveAllする配列
			$updateItemData = array();

			while ($row = fgetcsv($fp)) {

				$zipcode = $row[2];
				$record = array();
				$updateRecord = $this->Zipcode->query("SELECT * FROM zipcode as Zipcode WHERE zipcode = ${zipcode} limit 1;");

				// flag14が2の場合は削除(2は廃止データ)
				$isDelete = $row[13] == 2;
				if ($isDelete) {
					$this->Zipcode->delete($updateRecord[0]['Zipcode']['id']);
					continue;
				}

				$i = 0;
				if (!empty($updateRecord)) {
					$id = $updateRecord[0]['Zipcode']['id'];
					foreach ($updateRecord[0]['Zipcode'] as $key => $value) {
						if ($key === 'id') {
							$updateRecord[$key] = $id;
							continue;
						}
						$updateRecord[$key] = $row[$i++];
					}
					$updateItemData['Zipcode'][] = $updateRecord;
					continue;
				}
				foreach ($tableType as $key => $value) {
					if ($key !== 'id') {
						$updateRecord[$key] = $row[$i++];
					}
				}
				$updateItemData['Zipcode'][] = $updateRecord;
			}

			$time = microtime(true) - $time_start;
			if (empty($updateItemData)) {
				// return json_encode("CSVインポートを完了しました${time}", false);
				return json_encode($time);
			}
			//一括保存
			if (!$this->Zipcode->saveAll($updateItemData['Zipcode'])) {
				return json_encode("CSVインポートに失敗しました。", false);
			}
			return json_encode("CSVインポートを完了しました${time}", false);
		}
	}
}
