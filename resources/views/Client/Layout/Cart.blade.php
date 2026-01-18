@extends('Client.Index')
@section('Content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" class='py-4'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <Link to="/">Home</Link>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-md-12">
            <h3 class='border-bottom pb-3'>Giỏ hàng </h3>
            <table class='table'>
                <tbody>
                    @php
                            $subtotal = 0;
                    @endphp
                    @if(Auth::check())
                    @foreach ($carts as $cart)
                                @php
                                    $subtotal += $cart->product['price'] * $cart['quantity']
                                @endphp
                                <tr data-product_id="{{ $cart->product['id'] }}" data-size="{{ $cart->size['id'] }}" data-user="{{ Auth::user()->getAuthIdentifier() }}">
                                    <td width="100">
                                        <img src={{Storage::url($cart->product['image'])}} alt="" width="100" />
                                    </td>
                                    <td width="600">
                                        <p>{{ $cart->product['name'] }}</p>
                                        <div class='d-flex align-items-center '>
                                            <span>{{ number_format($cart->product['price']) }}</span>
                                            <div class='ps-3'>
                                                <button class='btn btn-size'>
                                                    {{ $cart->size['name'] }}
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" style="width:100px" min="1" max="3" class='form-control quantity'
                                            value="{{ $cart['quantity'] }}" />
                                    </td>
                                    <td>

                                        <button class="border-0 bg-body btnDelCart">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path
                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                            </svg>
                                        </button>

                                    </td>
                                </tr>
                    @endforeach
                    @else
                    <p>Vui lòng <a href="/dang-nhap" class="text-secondary">đăng nhập</a> </p>
                    
                    @endif
                    
                    
                        


                </tbody>
            </table>
            
        </div>
        <div class="row justify-content-end py-3">
            <div class="col-md-3">
                <div class="d-flex justify-content-between border-bottom  pb-2">
                    <div>
                        <strong>Subtotal</strong>
                    </div>
                    <div>{{ number_format($subtotal) }}</div>
                </div>
                <div class="d-flex justify-content-between border-bottom  pb-2">
                    <div>
                        <strong>Shipping</strong>
                    </div>
                    <div>$20</div>
                </div>
                <div class="d-flex justify-content-end py-3">
                    <a href="/thanh-toan" class='btn btn-primary '>Proceed to checkout</a>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('.quantity').change(function () {
                let product_id = $(this).closest('tr').attr('data-product_id');
                let size_id = $(this).closest('tr').attr('data-size');
                let user_id =$(this).closest('tr').attr('data-user');
                let qty = $(this).val();
                if (qty < 1 || qty > 3) {
                    alert("Số lương không được hơp lệ");
                    qty = $(this).val(1);
                }

                $.post("/updateCart", { quantity: qty, product_id: product_id, size_id: size_id,user_id: user_id }, function (res) {
                    // console.log(res);
                    if (res.status == 200) {
                        alert(res.message)
                    }
                    window.location.reload()

                })

            })

            $('.btnDelCart').click(function () {
                let product_id = $(this).closest('tr').attr('data-product_id');
                let size_id = $(this).closest('tr').attr('data-size');
                let user_id =$(this).closest('tr').attr('data-user');
                // alert(size_id+" "+product_id)
                $.post("/deleteCart", { product_id: product_id, size_id: size_id, user_id:user_id  }, function (res) {
                    // console.log(res)
                    if (res.status == 200) {
                        alert(res.message)
                    }
                    window.location.reload();
                })
            })
        })
    </script>
@endpush