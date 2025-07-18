<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

?><div class="notice notice-info wmodes-notice is-dismissible" data-wmodes_id="lite">
    <p><?php echo wp_kses( __( 'Hey, I noticed you having been using <strong>wModes - Catalog Mode, Product Pricing, Enquiry Forms & Promotions | for WooCommerce</strong>, that’s awesome! Could you please do me a favor and give it a 5-star rating to help us spread the word?', 'catalog-mode-pricing-enquiry-forms-promotions' ), array( 'strong' => array() ) ); ?></p>
    <p>
        <a href="https://wordpress.org/support/plugin/catalog-mode-pricing-enquiry-forms-promotions/reviews/" class="wmodes-btn" target="_blank"><span class="dashicons dashicons-external"></span><?php echo esc_html__( 'Yes! You deserve it', 'catalog-mode-pricing-enquiry-forms-promotions' ); ?></a>
        <a href="#" class="wmodes-btn wmodes-btn-secondary" data-wmodes_remind="yes"><span class="dashicons dashicons-calendar"></span><?php echo esc_html__( 'Nah, maybe later', 'catalog-mode-pricing-enquiry-forms-promotions' ); ?></a>
        <a href="#" class="wmodes-btn wmodes-btn-secondary"><span class="dashicons dashicons-smiley"></span><?php echo esc_html__( 'I already did', 'catalog-mode-pricing-enquiry-forms-promotions' ); ?></a>
    </p>
</div>