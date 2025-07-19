@extends('layouts.app')

@section('title', 'Senarai Responder - Admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-users me-2"></i>
                            Senarai Responder
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No. Telefon</th>
                                        <th>Umur</th>
                                        <th>Jantina</th>
                                        <th>Lokasi</th>
                                        <th>Tinjauan Selesai</th>
                                        <th>Jumlah Tinjauan</th>
                                        <th>Tarikh Daftar</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($responders as $index => $responder)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $responder['name'] }}</td>
                                            <td>{{ $responder['email'] }}</td>
                                            <td>{{ $responder['phone'] }}</td>
                                            <td>{{ $responder['age'] }}</td>
                                            <td>{{ $responder['gender'] }}</td>
                                            <td>{{ $responder['location'] }}</td>
                                            <td>
                                                <span class="badge bg-success">{{ $responder['completed_surveys'] }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $responder['total_surveys'] }}</span>
                                            </td>
                                            <td>{{ $responder['created_at'] }}</td>
                                            <td>
                                                <a href="{{ route('admin.responder.show', $responder['id']) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye me-1"></i>
                                                    Lihat Jawapan
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center text-muted">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Tiada responder ditemui
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .table th {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .badge {
            font-size: 0.8rem;
        }
    </style>
@endpush
