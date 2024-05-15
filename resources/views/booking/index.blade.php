@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="form-group col-md-10">
            <label>診察時間編集</label>
        </div>
        <div class="form-group col-md-2">
            <select id="clinics" class="form-control">
                <option value="">-- 診療 --</option>
                @foreach ($clinics as $clinic)
                <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <form id="add_operation_hour_form">
        <div class="row">
            <div class="form-group col-md-2">
                <select id="clinic_days" class="form-control">
                    <option value="">-- 診療日 --</option>
                    <option value="Sunday">日曜日</option>
                    <option value="Monday">月曜日</option>
                    <option value="Tuesday">火曜日</option>
                    <option value="Wednesday">水曜日</option>
                    <option value="Thursday">木曜日</option>
                    <option value="Friday">金曜日</option>
                    <option value="Saturday">土曜日</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <input type="time" id="start_time" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <input type="time" id="end_time" class="form-control" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success" id="add-hour">時間を追加</button>
                <button id="make-holiday" class="btn btn-primary">定休日に設定
                </button>
            </div>

        </div>
    </form>



    <div class="row">
        <div class="col-md-12">
            <ul id="operation_hours_list" class="list-group">
            </ul>
            <div class="col-md-12" id="holiday" style="display: none;">
                <div class="row">
                    <div class="col-md-8">
                        <button class="btn btn-outline-danger btn-block" disabled>定休日</button>
                    </div>
                    <div class="col-md-4">
                        <button id="cancel-holiday" class="btn btn-outline-primary">定休日を解除</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#clinics').change(function() {
            $('#operation_hours_list').show();
            $('#holiday').hide();
            $('#clinic_days').prop('disabled', false);
            $('#start_time').prop('disabled', false);
            $('#end_time').prop('disabled', false);
            $('#add-hour').prop('disabled', false);
            $('#make-holiday').prop('disabled', false);
            $('#clinic_days').val('');
            $('#operation_hours').empty().append('<option value="">--Select Operation Hour--</option>');
            $('#operation_hours_list').empty();
        });

        $('#clinic_days').change(function() {
            var clinicDay = $(this).val();
            var clinicId = $('#clinics').val();
            $('#start_time').prop('disabled', false);
            $('#end_time').prop('disabled', false);
            $('#add-hour').prop('disabled', false);
            $('#make-holiday').prop('disabled', false);

            if (clinicDay && clinicId) {
                $.ajax({
                    url: '/operation-hours/' + clinicId + '/' + clinicDay,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#operation_hours_list').empty();
                        $.each(data, function(key, value) {
                            var time = value.start_time + ' - ' + value.end_time;
                            var listItem = '<li class="list-group-item">' + time;
                            if (value.is_booked) {
                                listItem += ' <button class="btn btn-outline-dark cancel" data-id="' + value.id + '">X</button>';
                            }
                            listItem += '</li>';
                            $('#operation_hours_list').append(listItem);
                        });
                    }
                });
            } else {
                $('#operation_hours_list').empty();
            }
        });

        $('#add_operation_hour_form').submit(function(e) {
            e.preventDefault();
            var startTime = $('#start_time').val();
            var endTime = $('#end_time').val();
            var clinicId = $('#clinics').val();
            var clinicDay = $('#clinic_days').val();
            if (clinicId && clinicDay && startTime && endTime) {
                $.ajax({
                    url: '/add-operation-hour',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        clinic_id: clinicId,
                        day: clinicDay,
                        start_time: startTime,
                        end_time: endTime
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#clinic_days').trigger('change');
                        // Clear the form fields
                        $('#start_time').val('');
                        $('#end_time').val('');
                    }
                });
            }
        });

        $(document).on('click', '.cancel', function() {
            var operationHourId = $(this).data('id');
            $.ajax({
                url: '/cancel-operation-hour',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    operation_hour_id: operationHourId
                },
                success: function(response) {
                    alert(response.message);
                    $('#clinic_days').trigger('change');
                }
            });
        });

        $('#make-holiday').click(function() {
            $('#operation_hours_list').hide();
            $('#holiday').show();
            $('#clinic_days').prop('disabled', true);
            $('#start_time').prop('disabled', true);
            $('#end_time').prop('disabled', true);
            $('#add-hour').prop('disabled', true);
            $('#make-holiday').prop('disabled', true);
        });

        $('#cancel-holiday').click(function() {
            $('#operation_hours_list').show();
            $('#holiday').hide();
            $('#clinic_days').prop('disabled', false);
            $('#start_time').prop('disabled', false);
            $('#end_time').prop('disabled', false);
            $('#add-hour').prop('disabled', false);
            $('#make-holiday').prop('disabled', false);
        });
    });
</script>
@endsection