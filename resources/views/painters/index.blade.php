<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painters</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <h1>List of Painters</h1>
    <ul>
        @foreach ($painters as $painter)
            <li>
                {{ $painter->name }}
                <button onclick="deletePainter({{ $painter->id }})">Delete</button>
            </li>
        @endforeach
    </ul>

    <script>
        function deletePainter(painterId) {
            fetch(`/admin/painters/${painterId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.confirm) {
                        if (confirm(data.message)) {
                            fetch(`/admin/painters/${painterId}/force-delete`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json'
                                }
                            })
                                .then(response => response.json())
                                .then(data => {
                                    alert(data.message);
                                    location.reload();
                                });
                        }
                    } else {
                        alert(data.message);
                        location.reload();
                    }
                });
        }
    </script>
</body>

</html>