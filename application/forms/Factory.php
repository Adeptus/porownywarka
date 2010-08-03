<?php
 
class Application_Form_Factory {
 
    private static $_form = null;
 
    public static function create() {
        if (is_null(self::$_form)) {
            self::$_form = new Application_Form_MonitorAdd();
        }
        return self::$_form;
    }
 
    public static function setForm($form) {
        self::$_form = $form;
    }
 
}
