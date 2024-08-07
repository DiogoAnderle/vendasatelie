<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('plugins/summernote/lang/summernote-pt-BR.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<script src="{{ asset('js/dark-mode.js') }}"></script>

<!-- PLUGINS -->
<!-- Sweet Alert -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.js') }}"></script>
{{-- <script>
    $(document).ready(function() {
        $('#message').summernote({
       lang: 'pt-BR',
        height: 250,
        })
    })
</script> --}}
@yield('scripts')
