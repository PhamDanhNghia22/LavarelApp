@extends('Admin.Index')
@section('Content')
    <div class="container-fluid">
        <h3>Danh sách danh mục</h3>
        <div class="category-index">
            <div class="row">
                <div class="col-xl-3">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#CreateCategoryModal">
                        Thêm mới
                    </button>
                </div>
            </div>
            <div class="category-table my-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Hình ảnh danh mục</th>
                            <th>Tên danh mục</th>
                            <th>Trạng thái</th>
                            <th colspan="2"></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Categories as $category)
                            <tr>
                                <td><img src="{{ Storage::url($category['image']) }}" width="100" alt=""></td>
                                <td>{{ $category['name'] }}</td>
                                <td>{{ $category['is_active'] == 0 ? 'Ẩn' : 'Hiện' }}</td>
                                <td data-id="{{ $category->id }}">
                                    <button class="btn btn-outline-secondary btnEdit">Sửa</button>
                                    <button class="btn btn-outline-danger btnDel">Xóa</button>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <!-- Modal -->
                <div class="modal fade" id="CreateCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">

                        <form id="FrmCreateCategory" class="FrmCreateCategory modal-content" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm mới danh mục</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="" class="form-label">
                                        Tên danh mục
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

                <div class="modal fade" id="EditCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">

                        <form id="FrmEditCategory" name="FrmEditCategory" class="FrmEditBrand modal-content" method="post"
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
                                    <input type="text" name="OldImage" class="form-control">
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
            $('#NewImage').on('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = e => {
                    $('#previewImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            });
            // alert("oke");
            $('.btnDel').click(function () {
                let id = $(this).closest('td').attr('data-id');
                // alert(id);
                if (confirm("Ban có chac xoa không")) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('category.delete') }}",
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

            $('.btnEdit').click(function () {

                let id = $(this).closest('td').attr('data-id')
                let select = $(FrmEditCategory['is_active']);
                select.empty()
                $.get(`/admin/category/edit/${id}`, function (res) {
                    console.log(res)
                    $(FrmEditCategory['id']).val(res['category']['id'])
                    $(FrmEditCategory['name']).val(res['category']['name'])
                    $(FrmEditCategory['OldImage']).val(res['category']['image'])
                    $('img').attr('src', "{{ Storage::url('') }}" + res['category']['image'])
                    let status = [{ is_active: 0, name: "Ẩn" }, { is_active: 1, name: "Hiện" }];
                    status.forEach((item, i) => {
                        // console.log(item)
                        if (res['category']['is_active'] === item.is_active) {
                            select.append(`<option selected value="${item.is_active}">${item.name}</option>`)
                        } else {
                            select.append(`<option  value="${item.is_active}">${item.name}</option>`)
                        }
                    })
                })
                new bootstrap.Modal('#EditCategoryModal').show()
            })

            $('#FrmEditCategory').submit(function (e) {
                e.preventDefault();
                let Frmdata = new FormData($("#FrmEditCategory")[0]);

                $.ajax({
                    url: "{{ route('category.update') }}",
                    method: "POST",
                    data: Frmdata,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        // console.log(res)
                        if(res.status == 200){
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



            $('#FrmCreateCategory').submit(function (e) {
                e.preventDefault();
                let Frmdata = new FormData($("#FrmCreateCategory")[0]);
                $.ajax({
                    url: "{{ route('category.store') }}",
                    method: "post",
                    data: Frmdata,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        if (res.status == 201) {
                            alert(res.message)
                            $('#FrmCreateCategory')[0].reset()
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
        })
    </script>
@endpush