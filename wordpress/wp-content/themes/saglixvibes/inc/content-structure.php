<?php
/**
 * Content types, taxonomies and admin fields.
 *
 * @package SiteTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function site_theme_register_content_structure() {
	register_post_type(
		'event',
		array(
			'labels' => array(
				'name'               => __( 'אירועים', 'site-theme' ),
				'singular_name'      => __( 'אירוע', 'site-theme' ),
				'add_new_item'       => __( 'הוספת אירוע חדש', 'site-theme' ),
				'edit_item'          => __( 'עריכת אירוע', 'site-theme' ),
				'new_item'           => __( 'אירוע חדש', 'site-theme' ),
				'view_item'          => __( 'צפייה באירוע', 'site-theme' ),
				'search_items'       => __( 'חיפוש אירועים', 'site-theme' ),
				'not_found'          => __( 'לא נמצאו אירועים', 'site-theme' ),
				'all_items'          => __( 'כל האירועים', 'site-theme' ),
				'menu_name'          => __( 'אירועים', 'site-theme' ),
				'featured_image'     => __( 'תמונת אירוע', 'site-theme' ),
				'set_featured_image' => __( 'הגדרת תמונת אירוע', 'site-theme' ),
			),
			'public'       => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-calendar-alt',
			'rewrite'      => array( 'slug' => 'events' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		)
	);

	register_post_type(
		'class',
		array(
			'labels' => array(
				'name'               => __( 'חוגים', 'site-theme' ),
				'singular_name'      => __( 'חוג', 'site-theme' ),
				'add_new_item'       => __( 'הוספת חוג חדש', 'site-theme' ),
				'edit_item'          => __( 'עריכת חוג', 'site-theme' ),
				'new_item'           => __( 'חוג חדש', 'site-theme' ),
				'view_item'          => __( 'צפייה בחוג', 'site-theme' ),
				'search_items'       => __( 'חיפוש חוגים', 'site-theme' ),
				'not_found'          => __( 'לא נמצאו חוגים', 'site-theme' ),
				'all_items'          => __( 'כל החוגים', 'site-theme' ),
				'menu_name'          => __( 'חוגים', 'site-theme' ),
				'parent_item_colon'  => __( 'חוג ראשי:', 'site-theme' ),
				'featured_image'     => __( 'תמונת חוג', 'site-theme' ),
				'set_featured_image' => __( 'הגדרת תמונת חוג', 'site-theme' ),
			),
			'public'       => true,
			'show_in_rest' => true,
			'hierarchical' => true,
			'menu_icon'    => 'dashicons-groups',
			'rewrite'      => array( 'slug' => 'classes' ),
			'supports'     => array( 'title', 'thumbnail', 'page-attributes' ),
		)
	);

	register_post_type(
		'announcement',
		array(
			'labels' => array(
				'name'          => __( 'הכרזות', 'site-theme' ),
				'singular_name' => __( 'הכרזה', 'site-theme' ),
				'add_new_item'  => __( 'הוספת הכרזה חדשה', 'site-theme' ),
				'edit_item'     => __( 'עריכת הכרזה', 'site-theme' ),
				'new_item'      => __( 'הכרזה חדשה', 'site-theme' ),
				'view_item'     => __( 'צפייה בהכרזה', 'site-theme' ),
				'search_items'  => __( 'חיפוש הכרזות', 'site-theme' ),
				'not_found'     => __( 'לא נמצאו הכרזות', 'site-theme' ),
				'all_items'     => __( 'כל ההכרזות', 'site-theme' ),
				'menu_name'     => __( 'הכרזות', 'site-theme' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'menu_icon'           => 'dashicons-megaphone',
			'supports'            => array( 'title' ),
		)
	);

	register_post_type(
		'banner',
		array(
			'labels' => array(
				'name'               => __( 'באנרים', 'site-theme' ),
				'singular_name'      => __( 'באנר', 'site-theme' ),
				'add_new_item'       => __( 'הוספת באנר חדש', 'site-theme' ),
				'edit_item'          => __( 'עריכת באנר', 'site-theme' ),
				'new_item'           => __( 'באנר חדש', 'site-theme' ),
				'view_item'          => __( 'צפייה בבאנר', 'site-theme' ),
				'search_items'       => __( 'חיפוש באנרים', 'site-theme' ),
				'not_found'          => __( 'לא נמצאו באנרים', 'site-theme' ),
				'all_items'          => __( 'כל הבאנרים', 'site-theme' ),
				'menu_name'          => __( 'באנרים', 'site-theme' ),
				'featured_image'     => __( 'תמונת באנר', 'site-theme' ),
				'set_featured_image' => __( 'הגדרת תמונת באנר', 'site-theme' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'menu_icon'           => 'dashicons-format-image',
			'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
		)
	);

	register_taxonomy(
		'event_audience',
		array( 'event' ),
		array(
			'labels' => array(
				'name'          => __( 'קהל יעד', 'site-theme' ),
				'singular_name' => __( 'קהל יעד', 'site-theme' ),
				'add_new_item'  => __( 'הוספת קהל יעד', 'site-theme' ),
				'edit_item'     => __( 'עריכת קהל יעד', 'site-theme' ),
				'all_items'     => __( 'כל קהלי היעד', 'site-theme' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'event-audience' ),
		)
	);

	register_taxonomy(
		'class_age',
		array( 'class' ),
		array(
			'labels' => array(
				'name'          => __( 'גילאים', 'site-theme' ),
				'singular_name' => __( 'גיל', 'site-theme' ),
				'add_new_item'  => __( 'הוספת גיל', 'site-theme' ),
				'edit_item'     => __( 'עריכת גיל', 'site-theme' ),
				'all_items'     => __( 'כל הגילאים', 'site-theme' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'class-age' ),
		)
	);

	register_taxonomy(
		'class_field',
		array( 'class' ),
		array(
			'labels' => array(
				'name'          => __( 'תחומים', 'site-theme' ),
				'singular_name' => __( 'תחום', 'site-theme' ),
				'add_new_item'  => __( 'הוספת תחום', 'site-theme' ),
				'edit_item'     => __( 'עריכת תחום', 'site-theme' ),
				'all_items'     => __( 'כל התחומים', 'site-theme' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'class-field' ),
		)
	);
}
add_action( 'init', 'site_theme_register_content_structure' );

function site_theme_default_terms() {
	$groups = array(
		'event_audience' => array(
			'הגיל הרך (קטנטנינא)',
			'גן',
			'יסודי',
			'חטיבת ביניים',
			'תיכון',
			'בוגרים',
			'הגיל השלישי',
		),
		'class_age' => array(
			'גיל רך 0-6',
			'ילדים 7-12',
			'נוער 12-18',
			'צעירים 19-25',
			'בוגרים 25-65',
			'גיל שלישי 66+',
			'כל הגילאים',
		),
		'class_field' => array(
			'מועדוניות',
			'ספורט והתעמלות',
			'אומנות',
			'חברה וקהילה',
			'יזמות טכנולוגיה ומדע',
			'למידה',
			'ריקוד ומחול',
			'צהרון',
			'פעוטון',
			'מוסיקה ואמנויות הבמה',
			'מעון יום',
			'גנים',
			'אחר',
		),
	);

	foreach ( $groups as $taxonomy => $terms ) {
		foreach ( $terms as $term ) {
			if ( ! term_exists( $term, $taxonomy ) ) {
				wp_insert_term( $term, $taxonomy );
			}
		}
	}
}
add_action( 'init', 'site_theme_default_terms', 20 );

function site_theme_add_content_meta_boxes() {
	add_meta_box( 'event_details', __( 'פרטי אירוע', 'site-theme' ), 'site_theme_render_event_fields', 'event', 'normal', 'high' );
	add_meta_box( 'class_details', __( 'פרטי חוג', 'site-theme' ), 'site_theme_render_class_fields', 'class', 'normal', 'high' );
	add_meta_box( 'class_schedule', __( 'ימי פעילות ושעות', 'site-theme' ), 'site_theme_render_class_schedule_fields', 'class', 'normal', 'default' );
	add_meta_box( 'announcement_details', __( 'פרטי הכרזה', 'site-theme' ), 'site_theme_render_announcement_fields', 'announcement', 'normal', 'high' );
	add_meta_box( 'banner_details', __( 'פרטי באנר', 'site-theme' ), 'site_theme_render_banner_fields', 'banner', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'site_theme_add_content_meta_boxes' );

function site_theme_meta_value( $post_id, $key, $default = '' ) {
	$value = get_post_meta( $post_id, $key, true );

	return '' === $value ? $default : $value;
}

function site_theme_render_event_fields( $post ) {
	wp_nonce_field( 'site_theme_save_event_fields', 'site_theme_event_nonce' );
	$paid = site_theme_meta_value( $post->ID, '_event_is_paid', '0' );
	?>
	<div class="site-admin-fields" dir="rtl">
		<p>
			<label for="event_short_date"><?php esc_html_e( 'תאריך מקוצר (DD.MM) *', 'site-theme' ); ?></label>
			<input id="event_short_date" type="text" name="event_short_date" value="<?php echo esc_attr( site_theme_meta_value( $post->ID, '_event_short_date' ) ); ?>" placeholder="24.09" required>
		</p>
		<p>
			<label for="event_display_date"><?php esc_html_e( 'תאריך לתצוגה *', 'site-theme' ); ?></label>
			<input id="event_display_date" type="text" name="event_display_date" value="<?php echo esc_attr( site_theme_meta_value( $post->ID, '_event_display_date' ) ); ?>" required>
		</p>
		<p>
			<label for="event_location"><?php esc_html_e( 'מיקום *', 'site-theme' ); ?></label>
			<input id="event_location" type="text" name="event_location" value="<?php echo esc_attr( site_theme_meta_value( $post->ID, '_event_location' ) ); ?>" required>
		</p>
		<p>
			<label><input type="checkbox" name="event_is_paid" value="1" <?php checked( '1', $paid ); ?>> <?php esc_html_e( 'אירוע בתשלום', 'site-theme' ); ?></label>
		</p>
		<p>
			<label for="event_ticket_price"><?php esc_html_e( 'מחיר כרטיס', 'site-theme' ); ?></label>
			<input id="event_ticket_price" type="number" min="0" step="0.01" name="event_ticket_price" value="<?php echo esc_attr( site_theme_meta_value( $post->ID, '_event_ticket_price' ) ); ?>">
		</p>
		<p>
			<label for="event_capacity"><?php esc_html_e( 'מספר מקומות', 'site-theme' ); ?></label>
			<input id="event_capacity" type="number" min="0" step="1" name="event_capacity" value="<?php echo esc_attr( site_theme_meta_value( $post->ID, '_event_capacity', '0' ) ); ?>">
			<span class="description"><?php esc_html_e( 'אם הערך 0, יוצג אזל המלאי.', 'site-theme' ); ?></span>
		</p>
		<p>
			<label for="event_registration_url"><?php esc_html_e( 'קישור להרשמה/הזמנת כרטיסים', 'site-theme' ); ?></label>
			<input id="event_registration_url" class="ltr" type="url" name="event_registration_url" value="<?php echo esc_url( site_theme_meta_value( $post->ID, '_event_registration_url' ) ); ?>">
		</p>
		<p>
			<label for="event_audience_text"><?php esc_html_e( 'קהל יעד', 'site-theme' ); ?></label>
			<input id="event_audience_text" type="text" name="event_audience_text" value="<?php echo esc_attr( site_theme_meta_value( $post->ID, '_event_audience_text' ) ); ?>">
		</p>
	</div>
	<?php
}

function site_theme_render_class_fields( $post ) {
	wp_nonce_field( 'site_theme_save_class_fields', 'site_theme_class_nonce' );
	?>
	<div class="site-admin-fields" dir="rtl">
		<p>
			<label for="class_short_description"><?php esc_html_e( 'תיאור קצר', 'site-theme' ); ?></label>
			<textarea id="class_short_description" name="class_short_description" rows="3"><?php echo esc_textarea( site_theme_meta_value( $post->ID, '_class_short_description' ) ); ?></textarea>
		</p>
		<p>
			<label for="class_notes"><?php esc_html_e( 'הערות', 'site-theme' ); ?></label>
			<textarea id="class_notes" name="class_notes" rows="3"><?php echo esc_textarea( site_theme_meta_value( $post->ID, '_class_notes' ) ); ?></textarea>
		</p>
		<p>
			<label for="class_monthly_price"><?php esc_html_e( 'מחיר לחודש', 'site-theme' ); ?></label>
			<input id="class_monthly_price" type="number" min="0" step="0.01" name="class_monthly_price" value="<?php echo esc_attr( site_theme_meta_value( $post->ID, '_class_monthly_price' ) ); ?>">
		</p>
		<p>
			<label for="class_registration_url"><?php esc_html_e( 'קישור להרשמה', 'site-theme' ); ?></label>
			<input id="class_registration_url" class="ltr" type="url" name="class_registration_url" value="<?php echo esc_url( site_theme_meta_value( $post->ID, '_class_registration_url' ) ); ?>">
		</p>
		<p class="description"><?php esc_html_e( 'כדי ליצור קבוצות תחת חוג ראשי, יש לבחור חוג אב באזור מאפייני העמוד.', 'site-theme' ); ?></p>
	</div>
	<?php
}

function site_theme_render_announcement_fields( $post ) {
	wp_nonce_field( 'site_theme_save_announcement_fields', 'site_theme_announcement_nonce' );
	$active = site_theme_meta_value( $post->ID, '_announcement_active', '1' );
	?>
	<div class="site-admin-fields" dir="rtl">
		<p>
			<label for="announcement_link"><?php esc_html_e( 'קישור', 'site-theme' ); ?></label>
			<input id="announcement_link" class="ltr" type="url" name="announcement_link" value="<?php echo esc_url( site_theme_meta_value( $post->ID, '_announcement_link' ) ); ?>">
		</p>
		<p>
			<label>
				<input type="checkbox" name="announcement_active" value="1" <?php checked( '1', $active ); ?>>
				<?php esc_html_e( 'פעיל', 'site-theme' ); ?>
			</label>
		</p>
	</div>
	<?php
}

function site_theme_banner_backgrounds() {
	return array(
		'banner-1.webp' => __( 'רקע 1', 'site-theme' ),
		'banner-2.webp' => __( 'רקע 2', 'site-theme' ),
		'banner-3.webp' => __( 'רקע 3', 'site-theme' ),
		'banner-4.webp' => __( 'רקע 4', 'site-theme' ),
		'banner-5.webp' => __( 'רקע 5', 'site-theme' ),
	);
}

function site_theme_render_banner_fields( $post ) {
	wp_nonce_field( 'site_theme_save_banner_fields', 'site_theme_banner_nonce' );
	$active     = site_theme_meta_value( $post->ID, '_banner_active', '1' );
	$background = site_theme_meta_value( $post->ID, '_banner_background', 'banner-1.webp' );
	?>
	<div class="site-admin-fields" dir="rtl">
		<p>
			<label for="banner_secondary_title"><?php esc_html_e( 'כותרת משנית', 'site-theme' ); ?></label>
			<input id="banner_secondary_title" type="text" name="banner_secondary_title" value="<?php echo esc_attr( site_theme_meta_value( $post->ID, '_banner_secondary_title' ) ); ?>">
		</p>
		<p>
			<label for="banner_eyebrow_text"><?php esc_html_e( 'טקסט מקדים', 'site-theme' ); ?></label>
			<input id="banner_eyebrow_text" type="text" name="banner_eyebrow_text" value="<?php echo esc_attr( site_theme_meta_value( $post->ID, '_banner_eyebrow_text' ) ); ?>">
		</p>
		<p>
			<label for="banner_button_text"><?php esc_html_e( 'טקסט כפתור', 'site-theme' ); ?></label>
			<input id="banner_button_text" type="text" name="banner_button_text" value="<?php echo esc_attr( site_theme_meta_value( $post->ID, '_banner_button_text' ) ); ?>">
		</p>
		<p>
			<label for="banner_button_link"><?php esc_html_e( 'קישור כפתור', 'site-theme' ); ?></label>
			<input id="banner_button_link" class="ltr" type="url" name="banner_button_link" value="<?php echo esc_url( site_theme_meta_value( $post->ID, '_banner_button_link' ) ); ?>">
		</p>
		<fieldset class="site-banner-backgrounds">
			<legend><?php esc_html_e( 'רקע', 'site-theme' ); ?></legend>
			<?php foreach ( site_theme_banner_backgrounds() as $file => $label ) : ?>
				<label class="site-banner-background">
					<input type="radio" name="banner_background" value="<?php echo esc_attr( $file ); ?>" <?php checked( $file, $background ); ?>>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/banners/' . $file ); ?>" alt="<?php echo esc_attr( $label ); ?>">
					<span><?php echo esc_html( $label ); ?></span>
				</label>
			<?php endforeach; ?>
		</fieldset>
		<p>
			<label>
				<input type="checkbox" name="banner_active" value="1" <?php checked( '1', $active ); ?>>
				<?php esc_html_e( 'פעיל', 'site-theme' ); ?>
			</label>
		</p>
	</div>
	<?php
}

function site_theme_weekdays() {
	return array(
		'sun' => 'יום א׳',
		'mon' => 'יום ב׳',
		'tue' => 'יום ג׳',
		'wed' => 'יום ד׳',
		'thu' => 'יום ה׳',
		'fri' => 'יום ו׳',
		'sat' => 'יום ש׳',
	);
}

function site_theme_render_class_schedule_fields( $post ) {
	$schedule = get_post_meta( $post->ID, '_class_schedule', true );
	$schedule = is_array( $schedule ) ? $schedule : array();
	?>
	<div class="site-admin-fields site-schedule-fields" dir="rtl">
		<?php foreach ( site_theme_weekdays() as $key => $label ) : ?>
			<?php $row = isset( $schedule[ $key ] ) && is_array( $schedule[ $key ] ) ? $schedule[ $key ] : array(); ?>
			<div class="site-schedule-row">
				<label>
					<input type="checkbox" name="class_schedule[<?php echo esc_attr( $key ); ?>][active]" value="1" <?php checked( ! empty( $row['active'] ) ); ?>>
					<?php echo esc_html( $label ); ?>
				</label>
				<input type="time" name="class_schedule[<?php echo esc_attr( $key ); ?>][start]" value="<?php echo esc_attr( $row['start'] ?? '' ); ?>" aria-label="<?php esc_attr_e( 'שעת התחלה', 'site-theme' ); ?>">
				<span>-</span>
				<input type="time" name="class_schedule[<?php echo esc_attr( $key ); ?>][end]" value="<?php echo esc_attr( $row['end'] ?? '' ); ?>" aria-label="<?php esc_attr_e( 'שעת סיום', 'site-theme' ); ?>">
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

function site_theme_save_event_fields( $post_id ) {
	if ( ! isset( $_POST['site_theme_event_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['site_theme_event_nonce'] ) ), 'site_theme_save_event_fields' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = array(
		'_event_short_date'       => array( 'event_short_date', 'sanitize_text_field' ),
		'_event_display_date'     => array( 'event_display_date', 'sanitize_text_field' ),
		'_event_location'         => array( 'event_location', 'sanitize_text_field' ),
		'_event_ticket_price'     => array( 'event_ticket_price', 'sanitize_text_field' ),
		'_event_capacity'         => array( 'event_capacity', 'absint' ),
		'_event_registration_url' => array( 'event_registration_url', 'esc_url_raw' ),
		'_event_audience_text'    => array( 'event_audience_text', 'sanitize_text_field' ),
	);

	foreach ( $fields as $meta_key => $field ) {
		$raw = isset( $_POST[ $field[0] ] ) ? wp_unslash( $_POST[ $field[0] ] ) : '';
		update_post_meta( $post_id, $meta_key, call_user_func( $field[1], $raw ) );
	}

	update_post_meta( $post_id, '_event_is_paid', empty( $_POST['event_is_paid'] ) ? '0' : '1' );
}
add_action( 'save_post_event', 'site_theme_save_event_fields' );

function site_theme_save_class_fields( $post_id ) {
	if ( ! isset( $_POST['site_theme_class_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['site_theme_class_nonce'] ) ), 'site_theme_save_class_fields' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = array(
		'_class_short_description' => array( 'class_short_description', 'sanitize_textarea_field' ),
		'_class_notes'             => array( 'class_notes', 'sanitize_textarea_field' ),
		'_class_monthly_price'     => array( 'class_monthly_price', 'sanitize_text_field' ),
		'_class_registration_url'  => array( 'class_registration_url', 'esc_url_raw' ),
	);

	foreach ( $fields as $meta_key => $field ) {
		$raw = isset( $_POST[ $field[0] ] ) ? wp_unslash( $_POST[ $field[0] ] ) : '';
		update_post_meta( $post_id, $meta_key, call_user_func( $field[1], $raw ) );
	}

	$schedule = array();
	$posted   = isset( $_POST['class_schedule'] ) && is_array( $_POST['class_schedule'] ) ? wp_unslash( $_POST['class_schedule'] ) : array();

	foreach ( site_theme_weekdays() as $key => $label ) {
		$row = isset( $posted[ $key ] ) && is_array( $posted[ $key ] ) ? $posted[ $key ] : array();
		$schedule[ $key ] = array(
			'active' => empty( $row['active'] ) ? 0 : 1,
			'start'  => isset( $row['start'] ) ? sanitize_text_field( $row['start'] ) : '',
			'end'    => isset( $row['end'] ) ? sanitize_text_field( $row['end'] ) : '',
		);
	}

	update_post_meta( $post_id, '_class_schedule', $schedule );
}
add_action( 'save_post_class', 'site_theme_save_class_fields' );

function site_theme_save_announcement_fields( $post_id ) {
	if ( ! isset( $_POST['site_theme_announcement_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['site_theme_announcement_nonce'] ) ), 'site_theme_save_announcement_fields' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$link = isset( $_POST['announcement_link'] ) ? wp_unslash( $_POST['announcement_link'] ) : '';

	update_post_meta( $post_id, '_announcement_link', esc_url_raw( $link ) );
	update_post_meta( $post_id, '_announcement_active', empty( $_POST['announcement_active'] ) ? '0' : '1' );
}
add_action( 'save_post_announcement', 'site_theme_save_announcement_fields' );

function site_theme_save_banner_fields( $post_id ) {
	if ( ! isset( $_POST['site_theme_banner_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['site_theme_banner_nonce'] ) ), 'site_theme_save_banner_fields' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = array(
		'_banner_secondary_title' => array( 'banner_secondary_title', 'sanitize_text_field' ),
		'_banner_eyebrow_text'    => array( 'banner_eyebrow_text', 'sanitize_text_field' ),
		'_banner_button_text'     => array( 'banner_button_text', 'sanitize_text_field' ),
		'_banner_button_link'     => array( 'banner_button_link', 'esc_url_raw' ),
	);

	foreach ( $fields as $meta_key => $field ) {
		$raw = isset( $_POST[ $field[0] ] ) ? wp_unslash( $_POST[ $field[0] ] ) : '';
		update_post_meta( $post_id, $meta_key, call_user_func( $field[1], $raw ) );
	}

	$backgrounds = site_theme_banner_backgrounds();
	$background  = isset( $_POST['banner_background'] ) ? sanitize_file_name( wp_unslash( $_POST['banner_background'] ) ) : 'banner-1.webp';

	if ( ! isset( $backgrounds[ $background ] ) ) {
		$background = 'banner-1.webp';
	}

	update_post_meta( $post_id, '_banner_background', $background );
	update_post_meta( $post_id, '_banner_active', empty( $_POST['banner_active'] ) ? '0' : '1' );
}
add_action( 'save_post_banner', 'site_theme_save_banner_fields' );

function site_theme_content_admin_assets( $hook_suffix ) {
	if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	wp_enqueue_style(
		'site-content-admin',
		get_template_directory_uri() . '/admin-content.css',
		array(),
		(string) filemtime( get_template_directory() . '/admin-content.css' )
	);
}
add_action( 'admin_enqueue_scripts', 'site_theme_content_admin_assets' );

function site_theme_event_columns( $columns ) {
	$columns['event_display_date'] = __( 'תאריך', 'site-theme' );
	$columns['event_location']     = __( 'מיקום', 'site-theme' );
	$columns['event_capacity']     = __( 'מקומות', 'site-theme' );

	return $columns;
}
add_filter( 'manage_event_posts_columns', 'site_theme_event_columns' );

function site_theme_event_column_content( $column, $post_id ) {
	if ( 'event_display_date' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_event_display_date', true ) );
	}

	if ( 'event_location' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_event_location', true ) );
	}

	if ( 'event_capacity' === $column ) {
		$capacity = absint( get_post_meta( $post_id, '_event_capacity', true ) );
		echo esc_html( 0 === $capacity ? __( 'אזל המלאי', 'site-theme' ) : $capacity );
	}
}
add_action( 'manage_event_posts_custom_column', 'site_theme_event_column_content', 10, 2 );

function site_theme_class_columns( $columns ) {
	$columns['class_price'] = __( 'מחיר לחודש', 'site-theme' );
	$columns['class_age']   = __( 'גילאים', 'site-theme' );
	$columns['class_field'] = __( 'תחומים', 'site-theme' );

	return $columns;
}
add_filter( 'manage_class_posts_columns', 'site_theme_class_columns' );

function site_theme_class_column_content( $column, $post_id ) {
	if ( 'class_price' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_class_monthly_price', true ) );
	}

	if ( in_array( $column, array( 'class_age', 'class_field' ), true ) ) {
		$terms = get_the_term_list( $post_id, $column, '', ', ' );
		echo wp_kses_post( $terms ? $terms : '—' );
	}
}
add_action( 'manage_class_posts_custom_column', 'site_theme_class_column_content', 10, 2 );

function site_theme_announcement_columns( $columns ) {
	$columns['announcement_active'] = __( 'סטטוס', 'site-theme' );
	$columns['announcement_link']   = __( 'קישור', 'site-theme' );

	return $columns;
}
add_filter( 'manage_announcement_posts_columns', 'site_theme_announcement_columns' );

function site_theme_announcement_column_content( $column, $post_id ) {
	if ( 'announcement_active' === $column ) {
		$is_active = '1' === get_post_meta( $post_id, '_announcement_active', true );
		echo esc_html( $is_active ? __( 'פעיל', 'site-theme' ) : __( 'לא פעיל', 'site-theme' ) );
	}

	if ( 'announcement_link' === $column ) {
		$link = get_post_meta( $post_id, '_announcement_link', true );
		echo $link ? '<a class="ltr" href="' . esc_url( $link ) . '" target="_blank" rel="noreferrer">' . esc_html( $link ) . '</a>' : '—';
	}
}
add_action( 'manage_announcement_posts_custom_column', 'site_theme_announcement_column_content', 10, 2 );

function site_theme_banner_columns( $columns ) {
	$columns['banner_active']     = __( 'סטטוס', 'site-theme' );
	$columns['banner_background'] = __( 'רקע', 'site-theme' );
	$columns['banner_button']     = __( 'כפתור', 'site-theme' );

	return $columns;
}
add_filter( 'manage_banner_posts_columns', 'site_theme_banner_columns' );

function site_theme_banner_column_content( $column, $post_id ) {
	if ( 'banner_active' === $column ) {
		$is_active = '1' === get_post_meta( $post_id, '_banner_active', true );
		echo esc_html( $is_active ? __( 'פעיל', 'site-theme' ) : __( 'לא פעיל', 'site-theme' ) );
	}

	if ( 'banner_background' === $column ) {
		$background = get_post_meta( $post_id, '_banner_background', true );
		$background = $background ? $background : 'banner-1.webp';
		echo esc_html( site_theme_banner_backgrounds()[ $background ] ?? $background );
	}

	if ( 'banner_button' === $column ) {
		$text = get_post_meta( $post_id, '_banner_button_text', true );
		$link = get_post_meta( $post_id, '_banner_button_link', true );

		if ( $link ) {
			echo '<a class="ltr" href="' . esc_url( $link ) . '" target="_blank" rel="noreferrer">' . esc_html( $text ? $text : $link ) . '</a>';
		} else {
			echo esc_html( $text ? $text : '—' );
		}
	}
}
add_action( 'manage_banner_posts_custom_column', 'site_theme_banner_column_content', 10, 2 );

function site_theme_refresh_rewrite_rules() {
	site_theme_register_content_structure();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'site_theme_refresh_rewrite_rules' );
