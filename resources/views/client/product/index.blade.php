@extends('layouts.client.sidenav')
@section('sidenav')
<style>
#display-image-add, .display-image{
  width: 100x;
  height: 200px;
  border: 1px solid #b0b0b0;
  background-position: center;
  background-size: cover;
  margin-bottom: 20px;
}

.report-list .report-image{
    display: flex;
    justify-items: center;
    align-items: center;
    height: 100%;
}
.report-list .report-image img{
    position: absolute;
    top: 0% !important;
    height: 100%;
    width: 100%;
    background: #d9e4eb !important;
}
</style>

<section class="report-box">
    <article class="report-title">
       Product List
    </article>
    <div class="search-box">
        @can('user-create',$products)
        <button data-bs-toggle="modal" data-bs-target="#add" class="modal-button-success" type="button">Add Product</button>
        @endcan
        <form class="w-full" action="{{ route('client.product.index') }}">
            <i class="fa fa-search"></i>
            <input placeholder="Search"  type="search" name="search">
            <fieldset style="margin: 0px 10px;">
                <div>
                    <label id="labelMin" for="">{{ $min }}</label>
                    <input name="min" type="range" min="{{ $min }}" value="{{ $min }}" max="{{ $max }}"
                    oninput="document.getElementById('labelMin').innerHTML = this.value;">
                </div>
                <div>
                    <label id="labelMax">{{ $max }}</label>
                    <input name="max"  min="{{ $min }}" type="range" max="{{ $max }}" value="{{ $max }}"
                    oninput="document.getElementById('labelMax').innerHTML = this.value;">
                </div>
            </fieldset>
            <button type="submit">Search</button>
        </form>
    </div>
    @if ($message = Session::get('success'))
    <div class="alert-alert-message alert-success">
        {{ $message }}
    </div>
    @elseif ($message = Session::get('danger'))
    <div class="alert-alert-message alert-danger">
        {{ $message }}
    </div>
    @elseif ($message = Session::get('info'))
    <div class="alert-alert-message alert-info">
        {{ $message }}
    </div>
    @endif

   @error('image')
   <div class="alert-alert-message alert-danger">
        {{ $message }}
    </div>
   @enderror
    <article class="report-list">
        <div class="report-body" style="display: flex; color:white;">
            <p style="flex:2; text-align:center;"></p>
            <p style="flex:7; text-align:center;">Product</p>
            <p style="flex:7; text-align:center;">Category</p>
            <p style="flex:7; text-align:center;">Price</p>
            <p style="flex:2; text-align:center;">Options</p>
        </div>
    </article>

    @foreach ($products as $product)
        @can('view',$product)
        <article class="report-list">
            <div class="report-image" >
                @if ($product->image!=null)
                <img src="{{ asset('storage/product/'.$product->image->name) }}" alt="">
                @else
                <img src="{{ asset('storage/test.jpg') }}" alt="">
                @endif
            </div>
            <div class="report-head">
                <p>{{ Str::ucfirst($product->name) }}</p>
            </div>
            <div class="report-head">
                <p>{{ Str::ucfirst($product->category->name) }}</p>
            </div>
            <div class="report-head">
                <p>{{number_format($product->price,2) }}</p>
            </div>
            <div class="report-body">
                <a data-bs-toggle="modal" data-bs-target="#edit-{{ $product->id }}" href="#"><i style="font-size: 1.1rem;" class="fa fa-pencil"></i></a>
                <a data-bs-toggle="modal" data-bs-target="#delete-{{ $product->id }}" href="#"><i style="font-size: 1.1rem;" class="fa fa-trash"></i></a>

                 <!--modal edit-->
                 <div class="modal fade" id="edit-{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <form method="post" enctype="multipart/form-data" action="{{ route('client.product.update') }}">
                        @csrf
                        {{ method_field('patch') }}
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                        <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="display: flex; flex-direction:column; gap:5;">
                            <div style="display: none;" class="display-image" id="display-image-{{ $product->id }}"></div>
                            @if ($product->image!=null)
                            <img style="height:200px;" id="display-image-{{ $product->id }}" src="{{ asset('storage/product/'.$product->image->name) }}" alt="">
                            <input type="hidden" name="imageDelete" value="{{ $product->image->name }}" >
                            @else
                            <img style="height:200px;" id="display-image-{{ $product->id }}" src="{{ asset('storage/test.jpg') }}" alt="">
                            @endif
                            <label class="fa fa-label" for="">Edit Image</label>
                            <input class="display-input" name="image" value="{{ $product->category->name }}" class="fa fa-control" type="file">
                            <label class="fa fa-label" for="">Edit Product</label>
                            <input required value="{{ $product->name }}" name="product" class="fa fa-control" type="text">
                            <label class="fa fa-label" for="">Edit Categories</label>
                            <select required name="category" class="fa fa-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <label class="fa fa-label" for="">Enter Price</label>
                            <input required value="{{ $product->price }}" name="price" class="fa fa-control" type="number">
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" value="{{ $product->id }}" name="id">
                        {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i></button>
                        </div>
                    </div>
                  </form>
                </div>
                </div>
                    <!--end edit-->


                <!--modal delete-->
                <div class="modal fade" id="delete-{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <form method="POST" action="{{ route('client.product.destroy',$product->id) }}">
                        @csrf
                        {{ method_field('delete') }}
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="exampleModalLabel">Are you sure want to Delete?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                           {{ $product->name }}
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                    </div>
                     </form>
                </div>
                <!--end modal-->

            </div>
        </article>
        @endcan
    @endforeach
    {{ $products->withQueryString()->links('pagination::bootstrap-4') }}
</section>

  <!--modal add-->
  <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="post" enctype="multipart/form-data" action="{{ route('client.product.create') }}">
        {{ csrf_field() }}
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-success">
        <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="display: flex; flex-direction:column; gap:5;">
            <div id="display-image-add"></div>
            <label class="fa fa-label" for="">Upload Image</label>
            <input required name="image" class="image-add fa fa-control" type="file">
            <label class="fa fa-label" for="">Enter Product</label>
            <input required name="product" class="fa fa-control" type="text">
            <label class="fa fa-label" for="">Select Categories</label>
            <select required name="category" class="fa fa-control">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <label class="fa fa-label" for="">Enter Price</label>
            <input required name="price" class="fa fa-control" type="number">
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i></button>
        </div>
    </div>
  </form>
</div>
</div>
<!--end add-->

<script>
const image_add = document.querySelector(".image-add");
image_add.addEventListener("change", function(event) {
  let reader = new FileReader();
  reader.addEventListener("load", () => {
    let uploaded_image = reader.result;
    document.getElementById(event.target.parentElement.children[0].id).style.backgroundImage = `url(${uploaded_image})`;
  });
  reader.readAsDataURL(this.files[0]);
});
/*------------*/
const image_edit = document.querySelectorAll(".display-input");
image_edit.forEach(image=>{
    image.addEventListener("change", function(event) {
    let reader = new FileReader();
    let elementInput = event.target.parentElement.children
    reader.addEventListener("load", () => {
       elementInput[1].style.display="none"
       elementInput[0].style.display="inline"
       let uploaded_image = reader.result;
        document.getElementById(elementInput[0].id).style.backgroundImage = `url(${uploaded_image})`;
    });
    reader.readAsDataURL(this.files[0]);
    });
})

</script>
@endsection


