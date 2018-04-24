<div class="vp-pfui-elm-block" id="vp-pfui-format-video-fields" style="display: none;">
	<?php do_action( 'vp_pfui_before_video_meta' ); ?>
	<label for="vp-pfui-format-video-embed"><?php esc_html_e('Video URL (oEmbed) or Embed Code', 'dine'); ?></label>
	<textarea name="_format_video_embed" id="vp-pfui-format-video-embed" tabindex="1" placeholder="To enter multiple videos, you can separate video urls by entering a new line."><?php echo esc_textarea(get_post_meta($post->ID, '_format_video_embed', true)); ?></textarea>
	<?php do_action( 'vp_pfui_after_video_meta' ); ?>
</div>	
