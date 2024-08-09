<h1>Trabajar con Usuarios</h1>
<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <div class="flex align-center">
        <div class="col-8 row">
          <input type="hidden" name="page" value="Usuarios_Usuarios">
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
          {{ifnot OrderByUsercod}}
          <a href="index.php?page=Usuarios_Usuarios&orderBy=usercod&orderDescending=0">Id <i class="fas fa-sort"></i></a>
          {{endifnot OrderByUsercod}}
          {{if OrderUsercodDesc}}
          <a href="index.php?page=Usuarios_Usuarios&orderBy=clear&orderDescending=0">Id <i class="fas fa-sort-down"></i></a>
          {{endif OrderUsercodDesc}}
          {{if OrderUsercod}}
          <a href="index.php?page=Usuarios_Usuarios&orderBy=usercod&orderDescending=1">Id <i class="fas fa-sort-up"></i></a>
          {{endif OrderUsercod}}
        </th>
        <th class="left">
          {{ifnot OrderByUsername}}
          <a href="index.php?page=Usuarios_Usuarios&orderBy=username&orderDescending=0">Nombre <i class="fas fa-sort"></i></a>
          {{endifnot OrderByUsername}}
          {{if OrderByUsernameDesc}}
          <a href="index.php?page=Usuarios_Usuarios&orderBy=clear&orderDescending=0">Nombre <i class="fas fa-sort-down"></i></a>
          {{endif OrderByUsernameDesc}}
          {{if OrderByUsername}}
          <a href="index.php?page=Usuarios_Usuarios&orderBy=username&orderDescending=1">Nombre <i class="fas fa-sort-up"></i></a>
          {{endif OrderByUsername}}
        </th>
        <th>Correo Electrónico</th>
        <th>Tipo de Usuario</th>
        <th>Estado</th>
        <th><a href="index.php?page=Usuarios-Usuario&mode=INS">Nuevo</a></th>
      </tr>
    </thead>
    <tbody>
      {{foreach usuarios}}
      <tr>
        <td>{{usercod}}</td>
        <td>{{username}}</td>
        <td>{{useremail}}</td>
        <td>{{usertipo}}</td>
        <td>{{userest}}</td>
        <td class="center">
          <a href="index.php?page=Usuarios-Usuario&mode=UPD&usercod={{usercod}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Usuarios-Usuario&mode=DEL&usercod={{usercod}}">Eliminar</a>
        </td>
      </tr>
      {{endfor usuarios}}
    </tbody>
  </table>
  {{pagination}}
</section>
