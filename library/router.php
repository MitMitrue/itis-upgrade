<?php

class Router
{
	private $routes;

	public function __construct()
	{

		$routesPath = ROOT .'config/routes.php';


        $this->routes = include($routesPath);
	}

	private function getURI() // обращаемся только из этого класса
	{
		if(!empty($_SERVER['REQUEST_URI']))
	 		return trim($_SERVER['REQUEST_URI'], '/');
	} //возврашает строку (Запрос)

	public function run()
	{

		//получить строку запроса
		$uri = $this->getURI();

		//Проверить наличие такого запроса в routes.php
		foreach ($this->routes as $uriPattern => $path) {
			// проверка на соответствие регулярному выражению
			if (preg_match("~$uriPattern~", $uri)) { 
				// разделить путь на контроллер и action
				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);
				//Если есть совпадение, определить какой контроллер и 
					//action обрабатывае запрос
				$segments = explode('/', $path);
				// Составляем название контроллера
				$controllerName = array_shift($segments) . 'Controller'; //вырезаем первый элемент
				$controllerName = ucfirst($controllerName); // имя контроллера с большой буквы
				// Аналогично action 
				$actionName = 'action' . ucfirst(array_shift($segments));
				$paramentrs = $segments;
				//Подключить файл класса контроллера
				// создаем путь к файлу
				$controllerFile =  ROOT . 'controllers/' . $controllerName . '.php';
				if (file_exists($controllerFile)) { // проверяем наличие файла
					include_once($controllerFile); // подключаем
				}
				//Создать объект, вызвать метод (т.е. action)
				$controllerObject = new $controllerName;
				//$result = $controllerObject->$actionName($paramentrs);

                
				$result = call_user_func_array(array($controllerObject,$actionName),$paramentrs);
				// подобная функция, но параметры передаваемые можно принимать по другому и сразу присваивать их $category $id
				if ($result != null) {
					break;
				}
			}
		}
	}
}