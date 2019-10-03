<!-- メニューバー -->
<div class="container">
	<div class="nav-scroller py-1 mb-2">
		<nav class="nav d-flex justify-content-between">
			<?php foreach ($categorieList as $category) : ?>
				<?php $id = $category['Category']['id']; ?>
				<a class="p-2 text-muted" href=<?php echo "http://blog.dev1/cakephp/categories/view/${id}" ?>>
					<?php echo h($category['Category']['name']); ?>
				</a>
			<?php endforeach; ?>
		</nav>
	</div>

	<div class="row">
		<div class="col-md-8 mx-md-auto ">
			<div class="pt-4 blog-post-meta text-left mb-2">
				<?php
				$date = $post['Post']['created'];
				echo date('Y-m-d', strtotime(str_replace('-', '/', $date)));
				?>
				<?php if ($isOwner) { ?>
					<?php echo $this->Form->postLink(
							__('削除する'),
							array('action' => 'delete', $post['Post']['id']),
							array('class' => 'edit'),
							array('本当にこの記事を削除してもよろしいですか?')
						); ?>
					<div class="edit">
						<svg role="img" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 2.25 24 24" aria-labelledby="binIconTitle" stroke="#9b9b9b" stroke-width="2.4" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#9b9b9b">
							<title id="binIconTitle">Bin</title>
							<path d="M19 6L5 6M14 5L10 5M6 10L6 20C6 20.6666667 6.33333333 21 7 21 7.66666667 21 11 21 17 21 17.6666667 21 18 20.6666667 18 20 18 19.3333333 18 16 18 10" />
						</svg>
					</div>
					<a href="/cakephp/posts/edit/<?php echo $post['Post']['id'] ?>" class="edit">
						編集する
					</a>

					<div class="edit">
						<svg role="img" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 2.25 24 24" aria-labelledby="newIconTitle" stroke="#9b9b9b" stroke-width="2.4" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#9b9b9b">
							<title id="newIconTitle">New</title>
							<path d="M19 14V22H2.99997V4H13" />
							<path d="M17.4608 4.03921C18.2418 3.25817 19.5082 3.25816 20.2892 4.03921L20.9608 4.71079C21.7418 5.49184 21.7418 6.75817 20.9608 7.53921L11.5858 16.9142C11.2107 17.2893 10.702 17.5 10.1716 17.5L7.5 17.5L7.5 14.8284C7.5 14.298 7.71071 13.7893 8.08579 13.4142L17.4608 4.03921Z" />
							<path d="M16.25 5.25L19.75 8.75" />
						</svg>
					</div>
				<?php } ?>
			</div>


			<h1 class="text-left view-title">
				<?php echo h($post['Post']['title']); ?>
			</h1>

			<?php $id = $post['Category']['id']; ?>

			<a href=<?php echo "http://blog.dev1/cakephp/categories/view/${id}" ?> class="text-decoration-none">
				<span class="badge badge-pill badge-info category-link">
					<?php echo $post['Category']['name']; ?>
				</span>
			</a>

			<?php
			$tagCount = count($post['Tag']);
			for ($i = 0; $i < $tagCount; $i++) {
				?>
				<?php $tagId = $post['Tag'][$i]['id']; ?>
				<a href=<?php echo "http://blog.dev1/cakephp/Tags/view/${tagId}" ?> class="text-decoration-none">
					<span class=" badge badge-pill badge-light tag-link">
						<?php
							echo h($post['Tag'][$i]['name'] . ' ');
							?>
					</span>
				</a>
			<?php } ?>

			<!-- <img src="https://picsum.photos/710/350/?random" class="mt-3 thumbnail" alt=""> -->
			<?php
			//サムネイルの表示
			$thumbName = $post['Thumbnail']['thumbnailimage'];
			$thumbPath = $post['Thumbnail']['dir'];
			$base_ = "../files/thumbnail/thumbnailimage/";
			if ($thumbName !== null) {
				echo $this->Html->image($base_ . $thumbPath . DS . $thumbName, array("class" => "rounded mx-auto d-block mt-3 thumbnail"));
			}
			?>

			<dd>
				<p class="mb-4 mt-5 body-text">&nbsp;<?php echo h($post['Post']['body']); ?> </p>
				&nbsp;
			</dd>
			<dd>
				<!-- ポップアップ背景 -->
				<div class="popupbg"> </div>
				<div class="background-img"></div>
				<!-- スピナー -->
				<div class="spiner_wrapper">
					<div class="spinner-border text-secondary spiner" role="status">
						<span class="sr-only">Loading...</span>
					</div>
				</div>

				<?php
				// 画像の数を取得
				$photoCount = count($post['Attachment']);
				// 画像の表示
				for ($i = 0; $i < $photoCount; $i++) {
					$identificationId = $post['Post']['id'];
					$imgId = $post['Attachment'][$i]['id'];
					$imgName = $post['Attachment'][$i]['attachment'];
					$imgPath = $post['Attachment'][$i]['dir'];
					$base = "../files/attachment/attachment/";
					?>

					<a href=<?php echo "\"#${imgId}\"" ?> class="pop ">
						<img src=<?php echo "/cakephp/img/" . $base . $imgPath . DS . 'normal_'  . $imgName ?> alt="" class="mb-1 mt-1">
					</a>
					<!--  ポップアップしたい要素 -->
					<div id=<?php echo "\"${imgId}\"" ?> class="popup_wrapper">
						<img src=<?php echo "/cakephp/img/" . $base . $imgPath . DS . $imgName ?> alt="" class="img lb-outerContainer" id=<?php echo $imgName ?>>
						<p class="caption"><?php echo $imgName  ?></p>
						<img src="/cakephp/img/close.png" class="close_image" alt="">
						<img src="/cakephp/img/prev.png" alt="" class="prev_btn">
						<img src="/cakephp/img/next.png" alt="" class="next_btn">
					</div>
				<?php } ?>
				<div class="row">
					<?php foreach ($relatedArticles as $relatedArticle) : ?>
						<?php $id = $relatedArticle['Post']['id']; ?>
						<div class="col-sm-6 col-md-3 related-card">
							<div class="card img-thumbnail">
								<?php
									//サムネイルの表示
									$thumbName = $relatedArticle['Thumbnail']['thumbnailimage'];
									$thumbPath = $relatedArticle['Thumbnail']['dir'];
									$base_ = "/files/thumbnail/thumbnailimage/";
									?>
								<?php if ($thumbName !== null) :	?>
									<a href=<?php echo "http://blog.dev1/cakephp/posts/view/${id}" ?> class="text-dark">
										<img class="card-img-top related-card-img" src=<?php echo "/cakephp/" . $base_ . $thumbPath . DS . 'normal_' . $thumbName; ?> alt="画像">
									</a>
								<?php else : ?>
									<a href=<?php echo "http://blog.dev1/cakephp/posts/view/${id}" ?> class="text-dark">
										<img class="card-img-top related-card-img" src=<?php echo "/cakephp/img/noimage_midium.png"; ?> alt="画像">
									</a>
								<?php endif; ?>
								<div class="card-body realated-card-body">
									<a href=<?php echo "http://blog.dev1/cakephp/posts/view/${id}" ?> class="text-dark">
										<h5 class="card-title related-card-title"><?php echo $this->Text->truncate($relatedArticle['Post']['title'], 20, array('ellipsis' => '...', 'class' => 'text-dark')) ?></h5>
									</a>
								</div><!-- /.card-body -->
							</div><!-- /.card -->
							<p class="mb-0 text-muted linkadress">blog1.dev.com</p>
						</div><!-- /.col-sm-6.col-md-3 -->

					<?php endforeach; ?>
				</div>


		</div>
		<?php echo $this->element('sidebar'); ?>
	</div>
