@extends('admin.layout.app')

@section('content')


<style>

/* icon buttons */
.icon-btn {
    border: none;
    background: #f5f6fa;
    padding: 8px;
    border-radius: 8px;
    cursor: pointer;
    transition: .2s;
}

.icon-btn svg {
    display: block;
}

.edit-btn:hover {
    background: #e3f2fd;
    color: #0d6efd;
}

.delete-btn:hover {
    background: #fdeaea;
    color: #dc3545;
}

/* delete modal */
.delete-modal {
    border-radius: 12px;
    padding: 10px;
}

.delete-icon {
    background: #fdeaea;
    width: 80px;
    height: 80px;
    margin: auto;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.edit-btn {
    color: #0d6efd;
}
.delete-btn {
    color: #dc3545;
}
/* mobile */
@media (max-width: 576px) {

    .card-header {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 10px;
    }

    .icon-btn {
        padding: 10px;
    }

    .modal-dialog {
        margin: 10px;
    }

    .delete-modal {
        padding: 15px;
    }
}


</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">

            <h4 class="mb-0">My Account Info</h4>
        
            <div class="d-flex gap-2">
        
                <!-- Edit Icon -->
                <button class="icon-btn edit-btn" data-bs-toggle="modal" data-bs-target="#editModal" title="Edit">
                    <!-- pencil svg -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    fill="currentColor"
                    viewBox="0 0 16 16">
                   <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 
                            0 .708L5.207 13.793 3 14l.207-2.207L12.146.854z"/>
               </svg>
   
                </button>
        
                <!-- Delete Icon -->
                <button class="icon-btn delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete">
                    <!-- trash svg -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    fill="currentColor"
                    viewBox="0 0 16 16">
                   <path d="M5.5 5.5v7h1v-7h-1zm4 0v7h1v-7h-1z"/>
                   <path fill-rule="evenodd"
                         d="M14.5 3a1 1 0 0 1-1 1H13v9a2 
                            2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 
                            1 0 0 1-1-1V2a1 1 0 0 1 1-1h3a1 
                            1 0 0 1 1-1h2a1 1 0 0 1 1 
                            1h3a1 1 0 0 1 1 1v1z"/>
               </svg>
                </button>
        
            </div>
        </div>
        
        

        <div class="card-body">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <img src="{{ $user->image ? asset('storage/profile_images/'.$user->image) : asset('images/default-user.png') }}"
            style="width:100px;height:100px;border-radius:50%;object-fit:cover">
        </div>
    </div>

</div>

<div class="modal fade" id="deleteModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">

            <div class="modal-header border-0">
                <h5 class="modal-title text-danger">Delete Account</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">

                <!-- warning icon -->
                <div class="delete-icon mb-3">
                    <svg viewBox="0 0 24 24" width="60">
                        <path fill="#dc3545"
                            d="M12 2a10 10 0 100 
                            20 10 10 0 000-20zm1 
                            14h-2v-2h2v2zm0-4h-2V6h2v6z"/>
                    </svg>
                </div>

                <p class="mb-0">
                    Are you sure you want to delete your account?
                </p>
                <small class="text-muted">
                    This action cannot be undone.
                </small>

            </div>

            <div class="modal-footer justify-content-center border-0">
                <button class="btn btn-light" data-bs-dismiss="modal">
                    Cancel
                </button>

                <button class="btn btn-danger" id="confirmDelete">
                    Delete
                </button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Account</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="accountForm">
                    @csrf

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                        <small class="text-danger error-name"></small>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                        <small class="text-danger error-email"></small>
                    </div>

                    <div class="mb-3">
                        <label>New Password</label>
                        <input type="password" name="password" class="form-control">
                        <small class="text-danger error-password"></small>
                    </div>

                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <div class="mb-3 text-center">
                        <img id="profilePreview"
                             src="{{ $user->image ? asset('storage/profile_images/'.$user->image) : asset('images/default-user.png') }}"
                             style="width:100px;height:100px;border-radius:50%;object-fit:cover">
                    
                        <div class="mt-2">
                            <input type="file" name="image" id="imageInput" class="form-control">
                            <small class="text-danger error-image"></small>
                        </div>
                    </div>
                    

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success" id="saveAccount">Save</button>
            </div>

        </div>
    </div>
</div>



    

<script>

$('#confirmDelete').click(function () {

$.ajax({
    url: "{{ route('account.delete') }}",
    method: "POST",
    data: {
        _token: "{{ csrf_token() }}",
        _method: "DELETE"
    },
    success: function (res) {

        toastr.success("Account deleted");

        // close modal
        $('#deleteModal').modal('hide');

        setTimeout(() => {
            window.location = res.redirect;
        }, 600);
    }
});

});


    $('#deleteAccount').click(function () {
    
        if (!confirm('Are you sure to delete account?')) return;
    
        $.ajax({
            url: "{{ route('account.delete') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                _method: "DELETE"
            },
            success: function (res) {
                toastr.success("Account deleted");
                window.location = res.redirect;
            }
        });
    
    });
    </script>

<script>
$('#saveAccount').click(function () {

    // clear old validation
    $('.text-danger').text('');

    let formData = new FormData($('#accountForm')[0]);

    $.ajax({
        url: "{{ route('account.update') }}",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,

        success: function (res) {
            if (res.status) {
                
            
                $('#accountForm')[0].reset();

                // clear validation
                $('.text-danger').text('');

                // close modal (Bootstrap 4)
                let modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                modal.hide();

               
                setTimeout(() => {
                    location.reload();
                }, 400);
            }
        },

        error: function (xhr) {

            let errors = xhr.responseJSON.errors;

            if (errors.name) $('.error-name').text(errors.name[0]);
            if (errors.email) $('.error-email').text(errors.email[0]);
            if (errors.password) $('.error-password').text(errors.password[0]);
        }
    });

});

$('#editModal').on('hidden.bs.modal', function () {

// reset form fields
$('#accountForm')[0].reset();

// clear validation messages
$('.text-danger').text('');

});

$('#imageInput').on('change', function (e) {

const file = e.target.files[0];
if (!file) return;

const reader = new FileReader();

reader.onload = function (e) {
    $('#profilePreview').attr('src', e.target.result);
};

reader.readAsDataURL(file);

});



    </script>
@endsection