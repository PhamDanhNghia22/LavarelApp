@extends('Admin.Index')
@section('Content')
    <div class="container-fluid">
        <h3>Thêm mới sản phẩm</h3>
        <div class="create">
            <div class="container-fluid">
                <form id="FrmCreateProduct" name="FrmCreateProduct" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">
                            Tên sản phẩm
                        </label>
                        <input type="text" name="name" class="form-control mb-2">
                        <strong style="color:red;font-size:18px;" class="error-name" id="error"></strong>

                    </div>
                    <div class="mb-3 row">
                        <div class="col-4">
                            <label for="" class="form-label">
                                Giá sản phẩm
                            </label>
                            <input type="text" name="price" class="form-control mb-2">
                            <strong style="color:red;font-size:18px;" class="error-price" id="error"></strong>
                        </div>
                        <div class="col-4">
                            <label for="" class="form-label">
                                Giảm giá
                            </label>
                            <input type="text" name="discount" class="form-control mb-2">

                        </div>
                        <div class="col-4">
                            <label for="" class="form-label">
                                Số lượng
                            </label>
                            <input type="text" name="quantity" class="form-control mb-2">
                            <strong style="color:red;font-size:18px;" class="error-quantity" id="error"></strong>
                        </div>


                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">
                            Hình ảnh danh mục
                        </label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <img src="" width="100" class="my-2" name="previewImage" id="previewImage" alt="" >
                        <strong style="color:red;font-size:18px;" class="error-image" id="error"></strong>
                    </div>

                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="form-label">
                                    Trang thái
                                </label>
                                <select name="is_active" id="is_active" class="form-select">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiện</option>
                                </select>

                            </div>

                            <div class="col-6">
                                <label for="" class="form-label">
                                    Nổi bật
                                </label>
                                <select name="is_featured" id="is_featured" class="form-select">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiện</option>
                                </select>

                            </div>
                        </div>

                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">
                            Chọn kích thước
                        </label>
                        @foreach ($sizes as $size)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $size->id }}" name="size[]"
                                    id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    {{ $size->name }}
                                </label>
                            </div>
                        @endforeach

                    </div>


                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="form-label">
                                    Danh mục
                                </label>
                                <select name="category_id" id="category_id" class="form-select">
                                    <option value="">--Chọn danh mục--</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                                <strong style="color:red;font-size:18px;" class="error-category_id" id="error"></strong>
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">
                                    Thương hiệu
                                </label>
                                <select name="brand_id" id="brand_id" class="form-select">
                                    <option value="">--Chọn thương hiệu--</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                    @endforeach
                                </select>
                                <strong style="color:red;font-size:18px;" class="error-brand_id" id="error"></strong>
                            </div>

                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Mô tả</label>
                        <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="">
                        <a href="{{ route('product.index') }}" class="me-2 btn btn-outline-secondary">Danh sách</a>
                        <button class="btn btn-outline-primary">Lưu</button>
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
            $('#FrmCreateProduct').submit(function (e) {
                e.preventDefault();
                let frmData = new FormData($('#FrmCreateProduct')[0])
                $.ajax({
                    url: "{{ route('product.store') }}",
                    method: "POST",
                    data: frmData,
                    processData: false,
                    contentType: false,
                    // beforeSend: function(){
                    //     $('.loader').show();
                    // }
                    success: function (res) {
                        // console.log(res)
                        if (res.status == 201) {
                            alert(res.message)
                        }
                        window.location.reload="{{ route('product.index') }}";

                    },
                    error: function (xhr) {
                        console.log(xhr)
                        if (xhr.status == 422) {
                            let errs = xhr.responseJSON.errors;
                            // console.log(errs)
                            $.each(errs, function (key, value) {
                                $('.error-' + key).text(value)
                            })
                        }

                    }
                })
            })
        })
    </script>
@endpush