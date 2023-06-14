<?php
function flash($name = '', $message = '', $class = 'form-message form-message-red'){
    if(!empty($name)){
        if(!empty($message) && empty($_SESSION[$name])){
            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = $class;
        }else if(empty($message) && !empty($_SESSION[$name])){
            $class = !empty($_SESSION[$name.'_class']) ? $_SESSION[$name.'_class'] : $class;
            echo '<div class="' . $class . '">';
            echo '<ul>';
            foreach ($_SESSION[$name] as $element) {
                echo '<li>' . $element . '</li>';
            }
            echo '</ul>';
            echo '</div>';
            
            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);
        }
    }
}