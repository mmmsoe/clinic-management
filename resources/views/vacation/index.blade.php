@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="form-group col-md-9">
            <label>長期休業設定</label>
        </div>
        <div class="form-group col-md-3">
            <select id="clinics" class="form-control">
                <option value="">-- 診療 --</option>
                @foreach ($clinics as $clinic)
                <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <form id="add_vacation_form">
        <div class="row">
            <div class="form-group col-md-1">
                <label>期間</label>
            </div>
            <div class="form-group col-md-2">
                <input type="date" id="from_date" class="form-control" required>
            </div>
            <div class="form-group col-md-1">
                <label class="d-block text-center">~</label>
            </div>
            <div class="form-group col-md-2">
                <input type="date" id="to_date" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <input type="text" id="reason" class="form-control" required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">保存するn</button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            <div id="vacations_list">

                <table class="table table-striped">
                    <tbody id="vacations_table_body">
                        <!-- Vacation rows will be appended here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#clinics').change(function() {
            // Clear the input fields       
            $('#from_date').val('');
            $('#to_date').val('');
            $('#reason').val('');

            var fromDate = $('#from_date').val();
            var toDate = $('#to_date').val();
            var clinicId = $('#clinics').val();
            if (clinicId) {
                $.ajax({
                    url: '/vacations/' + clinicId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#vacations_table_body').empty();
                        $.each(data, function(key, value) {
                            var fromDate = value.from_date;
                            var toDate = value.to_date;
                            var reason = value.reason;
                            var tableRow = `
                        <tr>
                            <td>${fromDate}</td>
                            <td>${toDate}</td>
                            <td>${reason}</td>
                            <td><button class="btn btn-danger btn-sm cancel" data-id="${value.id}">キャンセル</button></td>
                        </tr>
                    `;
                            $('#vacations_table_body').append(tableRow);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            } else {
                $('#operation_hours_list').empty();
            }
        });

        $('#add_vacation_form').submit(function(e) {
            e.preventDefault();

            var fromDate = $('#from_date').val();
            var toDate = $('#to_date').val();
            var clinicId = $('#clinics').val();
            var reason = $('#reason').val(); // Make sure to retrieve the reason value

            if (clinicId && fromDate && toDate && reason) {
                $.ajax({
                    url: '/add-vacation',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        clinic_id: clinicId,
                        from_date: fromDate,
                        to_date: toDate,
                        reason: reason
                    },
                    success: function(response) {
                        alert(response.message);
                        // Clear the form fields
                        $('#from_date').val('');
                        $('#to_date').val('');
                        $('#reason').val('');
                        // Refresh the vacations list
                        refreshVacationsList();
                    },
                    error: function(xhr) {
                        alert('An error occurred: ' + xhr.responseText);
                    }
                });
            }
        });

        function refreshVacationsList() {
            var clinicId = $('#clinics').val();
            $.ajax({
                url: '/vacations/' + clinicId,
                type: 'GET',
                success: function(data) {
                    $('#vacations_table_body').empty();
                    $.each(data, function(key, value) {
                        var fromDate = value.from_date;
                        var toDate = value.to_date;
                        var reason = value.reason;
                        var tableRow = `
                        <tr>
                            <td>${fromDate}</td>
                            <td>${toDate}</td>
                            <td>${reason}</td>
                            <td><button class="btn btn-danger btn-sm cancel" data-id="${value.id}">Cancel</button></td>
                        </tr>
                    `;
                        $('#vacations_table_body').append(tableRow);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        $(document).on('click', '.cancel', function() {
            var vacationId = $(this).data('id');

            $.ajax({
                url: '/cancel-vacation',
                type: 'POST', // Use POST method and spoof DELETE with _method
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE', // Spoofing DELETE method
                    vacation_id: vacationId
                },
                success: function(response) {
                    alert(response.message);
                    // Refresh the vacations list
                    refreshVacationsList();
                },
                error: function(xhr) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        });
    });
</script>
@endsection