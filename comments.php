<?php if( !get_theme_mod('malina_single_disable_comments', false ) ){ ?>
<div id="comments">
	<?php	
		if ( post_password_required() ) { ?>
			<?php esc_html_e('This post is password protected. Enter the password to view comments.', 'malina'); ?>
		<?php
			return;
		}
	?>
	<?php if ( have_comments() ) : ?>
		<h2 id="comments-title"><span><?php esc_html_e('Comments ', 'malina'); ?></span></h2>
	
		<ol class="unstyled commentlist clearfix">
			 <?php wp_list_comments(array('type'=> 'comment', 'callback' => 'malina_comment' )); ?>
		</ol>
		<?php //get ping and trackbacks
			global $post;
			$ping_entries = get_comments(array( 'type'=> 'pings', 'post_id' => $post->ID ));
			
			if(!empty($ping_entries)){
			echo "<h2 class='title pingbacklist'><span>". esc_html__('Trackbacks &amp; Pingbacks','malina')."</span></h2>";
			?>
			
			<ol class="pingbacklist">
				<?php
					/* 
					 * Loop through and list the pingbacks and trackbacks. 
					 */
					wp_list_comments( array( 'type'=> 'pings', 'reverse_top_level'=>true ) );
				?>
			</ol>
			<?php } ?>
		<div class="navigation">
			<?php paginate_comments_links(array('prev_text' => esc_html__('Previous', 'malina'), 'next_text' => esc_html__('Next', 'malina'))); ?>
		</div>
		
	 <?php else : // this is displayed if there are no comments so far ?>
	
		<?php if ( comments_open() ) : ?>	
		 <?php else : // comments are closed ?>
		 	<h2 id="comments-title" class="mb0"><span><?php esc_html_e('Comments are closed.', 'malina'); ?></span></h2>
	
		<?php endif; ?>
		
	<?php endif; ?>
		
		
<?php if ( comments_open() ) : ?>

	<?php
		//Comment Form Args
        $comments_args = array(
			'title_reply'=>esc_html__('Leave a reply', 'malina'),
			'comment_field' => '<textarea id="comment" name="comment" aria-required="true" placeholder="'.esc_attr__('Add a Comment', 'malina').'" cols="58" rows="6" tabindex="4"></textarea>',
			'comment_notes_after' => '',
			'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title"><span>',
			'title_reply_after' => '</span></h3>',
			'comment_notes_before' => '',
			'logged_in_as' => '',
			'label_submit' => esc_html__('Post comment','malina')
		);
		
		// Show Comment Form
		comment_form($comments_args); 
	?>


<?php endif; // if you delete this the sky will fall on your head ?>

</div>
<?php } ?>