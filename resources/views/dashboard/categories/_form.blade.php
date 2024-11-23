@if($errors->any())
<div class="alert alert-danger">
    <h3>Error Occured!</h3>
    <ul>
        @foreach ($errors->all() as $error )
            <li>{{ $error}}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" @class([
        'form-control',
        'is-invalid'=>$errors->has('name')
    ]) value="{{old('name' , $category->name)}}">
    @error('name')
    <div class="invalid-feedback">
        {{ $message}}
    </div>
    @enderror
</div>

<div class="form-group">
    <label for="parent_id">Parent</label>
    <select name="parent_id" id="parent_id" class="form-control form-select">
        <option value="">Primary Category</option>
        @foreach ( $parents as $parent )
            <option value="{{ $parent->id }}" @selected(old('parent_id',$category->parent_id)==$parent->id) >{{ $parent->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" id="description" class="form-control">{{old('description',$category->description)}}</textarea>
</div>

<div class="form-group">
    <label for="image">Image</label>
    <input type="file" name="image" id="image" class="form-control" accept="image/*">
    @if($category->image)
    <img src="{{asset('storage/'.$category->image)}}" alt="" height="50px">
    @endif
</div>

<div class="form-group">
    <label for="status">Status</label>
    <div>
        <div class="form-check">
            <input type="radio" class="form-check-input" name="status" value="active" @checked(old('status',$category->status)=='active')>
            <label for="status" class="form-check-label">Active</label>
        </div>
        <div class="form-check">
            <input type="radio" class="form-check-input" name="status" value="archived" @checked(old('status',$category->status)=='archived')>
            <label for="status" class="form-check-label">Archived</label>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{$button_label ?? 'Save'}}</button>
</div>
