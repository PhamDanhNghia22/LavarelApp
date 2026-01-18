@extends('Admin.Index')
@section('Content')
    <div class="container-fluid">
        <h3>Thêm mới sản phẩm</h3>
        <div class="Edit">
            <div class="container-fluid">
                <form id="FrmEditProduct" name="FrmEditProduct" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">
                            Tên sản phẩm
                        </label>
                        <input type="text" name="name" class="form-control mb-2" value="{{ $product['name'] }}">
                        <strong style="color:red;font-size:18px;" class="error-name" id="error"></strong>

                    </div>
                    <div class="mb-3 row">
                        <div class="col-4">
                            <label for="" class="form-label">
                                Giá sản phẩm
                            </label>
                            <input type="text" name="price" class="form-control mb-2" value="{{ $product['price'] }}">
                            <strong style="color:red;font-size:18px;" class="error-price" id="error"></strong>
                        </div>
                        <div class="col-4">
                            <label for="" class="form-label">
                                Giảm giá
                            </label>
                            <input type="text" name="discount" class="form-control mb-2" value="{{ $product['discount'] }}">

                        </div>
                        <div class="col-4">
                            <label for="" class="form-label">
                                Số lượng
                            </label>
                            <input type="text" name="quantity" class="form-control mb-2" value="{{ $product['quantity'] }}">
                            <strong style="color:red;font-size:18px;" class="error-quantity" id="error"></strong>
                        </div>


                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">
                            Hình ảnh danh mục
                        </label>
                        <input type="file" name="image" id="image" class="form-control">
                        <input type="hidden" name="OldImage" id="OldImage" class="form-control"
                            value="{{ $product['image'] }}">
                        <img src="{{ Storage::url($product['image']) }}" width="100" class="my-2" name="previewImage"
                            id="previewImage" alt="">
                        <strong style="color:red;font-size:18px;" class="error-image" id="error"></strong>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">
                            Chọn kích thước
                        </label>
                        @foreach ($sizes as $size)
                                @if ($product->sizes)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" {{ $product->sizes->contains($size['id'])? 'checked': '' }} value="{{ $size->id }}" name="sizes[]"
                                        id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        {{ $size->name }}
                                    </label>
                                </div>
                                @endif
                                
                        @endforeach

                    </div>


                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="form-label">
                                    Trang thái
                                </label>
                                <select name="is_active" id="is_active" class="form-select">
                                    @php
                                        $status = [0 => 'Ẩn', 1 => 'Hiện'];
                                    @endphp
                                    @foreach ($status as $key => $value)
                                        @if($key == $product['is_active'])
                                            <option selected value="{{ $key }}">{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif

                                    @endforeach
                                </select>

                            </div>

                            <div class="col-6">
                                <label for="" class="form-label">
                                    Nổi bật
                                </label>
                                <select name="is_featured" id="is_featured" class="form-select">
                                    @php
                                        $status = [0 => 'Ẩn', 1 => 'Hiện'];
                                    @endphp
                                    @foreach ($status as $key => $value)
                                        @if($key == $product['is_featured'])
                                            <option selected value="{{ $key }}">{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif

                                    @endforeach
                                </select>

                            </div>
                        </div>

                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="form-label">
                                    Danh mục
                                </label>
                                <select name="category_id" id="category_id" class="form-select">
                                    @foreach ($categories as $category)
                                        @if ($category['id'] == $product['category_id'])
                                            <option selected value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                        @else
                                            <option selected value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                        @endif

                                    @endforeach
                                </select>
                                <strong style="color:red;font-size:18px;" class="error-category_id" id="error"></strong>
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">
                                    Thương hiệu
                                </label>
                                <select name="brand_id" id="brand_id" class="form-select">
                                    @foreach ($brands as $brand)
                                        @if ($brand['id'] == $product['brand_id'])
                                            <option selected value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                        @else
                                            <option selected value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <strong style="color:red;font-size:18px;" class="error-brand_id" id="error"></strong>
                            </div>

                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Mô tả</label>
                        <textarea name="description" id="description" class="form-control"
                            rows="5">{{ $product['description'] }}</textarea>
                    </div>
                    <div class="">
                        <input type="hidden" name="id" value="{{ $product['id'] }}">
                        <a href="{{ route('product.index') }}" class="me-2 btn btn-outline-secondary">Danh sách</a>
                        <button class="btn btn-outline-primary loading">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function () {
            
            $('#image').on('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = e => {
                    $('#previewImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            });
            $('#FrmEditProduct').submit(function (e) {
                e.preventDefault();

                let frmData = new FormData($('#FrmEditProduct')[0])
                $.ajax({
                    url: "{{ route('product.update', $product['id']) }}",
                    method: "POST",
                    data: frmData,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $('.loading').text("...")
                    },
                    success: function (res) {
                        // console.log(res)
                        if (res.status == 200) {
                            alert(res.message)
                        }
                        window.location.href = " {{ route('product.index') }}"

                    },
                    error: function (xhr) {
                        console.log(xhr)
                        let errs = xhr.responseJSON.errors;
                        // console.log(errs)
                        $.each(errs, function (key, value) {
                            $('.error-' + key).text(value)
                        })
                    }
                })
            })
        })
    </script>
@endpush