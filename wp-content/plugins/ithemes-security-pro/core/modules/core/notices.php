<?php

ITSEC_Lib_Admin_Notices::register(
	new ITSEC_Admin_Notice_Globally_Dismissible(
		new ITSEC_Admin_Notice_Managers_Only(
			new class implements ITSEC_Admin_Notice {
				public function get_id() {
					return ITSEC_Core::is_pro() ?
						'release-import-export-launch' :
						'release-site-scanner-free';
				}

				public function get_title() {
					return '';
				}

				public function get_message() {
					return ITSEC_Core::is_pro() ?
						esc_html__( 'iThemes Security Pro 7.1 is here!', 'it-l10n-ithemes-security-pro' ) :
						esc_html__( 'iThemes Security Pro’s most popular and powerful feature is now free in iThemes Security 8.1!', 'it-l10n-ithemes-security-pro' );
				}

				public function get_meta() {
					return array();
				}

				public function get_severity() {
					return self::S_INFO;
				}

				public function show_for_context( ITSEC_Admin_Notice_Context $context ) {
					return true;
				}

				public function get_actions() {
					return array(
						'blog' => new ITSEC_Admin_Notice_Action_Link(
							add_query_arg( 'itsec_view_release_post', $this->get_id(), admin_url( 'index.php' ) ),
							esc_html__( 'See What’s New', 'it-l10n-ithemes-security-pro' ),
							ITSEC_Admin_Notice_Action::S_PRIMARY,
							function () {
								$this->handle_dismiss();
								$url = ITSEC_Core::is_pro() ? 'https://ithemes.com/?p=72545' : 'https://ithemes.com/?p=73198';

								wp_redirect( $url );
								die;
							}
						)
					);
				}

				private function handle_dismiss() {
					$dismissed   = $this->get_storage();
					$dismissed[] = $this->get_id();
					$this->save_storage( $dismissed );

					return null;
				}

				private function get_storage() {
					$dismissed = get_site_option( 'itsec_dismissed_notices', array() );

					if ( ! is_array( $dismissed ) ) {
						$dismissed = array();
					}

					return $dismissed;
				}

				private function save_storage( $storage ) {
					update_site_option( 'itsec_dismissed_notices', $storage );
				}
			}
		)
	)
);

if ( ! ITSEC_Modules::is_active( 'malware-scheduling' ) ) {
	ITSEC_Lib_Admin_Notices::register(
		new ITSEC_Admin_Notice_Globally_Dismissible(
			new ITSEC_Admin_Notice_Managers_Only(
				new class implements ITSEC_Admin_Notice {
					public function get_id() {
						return 'enable-site-scan';
					}

					public function get_title() {
						return __( 'New! Scheduled Site Scans' );
					}

					public function get_message() {
						return __( 'Enable the Site Scanner to automatically scan your site twice a day for malware and known vulnerabilities.', 'it-l10n-ithemes-security-pro' );
					}

					public function get_meta() {
						return [];
					}

					public function get_severity() {
						return self::S_INFO;
					}

					public function show_for_context( ITSEC_Admin_Notice_Context $context ) {
						return true;
					}

					public function get_actions() {
						return [
							'enable' => new ITSEC_Admin_Notice_Action_Callback(
								ITSEC_Admin_Notice_Action::S_PRIMARY,
								__( 'Enable Scheduling', 'it-l10n-ithemes-security-pro' ),
								function () {
									ITSEC_Modules::activate( 'malware-scheduling' );
								}
							)
						];
					}
				}
			)
		)
	);
}

if ( version_compare( PHP_VERSION, ITSEC_Core::get_next_php_requirement(), '<' ) ) {
	ITSEC_Lib_Admin_Notices::register(
		new ITSEC_Admin_Notice_Remind_Me( new ITSEC_Admin_Notice_Managers_Only( new class implements ITSEC_Admin_Notice {
			public function get_id() {
				return 'php-outdated';
			}

			public function get_title() {
				return sprintf(
					__( 'Your site is running an outdated version of PHP (%1$s). Future versions of iThemes Security will require PHP %2$s or later.', 'it-l10n-ithemes-security-pro' ),
					explode( '-', PHP_VERSION )[0],
					ITSEC_Core::get_next_php_requirement()
				);
			}

			public function get_message() {
				return '';
			}

			public function get_meta() {
				return [];
			}

			public function get_severity() {
				return self::S_WARN;
			}

			public function show_for_context( ITSEC_Admin_Notice_Context $context ) {
				return true;
			}

			public function get_actions() {
				$actions = [
					'more' => new ITSEC_Admin_Notice_Action_Link(
						'https://ithemes.com/security/php-requirements/',
						__( 'Learn More', 'it-l10n-ithemes-security-pro' ),
						ITSEC_Admin_Notice_Action::S_PRIMARY
					)
				];

				if ( $direct_update = wp_get_direct_php_update_url() ) {
					$actions['direct_update'] = new ITSEC_Admin_Notice_Action_Link(
						$direct_update,
						__( 'Update PHP', 'it-l10n-ithemes-security-pro' ),
						ITSEC_Admin_Notice_Action::S_PRIMARY
					);
				}

				return $actions;
			}
		} ), WEEK_IN_SECONDS )
	);
}
