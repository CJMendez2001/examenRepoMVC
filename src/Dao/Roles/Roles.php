<?php

namespace Dao\Roles;

use Dao\Table;

class Roles extends Table
{
    public static function getRoles(
        string $partialName = "",
        string $status = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ) {
        $sqlstr = "SELECT r.rolescod, r.rolesdsc, r.rolesest,
                          CASE 
                              WHEN r.rolesest = 'ACT' THEN 'Activo' 
                              WHEN r.rolesest = 'INA' THEN 'Inactivo' 
                              ELSE 'Sin Asignar' 
                          END as rolesestDsc
                   FROM roles r";
        $sqlstrCount = "SELECT COUNT(*) as count FROM roles r";
        $conditions = [];
        $params = [];

        if ($partialName != "") {
            $conditions[] = "r.rolesdsc LIKE :partialName";
            $params["partialName"] = "%" . $partialName . "%";
        }

        if (!in_array($status, ["ACT", "INA", ""])) {
            throw new \Exception("Error Processing Request: Status has invalid value");
        }

        if ($status != "") {
            $conditions[] = "r.rolesest = :status";
            $params["status"] = $status;
        }

        if (count($conditions) > 0) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }

        if (!in_array($orderBy, ["rolescod", "rolesdsc", ""])) {
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
            "roles" => $registros,
            "total" => $numeroDeRegistros,
            "page" => $page,
            "itemsPerPage" => $itemsPerPage
        ];
    }

    public static function getRoleByCode(string $rolescod)
    {
        $sqlstr = "SELECT r.rolescod, r.rolesdsc, r.rolesest
                   FROM roles r
                   WHERE r.rolescod = :rolescod";

        $params = ["rolescod" => $rolescod];

        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insertRole(
        string $rolescod,
        string $rolesdsc,
        string $rolesest
    ) {
        $sqlstr = "INSERT INTO roles (rolescod, rolesdsc, rolesest) 
                   VALUES (:rolescod, :rolesdsc, :rolesest)";

        $params = [
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateRole(
        string $rolescod,
        string $rolesdsc,
        string $rolesest
    ) {
        $sqlstr = "UPDATE roles 
                   SET rolesdsc = :rolesdsc, 
                       rolesest = :rolesest
                   WHERE rolescod = :rolescod";

        $params = [
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteRole(string $rolescod)
    {
        $sqlstr = "DELETE FROM roles WHERE rolescod = :rolescod";
        $params = ["rolescod" => $rolescod];
        return self::executeNonQuery($sqlstr, $params);
    }
}

?>
