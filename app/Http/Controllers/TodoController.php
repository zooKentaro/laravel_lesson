<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $todo;

    public function __construct(Todo $instanceClass)
    {
        //ユーザがログインしているかチェック
        $this->middleware('auth');
        $this->todo = $instanceClass;
    }

    public function index()
    {
        $this->todo->all();
        //Auth::idで現在認証しているユーザのidを取得する
        $todos = $this->todo->getByUserId(Auth::id());
        return view('todo.index', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $this->todo->fill($input)->save();
        return redirect()->route('todo.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = $this->todo->find($id);
        return view('todo.edit', compact('todo'));
    }

    // return viewで何を返しているのか。

    // Update文とdelete文の書き方。

    // update
    // UPDATE テーブル名 SET 値 WHERE 条件

    // delete
    // DELETE FROM テーブル名 WHERE 条件

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $this->todo->find($id)->fill($input)->save();
        return redirect()->route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->todo->find($id)->delete();
        return redirect()->route('todo.index');
    }
}
