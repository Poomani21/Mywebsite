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
            <p><strong>Phone:</strong> {{ $user->phone }}</p>
            <p><strong>Address:</strong>
                @if($user->address)
                    {{ $user->address->address_line1 }}
                    {{ $user->address->address_line2 ? ', '.$user->address->address_line2 : '' }},
                    {{ $user->address->city }},
                    {{ $user->address->state }},
                    {{ $user->address->pincode }},
                    {{ $user->address->country }}
                @else
                    Not provided
                @endif
            </p>
            
            
            <img src="{{ $user->image ? asset('images/'.$user->image) : asset('images/default-user.png') }}"
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


<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form id="accountForm" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        <small class="text-danger error-name"></small>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" disabled>
                        <small class="text-danger error-email"></small>
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text">+91</span>
                            <input 
                                type="number"
                                name="phone"
                                value="{{ $user->phone }}"
                                class="form-control"
                                required>
                        </div>
                        <small class="text-danger error-phone"></small>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control">
                        <small class="text-danger error-password"></small>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <!-- Profile Image -->
                    <div class="mb-3 text-center">
                        <img id="profilePreview"
                             src="{{ $user->image ? asset('images/'.$user->image) : asset('images/default-user.png') }}"
                             class="rounded-circle mb-2"
                             style="width:100px;height:100px;object-fit:cover;">

                        <input type="file" name="image" id="imageInput" class="form-control">
                        <small class="text-danger error-image"></small>
                    </div>

                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="saveAccount">
                    Save
                </button>
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

            if (xhr.responseJSON && xhr.responseJSON.errors) {

                let errors = xhr.responseJSON.errors;

                if (errors.name) $('.error-name').text(errors.name[0]);
                if (errors.password) $('.error-password').text(errors.password[0]);
                if (errors.image) $('.error-image').text(errors.image[0]);
                if (errors.phone) $('.error-phone').text(errors.phone[0]);
            } else {
                
                console.log(xhr.responseText);
            }
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