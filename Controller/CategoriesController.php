<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class CategoriesController extends AppController
{

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Search.Prg');
	public $presetVars = true;

	public function beforeFilter()
	{
		parent::beforeFilter();

		// カテゴリー一覧
		$this->set('categorieList', $this->Category->find('all', array(
			'fields' => array('Category.name'),
		)));
		$this->Auth->allow('view');
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->Category->recursive = 1;
		$this->set('categories', $this->Paginator->paginate());
		// debug($this->Category->Post->find('all'));

		$this->Post->recursive = 1;
		// searchのバリテーションチェック
		$this->Prg->commonProcess();
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
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}

		$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
		$this->set('category', $this->Category->find('first', $options));

		$this->loadModel('Post');
		$this->Paginator->settings = array(
			'conditions' => array('Post.categorie_id' => $id),
			'limit' => $this->paginateLimit
		);
		$posts = $this->Paginator->paginate('Post');
		$this->set('posts', $posts);

		$conditions = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
		$postsCount = $this->Post->find('count', $conditions);
		$this->_setisPaginationDisplay($postsCount);
	}
	/**
	 * add method
	 *
	 * @return void
	 */
	public function add()
	{
		if ($this->request->is('post')) {
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Flash->success(__('The category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The category could not be saved. Please, try again.'));
			}
		}
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
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Category->save($this->request->data)) {
				$this->Flash->success(__('The category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
			$this->request->data = $this->Category->find('first', $options);
		}
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
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Category->delete($id)) {
			$this->Flash->success(__('The category has been deleted.'));
		} else {
			$this->Flash->error(__('The category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
