@extends('layouts.admin')

@section('content')
<!-- Hoverable Table rows -->
<div class="card">
    <h5 class="card-header">Data Kendaraan</h5>
    <div class="table-responsive text-nowrap">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>No Polisi</th>
            <th>Jenis Kendaraan</th>
            <th>Nama Pemilik</th>
            <th>Status Pemilik</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          <tr>
            <td>
              <i class="icon-base ri ri-suitcase-2-line icon-22px text-danger me-3"></i>
              <span>Tours Project</span>
            </td>
            <td>Albert Cook</td>
            <td>
              <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
                <li
                  data-bs-toggle="tooltip"
                  data-popup="tooltip-custom"
                  data-bs-placement="top"
                  class="avatar avatar-xs pull-up"
                  title="Lilian Fuller">
                  <img src="../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                </li>
                <li
                  data-bs-toggle="tooltip"
                  data-popup="tooltip-custom"
                  data-bs-placement="top"
                  class="avatar avatar-xs pull-up"
                  title="Sophia Wilkerson">
                  <img src="../assets/img/avatars/6.png" alt="Avatar" class="rounded-circle" />
                </li>
                <li
                  data-bs-toggle="tooltip"
                  data-popup="tooltip-custom"
                  data-bs-placement="top"
                  class="avatar avatar-xs pull-up"
                  title="Christina Parker">
                  <img src="../assets/img/avatars/7.png" alt="Avatar" class="rounded-circle" />
                </li>
              </ul>
            </td>
            <td>
              <span class="badge rounded-pill bg-label-primary me-1">Active</span>
            </td>
            <td>
              <div class="dropdown">
                <button
                  type="button"
                  class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                  data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line icon-18px"></i>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);">
                    <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                    Edit</a>
                  <a class="dropdown-item" href="javascript:void(0);">
                    <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
                    Delete</a>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
</div>
@endsection
@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS tanpa CSS tema -->
<script src="https://cdn.datatables.net/2.3.2/js/jquery.dataTables.min.js"></script>
@endpush
