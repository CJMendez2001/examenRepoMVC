<?php
namespace Dao\Viajes;

use Dao\Table;

class Viajes extends Table {
  public static function getViajes(
    string $destino = "",
    string $medio_transporte = "",
    int $page = 0,
    int $itemsPerPage = 10
  ) {
    $sqlstr = "SELECT v.id_viaje, v.destino, v.medio_transporte, v.duracion_dias, v.costo_total, v.fecha_inicio
               FROM DatosViajes v";
    $sqlstrCount = "SELECT COUNT(*) as count FROM DatosViajes v";
    $conditions = [];
    $params = [];
    
    if ($destino != "") {
      $conditions[] = "v.destino LIKE :destino";
      $params["destino"] = "%" . $destino . "%";
    }
    if ($medio_transporte != "") {
      $conditions[] = "v.medio_transporte = :medio_transporte";
      $params["medio_transporte"] = $medio_transporte;
    }
    if (count($conditions) > 0) {
      $sqlstr .= " WHERE " . implode(" AND ", $conditions);
      $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
    }
    
    $numeroDeRegistros = self::obtenerUnRegistro($sqlstrCount, $params)["count"];
    $pagesCount = ceil($numeroDeRegistros / $itemsPerPage);
    if ($page > $pagesCount - 1) {
      $page = $pagesCount - 1;
    }
    $sqlstr .= " LIMIT " . $page * $itemsPerPage . ", " . $itemsPerPage;

    $registros = self::obtenerRegistros($sqlstr, $params);
    return ["viajes" => $registros, "total" => $numeroDeRegistros, "page" => $page, "itemsPerPage" => $itemsPerPage];
  }
  
  public static function getViajeById(int $id_viaje) {
    $sqlstr = "SELECT v.id_viaje, v.destino, v.medio_transporte, v.duracion_dias, v.costo_total, v.fecha_inicio
               FROM DatosViajes v WHERE v.id_viaje = :id_viaje";
    $params = ["id_viaje" => $id_viaje];
    return self::obtenerUnRegistro($sqlstr, $params);
  }
  
  public static function insertViaje(
    string $destino,
    string $medio_transporte,
    int $duracion_dias,
    float $costo_total,
    string $fecha_inicio
  ) {
    $sqlstr = "INSERT INTO DatosViajes (destino, medio_transporte, duracion_dias, costo_total, fecha_inicio)
               VALUES (:destino, :medio_transporte, :duracion_dias, :costo_total, :fecha_inicio)";
    $params = [
      "destino" => $destino,
      "medio_transporte" => $medio_transporte,
      "duracion_dias" => $duracion_dias,
      "costo_total" => $costo_total,
      "fecha_inicio" => $fecha_inicio
    ];
    return self::executeNonQuery($sqlstr, $params);
  }
  
  public static function updateViaje(
    int $id_viaje,
    string $destino,
    string $medio_transporte,
    int $duracion_dias,
    float $costo_total,
    string $fecha_inicio
  ) {
    $sqlstr = "UPDATE DatosViajes SET destino = :destino, medio_transporte = :medio_transporte, duracion_dias = :duracion_dias,
               costo_total = :costo_total, fecha_inicio = :fecha_inicio WHERE id_viaje = :id_viaje";
    $params = [
      "id_viaje" => $id_viaje,
      "destino" => $destino,
      "medio_transporte" => $medio_transporte,
      "duracion_dias" => $duracion_dias,
      "costo_total" => $costo_total,
      "fecha_inicio" => $fecha_inicio
    ];
    return self::executeNonQuery($sqlstr, $params);
  }
  
  public static function deleteViaje(int $id_viaje) {
    $sqlstr = "DELETE FROM DatosViajes WHERE id_viaje = :id_viaje";
    $params = ["id_viaje" => $id_viaje];
    return self::executeNonQuery($sqlstr, $params);
  }
}
?>
