<?php

final class Utils
{
    public static function renderTwigTemplate($loaderSrc, $templateSrc, $params = array())
    {
        $loader = new \Twig\Loader\FilesystemLoader($loaderSrc);
        $twig = new \Twig\Environment($loader);
        
        echo $twig->load($templateSrc)->render($params);
    }

    public static function executeSQL($sql, $objType)
    {
        $con = MySQLConnection::getInstance();

        $sql = $con->prepare($sql);
        $sql->execute();

        $results = array();

        while ($row = $sql->fetchObject($objType)) {
            $results[] = $row;
        }

        return $results;
    }
}
