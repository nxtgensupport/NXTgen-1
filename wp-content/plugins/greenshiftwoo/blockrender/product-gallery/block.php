<?php


namespace greenshiftwoo\Blocks;

defined('ABSPATH') or exit;


class ProductGallery
{

	public function __construct()
	{
		add_action('init', array($this, 'init_handler'));
	}

	public function init_handler()
	{
		register_block_type(
			__DIR__,
			array(
				'render_callback' => array($this, 'render_block'),
				'attributes'      => $this->attributes
			)
		);
	}

	public $attributes = array(
		'id' => array(
			'type'    => 'string',
			'default' => null,
		),
		'inlineCssStyles' => array(
			'type'    => 'string',
			'default' => '',
		),
		'animation' => array(
			'type' => 'object',
			'default' => array(),
		),
		'sourceType'       => array(
			'type'    => 'string',
			'default' => 'latest_item',
		),
		'postId'       => array(
			'type'    => 'number',
			'default' => 0,
		),
		'direction'       => array(
			'type'    => 'string',
			'default' => 'horizontal',
		),
		'slidesPerView' => array(
			'type'    => 'array',
			'default' => [4, 4, 4, 4],
		),
		'spaceBetween' => array(
			'type'    => 'array',
			'default' => [10, 10, 10, 10],
		),
		'navigationarrows' => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'disableMobileVertical' => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'disableAttachments' => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'main_image_size' => array(
			'type'    => 'string',
			'default' => '',
		),
		'thumbnail_image_size' => array(
			'type'    => 'string',
			'default' => '',
		),
	);

	public function render_block($settings = array(), $inner_content = '')
	{
		extract($settings);

		if ($sourceType == 'latest_item') {
			global $post;
			if (is_object($post)) {
				if($post->post_type == 'product'){
					$postId = $post->ID;
				}else{
					$postId = 0;
				}
			} else {
				$postId = 0;
			}
		} else {
			$postId = (isset($postId) && $postId > 0) ? (int)$postId : 0;
		}

		$_product = gspbwoo_get_product_object_by_id($postId);

		if (!$_product) return __('Product not found.', 'greenshiftwoo');

		$htmlGallery = $this->gallery_html($_product, $slidesPerView, $spaceBetween, $navigationarrows,$disableAttachments, $main_image_size, $thumbnail_image_size);

		$htmlGallery = !empty($htmlGallery) ? $htmlGallery : '';

		$blockId = 'gspb_id-' . $id;
		$disablemobileClass = $disableMobileVertical ? ' disable-mobile-vertical' : '';
		$blockClassName = 'gspb-product-image-gallery ' . $blockId . $disablemobileClass . ' ' . (!empty($className) ? $className : '') . ' ';

		$out = '<div  class="' . $blockClassName . '"' . gspb_AnimationRenderProps($animation) . ' data-direction="' . $direction . '">';
		$out .= $htmlGallery;
		$out .= '</div>';
		return $out;
	}

	public function wp_get_attachment_image_without_srcset($attachment_id, $size = 'full', $icon = false, $attr = '')
	{
		// Add a filter to return null for srcset.
		add_filter('wp_calculate_image_srcset_meta', '__return_null');
		// Get the attachment image sans-srcset attribute.
		$result = wp_get_attachment_image($attachment_id, $size, $icon, $attr);
		// Remove the null srcset filter, to avoid global application.
		remove_filter('wp_calculate_image_srcset_meta', '__return_null');
		return $result;
	}

	public function gallery_html($_product, $slidesPerView, $spaceBetween, $navigationarrows, $disableAttachments, $main_image_size, $thumbnail_image_size)
	{
		$product_id = $_product->get_id();
		$featured_image = $_product->get_image_id();
		$image_ids = $_product->get_gallery_image_ids();
		$imagealt = get_post_meta($featured_image, '_wp_attachment_image_alt', TRUE);
		$videomain = get_post_meta($featured_image, 'gs_video_field', TRUE);
		$title = get_the_title($product_id);
		if (empty($imagealt)) {
			$imagealt = $title;
		}
		$threegalleryID = '';
		$threegallery = get_post_meta($product_id, 'greenshiftwoo360_image_gallery', true);
		$threegalleryArray = (!empty($threegallery)) ? explode(',', $threegallery) : '';
		if (!empty($threegalleryArray)) {
			$threegalleryID = $threegalleryArray[0];
		}
		$fileGallery = get_post_meta($product_id, 'greenshiftwoo_extended_gallery', true);
		$variationGallery = get_post_meta($product_id, 'greenshiftwoo_all_variation_galleries', true);
		$main_size = !empty($main_image_size) ? $main_image_size : 'woocommerce_single';
		$thumbnail_size = !empty($thumbnail_image_size) ? $thumbnail_image_size : 'woocommerce_gallery_thumbnail';
		ob_start();
	?>
		<div class="gspb-product-image-gallery-wrap gspb_product_gallery_lightbox">
			<div class="swiper gspb-gallery-full<?php if (empty($image_ids ) && !$threegalleryID && empty($fileGallery) && empty($variationGallery)) echo ' gspb-gallery-no-slider'; ?>">
				<div class="swiper-wrapper">
					<?php if (!empty($featured_image)) : ?>
						<div class="swiper-slide swiper-slide-main-image">
							<?php if ($videomain && filter_var($videomain, FILTER_VALIDATE_URL) && function_exists('gs_video_thumbnail_html')) : ?>
								<?php echo gs_video_thumbnail_html($videomain, $featured_image, $imagealt, '60', $main_size); ?>
							<?php else : ?>
								<a href="<?php echo esc_url(wp_get_attachment_url($featured_image)); ?>" title="<?php echo esc_attr($imagealt); ?>" class="imagelink">
									<?php echo wp_get_attachment_image($featured_image, $main_size, false, [
										'data-main-featured-image-src' => wp_get_attachment_image_src($featured_image, $main_size)[0],
										'data-main-featured-image-srcset' => wp_get_attachment_image_srcset($featured_image, $main_size),
										'loading' => 'eager'
									]) ?>
								</a>
							<?php endif; ?>
						</div>
						<?php if (!empty($image_ids)) : ?>
							<?php foreach ($image_ids as $image_id) : ?>
								<?php $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
								$video = get_post_meta($image_id, 'gs_video_field', TRUE);
								if (empty($image_alt)) {
									$image_alt = $title;
								}
								?>
								<div class="swiper-slide<?php if ($video && (strpos($video, '.gltf') != false || strpos($video, '.glb') != false || strpos($video, '.splinecode') != false)) : ?> swiper-no-swiping<?php endif;?>">
									<?php if ($video && filter_var($video, FILTER_VALIDATE_URL) && function_exists('gs_video_thumbnail_html')) : ?>
										<?php echo gs_video_thumbnail_html($video, $image_id, $image_alt, '60', $main_size); ?>
									<?php else : ?>
										<?php $imageobj = wp_get_attachment_image_src($image_id, $main_size); ?>
										<?php if (!empty($imageobj[0])) : ?>
										<a href="<?php echo esc_url(wp_get_attachment_url($image_id)); ?>" title="<?php echo esc_attr($image_alt); ?>" class="imagelink">
											<?php echo wp_get_attachment_image($image_id, $main_size, false, [
												'data-main-featured-image-src' => $imageobj[0]
											]) ?>
										</a>
										<?php endif; ?>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
						<?php if (!empty($variationGallery)) : ?>
							<?php foreach ($variationGallery as $variationID=>$variationValue) : ?>
								<?php $variationImages= !empty($variationValue['images']) ? $variationValue['images'] : ''; ?>
								<?php if(!empty($variationImages)):?>
									<?php foreach ($variationImages as $variationImage) : ?>
										<?php 
											$variationImage_alt = $variationImage ? get_post_meta($variationImage, '_wp_attachment_image_alt', TRUE) : '';
											$variationVideo = get_post_meta($variationImage, 'gs_video_field', TRUE);
										?>
										<?php if (empty($variationImage_alt)) {
											$variationImage_alt = $title;
										}
										?>
										<div class="swiper-slide slide-variation-images slide-variation-<?php echo (int)$variationID;?><?php if ($variationVideo && (strpos($variationVideo, '.gltf') != false || strpos($variationVideo, '.glb') != false || strpos($variationVideo, '.splinecode') != false)) : ?> swiper-no-swiping<?php endif;?>">
											<?php if ($variationVideo && filter_var($variationVideo, FILTER_VALIDATE_URL) && function_exists('gs_video_thumbnail_html')) : ?>
												<?php echo gs_video_thumbnail_html($variationVideo, $variationImage, $variationImage_alt, '60', $main_size); ?>
											<?php else : ?>
												<a href="<?php echo esc_url(wp_get_attachment_url($variationImage)); ?>" title="<?php echo esc_attr($variationImage_alt); ?>" class="imagelink">
													<?php echo wp_get_attachment_image($variationImage, $main_size) ?>
												</a>
											<?php endif; ?>
										</div>
									<?php endforeach; ?>
								<?php endif;?>
							<?php endforeach; ?>
						<?php endif; ?>
						<?php if (!empty($fileGallery[0]['image']) && function_exists('gs_video_thumbnail_html') && !$disableAttachments) : ?>
							<?php foreach ($fileGallery as $file) : ?>
								<?php $fileimageID = !empty($file['image']) ? $file['image'] : ''; ?>
								<?php $fileURL = !empty($file['file']) ? $file['file'] : ''; ?>
								<?php $file_alt = $fileimageID ? get_post_meta($fileimageID, '_wp_attachment_image_alt', TRUE) : ''; ?>
								<?php if (empty($file_alt)) {
									$file_alt = $title;
								}
								?>
								<div class="swiper-slide<?php if ($fileURL && (strpos($fileURL, '.gltf') != false || strpos($fileURL, '.glb') != false || strpos($fileURL, '.splinecode') != false)) : ?> swiper-no-swiping<?php endif;?>">
									<?php echo gs_video_thumbnail_html($fileURL, $fileimageID, $file_alt, '60', $main_size); ?>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
						<?php if (!empty($threegalleryID) && !$disableAttachments) : ?>
							<div class="swiper-slide swiper-no-swiping">
								<?php echo do_blocks('<!-- wp:greenshift-blocks/threesixty {"id":"gsbp-6fa4b380-1fc3","inlineCssStyles":".gspb_id-gsbp-6fa4b380-1fc3 img{object-fit:cover;display:block;}.gspb_id-gsbp-6fa4b380-1fc3 .gspb-threesixty-lightbox{position:absolute;width:30px;height:30px;left:15px;bottom:15px;background-color:white;border-radius:50%;display:flex;justify-content:center;align-items:center;cursor:pointer;z-index:2;}.gspb_id-gsbp-6fa4b380-1fc3 .gspb-threesixty-lightbox svg{width:15px;}.gspb_id-gsbp-6fa4b380-1fc3 .gspb-threesixty-gallery_placeholder{position:absolute;top:0;left:0;right:0;bottom:0;z-index:1;width:100%;height:100%;transition:opacity 0.3s ease-in-out;}.gspb_id-gsbp-6fa4b380-1fc3:hover .gspb-threesixty-gallery_placeholder{opacity:0;}.gspb_id-gsbp-6fa4b380-1fc3 .gspb-threesixty-gallery_grid{position:relative;}.gspb_id-gsbp-6fa4b380-1fc3:hover{cursor:grab;}.gspb_id-gsbp-6fa4b380-1fc3 .gspb-threesixty-gallery_placeholder span{position:absolute;width:80px;height:80px;left:50%;top:50%;margin:-40px 0 0 -40px;background-color:white;border-radius:50%;display:flex;justify-content:center;align-items:center;}.gspb_id-gsbp-6fa4b380-1fc3 .gspb-threesixty-gallery_placeholder svg{width:40px;}.gspb_id-gsbp-6fa4b380-1fc3 img{width:100%;max-width:100%;}.gspb_id-gsbp-6fa4b380-1fc3 img{height:auto;}","dynamicField":"greenshiftwoo360_image_gallery","post_type":"product","disablelazyload":true,"autoplay":true,"lightbox":true} /-->');?>
							</div>
						<?php endif; ?>
					<?php else : ?>
						<div class="swiper-slide">
							<?php echo sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src($main_size)), esc_html__('Awaiting product image', 'woocommerce')); ?>
						</div>
					<?php endif; ?>
				</div>
				<?php if ((!empty($image_ids) || $threegalleryID || !empty($fileGallery) || !empty($variationGallery)) && $navigationarrows) : ?>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				<?php endif; ?>
			</div>
			<?php if (!empty($image_ids) || $threegalleryID || !empty($fileGallery) || !empty($variationGallery)) : ?>
				<div class="swiper gspb-gallery-thumb" data-slidesperview="<?php echo esc_attr($slidesPerView[0]); ?>" data-slidesperviewmd="<?php echo esc_attr($slidesPerView[1]); ?>" data-slidesperviewsm="<?php echo esc_attr($slidesPerView[2]); ?>" data-slidesperviewxs="<?php echo esc_attr($slidesPerView[3]); ?>" data-spacebetween="<?php echo esc_attr($spaceBetween[0]); ?>" data-spacebetweenmd="<?php echo esc_attr($spaceBetween[1]); ?>" data-spacebetweensm="<?php echo esc_attr($spaceBetween[2]); ?>" data-spacebetweenxs="<?php echo esc_attr($spaceBetween[3]); ?>">
					<div class="swiper-wrapper">
						<?php if (!empty($featured_image)) : ?>
							<div class="swiper-slide swiper-slide-main-image">
								<?php echo $this->wp_get_attachment_image_without_srcset($featured_image, $thumbnail_size, false, [
									'data-main-featured-image-src' => wp_get_attachment_image_src($featured_image, $main_size)[0],
									'loading' => 'eager'
								]) ?>
								<?php if ($videomain && filter_var($videomain, FILTER_VALIDATE_URL)) : ?>
									<div class="gs-gallery-icon-play" style="position: absolute;top: 50%;transform: translate(-50%, -50%);left: 50%;">
										<?php if (strpos($videomain, '.glb') !== false || strpos($videomain, '.gltf') !== false || strpos($videomain, '.splinecode') !== false) : ?>
											<svg width="30" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 454.63">
												<path d="M474.53 297.19c-3.03-12.25-10.85-23.5-23.14-31.67a2.86 2.86 0 0 1-1.13-3.27c.35-1.04.64-2.12.86-3.24.22-1.05.38-2.15.46-3.28l.11-2.01-.24-3.42a2.8 2.8 0 0 1 .22-1.44c.62-1.45 2.3-2.12 3.75-1.5 21.45 9.21 37.46 22.94 46.87 38.6 7.37 12.25 10.7 25.71 9.46 39.13l-.01.08c-1.27 13.44-7.11 26.82-18.06 38.89-14.88 16.39-39.25 30.43-74.46 38.96l-1.7.41c-19.83 4.81-41.87 10.15-65.39 13.05l-.47.04a2.86 2.86 0 0 1-2.86-2.86V388.8a2.87 2.87 0 0 1 2.53-2.84c10.41-1.21 20.43-2.82 30.01-4.66 9.62-1.84 18.79-3.92 27.48-6.07 28.3-6.99 47.29-20.5 57.65-36.1 4.46-6.71 7.32-13.81 8.64-20.91 1.31-7.09 1.1-14.22-.58-21.03zM99.52 51.56 253.03.44c1.84-.62 3.75-.56 5.45.03V.44l155.55 53.28a8.564 8.564 0 0 1 5.8 8.88c.02.19.02.4.02.62v187.59h-.02c0 3.13-1.73 6.15-4.72 7.66l-154.44 78.48a8.624 8.624 0 0 1-4.45 1.24c-1.73 0-3.32-.51-4.67-1.38L96.76 256.07a8.597 8.597 0 0 1-4.61-7.61h-.03V60.09c0-4.35 3.21-7.93 7.4-8.53zm190.69 212.57 3.88-108.55 44.45-14.51c17.11-5.59 28.43-5.36 34.27.52 5.77 5.83 8.27 17.9 7.52 36.22-.73 18.29-4.28 32.5-10.68 42.71-6.46 10.3-18.07 18.85-35.12 25.73l-44.32 17.88zm47.76-96.17-12.86 4.45-1.94 51.77 12.84-4.92c4.18-1.61 7.22-3.28 9.12-5.06 1.91-1.76 2.93-4.53 3.08-8.31l1.29-33.19c.14-3.79-.68-5.89-2.52-6.29-1.82-.42-4.83.09-9.01 1.55zm-150.1 12.57.73-10.22c-3.2-2.29-8.38-5.39-15.54-9.31-7.08-3.87-15.9-7.56-26.39-11.08l-2.43-24.88c12.88 2.82 25.4 7.42 37.56 13.85 10.6 5.62 18.31 10.37 23.08 14.22 4.79 3.88 8.29 7.34 10.5 10.41 4.86 6.93 6.97 14.63 6.34 23.07-.8 10.69-6.02 15.79-15.61 15.27l-.06.8c10.71 10.54 15.67 21.61 14.8 33.11-.42 5.63-1.71 9.89-3.86 12.79-2.14 2.87-4.69 4.59-7.62 5.1-2.92.53-6.68.08-11.27-1.34-6.79-2.17-16.09-6.8-27.84-13.81-11.59-6.92-22.94-15.06-34.07-24.42l6-22.55c9.58 7.97 17.87 14 24.77 17.99 6.98 4.06 13.03 7.23 18.12 9.52l.72-10-27.15-18.26 1.57-22.36 27.65 12.1zm59.74 134.89V135.7L109.34 73.01v170.28l138.27 72.13zM402.62 75.06l-137.79 60.72v179.8l137.79-70.03V75.06zM255.65 17.63 124.87 61.19l131.4 59.59 131.4-57.91-132.02-45.24zM3.84 286.3c6.94-13.62 23.83-26.54 53.61-37.86.39-.16.82-.24 1.27-.21 1.57.11 2.76 1.47 2.66 3.04-.03.53.04 1.56.1 2.11.14 1.87.49 3.72 1.01 5.49.5 1.74 1.19 3.45 2.05 5.1l.18.32c.74 1.37.25 3.09-1.11 3.86-11.68 6.6-18.46 13.23-21.24 19.78-3.58 8.43-.31 17.06 7.65 25.55 8.52 9.07 22.24 17.89 38.81 26.08 54.49 26.97 138.89 46.87 171.76 47.77v-27.72c.01-.67.24-1.34.72-1.88a2.858 2.858 0 0 1 4.02-.27c17.19 15.1 35.95 30.16 52.06 46.27a2.846 2.846 0 0 1-.05 4.03c-16.47 15.93-34.68 30.92-51.92 46.08-.51.49-1.21.79-1.97.79-1.58 0-2.86-1.29-2.86-2.87v-25.74c-58.7 1.19-154.52-27.16-211.85-63.77-18.02-11.5-32.34-23.89-40.63-36.49-8.64-13.13-10.88-26.51-4.27-39.46z" />
											</svg>
										<?php else : ?>
											<svg class="play" width="30px" height="30px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
												<path d="M0 0h48v48H0z" fill="none"></path>
												<path d="m20 33 12-9-12-9v18zm4-29C12.95 4 4 12.95 4 24s8.95 20 20 20 20-8.95 20-20S35.05 4 24 4zm0 36c-8.82 0-16-7.18-16-16S15.18 8 24 8s16 7.18 16 16-7.18 16-16 16z" fill="#ffffff" class="fill-000000"></path>
											</svg>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>

							<?php foreach ($image_ids as $image_id) : ?>
								<?php $video = get_post_meta($image_id, 'gs_video_field', TRUE); ?>
								<div class="swiper-slide">
									<?php $imageobj = wp_get_attachment_image_src($image_id, $main_size); ?>
									<?php if(!empty($imageobj[0])):?>
										<?php echo $this->wp_get_attachment_image_without_srcset($image_id, $thumbnail_size, false, [
										'data-main-featured-image-src' => $imageobj[0],
										'loading' => 'eager'
									]) ?>
									<?php endif;?>
									<?php if ($video && filter_var($video, FILTER_VALIDATE_URL)) : ?>
										<div class="gs-gallery-icon-play" style="position: absolute;top: 50%;transform: translate(-50%, -50%);left: 50%;">
											<?php if (strpos($video, '.glb') !== false || strpos($video, '.gltf') !== false || strpos($video, '.splinecode') !== false) : ?>
												<svg width="30" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 454.63">
													<path d="M474.53 297.19c-3.03-12.25-10.85-23.5-23.14-31.67a2.86 2.86 0 0 1-1.13-3.27c.35-1.04.64-2.12.86-3.24.22-1.05.38-2.15.46-3.28l.11-2.01-.24-3.42a2.8 2.8 0 0 1 .22-1.44c.62-1.45 2.3-2.12 3.75-1.5 21.45 9.21 37.46 22.94 46.87 38.6 7.37 12.25 10.7 25.71 9.46 39.13l-.01.08c-1.27 13.44-7.11 26.82-18.06 38.89-14.88 16.39-39.25 30.43-74.46 38.96l-1.7.41c-19.83 4.81-41.87 10.15-65.39 13.05l-.47.04a2.86 2.86 0 0 1-2.86-2.86V388.8a2.87 2.87 0 0 1 2.53-2.84c10.41-1.21 20.43-2.82 30.01-4.66 9.62-1.84 18.79-3.92 27.48-6.07 28.3-6.99 47.29-20.5 57.65-36.1 4.46-6.71 7.32-13.81 8.64-20.91 1.31-7.09 1.1-14.22-.58-21.03zM99.52 51.56 253.03.44c1.84-.62 3.75-.56 5.45.03V.44l155.55 53.28a8.564 8.564 0 0 1 5.8 8.88c.02.19.02.4.02.62v187.59h-.02c0 3.13-1.73 6.15-4.72 7.66l-154.44 78.48a8.624 8.624 0 0 1-4.45 1.24c-1.73 0-3.32-.51-4.67-1.38L96.76 256.07a8.597 8.597 0 0 1-4.61-7.61h-.03V60.09c0-4.35 3.21-7.93 7.4-8.53zm190.69 212.57 3.88-108.55 44.45-14.51c17.11-5.59 28.43-5.36 34.27.52 5.77 5.83 8.27 17.9 7.52 36.22-.73 18.29-4.28 32.5-10.68 42.71-6.46 10.3-18.07 18.85-35.12 25.73l-44.32 17.88zm47.76-96.17-12.86 4.45-1.94 51.77 12.84-4.92c4.18-1.61 7.22-3.28 9.12-5.06 1.91-1.76 2.93-4.53 3.08-8.31l1.29-33.19c.14-3.79-.68-5.89-2.52-6.29-1.82-.42-4.83.09-9.01 1.55zm-150.1 12.57.73-10.22c-3.2-2.29-8.38-5.39-15.54-9.31-7.08-3.87-15.9-7.56-26.39-11.08l-2.43-24.88c12.88 2.82 25.4 7.42 37.56 13.85 10.6 5.62 18.31 10.37 23.08 14.22 4.79 3.88 8.29 7.34 10.5 10.41 4.86 6.93 6.97 14.63 6.34 23.07-.8 10.69-6.02 15.79-15.61 15.27l-.06.8c10.71 10.54 15.67 21.61 14.8 33.11-.42 5.63-1.71 9.89-3.86 12.79-2.14 2.87-4.69 4.59-7.62 5.1-2.92.53-6.68.08-11.27-1.34-6.79-2.17-16.09-6.8-27.84-13.81-11.59-6.92-22.94-15.06-34.07-24.42l6-22.55c9.58 7.97 17.87 14 24.77 17.99 6.98 4.06 13.03 7.23 18.12 9.52l.72-10-27.15-18.26 1.57-22.36 27.65 12.1zm59.74 134.89V135.7L109.34 73.01v170.28l138.27 72.13zM402.62 75.06l-137.79 60.72v179.8l137.79-70.03V75.06zM255.65 17.63 124.87 61.19l131.4 59.59 131.4-57.91-132.02-45.24zM3.84 286.3c6.94-13.62 23.83-26.54 53.61-37.86.39-.16.82-.24 1.27-.21 1.57.11 2.76 1.47 2.66 3.04-.03.53.04 1.56.1 2.11.14 1.87.49 3.72 1.01 5.49.5 1.74 1.19 3.45 2.05 5.1l.18.32c.74 1.37.25 3.09-1.11 3.86-11.68 6.6-18.46 13.23-21.24 19.78-3.58 8.43-.31 17.06 7.65 25.55 8.52 9.07 22.24 17.89 38.81 26.08 54.49 26.97 138.89 46.87 171.76 47.77v-27.72c.01-.67.24-1.34.72-1.88a2.858 2.858 0 0 1 4.02-.27c17.19 15.1 35.95 30.16 52.06 46.27a2.846 2.846 0 0 1-.05 4.03c-16.47 15.93-34.68 30.92-51.92 46.08-.51.49-1.21.79-1.97.79-1.58 0-2.86-1.29-2.86-2.87v-25.74c-58.7 1.19-154.52-27.16-211.85-63.77-18.02-11.5-32.34-23.89-40.63-36.49-8.64-13.13-10.88-26.51-4.27-39.46z" />
												</svg>
											<?php else : ?>
												<svg class="play" width="30px" height="30px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
													<path d="M0 0h48v48H0z" fill="none"></path>
													<path d="m20 33 12-9-12-9v18zm4-29C12.95 4 4 12.95 4 24s8.95 20 20 20 20-8.95 20-20S35.05 4 24 4zm0 36c-8.82 0-16-7.18-16-16S15.18 8 24 8s16 7.18 16 16-7.18 16-16 16z" fill="#ffffff" class="fill-000000"></path>
												</svg>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
							<?php if (!empty($variationGallery)) : ?>
								<?php foreach ($variationGallery as $variationID=>$variationValue) : ?>
									<?php $variationImages= !empty($variationValue['images']) ? $variationValue['images'] : ''; ?>
									<?php if(!empty($variationImages)):?>
										<?php foreach ($variationImages as $variationImage) : ?>
											<?php $variationVideo = get_post_meta($variationImage, 'gs_video_field', TRUE); ?>
											<div class="swiper-slide slide-variation-images slide-variation-<?php echo (int)$variationID;?>">
												<?php echo $this->wp_get_attachment_image_without_srcset($variationImage, $thumbnail_size, false, [
													'loading' => 'eager'
												]) ?>
												<?php if ($variationVideo && filter_var($variationVideo, FILTER_VALIDATE_URL)) : ?>
													<div class="gs-gallery-icon-play" style="position: absolute;top: 50%;transform: translate(-50%, -50%);left: 50%;">
														<?php if (strpos($variationVideo, '.glb') !== false || strpos($variationVideo, '.gltf') !== false || strpos($variationVideo, '.splinecode') !== false) : ?>
															<svg width="30" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 454.63">
																<path d="M474.53 297.19c-3.03-12.25-10.85-23.5-23.14-31.67a2.86 2.86 0 0 1-1.13-3.27c.35-1.04.64-2.12.86-3.24.22-1.05.38-2.15.46-3.28l.11-2.01-.24-3.42a2.8 2.8 0 0 1 .22-1.44c.62-1.45 2.3-2.12 3.75-1.5 21.45 9.21 37.46 22.94 46.87 38.6 7.37 12.25 10.7 25.71 9.46 39.13l-.01.08c-1.27 13.44-7.11 26.82-18.06 38.89-14.88 16.39-39.25 30.43-74.46 38.96l-1.7.41c-19.83 4.81-41.87 10.15-65.39 13.05l-.47.04a2.86 2.86 0 0 1-2.86-2.86V388.8a2.87 2.87 0 0 1 2.53-2.84c10.41-1.21 20.43-2.82 30.01-4.66 9.62-1.84 18.79-3.92 27.48-6.07 28.3-6.99 47.29-20.5 57.65-36.1 4.46-6.71 7.32-13.81 8.64-20.91 1.31-7.09 1.1-14.22-.58-21.03zM99.52 51.56 253.03.44c1.84-.62 3.75-.56 5.45.03V.44l155.55 53.28a8.564 8.564 0 0 1 5.8 8.88c.02.19.02.4.02.62v187.59h-.02c0 3.13-1.73 6.15-4.72 7.66l-154.44 78.48a8.624 8.624 0 0 1-4.45 1.24c-1.73 0-3.32-.51-4.67-1.38L96.76 256.07a8.597 8.597 0 0 1-4.61-7.61h-.03V60.09c0-4.35 3.21-7.93 7.4-8.53zm190.69 212.57 3.88-108.55 44.45-14.51c17.11-5.59 28.43-5.36 34.27.52 5.77 5.83 8.27 17.9 7.52 36.22-.73 18.29-4.28 32.5-10.68 42.71-6.46 10.3-18.07 18.85-35.12 25.73l-44.32 17.88zm47.76-96.17-12.86 4.45-1.94 51.77 12.84-4.92c4.18-1.61 7.22-3.28 9.12-5.06 1.91-1.76 2.93-4.53 3.08-8.31l1.29-33.19c.14-3.79-.68-5.89-2.52-6.29-1.82-.42-4.83.09-9.01 1.55zm-150.1 12.57.73-10.22c-3.2-2.29-8.38-5.39-15.54-9.31-7.08-3.87-15.9-7.56-26.39-11.08l-2.43-24.88c12.88 2.82 25.4 7.42 37.56 13.85 10.6 5.62 18.31 10.37 23.08 14.22 4.79 3.88 8.29 7.34 10.5 10.41 4.86 6.93 6.97 14.63 6.34 23.07-.8 10.69-6.02 15.79-15.61 15.27l-.06.8c10.71 10.54 15.67 21.61 14.8 33.11-.42 5.63-1.71 9.89-3.86 12.79-2.14 2.87-4.69 4.59-7.62 5.1-2.92.53-6.68.08-11.27-1.34-6.79-2.17-16.09-6.8-27.84-13.81-11.59-6.92-22.94-15.06-34.07-24.42l6-22.55c9.58 7.97 17.87 14 24.77 17.99 6.98 4.06 13.03 7.23 18.12 9.52l.72-10-27.15-18.26 1.57-22.36 27.65 12.1zm59.74 134.89V135.7L109.34 73.01v170.28l138.27 72.13zM402.62 75.06l-137.79 60.72v179.8l137.79-70.03V75.06zM255.65 17.63 124.87 61.19l131.4 59.59 131.4-57.91-132.02-45.24zM3.84 286.3c6.94-13.62 23.83-26.54 53.61-37.86.39-.16.82-.24 1.27-.21 1.57.11 2.76 1.47 2.66 3.04-.03.53.04 1.56.1 2.11.14 1.87.49 3.72 1.01 5.49.5 1.74 1.19 3.45 2.05 5.1l.18.32c.74 1.37.25 3.09-1.11 3.86-11.68 6.6-18.46 13.23-21.24 19.78-3.58 8.43-.31 17.06 7.65 25.55 8.52 9.07 22.24 17.89 38.81 26.08 54.49 26.97 138.89 46.87 171.76 47.77v-27.72c.01-.67.24-1.34.72-1.88a2.858 2.858 0 0 1 4.02-.27c17.19 15.1 35.95 30.16 52.06 46.27a2.846 2.846 0 0 1-.05 4.03c-16.47 15.93-34.68 30.92-51.92 46.08-.51.49-1.21.79-1.97.79-1.58 0-2.86-1.29-2.86-2.87v-25.74c-58.7 1.19-154.52-27.16-211.85-63.77-18.02-11.5-32.34-23.89-40.63-36.49-8.64-13.13-10.88-26.51-4.27-39.46z" />
															</svg>
														<?php else : ?>
															<svg class="play" width="30px" height="30px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
																<path d="M0 0h48v48H0z" fill="none"></path>
																<path d="m20 33 12-9-12-9v18zm4-29C12.95 4 4 12.95 4 24s8.95 20 20 20 20-8.95 20-20S35.05 4 24 4zm0 36c-8.82 0-16-7.18-16-16S15.18 8 24 8s16 7.18 16 16-7.18 16-16 16z" fill="#ffffff" class="fill-000000"></path>
															</svg>
														<?php endif; ?>
													</div>
												<?php endif; ?>
											</div>
										<?php endforeach; ?>
									<?php endif;?>
								<?php endforeach; ?>
							<?php endif; ?>
							<?php if (!empty($fileGallery[0]['image']) && function_exists('gs_video_thumbnail_html') && !$disableAttachments) : ?>
								<?php foreach ($fileGallery as $file) : ?>
									<?php $fileimageID = !empty($file['image']) ? $file['image'] : ''; ?>
									<?php $fileURL = !empty($file['file']) ? $file['file'] : ''; ?>
									<?php $file_alt = $fileimageID ? get_post_meta($fileimageID, '_wp_attachment_image_alt', TRUE) : ''; ?>
									<?php if (empty($file_alt)) {
										$file_alt = $title;
									}
									?>
									<div class="swiper-slide">
										<?php echo $this->wp_get_attachment_image_without_srcset($fileimageID, $thumbnail_size, false, [
											'data-main-featured-image-src' => wp_get_attachment_image_src($fileimageID, $main_size)[0],
											'loading' => 'eager'
										]) ?>
										<?php if ($fileURL && filter_var($fileURL, FILTER_VALIDATE_URL)) : ?>
											<div class="gs-gallery-icon-play" style="position: absolute;top: 50%;transform: translate(-50%, -50%);left: 50%;">
												<?php if (strpos($fileURL, '.glb') !== false || strpos($fileURL, '.gltf') !== false || strpos($fileURL, '.splinecode') !== false) : ?>
													<svg width="30" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 454.63">
														<path d="M474.53 297.19c-3.03-12.25-10.85-23.5-23.14-31.67a2.86 2.86 0 0 1-1.13-3.27c.35-1.04.64-2.12.86-3.24.22-1.05.38-2.15.46-3.28l.11-2.01-.24-3.42a2.8 2.8 0 0 1 .22-1.44c.62-1.45 2.3-2.12 3.75-1.5 21.45 9.21 37.46 22.94 46.87 38.6 7.37 12.25 10.7 25.71 9.46 39.13l-.01.08c-1.27 13.44-7.11 26.82-18.06 38.89-14.88 16.39-39.25 30.43-74.46 38.96l-1.7.41c-19.83 4.81-41.87 10.15-65.39 13.05l-.47.04a2.86 2.86 0 0 1-2.86-2.86V388.8a2.87 2.87 0 0 1 2.53-2.84c10.41-1.21 20.43-2.82 30.01-4.66 9.62-1.84 18.79-3.92 27.48-6.07 28.3-6.99 47.29-20.5 57.65-36.1 4.46-6.71 7.32-13.81 8.64-20.91 1.31-7.09 1.1-14.22-.58-21.03zM99.52 51.56 253.03.44c1.84-.62 3.75-.56 5.45.03V.44l155.55 53.28a8.564 8.564 0 0 1 5.8 8.88c.02.19.02.4.02.62v187.59h-.02c0 3.13-1.73 6.15-4.72 7.66l-154.44 78.48a8.624 8.624 0 0 1-4.45 1.24c-1.73 0-3.32-.51-4.67-1.38L96.76 256.07a8.597 8.597 0 0 1-4.61-7.61h-.03V60.09c0-4.35 3.21-7.93 7.4-8.53zm190.69 212.57 3.88-108.55 44.45-14.51c17.11-5.59 28.43-5.36 34.27.52 5.77 5.83 8.27 17.9 7.52 36.22-.73 18.29-4.28 32.5-10.68 42.71-6.46 10.3-18.07 18.85-35.12 25.73l-44.32 17.88zm47.76-96.17-12.86 4.45-1.94 51.77 12.84-4.92c4.18-1.61 7.22-3.28 9.12-5.06 1.91-1.76 2.93-4.53 3.08-8.31l1.29-33.19c.14-3.79-.68-5.89-2.52-6.29-1.82-.42-4.83.09-9.01 1.55zm-150.1 12.57.73-10.22c-3.2-2.29-8.38-5.39-15.54-9.31-7.08-3.87-15.9-7.56-26.39-11.08l-2.43-24.88c12.88 2.82 25.4 7.42 37.56 13.85 10.6 5.62 18.31 10.37 23.08 14.22 4.79 3.88 8.29 7.34 10.5 10.41 4.86 6.93 6.97 14.63 6.34 23.07-.8 10.69-6.02 15.79-15.61 15.27l-.06.8c10.71 10.54 15.67 21.61 14.8 33.11-.42 5.63-1.71 9.89-3.86 12.79-2.14 2.87-4.69 4.59-7.62 5.1-2.92.53-6.68.08-11.27-1.34-6.79-2.17-16.09-6.8-27.84-13.81-11.59-6.92-22.94-15.06-34.07-24.42l6-22.55c9.58 7.97 17.87 14 24.77 17.99 6.98 4.06 13.03 7.23 18.12 9.52l.72-10-27.15-18.26 1.57-22.36 27.65 12.1zm59.74 134.89V135.7L109.34 73.01v170.28l138.27 72.13zM402.62 75.06l-137.79 60.72v179.8l137.79-70.03V75.06zM255.65 17.63 124.87 61.19l131.4 59.59 131.4-57.91-132.02-45.24zM3.84 286.3c6.94-13.62 23.83-26.54 53.61-37.86.39-.16.82-.24 1.27-.21 1.57.11 2.76 1.47 2.66 3.04-.03.53.04 1.56.1 2.11.14 1.87.49 3.72 1.01 5.49.5 1.74 1.19 3.45 2.05 5.1l.18.32c.74 1.37.25 3.09-1.11 3.86-11.68 6.6-18.46 13.23-21.24 19.78-3.58 8.43-.31 17.06 7.65 25.55 8.52 9.07 22.24 17.89 38.81 26.08 54.49 26.97 138.89 46.87 171.76 47.77v-27.72c.01-.67.24-1.34.72-1.88a2.858 2.858 0 0 1 4.02-.27c17.19 15.1 35.95 30.16 52.06 46.27a2.846 2.846 0 0 1-.05 4.03c-16.47 15.93-34.68 30.92-51.92 46.08-.51.49-1.21.79-1.97.79-1.58 0-2.86-1.29-2.86-2.87v-25.74c-58.7 1.19-154.52-27.16-211.85-63.77-18.02-11.5-32.34-23.89-40.63-36.49-8.64-13.13-10.88-26.51-4.27-39.46z" />
													</svg>
												<?php else : ?>
													<svg class="play" width="30px" height="30px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
														<path d="M0 0h48v48H0z" fill="none"></path>
														<path d="m20 33 12-9-12-9v18zm4-29C12.95 4 4 12.95 4 24s8.95 20 20 20 20-8.95 20-20S35.05 4 24 4zm0 36c-8.82 0-16-7.18-16-16S15.18 8 24 8s16 7.18 16 16-7.18 16-16 16z" fill="#ffffff" class="fill-000000"></path>
													</svg>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
							<?php if (!empty($threegalleryID) && !$disableAttachments) : ?>
								<div class="swiper-slide">
									<?php echo $this->wp_get_attachment_image_without_srcset($threegalleryID, $thumbnail_size, false, [
										'data-main-featured-image-src' => wp_get_attachment_image_src($threegalleryID, $main_size)[0],
										'loading' => 'eager'
									]) ?>
									<div class="gs-gallery-icon-play" style="position: absolute;top: 50%;transform: translate(-50%, -50%);left: 50%;">
										<div class="gspb-threesixty-gallery_placeholder">
											<span>
												<svg x="0px" y="0px" viewBox="0 0 122.88 65.79" width="30px" fill="white">
													<g>
														<path d="M13.37,31.32c-22.23,12.2,37.65,19.61,51.14,19.49v-7.44l11.21,11.2L64.51,65.79v-6.97 C37.4,59.85-26.41,42.4,11.97,27.92c0.36,1.13,0.8,2.2,1.3,3.2L13.37,31.32L13.37,31.32z M108.36,8.31c0-2.61,0.47-4.44,1.41-5.48 c0.94-1.04,2.37-1.56,4.3-1.56c0.92,0,1.69,0.12,2.28,0.34c0.59,0.23,1.08,0.52,1.45,0.89c0.38,0.36,0.67,0.75,0.89,1.15 c0.22,0.4,0.39,0.87,0.52,1.41c0.26,1.02,0.38,2.09,0.38,3.21c0,2.49-0.42,4.32-1.27,5.47c-0.84,1.15-2.29,1.73-4.36,1.73 c-1.15,0-2.09-0.19-2.8-0.55c-0.71-0.37-1.3-0.91-1.75-1.62c-0.33-0.51-0.59-1.2-0.77-2.07C108.45,10.34,108.36,9.38,108.36,8.31 L108.36,8.31z M26.47,10.49l-9-1.6c0.75-2.86,2.18-5.06,4.31-6.59C23.9,0.77,26.91,0,30.8,0c4.47,0,7.69,0.83,9.69,2.5 c1.99,1.67,2.98,3.77,2.98,6.29c0,1.48-0.41,2.82-1.21,4.01c-0.81,1.2-2.02,2.25-3.65,3.15c1.32,0.33,2.34,0.71,3.03,1.15 c1.14,0.7,2.02,1.63,2.65,2.77c0.63,1.15,0.95,2.51,0.95,4.1c0,2-0.52,3.91-1.56,5.75c-1.05,1.83-2.55,3.24-4.51,4.23 c-1.96,0.99-4.54,1.48-7.74,1.48c-3.11,0-5.57-0.37-7.36-1.1c-1.8-0.73-3.28-1.8-4.44-3.22c-1.16-1.41-2.05-3.19-2.67-5.33 l9.53-1.27c0.38,1.92,0.95,3.26,1.74,4.01c0.78,0.74,1.78,1.12,3,1.12c1.27,0,2.33-0.47,3.18-1.4c0.85-0.93,1.27-2.18,1.27-3.74 c0-1.59-0.41-2.82-1.22-3.69c-0.81-0.87-1.92-1.31-3.32-1.31c-0.74,0-1.77,0.18-3.07,0.56l0.49-6.81c0.52,0.08,0.93,0.12,1.22,0.12 c1.23,0,2.26-0.4,3.08-1.19c0.82-0.79,1.24-1.72,1.24-2.81c0-1.05-0.31-1.88-0.93-2.49c-0.62-0.62-1.48-0.93-2.55-0.93 c-1.12,0-2.02,0.34-2.72,1.01C27.19,7.62,26.72,8.8,26.47,10.49L26.47,10.49z M75.15,8.27l-9.48,1.16 c-0.25-1.32-0.66-2.24-1.24-2.78c-0.59-0.54-1.31-0.81-2.16-0.81c-1.54,0-2.74,0.77-3.59,2.33c-0.62,1.13-1.09,3.52-1.38,7.19 c1.14-1.16,2.31-2.01,3.5-2.56c1.2-0.55,2.59-0.83,4.16-0.83c3.06,0,5.64,1.09,7.75,3.27c2.11,2.19,3.17,4.96,3.17,8.31 c0,2.26-0.53,4.32-1.6,6.2c-1.07,1.87-2.55,3.29-4.44,4.25c-1.9,0.96-4.27,1.44-7.13,1.44c-3.43,0-6.18-0.58-8.25-1.76 c-2.07-1.17-3.73-3.03-4.97-5.59c-1.24-2.56-1.86-5.95-1.86-10.18c0-6.18,1.3-10.71,3.91-13.59C54.13,1.44,57.74,0,62.36,0 c2.73,0,4.88,0.31,6.46,0.94c1.58,0.63,2.9,1.56,3.94,2.76C73.81,4.92,74.61,6.44,75.15,8.27L75.15,8.27z M57.62,23.55 c0,1.86,0.47,3.31,1.4,4.36c0.94,1.05,2.08,1.58,3.44,1.58c1.25,0,2.3-0.48,3.14-1.43c0.84-0.95,1.26-2.37,1.26-4.26 c0-1.93-0.44-3.41-1.31-4.42c-0.88-1.01-1.96-1.52-3.26-1.52c-1.32,0-2.44,0.49-3.34,1.48C58.06,20.32,57.62,21.72,57.62,23.55 L57.62,23.55z M77.91,17.57c0-6.51,1.17-11.07,3.52-13.67C83.77,1.3,87.35,0,92.14,0c2.31,0,4.2,0.29,5.68,0.85 c1.48,0.57,2.69,1.31,3.62,2.22c0.94,0.91,1.68,1.87,2.21,2.87c0.54,1.01,0.97,2.18,1.3,3.52c0.64,2.55,0.96,5.22,0.96,8 c0,6.22-1.05,10.76-3.16,13.64c-2.1,2.88-5.72,4.32-10.87,4.32c-2.88,0-5.21-0.46-6.99-1.38c-1.78-0.92-3.23-2.27-4.37-4.05 c-0.82-1.26-1.47-2.98-1.93-5.17C78.14,22.64,77.91,20.22,77.91,17.57L77.91,17.57z M87.34,17.59c0,4.36,0.38,7.34,1.16,8.94 c0.77,1.6,1.89,2.39,3.36,2.39c0.97,0,1.8-0.34,2.51-1.01c0.71-0.68,1.23-1.76,1.56-3.22c0.34-1.47,0.5-3.75,0.5-6.85 c0-4.55-0.38-7.6-1.16-9.18c-0.77-1.56-1.93-2.35-3.47-2.35c-1.58,0-2.71,0.8-3.42,2.39C87.69,10.31,87.34,13.27,87.34,17.59 L87.34,17.59z M112.14,8.32c0,1.75,0.15,2.94,0.46,3.58c0.31,0.64,0.76,0.96,1.35,0.96c0.39,0,0.72-0.13,1.01-0.41 c0.28-0.27,0.49-0.7,0.63-1.29c0.13-0.59,0.2-1.5,0.2-2.74c0-1.82-0.15-3.05-0.46-3.68c-0.31-0.63-0.77-0.94-1.39-0.94 c-0.63,0-1.09,0.32-1.37,0.96C112.28,5.4,112.14,6.59,112.14,8.32L112.14,8.32z M109.3,30.23c10.56,5.37,8.04,12.99-10.66,17.62 c-5.3,1.31-11.29,2.5-17.86,2.99v6.05c7.31-0.51,14.11-2.19,20.06-3.63c28.12-6.81,27.14-18.97,9.36-25.83 C109.95,28.42,109.65,29.35,109.3,30.23L109.3,30.23z" />
													</g>
												</svg>
											</span>
										</div>
									</div>
								</div>
							<?php endif; ?>

						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	<?php
		$res = ob_get_contents();
		ob_get_clean();
		return $res;
	}
}

new ProductGallery;
