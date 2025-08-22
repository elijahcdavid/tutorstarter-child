<?php
/**
 * Template for displaying single course
 *
 * @package Tutor\Templates
 * @author Themeum <support@themeum.com>
 * @link https://themeum.com
 * @since 1.0.0
 */

$course_id     = get_the_ID();
$course_rating = tutor_utils()->get_course_rating( $course_id );
$is_enrolled   = tutor_utils()->is_enrolled( $course_id, get_current_user_id() );

// Prepare the nav items.
$course_nav_item = apply_filters( 'tutor_course/single/nav_items', tutor_utils()->course_nav_items(), $course_id );
$is_public       = \TUTOR\Course_List::is_public( $course_id );
$is_mobile       = wp_is_mobile();

$enrollment_box_position = tutor_utils()->get_option( 'enrollment_box_position_in_mobile', 'bottom' );
if ( '-1' === $enrollment_box_position ) {
	$enrollment_box_position = 'bottom';
}
$student_must_login_to_view_course = tutor_utils()->get_option( 'student_must_login_to_view_course' );

tutor_utils()->tutor_custom_header();

if ( ! is_user_logged_in() && ! $is_public && $student_must_login_to_view_course ) {
	tutor_load_template( 'login' );
	tutor_utils()->tutor_custom_footer();
	return;
}
$has_video = apply_filters( 'tutor_course_has_video', tutor_utils()->has_video_in_single(), $course_id );
?>

<?php do_action( 'tutor_course/single/before/wrap' ); ?>
<div <?php tutor_post_class( 'tutor-full-width-course-top tutor-course-top-info tutor-page-wrap tutor-wrap-parent' ); ?>>
	<div class="tutor-course-details-page tutor-container">
		<?php ( isset( $is_enrolled ) && $is_enrolled ) ? tutor_course_enrolled_lead_info() : tutor_course_lead_info(); ?>
		<div class="tutor-row tutor-gx-xl-5">
			<main class="tutor-col-xl-8">
				<?php $has_video ? tutor_course_video() : get_tutor_course_thumbnail(); ?>
				<?php do_action( 'tutor_course/single/before/inner-wrap' ); ?>

				<?php if ( $is_mobile && 'top' === $enrollment_box_position ) : ?>
					<div class="tutor-mt-32">
						<?php tutor_load_template( 'single.course.course-entry-box' ); ?>
					</div>
				<?php endif; ?>

				<div class="tutor-course-details-tab tutor-mt-32">
					<?php if ( is_array( $course_nav_item ) && count( $course_nav_item ) > 1 ) : ?>
						<div class="tutor-is-sticky">
							<?php tutor_load_template( 'single.course.enrolled.nav', array( 'course_nav_item' => $course_nav_item ) ); ?>
						</div>
					<?php endif; ?>
					<div class="tutor-tab tutor-pt-24">
						<?php foreach ( $course_nav_item as $key => $subpage ) : ?>
							<div id="tutor-course-details-tab-<?php echo esc_attr( $key ); ?>" class="tutor-tab-item<?php echo 'info' == $key ? ' is-active' : ''; ?>">
								<?php
									do_action( 'tutor_course/single/tab/' . $key . '/before' );

									$method = $subpage['method'];
								if ( is_string( $method ) ) {
									$method();
								} else {
									$_object = $method[0];
									$_method = $method[1];
									$_object->$_method( get_the_ID() );
								}

									do_action( 'tutor_course/single/tab/' . $key . '/after' );
								?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<?php do_action( 'tutor_course/single/after/inner-wrap' ); ?>
			</main>

			<aside class="tutor-col-xl-4">
				<?php $sidebar_attr = apply_filters( 'tutor_course_details_sidebar_attr', '' ); ?>
				<div class="tutor-single-course-sidebar tutor-mt-40 tutor-mt-xl-0" <?php echo esc_attr( $sidebar_attr ); ?> >
					<?php do_action( 'tutor_course/single/before/sidebar' ); ?>

					<?php if ( ! $is_mobile ) : ?>
						<?php tutor_load_template( 'single.course.course-entry-box' ); ?>
					<?php endif ?>

					<div class="tutor-single-course-sidebar-more tutor-mt-24<?php echo $is_mobile ? ' tutor-mb-32' : ''; ?>">
						<!-- Course Info moved to top of sidebar-more section -->
						<?php
						// Get course metadata for the footer section
						$default_meta = array(
							array(
								'icon_class' => 'tutor-icon-mortarboard',
								'label'      => __( 'Total Enrolled', 'tutor' ),
								'value'      => tutor_utils()->get_option( 'enable_course_total_enrolled' ) ? tutor_utils()->count_enrolled_users_by_course() . ' ' . __( 'Total Enrolled', 'tutor' ) : null,
							),
							array(
								'icon_class' => 'tutor-icon-clock-line',
								'label'      => __( 'Duration', 'tutor' ),
								'value'      => get_tutor_option( 'enable_course_duration' ) ? ( get_tutor_course_duration_context() ? get_tutor_course_duration_context() . ' ' . __( 'Duration', 'tutor' ) : false ) : null,
							),
							array(
								'icon_class' => 'tutor-icon-refresh-o',
								'label'      => __( 'Last Updated', 'tutor' ),
								'value'      => get_tutor_option( 'enable_course_update_date' ) ? get_the_modified_date( get_option( 'date_format' ) ) . ' ' . __( 'Last Updated', 'tutor' ) : null,
							),
						);

						// Add level if enabled
						if ( tutor_utils()->get_option( 'enable_course_level', true, true ) ) {
							array_unshift(
								$default_meta,
								array(
									'icon_class' => 'tutor-icon-level',
									'label'      => __( 'Level', 'tutor' ),
									'value'      => get_tutor_course_level( get_the_ID() ),
								)
							);
						}

						// Apply filters for sidebar metadata
						$sidebar_meta = apply_filters( 'tutor/course/single/sidebar/metadata', $default_meta, get_the_ID() );
						?>
						
						<div class="tutor-card tutor-card-md tutor-sidebar-card tutor-card-level-header">
                            <ul class="tutor-ul">
                                <?php foreach ( $sidebar_meta as $key => $meta ) : ?>
                                    <?php
                                    if ( ! $meta['value'] ) {
                                        continue;
                                    }
                                    ?>
                                    <li class="tutor-d-flex<?php echo $key > 0 ? ' tutor-mt-12' : ''; ?> <?php echo esc_attr( isset( $meta['list_class'] ) ? $meta['list_class'] : '' ); ?>">
                                        <span class="<?php echo esc_attr( $meta['icon_class'] ); ?> tutor-color-black tutor-mt-4 tutor-mr-12" aria-labelledby="<?php echo esc_html( $meta['label'] ); ?>"></span>
                                        <span class="tutor-fs-6 tutor-color-secondary">
                                            <?php echo wp_kses_post( $meta['value'] ); ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
						</div>

						<?php 
						// REMOVED: tutor_course_instructors_html(); 
						?>
						<?php tutor_course_requirements_html(); ?>
						<?php tutor_course_tags_html(); ?>
						<?php tutor_course_target_audience_html(); ?>
					</div>

					<?php if ( $is_mobile ) : ?>
						<?php tutor_load_template( 'single.course.course-entry-box' ); ?>
					<?php endif ?>

					<?php do_action( 'tutor_course/single/after/sidebar' ); ?>
				</div>
			</aside>
		</div>
	</div>
</div>

<?php do_action( 'tutor_course/single/after/wrap' ); ?>

<?php
tutor_utils()->tutor_custom_footer();
