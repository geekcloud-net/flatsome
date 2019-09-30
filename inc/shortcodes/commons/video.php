<?php if ( $video_mp4 || $video_webm || $video_ogg ) { ?>
	<div class="video-overlay no-click fill <?php echo $video_visibility; ?>"></div>
	<video class="video-bg fill <?php echo $video_visibility; ?>" preload playsinline autoplay
		<?php echo $video_sound == 'false' ? 'muted' : ''; ?>
		<?php echo $video_loop == 'false' ? '' : 'loop'; ?>>
		<?php
		echo $video_mp4 ? '<source src="' . $video_mp4 . '" type="video/mp4">' : '';
		echo $video_ogg ? '<source src="' . $video_ogg . '" type="video/ogg">' : '';
		echo $video_webm ? '<source src="' . $video_webm . '" type="video/webm">' : '';
		?>
	</video>
<?php } ?>
<?php if ( $youtube ) { ?>
	<div class="video-overlay no-click fill"></div>
	<div id="ytplayer-<?php echo mt_rand( 1, 1000 ); ?>" class="ux-youtube fill object-fit <?php echo $video_visibility; ?>" data-videoid="<?php echo $youtube; ?>" data-loop="<?php echo 'false' !== $video_loop ? '1' : '0'; ?>" data-audio="<?php echo 'false' === $video_sound ? '0' : '1'; ?>"></div>
<?php } ?>
