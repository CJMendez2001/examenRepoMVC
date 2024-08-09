<?php
namespace Dao\Funciones;

use Dao\Table;

class Funciones extends Table
{
    public static function getFuncionByCod(string $fncod)
{
    $sqlstr = "SELECT fncod, fndsc, fnest, fntyp FROM funciones WHERE fncod = :fncod";
    return self::obtenerUnRegistro($sqlstr, compact("fncod"));
}

    public static function getFunciones(
        string $partialName = "",
        string $status = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $offset = 0,
        int $itemsPerPage = 10
    ) {
        $sqlstr = "SELECT f.fncod, f.fndsc, f.fnest, f.fntyp
                   FROM funciones f";
        $sqlstrCount = "SELECT COUNT(*) as count FROM funciones f";
        $conditions = [];
        $params = [];

        if ($partialName != "") {
            $conditions[] = "f.fndsc LIKE :partialName";
            $params["partialName"] = "%" . $partialName . "%";
        }

        if (!in_array($status, ["ACT", "INA", ""])) {
            throw new \Exception("Error Processing Request: Status has invalid value");
        }

        if ($status != "") {
            $conditions[] = "f.fnest = :status";
            $params["status"] = $status;
        }

        if (count($conditions) > 0) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }

        if (!in_array($orderBy, ["fncod", "fndsc", ""])) {
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

        if ($offset < 0) {
            $offset = 0;
        }

        $sqlstr .= " LIMIT " . $offset . ", " . $itemsPerPage;

        $registros = self::obtenerRegistros($sqlstr, $params);

        return [
            "funciones" => $registros,
            "total" => $numeroDeRegistros,
            "page" => $offset / $itemsPerPage,
            "itemsPerPage" => $itemsPerPage
        ];
    }

    public static function getFuncionById(string $fncod)
    {
        $sqlstr = "SELECT f.fncod, f.fndsc, f.fnest, f.fntyp
                   FROM funciones f
                   WHERE f.fncod = :fncod;";
        return self::obtenerUnRegistro($sqlstr, array("fncod" => $fncod));
    }

    public static function insertFuncion($fncod, $fndsc, $fnest, $fntyp)
    {
        $sqlins = "INSERT INTO funciones (fncod, fndsc, fnest, fntyp) 
                   VALUES (:fncod, :fndsc, :fnest, :fntyp);";
        return self::executeNonQuery(
            $sqlins,
            compact("fncod", "fndsc", "fnest", "fntyp")
        );
    }

    public static function updateFuncion($fncod, $fndsc, $fnest, $fntyp)
    {
        $sqlupd = "UPDATE funciones SET fndsc = :fndsc, fnest = :fnest, fntyp = :fntyp 
                   WHERE fncod = :fncod;";
        return self::executeNonQuery(
            $sqlupd,
            compact("fncod", "fndsc", "fnest", "fntyp")
        );
    }

    public static function deleteFuncion($fncod)
    {
        $sqldel = "DELETE FROM funciones WHERE fncod = :fncod;";
        return self::executeNonQuery(
            $sqldel,
            compact("fncod")
        );
    }
}
?>
