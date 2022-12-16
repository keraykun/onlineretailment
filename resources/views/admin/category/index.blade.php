@extends('layouts.admin.sidenav')
@section('sidenav')


<style>
    section.report-box{
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 20px;
    }
    article.report-title{
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        flex: 1 1 100%; /*grow | shrink | basis */
        height: 50px;
        display: flex;
        flex-direction: row;
        font-size: 1.2rem;
        color: white;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        letter-spacing: 1px;
        background: var(--fontNavy);
    }

    article.report-list{
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        flex: 1 1 100%; /*grow | shrink | basis */
        height: 50px;
        display: flex;
        flex-direction: row;
    }
    article.report-list .report-head{
        flex: 7;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }
    article.report-list .report-head > *{
        font-size: 1rem;
        color:var(--fontNavy) !important; */

    }
    article.report-list .report-image{
        width: 100px;
        overflow: hidden;
        position: relative;
    }
    article.report-list .report-image img{
        left: 0%;
        top: -50%;
        position: absolute;
        padding: 2px;
        background: var(--fontNavy);
    }

    article.report-list .report-body{
        background: purple;
        flex: 2;
        display: flex;
        align-items: center;
        justify-content: space-around;
    }
    article.report-list .report-body a {
        font-size: 1.1rem;
        color: white;
    }

    .search-box{
        width: 100%;
        display: flex;
        justify-content: center;
    }
    .search-box form{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .search-box form input[type="search"]{
        border: 0.5px solid skyblue;
        outline: 0;
        padding: 5px 10px;
        margin: 0px 20px;
    }
    .search-box form input[type="search"]:focus{
        border: 1px solid var(--fontNavy);

    }
    .search-box form button[type="submit"]{
        background: var(--fontNavy);
        padding: 5px 10px;
        border: 5px;
        color: azure;
    }
    .carretClass{
        box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
        padding: 5px 10px;
        cursor: pointer;
        display: none;
    }
</style>


<section class="report-box">
    <article class="report-title">
       Categories List
    </article>
    <div class="search-box">
        <button data-bs-toggle="modal" data-bs-target="#add" class="modal-button-success" type="button">Add category</button>
        <form class="w-full" action="{{ route('admin.category.index') }}">
            <i class="fa fa-search"></i>
            <input placeholder="Search"  type="search" name="search">
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
    @foreach ($categories as $category)
    <article class="report-list">
        <div class="report-head">
            <p>{{ Str::ucfirst($category->name) }}</p>
        </div>
        <div class="report-body">
            <a data-bs-toggle="modal" data-bs-target="#edit-{{ $category->id }}" href="#"><i style="font-size: 1.1rem;" class="fa fa-pencil"></i></a>
            <a data-bs-toggle="modal" data-bs-target="#delete-{{ $category->id }}" href="#"><i style="font-size: 1.1rem;" class="fa fa-trash"></i></a>

             <!--modal edit-->
                <div class="modal fade" id="edit-{{ $category->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <form method="post" action="{{ route('admin.category.update') }}">
                        @csrf
                        {{ method_field('patch') }}
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-navy">
                        <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label class="fa fa-label" for="">Category</label>
                            <input required name="category" class="fa fa-control" value="{{ $category->name }}" type="text">
                        </div>
                        <div class="modal-footer">
                        <input type="hidden" value="{{ $category->id }}" name="id">
                        <button type="submit" class="btn btn-navy"><i class="fa fa-edit"></i></button>
                        </div>
                    </div>
                </form>
                </div>
                </div>
                <!--end edit-->


            <!--modal delete-->
            <div class="modal fade" id="delete-{{ $category->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <form method="POST" action="{{ route('admin.category.destroy',$category->id) }}">
                    @csrf
                    {{ method_field('delete') }}
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure want to Delete?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       {{ $category->name }}
                    </div>
                    <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button> --}}
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
                </div>
                 </form>
            </div>
            <!--end modal-->
        </div>
    </article>
    @endforeach
    {{ $categories->withQueryString()->links('pagination::bootstrap-4') }}
</section>



  <!--modal add-->
  <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="post" action="{{ route('admin.category.create') }}">
        @csrf
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-success">
        <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <label class="fa fa-label" for="">Category</label>
            <input required name="category" class="fa fa-control" type="text">
        </div>
        <div class="modal-footer">
        {{-- <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button> --}}
        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i></button>
        </div>
    </div>
  </form>
</div>
</div>
<!--end add-->

@endsection
