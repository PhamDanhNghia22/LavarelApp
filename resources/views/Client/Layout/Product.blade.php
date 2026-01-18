@extends('Client.Index')
@section('Content')
    <div class="container product-detail py-4">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" class='py-4'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <Link to="/">Home</Link>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <Link to="/shop">Shop</Link>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Dummy Product Title</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row py-4">
                    <div class="col-3">
                        <div class="swiper mySwiper2">
                            <div class="swiper-wrapper d-flex flex-column ">
                                <div class="swiper-slide my-2">
                                    <img src="{{ asset('images/one.jpg') }}" />
                                </div>
                                <div class="swiper-slide my-2">
                                    <img src="{{ asset('images/two.jpg') }}" />
                                </div>
                                <div class="swiper-slide my-2">
                                    <img src="{{ asset('images/three.jpg') }}" />
                                </div>
                                <div class="swiper-slide my-2">
                                    <img src="{{ asset('images/six.jpg') }}" />
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-9">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">

                                <div class="swiper-slide">
                                    <img src="{{ Storage::url($product['image']) }}" class="w-100" />
                                </div>
                                <!-- <div class="swiper-slide">
                                        <img src="{{ asset('images/two.jpg') }}" class="w-100" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/three.jpg') }}" class="w-100" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/six.jpg') }}" class="w-100" />
                                    </div> -->

                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>

                        </div>

                    </div>

                </div>

            </div>
            <div class="col-md-6">
                <h2>{{ $product['name'] }}</h2>
                <div class='d-flex'>
                    <Rating size={20} initialValue={rating} />
                    <span class='pt-1 ps-2'>10 Reviews</span>
                </div>
                <div class="price h3 py-3">
                    {{ number_format($product['price']) }} <span class='text-decoration-line-through'>$80</span>
                </div>

                <div>
                    100% asdasfafsd sadasd <br />
                    asdojpasdjpasdksaopkdposa
                </div>
                <div class="pt-3">
                    <strong>Select size:</strong>
                    <div class="size">
                        @foreach ($sizes as $size)
                            @if ($product->sizes->contains($size['id']))
                                <div class="btn btn-size" data-size="{{ $size['id'] }}">{{  $size['name']  }}</div>
                            @endif

                        @endforeach


                    </div>

                </div>
                <div class="add-to-cart mt-4" data-id="{{ $product['id'] }}">
                    <input type="hidden" name="quantity" id="quantity" value="1">
                    <button class='btn btn-primary text-uppercase btnCart'>Add to cart</button>
                </div>
                <hr />
                <div>
                    <strong>Sku: </strong>
                    DDXXX44
                </div>

            </div>

        </div>

@endsection
    @push('scripts')
        <script>
            $(document).ready(function () {
                let id;
                let size;
                $('.btn-size').click(function () {
                    size = $(this).attr('data-size');
                    // alert(size)
                })
                $('.btnCart').click(function () {
                    id = $(this).closest('.add-to-cart').attr('data-id')
                    let qty = $('#quantity').val()
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:"/addCart",
                        method:"post",
                        data:{product_id:id, size_id:size, quantity: qty},
                        success: function(res){
                            if(res.status ==201){
                                alert(res.message)
                            }
                            window.location.href="/cart"
                        }
                    })
                })

                
            })
            var swiper = new Swiper(".mySwiper", {
                spaceBetween: 10,
                slidesPerView: 4,
                freeMode: true,
                watchSlidesProgress: true,
                thumbs: {
                    swiper: swiper,
                },
            });
            // var swiper2 = new Swiper(".mySwiper2", {
            //     spaceBetween: 10,
            //     freeMode: true,
            //     watchSlidesProgress: true,
            //     navigation: {
            //         nextEl: ".swiper-button-next",
            //         prevEl: ".swiper-button-prev",
            //     },
            //     thumbs: {
            //         swiper: swiper,
            //     },
            // });
        </script>
    @endpush