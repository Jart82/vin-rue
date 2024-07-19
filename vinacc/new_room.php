<?php 
require "../action/conn.php";
require "admin_core.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Account - Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css">
        <style>
            .card {
                margin: 20px;
            }
            .preview-images {
                display: flex;
                flex-wrap: wrap;
            }
            .preview-images img {
                margin: 10px;
                width: 100px;
                height: 100px;
                object-fit: cover;
            }
        </style>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="card shadow-lg border-0 rounded-lg mt-5 bglogo">
                                    <div class="card-header">
                                        <h3 class="card-title">Room Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <form id="roomForm" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="roomNumber">Appartment Number</label>
                                                <input type="text" class="form-control" id="roomNumber" name="roomNumber" placeholder="Enter room number">
                                            </div>
                                            <div class="form-group">
                                                <label for="roomName">Appartment Name</label>
                                                <input type="text" class="form-control" id="roomName" name="roomName" placeholder="Enter room name">
                                            </div>
                                            <div class="form-group">
                                                <label for="roomDescription">Appartment Description</label>
                                                <textarea class="form-control" id="roomDescription" name="roomDescription" rows="4" placeholder="Enter room description"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="pricePerNight">Price per Night</label>
                                                <input type="number" step="any" class="form-control" id="pricePerNight" name="pricePerNight" placeholder="Enter price per night">
                                            </div>
                                            <div class="form-group">
                                                <label for="pricePerNight">Guest</label>
                                                <input type="number" step="any" class="form-control" id="guest" name="guest" placeholder="Enter price per night">
                                            </div>
                                            <div class="form-group">
                                                <label for="pricePerNight">Bed</label>
                                                <input type="number" step="any" class="form-control" id="bed" name="bed" placeholder="Enter price per night">
                                            </div>
                                            <div class="form-group">
                                                <label for="pricePerNight">Bath</label>
                                                <input type="number" step="any" class="form-control" id="bath" name="bath" placeholder="Enter price per night">
                                            </div>
                                            <div class="form-group">
                                                <label for="amenities">Amenities</label>
                                                <select class="form-control select2" id="amenities" name="amenities[]" multiple="multiple">
                                                    <?php foreach(ht_get_all_rows($conn,'amenities') as $ame) { ?>
                                                    <option value="<?=$ame['id']; ?>"><?=$ame['name']; ?></option>
                                                    <?php } ?>
                                                    <!-- Add more options as needed -->
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="included">Included</label>
                                                <select class="form-control select2" id="included" name="included[]" multiple="multiple">
                                                    <?php foreach(ht_get_all_rows($conn,'included') as $ame) { ?>
                                                    <option value="<?=$ame['id']; ?>"><?=$ame['name']; ?></option>
                                                    <?php } ?>
                                                    <!-- Add more options as needed -->
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="images">Images</label>
                                                <input type="file" class="form-control" id="images" name="images[]" multiple>
                                                <div class="preview-images" id="previewImages"></div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>>
        </div>
        <script src="js/scripts.js"></script>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2();

                $('#images').on('change', function() {
                    const preview = $('#previewImages');
                    preview.empty();
                    const files = this.files;
                    if (files) {
                        Array.from(files).forEach(file => {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = $('<img>').attr('src', e.target.result);
                                preview.append(img);
                            };
                            reader.readAsDataURL(file);
                        });
                    }
                });

                $('#roomForm').on('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Submitting...',
                        text: 'Please wait while the form is being submitted.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const formData = new FormData(this);

                    $.ajax({
                        url: './action/new_room',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response === 'yes') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'The form has been successfully submitted!',
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: `Submission failed: ${response}`,
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: `Submission failed: ${error}`,
                            });
                        }
                    });
                });
            });
        </script>
    </body>
</html>
