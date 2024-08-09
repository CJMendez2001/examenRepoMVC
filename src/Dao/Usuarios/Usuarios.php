<?php
namespace Dao\Usuarios;

use Dao\Table;

class Usuarios extends Table {
  public static function getUsers(
    string $partialName = "",
    string $status = "",
    string $orderBy = "",
    bool $orderDescending = false,
    int $page = 0,
    int $itemsPerPage = 10
) {
    $sqlstr = "SELECT u.usercod, u.useremail, u.username, u.userfching, u.userest,
                    CASE 
                        WHEN u.userest = 'ACT' THEN 'Activo' 
                        WHEN u.userest = 'INA' THEN 'Inactivo' 
                        ELSE 'Sin Asignar' 
                    END as userestDsc
               FROM usuario u";
    $sqlstrCount = "SELECT COUNT(*) as count FROM usuario u";
    $conditions = [];
    $params = [];
    
    if ($partialName != "") {
        $conditions[] = "u.username LIKE :partialName";
        $params["partialName"] = "%" . $partialName . "%";
    }
    
    if (!in_array($status, ["ACT", "INA", ""])) {
        throw new \Exception("Error Processing Request: Status has invalid value");
    }
    
    if ($status != "") {
        $conditions[] = "u.userest = :status";
        $params["status"] = $status;
    }
    
    if (count($conditions) > 0) {
        $sqlstr .= " WHERE " . implode(" AND ", $conditions);
        $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
    }
    
    if (!in_array($orderBy, ["usercod", "username", "userfching", ""])) {
        throw new \Exception("Error Processing Request: OrderBy has invalid value");
    }
    
    if ($orderBy != "") {
        $sqlstr .= " ORDER BY " . $orderBy;
        if ($orderDescending) {
            $sqlstr .= " DESC";
        }
    }
    
    $numeroDeRegistros = self::obtenerUnRegistro($sqlstrCount, $params)["count"];
    $pagesCount = ceil($numeroDeRegistros / $itemsPerPage);
    
    if ($page > $pagesCount - 1) {
        $page = $pagesCount - 1;
    }
    
    $sqlstr .= " LIMIT " . $page * $itemsPerPage . ", " . $itemsPerPage;
    
    $registros = self::obtenerRegistros($sqlstr, $params);
    
    return [
        "usuarios" => $registros, 
        "total" => $numeroDeRegistros, 
        "page" => $page, 
        "itemsPerPage" => $itemsPerPage
    ];
}
public static function getUserById(int $usercod)
{
    $sqlstr = "SELECT u.usercod, u.useremail, u.username, u.userfching, u.userest
               FROM usuario u
               WHERE u.usercod = :usercod";
    
    $params = ["usercod" => $usercod];
    
    return self::obtenerUnRegistro($sqlstr, $params);
}
public static function insertUser(
  string $useremail,
  string $username,
  string $userpswd,
  string $usertipo,
  string $useractcod = null
) {
  $sqlstr = "INSERT INTO usuario (useremail, username, userpswd, userfching, userpswdest, userest, useractcod, usertipo) 
             VALUES (:useremail, :username, :userpswd, NOW(), 'NOE', 'ACT', :useractcod, :usertipo)";
  

  $userpswdHash = password_hash($userpswd, PASSWORD_DEFAULT);
  
  $params = [
      "useremail" => $useremail,
      "username" => $username,
      "userpswd" => $userpswdHash,
      "useractcod" => $useractcod,
      "usertipo" => $usertipo
  ];
  
  return self::executeNonQuery($sqlstr, $params);
}
public static function updateUser(
  int $usercod,
  string $useremail,
  string $username,
  string $userpswd,
  string $userest,
  string $usertipo,
  string $useractcod = null
) {
  
  $sqlstr = "UPDATE usuario 
             SET useremail = :useremail, 
                 username = :username, 
                 userpswd = :userpswd, 
                 userest = :userest,
                 useractcod = :useractcod,
                 usertipo = :usertipo
             WHERE usercod = :usercod";
  
  $userpswdHash = password_hash($userpswd, PASSWORD_DEFAULT);
  
  $params = [
      "usercod" => $usercod,
      "useremail" => $useremail,
      "username" => $username,
      "userpswd" => $userpswdHash,
      "userest" => $userest,
      "useractcod" => $useractcod,
      "usertipo" => $usertipo
  ];
  
  return self::executeNonQuery($sqlstr, $params);
}
public static function deleteUser(int $usercod)
{
    $sqlstr = "DELETE FROM usuario WHERE usercod = :usercod";
    $params = ["usercod" => $usercod];
    return self::executeNonQuery($sqlstr, $params);
}

}
?>
