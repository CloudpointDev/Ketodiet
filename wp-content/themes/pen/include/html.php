<?php
/**
 * Template functions.
 *
 * @package Pen
 */

defined( 'ABSPATH' ) || die();

if ( ! function_exists( 'pen_html_logo' ) ) {
	/**
	 * Displays the custom logo.
	 * Does nothing if the custom logo is not available.
	 *
	 * @param int $content_id Content ID.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_html_logo( $content_id = null ) {
		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		if ( function_exists( 'get_custom_logo' ) ) {
			$logo = trim( get_custom_logo() );
			if ( $logo ) {
				return sprintf(
					'<div class="pen_logo %1$s">%2$s</div>',
					pen_class_animation( 'header_logo', false, $content_id ),
					$logo
				);
			}
		}
		return '';
	}
}

if ( ! function_exists( 'pen_html_connect' ) ) {
	/**
	 * Generates markup for the social network links.
	 *
	 * @param string $location   The location of the social network links (for now it can be header or footer).
	 * @param int    $content_id Content ID.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_html_connect( $location, $content_id = null ) {
		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		ob_start();

		$rss_url = pen_option_get( 'rss' );
		if ( $rss_url ) {
			$rss_display = pen_option_get( 'rss_' . $location . '_display' );
			if ( $rss_display ) {
				$rss_url = explode( '|', $rss_url );
				foreach ( $rss_url as $rss_url ) {
					?>
			<li class="pen_rss" title="<?php esc_attr_e( 'Subscribe the RSS', 'pen' ); ?>">
				<a href="<?php echo esc_url( $rss_url ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'RSS', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$email = pen_option_get( 'email' );
		if ( $email ) {
			$email_display = pen_option_get( 'email_' . $location . '_display' );
			if ( $email_display ) {
				$email = explode( '|', $email );
				foreach ( $email as $email ) {
					if ( false !== strpos( $email, '@' ) ) {
						$email = 'mailto:' . antispambot( $email );
					}
					?>
			<li class="pen_email" title="<?php esc_attr_e( 'E-mail', 'pen' ); ?>">
				<a href="<?php echo esc_url( $email ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'E-mail', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$facebook_url = pen_option_get( 'facebook' );
		if ( $facebook_url ) {
			$facebook_display = pen_option_get( 'facebook_' . $location . '_display' );
			if ( $facebook_display ) {
				$facebook_url = explode( '|', $facebook_url );
				foreach ( $facebook_url as $facebook_url ) {
					?>
			<li class="pen_facebook" title="<?php esc_attr_e( 'Facebook', 'pen' ); ?>">
				<a href="<?php echo esc_url( $facebook_url ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'Facebook', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$instagram_url = pen_option_get( 'instagram' );
		if ( $instagram_url ) {
			$instagram_display = pen_option_get( 'instagram_' . $location . '_display' );
			if ( $instagram_display ) {
				$instagram_url = explode( '|', $instagram_url );
				foreach ( $instagram_url as $instagram_url ) {
					?>
			<li class="pen_instagram" title="<?php esc_attr_e( 'Instagram', 'pen' ); ?>">
				<a href="<?php echo esc_url( $instagram_url ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'Instagram', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$vk_url = pen_option_get( 'vk' );
		if ( $vk_url ) {
			$vk_display = pen_option_get( 'vk_' . $location . '_display' );
			if ( $vk_display ) {
				$vk_url = explode( '|', $vk_url );
				foreach ( $vk_url as $vk_url ) {
					?>
			<li class="pen_vk" title="<?php esc_attr_e( 'VK', 'pen' ); ?>">
				<a href="<?php echo esc_url( $vk_url ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'VK', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$pinterest_url = pen_option_get( 'pinterest' );
		if ( $pinterest_url ) {
			$pinterest_display = pen_option_get( 'pinterest_' . $location . '_display' );
			if ( $pinterest_display ) {
				$pinterest_url = explode( '|', $pinterest_url );
				foreach ( $pinterest_url as $pinterest_url ) {
					?>
			<li class="pen_pinterest" title="<?php esc_attr_e( 'Pinterest', 'pen' ); ?>">
				<a href="<?php echo esc_url( $pinterest_url ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'Pinterest', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$twitter_url = pen_option_get( 'twitter' );
		if ( $twitter_url ) {
			$twitter_display = pen_option_get( 'twitter_' . $location . '_display' );
			if ( $twitter_display ) {
				$twitter_url = explode( '|', $twitter_url );
				foreach ( $twitter_url as $twitter_url ) {
					?>
			<li class="pen_twitter" title="<?php esc_attr_e( 'Twitter', 'pen' ); ?>">
				<a href="<?php echo esc_url( $twitter_url ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'Twitter', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$linkedin_url = pen_option_get( 'linkedin' );
		if ( $linkedin_url ) {
			$linkedin_display = pen_option_get( 'linkedin_' . $location . '_display' );
			if ( $linkedin_display ) {
				$linkedin_url = explode( '|', $linkedin_url );
				foreach ( $linkedin_url as $linkedin_url ) {
					?>
			<li class="pen_linkedin" title="<?php esc_attr_e( 'LinkedIn', 'pen' ); ?>">
				<a href="<?php echo esc_url( $linkedin_url ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'LinkedIn', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$bitbucket_url = pen_option_get( 'bitbucket' );
		if ( $bitbucket_url ) {
			$bitbucket_display = pen_option_get( 'bitbucket_' . $location . '_display' );
			if ( $bitbucket_display ) {
				$bitbucket_url = explode( '|', $bitbucket_url );
				foreach ( $bitbucket_url as $bitbucket_url ) {
					?>
			<li class="pen_bitbucket" title="<?php esc_attr_e( 'BitBucket', 'pen' ); ?>">
				<a href="<?php echo esc_url( $bitbucket_url ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'BitBucket', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$flickr_url = pen_option_get( 'flickr' );
		if ( $flickr_url ) {
			$flickr_display = pen_option_get( 'flickr_' . $location . '_display' );
			if ( $flickr_display ) {
				$flickr_url = explode( '|', $flickr_url );
				foreach ( $flickr_url as $flickr_url ) {
					?>
			<li class="pen_flickr" title="<?php esc_attr_e( 'Flickr', 'pen' ); ?>">
				<a href="<?php echo esc_url( $flickr_url ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'Flickr', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$github_url = pen_option_get( 'github' );
		if ( $github_url ) {
			$github_display = pen_option_get( 'github_' . $location . '_display' );
			if ( $github_display ) {
				$github_url = explode( '|', $github_url );
				foreach ( $github_url as $github_url ) {
					?>
			<li class="pen_github" title="<?php esc_attr_e( 'GitHub', 'pen' ); ?>">
				<a href="<?php echo esc_url( $github_url ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'GitHub', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$telegram_url = pen_option_get( 'telegram' );
		if ( $telegram_url ) {
			$telegram_display = pen_option_get( 'telegram_' . $location . '_display' );
			if ( $telegram_display ) {
				$telegram_url = explode( '|', $telegram_url );
				foreach ( $telegram_url as $telegram_url ) {
					?>
			<li class="pen_telegram" title="<?php esc_attr_e( 'Telegram', 'pen' ); ?>">
				<a href="<?php echo esc_url( $telegram_url ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'Telegram', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$whatsapp_url = pen_option_get( 'whatsapp' );
		if ( $whatsapp_url ) {
			$whatsapp_display = pen_option_get( 'whatsapp_' . $location . '_display' );
			if ( $whatsapp_display ) {
				$whatsapp_url = explode( '|', $whatsapp_url );
				foreach ( $whatsapp_url as $whatsapp_url ) {
					?>
			<li class="pen_whatsapp" title="<?php esc_attr_e( 'WhatsApp', 'pen' ); ?>">
				<a href="<?php echo esc_attr( $whatsapp_url ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'WhatsApp', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$skype_url = pen_option_get( 'skype' );
		if ( $skype_url ) {
			$skype_display = pen_option_get( 'skype_' . $location . '_display' );
			if ( $skype_display ) {
				$skype_url = explode( '|', $skype_url );
				foreach ( $skype_url as $skype_url ) {
					?>
			<li class="pen_skype" title="<?php esc_attr_e( 'Skype', 'pen' ); ?>">
				<a href="<?php echo esc_attr( $skype_url ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'Skype', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$slack_url = pen_option_get( 'slack' );
		if ( $slack_url ) {
			$slack_display = pen_option_get( 'slack_' . $location . '_display' );
			if ( $slack_display ) {
				$slack_url = explode( '|', $slack_url );
				foreach ( $slack_url as $slack_url ) {
					?>
			<li class="pen_slack" title="<?php esc_attr_e( 'Slack', 'pen' ); ?>">
				<a href="<?php echo esc_url( $slack_url ); ?>">
					<span class="screen-reader-text">
					<?php
					esc_html_e( 'Slack', 'pen' );
					?>
					</span>
				</a>
			</li>
					<?php
				}
			}
		}

		$output = trim( ob_get_clean() );
		if ( $output ) {
			ob_start();
			?>
	<div class="pen_social_networks <?php pen_class_animation( 'social_' . $location, 'echo', $content_id ); /* phpcs:ignore */ ?>">
		<ul>
			<?php
			echo wp_kses( $output, wp_kses_allowed_html( 'post' ) );
			?>
		</ul>
	</div><!-- .pen_social_networks -->
			<?php
			return ob_get_clean();
		}
		return false;
	}
}

if ( ! function_exists( 'pen_html_search_box' ) ) {
	/**
	 * Generates markup for the search box.
	 *
	 * @param int $content_id Content ID.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_html_search_box( $content_id = null ) {
		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		$search_display = get_post_meta( $content_id, 'pen_content_search_display_override', true );
		if ( ! $search_display || 'default' === $search_display ) {
			$search_display = pen_option_get( 'search_display' );
		}
		if ( $search_display && 'no' !== $search_display ) {
			return trim( get_search_form( false ) );
		}
		return false;
	}
}

if ( ! function_exists( 'pen_html_navigation_fallback' ) ) {
	/**
	 * Fallback navigation menu.
	 *
	 * @since Pen 1.0.8
	 * @return void
	 */
	function pen_html_navigation_fallback() {

		$content_id = pen_post_id();

		if ( current_user_can( 'edit_theme_options' ) ) {
			?>
	<nav id="pen_navigation" class="<?php echo esc_attr( pen_class_navigation() ); ?>" role="navigation" title="<?php esc_attr_e( 'This is a shortcut link for users with theme customization permission, invisible for the rest.', 'pen' ); ?>" aria-label="<?php esc_attr_e( 'Header Menu', 'pen' ); ?>">
		<div class="pen_container <?php pen_class_animation( 'navigation', 'echo', $content_id ); /* phpcs:ignore */ ?>">
			<ul id="primary-menu" class="menu">
				<li class="pen_menu_create">
			<?php
			if ( is_customize_preview() ) {
				$url        = '#';
				$attributes = ' class="pen_customizer_shortcut" data-type="panel" data-target="nav_menus"';
			} else {
				$url        = esc_url( self_admin_url( 'nav-menus.php' ) );
				$attributes = '';
			}
			printf(
				'<a href="%1$s"%2$s>%3$s</a>',
				esc_attr( $url ),
				$attributes, /* phpcs:ignore */
				esc_html__( 'Create a menu?', 'pen' )
			);
			?>
				</li>
			</ul>
		</div>
			<?php
			pen_html_jump_menu( 'navigation', pen_post_id() );
			?>
	</nav>
			<?php
		}
	}
}

if ( ! function_exists( 'pen_html_footer_menu_fallback' ) ) {
	/**
	 * Fallback footer menu.
	 *
	 * @since Pen 1.0.8
	 * @return void
	 */
	function pen_html_footer_menu_fallback() {
		$content_id = pen_post_id();
		if ( current_user_can( 'edit_theme_options' ) ) {
			?>
	<nav id="pen_footer_menu" role="navigation" class="<?php pen_class_animation( 'footer_menu', 'echo', $content_id ); /* phpcs:ignore */ ?>" title="<?php esc_attr_e( 'This is a shortcut link for users with theme customization permission, invisible for the rest.', 'pen' ); ?>" aria-label="<?php esc_attr_e( 'Footer Menu', 'pen' ); ?>">
		<ul id="secondary-menu" class="menu">
			<li class="pen_menu_create">
			<?php
			if ( is_customize_preview() ) {
				$url        = '#';
				$attributes = ' class="pen_customizer_shortcut" data-type="panel" data-target="nav_menus"';
			} else {
				$url        = esc_url( self_admin_url( 'nav-menus.php' ) );
				$attributes = '';
			}
			printf(
				'<a href="%1$s"%2$s>%3$s</a>',
				esc_attr( $url ),
				$attributes, /* phpcs:ignore */
				esc_html__( 'Create a menu?', 'pen' )
			);
			?>
			</li>
		</ul>
	</nav>
			<?php
		}
	}
}

if ( ! function_exists( 'pen_html_content_information' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @param string $location   The selected location for the element.
	 * @param int    $content_id Content ID.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_html_content_information( $location, $content_id = null ) {

		if ( 'post' !== get_post_type() ) {
			return;
		}

		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		if ( ! in_array( (string) $location, array( 'header', 'footer' ), true ) ) {
			$location = 'header';
		}

		$pen_is_singular = is_singular();

		$view = $pen_is_singular ? 'content' : 'list';

		// Hide category for pages.
		$categories_list   = '';
		$category_location = get_post_meta( $content_id, 'pen_' . $view . '_category_location_override', true );
		if ( ! $category_location || 'default' === $category_location ) {
			$category_location = pen_option_get( $view . '_category_location' );
		}

		if ( $location === $category_location || ( ! $category_location && 'header' === $location ) ) {
			/* Translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( '||' );
			if ( pen_option_get( 'pen_' . $view . '_category_only_first' ) && false !== strpos( $categories_list, '||' ) ) {
				$categories_list = explode( '||', $categories_list );
				$categories_list = $categories_list[0];
			}
			$categories_list = str_replace( '||', _x( ', ', 'Separates category links.', 'pen' ), $categories_list );
			if ( $categories_list ) {
				$categories_list = sprintf(
					'<span class="cat-links%1$s"><span class="screen-reader-text">%2$s</span>%3$s</span>',
					pen_class_lists( 'category_display_override', $content_id ),
					__( 'Categories:', 'pen' ),
					$categories_list
				); /* phpcs:ignore */
			}
		}

		$posted_on     = '';
		$date_location = get_post_meta( $content_id, 'pen_' . $view . '_date_location_override', true );
		if ( ! $date_location || 'default' === $date_location ) {
			$date_location = pen_option_get( $view . '_date_location' );
		}

		if ( $location === $date_location || ( ! $date_location && 'header' === $location ) ) {
			$time_string = sprintf(
				'<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
				esc_attr( get_the_date( DATE_W3C ) ),
				esc_html( get_the_date() )
			);
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = sprintf(
					'<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>',
					esc_attr( get_the_date( DATE_W3C ) ),
					esc_html( get_the_date() ),
					esc_attr( get_the_modified_date( DATE_W3C ) ),
					esc_html( get_the_modified_date() )
				);
			}

			$posted_on = sprintf(
				/* Translators: %s: Post date. */
				esc_html_x( 'Posted on %s', 'post date', 'pen' ),
				sprintf(
					'<a href="%1$s" rel="bookmark">%2$s</a>',
					esc_url( get_permalink() ),
					$time_string
				)
			);
			$posted_on = sprintf(
				'<span class="posted-on%1$s">%2$s</span>',
				pen_class_lists( 'date_display_override', $content_id ),
				$posted_on
			);
		}

		$byline          = '';
		$author_location = get_post_meta( $content_id, 'pen_' . $view . '_author_location_override', true );
		if ( ! $author_location || 'default' === $author_location ) {
			$author_location = pen_option_get( $view . '_author_location' );
		}
		if ( $location === $author_location || ( ! $author_location && 'header' === $location ) ) {
			$byline = sprintf(
				// Translators: %s: Post author's name.
				esc_html_x( 'by %s', 'post author', 'pen' ),
				sprintf(
					'<span class="author vcard"><a class="url fn n" href="%1$S">%2$s</a></span>',
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_html( get_the_author() )
				)
			);
			$byline = sprintf(
				'<span class="byline%1$s"> %2$s</span>',
				pen_class_lists( 'author_display_override', $content_id ),
				$byline
			);
		}

		$output = trim( $posted_on . $byline . $categories_list );

		if ( $output ) {

			$classes = array(
				'entry-meta',
				$pen_is_singular ? 'pen_animate_on_scroll pen_custom_animation_fadeIn' : '',
			);

			$classes = trim( implode( ' ', array_unique( array_filter( $classes ) ) ) );

			ob_start();
			?>
		<div class="<?php echo esc_attr( $classes ); ?>">
			<?php
			echo $output; /* phpcs:ignore */
			?>
		</div>
			<?php
			return ob_get_clean();
		}
	}
}

if ( ! function_exists( 'pen_html_author' ) ) {
	/**
	 * Generates author profile.
	 *
	 * @param array $variables  Profile parameteres.
	 * @param int   $content_id Content ID.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_html_author( $variables = array(), $content_id = null ) {
		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		$view    = is_singular() ? 'content' : 'list';
		$display = get_post_meta( $content_id, 'pen_' . $view . '_profile_display_override', true );
		if ( ! $display || 'default' === $display ) {
			$display = pen_option_get( $view . '_profile_display' );
		}
		if ( ! $display ) {
			return;
		}
		$avatar   = get_avatar( get_the_author_meta( 'email' ), '90' );
		$user_url = get_the_author_meta( 'user_url' );
		$add_link = ( $user_url && ( ! isset( $variables['add_url'] ) || $variables['add_url'] ) ) ? true : false;

		$classes = trim(
			implode(
				' ',
				array(
					'pen_author_profile',
					pen_class_animation( $view . '_author', false, $content_id ),
					$avatar ? 'pen_has_avatar' : '',
				)
			)
		);
		?>
	<div class="<?php echo esc_attr( $classes ); ?>">
		<?php
		if ( $avatar && ( ! isset( $variables['add_avatar'] ) || $variables['add_avatar'] ) ) {
			?>
		<div class="pen_author_avatar">
			<?php
			if ( $add_link ) {
				?>
			<a href="<?php echo esc_url( $user_url ); ?>">
				<?php
			}

			echo $avatar; /* phpcs:ignore */

			if ( $add_link ) {
				?>
			</a>
				<?php
			}
			?>
		</div>
			<?php
		}

		$description = wp_kses( get_the_author_meta( 'description' ), wp_kses_allowed_html( 'post' ) );
		$classes     = trim(
			implode(
				' ',
				array(
					'pen_author_about',
					( ! $description ) ? 'pen_no_description' : '',
				)
			)
		);
		?>
		<div class="<?php echo esc_attr( $classes ); ?>">
			<h3>
		<?php
		the_author_link();
		?>
			</h3>
		<?php
		ob_start();
		if ( $user_url && ( ! isset( $variables['add_url'] ) || $variables['add_url'] ) ) {
			$site_name = wp_parse_url( $user_url );
			if ( isset( $site_name['host'] ) ) {
				$site_name = $site_name['host'];
			} else {
				$site_name = $user_url;
			}
			?>
			<a href="<?php echo esc_url( $user_url ); ?>" class="pen_author_url">
			<?php
			echo esc_html( $site_name );
			?>
			</a>
			<?php
		}

		if ( $description ) {
			?>
			<p>
			<?php
			echo $description; /* phpcs:ignore */
			?>
			</p>
			<?php
		}

		$about = trim( ob_get_clean() );
		if ( $about ) {
			?>
			<div>
			<?php
			echo $about; /* phpcs:ignore */
			?>
			</div>
			<?php
		}
		?>
		</div>
	</div>
		<?php
	}
}

if ( ! function_exists( 'pen_html_share' ) ) {
	/**
	 * Social sharing buttons.
	 *
	 * @global object $post
	 *
	 * @param string $location   The selected location.
	 * @param int    $content_id Content ID.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_html_share( $location, $content_id = null ) {
		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		ob_start();

		if ( ! is_singular() ) {
			return;
		}
		if ( ! in_array( (string) $location, array( 'header', 'content', 'footer' ), true ) ) {
			$location = 'header';
		}
		$share_location = get_post_meta( $content_id, 'pen_content_share_location_override', true );
		if ( ! $share_location || 'default' === $share_location ) {
			$share_location = pen_option_get( 'content_share_location' );
		}
		if ( $share_location !== $location ) {
			return;
		}

		$display = get_post_meta( $content_id, 'pen_content_share_display_override', true );
		if ( ! $display || 'default' === $display ) {
			$display = pen_option_get( 'content_share_display' );
		}
		if ( ! $display || 'no' === $display ) {
			return;
		}

		global $post;
		$url   = rawurlencode( esc_url( get_permalink( $content_id ) ) );
		$title = rawurlencode( $post->post_title );

		$url_home = is_multisite() ? network_home_url( false ) : home_url( false );

		$url_facebook = sprintf( 'https://www.facebook.com/sharer/sharer.php?u=%1$s', $url );
		$url_twitter  = sprintf( 'https://twitter.com/intent/tweet?text=%2$s&url=%1$s', $url, $title );
		$url_linkedin = sprintf( 'https://www.linkedin.com/cws/share?url=%1$s&original_referer=%2$s', $url, $url_home );
		?>
		<div class="pen_share">
			<h4>
		<?php
		esc_html_e( 'Share this!', 'pen' );
		?>
			</h4>
			<ul>
				<li class="pen_facebook">
		<?php
		$link_title = sprintf(
			/* Translators: %s: Social network name, e.g. Facebook. */
			__( 'Share on %s', 'pen' ),
			__( 'Facebook', 'pen' )
		);
		?>
					<a href="<?php echo esc_url( $url_facebook ); ?>" title="<?php echo esc_attr( $link_title ); ?>" target="_blank" class="pen_button pen_button_share">
						<span>
		<?php
		esc_html_e( 'Facebook', 'pen' );
		?>
						</span>
					</a>
				</li>
				<li class="pen_twitter">
		<?php
		$link_title = sprintf(
			/* Translators: %s: Social network name, e.g. Facebook. */
			__( 'Share on %s', 'pen' ),
			__( 'Twitter', 'pen' )
		);
		?>
					<a href="<?php echo esc_url( $url_twitter ); ?>" title="<?php echo esc_attr( $link_title ); ?>" target="_blank" class="pen_button pen_button_share">
						<span>
		<?php
		esc_html_e( 'Twitter', 'pen' );
		?>
						</span>
					</a>
				</li>
				<li class="pen_linkedin">
		<?php
		$link_title = sprintf(
			/* Translators: %s: Social network name, e.g. Facebook. */
			__( 'Share on %s', 'pen' ),
			__( 'LinkedIn', 'pen' )
		);
		?>
					<a href="<?php echo esc_url( $url_linkedin ); ?>" title="<?php echo esc_attr( $link_title ); ?>" target="_blank" class="pen_button pen_button_share">
						<span>
		<?php
		esc_html_e( 'LinkedIn', 'pen' );
		?>
						</span>
					</a>
				</li>
			</ul>
		</div><!-- .pen_share -->
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'pen_html_configuration_overview' ) ) {
	/**
	 * Displays an overview of the post meta settings.
	 *
	 * @param int $content_id Content ID.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_html_configuration_overview( $content_id = null ) {
		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		ob_start();
		$overview_list     = array();
		$overview_content  = array();
		$overview_sidebars = array();
		$customize_display = false;
		$edit_post_display = false;

		$options_list = pen_post_meta_options( 'list' );

		foreach ( $options_list as $option => $label ) {
			$value = get_post_meta( $content_id, $option, true );
			if ( $value && 'default' !== $value ) {
				$edit_post_display        = true;
				$overview_list[ $option ] = array(
					'status' => ( 'no' === $value ) ? 'disabled' : 'enabled',
					'label'  => $label,
					'value'  => $value,
					'help'   => __( 'You can change this by editing this post.', 'pen' ),
				);
			}
		}

		$options_content = pen_post_meta_options( 'content' );

		foreach ( $options_content as $option => $label ) {
			$value = get_post_meta( $content_id, $option, true );
			if ( $value && 'default' !== $value ) {
				$edit_post_display           = true;
				$overview_content[ $option ] = array(
					'status' => ( 'no' === $value ) ? 'disabled' : 'enabled',
					'label'  => $label,
					'value'  => $value,
					'help'   => __( 'You can change this by editing this post.', 'pen' ),
				);
			}
		}

		$options_sidebars = pen_post_meta_options( 'sidebar' );

		$is_homepage = ( ( is_home() || is_front_page() ) && is_singular() ) ? true : false;

		foreach ( $options_sidebars as $sidebar => $name ) {
			if ( $is_homepage ) {
				if ( pen_option_get( str_replace( 'pen_', 'pen_front_', $sidebar ) ) ) {
					$customize_display             = true;
					$overview_sidebars[ $sidebar ] = array(
						'status' => 'disabled',
						'label'  => sprintf(
							/* Translators: %s: Sidebar name. */
							esc_html__( '(If on homepage) "%s"', 'pen' ),
							$name
						),
						'value'  => __( 'Hidden', 'pen' ),
						'help'   => __( 'You can change this through Appearance &rarr; Customize &rarr; Front page &rarr; Sidebars.', 'pen' ),
					);
				}
			}
			if ( get_post_meta( $content_id, $sidebar, true ) ) {
				$edit_post_display             = true;
				$overview_sidebars[ $sidebar ] = array(
					'status' => 'disabled',
					'label'  => sprintf(
						/* Translators: %s: Sidebar name. */
						__( '"%s"', 'pen' ),
						ucfirst( str_replace( array( 'pen_sidebar_', '_display', '_' ), array( '', '', ' ' ), $sidebar ) )
					),
					'value'  => __( 'Hidden', 'pen' ),
					'help'   => __( 'You can change this by editing this post.', 'pen' ),
				);
			}
		}
		if ( empty( $overview_list ) && empty( $overview_content ) && empty( $overview_sidebars ) ) {
			ob_end_clean();
			return;
		}
		?>
		<div class="pen_options_overview" id="pen_post_overview_<?php echo esc_attr( $content_id ); ?>">
			<h3>
		<?php
		echo esc_html(
			sprintf(
				/* Translators: %s: Something to configure, such as Header, Footer. */
				__( '%s Settings', 'pen' ),
				__( 'Content', 'pen' )
			)
		);
		?>
			</h3>
			<p class="pen_overview_content_title">
				<strong>
					<span class="screen-reader-text">
		<?php
		echo esc_html(
			sprintf(
				'%s: ',
				__( 'Title', 'pen' )
			)
		);
		?>
					</span>
		<?php
		the_title();
		?>
				</strong>
			</p>
			<div class="pen_table_wrapper">
				<table>
		<?php
		if ( ! empty( $overview_list ) ) {
			?>
					<tr>
						<th scope="col" colspan="2">
			<?php
			esc_html_e( 'List Views', 'pen' );
			?>
						</th>
					</tr>
			<?php
			foreach ( $overview_list as $item ) {
				?>
					<tr class="pen_option_<?php echo esc_attr( $item['status'] ); ?>" title="<?php echo esc_attr( $item['help'] ); ?>">
				<?php
				$value = str_replace( '_', ' ', $item['value'] );
				if ( '#000000' === $value ) {
					$value = __( 'Dark', 'pen' );
				} elseif ( '#ffffff' === $value ) {
					$value = __( 'Light', 'pen' );
				}
				?>
						<td class="pen_overview_item">
				<?php
				echo esc_html( $item['label'] );
				?>
						</td>
						<td class="pen_overview_value">
				<?php
				if ( 'yes' === $value ) {
					esc_html_e( 'Yes', 'pen' );
				} elseif ( 'no' === $value ) {
					esc_html_e( 'No', 'pen' );
				} else {
					echo esc_html( $value );
				}
				?>
						</td>
					</tr>
				<?php
			}
		}

		if ( $overview_content || $overview_sidebars ) {
			?>
					<tr>
						<th scope="col" colspan="2">
			<?php
			esc_html_e( 'Full Content View', 'pen' );
			?>
						</th>
					</tr>
			<?php
			foreach ( $overview_content as $item ) {
				?>
					<tr class="pen_option_<?php echo esc_attr( $item['status'] ); ?>" title="<?php echo esc_attr( $item['help'] ); ?>">
				<?php
				$value = str_replace( array( '_', 'preset ' ), array( ' ', 'style ' ), $item['value'] );
				if ( '#000000' === $value ) {
					$value = __( 'Dark', 'pen' );
				} elseif ( '#ffffff' === $value ) {
					$value = __( 'Light', 'pen' );
				}
				?>
						<td class="pen_overview_item">
				<?php
				echo esc_html( $item['label'] );
				?>
						</td>
						<td class="pen_overview_value">
				<?php
				if ( 'yes' === $value ) {
					esc_html_e( 'Yes', 'pen' );
				} elseif ( 'no' === $value ) {
					esc_html_e( 'No', 'pen' );
				} else {
					echo esc_html( $value );
				}
				?>
						</td>
					</tr>
				<?php
			}
		}

		foreach ( $overview_sidebars as $item ) {
			?>
				<tr class="pen_option_<?php echo esc_attr( $item['status'] ); ?>" title="<?php echo esc_attr( $item['help'] ); ?>">
					<td class="pen_overview_item">
			<?php
			echo esc_html(
				sprintf(
					/* Translators: %s: sidebar name. */
					__( '%s widget area', 'pen' ),
					esc_html( $item['label'] )
				)
			);
			?>
					</td>
					<td class="pen_overview_value">
			<?php
			echo esc_html( $item['value'] );
			?>
					</td>
				</tr>
			<?php
		}
		?>
			</table>
		</div>
		<?php
		if ( $edit_post_display && ! is_customize_preview() ) {
			?>
		<a href="<?php echo esc_url( get_edit_post_link( $content_id ) ); ?>" class="pen_button">
			<?php
			echo esc_html(
				sprintf(
					/* Translators: %s: content type, such as "Page", or "Post". */
					__( 'Edit this %s', 'pen' ),
					get_post_type()
				)
			);
			?>
		</a>
			<?php
		}

		if ( $customize_display ) {
			$url_customize = wp_customize_url();
			if ( ! is_admin() ) {
				$content_id = pen_post_id();
				if ( $content_id ) {
					$url_customize = add_query_arg( 'pen_content_id', $content_id, wp_customize_url() );
				}
			}
			?>
		<a href="<?php echo esc_url( $url_customize ); ?>" class="pen_button">
			<?php
			esc_html_e( 'Edit defaults', 'pen' );
			?>
		</a>
			<?php
		}
		?>
	</div>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'pen_html_jump_menu' ) ) {
	/**
	 * Jump menus for easier access to various parts of the backend.
	 *
	 * @param string $element    Layout section or template part.
	 * @param int    $content_id Content ID.
	 *
	 * @since Pen 1.0.8
	 * @return void
	 */
	function pen_html_jump_menu( $element, $content_id = null ) {
		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}
		$menu = pen_jump_menu( $element, $content_id );

		$heading_text = sprintf(
			wp_kses(
				/* Translators: %s: layout section name, like Footer, Header, etc. */
				_x( 'Customize <span>%s</span>', 'verb', 'pen' ),
				wp_kses_allowed_html( 'post' )
			),
			esc_html( $menu['name'] )
		);
		$heading_title = htmlspecialchars( wp_strip_all_tags( str_replace( '"', '', htmlspecialchars_decode( $heading_text ) ) ) );

		// This menu has to be hidden when JavaScript is disabled (too many links) unless it's a screen-reader.
		?>
		<div id="pen_jump_menu_<?php echo esc_attr( $element ); ?>" class="pen_jump_menu clearfix screen-reader-text">
			<div class="pen_menu_wrapper clearfix screen-reader-text">
				<h4 title="<?php echo esc_attr( $heading_title ); ?>">
		<?php
		echo $heading_text; /* phpcs:ignore */
		?>
				</h4>
				<ul>
		<?php
		foreach ( $menu['items'] as $target => $label ) {
			?>
					<li>
			<?php
			if ( filter_var( $target, FILTER_VALIDATE_URL ) ) {
				$url = esc_url( $target );

				printf(
					'<a href="%1$s">%2$s</a>',
					esc_attr( $url ), // No need to esc_url.
					wp_kses( $label, wp_kses_allowed_html( 'post' ) )
				);

			} else {

				$url = pen_url_customizer( $target );

				list( $container_type, $container_name ) = explode( ',', $target );

				$generic = array(
					'background_image',
					'header_image',
					'nav_menus',
					'title_tagline',
					'widgets',
				);
				if ( ! in_array( $container_name, $generic, true ) && false === strpos( $container_name, 'sidebar-widgets-' ) ) {
					$container_name = 'pen_' . $container_type . '_' . $container_name;
				}

				printf(
					'<a href="%1$s" class="pen_customizer_shortcut"%2$s>%3$s</a>',
					esc_attr( $url ), // No need to esc_url.
					sprintf(
						' data-type="%1$s" data-target="%2$s"',
						esc_attr( $container_type ),
						esc_attr( $container_name )
					),
					wp_kses( $label, wp_kses_allowed_html( 'post' ) )
				);

			}
			?>
					</li>
			<?php
		}
		?>
				</ul>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'pen_html_pagination_content' ) ) {
	/**
	 * Inline content pagination.
	 *
	 * @param int $content_id Content ID.
	 *
	 * @since Pen 1.4.3
	 * @return void
	 */
	function pen_html_pagination_content( $content_id = null ) {
		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		ob_start();
		if ( function_exists( 'wp_pagenavi' ) ) {
			wp_pagenavi(
				array(
					'type' => 'multipart',
				)
			);
		} else {
			wp_link_pages(
				array(
					'before'         => sprintf(
						'<div class="page-links %1$s"><span class="screen-reader-text">%2$s</span>',
						pen_class_animation( 'content_pager', false, $content_id ),
						esc_html__( 'Pages:', 'pen' )
					),
					'after'          => '</div>',
					'next_or_number' => 'next',
				)
			);
		}
		$pagination = trim( ob_get_clean() );
		if ( $pagination ) {
			printf(
				'<div class="pen_content_pagination">%s</div>',
				$pagination /* phpcs:ignore */
			);
		}
	}
}

if ( ! function_exists( 'pen_html_button_users' ) ) {
	/**
	 * Returns HTML for a button to the user account profile.
	 *
	 * @since Pen 1.2.8
	 * @return string
	 */
	function pen_html_button_users() {
		ob_start();
		if ( is_user_logged_in() ) {
			if ( PEN_THEME_HAS_WOOCOMMERCE ) {
				$url_account = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
			} else {
				if ( ! current_user_can( 'edit_user' ) ) {
					return;
				}
				$url_account = get_edit_user_link();
			}
			?>
		<a class="pen_button" href="<?php echo esc_attr( $url_account ); ?>" title="<?php esc_attr_e( 'My Account', 'pen' ); ?>">
			<?php
			esc_html_e( 'My Account', 'pen' );
			?>
		</a>
			<?php
		} elseif ( pen_option_get( 'encourage_register' ) ) {

			$url_register = wp_kses( pen_option_get( 'encourage_register_url' ), wp_kses_allowed_html( 'post' ) );
			if ( ! $url_register ) {
				if ( PEN_THEME_HAS_WOOCOMMERCE ) {
					$url_register = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
				} else {
					$url_register = wp_registration_url();
				}
			}
			?>
		<a class="pen_button" href="<?php echo esc_attr( $url_register ); ?>" title="<?php esc_attr_e( 'Login / Register', 'pen' ); ?>">
			<?php
			esc_attr_e( 'Login / Register', 'pen' );
			?>
		</a>
			<?php
		}
		return ob_get_clean();
	}
}
