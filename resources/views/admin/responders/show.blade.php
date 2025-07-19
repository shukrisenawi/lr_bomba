@extends('layouts.app')

@section('title', 'Maklumat Responder - ' . $user->name)

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        Maklumat Responder
                    </h2>
                    <a href="{{ route('admin.responders') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali ke Senarai
                    </a>
                </div>
            </div>
        </div>

        <!-- Maklumat Peribadi -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user me-2"></i>
                            Maklumat Peribadi
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>Nama:</strong></td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>No. Telefon:</strong></td>
                                <td>{{ $user->respondent->phone_number ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Umur:</strong></td>
                                <td>{{ $user->respondent->age ?? '-' }} tahun</td>
                            </tr>
                            <tr>
                                <td><strong>Jantina:</strong></td>
                                <td>{{ $user->respondent->gender ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Etnik:</strong></td>
                                <td>{{ $user->respondent->ethnicity ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status Perkahwinan:</strong></td>
                                <td>{{ $user->respondent->marital_status ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Taraf Pendidikan:</strong></td>
                                <td>{{ $user->respondent->education_level ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-briefcase me-2"></i>
                            Maklumat Pekerjaan
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>Lokasi:</strong></td>
                                <td>{{ $user->respondent->location ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jawatan:</strong></td>
                                <td>{{ $user->respondent->position ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Gred:</strong></td>
                                <td>{{ $user->respondent->grade ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status Perkhidmatan:</strong></td>
                                <td>{{ $user->respondent->service_status ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tahun Perkhidmatan:</strong></td>
                                <td>{{ $user->respondent->years_of_service ?? '-' }} tahun</td>
                            </tr>
                            <tr>
                                <td><strong>Pendapatan Bulanan:</strong></td>
                                <td>RM {{ number_format($user->respondent->monthly_income_self ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pendapatan Pasangan:</strong></td>
                                <td>RM {{ number_format($user->respondent->monthly_income_spouse ?? 0, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tinjauan yang dijawab -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-clipboard-list me-2"></i>
                            Tinjauan yang Dijawab
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($responses->isEmpty())
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-info-circle fa-2x mb-2"></i>
                                <p>Tiada tinjauan yang dijawab</p>
                            </div>
                        @else
                            @foreach ($responses as $response)
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">
                                                <i class="fas fa-file-alt me-1"></i>
                                                Tinjauan #{{ $response['id'] }}
                                            </h6>
                                            <div>
                                                <span
                                                    class="badge {{ $response['completed'] ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $response['completed'] ? 'Selesai' : 'Dalam Proses' }}
                                                </span>
                                                <small class="text-muted ms-2">
                                                    {{ $response['created_at'] }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- Jawapan -->
                                        <div class="mb-3">
                                            <h6 class="text-primary">
                                                <i class="fas fa-question-circle me-1"></i>
                                                Jawapan
                                            </h6>
                                            @if (count($response['answers']) > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Soalan</th>
                                                                <th>Jawapan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($response['answers'] as $answer)
                                                                <tr>
                                                                    <td>Soalan #{{ $answer['question_id'] }}</td>
                                                                    <td>
                                                                        @if (is_array($answer['answer']))
                                                                            {{ implode(', ', $answer['answer']) }}
                                                                        @else
                                                                            {{ $answer['answer'] }}
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Tiada jawapan direkodkan</p>
                                            @endif
                                        </div>

                                        <!-- Skor -->
                                        @if (count($response['scores']) > 0)
                                            <div>
                                                <h6 class="text-info">
                                                    <i class="fas fa-chart-bar me-1"></i>
                                                    Skor
                                                </h6>
                                                <div class="row">
                                                    @foreach ($response['scores'] as $score)
                                                        <div class="col-md-4 mb-2">
                                                            <div class="border rounded p-2">
                                                                <small class="text-muted">{{ $score['category'] }}</small>
                                                                <h5 class="mb-0 text-primary">{{ $score['score'] }}</h5>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .table-borderless td {
            padding: 0.5rem 0;
        }

        .card-header h5 {
            font-size: 1.1rem;
        }
    </style>
@endpush
