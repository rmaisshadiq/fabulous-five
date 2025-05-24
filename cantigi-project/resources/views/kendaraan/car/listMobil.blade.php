@php
  $vehicleChunks = $vehicles->chunk(2);
@endphp

<div class="pagination-container mt-[8rem]">
  <div class="slides-container" id="slidesContainer">

    @include('kendaraan.car.listMobil1', ['vehicleChunks' => $vehicleChunks])
    @include('kendaraan.car.listMobil2', ['vehicleChunks' => $vehicleChunks])

  </div>
</div>
