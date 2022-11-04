<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Requests\ApiStoreBlogRequest;

class BlogController extends Controller
{
    public function index(Request $request) {
        $result = array(
            'status_code' => 200,
            'params' => array('boxes' =>  Blog::all()),
        );

        return response()->json($result);
    }

    public function show(Request $request, $blog_id) {
        $blog = Blog::findByID($blog_id);
        $result = array();

        if(empty($blog)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['記事の取得に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
                'params' => array('blog' => $blog),
            );
        }

        return response()->json($result);
    }
    public function store(ApiStoreBlogRequest $request) {
        
        $result = array();

        try {
            $blog = new Blog($data);
            $blog->save();

            $result = array(
                'status_code' => 200,
                'error_messages' => ['ブログの登録に成功しました。'],
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['ブログの登録に失敗しました。']
            );
        }

        return response()->json($result);
    }

    public function update(ApiStoreBlogRequest $request, $blog_id) {
        $data = array(
            'manager_id' => $request->post('manager_id'),
            'title' => $request->post('title'),
            'thumbnail_url' => $request->post('thumbnail_url'),
            'body' => $request->post('body'),
        );
        $result = array();

        try {
            $blog = Blog::findByID($blog_id);

            $blog->manager_id = $data['manager_id'];
            $blog->title = $data['title'];
            $blog->thumbnail_url = $data['thumbnail_url'];
            $blog->body = $data['body'];

            $blog->save();

            $result = array(
                'status_code' => 200,
                'error_messages' => ['ブログの更新に成功しました。'],
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['ブログの更新に失敗しました。']
            );
        }

        return response()->json($result);
    }

    public function delete(Request $request, $blog_id) {
        $blog = Blog::findByID($blog_id);
        $result = array();

        if(empty($blog)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['ブログの削除に失敗しました。']
            );
        } else {
            $result = array(
                'status_code' => 200,
                'error_messages' => ['ブログの削除に成功しました。'],
            );

            $blog->delete();
        }

        return response()->json($result);
    }
}
