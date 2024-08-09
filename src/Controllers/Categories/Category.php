<?php

namespace Controllers\Categories;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Categories\Categories as CategoriesDao;
use Utilities\Site;
use Utilities\Validators;

class Category extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";
    private $modeDescriptions = [
        "DSP" => "Detalle de Categoría %s",
        "INS" => "Nueva Categoría",
        "UPD" => "Editar Categoría %s",
        "DEL" => "Eliminar Categoría %s"
    ];
    private $readonly = "";
    private $showCommitBtn = true;
    private $category = [
        "CategoryID" => 0,
        "CategoryName" => "",
        "Description" => "",
        "CreatedDate" => "",
        "IsActive" => 1
    ];
    private $category_xss_token = "";

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
            Renderer::render("categories/category", $this->viewData);
        } catch (\Exception $ex) {
            Site::redirectToWithMsg(
                "index.php?page=Categories_Categories",
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
                $this->category = CategoriesDao::getCategoryById(intval($_GET["CategoryID"]));
                if (!$this->category) {
                    throw new \Exception("No se encontró la Categoría", 1);
                }
            }
        } else {
            throw new \Exception("Formulario cargado en modalidad inválida", 1);
        }
    }

    private function validateData()
    {
        $errors = [];
        $this->category_xss_token = $_POST["category_xss_token"] ?? "";
        $this->category["CategoryID"] = intval($_POST["CategoryID"] ?? "");
        $this->category["CategoryName"] = strval($_POST["CategoryName"] ?? "");
        $this->category["Description"] = strval($_POST["Description"] ?? "");
        $this->category["CreatedDate"] = strval($_POST["CreatedDate"] ?? "");
        $this->category["IsActive"] = intval($_POST["IsActive"] ?? 1);

        if (Validators::IsEmpty($this->category["CategoryName"])) {
            $errors["CategoryName_error"] = "El nombre de la categoría es requerido";
        }

        if (count($errors) > 0) {
            foreach ($errors as $key => $value) {
                $this->category[$key] = $value;
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
        $result = CategoriesDao::insertCategory(
            $this->category["CategoryName"],
            $this->category["Description"],
            $this->category["CreatedDate"],
            $this->category["IsActive"]
        );
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Categories_Categories",
                "Categoría creada exitosamente"
            );
        }
    }

    private function handleUpdate()
    {
        $result = CategoriesDao::updateCategory(
            $this->category["CategoryID"],
            $this->category["CategoryName"],
            $this->category["Description"],
            $this->category["CreatedDate"],
            $this->category["IsActive"]
        );
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Categories_Categories",
                "Categoría actualizada exitosamente"
            );
        }
    }

    private function handleDelete()
    {
        $result = CategoriesDao::deleteCategory($this->category["CategoryID"]);
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Categories_Categories",
                "Categoría eliminada exitosamente"
            );
        }
    }

    private function setViewData(): void
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["category_xss_token"] = $this->category_xss_token;
        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->category["CategoryID"]
        );
        $this->viewData["showCommitBtn"] = $this->showCommitBtn;
        $this->viewData["readonly"] = $this->readonly;

        $isActiveKey = "IsActive_" . ($this->category["IsActive"] ? "active" : "inactive");
        $this->category[$isActiveKey] = "selected";

        $this->viewData["category"] = $this->category;
    }
}
