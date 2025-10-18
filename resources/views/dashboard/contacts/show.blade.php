@extends('layouts.master')

@section('title', __('Contact Details'))

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.contacts.index') }}">{{ __('Contacts') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Details') }}</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">
                <i class="ti ti-user me-2"></i> {{ __('Contact Details') }}
            </h5>
            <a href="{{ route('dashboard.contacts.index') }}" class="btn btn-light btn-sm">
                <i class="ti ti-arrow-left"></i> {{ __('Back to Contacts') }}
            </a>
        </div>

        <div class="card-body mt-5">
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">{{ __('Name') }}</label>
                    <div class="form-control bg-light">{{ $contact->name }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">{{ __('Email') }}</label>
                    <div class="form-control bg-light">{{ $contact->email }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">{{ __('Phone') }}</label>
                    <div class="form-control bg-light">{{ $contact->phone ?? '—' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">{{ __('Company Name') }}</label>
                    <div class="form-control bg-light">{{ $contact->company_name ?? '—' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">{{ __('Date') }}</label>
                    <div class="form-control bg-light">{{ $contact->date ?? '—' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">{{ __('Time') }}</label>
                    <div class="form-control bg-light">{{ $contact->time ?? '—' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">{{ __('Created At') }}</label>
                    <div class="form-control bg-light">
                        {{ $contact->created_at->format('d M Y, h:i A') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
