<div class="vp-pfui-elm-block" id="vp-pfui-format-audio-fields" style="display: none;">
	<?php do_action( 'vp_pfui_before_audio_meta' ); ?>
	<label for="vp-pfui-format-audio-embed"><?php esc_html_e('Audio URL (oEmbed) or Embed Code', 'dine'); ?></label>
	<textarea name="_format_audio_embed" id="vp-pfui-format-audio-embed" tabindex="1" placeholder="To enter multiple audios, you can separate audio urls by entering a new line."><?php echo esc_textarea(get_post_meta($post->ID, '_format_audio_embed', true)); ?></textarea>
	<?php do_action( 'vp_pfui_after_audio_meta' ); ?>
</div>	