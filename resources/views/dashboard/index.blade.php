@extends('layouts.master')

@section('title', 'Dashboard')

@section('css')
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item active">{{ __('Dashboard') }}</li> --}}
@endsection

@section('content')
    <div class="row g-6">
        <!-- View sales -->
        <div class="col-xl-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-7">
                        <div class="card-body text-nowrap">
                            <h5 class="card-title mb-0">Hi {{ Auth::user()->name }}! 🎉</h5>
                            <p class="mb-2">Here what's happening in <br> your account today!</p>
                            <a href="javascript:;" class="btn btn-primary">View Profile</a>
                        </div>
                    </div>
                    <div class="col-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/illustrations/card-advance-sale.png') }}" height="140"
                                alt="view profile" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- View sales -->
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Total Contacts</h5>
                    <h3 class="text-primary">{{ $totalContacts }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Today's Submissions</h5>
                    <h3 class="text-success">{{ $todayContacts }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <h5>This Month</h5>
                    <h3 class="text-warning">{{ $thisMonthContacts }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Contacts in the Last 7 Days</h5>
                </div>
                <div class="card-body">
                    <canvas id="contactsChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('contactsChart').getContext('2d');
        const contactsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($contactsPerDay->pluck('date')) !!},
                datasets: [{
                    label: 'Contacts',
                    data: {!! json_encode($contactsPerDay->pluck('total')) !!},
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.2)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
