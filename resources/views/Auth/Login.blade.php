@extends('Client.Index')
@section('Content')
<div class="container-fluid">
    <div class="container ">
        <div class="d-flex justify-content-center ">
            <div class="login col-6 boder-0 rounded shadow  p-4">
                <h3 class="text-center">Đăng nhập</h3>
                <form name="frmLogin" id="frmLogin" method="post" class="">
                    @csrf

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
                    <div class="mb-3">
                        <a href="/register" class="ms-3 text-secondary">Tạo tài khoản</a>
                    </div>
                    <button class="btn btn-primary d-block mx-auto w-100">Đăng nhập</button>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#frmLogin').submit(function(e) {
        e.preventDefault()
        let frmData = $(this).serialize();
        // console.log(frmData);
        $.ajax({
            url: "{{ route('auth.login') }}",
            method: 'POST',
            data: frmData,
            success: function(res) {
                // console.log(res)
                if (res.status == 401) {
                    alert(res.message);
                } else {
                    if (res.status == 200) {
                        alert(res.message)
                    }
                }
                window.location.href = "/"
            },
            error: function(xhr) {
                // console.log(xhr)
                if (xhr.status == 422) {
                    let errs = xhr.responseJSON.errors;
                    $.each(errs, function(key, value) {
                        $('.error-' + key).text(value[0])
                    })

                }
            }
        })
    })
})
</script>
@endpush