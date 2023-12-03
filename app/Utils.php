<?php

final class Utils
{
    public static function renderTwigTemplate($loaderSrc, $templateSrc, $params = array())
    {
        $loader = new \Twig\Loader\FilesystemLoader($loaderSrc);
        $twig = new \Twig\Environment($loader);
        
        echo $twig->load($templateSrc)->render($params);
    }
}
