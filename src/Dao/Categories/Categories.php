<?php
namespace Dao\Categories;

use Dao\Table;

class Categories extends Table {
  public static function getFeaturedCategories() {
    $sqlstr = "SELECT c.categoryId, c.categoryName, c.categoryDescription, c.categoryImgUrl, c.categoryStatus FROM categories c INNER JOIN highlights h ON c.categoryId = h.categoryId WHERE h.highlightStart <= NOW() AND h.highlightEnd >= NOW()";
    $params = [];
    $registros = self::obtenerRegistros($sqlstr, $params);
    return $registros;
  }

  public static function getNewCategories() {
    $sqlstr = "SELECT c.categoryId, c.categoryName, c.categoryDescription, c.categoryImgUrl, c.categoryStatus FROM categories c WHERE c.categoryStatus = 'ACT' ORDER BY c.categoryId DESC LIMIT 3";
    $params = [];
    $registros = self::obtenerRegistros($sqlstr, $params);
    return $registros;
  }

  public static function getCategories(
    string $partialName = "",
    string $status = "",
    string $orderBy = "",
    bool $orderDescending = false,
    int $page = 0,
    int $itemsPerPage = 10
) {
    $sqlstr = "SELECT c.CategoryID, c.CategoryName, c.Description, c.CreatedDate, c.IsActive FROM Categories c";
    $sqlstrCount = "SELECT COUNT(*) as count FROM Categories c";
    $conditions = [];
    $params = [];
    if ($partialName != "") {
        $conditions[] = "c.CategoryName LIKE :partialName";
        $params["partialName"] = "%" . $partialName . "%";
    }
    if (!in_array($status, ["1", "0", ""])) {
        throw new \Exception("Error Processing Request Status has invalid value");
    }
    if ($status != "") {
        $conditions[] = "c.IsActive = :status";
        $params["status"] = $status;
    }
    if (count($conditions) > 0) {
        $sqlstr .= " WHERE " . implode(" AND ", $conditions);
        $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
    }
    if (!in_array($orderBy, ["CategoryID", "CategoryName", "CreatedDate", ""])) {
        throw new \Exception("Error Processing Request OrderBy has invalid value");
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
    return ["categories" => $registros, "total" => $numeroDeRegistros, "page" => $page, "itemsPerPage" => $itemsPerPage];
}

  public static function getCategoryById(int $categoryId) {
    $sqlstr = "SELECT c.categoryId, c.categoryName, c.categoryDescription, c.categoryImgUrl, c.categoryStatus FROM categories c WHERE c.categoryId = :categoryId";
    $params = ["categoryId" => $categoryId];
    return self::obtenerUnRegistro($sqlstr, $params);
  }

  public static function insertCategory(
    string $categoryName,
    string $categoryDescription,
    string $categoryImgUrl,
    string $categoryStatus
  ) {
    $sqlstr = "INSERT INTO categories (categoryName, categoryDescription, categoryImgUrl, categoryStatus) VALUES (:categoryName, :categoryDescription, :categoryImgUrl, :categoryStatus)";
    $params = [
      "categoryName" => $categoryName,
      "categoryDescription" => $categoryDescription,
      "categoryImgUrl" => $categoryImgUrl,
      "categoryStatus" => $categoryStatus
    ];
    return self::executeNonQuery($sqlstr, $params);
  }

  public static function updateCategory(
    int $categoryId,
    string $categoryName,
    string $categoryDescription,
    string $categoryImgUrl,
    string $categoryStatus
  ) {
    $sqlstr = "UPDATE categories SET categoryName = :categoryName, categoryDescription = :categoryDescription, categoryImgUrl = :categoryImgUrl, categoryStatus = :categoryStatus WHERE categoryId = :categoryId";
    $params = [
      "categoryId" => $categoryId,
      "categoryName" => $categoryName,
      "categoryDescription" => $categoryDescription,
      "categoryImgUrl" => $categoryImgUrl,
      "categoryStatus" => $categoryStatus
    ];
    return self::executeNonQuery($sqlstr, $params);
  }

  public static function deleteCategory(int $categoryId) {
    $sqlstr = "DELETE FROM categories WHERE categoryId = :categoryId";
    $params = ["categoryId" => $categoryId];
    return self::executeNonQuery($sqlstr, $params);
  }
}
?>
