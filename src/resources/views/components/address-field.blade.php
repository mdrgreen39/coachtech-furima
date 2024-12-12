<div>
    <div class="profile-upload__group">
        <label for="postcode" class="profile-upload__group-label">郵便番号</label>
        <input class="profile-upload__group-input" type="text" name="postcode" id="postcode" value="{{ old('postcode', $profile->postcode) }}">
        @if ($errors->has('postcode'))
        <p class="error-message">{{ $errors->first('postcode') }}</p>
        @endif
    </div>
    <div class="profile-upload__group">
        <label for="address" class="profile-upload__group-label">住所</label>
        <input class="profile-upload__group-input" type="text" name="address" id="address" value="{{ old('address', $profile->address) }}">
        @if ($errors->has('address'))
        <p class="error-message">{{ $errors->first('address') }}</p>
        @endif
    </div>
    <div class="profile-upload__group">
        <label for="building" class="profile-upload__group-label">建物名</label>
        <input class="profile-upload__group-input" type="text" name="building" id="building" value="{{ old('building', $profile->building) }}">
        @if ($errors->has('building'))
        <p class="error-message">{{ $errors->first('building') }}</p>
        @endif
    </div>





</div>