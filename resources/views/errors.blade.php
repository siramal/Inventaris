<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex items-center justify-center min-h-screen">

    <div class="text-center px-6">
        <img src="{{ asset('assets/images/404.png') }}" alt="Error Illustration" class="mx-auto w-full max-w-sm mb-8">
        
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">
            You can't access this page.
        </h1>
        
        <a href="{{ url()->previous() }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-8 rounded-md transition duration-300">
            Back
        </a>
    </div>

</body>
</html>