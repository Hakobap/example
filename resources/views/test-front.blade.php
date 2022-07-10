<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rostering</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/site/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/site/css/style.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/site/css/reset.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/site/css/font-awesome.min.css') }}"/>
    <style>
        .dotted{
            border-top:1px dashed  #e8e8e8 !important;
            border-bottom:1px dashed  #e8e8e8 !important;
        }
        .task-container  tbody tr:last-child td{padding-bottom:100px}
        .add-task-btn{
            font-family: "Lato-Bold";
            background: #d0d0d0;
            display: block;
            color: #374fb5;
            height: 40px;
            text-align: center;
            vertical-align: middle;
            line-height: 40px;
            border-radius: 5px;
            font-size: 16px;
        }
        .task-container table {
            color: #3e3e3e;
            font-size: 14px;
            background: #fff;
            margin-bottom:0;
        }
        .task-container  .date-details1{
            color:#374fb5;
        }
        .task-container  .icon-flex {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .icon-flex a{
            margin:0 5px;
        }
        .check-task{
            display: flex;
            align-items: center;
            top: -22px;
        }

        .task-container table thead th, .task-container td {
            vertical-align: bottom;
            border: none ;
            border-bottom:none !important;
        }
        .task-container td ,.task-container th{
            border-right:1px solid #e8e8e8 !important;
        }
        .task-container tr td:last-child ,.task-container th:last-child{
            border-right:none !important;
        }
        .task-container th{
            border-bottom:1px solid #e8e8e8 !important;
            padding:5px;
            line-height:40px;
            font-weight: normal
        }
        .task-container td p{
            line-height: 20px;
        }
        .task-container  .title {
            display: block;
            margin: 0 0 20px;
            font-size: 24px;
            text-transform: uppercase;
        }

        .task-container  .checkbox {
            display: inline-block;
            position: relative;
            font-size: 16px;
            line-height: 24px;
        }
        .task-container  .checkbox__input {
            position: absolute;
            top: 0;
            left: 0;
            width: 16px;
            height: 16px;
            opacity: 0;
            z-index: 0;
        }
        .task-container .checkbox__label {
            display: block;
            padding: 0 0 0 24px;
            cursor: pointer;
            font-family: "Lato-Regular";
            font-size: 14px;
            color: #000;
        }
        .task-container  .checkbox__label:before {
            content: '';
            position: absolute;
            top: 1px;
            left: 0;
            width: 20px;
            height: 20px;
            background-color: transparent;
            border: 4px solid #e8e8e8;
            border-radius: 5px;
            z-index: 1;
            -webkit-transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            -webkit-transition-property: background-color, border-color;
            transition-property: background-color, border-color;
        }
        .task-container  .checkbox__label:after {
            content: '';
            position: absolute;
            top: 3px;
            left:7px;
            width: 6px;
            height: 12px;
            border-bottom: 2px solid transparent;
            border-right: 2px solid transparent;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            z-index: 2;
            -webkit-transition: border-color 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            transition: border-color 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .task-container  .checkbox__input:checked + .checkbox__label:before {
            background-color: #1244b7;
            border-color: #1244b7;
        }
        .task-container  .checkbox__input:checked + .checkbox__label:after {
            border-color: #fff;
        }
        .task-container  .txt-deco{
            padding-left: 10px;
            font-size: 16px;
            text-transform: uppercase;
            font-family: 'Lato-Bold';
            color: #374fb5;
        }
        .task-container  .table-responsive {
            background: #fff;
            border: 1px solid #e8e8e8;
            border-top:none !important;
        }
        .keepshift-row .custom-select-trigger {
            color:#000;
        }

        .keepshift-row    .custom-select-trigger:after {
            background: url({{asset('site/images/arrow-blue.png')}}) no-repeat 100%;
        }
        .keepshift-row #datetimepicker1 {
            background: url({{ asset('/site/images/calendar-blue.png') }}) no-repeat 0;
            width:94px;
        }
        .keepshift-row  .div-decoration {
            border-right: 1px solid #e8e8e8;
        }
        .keepshift-row{
            background:#fff;
        }
        .p0{
            padding:0 !important;
        }
        .refresh-icon {
            background: url({{ asset('/site/images/refresh-blue.png') }}) no-repeat 0px 8px;
        }
    </style>
</head>
<body>

<div class="wrapper task-container dashboard">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark container">
            <div class="flex-row d-flex">
                <a class="navbar-brand" href="#"><img src="{{ asset('/site/images/logo.png') }}" alt="logo"></a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="collapsingNavbar">
                <div>
                    <a href="#">
                        <span class="icon dashboard"> Dashboard </span>
                    </a>
                    <a href="#">
                        <span class="icon rostering"> Rostering</span></a>
                    <a href="#">
                        <span class="icon tracking"> Time Tracking</span></a>
                    <a href="#">
						<span class="icon managment"><button type="button" class="modal-btn" data-toggle="modal"
                                                             data-target="#modal-dialog"> Task management</button> </span></a>
                    <a href="#">
                        <span class="icon onboarding"> Onboarding</span></a>
                    <a href="#">
                        <span class="icon award"> Award </span></a>
                    <a href="#">
                        <span class="icon integration"> Integration</span></a>
                    <a href="#"><span class="icon logout"> Logout</span></a>
                </div>
            </div>
        </nav>
    </header>
    <div class="top-menu"></div>
    <div class="container top-select-row keepshift-row">
        <div class="form-group div-decoration">
            <section class="select-decoration">
                <select class="custom-select sources" placeholder="Company Name">
                    <option value="option">Options</option>
                    <option value="option">Edit</option>
                    <option value="option">Discard</option>
                    <option value="option">Invite</option>
                </select>
            </section>
        </div>
        <div class="div-decoration datapicker">
            <input type="text" class="form-control" id="datetimepicker1">
        </div>
        <div class="div-decoration">
            <a href="#" class="refresh-icon">  </a>
        </div>
    </div>
    <div class="container p0">
        <div class="table-responsive" >
            <table class="table">
                <thead>
                <tr class="dotted">
                    <th scope="col"  style="width:340px">
                        <p class="txt-deco">My Tasks</p>
                    </th>
                    <th style="width:155px">
                        <p class="text-center">Due Date</p>
                    </th>
                    <th style="width:580px">
                        <p class="text-center">Notes</p>
                    </th>
                    <th style="width:120px">
                        <a href="#" class="add-task-btn">Add Task</a>
                    </th>
                </tr>
                </thead>
                <tbody class="mt30">
                <tr>
                    <td scope="row">
                        <div class="check-task">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox1" class="checkbox__input">
                                <label for="checkbox1" class="checkbox__label">Task Title (Lorem ipsum dolor sit amet )</label>
                            </div>
                        </div>
                    </td>
                    <td><p class="date-details1 text-center">13 Feb 2020</p></td>
                    <td>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </td>
                    <td>
                        <div class="icon-flex">
                            <a href="#"><img src="{{ asset('/site/images/edit.svg') }}" width="20" alt="edit"></a>
                            <a href="#"><img src="{{ asset('/site/images/close.png') }}" width="20" alt="close"></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <div class="check-task">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox2" class="checkbox__input">
                                <label for="checkbox2" class="checkbox__label">Task Title (Lorem ipsum dolor sit amet )</label>
                            </div>
                        </div>
                    </td>
                    <td><p class="date-details1 text-center">13 Feb 2020</p></td>
                    <td>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </td>
                    <td>
                        <div class="icon-flex">
                            <a href="#"><img src="{{ asset('/site/images/edit.svg') }}" width="20" alt="edit"></a>
                            <a href="#"><img src="{{ asset('/site/images/close.png') }}" width="20" alt="close"></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <div class="check-task">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox3" class="checkbox__input">
                                <label for="checkbox3" class="checkbox__label">Task Title (Lorem ipsum dolor sit amet )</label>
                            </div>
                        </div>
                    </td>
                    <td><p class="date-details1 text-center">13 Feb 2020</p></td>
                    <td>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </td>
                    <td>
                        <div class="icon-flex">
                            <a href="#"><img src="{{ asset('/site/images/edit.svg') }}" width="20" alt="edit"></a>
                            <a href="#"><img src="{{ asset('/site/images/close.png') }}" width="20" alt="close"></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <div class="check-task">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox4" class="checkbox__input">
                                <label for="checkbox4" class="checkbox__label">Task Title (Lorem ipsum dolor sit amet )</label>
                            </div>
                        </div>
                    </td>
                    <td><p class="date-details1 text-center">13 Feb 2020</p></td>
                    <td>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </td>
                    <td>
                        <div class="icon-flex">
                            <a href="#"><img src="{{ asset('/site/images/edit.svg') }}" width="20" alt="edit"></a>
                            <a href="#"><img src="{{ asset('/site/images/close.png') }}" width="20" alt="close"></a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="table mt30">
                <thead>
                <tr class="dotted">
                    <th scope="col"  style="width:340px">
                        <p class="txt-deco">My Tasks</p>
                    </th>
                    <th style="width:155px">
                        <p class="text-center">Due Date</p>
                    </th>
                    <th style="width:580px">
                        <p class="text-center">Notes</p>
                    </th>
                    <th style="width:120px">
                        <a href="#" class="add-task-btn">Add Task</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td scope="row">
                        <div class="check-task">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox5" class="checkbox__input">
                                <label for="checkbox5" class="checkbox__label">Task Title (Lorem ipsum dolor sit amet )</label>
                            </div>
                        </div>
                    </td>
                    <td><p class="date-details1 text-center">13 Feb 2020</p></td>
                    <td>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </td>
                    <td>
                        <div class="icon-flex">
                            <a href="#"><img src="{{ asset('/site/images/edit.svg') }}" width="20" alt="edit"></a>
                            <a href="#"><img src="{{ asset('/site/images/close.png') }}" width="20" alt="close"></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <div class="check-task">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox6" class="checkbox__input">
                                <label for="checkbox6" class="checkbox__label">Task Title (Lorem ipsum dolor sit amet )</label>
                            </div>
                        </div>
                    </td>
                    <td><p class="date-details1 text-center">13 Feb 2020</p></td>
                    <td>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </td>
                    <td class="border0">
                        <div class="icon-flex">
                            <a href="#"><img src="{{ asset('/site/images/edit.svg') }}" width="20" alt="edit"></a>
                            <a href="#"><img src="{{ asset('/site/images/close.png') }}" width="20" alt="close"></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <div class="check-task">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox7" class="checkbox__input">
                                <label for="checkbox7" class="checkbox__label">Task Title (Lorem ipsum dolor sit amet )</label>
                            </div>
                        </div>
                    </td>
                    <td><p class="date-details1 text-center">13 Feb 2020</p></td>
                    <td>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </td>
                    <td>
                        <div class="icon-flex">
                            <a href="#"><img src="{{ asset('/site/images/edit.svg') }}" width="20" alt="edit"></a>
                            <a href="#"><img src="{{ asset('/site/images/close.png') }}" width="20" alt="close"></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <div class="check-task">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox8" class="checkbox__input">
                                <label for="checkbox8" class="checkbox__label">Task Title (Lorem ipsum dolor sit amet )</label>
                            </div>
                        </div>
                    </td>
                    <td><p class="date-details1 text-center">13 Feb 2020</p></td>
                    <td>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </td>
                    <td>
                        <div class="icon-flex">
                            <a href="#"><img src="{{ asset('/site/images/edit.svg') }}" width="20" alt="edit"></a>
                            <a href="#"><img src="{{ asset('/site/images/close.png') }}" width="20" alt="close"></a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="{{ asset('/site/js/jquery.min.js') }}"></script>
<script src="{{ asset('/site/js/bootstrap.js') }}"></script>
<script src="{{ asset('/site/js/main.js') }}"></script>

</body>
</html>