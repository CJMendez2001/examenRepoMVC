<?php
namespace Dao\Categories;

use Dao\Table;

class Categories extends Table {
  public static function getCategories(
    string $partialName = "",
    string $status = "",
    string $orderBy = "",
    bool $orderDescending = false,
    int $page = 0,
    int $itemsPerPage = 10
  ) {
    $sqlstr = "SELECT c.CategoryID, c.CategoryName, c.Description, c.CreatedDate, c.IsActive,
                      CASE 
                          WHEN c.IsActive = 1 THEN 'Activo' 
                          ELSE 'Inactivo' 
                      END as StatusDescription
               FROM Categories c";
    $sqlstrCount = "SELECT COUNT(*) as count FROM Categories c";
    $conditions = [];
    $params = [];
    
    if ($partialName != "") {
        $conditions[] = "c.CategoryName LIKE :partialName";
        $params["partialName"] = "%" . $partialName . "%";
    }
    
    if ($status !== "" && in_array($status, ["1", "0"])) {
        $conditions[] = "c.IsActive = :status";
        $params["status"] = $status;
    } elseif ($status !== "") {
        throw new \Exception("Error Processing Request: Status has invalid value");
    }
    
    if (count($conditions) > 0) {
        $sqlstr .= " WHERE " . implode(" AND ", $conditions);
        $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
    }
    
    if ($orderBy != "" && in_array($orderBy, ["CategoryID", "CategoryName", "CreatedDate"])) {
        $sqlstr .= " ORDER BY " . $orderBy;
        if ($orderDescending) {
            $sqlstr .= " DESC";
        }
    } elseif ($orderBy != "") {
        throw new \Exception("Error Processing Request: OrderBy has invalid value");
    }
    
    $numeroDeRegistros = self::obtenerUnRegistro($sqlstrCount, $params)["count"];
    $pagesCount = ceil($numeroDeRegistros / $itemsPerPage);
    
    if ($page > $pagesCount - 1) {
        $page = $pagesCount - 1;
    }
    
    $sqlstr .= " LIMIT " . ($page * $itemsPerPage) . ", " . $itemsPerPage;
    
    $registros = self::obtenerRegistros($sqlstr, $params);
    
    return [
        "categories" => $registros, 
        "total" => $numeroDeRegistros, 
        "page" => $page, 
        "itemsPerPage" => $itemsPerPage
    ];
  }

  public static function getCategoryById(int $categoryId) {
    $sqlstr = "SELECT c.CategoryID, c.CategoryName, c.Description, c.CreatedDate, c.IsActive
               FROM Categories c
               WHERE c.CategoryID = :categoryId";
    
    $params = ["categoryId" => $categoryId];
    
    return self::obtenerUnRegistro($sqlstr, $params);
  }

  public static function insertCategory(
    string $categoryName,
    string $description,
    string $isActive
  ) {
    $sqlstr = "INSERT INTO Categories (CategoryName, Description, CreatedDate, IsActive) 
               VALUES (:categoryName, :description, NOW(), :isActive)";
    $params = [
      "categoryName" => $categoryName,
      "description" => $description,
      "isActive" => $isActive
    ];
    return self::executeNonQuery($sqlstr, $params);
  }

  public static function updateCategory(
    int $categoryId,
    string $categoryName,
    string $description,
    string $isActive
  ) {
    $sqlstr = "UPDATE Categories 
               SET CategoryName = :categoryName, 
                   Description = :description, 
                   IsActive = :isActive 
               WHERE CategoryID = :categoryId";
    $params = [
      "categoryId" => $categoryId,
      "categoryName" => $categoryName,
      "description" => $description,
      "isActive" => $isActive
    ];
    return self::executeNonQuery($sqlstr, $params);
  }

  public static function deleteCategory(int $categoryId) {
    $sqlstr = "DELETE FROM Categories WHERE CategoryID = :categoryId";
    $params = ["categoryId" => $categoryId];
    return self::executeNonQuery($sqlstr, $params);
  }
}
?>
