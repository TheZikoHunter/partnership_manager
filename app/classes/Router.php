<?php

class Router {
    private static array $routes;

    public static function register($route = '/', $filename=''){
        self::$routes[$route] = $filename;
    }

    public static function run(string $URI){
        $route = explode('?', $URI)[0];
        $play = self::$routes[$route];

        try{
				if($route !== '/addUser' && $route !== '/dbError' && $route !==  '/404'){
					ob_start();
					require_once $play;
					$content = ob_get_clean();
					require_once ABSOLUTE_PATH . '/pages/layouts/layout.php';
				}else{
					require_once $play;
				}
            } catch(Throwable $e){
                echo "<h1>Can't find the file </h1> <p>" . $e -> getMessage() . "</p>";
            }
    }
    public static function authentificate(){
        try{
            require_once ABSOLUTE_PATH . '/pages/register.php';
			
        }catch(Throwable $t){
            echo "problem in router.php oh no : " . $t;
        }
        
    }
}