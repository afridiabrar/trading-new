@extends('layouts.front.app')
@section('title', 'Brands')
@section('content')
    <section class="sec-filter">
        <div class="container">
            <div class="clmnsxx text-center">
                <h2> Brands </h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="brands">
                        @foreach($brands as $key => $brand)
                            <ul>
                                <li style="font-family: 'Graphik';font-weight: bold;font-size: 40px;color: #000;text-align:left;">{!! $key !!} </li>
                                @foreach($brand as $data)
                                    <li><a href="{!! route('shop') . '?id=' . $data['id'] . '&data_from=brand' !!}">{!! $data['name'] !!}</a></li>
                                @endforeach
                            </ul>
                            @endforeach


                            {{--
                                                    <table class="table brandsxx">
                             --}}

                            {{-- <thead>
                            </thead>
                            <tbody>
                            @foreach($brands as $key => $brand)
                                <tr>
                                    <td class="alphax">{!! $key !!}</td>
                                        @foreach($brand as $value)
                                            <td class="thexx">{!! $value !!}</td>
                                        @endforeach
                                </tr>
                            @endforeach --}}
                            {{--                            <tr>--}}
                            {{--                                <td class="alphax">B</td>--}}
                            {{--                                <td class="thexx">Birkenstock <br>--}}
                            {{--                                    Berghaus--}}
                            {{--                                </td>--}}
                            {{--                                <td></td>--}}
                            {{--                            </tr>--}}
                            {{--                            <tr>--}}
                            {{--                                <td class="alphax">C</td>--}}
                            {{--                                <td class="thexx">Carhartt WIP <br>--}}
                            {{--                                    Converse <br>--}}
                            {{--                                    Clarks Originals--}}
                            {{--                                </td>--}}
                            {{--                                <td>Columbia <br>--}}
                            {{--                                    Crocs <br>--}}
                            {{--                                    Calvin Klein--}}
                            {{--                                </td>--}}
                            {{--                                <td>--}}

                            {{--                                    Crep Protect <br>--}}
                            {{--                                    Champion--}}
                            {{--                                </td>--}}
                            {{--                            </tr>--}}
                            {{--                            <tr>--}}
                            {{--                                <td class="alphax">D</td>--}}
                            {{--                                <td class="thexx">Dr. Martens <br>--}}
                            {{--                                </td>--}}
                            {{--                                <td></td>--}}
                            {{--                            </tr>--}}
                            {{--                            <tr>--}}
                            {{--                                <td class="alphax">E</td>--}}
                            {{--                                <td class="thexx">Element</td>--}}
                            {{--                                <br>--}}
                            {{--                                <td></td>--}}
                            {{--                            </tr>--}}
                            {{--                            <tr>--}}
                            {{--                                <td class="alphax">F</td>--}}
                            {{--                                <td class="thexx">Fred Perry <br>--}}
                            {{--                                    Fila--}}
                            {{--                                </td>--}}
                            {{--                                <td></td>--}}
                            {{--                            </tr>--}}
                            {{--                            <tr>--}}
                            {{--                                <td class="alphax">G</td>--}}
                            {{--                                <td class="thexx">Gramicci <br>--}}
                            {{--                                    Gio Goi--}}
                            {{--                                </td>--}}
                            {{--                                <td></td>--}}
                            {{--                            </tr>--}}
                            {{--                            <tr>--}}
                            {{--                                <td class="alphax">H</td>--}}
                            {{--                                <td class="thexx">Huf <br>--}}
                            {{--                                    Hi-Tec <br>--}}
                            {{--                                    Hoka One One--}}
                            {{--                                </td>--}}
                            {{--                                <td></td>--}}
                            {{--                            </tr>--}}
                            {{--                            <tr>--}}
                            {{--                                <td class="alphax">J</td>--}}
                            {{--                                <td class="thexx">Jordan <br>--}}
                            {{--                                    Jason Markk--}}
                            {{--                                </td>--}}
                            {{--                                <td>--}}

                            {{--                                </td>--}}
                            {{--                            </tr>--}}
                            {{--                            <tr>--}}
                            {{--                                <td class="alphax">K</td>--}}
                            {{--                                <td class="thexx">Kangol <br>--}}
                            {{--                                    Keen <br>--}}
                            {{--                                    Kickers--}}
                            {{--                                </td>--}}
                            {{--                                <td>--}}
                            {{--                                    Karhu--}}

                            {{--                                </td>--}}
                            {{--                            </tr>--}}
                            {{--                            <tr>--}}
                            {{--                                <td class="alphax">L</td>--}}
                            {{--                                <td class="thexx">Levis</td>--}}
                            {{--                                <td>--}}

                            {{--                                </td>--}}
                            {{--                            </tr>--}}
                            {{--                            <tr>--}}
                            {{--                                <td class="alphax">M</td>--}}
                            {{--                                <td class="thexx">Mephisto <br>--}}
                            {{--                                    Medicom <br>--}}
                            {{--                                    Medipop--}}
                            {{--                                </td>--}}
                            {{--                                <td>--}}

                            {{--                                </td>--}}
                            {{--                            </tr>--}}
                            {{--                            <tr>--}}
                            {{--                                <td class="alphax">#</td>--}}
                            {{--                                <td class="thexx">View all Brands</td>--}}
                            {{--                                <td>--}}

                            {{--                                </td>--}}
                            {{--                            </tr>--}}
                            </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
