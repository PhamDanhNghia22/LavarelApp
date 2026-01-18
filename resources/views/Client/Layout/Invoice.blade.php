@extends('client.Index')
@section('Content')
@php
$total =0;
@endphp
        
    <div class="container-fluid pb-5">
        <div class="invoice">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <h3 class='border-bottom pb-3'><strong>Thông tin thanh toán</strong></h3>
                    <form id="frmInvoice" name="frmInvoice">
                        @csrf
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="email" name="email" class='form-control' placeholder='Email' />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="text" name="phone" class='form-control' placeholder='Phone' />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="text" name="address" class='form-control' placeholder='Address' />
                                </div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <button class="btn btn-danger">Thanh toán</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-5">
                    <table class='table'>
                        <tbody>
                            @foreach ($carts as $cart )
                            @php
                                $total += $cart->product['price'] * $cart['quantity'];
                            @endphp
                           
                            <tr>
                                <td width={100}>
                                    <img src="{{ Storage::url($cart->product['image']) }}" alt="" width="100"/>
                                </td>
                                <td width={600}>
                                    <p>{{$cart->product['name']}}</p>
                                    <div class='d-flex align-items-center '>
                                        <span>{{ number_format($cart->product['price']) }}</span>
                                        <div class='ps-3'>
                                            <button class='btn btn-size'>
                                                {{ $cart->size['name'] }} 
                                            </button>
                                        </div>
                                        <div class="ps-5">{{ $cart['quantity'] }}</div>
                                    </div>
                                </td>


                            </tr>
                            @endforeach
                            

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#frmInvoice').submit(function(e){
                e.preventDefault();
                let frmData = $(this).serialize();
                // console.log(frmData);
                $.ajax({
                    url:"{{ route('invoice.create') }}",
                    method:"POST",
                    data: frmData,
                    success:function(res){
                        console.log(res)
                        if(res.status ==201){
                            alert(res.message)
                        }
                        window.location.reload();
                    }
                })
                
            })
        })
    </script>
@endpush