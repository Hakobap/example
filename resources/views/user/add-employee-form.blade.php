<form id="roster-form">
    @csrf

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a class="collapsed tab-inner" role="button" data-toggle="collapse"
                       data-parent="#accordion" href="#collapseOne" aria-expanded="false"
                       aria-controls="collapseOne">
                        Add An Employee <span> (number of staff - 12) </span>
                        <button  class="dashboard-add-btn">Add </button>
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
                 aria-labelledby="headingOne">
                <div class="panel-body">
                    <div>
                        <div class="form-group">
                            <input placeholder="First Name" name="first_name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <input placeholder="Last Name" name="last_name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <input placeholder="Phone Number" name="phone" type="text" id="phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <input placeholder="E-Mail" name="email" type="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <input placeholder="Company" name="company" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <input placeholder="Password" name="password" type="password" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                    <a class="collapsed tab-inner" role="button" data-toggle="collapse"
                       data-parent="#accordion" href="#collapseTwo" aria-expanded="false"
                       aria-controls="collapseTwo">
                        Add Positions <span> (number of staff - 12) </span>
                        <button  class="dashboard-add-btn">Add </button>
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                 aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="form-group em-positions">
                        <input class="form-control" name="position[]" type="text" placeholder="Position Title">
                    </div>
                    <div class="btn-panel" style="position: static;">
                        <a href="#" class="btn-blue add-new-position">Add New</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
                <h4 class="panel-title">
                    <a class="collapsed tab-inner" role="button" data-toggle="collapse"
                       data-parent="#accordion" href="#collapseThree" aria-expanded="false"
                       aria-controls="collapseThree">
                        Add Sites  <span> (number of staff - 12) </span>
                        <button  class="dashboard-add-btn">Add </button>
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                 aria-labelledby="headingOne">
                <div class="panel-body">

                    <div class="form-group em-sites">
                        <input type="url" name="site[]" placeholder="Site Name" class="form-control" />
                    </div>
                    <div class="btn-panel" style="position: static;">
                        <a href="#" class="btn-blue add-new-site">Add New</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>