<?php
/**
 * Nazareth Child Theme — functions.php
 *
 * Customizations applied on top of the parent Nazareth theme.
 *
 * Removed in Session 10: GA4 block (my_own_analytics)
 *   — GA4 was firing unconditionally, bypassing Complianz. GDPR non-compliance.
 *     Reconfigure via Complianz > Manage Consent > Statistics scripts.
 * Removed in Session 10: Output buffering (start_modify_html / end_modify_html)
 *   — Conflicted with WP Fastest Cache. Replaced by a targeted filter.
 * Updated in Session 10: Breadcrumb "Home" fix
 *   — trx_addons_filter_breadcrumbs does not exist in ThemeREX Addons 1.6.22.
 *     Replaced by a gettext filter scoped to ThemeREX text domains.
 */

/**
 * Enqueue the parent theme stylesheet.
 *
 * Only the parent stylesheet is loaded — no CSS overrides exist in the child theme.
 * If child theme CSS overrides are added later, switch to a two-handle version
 * that also enqueues get_stylesheet_directory_uri() . '/style.css'.
 */
function nazareth_child_scripts() {
    wp_enqueue_style( 'nazareth-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'nazareth_child_scripts' );

/**
 * Translate "Home" to "Accueil" in ThemeREX breadcrumb output.
 *
 * The hook trx_addons_filter_breadcrumbs does not exist in ThemeREX Addons 1.6.22.
 * The gettext filter intercepts translated strings at the WordPress level, before
 * they are rendered. Scoping to known ThemeREX text domains avoids accidentally
 * translating "Home" in unrelated plugin or admin strings.
 *
 * @param string $translated  The translated (or original) string.
 * @param string $text        The original English string.
 * @param string $domain      The text domain of the calling plugin or theme.
 * @return string
 */
function translate_home_to_accueil( $translated, $text, $domain ) {
    // Target only ThemeREX text domains to avoid side effects on other plugins
    $trx_domains = array( 'trx_addons', 'nazareth', 'nazareth-child' );

    if ( $text === 'Home' && in_array( $domain, $trx_domains, true ) ) {
        return 'Accueil';
    }

    return $translated;
}
add_filter( 'gettext', 'translate_home_to_accueil', 20, 3 );