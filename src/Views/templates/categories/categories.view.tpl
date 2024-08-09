<h1>Trabajar con Categorías</h1>
<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <div class="flex align-center">
        <div class="col-8 row">
          <input type="hidden" name="page" value="Categories_Categories">
          <label class="col-3" for="partialName">Nombre</label>
          <input class="col-9" type="text" name="partialName" id="partialName" value="{{partialName}}" />
          <label class="col-3" for="status">Estado</label>
          <select class="col-9" name="status" id="status">
              <option value="" {{status_EMP}}>Todos</option>
              <option value="1" {{status_ACTIVE}}>Activo</option>
              <option value="0" {{status_INACTIVE}}>Inactivo</option>
          </select>
        </div>
        <div class="col-4 align-end">
          <button type="submit">Filtrar</button>
        </div>
      </div>
    </form>
  </div>
</section>
<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>
          {{ifnot OrderByCategoryId}}
          <a href="index.php?page=Categories_Categories&orderBy=CategoryID&orderDescending=0">Id <i class="fas fa-sort"></i></a>
          {{endifnot OrderByCategoryId}}
          {{if OrderCategoryIdDesc}}
          <a href="index.php?page=Categories_Categories&orderBy=clear&orderDescending=0">Id <i class="fas fa-sort-down"></i></a>
          {{endif OrderCategoryIdDesc}}
          {{if OrderCategoryId}}
          <a href="index.php?page=Categories_Categories&orderBy=CategoryID&orderDescending=1">Id <i class="fas fa-sort-up"></i></a>
          {{endif OrderCategoryId}}
        </th>
        <th class="left">
          {{ifnot OrderByCategoryName}}
          <a href="index.php?page=Categories_Categories&orderBy=CategoryName&orderDescending=0">Nombre <i class="fas fa-sort"></i></a>
          {{endifnot OrderByCategoryName}}
          {{if OrderCategoryNameDesc}}
          <a href="index.php?page=Categories_Categories&orderBy=clear&orderDescending=0">Nombre <i class="fas fa-sort-down"></i></a>
          {{endif OrderCategoryNameDesc}}
          {{if OrderCategoryName}}
          <a href="index.php?page=Categories_Categories&orderBy=CategoryName&orderDescending=1">Nombre <i class="fas fa-sort-up"></i></a>
          {{endif OrderCategoryName}}
        </th>
        <th>
          {{ifnot OrderByCreatedDate}}
          <a href="index.php?page=Categories_Categories&orderBy=CreatedDate&orderDescending=0">Fecha de Creación <i class="fas fa-sort"></i></a>
          {{endifnot OrderByCreatedDate}}
          {{if OrderCreatedDateDesc}}
          <a href="index.php?page=Categories_Categories&orderBy=clear&orderDescending=0">Fecha de Creación <i class="fas fa-sort-down"></i></a>
          {{endif OrderCreatedDateDesc}}
          {{if OrderCreatedDate}}
          <a href="index.php?page=Categories_Categories&orderBy=CreatedDate&orderDescending=1">Fecha de Creación <i class="fas fa-sort-up"></i></a>
          {{endif OrderCreatedDate}}
        </th>
        <th>Estado</th>
        <th><a href="index.php?page=Categories-Category&mode=INS">Nuevo</a></th>
      </tr>
    </thead>
    <tbody>
      {{foreach categories}}
      <tr>
        <td>{{CategoryID}}</td>
        <td> <a class="link" href="index.php?page=Categories-Category&mode=DSP&CategoryID={{CategoryID}}">{{CategoryName}}</a>
        </td>
        <td class="right">
          {{CreatedDate}}
        </td>
        <td class="center">{{IsActive}}</td>
        <td class="center">
          <a href="index.php?page=Categories-Category&mode=UPD&CategoryID={{CategoryID}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Categories-Category&mode=DEL&CategoryID={{CategoryID}}">Eliminar</a>
        </td>
      </tr>
      {{endfor categories}}
    </tbody>
  </table>
  {{pagination}}
</section>
