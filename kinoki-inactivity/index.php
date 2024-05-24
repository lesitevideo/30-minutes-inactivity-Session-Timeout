<?php
/*
Plugin Name: 30 minutes inactivity Session Timeout
Description: session timeout functionality.
Version: 1.0
Author: Kinoki team
*/

function cnesbo_session_timeout_script() {
    ?>
    <script>
        jQuery(document).ready(function($) {
            var maxIdleTime = 1800; // 1800 secondes = 30 minutes
            var idleTimer;

            function resetTimer() {
                clearTimeout(idleTimer);
                idleTimer = setTimeout(logoutUser, maxIdleTime * 1000);
            }

            function logoutUser() {
                var data = {
                    'action': 'cnesbo_verify_user_session'
                };
                $.post(ajaxurl, data, function(response) {
                    alert('Votre session est terminée faute de la moindre activité depuis 30 minutes.');
                    window.location.reload();
                });
            }

            $(document).on("mousemove keypress", resetTimer);
            resetTimer();
        });
    </script>
    <?php
}

function cnesbo_verify_user_session() {
    wp_destroy_current_session();
    wp_die();
}

add_action('admin_head', 'cnesbo_session_timeout_script');

add_action('wp_ajax_cnesbo_verify_user_session', 'cnesbo_verify_user_session');
?>