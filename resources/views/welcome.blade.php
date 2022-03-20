@extends('layouts.app')

@section('content')
<div class="container">

	@include('shared.status')

	<div class="my-4 row">
		<a class="btn btn-primary" href="{{ route('posts.create') }}">Create Post</a>
	</div>

	<hr>

	<div class="row">
		<table class="table">
			<thead>
				<tr>
					<th scope="col">Title</th>
					<th scope="col">Description</th>
					<th scope="col">Author Name</th>
					<th scope="col">Comment Count</th>
					<th scope="col">Created AT</th>
					@auth
						<th scope="col">Actions</th>
					@endauth
				</tr>
			</thead>
			<tbody>

				@forelse ($posts as $key => $post)

					<tr>
						<td>{{ $post->title }}</td>
						<td>
							<a href="{{ route('posts.show', $post->id) }}">
								{{ Str::limit($post->description, 50) }}
							</a>
						</td>
						<td>{{ $post->author->name }}</td>
						<td>{{ $post->comments_count }}</td>
						<td>{{ $post->created_at }}</td>

						@auth
							<td>
								<button type="button" onclick="openLink('{{ route('posts.edit', $post->id) }}')" class="btn btn-primary" @disabled(!Auth::user()->can('update', $post))>Edit</button>
								<button type="button" onclick="openDeleteModal('{{ route('posts.destroy', $post->id) }}')" class="btn btn-danger" @disabled(!Auth::user()->can('delete', $post))>Delete</button>
							</td>
						@endauth
					</tr>

				@empty

					<tr>
						<td colspan="5" class="text-center">
							<strong class="text-danger">No posts</strong>
						</td>
					</tr>

				@endforelse

			</tbody>
		</table>

		{{ $posts->links() }}

	</div>
</div>
@endsection
