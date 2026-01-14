<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <h1>Welcome to the Application</h1>

    <button id="alertButton">Show Alert</button>

    <script>
        document.getElementById('alertButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Hello!',
                text: 'This is a SweetAlert2 alert.',
                icon: 'success',
                confirmButtonText: 'Cool'
            });
        });
    </script>


</body>
</html>
