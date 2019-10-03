<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>

<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
	echo $this->Html->meta('icon');

	// jQery CDN
	echo $this->Html->script("https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js");
	// アイコンCDN
	echo $this->Html->script("https://unpkg.com/ionicons@4.5.5/dist/ionicons.js");

	// Twitter Bootstrap 4.3.1 CDN
	echo $this->Html->css('https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
	echo $this->Html->css("https://fonts.googleapis.com/css?family=Playfair+Display:700,900");
	echo $this->Html->css('blog.css', array('plugin' => false));
	echo $this->Html->css('popup.css', array('plugin' => false));



	// fontawesome CDN
	echo $this->Html->script("https://kit.fontawesome.com/23ffccf443.js");

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	?>
</head>
<div class="container">
	<?php echo $this->Session->flash(); ?>
</div>
<?php echo $this->element('header'); ?>

<body>
	<div id="container">
		<div id="header">

		</div>
		<div id="content">

			<?php //echo $this->Flash->render();
			?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
				$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
				'https://cakephp.org/',
				array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
			);
			?>
			<p>
				<?php echo $cakeVersion; ?>
			</p>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
<?php
// JQuery & Popper CDN
echo $this->Html->script("https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js");
echo $this->Html->script('https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
echo $this->Html->script('index.js', array('plugin' => false));
?>

</html>
