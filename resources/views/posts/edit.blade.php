@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')

	<div class="container">
		<div class="row">

			@include('shared.status')

			<div class="my-4 text-end">
				<a href="{{ route('welcome') }}" class="btn btn-info">Home</a>
				<a href="{{ route('posts.create') }}" class="btn btn-primary">Create</a>
				<a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary">View</a>
				@auth
					<button onclick="openDeleteModal('{{ route('posts.destroy', $post->id) }}')" class="btn btn-danger" @disabled(!Auth::user()->can('delete', $post) ?? '')>Delete</button>
				@endauth
			</div>

			<hr>

			<form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
				@csrf
				@method('PUT')

				<div class="row mb-3">
					<label for="inputTitle" class="col-md-2 col-form-label">Title</label>
					<div class="col-md-10">
						<input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="inputTitle" value="{{ old('title', $post->title) }}" placeholder="Enter Title">
						@error('title')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
				</div>

				<div class="row mb-3">
					<label for="inputDescription" class="col-md-2 col-form-label">Description</label>
					<div class="col-md-10">
						<textarea name="description" class="form-control @error('description') is-invalid @enderror" id="inputDescription" rows="3" placeholder="Enter Description">{{ old('description', $post->description) }}</textarea>
						@error('description')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
				</div>

				<div class="row mb-3">
					<label for="selectTags" class="col-md-2 col-form-label">Tags</label>
					<div class="col-md-10">
						<select name="tags[]" class="form-select @error('tags') is-invalid @enderror" id="selectTags" data-placeholder="Choose anything" multiple>
							@foreach($tags as $tag)
								<option @selected(collect(old('tags', $postTags))->contains($tag->name))>{{ $tag->name }}</option>
							@endforeach
						</select>
						@error('tags')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
				</div>

				<button type="submit" class="btn btn-success w-100">Update</button>
			</form>

		</div>
	</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
	$( '#selectTags' ).select2( {
		theme: "bootstrap-5",
		width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
		placeholder: $( this ).data( 'placeholder' ),
		closeOnSelect: false,
		tags: true
	} );
</script>

@endpush