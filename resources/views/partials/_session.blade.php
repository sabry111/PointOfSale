@if (session('success'))

    <script>
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: "{{ session('success') }}",
            timeout: 2000,
            killer: true
        }).show();
    </script>

@endif




{{-- @if (session()->has('add'))
    <script>
        window.onload = function() {
            notif({
                msg: "تم إضافة البيانات بنجاح",
                type: "success"
            })
        }
    </script>
@endif

@if (session()->has('delete'))
    <script>
        window.onload = function() {
            notif({
                msg: "تم حذف البيانات بنجاح",
                type: "error"
            })
        }
    </script>
@endif
@if (session()->has('edit'))
    <script>
        window.onload = function() {
            notif({
                msg: "تم تعديل البيانات بنجاح",
                type: "success"
            })
        }
    </script>
@endif --}}
