<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Categories</title>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Categories</h1>
        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            Add Category
        </button>
        {{-- <form action="{{ route('categories.store') }}" method="post" id="addCategoryForm" class="d-none">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Category Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="parent_id" class="form-label">Parent Category:</label>
                <select name="parent_id" id="parent_id" class="form-select">
                    <option value="">None</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
        </form> --}}
        <ul class="mt-3">
            @foreach ($categories as $category)
                <li>{{ $category->name }}</li>
                @if ($category->children->count() > 0)
                    @include('categories.subcategories', ['subcategories' => $category->children])
                @endif
            @endforeach
        </ul>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="form-Add-category">
                        @csrf
                        <div class="mb-3">
                            <label for="modal-name" class="form-label">Category Name:</label>
                            <input type="text" class="form-control" id="modal-name" name="name">
                            <span class="text-danger error-msg name"></span>
                        </div>
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent Category:</label>
                            <select name="parent_id" id="parent_id" class="form-select">
                                <option value="">None</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-add-category" onclick="addCategory()">Add Category</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('modal-add-category').addEventListener('click', function() {
            document.getElementById('addCategoryForm').submit();
        });
    </script>
    <script>
           function addCategory() {
    var formData = new FormData($('#form-Add-category')[0]);

    $.ajax({
        method: "POST",
        url: '{{ route('categories.store') }}',
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            if (data.error == 1) {
                if (data.vderror == 1) {
                    // Display validation errors
                    $.each(data.errors, function(key, value) {
                        $('.error-msg.' + key).text(value[0]);
                    });
                } else {
                    $("#addCategoryModal").modal('hide');
                    appct.clearErrors("#addCategoryModal");
                    toastr.error(data.msg, 'danger');

                    $('#form-Add-category')[0].reset();
                }
            } else {
                $("#addCategoryModal").modal('hide');
                appct.clearErrors("#addCategoryModal");
                toastr.success(data.msg, 'success');

                $('#form-Add-category')[0].reset();
            }
        },
        // error: function (error) {
        //     console.log(error);
        // }
    });
}

    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        @if(Session::has('success'))
        toastr.options =
        {
          "closeButton" : true,
          "progressBar" : true
        }
            toastr.success("{{ session('success') }}");
        @endif

        @if(Session::has('danger'))
        toastr.options =
        {
          "closeButton" : true,
          "progressBar" : true
        }
            toastr.error("{{ session('danger') }}");
        @endif

      </script>

</body>
</html>
