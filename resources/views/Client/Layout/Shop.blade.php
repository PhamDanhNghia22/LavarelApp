@extends('Client.Index')
@section('Content')
    <div class="container-fluid">
        <div class="shop p-5">
            <div class="row justify-content-evenly">
                <div class="col-md-2">
                    <!-- Categories -->
                    <div class="categories shadow rounded border-0 p-3 mb-4">
                        <h4 class="text-center">Categories</h4>
                        <ul>
                            @foreach($categories as $category)
                            <li>
                                <input type="checkbox" name="brand" id="" class="me-2"><label for="">{{ $category->name }}</label>
                            </li>
                            @endforeach
                            
                        </ul>
                    </div>
                    <!-- Brands -->
                    <div class="brands shadow rounded border-0 p-3">
                        <h4 class="text-center">Brands</h4>
                        <ul>
                            @foreach($brands as $brand)
                            <li>
                                <input type="checkbox" name="brand" id="" class="me-2"><label for="">{{ $brand->name }}</label>
                            </li>
                            @endforeach
                            
                        </ul>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="d-flex flex-wrap justify-content-center align-items-center">
                        
                        <div class="col-md-3  m-2">
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
                        <div class="col-md-3  m-2">
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
                        <div class="col-md-3  m-2">
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
                        <div class="col-md-3  m-2">
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
                        <div class="col-md-3  m-2">
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
                        <div class="col-md-3  m-2">
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
                        <div class="col-md-3  m-2">
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
                        <div class="col-md-3  m-2">
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
                        <div class="col-md-3  m-2">
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
            </div>
        </div>
    </div>
@endsection