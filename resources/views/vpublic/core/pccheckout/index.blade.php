@extends('templates.core.master')
@section('main')
<main class="site-main checkout">
    <div class="container">
        <ol class="breadcrumb-page">
            <li><a href="#">Home </a></li>
            <li class="active"><a href="#">Checkout  </a></li>
        </ol>
    </div>
    <div class="container">
        <form action="#" class="checkout" method="post" name="checkout">
            <h4 class="title-checkout">Biiling Address</h4>
            <div class="row">
                <div class="form-group col-md-6">   
                    <label class="title">First Name*</label> 
                    <input type="text" class="form-control" id="forFName" placeholder="Your name" >
                </div>
                <div class="form-group col-md-6">   
                    <label class="title">Last Name*</label> 
                    <input type="text" class="form-control" id="forLName" placeholder="Your last name" >
                </div>
                <div class="form-group col-md-6">
                    <label class="title">Email Addreess:</label>
                    <input type="email" class="form-control" id="forEmail" placeholder="Type your email" >
                </div>
                <div class="form-group col-md-6">
                    <label class="title">Phone numbber*</label>
                    <input type="text" class="form-control" placeholder="10 digits format">
                </div>
                <div class="form-group col-md-6">
                    <label class="title">Address:</label>
                    <input type="text" class="form-control" placeholder="Street at apartment number">
                </div>
                <div class="form-group col-md-6">
                    <label class="title">Country*</label>
                    <input type="text" class="form-control" placeholder="United States">
                </div>
                <div class="form-group col-md-6">
                    <label class="title">Postcode / ZIP:</label>
                    <input type="text" class="form-control" placeholder="Your postal code">
                </div>
                <div class="form-group col-md-6">
                    <label class="title">Town / City*</label>
                    <input type="text" class="form-control" placeholder="City name">
                </div>
                <div class="form-group shipping col-md-6">
                    <ul>
                        <li><label class="inline" ><input type="checkbox"><span class="input"></span>Create an account?</label></li>
                        <li><label class="inline" ><input type="checkbox"><span class="input"></span>Ship to a different address?</label></li>
                    </ul>
                    <h4 class="title-checkout">Shipping method</h4>
                    <p>Flat Rate</p>
                    <p>Fixed $50.00</p>
                    <h4 class="discount">Discount Codes</h4>
                    <label class="title">Enter Your Coupon code:</label>
                    <input type="text" class="form-control">
                    <button type="submit" class="btn-apply">Apply</button>
                </div>
                <div class="form-group payment col-md-6">
                    <h4 class="title-checkout">Payment Method</h4>
                    <p>Check / Money order</p>
                    <p>Credit Cart (saved)</p>
                    <ul>
                        <li><label class="inline" ><input type="checkbox"><span class="input"></span>Direct Bank Transder</label></li>
                        <li><label class="inline" ><input type="checkbox"><span class="input"></span>Cash on Delivery</label></li>
                        <li><label class="inline" ><input type="checkbox"><span class="input"></span>Paypal</label></li>
                    </ul>
                    <p class="credit">You can pay with your credit<br> card if you don't have a paypal account</p>
                    <span class="grand-total">Grand Total<span>$100.00</span></span>
                    <button type="submit" class="btn-order">Place Order Now</button>
                </div>
                
            </div>
        </form>
    </div>
    
</main>
@stop