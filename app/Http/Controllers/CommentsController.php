<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comments;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentsMail;

class CommentsController extends Controller
{
    public function index()
    {
        $comments = Comments::latest()->paginate(10);

        return view('comments.index', compact('comments'));
    }

    public function create()
    {
        return view('comments.create');
    }

    public function store(CommentRequest $request, $id = null)
    {

        $query = [
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
            'approved' => isset($request->approved)
        ];

        foreach([ 'type', 'article_id', 'parent_id' ] as $v){
            
            if(!isset($request->{ $v })) continue;

            $query[$v] =  $request->{ $v };
        }

        $comment = (new Comments())->updateOrCreate([ 'id' => $id ], $query);

        if(!empty( env('MAIL_FROM_ADDRESS') )){

            // send email to post author
            if(is_null($id)){
                Mail::to( $comment->{ $comment->type }->author->email )->send( new CommentsMail( $comment, 'added' ) );
            }

            if($comment->approved){

                // approved email
                Mail::to( $comment->email )->send( new CommentsMail( $comment, 'approved' ) );

                // send mail to comments parent 
                $parent = $comment->parent;

                while($parent){

                    Mail::to( $parent->email )->send( new CommentsMail( $comment, 'reply' ) );

                    $parent = $parent->parent;
                }
            }
        }

        return back()->with('success', 'New Comment Created!');
    }

    public function edit($id)
    {
        $comment = Comments::findOrFail($id);

        return view('comments.create', compact('comment'));
    }

    public function destroy($id)
    {
        Comments::destroy($id);

        return redirect()->route('comments.index')->with('success', 'Comment Deleted!');
    }
}
