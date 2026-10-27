@extends('backend.layouts.master')
@section('content')

    <div class="dashboard-main-body">

        <!-- Page Header -->
        <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <div>
                <h1 class="fw-semibold mb-4 h6 text-primary-light">General Settings</h1>
                <div>
                    <a href="{{ route('dashboard') }}"
                        class="text-secondary-light hover-text-primary hover-underline">Dashboard</a>
                    <span class="text-secondary-light">/ Settings / General</span>
                </div>
            </div>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const errorList = @json($errors->all()).map(err => `<li>${err}</li>`).join('');
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: `<ul class="text-start mb-0">${errorList}</ul>`,
                        confirmButtonText: 'Got it',
                        confirmButtonColor: '#dc3545'
                    });
                });
            </script>
        @endif

        <!-- ✅ ADD THIS SUCCESS MESSAGE BLOCK RIGHT HERE ✅ -->
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'Great!',
                        confirmButtonColor: '#198754' // Bootstrap success green
                    });
                });
            </script>
        @endif

        <!-- Form Card (Mirroring the working Course page structure) -->
        <div class="mt-24">
            <div class="card h-100">
                <div class="card-body">
                    <form action="{{ route('general-settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Information -->
                        <h6 class="fw-bold text-primary-light mb-3 mt-2">Basic Information</h6>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Site Name <span
                                            class="text-danger-600">*</span></label>
                                    <input type="text" name="site_name" class="form-control radius-8"
                                        value="{{ old('site_name', $setting->site_name ?? '') }}"
                                        placeholder="Enter Site Name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span
                                            class="text-danger-600">*</span></label>
                                    <input type="email" name="email" class="form-control radius-8"
                                        value="{{ old('email', $setting->email ?? '') }}" placeholder="Enter email address"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Phone
                                        Number</label>
                                    <input type="text" name="phone" class="form-control radius-8"
                                        value="{{ old('phone', $setting->phone ?? '') }}" placeholder="Enter phone number">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Website
                                        URL</label>
                                    <input type="url" name="website_url" class="form-control radius-8"
                                        value="{{ old('website_url', $setting->website_url ?? '') }}"
                                        placeholder="https://example.com">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Address</label>
                                    <input type="text" name="address" class="form-control radius-8"
                                        value="{{ old('address', $setting->address ?? '') }}"
                                        placeholder="Enter Your Address">
                                </div>
                            </div>
                        </div>

                        <!-- Images Section -->
                        <h6 class="fw-bold text-primary-light mb-3 mt-4 pt-3 border-top">Images & Logos</h6>
                        <div class="row gy-4">
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label fw-semibold text-secondary-light text-sm mb-8">Main Logo <span
                                        class="text-secondary-light fw-normal">(Max 2MB)</span></label>
                                <input type="file" name="logo" class="form-control radius-8" accept="image/*"
                                    onchange="previewImage(this, 'previewLogo')">
                                <div class="avatar-upload mt-16 text-center">
                                    @if ($setting && $setting->logo)
                                        <img id="previewLogo" src="{{ asset('storage/' . $setting->logo) }}"
                                            class="img-fluid rounded border p-1" style="max-height: 80px;">
                                    @else
                                        <img id="previewLogo" class="img-fluid rounded border p-1 d-none"
                                            style="max-height: 80px;">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label fw-semibold text-secondary-light text-sm mb-8">Favicon <span
                                        class="text-secondary-light fw-normal">(32x32px)</span></label>
                                <input type="file" name="favicon" class="form-control radius-8" accept="image/*"
                                    onchange="previewImage(this, 'previewFavicon')">
                                <div class="avatar-upload mt-16 text-center">
                                    @if ($setting && $setting->favicon)
                                        <img id="previewFavicon" src="{{ asset('storage/' . $setting->favicon) }}"
                                            class="img-fluid rounded border p-1" style="max-height: 40px;">
                                    @else
                                        <img id="previewFavicon" class="img-fluid rounded border p-1 d-none"
                                            style="max-height: 40px;">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label fw-semibold text-secondary-light text-sm mb-8">Backend Logo</label>
                                <input type="file" name="backend_logo" class="form-control radius-8" accept="image/*"
                                    onchange="previewImage(this, 'previewBackendLogo')">
                                <div class="avatar-upload mt-16 text-center">
                                    @if ($setting && $setting->backend_logo)
                                        <img id="previewBackendLogo" src="{{ asset('storage/' . $setting->backend_logo) }}"
                                            class="img-fluid rounded border p-1" style="max-height: 60px;">
                                    @else
                                        <img id="previewBackendLogo" class="img-fluid rounded border p-1 d-none"
                                            style="max-height: 60px;">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label fw-semibold text-secondary-light text-sm mb-8">Cover Image</label>
                                <input type="file" name="cover_image" class="form-control radius-8" accept="image/*"
                                    onchange="previewImage(this, 'previewCover')">
                                <div class="avatar-upload mt-16 text-center">
                                    @if ($setting && $setting->cover_image)
                                        <img id="previewCover" src="{{ asset('storage/' . $setting->cover_image) }}"
                                            class="img-fluid rounded border"
                                            style="max-height: 80px; width: 100%; object-fit: cover;">
                                    @else
                                        <img id="previewCover" class="img-fluid rounded border d-none"
                                            style="max-height: 80px; width: 100%; object-fit: cover;">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Social Media URLs -->
                        <h6 class="fw-bold text-primary-light mb-3 mt-4 pt-3 border-top">Social Media Links</h6>
                        <div class="row">
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8"><i
                                            class="ri-facebook-fill text-primary me-1"></i> Facebook</label>
                                    <input type="url" name="facebook" class="form-control radius-8"
                                        value="{{ old('facebook', $setting->facebook ?? '') }}"
                                        placeholder="https://facebook.com/...">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8"><i
                                            class="ri-twitter-x-fill text-dark me-1"></i> Twitter / X</label>
                                    <input type="url" name="twitter" class="form-control radius-8"
                                        value="{{ old('twitter', $setting->twitter ?? '') }}"
                                        placeholder="https://twitter.com/...">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8"><i
                                            class="ri-instagram-fill text-danger me-1"></i> Instagram</label>
                                    <input type="url" name="instagram" class="form-control radius-8"
                                        value="{{ old('instagram', $setting->instagram ?? '') }}"
                                        placeholder="https://instagram.com/...">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8"><i
                                            class="ri-linkedin-fill text-info me-1"></i> LinkedIn</label>
                                    <input type="url" name="linkedin" class="form-control radius-8"
                                        value="{{ old('linkedin', $setting->linkedin ?? '') }}"
                                        placeholder="https://linkedin.com/...">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8"><i
                                            class="ri-youtube-fill text-danger me-1"></i> YouTube</label>
                                    <input type="url" name="youtube" class="form-control radius-8"
                                        value="{{ old('youtube', $setting->youtube ?? '') }}"
                                        placeholder="https://youtube.com/...">
                                </div>
                            </div>
                        </div>
                        <!-- Certificate Template Section -->
                        <h6 class="fw-bold text-primary-light mb-3 mt-4 pt-3 border-top">Certificate Template</h6>
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary-light text-sm mb-8">
                                    Sample Certificate <span class="text-secondary-light fw-normal">(PDF or Image, Max
                                        4MB)</span>
                                </label>
                                <input type="file" name="sample_certificate" class="form-control radius-8"
                                    accept=".pdf, image/*" onchange="previewCertificate(this, 'previewCert')">
                                <small class="text-muted d-block mt-1">This template will be used as a base to generate
                                    student certificates.</small>

                                <div class="avatar-upload mt-16 text-center p-3 border rounded bg-light">
                                    @if ($setting && $setting->sample_certificate)
                                        @php
                                            $ext = strtolower(
                                                pathinfo($setting->sample_certificate, PATHINFO_EXTENSION),
                                            );
                                        @endphp

                                        @if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                                            <!-- Image Preview -->
                                            <img id="previewCert"
                                                src="{{ asset('storage/' . $setting->sample_certificate) }}"
                                                class="img-fluid rounded border p-1" style="max-height: 150px;">
                                        @else
                                            <!-- PDF Preview -->
                                            <div id="previewCert"
                                                class="d-flex flex-column align-items-center justify-content-center py-3">
                                                <i class="ri-file-pdf-fill text-danger" style="font-size: 48px;"></i>
                                                <a href="{{ asset('storage/' . $setting->sample_certificate) }}"
                                                    target="_blank" class="btn btn-sm btn-outline-primary mt-2 radius-8">
                                                    <i class="ri-eye-line me-1"></i> View Current Template
                                                </a>
                                            </div>
                                        @endif
                                    @else
                                        <!-- Empty State -->
                                        <div id="previewCert"
                                            class="d-none d-flex flex-column align-items-center justify-content-center py-3">
                                            <i class="ri-file-upload-line text-muted" style="font-size: 48px;"></i>
                                            <span class="text-muted small mt-2">No template uploaded</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Form 5 Certificate Template Section -->
                        <h6 class="fw-bold text-primary-light mb-3 mt-4 pt-3 border-top">Form 5 Certificate Template</h6>
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary-light text-sm mb-8">
                                    Form 5 Certificate <span class="text-secondary-light fw-normal">(PDF or Image, Max
                                        4MB)</span>
                                </label>
                                <input type="file" name="form5_certificate" class="form-control radius-8"
                                    accept=".pdf, image/*" onchange="previewCertificate(this, 'previewForm5Cert')">
                                <small class="text-muted d-block mt-1">Specific template used for Form 5 certificate
                                    generation.</small>

                                <div class="avatar-upload mt-16 text-center p-3 border rounded bg-light">
                                    @if ($setting && $setting->form5_certificate)
                                        @php
                                            $ext = strtolower(
                                                pathinfo($setting->form5_certificate, PATHINFO_EXTENSION),
                                            );
                                        @endphp

                                        @if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                                            <!-- Image Preview -->
                                            <img id="previewForm5Cert"
                                                src="{{ asset('storage/' . $setting->form5_certificate) }}"
                                                class="img-fluid rounded border p-1" style="max-height: 150px;">
                                        @else
                                            <!-- PDF Preview -->
                                            <div id="previewForm5Cert"
                                                class="d-flex flex-column align-items-center justify-content-center py-3">
                                                <i class="ri-file-pdf-fill text-danger" style="font-size: 48px;"></i>
                                                <a href="{{ asset('storage/' . $setting->form5_certificate) }}"
                                                    target="_blank" class="btn btn-sm btn-outline-primary mt-2 radius-8">
                                                    <i class="ri-eye-line me-1"></i> View Current Form 5 Template
                                                </a>
                                            </div>
                                        @endif
                                    @else
                                        <!-- Empty State -->
                                        <div id="previewForm5Cert"
                                            class="d-none d-flex flex-column align-items-center justify-content-center py-3">
                                            <i class="ri-file-upload-line text-muted" style="font-size: 48px;"></i>
                                            <span class="text-muted small mt-2">No Form 5 template uploaded</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Admission Form Template Section -->
<h6 class="fw-bold text-primary-light mb-3 mt-4 pt-3 border-top">Admission Form Template</h6>
<div class="row gy-4">
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary-light text-sm mb-8">
            Admission Form Template <span class="text-secondary-light fw-normal">(PDF or Image, Max 7MB)</span>
        </label>
        <input type="file" name="admission_form_template" class="form-control radius-8"
            accept=".pdf, image/*" onchange="previewCertificate(this, 'previewAdmissionForm')">
        <small class="text-muted d-block mt-1">Specific template used for admission form generation.</small>

        <div class="avatar-upload mt-16 text-center p-3 border rounded bg-light">
            @if ($setting && $setting->admission_form_template)
                @php
                    $ext = strtolower(pathinfo($setting->admission_form_template, PATHINFO_EXTENSION));
                @endphp

                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                    <!-- Image Preview -->
                    <img id="previewAdmissionForm"
                        src="{{ asset('storage/' . $setting->admission_form_template) }}"
                        class="img-fluid rounded border p-1" style="max-height: 150px;">
                @else
                    <!-- PDF Preview -->
                    <div id="previewAdmissionForm"
                        class="d-flex flex-column align-items-center justify-content-center py-3">
                        <i class="ri-file-pdf-fill text-danger" style="font-size: 48px;"></i>
                        <a href="{{ asset('storage/' . $setting->admission_form_template) }}"
                            target="_blank" class="btn btn-sm btn-outline-primary mt-2 radius-8">
                            <i class="ri-eye-line me-1"></i> View Current Admission Form
                        </a>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div id="previewAdmissionForm"
                    class="d-none d-flex flex-column align-items-center justify-content-center py-3">
                    <i class="ri-file-upload-line text-muted" style="font-size: 48px;"></i>
                    <span class="text-muted small mt-2">No admission form template uploaded</span>
                </div>
            @endif
        </div>
    </div>
</div>
                        <!-- Buttons -->
                        <div class="d-flex align-items-center justify-content-end gap-3 mt-24 pt-3 border-top">
                            <button type="reset"
                                class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8">Reset</button>
                            <button type="submit"
                                class="btn btn-primary-600 border border-primary-600 text-md px-24 py-12 radius-8">
                                <i class="ri-save-line me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Existing image preview function
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById(previewId);
                    img.src = e.target.result;
                    img.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Certificate preview function
        function previewCertificate(input, previewId) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const previewContainer = document.getElementById(previewId);

                if (file.type === 'application/pdf') {
                    previewContainer.innerHTML = `
                        <div class="d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="ri-file-pdf-fill text-danger" style="font-size: 48px;"></i>
                            <span class="text-muted small mt-2">${file.name}</span>
                        </div>
                    `;
                } else {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.innerHTML =
                            `<img src="${e.target.result}" class="img-fluid rounded border" style="max-height: 200px;">`;
                    }
                    reader.readAsDataURL(file);
                }
            }
        }

        // NEW: Specific function for Admission Form preview
        function previewAdmissionFile(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const previewContainer = document.getElementById('admissionFormPreviewContainer');

                if (file.type === 'application/pdf') {
                    previewContainer.innerHTML = `
                        <div class="d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="ri-file-pdf-fill text-danger" style="font-size: 48px;"></i>
                            <span class="text-muted small mt-2">${file.name}</span>
                            <span class="text-muted small">(PDF File)</span>
                        </div>
                    `;
                } else if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.innerHTML = `
                            <img src="${e.target.result}" class="img-fluid rounded border" style="max-height: 200px;">
                        `;
                    }
                    reader.readAsDataURL(file);
                } else {
                    alert('Please upload a valid PDF or image file');
                }
            }
        }
    </script>
@endpush
