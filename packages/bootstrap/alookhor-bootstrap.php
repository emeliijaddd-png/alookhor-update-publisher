<?php
/**
 * ALOOKHOR — نصب و به‌روزرسانی خودکار «به‌روزرسان سایت آلوخور».
 *
 * این قطعه را یک بار در انتهای functions.php قالب فعال خود قرار دهید
 * (نمایش > ویرایشگر پرونده‌های پوسته > functions.php).
 *
 * کار آن فقط این است: جدیدترین نسخه ابزار را از مخزن شما می‌گیرد،
 * روی سایت نصب می‌کند و فعال می‌کند. پس از آن خود ابزار از طریق
 * دکمه «به‌روزرسانی حالا» در پیشخوان به‌روز می‌شود و دیگر نیازی
 * به هیچ فایل یا کاری نخواهد بود.
 */

if ( ! function_exists( 'alookhor_bootstrap_tick' ) ) {

	function alookhor_bootstrap_tick() {

		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		require_once ABSPATH . 'wp-admin/includes/plugin.php';

		$slug    = 'alookhor-sample-builder';
		$path    = $slug . '/' . $slug . '.php';
		$file    = WP_PLUGIN_DIR . '/' . $path;
		$stage   = get_option( 'alookhor_bootstrap_stage' );
		$repo    = 'https://raw.githubusercontent.com/emeliijaddd-png/alookhor-update-publisher/'
			. 'arena/01a0a537-alookhor-update-publisher/packages';

		// مرحله دوم: فعال‌سازی در یک درخواست تازه (برای جلوگیری از تداخل).
		if ( 'activate' === $stage ) {
			if ( file_exists( $file ) && ! is_plugin_active( $path ) ) {
				activate_plugin( $path, '', false, true );
			}
			delete_option( 'alookhor_bootstrap_stage' );
			return;
		}

		$manifest = wp_remote_get( $repo . '/updates/update.json', array( 'timeout' => 30 ) );
		if ( is_wp_error( $manifest ) ) {
			return;
		}

		$info = json_decode( wp_remote_retrieve_body( $manifest ) );
		if ( empty( $info->version ) || empty( $info->source ) ) {
			return;
		}

		$installed = '0';
		if ( file_exists( $file ) ) {
			$data = get_plugin_data( $file, false, false );
			if ( ! empty( $data['Version'] ) ) {
				$installed = $data['Version'];
			}
		}

		if ( ! version_compare( $info->version, $installed, '>' ) ) {
			return;
		}

		$response = wp_remote_get( $info->source, array( 'timeout' => 60 ) );
		if ( is_wp_error( $response ) ) {
			return;
		}

		$code = wp_remote_retrieve_body( $response );
		if ( ! $code || 0 !== strpos( $code, '<?php' ) ) {
			return;
		}

		if ( ! is_dir( dirname( $file ) ) ) {
			wp_mkdir_p( dirname( $file ) );
		}

		if ( is_plugin_active( $path ) ) {
			deactivate_plugins( $path, true );
		}

		if ( ! file_put_contents( $file, $code ) ) {
			return;
		}

		update_option( 'alookhor_bootstrap_stage', 'activate', false );
	}

	add_action( 'admin_init', 'alookhor_bootstrap_tick' );
}
