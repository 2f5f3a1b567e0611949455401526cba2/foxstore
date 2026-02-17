<?php
    function is_post_request(): bool {
        return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
    }

    function redirect($url) {
        header("Location: $url");
        exit;
    }

    // Check if we got a post request with all these values
    function post_contains(array $field_names):bool {
        if (!is_post_request()){
            return false;
        }
        foreach ($field_names as $name) {
            if (!isset($_POST[$name])) {
                return false;
            }
        }
        return true;
    }
?>