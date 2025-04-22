<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    /* Sidebar styles */
    #sidebar {
        width: 250px;
        height: 100vh;
        overflow-y: auto;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #fff;
        border-right: 1px solid #dee2e6;
        z-index: 1031; /* Ensure it stays above other content */
    }

    /* Content area adjustment on larger screens */
    @media (min-width: 768px) {
        #contentArea {
            margin-left: 250px;
        }
    }

    /* Optional scrollbar customization */
    #sidebar::-webkit-scrollbar {
        width: 8px;
    }

    #sidebar::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.15);
        border-radius: 4px;
    }

    #sidebar::-webkit-scrollbar-track {
        background-color: transparent;
    }
</style>

</head>

<body class="bg-light">

    <!-- Sidebar + Main Content Wrapper -->
    <div class="d-flex">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-white border-end shadow-sm vh-100 position-fixed">
            @include('admin.partials.sidebar')
        </div>

        <!-- Overlay for mobile -->
        <div id="overlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-none" style="z-index: 1030;"></div>

        <!-- Main Content Area -->
        <div class="flex-grow-1" id="contentArea">
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleBtn = document.getElementById('toggleSidebar');
        const contentArea = document.getElementById('contentArea');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('d-none');
                overlay.classList.toggle('d-none');
            });
        }

        overlay.addEventListener('click', () => {
            sidebar.classList.add('d-none');
            overlay.classList.add('d-none');
        });
    </script>
</body>
</html>
