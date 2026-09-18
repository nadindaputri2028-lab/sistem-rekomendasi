<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Sistem Rekomendasi Mahasiswa')
    </title>

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}"
    >

</head>

<body>

    @include('layouts.navbar')

    <main class="page">

        @if(session('success'))

            <div class="alert success">
                {{ session('success') }}
            </div>

        @endif


        @if(session('error'))

            <div class="alert error">
                {{ session('error') }}
            </div>

        @endif


        @yield('content')

    </main>

    @include('layouts.footer')


    <script>

        document
            .querySelectorAll('[data-confirm]')
            .forEach(function (element) {

                element.addEventListener('click', function (event) {

                    if (!confirm(element.dataset.confirm)) {
                        event.preventDefault();
                    }

                });

            });

    </script>

</body>

</html>