<?php
  namespace app\core;

  class Application {
    public static string $ROOT_DIR;
    
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?DbModel $user;
    
    public static Application $app;
    public Controller $controller;
    
    public function __construct($rootPath, array $config) {
      $this->userClass = $config['userClass'];
      self::$ROOT_DIR = $rootPath;
      self::$app = $this;
      $this->request = new Request();
      $this->response = new Response();
      $this->session = new Session();
      $this->router = new Router($this->request, $this->response);
      
      $this->db = new Database($config['db']);
      
      $primaryValue = $this->session->get('user');
      if($primaryValue) {
        $primarykey = $this->userClass::primaryKey();
        $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
      }
      else {
        $this->user = null;
      }
    }
    
    public static function isGuest() {
      return !self::$app->user;
    }
    
    public function run() {
      echo $this->router->resolve();
    }
    
    public function getController(): Controller {
      return $this->controller;
    }
    
    public function setController(Controller $controller): void {
      $this->controller = $controller;
    }
    
    public function login(DbModel $user) {
      $this->user = $user;
      $primarykey = $user->primarykey();
      $primaryValue = $user->{$primarykey};
      $this->session->set('user', $primaryValue);
      return true;
    }
    
    public function logout() {
      $this->user = null;
      $this->session->remove('user');
    }
  }
?>