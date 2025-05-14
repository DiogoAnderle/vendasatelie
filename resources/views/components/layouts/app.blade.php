<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @include('components.layouts.partials.styles')

    @laravelPWA

</head>

<body class="hold-transition sidebar-collapse sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed"
    id='body'>
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <div class="spinner-grow text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <!-- Navbar -->
        @include('components.layouts.partials.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('components.layouts.partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @include('components.layouts.partials.content-header')
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @livewire('messages')
                    {{ $slot }}
                    <!-- /.row -->
                </div><!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->



        <!-- Main Footer -->
        @include('components.layouts.partials.footer')
    </div>
    <!-- ./wrapper -->

    @include('components.layouts.partials.scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('msg', (event) => {
                setTimeout(() => {
                    $('.alert').alert('close')
                }, 3000);
            })
        })

        // document.addEventListener('livewire:initialized', () => {
        //     Livewire.on('msg', (event) => {
        //         const Toast = Swal.mixin({
        //             toast: true,
        //             position: 'top-end', // Posição do toast (top-right é comum)
        //             showConfirmButton: false,
        //             timer: 3000, // Duração em milissegundos
        //             timerProgressBar: true,
        //             didOpen: (toast) => {
        //                 toast.addEventListener('mouseenter', Swal.stopTimer)
        //                 toast.addEventListener('mouseleave', Swal.resumeTimer)
        //             }
        //         });

        //         Toast.fire({
        //             icon: event.type === 'success' ? 'success' : (event.type === 'error' ? 'error' :
        //                 (event.type === 'warning' ? 'warning' : 'info')),
        //             title: event.message
        //         });
        //     });
        // });

        // document.addEventListener('livewire:init', () => {
        //     Livewire.on('close-modal', (idModal) => {
        //         $('#' + idModal).modal('hide')
        //     })
        // })

        document.addEventListener('livewire:init', () => {
            Livewire.on('open-modal', (payload) => {
                let modalId;

                if (typeof payload === 'object' && payload !== null && payload.hasOwnProperty('params')) {
                    modalId = payload.params;
                } else if (typeof payload === 'string') {
                    modalId = payload;
                } else if (Array.isArray(payload) && payload.length > 0 && typeof payload[0] === 'string') {
                    modalId = payload[0];
                } else {
                    console.error('Erro: Formato inválido recebido no evento open-modal', payload);
                    return; // Encerra a função se o formato for inesperado
                }
                $('#' + modalId).modal('show');
            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('delete', (event) => {
                Swal.fire({
                    title: "Tem certeza que deseja excluir a venda FV-" + event.id + ' ?',
                    text: "Essa ação não pode ser desfeita!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim, excluir isso!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch(event.eventName, {
                            id: event.id
                        })
                    }
                });
            })
        })


        document.addEventListener('livewire:init', () => {
            Livewire.on('finished', (event) => {
                Swal.fire({
                    title: "Tem certeza que deseja marcar pedido FV-" + event.id +
                        ' como concluído?',
                    text: "Essa ação não pode ser desfeita!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim, concluir isso!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch(event.eventName, {
                            id: event.id
                        })
                    }
                });
            })
        })
    </script>

</body>

</html>
