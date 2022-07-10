{{-- Add Task Modal --}}

<div id="addTask" class="modal fade modal-addTask __add_task_modal" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    <span class="title-for-add">Add Task</span>
                    <span class="title-for-edit" style="display: none;">Edit Task</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="add-task-tdl" action="{{ route('employee.task-management.tasks.store') }}" method="post">
                    <input type="hidden" name="id">

                    <div class="form-group">
                        <label for="text">Task Title</label>
                        <input name="title" type="text" class="form-control">
                    </div>

                    <div class="form-group add-task-select" id="assign-site">
                        <label for="assign">Assign Site</label>
                        <select name="site_id" class="form-control">
                            <option>
                                non site
                            </option>

                            @if($sitesForEmployees->count())
                                @foreach($sitesForEmployees as $id => $site)
                                    <option value="{{ $site->id }}">{{ $site->value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="text">Due Date</label>
                        <input name="due_date" type="date" min="{{ \Carbon\Carbon::now() }}" class="form-control">
                    </div>

                    <label for="text">Notes</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </form>
            </div>
            <div class="a-flex-footer modal-footer">
                <button type="button" class="close-btn" data-dismiss="modal">Close</button>
                <button onclick="$('#add-task-tdl').submit();" type="submit" class="save-add-btn">Save</button>
            </div>
        </div>

    </div>
</div>

{{-- ./ Add Task Modal --}}

{{-- The Task attached files --}}

<div id="attached-files" class="modal fade modal-attached-files modal-addTask" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    <span class="title-for-add">Attached Files</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body task-container">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="dotted">
                        <tr align="center">
                            <th>User</th>
                            <th>File</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ./ The Task attached files --}}