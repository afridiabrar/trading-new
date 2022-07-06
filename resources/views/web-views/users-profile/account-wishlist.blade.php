@extends('layouts.front.app')

@section('title', 'Wishlist')

@push('css')
    <style>
        .details-o {
            font-size: 14px;
        }

        .details-r {
            font-size: 14px;
        }

        .order-d {
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
@endpush
@section('content')

    @include('web-views.users-profile.partials.account-profile-header')

    <section class="check-sec">
        <div class="container frm-prof">
            <div class="row">

                @include('web-views.users-profile.partials.account-side-menu')

                <div class="col-sm-8 all-over-detail">
                    <h3>Current Orders</h3>
                    <div class="table-responsive ">
                        <div class="table-wrapper">
                            <table class="table table-striped dark table-hover cssTable">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($wishlists) > 0)
                                    @foreach($wishlists as $key => $wishlist)
                                        <tr>
                                            <td><a href="{!! route('product.details', $wishlist->product->slug) !!}" class="text-g"><img width="50"
                                                                                src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') . '/' . $wishlist->product->thumbnail !!}"
                                                                                width="50"
                                                                                alt="{!! $wishlist->product->name !!}">{!! $wishlist->product->name !!}</a></td>
                                            <td>{!! ($wishlist->product->brand) ? $wishlist->product->brand->name : '' !!}</td>
                                            @php($tax = ($wishlist->product->tax_type == 'percent' ? $wishlist->product->unit_price + ($wishlist->product->unit_price * $wishlist->product->tax) / 100 : $wishlist->product->unit_price + $wishlist->product->tax))
                                            <td>{!! \App\CPU\Helpers::currency_converter($tax) !!}</td>
                                            <td>{!! date('F d, Y', strtotime($wishlist->product->created_at)) !!}</td>
                                            <td><a href="{!! route('delete-wishlist', $wishlist->product->slug) !!}" class="view"><i
                                                        class="fa fa-remove"></i> Remove</a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td>No Records Found!</td></tr>
                                @endif
                                </tbody>
                            </table>
                            {!! $wishlists->appends($_GET)->links('vendor.pagination.profile-pagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
