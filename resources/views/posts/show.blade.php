@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="row">

			@include('shared.status')

			<div class="my-4 text-end">
				<a href="{{ route('welcome') }}" class="btn btn-info">Home</a>
				<a href="{{ route('posts.create') }}" class="btn btn-primary">Create</a>
				@auth
					<button onclick="openLink('{{ route('posts.edit', $post->id) }}')" class="btn btn-success" @disabled(!Auth::user()->can('update', $post))>Edit</button>
					<button onclick="openDeleteModal('{{ route('posts.destroy', $post->id) }}')" class="btn btn-danger" @disabled(!Auth::user()->can('delete', $post))>Delete</button>
				@endauth
			</div>

			<hr>

			<div class="px-4 text-center">
				<h1 class="display-5 fw-bold">{{ $post->title }}</h1>
				<div class="col-md-12 mx-auto">
					<p class="lead mb-4">{{ $post->description }}</p>
				</div>
			</div>

			<div class="row pb-4 mb-4">
				<div class="col-md-6">
					@foreach($post->tags as $tag)
						<span class="badge rounded-pill {{ Arr::random($badgeColors) }}">{{ $tag->name }}</span>
					@endforeach
				</div>

				<div class="col-md-6 text-end">
					{{ $post->created_at }} ({{ $post->author->name }})
				</div>
			</div>

			<hr>

			@auth
				<!-- The user is authenticated... -->
				<form action="{{ route('posts.comments.store', $post->id) }}" method="post" enctype="multipart/form-data">
					@csrf

					<div class="mb-3">
						<label for="textareaContent" class="form-label">Your Comment</label>
						<textarea name="content" class="form-control @error('content') is-invalid @enderror" id="textareaContent" rows="3" placeholder="Type comment..."></textarea>
						@error('content')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>

					<button type="submit" class="btn btn-warning float-end">Add</button>

				</form>
			@endauth

			@guest
				<!-- The user is not authenticated... -->
				<div class="d-grid gap-2 col-6 mx-auto">
					<a class="btn btn-primary" href="{{ route('login') }}">Login to comment</a>
				</div>
			@endguest

			<div class="my-3 p-3 bg-body rounded">
				<h6 class="border-bottom pb-2 mb-0">Comments</h6>

				@forelse ($comments as $comment)

					<div class="d-flex text-muted pt-3">
						<div class="pb-3 mb-0 small lh-sm border-bottom w-100">
							<div class="d-flex justify-content-between">
								<strong class="text-gray-dark col-md-10">{{ $comment->content }}</strong>
								<a href="javascript:" class="col-md-2 text-end">{{ $comment->created_at }}</a>
							</div>
							<span class="d-block">{{ $comment->user->name }}</span>
						</div>
					</div>

				@empty

					<div class="text-center">
						<strong class="text-danger">No comment</strong>
					</div>

				@endforelse

				{{ $comments->links() }}

			</div>

		</div>
	</div>

@endsection