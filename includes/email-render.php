<?php

	namespace ETCFW_M\INC;

	if (!defined('ABSPATH')) exit;

	class Email_Render {

		public function __construct( ) {
			add_action('plugins_loaded', function () {
				add_action('viwec_order_item_parts', [ $this, 'remove_prev_order_download' ], 9);
				add_action('viwec_order_item_parts', [ $this, 'order_download' ], 10, 3);
			});
		}

		public function remove_prev_order_download () {
			include_once(WP_PLUGIN_DIR . '/email-template-customizer-for-woo/includes/email-render.php');

			$priority = has_action('viwec_order_item_parts', [ \VIWEC\INC\Email_Render::init(), 'order_download' ]);

			remove_action('viwec_order_item_parts', [ \VIWEC\INC\Email_Render::init(), 'order_download' ], $priority);
		}

		public function order_download ( $item_id, $item, $order ) {
			$show_downloads = $order->has_downloadable_item() && $order->is_download_permitted();

			if ( ! $show_downloads ) {
				return;
			}

			$pid       = $item->get_data()['product_id'];
			$downloads = $order->get_downloadable_items();

			foreach ( $downloads as $download ) {
				if ( $pid == $download['product_id'] ) {
					$href    = esc_url( $download['download_url'] );
					$display = esc_html( $download['download_name'] );
					$expires = '';
					if ( ! empty( $download['access_expires'] ) ) {
						$datetime     = esc_attr( date_i18n( 'Y-m-d', strtotime( $download['access_expires'] ) ) );
						$title        = esc_attr( strtotime( $download['access_expires'] ) );
						$display_time = esc_html( date_i18n( get_option( 'date_format' ), strtotime( $download['access_expires'] ) ) );
						$expires      = "<br>Download Expires - <time datetime='$datetime' title='$title'>$display_time</time>";
					}
					printf( "<p><a href='%s'>%s</a> %s</p>", esc_url( $href ), esc_html( $display ), $expires );
				}
			}
		}
	}

