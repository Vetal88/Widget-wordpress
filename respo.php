<?php
require __DIR__ . '/BookmarksWidget.php';

/**
 * Plugin Name:       repo
 * Description:       Plugin  repo.
 * Version:           1.0.0
 * Author:            Vitalik
 * License:           GPL-1.0+
 */
class Repo
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'style_include'));
        add_action('widgets_init', array($this, 'widget'));
        add_action('wp_dashboard_setup', array($this, 'dashboardWidget'));
        add_action( 'wp_ajax_send_message', array( $this, 'send_message' ) );
        add_action( 'wp_ajax_nopriv_send_message', array( $this, 'send_message' ) );


    }

    public function style_include()
    {
        global $post;

        wp_enqueue_script('jq', plugins_url() . '/repo/js/jquery.min.js', '', false);
        wp_enqueue_style('jq');
        wp_enqueue_script('repo', plugins_url() . '/repo/js/repo.js', '', false);
        wp_enqueue_style('repo');
        wp_localize_script('repo', 'repo', ['url' => admin_url('admin-ajax.php')]);

    }


    //dashboard
    public function dashboardWidget()
    {
        wp_add_dashboard_widget('dashboardWidget', 'favorite Form', array($this, 'show_bookmarks'));
    }

    public function show_bookmarks()
    {

        echo '<form class="form" id="form" name="form" method="POST" >
		<input type="text" id="name" class="form-field" name="name" placeholder="Введите ваше имя" >
		<input type="email" id="email" class="form-field" name="email" placeholder="Введите ваш email">
		<input type="submit" class="form-button">
	</form>';

    }

    public function send_message()
    {

        $contact_errors = false;

        $name = $_POST["name"];
        $email = $_POST["email"];

        // write the email content
        $header .= "MIME-Version: 1.0\n";
        $header .= "Access-Control-Allow-Origin: *\n";
        $header .= "From:" . $email;

        $message = "Name: $name\n";
        $message .= "Email Address: $email\n";
        $message .= "Message:\n$message";

        $subject = "test";
        $subject = "=?utf-8?B?" . base64_encode($subject) . "?=";

        $to = get_option('admin_email');

        if (!wp_mail($to, $subject, $message, $header)) {
            $contact_errors = true;
        }
        die();
    }
    public function widget()
    {
        register_widget('BookmarksWidget');
    }

    public function my_activation_func()
    {
        file_put_contents(__DIR__ . '/my_log.txt', ob_get_contents());
    }


}

$bookmarks = new Repo();
register_activation_hook(__FILE__, array('Repo', 'my_activation_func'));