<?php
	class Twig_library {
        public  $twig;
        function __construct($templates_path=''){
            
            require_once $_SERVER['DOCUMENT_ROOT'].'/nitin/vendor/autoload.php';
            if(isset($templates_path) && $templates_path!=""){
                $twigloader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/nitin/views/'.$templates_path."/");
            } else {
                $twigloader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/nitin/views/');
            }
            $this->twig = new \Twig\Environment($twigloader);
            //$this->twig->addExtension(new Twig_Extension_Debug());
            // $this->twig->setCache($_SERVER['DOCUMENT_ROOT'] . '/simplemvc-mater/views/html/twigcache/');
             return $this->twig;
        }

    }
