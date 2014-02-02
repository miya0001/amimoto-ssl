<?php
/*
Plugin Name: Amimoto SSL
Author: Takayuki Miyauchi
*/

$amimoto_ssl = new Amimoto_SSL();
$amimoto_ssl->register();

class Amimoto_SSL {

function register()
{
    add_action('plugins_loaded', array($this, 'plugins_loaded'));
}

public function plugins_loaded()
{
    $hooks = array(
        "home_url",
        "site_url",
        "stylesheet_directory_uri",
        "template_directory_uri",
        "plugins_url",
        "wp_get_attachment_url",
        "theme_mod_header_image",
        "theme_mod_background_image",
        "the_content",
        "upload_dir",
    );

    foreach ($hooks as $hook) {
        add_filter($hook, array($this, 'ssl_fix'));
    }
}

public  function ssl_fix($uri)
{
    if (is_admin()) {
        return $uri;
    } else {
        $ssl_url = preg_replace("#^http(s)?\:#", "", WP_HOME);
        return str_replace(WP_HOME, $ssl_url, "", WP_HOME), $uri);
    }
}

}

// EOF
