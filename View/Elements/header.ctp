	<!-- ヘッダー -->

	<header class="blog-header py-3">
		<div class="container">
			<div class="row flex-wrap justify-content-between align-items-center header_items ">
				<div class="col-md-4 d-flex align-items-md-center no-gutters item_search">
					<a class="text-muted" href="#" id="search">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24" focusable="false">
							<title>Search</title>
							<circle cx="10.5" cy="10.5" r="7.5" />
							<path d="M21 21l-5.2-5.2" />
						</svg>
					</a>
					<?php echo $this->Form->create('Post', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'class' => 'form-inline')); ?>
					<div class="input-group search_wrapper">
						<?php echo $this->Form->input('keyword', array('label' => false, 'placeholder' => 'タイトル・タグ・カテゴリー', "class" => "search_form form-control-sm search_input")); ?>
						<div class="input-group-append ">
							<?php echo $this->Form->submit('検索', array("class" => "btn btn-sm btn-outline-secondary search_form")); ?>
							<?php echo $this->Form->end(array('type' => 'hidden')); ?>
						</div>
					</div>
				</div>

				<div class="col-md-4 text-center item_text">
					<a class="blog-header-logo text-dark" href="http://blog.dev1/cakephp/">Blog</a>
				</div>

				<div class="col-md-4 pt-1 d-md-flex justify-content-md-end align-items-md-center item_buttons">
					<a href=<?php echo $addUrl ?> class="btn-sm fas fa-pencil-alt mr-3 mb-n2 text-secondary">
						記事を投稿する
					</a>
					<a class="btn btn-sm btn-outline-primary mr-2 loginOrlogout" href=<?php echo $linkAdress ?>><?php echo $btnStr ?></a>
					<?php if (!$isLogin) { ?>
						<a class="btn btn-sm btn-outline-secondary signup" href="http://blog.dev1/cakephp/users/add">Sign up</a>
					<?php } else { ?>
						<a class="btn btn-sm btn-outline-secondary signup" href=<?php echo "http://blog.dev1/cakephp/users/view/" . $userId ?>>My Page</a>
					<?php } ?>
				</div>
			</div>
	</header>
	<div class="container">
		<div class="header-border"></div>
