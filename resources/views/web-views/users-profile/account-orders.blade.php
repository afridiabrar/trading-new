@extends('layouts.front.app')
@section('title', 'My Orders')
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
                                    <th>Order#</th>
                                    <th>Order Date</th>
                                    <th>Payment Status</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($orders) > 0)
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{!! $order['id'] !!}</td>
                                            <td>{!! date('F d, Y', strtotime($order['created_at'])) !!}</td>
                                            <td>
                                                @if($order['payment_status'] == 'paid')
                                                    <span class="status text-success"> {!! ucwords($order['payment_status']) !!} </span>
                                                @elseif($order['payment_status'] == 'unpaid')
                                                    <span class="status text-danger"> {!! ucwords($order['payment_status']) !!}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order['order_status']=='failed' || $order['order_status']=='canceled')
                                                    <span class="status text-danger">•</span> {!! ucwords($order['order_status']) !!}
                                                @elseif($order['order_status']=='confirmed' || $order['order_status']=='processing' || $order['order_status']=='delivered')
                                                    <span class="status text-success">•</span> {!! ucwords($order['order_status']) !!}
                                                @else
                                                    <span class="status text-info">•</span> {!! ucwords($order['order_status']) !!}
                                                @endif
                                            </td>
                                            <td>{!! \App\CPU\Helpers::currency_converter($order['order_amount']) !!}</td>
                                            <td>
                                                <a href="javascript:void(this);" class="view order_view_details" title=""
                                                   data-original-title="View Details" data-id="{!! $order['id'] !!}"><i
                                                        class="fa fa-chevron-circle-right"></i> View Details</a>
                                                @if($order['payment_method']=='cash_on_delivery' && $order['order_status']=='pending')
                                                    <a href="{!! route('order-cancel', $order['id']) !!}" class="view" title=""
                                                       data-original-title="Cancel Order"><i
                                                            class="fa fa-remove"></i> Cancel Order</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td>No orders found!</td></tr>
                                @endif
                                </tbody>
                            </table>
                            {!! $orders->appends($_GET)->links('vendor.pagination.profile-pagination') !!}
                        </div>
                    </div>
                </div>
            </div>
            {{--Table Row Close --}}

        </div>
        {{-- Model --}}
        <div class="modal fade" id="order_view_details_modal">
        </div>
    </section>
    <!-- end container-->
@endsection

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

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.order_view_details').click(function () {
                var url = '{!! route("account-order-details", ":id") !!}';
                url = url.replace(':id', $(this).attr('data-id'));
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function (response) {
                        $('#loading').show();
                    },
                    success: function (response) {
                        $('#order_view_details_modal').html(response.html);
                        $('#order_view_details_modal').modal('show');
                    },
                    complete: function (response) {
                        $('#loading').hide();
                    }
                });
            });
        });
    </script>
@endpush
