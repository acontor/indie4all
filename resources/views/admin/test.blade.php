<!DOCTYPE html>


<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('js/select2.min.js') }}" ></script>
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
 

</head>

<body>
    <div class="container mt-5">
        <h2>Prueba SELECT2</h2>

        <select class="form-control" id="busqueda"></select>
    </div>
</body>

<script type="text/javascript">
    $('#busqueda').select2({
        placeholder: 'Select movie',
        ajax: {
            url: '/autocomplete-user-search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>
</html>