@extends('Admin.Index')
@section('Content')
    <div class="container-fluid">
        <h3>Danh sách thương hiệu</h3>
        <div class="index">
            <div class="row">
                <div class="col-xl-3">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#CreateBrandModal">
                        Thêm mới
                    </button>
                </div>

            </div>
            <div class="category-table my-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Hình ảnh </th>
                            <th>Tên thương hiệu</th>
                            <th>Trạng thái</th>
                            <th colspan="2"></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $brand)
                            <tr>
                                <td><img src="{{ Storage::url($brand['image']) }}" width="100" alt=""></td>
                                <td>{{ $brand['name'] }}</td>
                                <td>{{ $brand['is_active'] == 0 ? 'Ẩn' : 'Hiện' }}</td>
                                <td data-id="{{ $brand->id }}">
                                    <a class="btn btn-outline-secondary btnEdit">Sửa</a>
                                    <button class="btn btn-outline-danger btnDel">Xóa</button>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <!-- Modal -->
                <div class="modal fade" id="CreateBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">

                        <form id="FrmCreateBrand" class="FrmCreateBrand modal-content" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm mới Thương hiệu</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="" class="form-label">
                                        Tên thương hiệu
                                    </label>
                                    <input type="text" name="name" class="form-control mb-2">
                                    <strong style="color:red;font-size:18px;background-color: #FCE77D" class="error"
                                        id="error"></strong>

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
                            </div>

                            <div class="modal-footer">
                                <a href="{{ route('brand.index') }}" class="me-2 btn btn-outline-secondary">Danh sách</a>
                                <button class="btn btn-outline-primary">Lưu</button>
                            </div>

                        </form>


                    </div>
                </div>

                <div class="modal fade" id="EditBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">

                        <form id="FrmEditBrand" name="FrmEditBrand" class="FrmEditBrand modal-content" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Cập nhật Thương hiệu</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="" class="form-label">
                                        Tên thương hiệu
                                    </label>
                                    <input type="text" name="name" class="form-control mb-2">
                                    <strong style="color:red;font-size:18px;background-color: #FCE77D" class="error"
                                        id="error"></strong>

                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">
                                        Hình ảnh
                                    </label>
                                    <input type="file" name="NewImage" id="NewImage" class="form-control">
                                    <input type="hidden" name="OldImage" class="form-control">
                                    <img src="" width="100" class="my-2" name="previewImage" id="previewImage" alt="">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">
                                        Trang thái
                                    </label>
                                    <select name="is_active" id="is_active" class="form-select">
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <input type="hidden" name="id">
                                <a href="{{ route('brand.index') }}" class="me-2 btn btn-outline-secondary">Danh sách</a>
                                <button class="btn btn-outline-primary">Lưu</button>
                            </div>

                        </form>


                    </div>
                </div>




            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(document).ready(function () {
            
            let status = [{ is_active: 0, name: "Ẩn" }, { is_active: 1, name: "Hiện" }];
            $('#NewImage').on('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = e => {
                    $('#previewImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            });
            
            $('#FrmCreateBrand').submit(function (e) {
                e.preventDefault();
                let Frmdata = new FormData($("#FrmCreateBrand")[0]);
                $.ajax({
                    url: "{{ route('brand.store') }}",
                    method: "post",
                    data: Frmdata,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        if (res.status == 201) {
                            alert(res.message)
                        }
                        window.location.reload()

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

            $('.btnEdit').click(function () {
                let id = $(this).closest('td').attr('data-id');
                let select = $(FrmEditBrand['is_active']);
                select.empty()
                $.get(`/admin/brand/edit/${id}`, function (res) {
                    console.log(res)
                    $(FrmEditBrand['id']).val(res['brand']['id'])
                    $(FrmEditBrand['name']).val(res['brand']['name'])
                    $(FrmEditBrand['OldImage']).val(res['brand']['image'])
                    $(FrmEditBrand['previewImage']).attr('src', "{{ Storage::url('') }}" + res['brand']['image'])
                    select.val(res['brand']['is_active'])
                    status.forEach((item, i) => {
                        // console.log(item)
                        if (res['brand']['is_active'] === item.is_active) {
                            select.append(`<option selected value="${item.is_active}">${item.name}</option>`)
                        } else {
                            select.append(`<option  value="${item.is_active}">${item.name}</option>`)
                        }
                    })
                    
                })
                new bootstrap.Modal("#EditBrandModal").show();
            })

            $('#FrmEditBrand').submit(function (e) {
                e.preventDefault();
                let Frmdata = new FormData($("#FrmEditBrand")[0]);

                $.ajax({
                    url: "{{ route('brand.update') }}",
                    method: "POST",
                    data: Frmdata,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        // console.log(res)
                        if (res.status == 200) {
                            alert(res.message)
                        }
                        window.location.reload()

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

            // alert("oke");
            $('.btnDel').click(function () {
                let id = $(this).closest('td').attr('data-id');
                // alert(id);
                if (confirm("Ban có chac xoa không")) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('brand.delete') }}",
                        method: "POST",
                        data: { id: id },
                        success: function (res) {
                            // console.log(res)
                            if (res.status == 200) {
                                alert(res.message);
                            }
                            window.location.reload();
                        }

                    })
                }

            })
        })
    </script>
@endpush