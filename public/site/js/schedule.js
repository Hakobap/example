var url_prefix = $('#shift-form').hasClass('employee-shift-form') ? '/employee' : '/user';

/**
 * Shift scroll actions.
 */
var scheduleTableScrollEvent = function () {
    $('#home-table').scroll(function () {
        var scrollLeft = $(this).scrollLeft();

        var $firstTD = $('#home-table tbody tr td:first-child, #home-table thead tr:first-child th:first-child');

        if (scrollLeft > 50) {
            $firstTD.addClass('table-fixed-td');
        } else {
            $firstTD.removeClass('table-fixed-td');
        }
    });
};

scheduleTableScrollEvent();

var updateTableByInterval = function (calendar_schedule, view) {
    var page = $('.report-line').data('action');

    if (view) {
        if (page.indexOf('?') == 0) {
            page += '?view=' + view;
        } else {
            page = page.replace(/\&view=[0-9]+$/gi, '');
            page += '&view=' + view;
        }
    }

    goTo("Schedule Table", "Schedule Table", (page.match(/\?(.*)/gi) || [''])[0]);

    $('#CopyShift').remove();

    $.ajax({
        type: 'post',
        url: page,
        data: {calendar_schedule: calendar_schedule},
        success: function (response) {
            var $oldContent = $('#schedule-table-content');
            $oldContent.hide().after(response);
            $oldContent.remove();
            scheduleTableScrollEvent();
        }
    });
};

$(function () {
    var page = $('.report-line').data('action');

    var addModal = $('#modal-dialog').html();

    $(document).delegate('#searchlink', 'click', function (e) {
        var target = e ? e.target : window.event.srcElement;

        if ($(target).attr('id') == 'searchlink') {
            if ($(this).hasClass('open')) {
                $(this).removeClass('open');
            } else {
                $(this).addClass('open');
            }
        }
    });

    $(document).delegate('.selected-inter .dropdown-item', 'click', function () {
        var value = $(this).text();
        var calendar_schedule = $(this).data('schedule');

        $(this).closest('.dropdown').find('.selected-d-inter').attr('data-schedule', calendar_schedule).text(value);

        if (!$(this).closest('.dropdown').hasClass('__form')) {
            updateTableByInterval(calendar_schedule, calendar_schedule);
        }
    });

    $(document).delegate('.dropdown.__form .dropdown-item', 'click', function () {
        var ref = $(this).closest('.dropdown').data('ref');
        var value = $(this).data('value');
        $(ref).val(value);
        $(this).closest('form').submit();
    });

    $(document).delegate('#schedule-table .m-plus', 'click', function () {
        $('#modal-dialog').html(addModal);
        $('#modal-dialog .modal-title').html('New Shift');

        var emId = $(this).closest('tr').attr('data-row');
        var row = $(this).closest('td').index();
        var url = $(this).data('pos');

        var site_id = $('#shift-form [name="site_id"]').val();
        $('[name="employee_id"]').val(emId);
        $('input[name="row"]').val(row);

        if (!$('#shift-form').hasClass('employee-shift-form')) {
            $.ajax({
                type: 'post',
                url: url,
                data: {id: emId, site_id: site_id},
                success: function (response) {
                    $('[name="position_id"]').empty();

                    if (response.success == true) {
                        $.each(response.data, function (key, value) {
                            $('[name="position_id"]').append('<option value="' + value.position.id + '">' + value.position.value + '</option>');
                        });
                    }
                }
            });
        }
    });

    $(document).delegate('#schedule-table .delete-item', 'click', function () {
        var dataId = $(this).closest('.inner-decoration').attr('data-id');

        var url = base_url + url_prefix + '/task-management/schedule/delete/' + dataId;

        $.ajax({
            type: 'post',
            url: url,
            success: function (response) {
                var $shift = $('.inner-decoration[data-id="' + dataId + '"]');

                $shift.removeClass('green')
                    .removeClass('red')
                    .removeClass('yellow')
                    .html('<i class="fa fa-plus m-plus" data-toggle="modal" data-target="#modal-dialog"></i>');

                $shift.attr('data-id', '');

                var $btn = $('.publish-btn a');
                var count = ($btn.text().match(/[0-9]+/gi) || [0])[0];
                var text = ($btn.text().match(/[A-Z]+/gi) || [''])[0];
                var newText = text + (count ? ' ' + (count - 1) : '');

                $btn.text(newText);
            }
        });
    });

    $(document).delegate('.hover-event .edit-btn', 'click', function () {
        var task_id = $(this).closest('.hover-event').data('id');
        var emId = $(this).closest('tr').attr('data-row');
        var row = $(this).closest('td').index();

        $.ajax({
            type: 'post',
            url: page,
            data: {task_id: task_id},
            success: function (response) {
                $('.schedule-modals').html(response);
                setTimeout(function () {
                    $('#modal-dialog').modal('show');
                    $('[name="employee_id"]').val(emId);
                    $('input[name="row"]').val(row);
                }, 100)
            }
        });
    });

    $(document).delegate('#shift-form', 'submit', function (e) {
        e.preventDefault();

        var task_id = $('[name="task_id"]').val();

        var formData = $('#shift-form').serializeArray();

        var url = base_url + url_prefix + '/task-management/schedule/store' + (task_id ? '/' + task_id : '');

        $.ajax({
            type: 'post',
            url: url,
            data: formData,
            success: function (response) {
                if (response.success == true) {
                    alert('Form data successfully saved!');

                    location.reload();

                    return false;
                } else {
                    alert('Form data wasn\'t saved!');
                }
            },
            error: function (response) {
                var errors = response.responseJSON.errors;
                var errInfo = '';
                for (var field in errors) {
                    errInfo += (errors[field][0] + '\n');
                }
                if (errInfo) {
                    alert(errInfo);
                }
                /*
                 for (var field in errors) {
                 var $label = $('[name="' + field + '"]').prev('label');
                 if (!$label.length) {
                 $label = $('label[for="' + field + '"]');
                 }
                 $label.find('.field-error').html(errors[field][0]).slideToggle();
                 }
                 */
            }
        });

        return false;
    });
});

/**
 * Shift copy-paste actions.
 */
$(function () {
    var isActive = false;
    var copyShiftId = 0;

    $(window).hover(function (e) {
        var $target = $(e.target);

        if (isActive === true && $target.hasClass('inner-decoration')) {
            if ($target.closest('td').index() == 0) return;

            var row = $target.closest('td').index();
            var emId = parseInt($target.closest('tr').attr('data-row'));
            var cloneEmId = parseInt($('[data-id="' + copyShiftId + '"]').closest('tr').attr('data-row'));
            var shiftId = parseInt($target.data('id'));

            if (!shiftId && copyShiftId && isActive) {
                $('.inner-decoration[data-id=""]').css({
                    border: 'none',
                    cursor: 'initial'
                });

                if (emId) {
                    $target.css({
                        border: 'dotted 2px blue',
                        cursor: 'pointer'
                    });
                }
            }
        }
    });

    $(document).delegate(document, 'click', function (e) {
        var $target = $(e.target);

        $('.inner-decoration').css('border', 'none');

        if (isActive === true && $target.hasClass('inner-decoration')) {
            var shiftId = parseInt($target.data('id'));

            // if exist no shiftId Id then doing paste to there by existing copyShiftId
            if (!shiftId && copyShiftId && isActive) {
                var row = $target.closest('td').index();
                var emId = parseInt($target.closest('tr').attr('data-row'));
                var cloneEmId = parseInt($('[data-id="' + copyShiftId + '"]').closest('tr').attr('data-row'));

                if (emId) {
                    pasteAction($target, row, copyShiftId, emId);
                }
            }

            isActive = false;
            copyShiftId = 0;
        } else if ($target.hasClass('copy-btn')) {
            if (isActive === false) {
                $('.inner-decoration').css('border', 'none');
                $target.closest('.inner-decoration').css('border', 'dotted 2px #9196a9');
                isActive = true;
                copyShiftId = $target.closest('.inner-decoration').data('id')
            } else {
                copyShiftId = 0;
                isActive = false;
                $target.closest('.inner-decoration').css('border', 'dotted 2px #9196a9');
            }
        }
    });

    var pasteAction = function ($target, row, copyShiftId, emId) {
        var url = base_url + url_prefix + '/task-management/schedule/copy';

        var calendar_schedule = parseInt($('.selected-d-inter').data('schedule'));

        $.ajax({
            type: 'post',
            url: url,
            data: {task_id: copyShiftId, row: row, employee_id: emId},
            success: function (response) {
                if (response.success) {
                    updateTableByInterval(calendar_schedule);
                }
            }
        });
    }
});

/**
 * Shift calculate hours
 */
$(function () {
    $(document).delegate('[name="meal_break"], [name="start_date"], [name="end_date"]', 'change + input', function () {
        var meal_break = parseInt($('[name="meal_break"]').val());
        var start_date = $('[name="start_date"]').val();
        var end_date = $('[name="end_date"]').val();

        $.ajax({
            type: 'post',
            url: base_url + '/calc-hours',
            data: {meal_break: meal_break, start_date: start_date, end_date: end_date},
            success: function (response) {
                $('#hours').val(response);
            }
        });
    });
});

/**
 * Shift copy with interval
 */
$(function () {
    $(document).delegate('.ctype', 'click', function () {
        ///// getting params after delegate
        var $radios = $('.ctype');
        var $checkboxes = $('input[name="copyTo[]"]');
        var $checkboxesList = $('.checkbox-dates');
        //// end

        var type = parseInt(this.value);

        if (type == 2) {
            if ($(this).prop('checked') === true) {
                $checkboxes.removeAttr('disabled');
                $checkboxesList.css('opacity', 1);
            }
        } else {
            $checkboxes.attr('disabled', true);
            $checkboxesList.css('opacity', .5);
        }
    });

    $(document).delegate('#copyToForm', 'submit', function (e) {
        e.preventDefault();

        var $this = $(this);
        var data = $this.serializeArray();
        var action = location.href;
        var dataSchedule = parseInt($('[data-schedule]').data('schedule'));

        $('#__spinner').show();

        $.ajax({
            type: 'post',
            url: action,
            data: data,
            success: function (response) {
                $('#CopyShift').modal('hide');
                $('#__spinner').hide();

                setTimeout(function () {
                    alert('new shift has been saved');
                    updateTableByInterval(dataSchedule);
                }, 1333);
            }
        });
    });
});

/**
 * Publish Shifts
 */
$(function () {
    //$('#ch-1').change(function () {
    //    $('#ch-2, #ch-3').prop('checked', $('#ch-1').prop('checked'));
    //});
    //
    //$('#publish-shift-form').submit(function () {
    //    var isValid = $('#ch-1').prop('checked') || $('#ch-2').prop('checked') || $('#ch-3').prop('checked');
    //
    //    if (isValid === false) {
    //        alert('Select a shift to change status');
    //    }
    //
    //    return isValid;
    //});
});