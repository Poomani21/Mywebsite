@extends('admin.layout.app')

@section('content')
<style>
/* ===========================
   Product Grid
=========================== */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px 0;
}

/* Product Card */
.product-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.product-card img {
    width: 100%;
    height: 180px;
    object-fit: contain;
    background: #f8f8f8;
    transition: transform 0.2s ease;
}

.product-card:hover img {
    transform: scale(1.05);
}

/* Product Info */
.product-info {
    padding: 15px;
    flex-grow: 1;
}

.product-info h5 {
    font-size: 16px;
    font-weight: 600;
    margin: 0 0 8px 0;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}

.product-info p {
    color: #555;
    margin: 0 0 12px 0;
    font-size: 14px;
}

.product-price {
    font-weight: 700;
    color: #ff9900;
    margin-bottom: 12px;
}

/* Actions */
.product-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-bottom: 12px;
}

.product-actions .btn {
    border-radius: 30px;
    font-size: 14px;
    padding: 6px 12px;
}

/* ===========================
   Modal Styles
=========================== */
.modal-overlay {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
}

.modal-content {
    background: #fff;
    border-radius: 12px;
    width: 95%;
    max-width: 500px;
    margin: 5% auto;
    padding: 25px;
    text-align: left;
    position: relative;
    animation: fadeIn 0.3s ease;
}

.modal-close {
    position: absolute;
    top: 12px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
}

.modal-content h4 {
    margin-bottom: 15px;
    font-weight: 600;
    text-align: center;
}

.modal-content form .form-group {
    margin-bottom: 15px;
}

.modal-content form label {
    font-weight: 500;
}

.modal-content form input,
.modal-content form textarea {
    width: 100%;
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.modal-content form textarea {
    resize: vertical;
}


/* Buttons in modal footer */
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.modal-footer .btn {
    border-radius: 30px;
    padding: 8px 16px;
}

/* Animation */
@keyframes fadeIn {
    0% {opacity: 0; transform: translateY(-20px);}
    100% {opacity: 1; transform: translateY(0);}
}

/* Responsive */
@media(max-width:768px){
    .product-card img { height: 150px; }
}
/* ===== Header Layout ===== */
.products-header {
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 14px;
    margin-bottom: 14px;
}

/* Title */
.page-title {
    margin: 0;
    font-size: 22px;
    font-weight: 600;
    line-height: 36px;   /* match button height */
}

/* Filter Bar */
.filter-bar {
    display: flex;
    align-items: center;   /* vertical align */
    gap: 8px;
}

/* SAME HEIGHT FOR ALL CONTROLS */
.filter-bar input,
.btn-filter,
.btn-reset,
.btn-add {
    height: 36px;
    box-sizing: border-box;
}

/* Input */
.filter-bar input {
    padding: 6px 10px;
    border: 1px solid #dcdcdc;
    border-radius: 4px;
    width: 260px;
    font-size: 14px;
}

/* Search */
.btn-filter {
    padding: 0 14px;
    background: #2d6cdf;
    border: none;
    color: #fff;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
}

/* Reset */
.btn-reset {
    padding: 0 12px;
    border: 1px solid #ccc;
    background: #f3f3f3;
    border-radius: 4px;
    font-size: 14px;
    text-decoration: none;
    color: #333;
    display: flex;
    align-items: center;
}

/* Add */
.btn-add {
    padding: 0 16px;
    background: #2d6cdf;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
}

/* Hover */
.btn-filter:hover,
.btn-add:hover {
    background: #1f57c3;
}


/* ===== Pagination Top ===== */
.pagination-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 12px 0 6px;
}

.result-text {
    font-size: 14px;
    color: #666;
}

.pagination-box {
    display: flex;
}

/* ===== Pagination Bottom ===== */
.pagination-bottom {
    display: flex;
    justify-content: center;
    margin: 20px 0;
}

/* ===== Mobile ===== */
@media (max-width: 768px) {
    .products-header {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .filter-bar {
        flex-wrap: wrap;
    }

    .filter-bar input {
        width: 100%;
    }

    .btn-add {
        width: 100%;
    }
    .pagination-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-direction: row;   /* keep same line */
        gap: 8px;
        width: 100%;
    }

    .result-text {
        font-size: 13px;
        white-space: nowrap;
    }

    .pagination-box {
        display: flex;
    }

    .pagination-box .pagination {
        margin: 0;
    }
}

.pagination-box p.small.text-muted {
            display: none;
        }
        .empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state img {
    width: 120px;
    opacity: 0.8;
    margin-bottom: 20px;
}

.empty-state h4 {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 6px;
    color: #2c2c2c;
}

.empty-state p {
    color: #6c757d;
    margin-bottom: 18px;
    font-size: 14px;
}

.btn-reset-filter {
    border: 1px solid #2d6cdf;
    color: #2d6cdf;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    display: inline-block;
}

.btn-reset-filter:hover {
    background: #2d6cdf;
    color: #fff;
}

</style>
<script>
  const deleteRouteTemplate = "{{ route('product.destroy', ':id') }}";
</script>

<div class="container">
    <div class="products-header">

        <!-- LEFT: Title -->
        <h4 class="page-title">Products</h4>
    
        <!-- CENTER: Search + Reset -->
        <form method="GET" action="{{ route('product.index') }}" class="filter-bar">
    
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search by product name">
    
            <button type="submit" class="btn-filter">Search</button>
    
            @if(request()->filled('search'))
                <a href="{{ route('product.index') }}" class="btn-reset">Reset</a>
            @endif
    
        </form>
    
        <!-- RIGHT: Add -->
        <button class="btn-add" id="addProductBtn">
            Add Product
        </button>
    
    </div>
    
    
    @if($products->hasPages())
<div class="pagination-top">
    <span class="result-text">
        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
    </span>

    <div class="pagination-box">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endif


    <div class="products-grid">
        @if($products->count() > 0)
    
            @foreach($products as $product)
            <div class="product-card" data-id="{{ $product->_id }}"
                 data-name="{{ $product->name }}"
                 data-price="{{ $product->price }}"
                 data-image="{{ asset('images/' . $product->image) }}"
                 data-description="{{ $product->description }}">
                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                <div class="product-info">
                    <h5>{{ $product->name }}</h5>
                    <p>{{ Str::limit($product->description, 50) }}</p>
                    <div class="product-price">₹{{ $product->price }}</div>
                </div>
                <div class="product-actions">
                    <button class="btn btn-warning btn-sm editProductBtn">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-danger btn-sm deleteProductBtn">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
            @endforeach
    
        @else
    
        @if($products->count() == 0)
        <div class="empty-state">
        
            <img src="{{ asset('images/nodata.png') }}" alt="No products">
        
            @if(request()->filled('search'))
                <h4>No products found</h4>
                <p>No matching products for your search.</p>
        
                <a href="{{ route('product.index') }}" class="btn-reset-filter">
                    Reset Filters
                </a>
            @else
                <h4>No products available</h4>
                <p>There are no products added yet.</p>
            @endif
        
        </div>
        @endif
        
    
        @endif
    </div>
    
  


</div>

@if($products->hasPages())
<div class="pagination-top">
    <span class="result-text">
        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
    </span>

    <div class="pagination-box">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endif


<!-- Modal -->
<!-- Modal -->
<div class="modal-overlay" id="productModal">
  <div class="modal-content">
      <span class="modal-close">&times;</span>
      <h4 id="modalTitle">Add New Product</h4>

      <form id="productForm" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="_method" id="formMethod" value="POST">
          <input type="hidden" name="product_id" id="productId" value="">

          <div class="form-group">
              <label>Product Name <small class="text-danger">*</small></label>
              <input type="text" name="name" id="productName" required>
          </div>

          <div class="form-group">
              <label>Product Price <small class="text-danger">*</small></label>
              <input type="number" name="price" id="productPrice" required>
          </div>

          <div class="form-group">
              <label>Product Description</label>
              <textarea name="description" id="productDescription" rows="3"></textarea>
          </div>

          <div class="form-group">
              <label>Product Image</label>
              <input type="file" name="image" id="productImage" accept="image/*">
              <div id="imagePreview" style="margin-top:10px;">
                  <img id="previewImg" src="" alt="Image Preview" style="max-width: 100%; max-height: 200px; display:none; border-radius:8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
              </div>
          </div>

          <div class="modal-footer">
              <button type="button" class="btn btn-secondary modal-cancel">Cancel</button>
              <button type="submit" class="btn btn-primary">Save</button>
          </div>
      </form>
  </div>
</div>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this product?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
      </div>
    </div>
  </div>
</div>


@endsection


<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
$(document).ready(function(){

const modal = $('#productModal');
const form = $('#productForm');
const previewImg = $('#previewImg');

// Image Preview
$('#productImage').change(function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            previewImg.attr('src', e.target.result).show();
        }
        reader.readAsDataURL(file);
    } else {
        previewImg.hide();
    }
});

// Open Add Product Modal
$('#addProductBtn').click(function(){
    $('#modalTitle').text('Add New Product');
    $('#formMethod').val('POST');
    form.attr('action', "{{ route('product.store') }}");
    $('#productId').val('');
    $('#productName').val('');
    $('#productPrice').val('');
    $('#productDescription').val('');
    $('#productImage').val('');
    previewImg.hide();
    modal.fadeIn();
});

// Open Edit Product Modal
$('.editProductBtn').click(function(e){
    e.stopPropagation();
    const card = $(this).closest('.product-card');

    $('#modalTitle').text('Edit Product');
    $('#formMethod').val('PUT');
    form.attr('action', "{{ url('product') }}/" + card.data('id'));
    $('#productId').val(card.data('id'));
    $('#productName').val(card.data('name'));
    $('#productPrice').val(card.data('price'));
    $('#productDescription').val(card.data('description'));
    $('#productImage').val('');
    
    // Show current product image
    previewImg.attr('src', card.data('image')).show();
    modal.fadeIn();
});


let deleteProductId = null;

// When delete button is clicked
$(document).on('click', '.deleteProductBtn', function(e){
    e.stopPropagation();

    const card = $(this).closest('.product-card');
    deleteProductId = card.data('id');

    const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    modal.show();
});

// When confirm delete is clicked
$('#confirmDeleteBtn').on('click', function(){
    if(!deleteProductId) return;

    let deleteUrl = deleteRouteTemplate.replace(':id', deleteProductId);

    const form = $('<form>', {
        method: 'POST',
        action: deleteUrl
    });

    form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
    form.append('<input type="hidden" name="_method" value="DELETE">');

    $('body').append(form);
    form.submit();
});


// Close Modal
$('.modal-close').click(function(){
    modal.fadeOut();
});

// Click outside modal closes
modal.click(function(e){
    if(e.target.id === 'productModal'){
        modal.fadeOut();
    }
});


// Close modal on Cancel button
$('.modal-cancel').on('click', function(){
    $('#productModal').fadeOut();
});

// Close modal when clicking on X
$('.modal-close').on('click', function(){
    $('#productModal').fadeOut();
});

// Close modal when clicking outside the modal content
$('#productModal').on('click', function(e){
    if ($(e.target).is('#productModal')) {
        $('#productModal').fadeOut();
    }
});

});

</script>

