<?php
App::uses('AppController', 'Controller');
/**
 * Thumbnails Controller
 *
 * @property Thumbnail $Thumbnail
 * @property PaginatorComponent $Paginator
 */
class ThumbnailsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Thumbnail->recursive = 0;
		$this->set('thumbnails', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Thumbnail->exists($id)) {
			throw new NotFoundException(__('Invalid thumbnail'));
		}
		$options = array('conditions' => array('Thumbnail.' . $this->Thumbnail->primaryKey => $id));
		$this->set('thumbnail', $this->Thumbnail->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Thumbnail->create();
			if ($this->Thumbnail->save($this->request->data)) {
				$this->Flash->success(__('The thumbnail has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The thumbnail could not be saved. Please, try again.'));
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
	public function edit($id = null) {
		if (!$this->Thumbnail->exists($id)) {
			throw new NotFoundException(__('Invalid thumbnail'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Thumbnail->save($this->request->data)) {
				$this->Flash->success(__('The thumbnail has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The thumbnail could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Thumbnail.' . $this->Thumbnail->primaryKey => $id));
			$this->request->data = $this->Thumbnail->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->Thumbnail->exists($id)) {
			throw new NotFoundException(__('Invalid thumbnail'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Thumbnail->delete($id)) {
			$this->Flash->success(__('The thumbnail has been deleted.'));
		} else {
			$this->Flash->error(__('The thumbnail could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
