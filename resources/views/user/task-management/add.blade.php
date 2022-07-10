@extends('layouts.app_dashboard')

@section('content')
    <div class="container">
       <form method="post" action="{{ route('user.task-management.store') }}">
           @csrf

           <h3><a href="#" class="site-url">yoursite.com</a></h3>

           @if($errors->all() && !empty($errors->all()))
               <ul class="alert alert-danger">
                   @foreach($errors->all() as $error)
                       <li style="line-height: 20px;">{{ $error }}</li>
                   @endforeach
               </ul>
           @endif

           <div class="summary-banner">
               <div class="col-lg-7">
                   <p class="w-text">Week Summary:</p>
                   <div class="summary-inner">
                       <div class="summary-details1">
                           <p>$25000</p>
                       </div>
                       <div class="summary-details2">
                           <p>$0.00</p>
                       </div>
                       <div class="summary-details3">
                           <p>$0.00</p>
                       </div>
                       <div class="summary-details4">
                           <p>$0.00</p>
                       </div>
                   </div>

               </div>
               <div class="col-lg-5 s-right-banner">
                   <div class="form-group col-lg-12">
                       <select name="position_id" class="form-control">
                           <option>Position  they can work</option>
                           @if($positions && !empty($positions))
                               @foreach($positions as $position)
                                   <option {{ old('position_id') == $position->id ? 'selected' : '' }} value="{{ $position->id }}">{{ $position->value }}</option>
                               @endforeach
                           @endif
                       </select>
                       <div class="btn-panel" hidden> <a  href="#"class="btn-blue">Update</a> </div>
                   </div>
                   <div class="form-group col-lg-12">
                       <select name="employee_id" class="form-control">
                           <option>Employee Name</option>
                           @if($employees && !empty($employees))
                               @foreach($employees as $employee)
                                   <option {{ old('employee_id') == $employee->id ? 'selected' : '' }} value="{{ $employee->id }}">{{ $employee->first_name . ' ' . $employee->last_name }}</option>
                               @endforeach
                           @endif
                       </select>
                       <div class="btn-panel" hidden> <a  href="#"class="btn-blue">Roster</a> </div>
                   </div>
               </div>
           </div>
           <div class="datepicker-box">
               <div class="form-group">
                   <label style="font-size: 15px;line-height: 33px;" class="control-label">Start Date</label>
                   <div class="">
                       <div class="">
                           <input class="form-control" name="start_date" value="{{ old('start_date', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}" type="datetime-local" placeholder="Start Date">
                       </div>
                       <label style="font-size: 15px;line-height: 33px;" class="control-label">End Date</label>
                       <div class="">
                           <input class="form-control" name="end_date" value="{{ old('end_date', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}" type="datetime-local" placeholder="End Date">
                       </div>
                   </div>
               </div>
               {{--            <div class="form-group col-lg-12 c-name-banner">--}}
               {{--                <select class="form-control">--}}
               {{--                    <option>Company Name</option>--}}
               {{--                    <option>2</option>--}}
               {{--                    <option>3</option>--}}
               {{--                    <option>4</option>--}}
               {{--                </select>--}}
               {{--            </div>--}}
               {{--            <div class="price-details">--}}
               {{--                <p>Price Range</p>--}}
               {{--                <section class="range-slider">--}}
               {{--                    <span class="rangeValues"></span>--}}
               {{--                    <input value="500" min="500" max="50000" step="500" type="range">--}}
               {{--                    <input value="50000" min="500" max="50000" step="500" type="range">--}}
               {{--                </section>--}}
               {{--            </div>--}}

               <div class="form-group">
                   <label style="font-size: 15px;line-height: 33px;" class="control-label">The Work Salary By $/Hours</label>
                   <div class="">
                       <div class="">
                           <input class="form-control" name="price" value="{{ old('price') }}" type="text" placeholder="Price">
                       </div>
                      <br>
                       <div class="">
                           <input class="form-control" name="hours" value="{{ old('hours') }}" type="text" placeholder="Hours">
                       </div>
                   </div>
               </div>

               <div class="form-group">
                   <label style="font-size: 15px;line-height: 33px;" class="control-label">Task Information</label>
                   <textarea class="form-control" name="description">{{ old('description') }}</textarea>
               </div>

               <div class="form-group clearfix">
                   <button type="submit" class="btn btn-primary pull-right"> Add </button>
               </div>
           </div>
       </form>
    </div>
@endsection



@section('js')
    <script>
        function getVals(){
            // Get slider values
            var parent = this.parentNode;
            var slides = parent.getElementsByTagName("input");
            var slide1 = parseFloat( slides[0].value );
            var slide2 = parseFloat( slides[1].value );
            // Neither slider will clip the other, so make sure we determine which is larger
            if( slide1 > slide2 ){ var tmp = slide2; slide2 = slide1; slide1 = tmp; }

            var displayElement = parent.getElementsByClassName("rangeValues")[0];
            displayElement.innerHTML = "$ " + slide1 + "k - $" + slide2 + "k";
        }

        window.onload = function(){
            // Initialize Sliders
            var sliderSections = document.getElementsByClassName("range-slider");
            for( var x = 0; x < sliderSections.length; x++ ){
                var sliders = sliderSections[x].getElementsByTagName("input");
                for( var y = 0; y < sliders.length; y++ ){
                    if( sliders[y].type ==="range" ){
                        sliders[y].oninput = getVals;
                        // Manually trigger event first time to display values
                        sliders[y].oninput();
                    }
                }
            }
        }
    </script>
@endsection