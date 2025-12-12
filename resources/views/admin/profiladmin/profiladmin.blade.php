@extends('admin.layout.sidebaradmin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/profiladmin.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">

<style>
/* Modal Crop */
#cropModal .modal-dialog {
    max-width: 900px !important;
    width: auto;
    margin: 1.5rem auto;
}
#cropModal .modal-body {
    height: 65vh !important;
    padding: 0;
    display: flex;
    flex-direction: column;
}
/* Toolbar */
.crop-toolbar {
    padding: .75rem 1rem;
    display: flex;
    gap: .5rem;
    align-items: center;
    background: #f8f9fa;
}
/* Area crop */
.crop-area {
    flex: 1;
    width: 100%;
    background: #e9ecef;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
}
#image-preview {
    max-width: 100%;
    max-height: 100%;
    display: block;
}
/* Aspect ratio btn */
.aspect-btn.active {
    border-width: 2px;
}
#cropModal .modal-footer {
    background: #f8f9fa;
}
.btn-small {
    padding: .35rem .6rem;
    font-size: .875rem;
}
/* Preview crop di form */
.cropped-preview {
    display: block;
    margin: 10px auto 0 auto;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #dee2e6;
}
</style>
@endpush

@section('content')
<div class="main-content container">
    <h1 class="mt-4">PROFIL</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row mt-4">
        <!-- FOTO PROFIL -->
        <div class="col-md-4">
            <div class="profile-card text-center p-4 shadow">
                <img src="{{ $admin->photo ? asset('uploads/admin/'.$admin->photo) : asset('img/default-user.png') }}"
                     class="img-fluid rounded-circle mb-3 profile-img"
                     style="width:180px; height:180px; object-fit:cover;">
                <h3>{{ $admin->username }}</h3>
                <p>{{ $admin->email }}</p>
                <p class="text-muted">{{ ucfirst($admin->role) }}</p>

                <button type="button" class="btn btn-primary btn-block mt-3"
                        data-bs-toggle="modal" data-bs-target="#editProfilModal">
                    <i class="fas fa-edit"></i> Edit Profil
                </button>

                @if($admin->role == 'superadmin')
                    <button type="button" class="btn btn-success btn-block mt-3"
                            data-bs-toggle="modal" data-bs-target="#addAdminModal">
                        <i class="fas fa-user-plus"></i> Tambah Admin
                    </button>

                    <a href="{{ route('admin.list') }}" class="btn btn-dark btn-block mt-2">
                        <i class="fas fa-users"></i> List Admin
                    </a>
                @endif
            </div>
        </div>

        <!-- DETAIL PROFIL -->
        <div class="col-md-8">
            <div class="card profile-details shadow">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $admin->username }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label class="col-sm-3 col-form-label font-weight-bold">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $admin->email }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label class="col-sm-3 col-form-label font-weight-bold">Role</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ ucfirst($admin->role) }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT PROFIL -->
<div class="modal fade" id="editProfilModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="ajax-form" action="{{ route('profiladmin.update') }}" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="modal-header">
                    <h5>Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="{{ $admin->username }}">

                    <label class="mt-3">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $admin->email }}">

                    <label class="mt-3">Foto Profil</label>
                    <input type="file" name="photo" class="form-control photo-input" accept="image/*">
                    <img src="{{ $admin->photo ? asset('uploads/admin/'.$admin->photo) : asset('img/default-user.png') }}" class="cropped-preview" id="croppedPreview">

                    <label class="mt-3">Password Baru (Opsional)</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control edit-password">
                        <button type="button" class="btn btn-outline-secondary toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH ADMIN (tidak berubah) -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="ajax-form" action="{{ route('profiladmin.addAdmin') }}" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="modal-header">
                    <h5>Tambah Admin Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>

                    <label class="mt-3">Email</label>
                    <input type="email" name="email" class="form-control" required>

                    <label class="mt-3">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control add-password" required>
                        <button type="button" class="btn btn-outline-secondary toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Tambah Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL CROP FOTO -->
<div class="modal fade" id="cropModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="crop-toolbar">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-small aspect-btn active" data-ratio="1">1 : 1</button>
                        <button type="button" class="btn btn-outline-primary btn-small aspect-btn" data-ratio="0.8">4 : 5</button>
                        <button type="button" class="btn btn-outline-primary btn-small aspect-btn" data-ratio="1.333333">3 : 4</button>
                        <button type="button" class="btn btn-outline-primary btn-small aspect-btn" data-ratio="0.666666">2 : 3</button>
                    </div>

                    <div class="ms-3 d-flex align-items-center" style="gap:.35rem;">
                        <button type="button" id="zoomIn" class="btn btn-secondary btn-small"><i class="fas fa-search-plus"></i></button>
                        <button type="button" id="zoomOut" class="btn btn-secondary btn-small"><i class="fas fa-search-minus"></i></button>
                        <button type="button" id="rotateLeft" class="btn btn-secondary btn-small"><i class="fas fa-undo"></i></button>
                        <button type="button" id="rotateRight" class="btn btn-secondary btn-small"><i class="fas fa-redo"></i></button>
                    </div>

                    <div class="ms-auto text-muted small">Atur area crop lalu simpan.</div>
                </div>

                <div class="crop-area">
                    <img id="image-preview" alt="Preview">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="cropButton" class="btn btn-primary">Crop & Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function(){
    // Toggle Password
    $('.toggle-password').click(function(){
        let input = $(this).siblings('input[type="password"],input[type="text"]');
        let icon = $(this).find('i');
        input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
        icon.toggleClass('fa-eye fa-eye-slash');
    });

    // Cropper
    let cropper = null;
    let currentRatio = 1;
    let targetInput = null;

    function approxEqual(a,b,eps=0.001){ return Math.abs(a-b)<eps; }

    $('.photo-input').change(function(e){
        const file = e.target.files?.[0]; if(!file) return;
        targetInput = e.target;
        const reader = new FileReader();
        reader.onload = function(ev){
            $('#image-preview').attr('src', ev.target.result);
            new bootstrap.Modal(document.getElementById('cropModal')).show();
        };
        reader.readAsDataURL(file);
    });

    $('#cropModal').on('shown.bs.modal', function () {
        const image = document.getElementById('image-preview');
        if(cropper){ cropper.destroy(); cropper=null; }

        image.onload = function(){
            cropper = new Cropper(image,{
                viewMode: 1,
                autoCropArea: 1,
                background: false,
                responsive: true,
                aspectRatio: currentRatio
            });
        };
        if(image.complete && image.naturalHeight !== 0){
            image.onload();
        }
    });

    $('.aspect-btn').click(function(){
        currentRatio = parseFloat($(this).data('ratio'));
        if(cropper) cropper.setAspectRatio(currentRatio);
        $('.aspect-btn').removeClass('active'); $(this).addClass('active');
    });

    $('#zoomIn').click(()=>cropper?.zoom(0.1));
    $('#zoomOut').click(()=>cropper?.zoom(-0.1));
    $('#rotateLeft').click(()=>cropper?.rotate(-90));
    $('#rotateRight').click(()=>cropper?.rotate(90));

    // Crop & preview langsung di form
    $('#cropButton').click(function(){
        if(!cropper || !targetInput) return;
        let W=800,H=800;
        if(approxEqual(currentRatio,1)){ W=H=800; }
        else if(approxEqual(currentRatio,0.8)){ W=1000; H=1250; }
        else if(approxEqual(currentRatio,1.333333)){ W=900; H=1200; }
        else if(approxEqual(currentRatio,0.666666)){ W=1200; H=1800; }
        else { W=1000; H=Math.round(W/currentRatio); }

        cropper.getCroppedCanvas({width:W,height:H,imageSmoothingEnabled:true,imageSmoothingQuality:"high"})
        .toBlob(function(blob){
            const file = new File([blob],"cropped_"+Date.now()+".png",{type:blob.type});
            const dt = new DataTransfer(); dt.items.add(file);
            targetInput.files = dt.files;

            // Preview langsung di form
            const reader = new FileReader();
            reader.onload = function(e){
                $('#croppedPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);

            bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            Swal.fire({ icon:"success", title:"Berhasil", text:"Foto berhasil dipotong.", timer:1200, showConfirmButton:false });
        },"image/png",0.92);
    });

    // AJAX Generic
    $('.ajax-form').submit(function(e){
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        $(form).find('.photo-input').each(function(){
            if(this.files.length > 0){
                formData.set(this.name, this.files[0]);
            }
        });

        $.ajax({
            url: $(form).attr('action'),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                const modal = bootstrap.Modal.getInstance($(form).closest('.modal')[0]);
                modal?.hide();
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');

                Swal.fire({ icon:'success', title:'Berhasil', text:res.message || 'Data berhasil disimpan!', timer:1500, showConfirmButton:false });

                if($(form).attr('action').includes('update')){
                    $('input[readonly][value="{{ $admin->username }}"]').val(formData.get('username'));
                    $('input[readonly][value="{{ $admin->email }}"]').val(formData.get('email'));
                    $('.profile-card h3').text(formData.get('username'));
                    $('.profile-card p').first().text(formData.get('email'));

                    let file = $(form).find('.photo-input')[0]?.files[0];
                    if(file){
                        let reader = new FileReader();
                        reader.onload = function(e){ $('.profile-card img').attr('src', e.target.result); }
                        reader.readAsDataURL(file);
                    }
                }else{
                    form.reset();
                }
            },
            error: function(xhr){
                let err = xhr.responseJSON?.errors;
                let msg = err ? Object.values(err).flat().join('\n') : 'Terjadi kesalahan';
                Swal.fire('Gagal!', msg, 'error');
            }
        });
    });
});
</script>
@endpush
