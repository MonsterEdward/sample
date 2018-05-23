<li id="status-{{ $status->id }}">
	<a href="{{ route('users.show', $user->id) }}">
		<img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="gravatar">
	</a>

	<span class="user">
		<a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
	</span>
	<span class="timestamp">
		{{ $status->created_at->diffForHumans() }}
	</span>{{-- diffForHumans()的作用是将日期进行友好化处理 --}}
	<span class="content">{{ $status->content }}</span>

	@can('destroy', $status){{-- destroy单词拼错,找不出来,因为不知道原理 --}}
		<form action="{{ route('statuses.destroy', $status->id) }}" method="POST">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}
			<button type="submit" class="btn btn-sm btn-danger status-delete-btn">Delete</button>
		</form>
	@endcan
</li>