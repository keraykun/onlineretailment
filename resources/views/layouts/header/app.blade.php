<html>
<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Caveat&display=swap');
        :root{
            --fontText: #658397;
            --fontClay: #b2cbdb;
            --fontOrange:#ecad47;
            --greenColor:rgb(34 197 94);
            --orangeColor:rgb(205 144 17);
            --fontNavy:#0E86D4;
            --fontDanger:#df2828;
        }

        .home-logo{
            font-family: 'Caveat', cursive;
            font-size: 3rem;
            font-weight: bold;
            color: rgb(202 138 4);
            text-shadow: 1px 2px 0px #4f5723;
            letter-spacing: 2px;
        }
        .count-cart{
            font-size: 0.9rem;
            padding: 1px 3px;
            background: red;
            border-radius: 50%;
            color: white;
        }

    .alert-alert-message.alert-success{
        border:none;
        border-bottom: 2px solid rgb(10 231 91);
        opacity: 0.9;
        margin-right: 20px;
        width: 300px;
        letter-spacing: 1.1px;
        text-align: center;
        color:  rgb(10 231 91);
        position: relative;
    }
    .alert-alert-message.alert-success::before{
        content: '';
        position: absolute;
        background: rgb(10 231 91);
        opacity: 0.1;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .alert-alert-message.alert-danger{
        border:none;
        border-bottom: 2px solid red;
        opacity: 0.9;
        margin-right: 20px;
        width: 300px;
        letter-spacing: 1.1px;
        text-align: center;
        color:  red;
        position: relative;
    }
    .alert-alert-message.alert-danger::before{
        content: '';
        position: absolute;
        background: red;
        opacity: 0.1;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .alert-alert-message.alert-added{
        border:none;
        border-bottom: 2px solid orange;
        opacity: 0.9;
        margin-right: 20px;
        width: 300px;
        letter-spacing: 1.1px;
        text-align: center;
        color:  orange;
        position: relative;
    }
    .alert-alert-message.alert-added::before{
        content: '';
        position: absolute;
        background: orange;
        opacity: 0.1;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .alert-alert-message.alert-danger::before{
        content: '';
        position: absolute;
        background: red;
        opacity: 0.1;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .alert-alert-message.alert-info{
        border:none;
        border-bottom: 2px solid var(--fontNavy);
        opacity: 0.9;
        margin-right: 20px;
        width: 300px;
        letter-spacing: 1.1px;
        text-align: center;
        color:  var(--fontNavy);
        position: relative;
    }
    .alert-alert-message.alert-info::before{
        content: '';
        position: absolute;
        background:var(--fontNavy);
        opacity: 0.1;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }


    .modal-button-success{
        background: rgb(34 197 94);
        color: azure;
        padding: 5px 10px;
        width: 200px;
        letter-spacing: 1px;
    }
    .modal-button-success:hover{
       background: rgb(39 229 109) !important;
    }

    /**buttonts **/

    .btn.btn-default{
       border: 1px solid #b0b0b0;
       padding: 10px 10px;
       border-radius: 5px;
       margin: 5px;
    }


    .btn.btn-success{
       background: rgb(34 197 94);
       color: white;
       padding: 10px 20px;
       border-radius: 5px;
       margin: 5px;
    }
    .btn.btn-success:hover{
       background: rgb(39 229 109) !important;
    }

    .btn.btn-navy{
       background: var(--fontNavy);
       color: white;
       padding: 10px 20px;
       border-radius: 5px;
       margin: 5px;
    }
    .btn.btn-navy:hover{
       background: #0c97f1 !important;
    }

    .bg-danger{
        background:  #df2828;
        color: azure;
    }
    .bg-success{
        background: rgb(29 195 90);
        color: azure;
    }
    .bg-navy{
        background:  var(--fontNavy);
        color: azure;
    }

    .btn.btn-danger{
       background: #df2828;
       color: white;
       padding: 10px 20px;
       border-radius: 5px;
       margin: 5px;
    }
    .btn.btn-danger:hover{
       background: #ff3939 !important;
    }

    .bg-purple{
        background: purple;
        color: white;
    }

    .btn.btn-purple{
        background: purple;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        margin: 5px;
    }
    .btn.btn-purple:hover{
        background: #cd15cd;
    }
    </style>

<style>
    .fa.fa-control{
        outline: 0;
        padding: 5px 10px;
        border: 1px solid #b0b0b0;
        border-radius: 3px;
        margin: 5px;
    }
</style>
</head>
<body>
    <div id="main-container" class="mx-auto xl:container h-full">
        <nav class="pt-5 flex flex-row justify-center items-center">
            <a class="home-logo"  href="{{ route('guest.home') }}" class="bg-red-600" href="">Sneakers</a>
            <ul  class="flex w-full text-green-600 font-bold py-4 pr-4 text-2xl justify-end gap-8 mr-5">
            @if (!Auth::check())
                <li><a href="{{ route('guest.login') }}" class="hover:text-green-500 hover:underline-offset cursor-pointer">Login</a></li>
                <li><a href="{{ route('guest.register') }}" class="hover:text-green-500 hover:underline-offset cursor-pointer">Register</a></li>
            @else
                <li><small style="color:#0e86d4;"><i class="fa fa-user" style="margin-right: 10px; color:#0e86d4;"></i>{{ auth()->user()->name }}</small></li>
                @if(auth()->user()->role->name==='user')
                <li><a href="{{ route('cart.index') }}" class="hover:text-green-500 hover:underline-offset cursor-pointer"><i style="color: rgb(205 144 17);" class="fa fa-shopping-cart"></i><span class="count-cart">{{ countCart() }}</span></a></li>
                <li><a href="{{ route('cart.wishlist.index') }}" class="hover:text-green-500 hover:underline-offset cursor-pointer"><i style="color: #d9a5ae;" class="fa fa-heart"></i><span class="count-cart">{{ countWishCart() }}</span></a></li>
                @endif
                @if(Route::is('guest.*') )
                <li><a href="{{ redirectToDashboard(Auth::user()->role->name) }}" class="hover:text-green-500 hover:underline-offset cursor-pointer"><i style="color: rgb(34 197 94);" class="fa fa-home"></i></a></li>
                @else
                <li><a href="{{ route('guest.product') }}" class="hover:text-green-500 hover:underline-offset cursor-pointer">
                    <i style="color: rgb(34 197 94);" class="fa fa-shopping-bag"></i>
                    <span style="font-size:1rem; background:red; padding:2px; margin:0px 4px; color:white; border-radius:10px;">Shop</span></a>
                </li>
                @endif
            @endif
            </ul>
        </nav>
        <main id="main-container" class="flex flex-row relative">
            <!---->
            @yield('content')
            <!---->
         </main>
    </div>
    <script>
        let alert = document.querySelector('.alert-alert-message')
        setTimeout(() => {
            alert.style.display='none'
        }, 2000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
