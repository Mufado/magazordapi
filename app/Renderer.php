<?php
/**
 * This app uses an default layout.
 * When layout is done, the app will input the View code in the body
 * of the template, loading the full page right after that.
 */
final class Renderer
{
    private static $instance = null;
    private static $layout;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$layout = "layout.html";
        }

        return self::$instance;
    }

    /**
     * Renders the new page based on `.html` source
     * 
     * This app uses Twig to help with the integration between Views and Controllers.
     * 
     * @param string $loaderSrc The source where Twig builds the enviromnent
     * @param string $templateName The source of the `.html` file
     * @param array $params Array of parameters that will be used by the View
     */
    public static function renderPage($loaderSrc, $templateName, $params = array())
    {
        $params = array(
            "body" => self::renderBody($loaderSrc, $templateName, $params),
            "script" => self::renderScript($loaderSrc, $templateName),
            "style" => self::renderStyle($loaderSrc, $templateName)
        );

        $layout = file_get_contents("Views/layout.html");

        $page = str_replace("{{ body }}", $params['body'], $layout);
        $page = str_replace("{{ script }}", $params['script'], $page);
        echo str_replace("{{ style }}", $params['style'], $page);
    }

    private static function renderBody($loaderSrc, $templateName, $params = array()) {
        try {
            ob_start();
                $loader = new \Twig\Loader\FilesystemLoader($loaderSrc);
                $twig = new \Twig\Environment($loader);
                echo $twig->load($templateName.".html")->render($params);
            return ob_get_clean();
        } catch (Exception) {
            return "";
        }
    }

    private static function renderScript($loaderSrc, $templateName) {
        try {
            ob_start();
                $loader = new \Twig\Loader\FilesystemLoader($loaderSrc."/Scripts");
                $twig = new \Twig\Environment($loader);

                $script = $twig->load($templateName.".js")->render();
                echo "<script>".$script."</script>";
            return ob_get_clean();
        } catch (Exception) {
            return "";
        }
    }

    private static function renderStyle($loaderSrc, $templateName) {
        try {
            ob_start();
                $loader = new \Twig\Loader\FilesystemLoader($loaderSrc."/Styles");
                $twig = new \Twig\Environment($loader);

                $style = $twig->load($templateName.".css")->render();

                echo "<style>".$style."</style>";
            return ob_get_clean();
        } catch (Exception) {
            return "";
        }
    }
}