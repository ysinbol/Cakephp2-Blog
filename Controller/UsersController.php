<?php
App::uses('AppController', 'Controller', 'Post');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController
{

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator');

	public function beforeFilter()
	{
		parent::beforeFilter();


		$userId = $this->Auth->user('id');

		// CakePHP 2.1以上
		$this->Auth->allow(
			'add',
			'logout',
			'login',
			'initDB',
			'ajax_AdressDisplay',
			'ajax_SetPrefList',
			'ajax_SetCityList',
			'view',
			"edit"
		);

		// $this->Auth->allow("edit/${userId}");
	}

	public function initDB()
	{
		$group = $this->User->Group;
		//管理者グループには全てを許可する
		$group->id = 1;
		$this->Acl->allow($group, 'controllers');
		$this->Acl->allow($group, 'controllers/categories');

		//マネージャグループには posts と widgets に対するアクセスを許可する
		$group->id = 2;
		$this->Acl->deny($group, 'controllers');
		$this->Acl->allow($group, 'controllers/Posts');
		$this->Acl->allow($group, 'controllers/Widgets');

		//ユーザグループには posts と widgets に対する追加と編集を許可する
		$group->id = 3;
		$this->Acl->deny($group, 'controllers');
		$this->Acl->allow($group, 'controllers/Posts/add');
		$this->Acl->allow($group, 'controllers/Posts/edit');
		$this->Acl->allow($group, 'controllers/Posts/delete');
		$this->Acl->allow($group, 'controllers/Widgets/add');
		$this->Acl->allow($group, 'controllers/Widgets/edit');

		//馬鹿げた「ビューが見つからない」というエラーメッセージを表示させないために exit を追加します
		echo "all done";
		exit;
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
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
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->User->recursive = 1;
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$user = $this->User->find('first', $options);

		$this->Paginator->settings = array(
			'conditions' => array('Post.user_id' => $id),
			'limit' => $this->paginateLimit
		);
		$data = $this->Paginator->paginate('Post');

		$this->set('posts', $data);
		$this->set('user', $user);
		$this->request->data = $user;

		// paginationの表示・非表示
		$conditions = array('conditions' => array('Post.user_id' => $id));
		$postsCount = $this->User->Post->find('count', $conditions);
		$this->_setisPaginationDisplay($postsCount);

		$isOwner = $this->Auth->user('id') == $id;
		$this->set('isOwner', $isOwner);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add()
	{
		if ($this->request->is('post')) {
			$this->User->create();

			if ($this->User->saveAll(($this->request->data), array('deep' => true))) {
				$this->Session->setFlash(__('新規登録が完了しました。'), 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));
				$this->Auth->login();
				return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}

		// グループリストをviewにセット
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
		$this->_setPrefectures();
		$this->_setRegions();
	}

	public function ajax_AdressDisplay()
	{
		// Ajax以外の通信の場合
		if (!$this->request->is('ajax')) {
			throw new BadRequestException();
		}

		// 使用するモデルデータを読み込む
		$this->loadModel('Zipcode');
		$this->loadModel('Prefecture');

		// view描画しない(MissingView対策)
		$this->autoRender = false;

		// 郵便番号で検索。都道府県・市区町村を取得
		$zipcode = $this->request->data['zipcode'];
		$adress = $this->Zipcode->find('all', array(
			'fields' => array('Zipcode.pref', 'Zipcode.city', 'Zipcode.street'),
			'conditions' => array('Zipcode.zipcode' => $zipcode),
		));
		if (empty($adress)) {
			$errorMsg = "※郵便番号に該当する住所情報が存在しません。";
			return json_encode($errorMsg);
		}

		// 県のidを取得
		$pref = $adress[0]['Zipcode']['pref'];
		$prefIndexArray = $this->Prefecture->find('first', array(
			'fields' => 'Prefecture.id',
			'conditions' => array('Prefecture.name' => $pref)
		));

		return json_encode(array($adress[0], $prefIndexArray));
	}

	public function ajax_SetPrefList()
	{
		// Ajax以外の通信の場合
		if (!$this->request->is('ajax')) {
			throw new BadRequestException();
		}

		// 使用するモデルデータを読み込む
		$this->loadModel('Prefecture');

		// view描画しない(MissingView対策)
		$this->autoRender = false;

		// 選択された地方のidを取得し、それに該当する県名一覧をリストで取得
		$inputValue = $this->request->data['value'];
		$prefList = $this->Prefecture->find('list', array(
			'fields' => 'Prefecture.name',
			'conditions' => array('Prefecture.region_id' => $inputValue)
		));

		// 県名一覧でセットされたリストの一番上の県名に該当する市一覧を取得
		$cityList = $this->_getCityList(reset($prefList));

		// JQueryのidをここで設定
		$prefId = 'prefSelect';
		$cityId = 'citySelect';
		return json_encode(array(array($prefId, $prefList), array($cityId, $cityList)));
	}

	public function ajax_SetCityList()
	{
		// Ajax以外の通信の場合
		if (!$this->request->is('ajax')) {
			throw new BadRequestException();
		}

		// view描画しない(MissingView対策)
		$this->autoRender = false;

		// 使用するモデルデータを読み込む
		$pref = $this->request->data['value'];
		$cityList = $this->_getCityList($pref);

		$selecterId = 'citySelect';
		return json_encode(array(array($selecterId, $cityList)));
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
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$user = $this->User->find('first', $options);
		if ($this->request->is(array('post', 'put'))) {


			// 画像ファイルであるかチェック
			if (!$this->_isProfileImage($user)) {
				return;
			}

			//サムネイル画像差替え
			$this->_modfiyThumbnail($user);

			if ($this->User->saveAll(($this->request->data))) {
				$this->Session->setFlash(__('編集を保存しました。'), 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));

				return $this->redirect(array('controller' => 'users', 'action' => "view/${id}"));
			} else {
				$this->Session->setFlash(__('保存できませんでした。'), 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			}
		}

		$this->set('user', $user);
		$this->request->data = $user;
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
		$this->_setPrefectures();
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
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete($id)) {
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function login()
	{
		if ($this->Session->read('Auth.User')) {
			$this->redirect('/', null, false);
		}
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			}
			$this->Session->setFlash(__('ログインに失敗しました。idまたはパスワードが異なっています。'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-danger'
			));
		}
	}

	public function logout()
	{
		$this->Session->setFlash(__('ログアウトしました。'), 'alert', array(
			'plugin' => 'BoostCake',
			'class' => 'alert-success'
		));
		$this->redirect($this->Auth->logout());
	}


	// 非アクション関数
	public function _setPrefectures()
	{
		$this->loadModel('Prefecture');
		$prefList = $this->Prefecture->find('list', array('fields' => 'Prefecture.name'));
		array_unshift($prefList, '都道府県を選択');
		$this->set(compact('prefList'));
	}

	public function _setRegions()
	{
		$this->loadModel('Region');
		$regionList = $this->Region->find('list', array('fields' => 'Region.name'));
		$this->set(compact('regionList'));
	}

	public function _isProfileImage($user = null)
	{
		// 画像ファイルが選択されていなければ配列を削除
		if ($this->request->data['Profileimage']['profile']['size'] == 0) {
			unset($this->request->data['Profileimage']);

			return true;
		}

		// 画像ファイルであるかチェック
		$this->User->Profileimage->set($this->request->data['Profileimage']);
		if (!$this->User->Profileimage->validates()) {
			$this->Session->setFlash(__('画像ファイルを選択してください。'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
			$this->set('user', $user);
			return false;
		}

		return true;
	}

	public function _modfiyThumbnail($user = null)
	{
		// サムネを差し替える。
		$profileimageId = $user['Profileimage']['id'];
		$this->User->Profileimage->delete($profileimageId);
	}

	// 県名に該当する市区町村リストを取得
	public function _getCityList($pref)
	{
		// 使用するモデルデータを読み込む
		$this->loadModel('Zipcode');

		// 県名に該当する市区町村一覧を重複無しで取得
		$cityListAll = $this->Zipcode->find('all', array(
			'fields' => 'DISTINCT Zipcode.city',
			'conditions' => array('Zipcode.pref' => $pref),
		));

		// allで取得した市区町村一覧をlist化
		$cityList = array();
		$index = 0;
		foreach ($cityListAll as $i) {
			foreach ($i as $key => $value) {
				$cityList += array($index => $value['city']);
				$index++;
			}
		}

		return $cityList;
	}
}
