<?php
App::uses('AppController', 'Controller');
/**
 * Tags Controller
 *
 * @property Tag $Tag
 * @property PaginatorComponent $Paginator
 */
class TagsController extends AppController
{

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator');
	public $presetVars = true;

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('view');
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->Tag->recursive = 1;
		$this->set('tags', $this->Paginator->paginate());

		// searchのバリテーションチェック
		$this->Prg->commonProcess();

		// 検索条件のconditionsをpaginateに渡している。
		$this->paginate = array(
			'conditions' => $this->Tag->parseCriteria($this->passedArgs),
			'order' => array('id' => 'desc'),
			'limit' => $this->paginateLimit,
		);
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
		if (!$this->Tag->exists($id)) {
			throw new NotFoundException(__('Invalid tag'));
		}
		$options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id));
		$this->set('tag', $this->Tag->find('first', $options));
		$posts = $this->Tag->Post->find('all', array('conditions' => 'Tag'));

		$this->Tag->recursive = 1;

		$conditions = array(
			'conditions' => array('PostsTag.tag_id' => $id),
			'limit' => $this->paginateLimit,
			'joins' => array(
				array(
					'table' => 'posts_tags',
					'alias' => 'PostsTag',
					'type' => 'INNER',
					'conditions' => array(
						'PostsTag.tag_id' => $id,
						'PostsTag.post_id = Post.id'
					)
				)
			),
			'order' => array('popularity' => 'desc'),
		);

		$this->Paginator->settings = $conditions;
		$posts = $this->Paginator->paginate('Post');
		$this->set('posts', $posts);

		$postsCount = $this->Tag->Post->find('count', $conditions);
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
			$this->Tag->create();
			debug($this->request->data);
			return;
			if ($this->Tag->save($this->request->data)) {
				$this->Flash->success(__('The tag has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The tag could not be saved. Please, try again.'));
			}
		}
		$posts = $this->Tag->Post->find('list');
		$this->set(compact('posts'));
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
		if (!$this->Tag->exists($id)) {
			throw new NotFoundException(__('Invalid tag'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Tag->save($this->request->data)) {
				$this->Flash->success(__('The tag has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The tag could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id));
			$this->request->data = $this->Tag->find('first', $options);
		}
		$posts = $this->Tag->Post->find('list');
		$this->set(compact('posts'));
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
		if (!$this->Tag->exists($id)) {
			throw new NotFoundException(__('Invalid tag'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Tag->delete($id)) {
			$this->Flash->success(__('The tag has been deleted.'));
		} else {
			$this->Flash->error(__('The tag could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
