<?php

namespace Controllers\Viajes;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Viajes\Viajes as ViajesDao;
use Utilities\Site;
use Utilities\Validators;

class Viaje extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";
    private $modeDescriptions = [
        "DSP" => "Detalle de %s %s",
        "INS" => "Nuevo Viaje",
        "UPD" => "Editar %s %s",
        "DEL" => "Eliminar %s %s"
    ];
    private $readonly = "";
    private $showCommitBtn = true;
    private $viaje = [
        "id_viaje" => 0,
        "destino" => "",
        "medio_transporte" => "",
        "duracion_dias" => 0,
        "costo_total" => 0,
        "fecha_inicio" => "",
        "status" => "ACT"
    ];
    private $viaje_xss_token = "";

    public function run(): void
    {
        try {
            $this->getData();
            if ($this->isPostBack()) {
                if ($this->validateData()) {
                    $this->handlePostAction();
                }
            }
            $this->setViewData();
            Renderer::render("viajes/viaje", $this->viewData);
        } catch (\Exception $ex) {
            Site::redirectToWithMsg(
                "index.php?page=Viajes_Viajes",
                $ex->getMessage()
            );
        }
    }

    private function getData()
    {
        $this->mode = $_GET["mode"] ?? "NOF";
        if (isset($this->modeDescriptions[$this->mode])) {
            $this->readonly = $this->mode === "DEL" ? "readonly" : "";
            $this->showCommitBtn = $this->mode !== "DSP";
            if ($this->mode !== "INS") {
                $this->viaje = ViajesDao::getViajeById(intval($_GET["id_viaje"]));
                if (!$this->viaje) {
                    throw new \Exception("No se encontró el Viaje", 1);
                }
            }
        } else {
            throw new \Exception("Formulario cargado en modalidad inválida", 1);
        }
    }

    private function validateData()
    {
        $errors = [];
        $this->viaje_xss_token = $_POST["viaje_xss_token"] ?? "";
        $this->viaje["id_viaje"] = intval($_POST["id_viaje"] ?? "");
        $this->viaje["destino"] = strval($_POST["destino"] ?? "");
        $this->viaje["medio_transporte"] = strval($_POST["medio_transporte"] ?? "");
        $this->viaje["duracion_dias"] = intval($_POST["duracion_dias"] ?? "");
        $this->viaje["costo_total"] = floatval($_POST["costo_total"] ?? "");
        $this->viaje["fecha_inicio"] = strval($_POST["fecha_inicio"] ?? "");
        $this->viaje["status"] = strval($_POST["status"] ?? "");

        if (Validators::IsEmpty($this->viaje["destino"])) {
            $errors["destino_error"] = "El destino del viaje es requerido";
        }

        if (Validators::IsEmpty($this->viaje["medio_transporte"])) {
            $errors["medio_transporte_error"] = "El medio de transporte es requerido";
        }

        if (Validators::IsEmpty($this->viaje["duracion_dias"]) && $this->viaje["duracion_dias"] <= 0) {
            $errors["duracion_dias_error"] = "La duración del viaje es requerida y debe ser un valor mayor a cero";
        }

        if (Validators::IsEmpty($this->viaje["costo_total"]) && $this->viaje["costo_total"] <= 0) {
            $errors["costo_total_error"] = "El costo total del viaje es requerido y debe ser un valor mayor a cero";
        }

        if (Validators::IsEmpty($this->viaje["fecha_inicio"])) {
            $errors["fecha_inicio_error"] = "La fecha de inicio del viaje es requerida";
        }

        if (!in_array($this->viaje["status"], ["ACT", "INA"])) {
            $errors["status_error"] = "El estado del viaje es inválido";
        }

        if (count($errors) > 0) {
            foreach ($errors as $key => $value) {
                $this->viaje[$key] = $value;
            }
            return false;
        }
        return true;
    }

    private function handlePostAction()
    {
        switch ($this->mode) {
            case "INS":
                $this->handleInsert();
                break;
            case "UPD":
                $this->handleUpdate();
                break;
            case "DEL":
                $this->handleDelete();
                break;
            default:
                throw new \Exception("Modo inválido", 1);
                break;
        }
    }

    private function handleInsert()
    {
        $result = ViajesDao::insertViaje(
            $this->viaje["destino"],
            $this->viaje["medio_transporte"],
            $this->viaje["duracion_dias"],
            $this->viaje["costo_total"],
            $this->viaje["fecha_inicio"],
            $this->viaje["status"]
        );
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Viajes_Viajes",
                "Viaje creado exitosamente"
            );
        }
    }

    private function handleUpdate()
    {
        $result = ViajesDao::updateViaje(
            $this->viaje["id_viaje"],
            $this->viaje["destino"],
            $this->viaje["medio_transporte"],
            $this->viaje["duracion_dias"],
            $this->viaje["costo_total"],
            $this->viaje["fecha_inicio"],
            $this->viaje["status"]
        );
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Viajes_Viajes",
                "Viaje actualizado exitosamente"
            );
        }
    }

    private function handleDelete()
    {
        $result = ViajesDao::deleteViaje($this->viaje["id_viaje"]);
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Viajes_Viajes",
                "Viaje eliminado exitosamente"
            );
        }
    }

    private function setViewData(): void
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["viaje_xss_token"] = $this->viaje_xss_token;
        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->viaje["id_viaje"],
            $this->viaje["destino"]
        );
        $this->viewData["showCommitBtn"] = $this->showCommitBtn;
        $this->viewData["readonly"] = $this->readonly;

        $statusKey = "status_" . strtolower($this->viaje["status"]);
        $this->viaje[$statusKey] = "selected";

        $this->viewData["viaje"] = $this->viaje;
    }
}
?>
