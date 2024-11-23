<script src="{{asset('assets/admin/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('assets/admin/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('assets/admin/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/admin/vendor/libs/node-waves/node-waves.js')}}"></script>
<script src="{{asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/admin/vendor/libs/hammer/hammer.js')}}"></script>
<script src="{{asset('assets/admin/vendor/libs/i18n/i18n.js')}}"></script>
<script src="{{asset('assets/admin/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{asset('assets/admin/vendor/js/menu.js')}}"></script>
<!-- endbuild -->
{{--<script src="{{asset('assets/admin/vendor/libs/select2/select2.js')}}"></script>--}}

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Vendors JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('assets/admin/vendor/libs/swiper/swiper.js')}}"></script>
<script src="{{asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>

<!-- Flat Picker -->
<script src="{{asset('assets/admin/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/admin/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<!-- Form Validation -->
<script src="{{asset('assets/admin/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>

<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>

<!-- Main JS -->
<script src="{{asset('assets/admin/js/main.js')}}"></script>

<!-- Page JS -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="{{asset('assets/admin/js/dashboards-analytics.js')}}"></script>
<script src="{{asset('assets/admin/vendor/libs/chartjs/chartjs.js')}}"></script>
<script src="{{asset('assets/admin/js/charts-chartjs.js')}}"></script>

<script src="{{asset('assets/admin/js/custom.js')}}"></script>

@yield('scripts')

{{--<script>--}}
{{--    @if(\Illuminate\Support\Facades\Session::has('message'))--}}
{{--    Swal.fire({--}}
{{--        toast: true,--}}
{{--        position: 'top-end',--}}
{{--        icon: 'success',--}}
{{--        title: '{{\Illuminate\Support\Facades\Session::get('message')}}',--}}
{{--        showConfirmButton: false,--}}
{{--        timer: 5000--}}
{{--    });--}}
{{--    @endif--}}

{{--</script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    toastr.error("{{ $error }}", "Error", {
        closeButton: true,
        progressBar: true,
        timeOut: "5000",
    });
    @endforeach
    @endif

    @if (session('success'))
    toastr.success("{{ session('success') }}", "Success", {
        closeButton: true,
        progressBar: true,
        timeOut: "5000",
    });
    @endif
    @if (session('error'))
    toastr.error("{{ session('error') }}", "Error", {
        closeButton: true,
        progressBar: true,
        timeOut: "5000",
    });
    @endif
    @if (session('info'))
    toastr.info("{{ session('info') }}", "Info", {
        closeButton: true,
        progressBar: true,
        timeOut: "5000",
    });
    @endif

    @if (session('warning'))
    toastr.warning("{{ session('warning') }}", "Warning", {
        closeButton: true,
        progressBar: true,
        timeOut: "5000",
    });
    @endif
    function fireDeleteEvent(id) {
    Swal.fire({
        title: "{{ trans('dashboard.delete-confirm') }}",
        text: "{{ trans('dashboard.delete-confirm-message') }}",
        icon: 'warning',
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: "{{ trans('dashboard.close') }}",
        confirmButtonText: "{{ trans('dashboard.yes-delete') }}",
        customClass: {
            confirmButton: 'btn btn-primary me-1',
            cancelButton: 'btn btn-label-secondary'
        },
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "{{ trans('dashboard.deleted') }}",
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false

            });
            $('#form-' + id).submit();
        }
    })
    } //end fireDeleteEvent
</script>
<script>
    function CheckAll(className, elem) {
        var elements = document.getElementsByClassName(className);
        var l = elements.length;

        if (elem.checked) {
            for (var i = 0; i < l; i++) {
                elements[i].checked = true;
            }
        } else {
            for (var i = 0; i < l; i++) {
                elements[i].checked = false;
            }
        }

    }
</script>

