<?php
namespace App\Core;
class Controller {
    public function model($model) {
        $modelClass = 'App\\Models\\' . $model;
        if (class_exists($modelClass)) {
            return new $modelClass();
        }
        throw new \Exception("Model $modelClass not found");
    }

    public function render($view, $data = []) {
        extract($data);
        if (file_exists(_DIR_ROOT . '/app/views/'.$view.'.php')) {
            require_once _DIR_ROOT . '/app/views/'.$view.'.php';
        }
    }
}