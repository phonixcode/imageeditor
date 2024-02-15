<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Image Editor</title>
</head>
<body>

    <h3>Cleanup Image</h3><br>
    <form id="cleanupImage" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" accept="image/*">
        <input type="file" name="mask" accept="image/png">
        <input type="hidden" name="edit_task" value="cleanup">
        <button type="submit">Cleanup Image</button>
        <div id="cleanupImageErrors"></div>
    </form>

    <br><br>
    <h3>Remove Background Image</h3><br>
    <form id="removeBackground" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" accept="image/*">
        <input type="hidden" name="edit_task" value="remove_background">
        <button type="submit">Remove Background Image</button>
        <div id="removeBackgroundErrors"></div>
    </form>

    <div id="editedImageContainer"></div>

    <script>
        document.getElementById('cleanupImage').addEventListener('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(this);

            fetch('/cleanup-image', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Display edited image
                    document.getElementById('editedImageContainer').innerHTML =
                        `<img src="${data.editedImage}" alt="Edited Image">`;
                    // Clear any previous validation errors
                    document.getElementById('cleanupImageErrors').innerHTML = '';
                })
                .catch(error => {
                    // Display validation errors
                    document.getElementById('cleanupImageErrors').innerHTML = 'Error: ' + error.message;
                });
        });
    </script>
    <script>
        document.getElementById('removeBackground').addEventListener('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(this);

            fetch('/remove-background-image', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Display edited image
                    document.getElementById('editedImageContainer').innerHTML =
                        `<img src="${data.editedImage}" alt="Edited Image">`;
                    // Clear any previous validation errors
                    document.getElementById('removeBackgroundErrors').innerHTML = '';
                })
                .catch(error => {
                    // Display validation errors
                    document.getElementById('removeBackgroundErrors').innerHTML = 'Error: ' + error.error;
                });
        });
    </script>
</body>
</html>
