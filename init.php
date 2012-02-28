<?php
    $route = new YPFObject;
    $route->match = '/preview';
    $route->controller = 'design_preview\main';
    $route->action = 'index';
    $route->method = 'get';
    YPFramework::setSetting('routes.design_preview', $route);

    $route = new YPFObject;
    $route->match = '/preview';
    $route->controller = 'design_preview\main';
    $route->action = 'preview';
    $route->method = 'POST';
    YPFramework::setSetting('routes.do_design_preview', $route);
?>
