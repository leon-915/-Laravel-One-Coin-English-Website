<div class="card mb-3">
    <div class="card-body">
        <h4 class="card-title"></h4>
        <div class="row">
            <div class="col-12">
                {!! Form::open(array('role'=>'form','id'=>'user-search','name'=>"user-search",'autocomplete' => "off")) !!}
                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="form-control-label" for="name">Name</label>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class'=> 'form-control','id' => 'first_name'))!!}
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-control-label" for="email_search">Email</label>
                        {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','id' => 'email_search')) !!}
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-control-label" for="status">Role</label>
                        <select class="form-control" name="role">
                            <option value="">Select Role</option>
                            <?php foreach ($roles as $rkey => $role) { ?>
                            <option value="{{ $role }}"> {{ $role }}</option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label" for="status">Status</label>
                        <select class="form-control" name="status">
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>
                            <option value="3">Suspended</option>
                        </select>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>


