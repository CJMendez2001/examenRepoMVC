<h1>Trabajar con Funciones</h1>
<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <div class="flex align-center">
        <div class="col-8 row">
          <input type="hidden" name="page" value="Funciones_Funciones">
          <label class="col-3" for="partialName">Nombre</label>
          <input class="col-9" type="text" name="partialName" id="partialName" value="{{partialName}}" />
          <label class="col-3" for="status">Estado</label>
          <select class="col-9" name="status" id="status">
              <option value="EMP" {{status_EMP}}>Todos</option>
              <option value="ACT" {{status_ACT}}>Activo</option>
              <option value="INA" {{status_INA}}>Inactivo</option>
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
          {{ifnot OrderByFncod}}
          <a href="index.php?page=Funciones_Funciones&orderBy=fncod&orderDescending=0">Id <i class="fas fa-sort"></i></a>
          {{endifnot OrderByFncod}}
          {{if OrderFncodDesc}}
          <a href="index.php?page=Funciones_Funciones&orderBy=clear&orderDescending=0">Id <i class="fas fa-sort-down"></i></a>
          {{endif OrderFncodDesc}}
          {{if OrderFncod}}
          <a href="index.php?page=Funciones_Funciones&orderBy=fncod&orderDescending=1">Id <i class="fas fa-sort-up"></i></a>
          {{endif OrderFncod}}
        </th>
        <th class="left">
          {{ifnot OrderByFndsc}}
          <a href="index.php?page=Funciones_Funciones&orderBy=fndsc&orderDescending=0">Descripción <i class="fas fa-sort"></i></a>
          {{endifnot OrderByFndsc}}
          {{if OrderByFndscDesc}}
          <a href="index.php?page=Funciones_Funciones&orderBy=clear&orderDescending=0">Descripción <i class="fas fa-sort-down"></i></a>
          {{endif OrderByFndscDesc}}
          {{if OrderByFndsc}}
          <a href="index.php?page=Funciones_Funciones&orderBy=fndsc&orderDescending=1">Descripción <i class="fas fa-sort-up"></i></a>
          {{endif OrderByFndsc}}
        </th>
        <th>Estado</th>
        <th>Tipo</th>
        <th><a href="index.php?page=Funciones_Funcion&mode=INS">Nueva</a></th>
      </tr>
    </thead>
    <tbody>
      {{foreach funciones}}
      <tr>
        <td>{{fncod}}</td>
        <td>{{fndsc}}</td>
        <td>{{fnest}}</td>
        <td>{{fntyp}}</td>
        <td>
          <a href="index.php?page=Funciones_Funcion&mode=UPD&fncod={{fncod}}">Editar</a>
          <a href="index.php?page=Funciones_Funcion&mode=DEL&fncod={{fncod}}">Eliminar</a>
        </td>
      </tr>
      {{endfor funciones}}
    </tbody>
  </table>
  <div>
    {{pagination}}
  </div>
</section>
