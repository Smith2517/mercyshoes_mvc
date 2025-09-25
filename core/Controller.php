<?php
class Controller {
    protected function render($viewPath, $data = [], $layout = 'main') {
        extract($data);
        $viewFile = __DIR__ . '/../app/views/' . $viewPath . '.php';
        $layoutFile = __DIR__ . '/../app/views/partials/layout_' . $layout . '.php';
        if (!file_exists($viewFile)) {
            http_response_code(404);
            echo "<h2>Vista no encontrada: $viewPath</h2>";
            return;
        }
        include $layoutFile;
    }

    protected function renderPartial($viewPath, $data = []) {
        extract($data);
        $viewFile = __DIR__ . '/../app/views/' . $viewPath . '.php';
        if (!file_exists($viewFile)) {
            http_response_code(404);
            echo "<h2>Vista no encontrada: $viewPath</h2>";
            return;
        }
        include $viewFile;
    }

    protected function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    protected function redirect($route) {
        $url = BASE_URL . '?r=' . urlencode($route);
        header("Location: $url");
        exit;
    }
    protected function isPost() { return $_SERVER['REQUEST_METHOD'] === 'POST'; }
}
?>
