@extends('layouts.admin.sidenav')
@section('sidenav')

<style>
#display-image-add, .display-image,#display-image-picture{
  width: 100x;
  height: 300px;
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
/****-----*/
section.report-box div{
    width: 100%;
    display: flex;
    flex-direction: row !important;
    align-items: flex-start;
    gap: 10px;
}section.report-box div.form-content div{
    width:100%;
}
section.report-box div.form-content div form div.form-list{
    width: 100%;
    display: flex;
    flex-direction: column !important;
}
section.report-box div.form-content div form div div.form-group{
    padding: 10px;
    display: flex;
    justify-content: space-around;
    align-items: center;
    letter-spacing: 1px;
    font-size: 1.1rem;
}
section.report-box div.form-content div form div div.form-group label{
    flex:1;
    color: #729cb7;
}
section.report-box div.form-content div form div div.form-group input{
    padding: 5px 20px;
    width: 100%;
    flex:2;
    outline: 0;
    border: 1px solid #729cb7;
    border-radius: 7px;
}
section.report-box div.form-content div form div div.form-group input:disabled{
    color: gray;
}
</style>

<section class="report-box">
    @if(Session::has('success'))
    <p style="color:green; font-size:1.1rem;">{{ Session::get('success') }}</p>
    @enderror
   <div class="form-content">
    <div class="form-account">
        <form method="POST" action="{{ route('admin.setting.detail') }}" style="width:100%;">
            @csrf
            <div class="form-list">
            <div class="form-group">
                <label class="form-list" for="">Email : </label>
                <input disabled value="{{ auth()->user()->email }}" type="email">
            </div>
            <div class="form-group">
                <label class="form-list" for="">Role Mode : </label>
                <input disabled value="{{ ucfirst(auth()->user()->role->name ) }}" type="text">
            </div>
            @error('name')
            <p style="color:red;">{{ $message }}</p>
            @enderror
            <div class="form-group">
                <label class="form-list" for="">Name : </label>
                <input name="name" value="{{ auth()->user()->name }}" type="text">
            </div>
            <div class="form-group">
                <button class="btn btn-navy" type="submit">Update Name</button>
            </div>
         </div>
        </form>
    </div>

    <div class="form-picture" style="display: flex; flex-direction:column !important;">
        <div id="display-image-picture" style="overflow: hidden;">
            @if (userProfilePicture()->image!=null)
            <img style="height: 400px; width:100%;" src="{{ asset('storage/users/'.userProfilePicture()->image->name) }}" alt="">
            @endif
        </div>
        <div style="display: none;" id="display-image-add"></div>
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.setting.picture') }}">
            @csrf
            <input required name="image" class="image-add fa fa-control" type="file">
            <button class="btn btn-navy" type="submit">Update Picture</button>
        </form>
    </div>

   </div>
   <div class="form-content">
    <div class="form-account">
        <form method="POST" action="{{ route('admin.setting.password') }}" style="width:100%;">
            @csrf
            <div class="form-list">
            @error('password')
            <p style="color:red;">{{ $message }}</p>
             @enderror
            <div class="form-group">
                <label class="form-list">Old Password : </label>
                <input name="password"  type="password">
            </div>
            @error('newpassword')
            <p style="color:red;">{{ $message }}</p>
             @enderror
            <div class="form-group">
                <label class="form-list">New Password : </label>
                <input  name="newpassword"  type="password">
            </div>
            @error('confirmpassword')
            <p style="color:red;">{{ $message }}</p>
             @enderror
            <div class="form-group">
                <label class="form-list">Confirm Password : </label>
                <input  name="confirmpassword" type="password">
            </div>
            <div class="form-group">
                <button class="btn btn-navy" type="submit">Update Password</button>
            </div>
         </div>
        </form>
    </div>
    <div class="form-picturex" >

    </div>
   </div>
</section>
<script>
const image_add = document.querySelector(".image-add");
image_add.addEventListener("change", function(event) {
  let reader = new FileReader();
  reader.addEventListener("load", () => {
    let uploaded_image = reader.result;
    let imageFile =  document.querySelector('#display-image-add')
    document.querySelector('#display-image-picture').style.display="none";
    imageFile.style.display="inline";
    imageFile.style.backgroundImage = `url(${uploaded_image})`;
  });
  reader.readAsDataURL(this.files[0]);
});
</script>
@endsection
