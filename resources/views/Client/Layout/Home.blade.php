@extends('Client.Index')
@section('Content')
	<section class="sec-1">
		<!-- Slider main container -->
		<div class="swiper mySwiper">
			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<img src="{{ asset('images/banner-1.jpg') }}" alt="">
				</div>
				<div class="swiper-slide"><img src="{{ asset('images/banner-2.jpg') }}" alt=""></div>

			</div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>
		</div>
	</section>

	<section class="sec-2 py-4">
		<div class="container mb-3">
			<h2 class='text-center'>New Arrivals</h2>
			<div class="row mt-4 justify-content-center">
				@foreach ($NewArrivals as $new)
					<div class="col-md-3 col-6">
						<div class="product card border-0">
							<div class="card-img my-2">
								<img src="{{ Storage::url($new['image']) }}" alt="" class='w-100' />
							</div>
							<div class="card-body">
								<a href="/product/{{$new['slug']}}/{{ $new['id'] }}">{{ $new['name'] }}</a>
								<div class="price">
									{{ number_format($new['price']) }}$ <span class='text-decoration-line-through'>$80</span>
								</div>
							</div>
						</div>
					</div>
				@endforeach

			</div>
		</div>

		<div class="container mb-3">
			<h2 class='text-center'>Featured Product</h2>
			<div class="row mt-4 justify-content-center">
				<div class="col-md-3 col-6">
					<div class="product card border-0">
						<div class="card-img">
							<img src="{{ asset('images/two.jpg') }}" alt="" class='w-100' />
						</div>
						<div class="card-body">
							<a href="">Red shirt for men</a>
							<div class="price">
								$50 <span class='text-decoration-line-through'>$80</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-6">
					<div class="product card border-0">
						<div class="card-img">
							<img src="{{ asset('images/two.jpg') }}" alt="" class='w-100' />
						</div>
						<div class="card-body">
							<a href="">Red shirt for men</a>
							<div class="price">
								$50 <span class='text-decoration-line-through'>$80</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-6">
					<div class="product card border-0">
						<div class="card-img">
							<img src="{{ asset('images/two.jpg') }}" alt="" class='w-100' />
						</div>
						<div class="card-body">
							<a href="">Red shirt for men</a>
							<div class="price">
								$50 <span class='text-decoration-line-through'>$80</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-6">
					<div class="product card border-0">
						<div class="card-img">
							<img src="{{ asset('images/two.jpg') }}" alt="" class='w-100' />
						</div>
						<div class="card-body">
							<a href="">Red shirt for men</a>
							<div class="price">
								$50 <span class='text-decoration-line-through'>$80</span>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
@endsection