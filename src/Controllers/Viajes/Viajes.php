<?php

namespace Controllers\Viajes;

use Controllers\PublicController;
use Utilities\Context;
use Utilities\Paging;
use Dao\Viajes\Viajes as DaoViajes;
use Views\Renderer;

class Viajes extends PublicController
{
  private $destino = "";
  private $medio_transporte = "";
  private $pageNumber = 1;
  private $itemsPerPage = 10;
  private $viewData = [];
  private $viajes = [];
  private $viajesCount = 0;
  private $pages = 0;

  public function run(): void
  {
    $this->getParamsFromContext();
    $this->getParams();
    $tmpViajes = DaoViajes::getViajes(
      $this->destino,
      $this->medio_transporte,
      $this->pageNumber - 1,
      $this->itemsPerPage
    );
    $this->viajes = $tmpViajes["viajes"];
    $this->viajesCount = $tmpViajes["total"];
    $this->pages = $this->viajesCount > 0 ? ceil($this->viajesCount / $this->itemsPerPage) : 1;
    if ($this->pageNumber > $this->pages) {
      $this->pageNumber = $this->pages;
    }
    $this->setParamsToContext();
    $this->setParamsToDataView();
    Renderer::render("viajes/viajes", $this->viewData);
  }

  private function getParams(): void
  {
    $this->destino = isset($_GET["destino"]) ? $_GET["destino"] : $this->destino;
    $this->medio_transporte = isset($_GET["medio_transporte"]) ? $_GET["medio_transporte"] : $this->medio_transporte;
    $this->pageNumber = isset($_GET["pageNum"]) ? intval($_GET["pageNum"]) : $this->pageNumber;
    $this->itemsPerPage = isset($_GET["itemsPerPage"]) ? intval($_GET["itemsPerPage"]) : $this->itemsPerPage;
  }

  private function getParamsFromContext(): void
  {
    $this->destino = Context::getContextByKey("viajes_destino");
    $this->medio_transporte = Context::getContextByKey("viajes_medio_transporte");
    $this->pageNumber = intval(Context::getContextByKey("viajes_page"));
    $this->itemsPerPage = intval(Context::getContextByKey("viajes_itemsPerPage"));
    if ($this->pageNumber < 1) $this->pageNumber = 1;
    if ($this->itemsPerPage < 1) $this->itemsPerPage = 10;
  }

  private function setParamsToContext(): void
  {
    Context::setContext("viajes_destino", $this->destino, true);
    Context::setContext("viajes_medio_transporte", $this->medio_transporte, true);
    Context::setContext("viajes_page", $this->pageNumber, true);
    Context::setContext("viajes_itemsPerPage", $this->itemsPerPage, true);
  }

  private function setParamsToDataView(): void
  {
    $this->viewData["destino"] = $this->destino;
    $this->viewData["medio_transporte"] = $this->medio_transporte;
    $this->viewData["pageNum"] = $this->pageNumber;
    $this->viewData["itemsPerPage"] = $this->itemsPerPage;
    $this->viewData["viajesCount"] = $this->viajesCount;
    $this->viewData["pages"] = $this->pages;
    $this->viewData["viajes"] = $this->viajes;
    $pagination = Paging::getPagination(
      $this->viajesCount,
      $this->itemsPerPage,
      $this->pageNumber,
      "index.php?page=Viajes_Viajes",
      "Viajes_Viajes"
    );
    $this->viewData["pagination"] = $pagination;
  }
}
?>

