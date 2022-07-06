@extends('layouts.front.app')
@section('title', 'Order')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="teext-w-icn">
                    <img class="img-fluid" src="{!! frontImage('alex.png') !!}">
                    <h4>JOHN DOE <br>
                        <span>User # 12496</span>
                    </h4>
                </div>
            </div>
            <div class="col-md-8">
                <h2 class="text-center">

                    Profile
                </h2>
            </div>
        </div>
    </div>
    <section class="check-sec" >
        <div class="container frm-prof">
            <div class="row">
                <div class="col-sm-4">
                    <div class="profilx">
                        <a href="{!! route('user-account') !!}" class="btnx-4">Profile</a>
                        <a href="{!! url('security') !!}" class="btnx-4">Security</a>
                        {{-- <a href="{!! url('payment-method') !!}" class="btnx-4">Payment Method</a> --}}
                        <a href="{!! url('order') !!}" class="btnx-4">Orders</a>
                        {{-- <a href="#" class="btnx-4">Orders History</a> --}}
                    </div>
                </div>
                <div class="col-sm-8 all-over-detail">
                    <h3>Current Orders</h3>
                    <div class="table-responsive ">
                        <div class="table-wrapper">
                            <table class="table table-striped dark table-hover cssTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Location</th>
                                        <th>Order Date</th>
                                        <th>Status</th>
                                        <th>Net Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><a href="#" class="text-g"><img width="50" src="{{ asset('http://localhost/rchive/storage/app/public/product/thumbnail/2021-09-13-613f5fefcad10.png')}}" width="50"
                                                   alt="Avatar"> Michael Holz</a></td>
                                        <td>London</td>
                                        <td>Jun 15, 2017</td>
                                        <td><span class="status text-success">•</span> Delivered</td>
                                        <td>$254</td>
                                        <td><a href=""  data-toggle="modal" data-target="#modal1" class="view" title=""
                                            data-original-title="View Details"><i
                                                class="fa fa-chevron-circle-right"></i> View Details</a></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><a href="#" class="text-g"><img width="50" src="{{ asset('http://localhost/rchive/storage/app/public/product/thumbnail/2021-09-13-613f5fefcad10.png')}}" width="50"
                                                    alt="Avatar"> Paula Wilson</a></td>
                                        <td>Madrid</td>
                                        <td>Jun 21, 2017</td>
                                        <td><span class="status text-info">•</span> Shipped</td>
                                        <td>$1,260</td>
                                        <td><a href=""  data-toggle="modal" data-target="#modal1" class="view" title=""
                                            data-original-title="View Details"><i
                                                class="fa fa-chevron-circle-right"></i> View Details</a></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><a href="#" class="text-g"><img width="50" src="{{ asset('http://localhost/rchive/storage/app/public/product/thumbnail/2021-09-13-613f5fefcad10.png')}}" width="50"
                                                     alt="Avatar"> Antonio Moreno</a></td>
                                        <td>Berlin</td>
                                        <td>Jul 04, 2017</td>
                                        <td><span class="status text-danger">•</span> Cancelled</td>
                                        <td>$350</td>
                                        <td><a href=""  data-toggle="modal" data-target="#modal1" class="view" title=""
                                            data-original-title="View Details"><i
                                                class="fa fa-chevron-circle-right"></i> View Details</a></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="clearfix justify-content-center text-center">
                                <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                                <ul class="pagination justify-content-center text-center ">
                                    <li class="page-item"><a href="#" class="page-link">Pre</a></li>
                                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                                    <li class="page-item active"><a href="#" class="page-link">4</a></li>
                                    <li class="page-item"><a href="#" class="page-link">5</a></li>
                                    <li class="page-item"><a href="#" class="page-link">6</a></li>
                                    <li class="page-item"><a href="#" class="page-link">7</a></li>
                                    <li class="page-item"><a href="#" class="page-link">Next</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    {{-- <h3>Current Orders</h3>
                    <table class="table table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Total -  $385</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">01</th>
                            <td>  Nylon Jail Jacket</td>
                            <td> <span>$300 </span></td>
                            <td><a href="#" class="btnx-4">View Order</a></td>
                        </tr>
                        <tr>
                            <th scope="row">02</th>
                            <td>    "I Saw This Future" T-shirt</td>
                            <td><span>$85</span></td>
                            <td><a href="#" class="btnx-4">View Order</a></td>
                        </tr>
                        </tbody>
                    </table> --}}
                </div>
            </div>
{{--Table Row Close --}}

</div>
 {{-- Model --}}
 <div class="modal fade" id="modal1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-body">
                <div class="container pt-5 pb-2">
                    <h4 class="modal-title text-center font-18">TSA HOODIE<br> New Arrival</h4> <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6>Item Details</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <img class="img-fluid img-o" width="100" src="https://i.imgur.com/iItpzRh.jpg">
                        </div>
                        <div class="col-md-6 text-right" style="padding-top: 2vh;">
                            <ul type="none" class="order-d">
                                <li>Size: 11</li>
                                <li>Color: Desert Sage</li>
                            </ul>
                        </div>
                    </div>

                    <h6>Order Details</h6>
                    <div class="row">
                        <div class="col-md-6 col-xs-6 details-o">
                            <ul type="none">
                                <li class="left">Order number:</li>
                                <li class="left">Date:</li>
                                <li class="left">Price:</li>
                                <li class="left">Shipping:</li>
                                <li class="left">Total Price:</li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-xs-6 details-r">
                            <ul class="" type="none" >
                                <li class="right">#BBRT-3456981</li>
                                <li class="right">19-03-2020</li>
                                <li class="right">$690</li>
                                <li class="right">$30</li>
                                <li class="right">$720</li>
                            </ul>
                        </div>
                    </div>
                    <h6>Shipment</h6>
                    <div class="row" style="border-bottom: none">
                        <div class="col-md-6">
                            <ul type="none" class="order-d">
                                <li class="left">Estimated arrival</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul type="none" class="order-d">
                                <li class="right">25-03-2020</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="bg-white p-2 border rounded px-3">
                                <div class="d-flex flex-row justify-content-between align-items-center order">
                                    <div class="d-flex flex-column order-details"><span>Your order has been delivered</span><span class="date">by DHFL on 21 Jan, 2020</span></div>
                                    {{-- <div class="tracking-details">
                                        <button class="btn btn-outline-info btn-sm btn-rounded btn-navbar waves-effect waves-light" type="button">View Invoice Details</button>
                                    </div> --}}
                                </div>
                                <hr class="divider mb-4">
                                <div class="d-flex flex-row justify-content-between align-items-center align-content-center"><span class="dot"></span>
                                    <hr class="flex-fill track-line"><span class="dot"></span>
                                    <hr class="flex-fill track-line"><span class="dot"></span>
                                    <hr class="flex-fill track-line"><span class="dot"></span>
                                    <hr class="flex-fill track-line"><span class="d-flex justify-content-center align-items-center big-dot dot"><i class="fa fa-check text-white"></i></span></div>
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <div class="d-flex flex-column align-items-start"><span>15 Mar</span><span>Order placed</span></div>
                                    <div class="d-flex flex-column justify-content-center"><span>15 Mar</span><span>Order placed</span></div>
                                    <div class="d-flex flex-column justify-content-center align-items-center"><span>15 Mar</span><span>Order Dispatched</span></div>
                                    <div class="d-flex flex-column align-items-center"><span>15 Mar</span><span>Out for delivery</span></div>
                                    <div class="d-flex flex-column align-items-end"><span>15 Mar</span><span>Delivered</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Modal footer -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-dark btn-submit">View Order Invoice </button>
             </div>
        </div>
    </section>
    <!-- end container-->
    <style>
.details-o{
    font-size: 14px;
}
.details-r{
font-size: 14px;
}
.order-d{
    font-size: 14px;
}

.date {
    font-size: 11px
}

.divider {
    height: 0px !important;
    background-color: #e09370
}

.track-line {
    height: 2px !important;
    background-color: #e09370
}

.dot {
    height: 10px;
    width: 10px;
    margin-left: 3px;
    margin-right: 3px;
    margin-top: 0px;
    background-color: #e09370;
    border-radius: 50%;
    display: inline-block
}

.big-dot {
    height: 25px;
    width: 25px;
    margin-left: 0px;
    margin-right: 0px;
    margin-top: 0px;
    background-color: #e09370;
    border-radius: 50%;
    display: inline-block
}

.big-dot i {
    font-size: 12px
}
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
    font-size: 14px;
}
.modal-dialog {
    max-width: 500px !important;
    margin: 30px auto;
}
    </style>
@endsection
