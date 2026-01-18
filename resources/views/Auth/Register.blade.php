@extends('Client.Index')
@section('Content')
    <div class="container-fluid">
        <div class="container ">
            <div class="d-flex justify-content-center">
                <div class="register col-md-6 rounded shadow boder-0 p-3">
                    <h3 class="text-center">Đăng ký</h3>
                    <form name="frmRegister" id="frmRegister" method="post">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="" class="form-label">Tên người dùng</label>
                            <input type="text" class="form-control" name="name" id="name">
                            <strong style="color:red;font-size:14px;" class="error-name" id="error"></strong>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email </label>
                            <input type="email" class="form-control" name="email" id="email">
                            <strong style="color:red;font-size:14px" class="error-email" id="error"></strong>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <strong style="color:red;font-size:14px;" class="error-password" id="error"></strong>
                        </div>

                        <button class="btn btn-primary d-block mx-auto w-100">Đăng ký</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#frmRegister').submit(function (e) {
                e.preventDefault()
                let frmData = $(this).serialize();
                // console.log(frmData);
                $.ajax({
                    url: "{{ route('auth.register') }}",
                    method: 'POST',
                    data: frmData,
                    success: function (res) {
                        // console.log(res)
                        if (res.status == 201) {
                            alert(res.message);
                        }
                        window.location.href = "/dang-nhap"
                    },
                    error: function (xhr) {
                        // console.log(xhr)
                        if (xhr.status == 422) {
                            let errs = xhr.responseJSON.errors;
                            $.each(errs, function (key, value) {
                                $('.error-' + key).text(value[0])
                            })

                        }
                    }
                })
            })
        })
    </script>
@endpush