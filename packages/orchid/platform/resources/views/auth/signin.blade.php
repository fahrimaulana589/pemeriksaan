<div class="mb-3">

    <label class="form-label">
        {{__('Email address')}}
    </label>

    {!!  \Orchid\Screen\Fields\Input::make('email')
        ->type('email')
        ->required()
        ->tabindex(1)
        ->autofocus()
        ->autocomplete('email')
        ->inputmode('email')
        ->placeholder(__('Enter your email'))
    !!}
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
    <label class="form-check">
        <input type="hidden" name="remember">
        <input type="checkbox" name="remember" value="true"
               class="form-check-input" {{ !old('remember') || old('remember') === 'true'  ? 'checked' : '' }}>
        <span class="form-check-label"> {{__('Remember Me')}}</span>
    </label>
</div>
<div class="mb-3">
    <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
</div>
