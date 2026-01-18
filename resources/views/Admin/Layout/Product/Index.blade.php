@extends('Admin.Index')
@section('Content')
    <div class="container-fluid">
        <h3>Danh sách sản phẩm</h3>
        <div class="index">
            <div class="row">
                <div class="col-xl-6">
                    <a href="{{ route('product.create') }}" class="btn btn-outline-primary">Thêm mới</a>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#SizeModal">Kích thước</button>
                </div>

            </div>
            <div class="category-table my-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>  
                            <th>Sku </th>
                            <th>Hình ảnh </th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Giảm giá</th>
                            <th>Kích thước</th>
                            <th>Trạng thái</th>
                            <th>Danh mục</th>
                            <th>Thương hiệu</th>
                            <th colspan="2"></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product['sku'] }}</td>
                                <td><img src="{{ Storage::url($product['image']) }}" width="100" alt=""></td>
                                <td>{{ $product['name'] }}</td>
                                <td>{{ $product['price'] }}</td>
                                <td>{{ $product['discount'] ? $product['discount']: 0 }}</td>
                                <td>
                                    @foreach ($sizes as $size)
                                    {{ $product->sizes->contains($size['id']) ? $size['name']:'' }}
                                    @endforeach
                                </td>
                                <td>{{ $product['is_active'] == 0 ? 'Ẩn' : 'Hiện' }}</td>
                                <td>
                                    @foreach ($categories as $category)
                                        @if ($category['id'] == $product['category_id'])
                                            {{ $category['name'] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($brands as $brand)
                                        @if ($brand['id'] == $product['brand_id'])
                                            {{ $brand['name'] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td data-id="{{ $product['id'] }}">
                                    <a href="{{ route('product.edit', $product['id']) }}"
                                        class="btn btn-outline-secondary btnEdit">Sửa</a>
                                    <button class="btn btn-outline-danger btnDel">Xóa</button>
                                </td>

                            </tr>
                        @endforeach


                    </tbody>
                </table>

                <div class="modal fade" id="SizeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">

                        <form id="CreateSizeFrm" name="CreateSizeFrm" class=" modal-content" method="post">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Thuộc tính</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" name="name" class="form-control" placeholder="Nhập kích thước">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th>Tên kích thước</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sizes as $size)
                                            <tr>
                                                <td>{{ $size->name }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                            <div class="modal-footer">
                                <a href="{{ route('product.index') }}" class="me-2 btn btn-outline-secondary">Danh sách</a>
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
            $('.btnDel').click(function () {
                let id = $(this).closest('td').attr('data-id');
                // alert(id);
                if (confirm("Bạn có chắc xóa?")) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('product.delete') }}",
                        method: "POST",
                        data: { id: id },
                        success: function (res) {
                            // console.log(res)
                            if (res.status == 200) {
                                alert(res.message)
                            }
                            window.location.reload()
                        }
                    })
                }

            })

            $('#CreateSizeFrm').submit(function (e) {
                e.preventDefault();
                let data = $(this).serialize();
                $.ajax({
                    url: "{{ route('productsize.create') }}",
                    method: "POST",
                    data: data,
                    success: function (res) {
                        if (res.status == 201) {
                            alert(res.message)
                        }
                        window.location.reload()
                    }
                })
            })
        })
    </script>
@endpush