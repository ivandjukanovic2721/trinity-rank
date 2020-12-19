@foreach($comments as $comment)
	<div style="padding-left: {{ ($index * 5) }}%">
		<div class="border-l border-gray-200 pl-2">
		    <p class="mt-3 text-base text-gray-500">
		    	<strong class="block">
		    		{{ $comment->name }} ({{ $comment->email }}):
		    	</strong>
		        {{ $comment->content }}
		    </p>

	        @include('comments.form.index', [ 
	        	'type' => $type, 'parent_id' => $comment->parent_id, 'article_id' => $article_id, 
	        	'comments' => $sub_comments->filter(function($v,$k) use ($comment){ 
	        		return ($v->parent_id == $comment->id); 
	        	}), 'index' => ($index+1) 
	        ])

	        @include('comments.form.form')
	    </div>	    
	</div>
@endforeach