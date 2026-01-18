@extends('Admin.Index')
@section('Content')
    <div class="container-fluid">
        <div class="create">
            <h3>Thêm mới thương hiệu</h3>
            <form id="FrmCreateBrand" class="FrmCreateBrand" method="post"  enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">
                        Tên thương hiệu
                    </label>
                    <input type="text" name="name" class="form-control mb-2">
                    <strong style="color:red;font-size:18px;background-color: #FCE77D" class="error" id="error"></strong>

                </div>
                <div class="mb-3">
                    <label for="" class="form-label">
                        Hình ảnh 
                    </label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">
                        Trang thái
                    </label>
                    <select name="is_active" id="is_active" class="form-select">
                        <option value="0">Ẩn</option>
                        <option value="1">Hiện</option>
                    </select>
                </div>
                <div class="">
                    <a href="{{ route('brand.index') }}" class="me-2 btn btn-outline-secondary">Danh sách</a>
                    <button class="btn btn-outline-primary">Lưu</button>
                </div>
                
            </form>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(document).ready(function(){
            // alert("oke");
            $('#FrmCreateBrand').submit(function(e){
                e.preventDefault();
                let Frmdata = new FormData($("#FrmCreateBrand")[0]);
                $.ajax({
                    url:"{{ route('brand.store') }}",
                    method:"post",
                    data:Frmdata,
                    processData: false,
                    contentType: false,
                    success: function(res){
                        if(res.status == 201){
                            alert(res.message)
                            $('#FrmCreateBrand')[0].reset()
                        }
                        
                    },
                    error: function(xhr){
                        if(xhr.status == 422){
                            let errs = xhr.responseJSON.errors;
                            $.each(errs, function(key,value){
                                $('.error').text(value[0])
                            })

                        }
                    }
                })
            })
        })
    </script>
@endpush