@extends('layouts.header.app')
@section('content')
<style>


.proceed-content{
    display: flex;
    gap: 20px;
    width: 100%;

}


.customers-details{
  font-family: Arial, Helvetica, sans-serif;
  width: 100%;
  height: 80vh;
  flex: 1;
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}

.customers-details section:nth-child(1){
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    background: var(--greenColor);
    color: azure;
    padding: 10px;
    font-size: 1.2rem;
}

.customers-details section:nth-child(2){
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 100%;
    width: 100%;
    padding: 20px;
    align-items: flex-start;
    justify-items: flex-start;
}
.customers-details section:nth-child(2) div:nth-child(1){
    width: 100%;
    display: flex;
    align-items: flex-start;
    justify-items: flex-start;

}

.customers-details section:nth-child(2) div.back{
    width: 100%;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 20px 40px;
}


/*-------------*/

.customers-orders{
    height: 80vh;
    overflow-y: scroll;
    flex: 1;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}
.customers-orders section:nth-child(1){
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    background: var(--greenColor);
    color: azure;
    padding: 10px;
    font-size: 1.2rem;
    position: sticky;
    top: 0;
}
.customers-orders section:nth-child(2) div{
    display: flex;
}
.customers-orders section:nth-child(2) div.customer-info{
    box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    margin: 8px 0px;
}

.customers-orders section:nth-child(2) div.customer-info img{
    width: 130px;
    height: 80px;
    padding: 2px;
}

.customers-orders section:nth-child(2) div.customer-info div.order-detail{
    display: flex;
    flex-direction: column;
    padding: 5px;
}

.customers-orders section:nth-child(2) div.customer-info div.order-detail span{
    font-weight: bold;
    margin-right: 15px;
}

.form-group{
    width: 100%;
    padding: 5px;
    margin: 10px;
    display: flex;
    gap: 30px;
    justify-content: space-between;
}

.form-control{
    border: 1px solid #A9A9A9;
    width: 60%;
    border-radius: 3px;
    outline: 0;
    padding: 8px 10px;
}

.alert.alert-danger{
    color: red;
    font-weight: bold;
    letter-spacing: 1px;
    font-size: 0.8rem;
}
</style>


<section class="landing flex-shrink-1 flex  flex-col items-center justify-around" style="padding-bottom: 25px;">
    <div class="proceed-content">
    <article class="customers-details">
        <section>
            <div>Delivery Information</div>
        </section>
        <section>
            <form method="POST" action="{{ route('cart.create') }}" style="width: 100%; padding:0px 30px;">
                @csrf
            <div class="form-list">
                <div class="form-group">
                    <label for="">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                     @enderror
                    Receiver Name
                    </label>
                    <input  name="name" placeholder="Enter name" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label for="">
                        @error('contact')
                            <div class="alert alert-danger">{{ $message }}</div>
                         @enderror
                        Contact Number
                        </label>
                    <input name="contact" maxlength="11" placeholder="Enter contact" class="form-control" type="number">
                </div>
                <div class="form-group">
                    <label for="">
                        @error('province')
                            <div class="alert alert-danger">{{ $message }}</div>
                         @enderror
                        Province
                        </label>
                    <input name="province" placeholder="Enter province" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label for="">
                        @error('city')
                            <div class="alert alert-danger">{{ $message }}</div>
                         @enderror
                        City
                        </label>
                    <input  name="city" placeholder="Enter city" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label for="">
                        @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                         @enderror
                        Address
                        </label>
                    <input  name="address" placeholder="Enter address" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label for="">
                        @error('street')
                            <div class="alert alert-danger">{{ $message }}</div>
                         @enderror
                        Street
                        </label>
                    <input name="street" placeholder="Enter street" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label for="">
                        @error('describe')
                            <div class="alert alert-danger">{{ $message }}</div>
                         @enderror
                        Describe Street
                        </label>
                    <input  name="describe" placeholder="Enter specific Street" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <i>Note : this is CASH ON DELIVERY ( COD ). we don't use any kind of payment credit cards like debit if you
                        don't agree with the payment method you can cancel your orders.</i>
                </div>
            </div>
            <div class="back">
                <a class="btn btn-default" href="{{ route('cart.index') }}">Back</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-credit-card" style="font-size: 1rem;" aria-hidden="true"></i> Order</button>
            </div>
        </section>
    </form>
    </article>

    <article class="customers-orders">
        <section>
            <div>Product Ordered</div>
        </section>
       <section>

        @foreach ($orders->carts as $cart)
        @can('view',$cart)
            <div class="customer-info">
                @if ($cart->product->image!=null)
                <img src="{{ asset('storage/product/'.$cart->product->image->name) }}" alt="">
                @else
                <img src="{{ asset('images/test.jpg') }}" alt="">
                @endif
                <div class="order-detail">
                    <p><span>Product : </span>  {{ $cart->product->name }}</p>
                    <p><span>Price : </span> {{ number_format($cart->price,2) }}</p>
                    <p><span>Seller : </span> {{ $cart->product->owner->name }}</p>
                </div>
            </div>
        @endcan
        @endforeach

        </section>
    </article>
</section>

 @endsection
