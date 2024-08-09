<h1>Trabajar con Viajes</h1>
<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <div class="flex align-center">
        <div class="col-8 row">
          <input type="hidden" name="page" value="Viajes_Viajes">
          <label class="col-3" for="partialDestino">Destino</label>
          <input class="col-9" type="text" name="partialDestino" id="partialDestino" value="{{partialDestino}}" />
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
          {{ifnot OrderByIdViaje}}
          <a href="index.php?page=Viajes_Viajes&orderBy=id_viaje&orderDescending=0">Id <i class="fas fa-sort"></i></a>
          {{endifnot OrderByIdViaje}}
          {{if OrderIdViajeDesc}}
          <a href="index.php?page=Viajes_Viajes&orderBy=clear&orderDescending=0">Id <i class="fas fa-sort-down"></i></a>
          {{endif OrderIdViajeDesc}}
          {{if OrderIdViaje}}
          <a href="index.php?page=Viajes_Viajes&orderBy=id_viaje&orderDescending=1">Id <i class="fas fa-sort-up"></i></a>
          {{endif OrderIdViaje}}
        </th>
        <th class="left">
          {{ifnot OrderByDestino}}
          <a href="index.php?page=Viajes_Viajes&orderBy=destino&orderDescending=0">Destino <i class="fas fa-sort"></i></a>
          {{endifnot OrderByDestino}}
          {{if OrderDestinoDesc}}
          <a href="index.php?page=Viajes_Viajes&orderBy=clear&orderDescending=0">Destino <i class="fas fa-sort-down"></i></a>
          {{endif OrderDestinoDesc}}
          {{if OrderDestino}}
          <a href="index.php?page=Viajes_Viajes&orderBy=destino&orderDescending=1">Destino <i class="fas fa-sort-up"></i></a>
          {{endif OrderDestino}}
        </th>
        <th>
          {{ifnot OrderByMedioTransporte}}
          <a href="index.php?page=Viajes_Viajes&orderBy=medio_transporte&orderDescending=0">Medio de Transporte <i class="fas fa-sort"></i></a>
          {{endifnot OrderByMedioTransporte}}
          {{if OrderMedioTransporteDesc}}
          <a href="index.php?page=Viajes_Viajes&orderBy=clear&orderDescending=0">Medio de Transporte <i class="fas fa-sort-down"></i></a>
          {{endif OrderMedioTransporteDesc}}
          {{if OrderMedioTransporte}}
          <a href="index.php?page=Viajes_Viajes&orderBy=medio_transporte&orderDescending=1">Medio de Transporte <i class="fas fa-sort-up"></i></a>
          {{endif OrderMedioTransporte}}
        </th>
        <th>
          {{ifnot OrderByDuracionDias}}
          <a href="index.php?page=Viajes_Viajes&orderBy=duracion_dias&orderDescending=0">Duración (días) <i class="fas fa-sort"></i></a>
          {{endifnot OrderByDuracionDias}}
          {{if OrderDuracionDiasDesc}}
          <a href="index.php?page=Viajes_Viajes&orderBy=clear&orderDescending=0">Duración (días) <i class="fas fa-sort-down"></i></a>
          {{endif OrderDuracionDiasDesc}}
          {{if OrderDuracionDias}}
          <a href="index.php?page=Viajes_Viajes&orderBy=duracion_dias&orderDescending=1">Duración (días) <i class="fas fa-sort-up"></i></a>
          {{endif OrderDuracionDias}}
        </th>
        <th>
          {{ifnot OrderByCostoTotal}}
          <a href="index.php?page=Viajes_Viajes&orderBy=costo_total&orderDescending=0">Costo Total <i class="fas fa-sort"></i></a>
          {{endifnot OrderByCostoTotal}}
          {{if OrderCostoTotalDesc}}
          <a href="index.php?page=Viajes_Viajes&orderBy=clear&orderDescending=0">Costo Total <i class="fas fa-sort-down"></i></a>
          {{endif OrderCostoTotalDesc}}
          {{if OrderCostoTotal}}
          <a href="index.php?page=Viajes_Viajes&orderBy=costo_total&orderDescending=1">Costo Total <i class="fas fa-sort-up"></i></a>
          {{endif OrderCostoTotal}}
        </th>
        <th>
          {{ifnot OrderByFechaInicio}}
          <a href="index.php?page=Viajes_Viajes&orderBy=fecha_inicio&orderDescending=0">Fecha de Inicio <i class="fas fa-sort"></i></a>
          {{endifnot OrderByFechaInicio}}
          {{if OrderFechaInicioDesc}}
          <a href="index.php?page=Viajes_Viajes&orderBy=clear&orderDescending=0">Fecha de Inicio <i class="fas fa-sort-down"></i></a>
          {{endif OrderFechaInicioDesc}}
          {{if OrderFechaInicio}}
          <a href="index.php?page=Viajes_Viajes&orderBy=fecha_inicio&orderDescending=1">Fecha de Inicio <i class="fas fa-sort-up"></i></a>
          {{endif OrderFechaInicio}}
        </th>
        <th><a href="index.php?page=Viajes-Viaje&mode=INS">Nuevo</a></th>
      </tr>
    </thead>
    <tbody>
      {{foreach viajes}}
      <tr>
        <td>{{id_viaje}}</td>
        <td> <a class="link" href="index.php?page=Viajes-Viaje&mode=DSP&id_viaje={{id_viaje}}">{{destino}}</a></td>
        <td class="center">{{medio_transporte}}</td>
        <td class="right">{{duracion_dias}}</td>
        <td class="right">{{costo_total}}</td>
        <td class="center">{{fecha_inicio}}</td>
        <td class="center">
          <a href="index.php?page=Viajes-Viaje&mode=UPD&id_viaje={{id_viaje}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Viajes-Viaje&mode=DEL&id_viaje={{id_viaje}}">Eliminar</a>
        </td>
      </tr>
      {{endfor viajes}}
    </tbody>
  </table>
  {{pagination}}
</section>
