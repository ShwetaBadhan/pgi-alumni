@extends('backend.layouts.master')

@section('content')
<div class="pcoded-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Accompanying Person Rate Settings</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Settings</li>
                        <li class="breadcrumb-item active">Accompanying Rate</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Configure Rates & Discount</h5>
                </div>
                               <div class="card-body">
                    
                    {{-- ✅ YE ERROR DISPLAY BLOCK ADD KAREIN --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Validation Failed!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('accompanying-rate.store') }}" method="POST">
                        @csrf
                        
                        <!-- Base Rate -->
                        <div class="form-group mb-3">
                            <label class="form-label">Base Accompanying Charge (₹) *</label>
                            <input type="number" step="0.01" name="base_rate" class="form-control" 
                                   value="{{ old('base_rate', $rate->base_rate ?? '') }}" required>
                            <small class="text-muted">Standard charge for non-alumni accompanying persons.</small>
                        </div>

                        <!-- Discount Toggle -->
                        <div class="form-group mb-3 p-3 bg-light rounded border">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_discount_enabled" id="discountSwitch" 
                                       {{ old('is_discount_enabled', $rate->is_discount_enabled ?? false) ? 'checked' : '' }}
                                       onchange="toggleDiscountField()">
                                <label class="form-check-label fw-bold" for="discountSwitch">
                                    Enable Discount for PGI Alumni Accompanying Persons
                                </label>
                            </div>
                        </div>

                        <!-- Discount Percentage Field -->
                        <div class="form-group mb-3" id="discountField" 
                             style="{{ old('is_discount_enabled', $rate->is_discount_enabled ?? false) ? '' : 'display: none;' }}">
                            <label class="form-label">Discount Percentage (%) *</label>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0" max="100" name="discount_percentage" class="form-control" 
                                       value="{{ old('discount_percentage', $rate->discount_percentage ?? '') }}">
                                <span class="input-group-text">%</span>
                            </div>
                            <small class="text-muted">Example: Enter 20 for 20% discount on the base rate.</small>
                        </div>

                        <!-- Active Status -->
                        <div class="form-group mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" id="statusSwitch" 
                                       {{ old('status', $rate->status ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusSwitch">Active / Enabled</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="feather icon-save"></i> Save Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleDiscountField() {
        const isChecked = document.getElementById('discountSwitch').checked;
        document.getElementById('discountField').style.display = isChecked ? 'block' : 'none';
    }
</script>
@endpush