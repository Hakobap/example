<?php
/**
 * @var $calendar App\Services\Calendar;
 */
?>

@extends('layouts.app_dashboard')

@section('top-menu')

@endsection

@section('top-menu-right')
    <div class="page-main-title">
        <h3>ROSTER</h3>
    </div>
@endsection

@section('content')
    @include('user.task-management.schedule-table')
@endsection

@section('css')
    <style>
        i {
            cursor: pointer;
        }
        .inner-decoration .delete-item {
            position: absolute;
            right: -10px;
            top: -20px;
            float: right;
            margin-top: 6px;
            font-size: 23px;
            color: #cc4141;
            z-index: 5;
        }
        .inner-decoration {
            padding: 22px 10px;
            min-width: 154px;
            height: 104px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .wrapper {
            overflow-x: hidden;
        }
    </style>
@endsection