@extends('layout')
@section('title', 'Cleanup Image')

@section('content')
    <div class="container-fluid">
        <!-- begin row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-statistics">
                    <div class="card-header">
                        <div class="card-heading">
                            <h4 class="card-title">Cleanup Image</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="cleanupImage" enctype="multipart/form-data">
                            @csrf

                            <div id="cleanupImageErrors" class="text-danger"></div>

                            <div class="form-row mt-2">

                                <input type="hidden" name="edit_task" value="cleanup">

                                <div class="col-md-6 mb-3">
                                    <label for="originalImage">Original Image</label>
                                    <input type="file" id="originalImage" class="form-control" name="image"
                                        accept="image/*">
                                    <small id="" class="form-text text-muted">
                                        Note: The original image should be a JPG or a PNG, with a
                                        maximum resolution of 16 megapixels and a max file size of 30
                                        Mb.
                                    </small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="originalImage">Mask Image</label>
                                    <input type="file" id="originalImage" class="form-control" name="mask"
                                        accept="image/png">
                                    <small id="" class="form-text text-muted">
                                        Note:
                                        <ul>
                                            <li>The mask image should be a PNG, and should have the same
                                                resolution as the original image and a max file size of
                                                30 Mb.
                                            </li>
                                            <li>T
                                                he mask should be black and white with no grey pixels
                                            </li>
                                        </ul>
                                    </small>
                                </div>
                            </div>

                            <button id="submitButton" class="btn btn-primary" type="submit">
                                <span id="submitText">Submit</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-statistics">
                    <div class="card-header">
                        <div class="card-heading">
                            <h4 class="card-title">Result</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        <div id="editedImageContainer"></div>

                    </div>
                </div>
            </div>

        </div>
        <!-- end row -->
    </div>
@endsection

@push('js')
    <script>
        document.getElementById('cleanupImage').addEventListener('submit', function(event) {
            event.preventDefault();

            // Disable submit button
            document.getElementById('submitButton').setAttribute('disabled', 'disabled');
            document.getElementById('submitText').textContent = 'Loading...'; // Change text to "Loading..."

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
                        `<img src="${data.editedImage}" alt="Edited Image" width="100" height="100"> <br>`;
                    // Clear any previous validation errors
                    // document.getElementById('removeBackgroundErrors').innerHTML = '';

                    // Add download button
                    const downloadButton = document.createElement('a');
                    downloadButton.href = data.editedImage; // Link to the edited image
                    downloadButton.textContent = 'Download Edited Image';
                    downloadButton.className = 'btn btn-info mt-4';
                    downloadButton.download = 'edited_image.png'; // Specify the filename for the downloaded image
                    document.getElementById('editedImageContainer').appendChild(downloadButton);
                })

                .catch(error => {
                    // Display validation errors
                    // document.getElementById('cleanupImageErrors').innerHTML = 'Error: ' + error.message;

                    // Show SweetAlert with error message
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Error: ' + error.message,
                    });
                })
                .finally(() => {
                    // Enable submit button
                    document.getElementById('submitButton').removeAttribute('disabled');
                    document.getElementById('submitText').textContent = 'Submit'; // Reset text to "Submit"
                });
        });
    </script>
@endpush
