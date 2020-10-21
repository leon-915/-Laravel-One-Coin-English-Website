
<div class="row">
    <div class="col-12">
        <div class="plan_header">
            <h2>Refer and Earn Reward</h2>
            <p>Refer teacher and earn rewards from accent</p>
        </div>

        <h4>Your referral code is :  {{ $teacher->referral_code }}</h4>

        {{--<p><span> Credits : </span> {{$teacher->credit_balance}} </p>--}}
        {{--<p><span> Points : </span> {{$teacher->reward_balance}} </p>--}}

    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Write Email address of student">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 text-right mt-3">
        <button class="btn_sub btnsub_arr">Refer Student</button>
    </div>
</div>