@error('email')
    <span class="d-block invalid-feedback text-danger mb-3">
            {{ $errors->first('email') }}
    </span>
@enderror

<div class="mb-3 d-flex align-items-center">
    <span class="thumb-sm avatar me-3">
        @if($lockUser->inRole('admin'))
            <img src="{{url('assets/img/avatars/1.png')}}" class="b bg-light rounded-circle" alt="test">
        @elseif($lockUser->inRole('dokter'))
            <img src="{{ $lockUser->dokter != null ? url($lockUser->dokter->icon) : url('assets/img/avatars/1.png') }}" class="b bg-light" alt="test">
        @elseif($lockUser->inRole('pasien'))
            <img src="{{ $lockUser->pasien != null ? url($lockUser->pasien->icon) : url('assets/img/avatars/1.png') }}" class="b bg-light" alt="test">
        @endif
    </span>
    <span style="width:125px;" class="small">
        <span class="text-ellipsis">{{ $lockUser->presenter()->title() }}</span>
        <span class="text-muted d-block text-ellipsis">{{ $lockUser->presenter()->subTitle() }}</span>
    </span>
    <input type="hidden" name="email" required value="{{ $lockUser->email }}">
    <input type="hidden" name="remember" value="true">
</div>

<div class="mb-3 form-password-toggle">
    <div class="d-flex justify-content-between">
        <label class="form-label" for="password">Password</label>
    </div>
    <div class="input-group input-group-merge">
        <input
            type="password"
            id="password"
            class="form-control"
            name="password"
            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
            aria-describedby="password"
        />
        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
    </div>
</div>
<div class="mb-3">
    <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
</div>
<div class="row align-items-center">
    <div class="col-md-6 col-xs-12">
        <a href="{{ route('platform.login.lock') }}" class="small">
            {{__('Sign in with another user.')}}
        </a>
    </div>
</div>
