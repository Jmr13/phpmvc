<?php 
  namespace app\core;
  
  use app\core\Application;
  use app\core\Model;

  abstract class DbModel extends Model {
    abstract public function tableName(): string;
    abstract public function attributes(): array;
    
    public function save() {
      $tableName = $this->tableName();
      $attributes = $this->attributes();
      $params = array_map(fn($attr) => ":$attr", $attributes);
      $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") 
        VALUES (".implode(',', $params).")");
      foreach ($attributes as $attribute) {
        $statement->bindValue(":$attribute", $this->{$attribute});
      }
      $statement->execute();
      return true;
    }
    
    /* $where = [email => zura@example.com, firstname => zura] */
    public function findOne($where) {
      $tableName = static::tableName();
      $attributes = array_keys($where);
      /* SELECT * FROM $tableName WHERE email = :email AND firstname = :firstname */
      $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
      $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
      foreach ($where as $key => $item) {
        $statement->bindValue(":$key", $item);
      }
      
      $statement->execute();
      return $statement->fetchObject(static::class);
    }
    
    public static function prepare($sql) {
      return Application::$app->db->pdo->prepare($sql);
    }
  }
?>