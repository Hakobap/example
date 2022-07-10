$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * For Example: goTo("another page", "example", 'example.html');
 *
 * @param page
 * @param title
 * @param url
 */
function goTo(page, title, url) {
    if ("undefined" !== typeof history.pushState) {
        history.pushState({page: page}, title, url);
    } else {
        window.location.assign(url);
    }
}

function confirmExit() {
    return "You have attempted to leave this page. " +
        "If you have made any changes to the fields without clicking the Save button, your changes will be lost. " +
        "Are you sure you want to exit this page?";
}

function getVals() {
    // Get slider values
    var parent = this.parentNode;
    var slides = parent.getElementsByTagName("input");
    var slide1 = parseFloat(slides[0].value);
    var slide2 = parseFloat(slides[1].value);
    // Neither slider will clip the other, so make sure we determine which is larger
    if (slide1 > slide2) {
        var tmp = slide2;
        slide2 = slide1;
        slide1 = tmp;
    }

    var displayElement = parent.getElementsByClassName("rangeValues")[0];
    displayElement.innerHTML = "$ " + slide1 + "k - $" + slide2 + "k";
}

window.employeeTabsEnable = false;

///////////////////////// Add User Page
function openTab(evt, cityName) {
    evt.preventDefault();

    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");

    tablinks = document.getElementsByClassName("tablinks");

    if (window.employeeTabsEnable === true) {
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    } else if (!$('.tablinks').hasClass('active')) {
        $('#defaultOpen').addClass('active');
        $('.tabcontent').hide();
        $('#tab1').show();
    }

    return false;
}

function changeTab(index, activeIndex) {
    var selector = '.tab' + index + '-btn';
    var $form = $('#add-employee-block');
    var id = $form.data('id');
    var data = new FormData($form.get(0));
    var url = base_url + '/user/employee/step' + activeIndex + '/' + id;

    var nextStep = function () {
        $.ajax({
            dataType: "json",
            type: "POST",             // Type of request to be send, called as method
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false,        // To send DOMDocument or non processed data file it is set to false
            url: url,
            data: data,
            success: function (response) {
                window.employeeTabsEnable = true;

                document.querySelector(selector).click();

                window.employeeTabsEnable = false;
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
            }
        });
    };

    var prevStep = function () {
        window.employeeTabsEnable = true;

        document.querySelector(selector).click();

        window.employeeTabsEnable = false;
    };

    index > activeIndex ? nextStep() : prevStep();
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen") && document.getElementById("defaultOpen").click();

function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var htmlPreview =
                '<img width="70px" src="' + e.target.result + '" />' +
                '<p style="display: none;">' + input.files[0].name + '</p>';
            $('.user-deco').html(htmlPreview);
            //var wrapperZone = $(input).parent();
            //var previewZone = $(input).parent().parent().find('.preview-zone');
            //var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');
            //
            //wrapperZone.removeClass('dragover');
            //previewZone.removeClass('hidden');
            //boxZone.empty();
            //boxZone.append(htmlPreview);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function reset(e) {
    e.wrap('<form>').closest('form').get(0).reset();
    e.unwrap();
}

function generateMapUrl(address) {
    var url = 'https://www.google.com/maps/embed/v1/place?key=AIzaSyCWgblldR_3_dLTg_hqeZRK9MlYi-Imoo0&q=' + address;

    return url;
}

/**
 * Search employee on key up event
 */
function searchEmployee() {
    var value = $(this).val().toLowerCase();
    $(".employee-container tbody tr").filter(function () {
        $(this).toggle($(this).find('.user').text().toLowerCase().indexOf(value) > -1)
    });
}

$(document).delegate(".dropzone", 'change', function () {
    readFile(this);
});

$('.dropzone-wrapper').on('dragover', function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).addClass('dragover');
});

$('.dropzone-wrapper').on('dragleave', function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).removeClass('dragover');
});

$('.remove-preview').on('click', function () {
    var boxZone = $(this).parents('.preview-zone').find('.box-body');
    var previewZone = $(this).parents('.preview-zone');
    var dropzone = $(this).parents('.form-group').find('.dropzone');
    boxZone.empty();
    previewZone.addClass('hidden');
    reset(dropzone);
});
///////////////////////////////////////

window.onload = function () {
    // Initialize Sliders
    var sliderSections = document.getElementsByClassName("range-slider");
    for (var x = 0; x < sliderSections.length; x++) {
        var sliders = sliderSections[x].getElementsByTagName("input");
        for (var y = 0; y < sliders.length; y++) {
            if (sliders[y].type === "range") {
                sliders[y].oninput = getVals;
                // Manually trigger event first time to display values
                sliders[y].oninput();
            }
        }
    }

    if (window.location.hash == "#home-form") {
        $('html, body').animate({
            scrollTop: $('.home-form').offset().top
        }, 1000);
        window.location.hash = '';
    }

    $('.login-btn').click(function () {
        $('html, body').animate({
            scrollTop: $('.home-form').offset().top
        }, 1000);
    });
};

function setUserTime() {
    var localtime = new Date();
    var timeNow = (localtime.getMonth() + 1) + '/' + localtime.getDate() + '/' + localtime.getFullYear() + ' ' + localtime.getHours() + ':' + localtime.getMinutes() + ':' + localtime.getSeconds();

    $.ajax({
        type: 'post',
        url: base_url + '/localtime/set',
        data: {value: timeNow}
    });
}

function addPrefixToPhoneInput() {
    $(document).delegate('#country-listbox li', 'click', function () {
        var phonePrefix = $(this).find('.iti__dial-code').text();

        $('.iti.iti--allow-dropdown input').val(phonePrefix);
    });
}

addPrefixToPhoneInput();

function initializeNumberInput(selector) {
    try {
        var input = document.querySelector(selector);

        if (!input.value) {
            input.value = "+1"; // default en phone prefix
        }

        window.intlTelInput(input, {
            // allowDropdown: false,
            // autoHideDialCode: false,
            // autoPlaceholder: "off",
            dropdownContainer: document.body,
            // excludeCountries: ["us"],
            // formatOnDisplay: false,
            // geoIpLookup: function(callback) {
            //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            //     var countryCode = (resp && resp.country) ? resp.country : "";
            //     callback(countryCode);
            //   });
            // },
            // hiddenInput: "full_number",
            // initialCountry: "auto",
            // localizedCountries: { 'de': 'Deutschland' },
            // nationalMode: false,
            // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
            // placeholderNumberType: "MOBILE",
            // preferredCountries: ['cn', 'jp'],
            // separateDialCode: true,
            utilsScript: base_url + "/phone_prefix/js/utils.js",
        });
    } catch (e) {

    }
}

$(document).ready(function () {
    initializeNumberInput("#phone");
    initializeNumberInput("#phone_2");
    setUserTime();

    try {
        // setting datetimepicker if bootstrap library is already connected
        $('.datetimepicker-e, #datetimepicker1').datetimepicker({
            format: 'DD/MM/YYYY',
        });

        $('#datetimepicker2').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        //Get the value of Start and End of Week
        $('#datetimepicker1').on('dp.change', function (e) {
            if (this.value != $(this).data('value')) {
                $('#top-menu-form-filter').submit();
            } else {
                $(this).val('Please select the calendar week ...');
            }
        });

        $('#datetimepicker1').val($('#datetimepicker1').data('value'));
    } catch (e) {
        // bootstrap datetimepicker not found
    }

    $('#top-menu-form-filter select').change(function () {
        $('#top-menu-form-filter').submit();
    });

    $(".custom-select").not('.employee-actions').each(function () {
        var classes = $(this).attr("class"),
            id = $(this).attr("id"),
            name = $(this).attr("name");
        var template = '<div class="' + classes + '">';
        template +=
            '<span class="custom-select-trigger">' +
            $(this).attr("placeholder") +
            "</span>";
        template += '<div class="custom-options">';
        $(this)
            .find("option")
            .each(function () {
                template +=
                    '<span class="custom-option ' +
                    $(this).attr("class") +
                    '" data-value="' +
                    $(this).attr("value") +
                    '">' +
                    $(this).html() +
                    "</span>";
            });
        template += "</div></div>";

        $(this).wrap('<div class="custom-select-wrapper"></div>');
        $(this).hide();
        $(this).after(template);
    });

    $(".custom-option:first-of-type").hover(
        function () {
            $(this)
                .parents(".custom-options")
                .addClass("option-hover");
        },
        function () {
            $(this)
                .parents(".custom-options")
                .removeClass("option-hover");
        }
    );

    $(".custom-select-trigger").on("click", function () {
        $("html").one("click", function () {
            $(".custom-select").removeClass("opened");
        });
        $(this)
            .parents(".custom-select")
            .toggleClass("opened");
        event.stopPropagation();
    });

    $(".custom-option").on("click", function () {
        $(this)
            .parents(".custom-select-wrapper")
            .find("select")
            .val($(this).data("value"));
        $(this)
            .parents(".custom-options")
            .find(".custom-option")
            .removeClass("selection");
        $(this).addClass("selection");
        $(this)
            .parents(".custom-select")
            .removeClass("opened");
        $(this)
            .parents(".custom-select")
            .find(".custom-select-trigger")
            .text($(this).text());
    });

    $("[data-toggle=offcanvas]").click(function () {
        $(".row-offcanvas").toggleClass("active");
    });

    $('#step1 label,#step2 label,#step3 label,#step4 label,#step5 label, #shift-form label, #add-employee label, #add-task-tdl label').append('<span class="field-error"></span>');

    $('.try-btn').attr('data-target', '.step' + (localStorage.getItem('active-step') ? localStorage.getItem('active-step') : 1));

    $('[data-step]').click(function () {
        var step = $(this).attr('data-step');
        var nextStep = Number(step) + 1;
        var prevStep = Number(step) - 1;
        var hasPrevClass = $(this).hasClass('prev-step') ? 1 : 0;
        // var stepToChange = hasPrevClass ? prevStep : nextStep;

        if (hasPrevClass) {
            localStorage.setItem('active-step', step);
            $('.step' + nextStep).modal('hide');
            $('.step' + step).modal('show');

            // When changing the active step
            $('.field-sites-options, .field-positions-options').hide();

            return false;
        }

        var data = $('#step' + step).serializeArray();
        $('.field-error, .site-field-errors').hide().empty();
        $('#error-position').hide();
        $.ajax({
            type: 'post',
            url: base_url + '/step/' + step,
            data: data,
            success: function (response) {
                if (response.success == true) {
                    if (step == 5) {
                        localStorage.setItem('active-step', 1);
                        location.href = response.url;
                        return false;
                    }

                    $('#company').val(response.company);

                    $('.step' + step).modal('hide');
                    $('.step' + nextStep).modal('show');
                    localStorage.setItem('active-step', nextStep);
                }
            },
            error: function (response) {
                var errors = response.responseJSON.errors;
                for (var field in errors) {
                    var $label = $('[name="' + field + '"]').prev('label');
                    if (!$label.length) {
                        $label = $('label[for="' + field + '"]');
                    }
                    if ((field.match(/site\.|position\./gi) || []).length) {
                        $('.site-field-errors').append('<p>' + errors[field][0] + '</p>').show();
                    }
                    if (field == 'site' || field == 'position') {
                        $('#error-position').show();
                    }
                    $label.find('.field-error').html(errors[field][0]).slideToggle();
                }
            }
        });
    });

    $('.add-site').click(function () {
        // $('.field-sites-options, .field-positions-options').hide();
        $('.field-sites-options').empty();
        $.ajax({
            type: 'post',
            url: base_url + '/step/sites',
            data: {},
            success: function (response) {
                if (response.success == true) {
                    for (var i in response.data) {
                        $('.field-sites-options').append('<label>' + response.data[i] + ' &nbsp; <input value="' + response.data[i] + '" name="site[]" type="checkbox"/></label>');
                    }
                    $('.field-sites-options').show();
                }
            }
        });
    });

    $('.add-position').click(function () {
        // $('.field-sites-options, .field-positions-options').hide();
        $('.field-positions-options').empty();
        $.ajax({
            type: 'post',
            url: base_url + '/step/positions',
            data: {},
            success: function (response) {
                if (response.success == true) {
                    for (var i in response.data) {
                        $('.field-positions-options').append('<label>' + response.data[i] + ' &nbsp; <input value="' + response.data[i] + '" name="position[]" type="checkbox"/></label>');
                    }
                    $('.field-positions-options').show();
                }
            }
        });
    });

    $('.add-new-site').click(function () {
        var appendHtml = '<div class="row" style="margin-top: 20px;">\n' +
            '                                                <div class="col-md-10">\n' +
            '                                                    <input type="url" name="site[]" placeholder="Site Name" class="form-control" />\n' +
            '                                                </div>\n' +
            '                                                <div class="col-md-2">\n' +
            '                                                    <button onclick="$(this).closest(\'.row\').remove()" class="btn btn-danger"><i class="fa fa-trash"></i></button>\n' +
            '                                                </div>\n' +
            '                                            </div>';

        $('.em-sites').append(appendHtml);

        return false;
    });

    $('.add-new-position').click(function () {
        var appendHtml = '<div class="row" style="margin-top: 20px;">\n' +
            '                                                <div class="col-md-10">\n' +
            '                                                    <input type="text" name="position[]" placeholder="Position Title" class="form-control" />\n' +
            '                                                </div>\n' +
            '                                                <div class="col-md-2">\n' +
            '                                                    <button onclick="$(this).closest(\'.row\').remove()" class="btn btn-danger"><i class="fa fa-trash"></i></button>\n' +
            '                                                </div>\n' +
            '                                            </div>';

        $('.em-positions').append(appendHtml);

        return false;
    });

    $('.add-roster').click(function () {
        var formData = $('#roster-form').serializeArray();
        $('.site-errors').hide();
        $('.site-errors .messages').empty();

        $.ajax({
            type: 'post',
            url: base_url + '/user/rostering/add',
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
                for (var field in errors) {
                    $('.site-errors .messages').append('<p style="font-size: 18px;">' + errors[field][0] + '</p>');
                    $('.site-errors').show();
                }
            }
        });
    });

    $(document).delegate("#search-employee, .employee-search", "keyup", searchEmployee);

    $(".summery-search input, .summery-search + .filter-employee").on("keyup + change", function () {
        var value = $(this).val().toLowerCase();
        $(".employee-container tbody tr").filter(function () {
            $(this).toggle($(this).find('td').text().toLowerCase().indexOf(value) > -1)
        });

        if ($(this).is('input')) {
            $('.summery-search + .filter-employee option:first-child').attr('selected', true);
        } else {
            $('.summery-search + .filter-employee option:first-child').removeAttr('selected');
        }
    });

    $('.bulk-action').change(function () {
        if (this.value) {
            $(this).closest('form').submit();
        }
    });

    $('input[name="employees[]"]').change(function () {
        var builkAction = $('.bulk-action');
        if ($('input[name="employees[]"]:checked').length) {
            builkAction.removeAttr('disabled');
        } else {
            builkAction.attr('disabled', true);
        }
    });

    //$(".summery-search .filter-employee").on("change", function () {
    //    var value = $(this).val().toLowerCase();
    //    alert(value)
    //    $(".employee-container tbody tr").filter(function () {
    //        $(this).toggle($(this).find('td').text().toLowerCase().indexOf(value) > -1)
    //    });
    //});

    $(document).delegate("#schedule-table #search-employee", "keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#schedule-table tbody tr").filter(function () {
            $(this).toggle($(this).find('.user').text().toLowerCase().indexOf(value) > -1)
        });
    });

    $('.__edit_site').click(function () {
        $('#sites-form input, #sites-form select').val('');
    });

    $('.__edit_employee').click(function () {
        var id = $(this).data('id');

        $('html, body').animate({
            scrollTop: 0
        }, 1000);

        $.ajax({
            type: "POST",
            dataType: "html",
            url: $('#add-employee-block').data('action'),
            data: {id: id},
            success: function (response) {
                $('.__employee_actions').html(response);

                $('#add-employee-block').show();
                $('#staff').hide();

                document.getElementById("defaultOpen").click();
                initializeNumberInput("#phone");
                $('select[name="site_id[]"], select[name="position_id[]"]').multiSelect();
            }
        });
    });

    $(document).delegate('.__employee_actions [name="first_name"]', 'input', function () {
        $('.t-user-name span:first-child').html(this.value);
    });

    $(document).delegate('.__employee_actions [name="last_name"]', 'input', function () {
        $('.t-user-name span:last-child').html(this.value);
    });

    $(document).delegate('#add-employee-block', 'submit', function (e) {
        e.preventDefault();

        var $form = $(this);
        var data = new FormData(this);

        $.ajax({
            dataType: "json",
            type: "POST",             // Type of request to be send, called as method
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false,        // To send DOMDocument or non processed data file it is set to false
            url: $form.attr('action'),
            data: data,
            success: function (response) {
                if (response.success == true) {
                    location.reload();
                } else {
                    alert(response.message)
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
            }
        });

        return false;
    });

    $(document).delegate('#add-employee-block .add-position + .save-btn', 'click', function () {
        var $input = $(this).prev('input');
        var url = $(this).data('url');
        var position = $input.val().trim();

        if (position.length > 1) {
            $.ajax({
                type: 'post',
                url: url,
                data: {position: position},
                success: function (response) {
                    if (response.success == true) {
                        var option = '<option value="' + response.data.id + '">' + response.data.value + '</option>';

                        $('#add-employee-block select[name="position_id[]"]').append(option);

                        $input.val('');
                    } else {
                        alert(response.message);
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
                }
            });
        } else {
            alert('The Position field must be at least 2 characters');
        }
    });

    window.employee_action = 'add';
    window.employee_id = 0;

    $('[data-target="#addEmployeeModal"]').click(function () {
        $('select[name="site_id"], select[name="position_id"]').removeAttr('disabled');
        window.employee_action = 'add';
        window.employee_id = 0;
        var $form = $('#add-employee');

        $form.find('input').each(function () {
            this.value = '';
        });
    });

    $(document).delegate('.back-link, #add-employee-block .tab-close', 'click', function () {
        $('html, body').animate({
            scrollTop: 0
        }, 1000);

        $('#add-employee-block, #staff').toggle();
    });

    $(".employee-actions").on("change", function () {
        var $this = $(this);
        var $form = $('#add-employee');
        var id = $this.data('id');
        var action = $this.val();
        window.employee_action = action;
        window.employee_id = id;

        $('html, body').animate({
            scrollTop: 0
        }, 1000);

        // reverting action
        $this.val('revert');

        if (action == 'discard' && confirm('Are You Sure?')) {
            $.ajax({
                type: 'post',
                url: base_url + '/user/employee/delete/' + id,
                data: {action: 'discard'},
                success: function (response) {
                    if (response.success == true) {
                        $this.closest('tr').remove();
                    }
                }
            });
        } else if (action == 'edit') {
            var $selects = $form.find('[name="site_id[]"], [name="position_id[]"]');

            $selects.find('option').removeAttr('selected');

            $.ajax({
                type: 'post',
                url: base_url + '/user/employee/get/' + id,
                data: {action: 'discard'},
                success: function (response) {
                    if (response.success == true) {
                        var employee = response.employee;

                        $.each(employee, function (field, value) {
                            if (field == 'roster_start_time' && value == '') {
                                field = 0;
                            }

                            if ($form.find('[name="' + field + '"]').length) {
                                $form.find('[name="' + field + '"]').val(value);
                            }

                            if (field == 'employee_positions') {
                                var $select = $form.find('[name="position_id[]"]');

                                var data = [];

                                $.each(value, function (__key, __value) {
                                    var field_value = __value.position.value;

                                    $select.find('option').each(function () {
                                        if (this.innerHTML == field_value) {
                                            data[__key] = this.value;
                                        }
                                    });
                                });

                                $select.val(data);
                            }

                            if (field == 'employee_sites') {
                                var $select = $form.find('[name="site_id[]"]');

                                var data = [];

                                $.each(value, function (__key, __value) {
                                    var field_value = __value.site.value;

                                    $select.find('option').each(function () {
                                        if (this.innerHTML == field_value) {
                                            data[__key] = this.value;
                                        }
                                    });
                                });

                                $select.val(data);
                            }
                        });
                    }
                }
            });

            $('#addEmployeeModal').modal({
                show: true
            });
        } else if (action == 'revert') {
            window.employee_action = 'add';
            window.employee_id = 0;

            $('#addEmployeeModal').modal({
                show: false
            });
        }
    });

    $('.site-item').click(function () {
        var id = $(this).data('id');
        var $form = $('#sites-form');

        $form.find('input[name="id"]').val(id);

        if (id) {
            // Updating The Form
            $('.addSiteModal .modal-title').text('Edit Site');
            $('.addSiteModal .blue-btn').text('Edit');
            $.ajax({
                type: 'post',
                url: $form.data('get'),
                data: {id: id},
                success: function (response) {
                    if (response.success == true) {
                        $.each(response.data, function (key, value) {
                            var $elem = $form.find('[name="' + key + '"]');
                            if ($elem.length) {
                                $elem.val(value);
                            }
                        });
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
                }
            });
        } else {
            // Resetting The Form
            $('.addSiteModal .modal-title').text('Add Site');
            $('.addSiteModal .blue-btn').text('Add');
            $form.get(0).reset();
        }
    });

    $('#sites-form').submit(function (e) {
        e.preventDefault();

        var $form = $(this);

        $.ajax({
            type: 'post',
            url: $(this).attr('action'),
            data: $form.serializeArray(),
            success: function (response) {
                if (response.success == true) {
                    location.reload();
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
            }
        });

        return false;
    });

    $('.roster .add-task').click(function (e) {
        e.preventDefault();

        location.href = $(this).data('href');

        return false;
    });

    $('.btn-panel.add-task').click(function (e) {
        $('html, body').animate({
            scrollTop: 0
        }, 1000);


        var id = $(this).data('id');

        $('#add-task-tdl .field-error').empty();
        $('.__add_task_modal .title-for-add').show();
        $('.__add_task_modal .title-for-edit').hide();

        $('.__add_task_modal input, .__add_task_modal textarea').val('');
        $('.__add_task_modal select[name="employee_id"]').val(id);
    });

    $('.edit-my-task').click(function (e) {
        $('html, body').animate({
            scrollTop: 0
        }, 1000);

        $('#add-task-tdl .field-error').empty();
        $('.__add_task_modal .title-for-add').hide();
        $('.__add_task_modal .title-for-edit').show();

        var url = this.href;

        $.ajax({
            type: 'post',
            url: url,
            data: {},
            success: function (response) {
                if (response.success == true) {
                    $.each(response.data, function (field, value) {
                        var $elem = $('[name="' + field + '"]');
                        $elem.val(value);
                    });
                }
            }
        });
    });

    $('#add-task-tdl').submit(function () {
        var $form = $(this);

        $form.find('.field-error').empty();

        $.ajax({
            type: 'post',
            url: $(this).attr('action'),
            data: $form.serializeArray(),
            success: function (response) {
                if (response.success == true) {
                    location.reload();
                }
            },
            error: function (response) {
                var errors = response.responseJSON.errors;
                for (var field in errors) {
                    var $label = $('[name="' + field + '"]').prev('label');
                    if (!$label.length) {
                        $label = $('label[for="' + field + '"]');
                    }
                    $label.find('.field-error').html(errors[field][0]);
                }
            }
        });

        return false;
    });

    $('.attach-files').change(function () {
        $('form#my-tasks-list').submit();
    });

    $('form#my-tasks-list').change(function () {
        var $form = $(this);

        var done = [];
        var pending = [];

        $form.find('[name="done[]"]').each(function () {
            var value = this.value;

            var $modalInp = $('.task-details-view [data-status-id="' + value + '"]');

            $modalInp.prop('checked', $(this).prop('checked'));

            if ($(this).prop('checked') == true) {
                done.push(value);
                $modalInp.next('label').css('text-decoration', 'line-through');
            } else {
                pending.push(value);
                $modalInp.next('label').css('text-decoration', 'inherit');
            }
        });

        $.ajax({
            type: 'post',
            url: $form.attr('data-action'),
            data: {
                done: done,
                pending: pending
            },
            success: function (response) {
                if (response.success == true) {
                    //location.reload();
                }
            }
        });
    });

    $('.task-details-view [data-status-id]').click(function () {
        var value = $(this).data('status-id');

        $('form#my-tasks-list [name="done[]"][value="' + value + '"]').click();

        //if ($(this).prop('checked') == true) {
        //    $(this).next('label').css('text-decoration', 'line-through');
        //} else {
        //    $(this).next('label').css('text-decoration', 'inherit');
        //}
    });

    $('.task-details-view [data-edit-id]').click(function () {
        var id = $(this).data('edit-id');
        $('.task-container .edit-my-task[data-id="' + id + '"]').click();
    });

    $('.task-details-view [data-del-id]').click(function () {
        var id = $(this).data('del-id');
        $('.task-container .delete-my-task[data-id="' + id + '"]').click();
    });

    $('.task-container .delete-my-task').click(function (e) {
        e.preventDefault();

        var $this = $(this);
        var id = $this.data('id');
        var href = this.href;

        $this.closest('tr').remove();
        $('[data-del-id="' + id + '"]').closest('.task-details-view').next('hr').remove();
        $('[data-del-id="' + id + '"]').closest('.task-details-view').remove();

        $.ajax({
            type: 'post',
            url: href,
            data: {},
            success: function (response) {
                if (response.success == true) {
                    //location.reload();
                }
            }
        });

        return false;
    });

    $('.view-site-on-map').click(function () {
        var address = $(this).data('address');

        if (!address) {
            alert('No address mentioned for showing on the map');

            return false;
        }

        $('#site-map-view').attr('src', generateMapUrl(address)).show();

        $('html, body').animate({
            scrollTop: $('#site-map-view').offset().top
        }, 1000);
    });

    $('.attach-task-file').click(function (e) {
        e.preventDefault();

        $(this).closest('.icon-flex').find('.attachment-file-input').click();
    });

    downloadAttachment = function (attachment_id, to_do_list_id) {
        var url_prefix = $('#my-tasks-list').hasClass('employee-to-do-list-form') ? '/employee' : '/user';

        var url = base_url + url_prefix + '/task-management/tasks/download-attachment/' + attachment_id + '/' + to_do_list_id;

        location.href = url;
    };

    trashAttachment = function (attachment_id, to_do_list_id) {
        var url_prefix = $('#my-tasks-list').hasClass('employee-to-do-list-form') ? '/employee' : '/user';

        var url = base_url + url_prefix + '/task-management/tasks/trash-attachment/' + attachment_id + '/' + to_do_list_id;

        $.ajax({
            type: 'post',
            url: url,
            data: {},
            success: function (response) {
                if (response.success == true) {
                    $('#row-' + attachment_id).remove();

                    var attacheCount = window.$targetEl.text();

                    window.$targetEl.text(parseInt(attacheCount) - 1);
                }
            }
        });
    };

    $('[data-target="#attached-files"]').click(function (e) {
        e.preventDefault();

        window.$targetEl = $(this);

        var attachments = $(this).data('attachments');
        var $modal = $('#attached-files');

        $modal.find('tbody').empty();

        $.each(attachments, function (key, attachment) {
            var $tr = $('<tr id="row-' + attachment.id + '"/>');
            $tr.append('<td>' + attachment.user.first_name + ' ' + attachment.user.last_name + '</td>');
            $tr.append('<td>' + attachment.file + '</td>');
            $tr.append('<td><div class="btn-group col-md-12">' +
                '<button onclick="downloadAttachment(' + attachment.id + ',' + attachment.to_do_list_id + ')" class="btn btn-primary"><i class="fa fa-download"></i></button>' +
                '<button onclick="trashAttachment(' + attachment.id + ',' + attachment.to_do_list_id + ')" class="btn btn-danger"><i class="fa fa-trash"></i></button>' +
                '</div></td>');
            $modal.find('tbody').append($tr);
        });
    });
});