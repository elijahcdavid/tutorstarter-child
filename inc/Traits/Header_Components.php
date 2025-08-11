<?php
/**
 * Handles registering header components
 *
 * @package Tutor_Starter
 */

namespace Tutor_Starter_Child\Traits;

defined( 'ABSPATH' ) || exit;

/**
 * Header components trait
 */
trait Header_Components {

	/**
	 * Navbar toggler
	 */
	public static function navbar_toggler() {
		$toggler_html = '<li class="nav-close"><button class="btn-nav-close"><span class="close-btn">+</span></button></li>';
		return $toggler_html;
	}

	/**
	 * Tutor multi-column dropdown menu
	 */
	public static function tutor_multi_column_dropdown() {
		if ( ! class_exists( '\TUTOR\Utils' ) ) {
			return; // @todo: cross check
		}

		// $default_menus = apply_filters( 'tutor_dashboard/nav_items', self::default_menus() );
		$default_menus = self::default_menus();
		$current_user  = wp_get_current_user();
		?>
		<div class="tutor-header-profile-photo">
			<a href="<?php echo esc_url( home_url( '/dashboard' ) ); ?>" class="tutor-avatar-link" title="<?php esc_attr_e( 'Go to Dashboard', 'tutorstarter' ); ?>">
				<?php
				$profile_pic = tutor_utils()->get_tutor_avatar( get_current_user_id() );
				echo $profile_pic;
				?>
			</a>
		</div><!-- .tutor-header-profile-photo -->
		<!-- Removed dropdown functionality - avatar is now a direct link to dashboard -->
		<?php
	}
	/**
	 * Filtered nav items based on capabilities
	 *
	 * @return array
	 */
	public static function filtered_nav() {
		if ( ! class_exists( '\TUTOR\Utils' ) ) {
			return;
		}

		$instructor_menu = apply_filters( 'tutor_dashboard/instructor_nav_items', tutor_utils()->instructor_menus() );
		$common_navs     = array(
			'dashboard-page' => array(
				'title' => __( 'Dashboard', 'tutorstarter' ),
				'icon'  => 'tutor-icon-settings',
			),
			'settings'       => array(
				'title' => __( 'Account Settings', 'tutorstarter' ),
				'icon'  => 'tutor-icon-settings',
			),
			'logout'         => array(
				'title' => __( 'Logout', 'tutorstarter' ),
				'icon'  => 'tutor-icon-signout',
			),
		);

		$all_nav_items = array_merge( $instructor_menu, $common_navs );

		foreach ( $all_nav_items as $nav_key => $nav_item ) {

			if ( is_array( $nav_item ) ) {

				if ( isset( $nav_item['show_ui'] ) && ! tutor_utils()->array_get( 'show_ui', $nav_item ) ) {
					unset( $all_nav_items[ $nav_key ] );
				}

				if ( isset( $nav_item['auth_cap'] ) && ! current_user_can( $nav_item['auth_cap'] ) ) {
					unset( $all_nav_items[ $nav_key ] );
				}
			}
		}

		return $all_nav_items;
	}

	/**
	 * Check role
	 *
	 * @return bool
	 */
	public static function is_user_priviledged() {
		$user_is_priviledged = false;
		$current_user        = wp_get_current_user();
		$predefined_roles    = apply_filters(
			'tutor_user_is_priviledged',
			array(
				'administrator',
				'tutor_instructor',
			)
		);

		if ( array_intersect( $current_user->roles, $predefined_roles ) ) {
			$user_is_priviledged = true;
		} else {
			$user_is_priviledged = false;
		}

		return $user_is_priviledged;
	}

	/**
	 * Default Menus
	 */
	public static function default_menus() {
		return array(
			'' => array(
				'title' => __( 'Dashboard', 'tutorstarter' ),
				'icon'  => 'tutor-icon-dashboard',
			),
			'my-profile'       => array(
				'title' => __( 'My profile', 'tutorstarter' ),
				'icon'  => 'tutor-icon-user-bold',
			),
			'settings'       => array(
				'title' => __( 'Account Settings', 'tutorstarter' ),
				'icon'  => 'tutor-icon-gear',
			),
			'logout'         => array(
				'title' => __( 'Logout', 'tutorstarter' ),
				'icon'  => 'tutor-icon-signout',
			),
		);
	}
}