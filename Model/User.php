<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Group $Group
 * @property Post $Post
 */
class User extends AppModel
{

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'username' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'login' => array(
				'rule' => 'isUnique',
				'message' => 'そのユーザ名はすでに使われています。'
			)
		),
		'password' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'extension' => array(
			'rule' => array(
				'extension', array(
					'jpg', 'jpeg', 'png', 'gif'
				)  // 拡張子を配列で定義
			),
			'message' => array('file extension error')
		)
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Group' => array(
			/* 'className' => */
			'Group' //,
			// 'foreignKey' => 'group_id',
			// 'conditions' => '',
			// 'fields' => '',
			// 'order' => ''
		)
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public $hasOne = array(
		'Profileimage' => array(
			'className' => 'Profileimage',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => array(
				'Profileimage.model' => 'User',
			),
		)
	);

	public $actsAs = array('Acl' => array('type' => 'requester', 'enabled' => false));

	public function beforeSave($options = array())
	{
		$this->data['User']['password'] = AuthComponent::password(
			$this->data['User']['password']
		);
		return true;
	}

	public function parentNode()
	{
		if (!$this->id && empty($this->data)) {
			return null;
		}
		if (isset($this->data['User']['group_id'])) {
			$groupId = $this->data['User']['group_id'];
		} else {
			$groupId = $this->field('group_id');
		}
		if (!$groupId) {
			return null;
		} else {
			return array('Group' => array('id' => $groupId));
		}
	}

	public function bindNode($user)
	{
		return array('model' => 'Group', 'foreign_key' => $user['User']['group_id']);
	}
}
