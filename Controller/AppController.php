<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::import('Vendor', 'accesslogs');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
  public $components = array(
    'DebugKit.Toolbar',
    'Acl',
    'Flash' => array(
      'element' => 'alert',
      'key' => 'auth',
      'params' => array(
        'plugin' => 'BoostCake',
        'class' => 'alert-error'
      )
    ),
    'Auth' => array(
      'authorize' => array(
        'Actions' => array('actionPath' => 'controllers')
      ),
    ),
    'Session',
    'RequestHandler',
  );

  public $helpers = array(
    'Session',
    'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
    'Form' => array('className' => 'BoostCake.BoostCakeForm'),
    'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
  );

  protected $paginateLimit = 5;

  public function beforeFilter()
  {
    $this->access = new AccessLogs();
    $this->access->write_log();

    // AuthComponent の設定
    $this->Auth->loginAction = array(
      'controller' => 'users',
      'action' => 'login'
    );
    $this->Auth->logoutRedirect = array(
      'controller' => 'posts',
      'action' => 'index'
    );
    $this->Auth->loginRedirect = array(
      'controller' => 'posts',
      'action' => 'index'
    );

    $this->Auth->allow('display');
    $this->set('paginateLimit', $this->paginateLimit);


    // ログインしているか
    $isLogin = $this->Auth->user('id') != 0 ? true : false;
    $this->set('isLogin', $isLogin);

    $this->loadModel('User');
    $user = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->User('id'))));
    $this->set('user', $user);

    $this->_setCurrentUserStatus();
    $this->_setaddArticleUrl();
    $this->_setArticleRanking();
  }

  // ログイン状況のセット
  public function _setCurrentUserStatus()
  {
    $user_id = $this->Auth->user('id');
    if ($user_id !== null) {
      $btnStr = 'Logout';
      $linkAdress = "http://blog.dev1/cakephp/users/logout";
    } else {
      $btnStr = 'Log in';
      $linkAdress = "http://blog.dev1/cakephp/users/login/";
    }

    $this->set('btnStr', $btnStr);
    $this->set('linkAdress', $linkAdress);
    $this->set('userId', $this->Auth->user('id'));
  }

  // ページネーションを表示するかセット
  public function _setisPaginationDisplay($postsCount)
  {
    $isPaginationDisplay = $postsCount > $this->paginateLimit;
    $this->set('isPaginationDisplay', $isPaginationDisplay);
  }

  // 記事投稿URLのセット
  public function _setaddArticleUrl()
  {
    if (!empty($this->params['pass'])) {
      $addUrl = "http://blog.dev1/cakephp/posts/add/" . $this->params['pass'][0];
    } else {
      $addUrl = "http://blog.dev1/cakephp/posts/add/";
    }

    $this->set('addUrl', $addUrl);
  }

  // 記事ランキングをセット
  public function _setArticleRanking()
  {
    $this->loadModel('Post');
    $articleRanking = $this->Post->find('all', array('limit' => 3, 'order' => 'accesscount desc'));
    $this->set('articleRanking', $articleRanking);
  }
}
