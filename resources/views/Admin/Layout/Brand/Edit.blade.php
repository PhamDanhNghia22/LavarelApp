@extends('Admin.Index')
@section('Content')
    <div class="container-fluid">
        <div class="Edit">
            <h3>Cập nhật danh mục</h3>
            <form id="FrmEditBrand" class="FrmEditBrand" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">
                        Tên danh mục
                    </label>
                    <input type="text" name="name" class="form-control mb-2" value="{{ $brand['name'] }}">
                    <strong style="color:red;font-size:18px;background-color: #FCE77D" class="error" id="error"></strong>

                </div>
                <div class="mb-3">
                    <label for="" class="form-label">
                        Hình ảnh danh mục
                    </label>
                    <input type="file" name="NewImage" class="form-control">
                    <input type="text" name="OldImage" value="{{ $brand['image'] }}">
                    <img src="{{ Storage::url($brand['image']) }}" alt="" width="100" class="my-2">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">
                        Trang thái
                    </label>
                    <select name="is_active" id="is_active" class="form-select">
                        @php
                            $status = [0 => 'Ẩn', 1 => 'Hiện'];

                        @endphp
                        @foreach($status as $key => $value)
                            @if($brand['is_active'] == $key)
                                <option selected value="{{$key}}">{{$value}}</option>
                            @else
                                <option value="{{$key}}">{{$value}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="">
                    <input type="hidden" name="id"  value="{{ $brand['id'] }}">
                    <a href="{{ route('brand.index') }}" class="me-2 btn btn-outline-secondary">Danh sách</a>
                    <button class="btn btn-outline-primary">Lưu</button>
                </div>

            </form>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(document).ready(function () {
            // alert("oke");
            $('#FrmEditBrand').submit(function (e) {
                e.preventDefault();
                let Frmdata = new FormData($("#FrmEditBrand")[0]);

                $.ajax({
                    url: "{{ route('brand.update',$brand->id) }}",
                    method: "POST",
                    data: Frmdata,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        // console.log(res)
                        if(res.status == 200){
                            alert(res.message)
                        }
                        window.location.href={{ route('category.index') }}

                    },
                    error: function (xhr) {
                        if (xhr.status == 422) {
                            let errs = xhr.responseJSON.errors;
                            $.each(errs, function (key, value) {
                                $('.error').text(value[0])
                            })

                        }
                    }
                })
            })
        })
    </script>
@endpush