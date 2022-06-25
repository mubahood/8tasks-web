<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Utils;
use Carbon\Carbon;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiController  extends Controller
{
    public function tasks_create(Request $r)
    {
        $t = new Task();
        $u = $r->user;

        $t->assigned_to = $r->assigned_to;
        $t->assigned_by = $u->id;
        $t->submision_status = 0;
        $t->review_status = 0;
        $t->category_id = 0;
        $t->value = 0;
        $t->body = $r->body;
        $t->project_id = $r->project_id;
        $t->title = $r->title;
        $t->review_comment = $r->review_comment;
        $t->enterprise_id = $u->enterprise_id;



        $main_date =  Carbon::parse($r->task_date)->format('Y-m-d');
        $t->start_date = $main_date . " " . Carbon::parse($r->start_time)->format('H:i:s');
        $t->end_date = $main_date . " " . Carbon::parse($r->end_time)->format('H:i:s');
        $t->submit_before = $main_date . " " . Carbon::parse($r->end_time)->format('H:i:s');


        if ($t->save()) {
            return Utils::response([
                'status' => 1,
                'message' => 'Task created successfully.',
            ]);
        } else {
            return  Utils::response([
                'status' => 0,
                'message' => 'Failed to create task.',
            ]);
        }
    }


    public function tasks(Request $r)
    {
        return $r->user->username;
    }

    public function projects(Request $r)
    {
        return  Project::where([
            'enterprise_id' => $r->user->enterprise_id
        ])->get();
    }

    public function employees(Request $r)
    {
        return  Administrator::where([
            'enterprise_id' => $r->user->enterprise_id
        ])->get();
    }

    public function login(Request $r)
    {
        if ((!isset($_POST['username'])) || (!isset($_POST['password']))) {
            return Utils::response(['message' => 'Username and password fields are required.', 'status' => 0]);
        }
        $u = Administrator::where('username', $r->username)->first();
        if ($u == null) {
            //wronfg pass
            return Utils::response(['message' => 'Account with provided credentials wsa not found.', 'status' => 0]);
        }

        if (!password_verify($r->password, $u->password)) {
            return Utils::response(['message' => 'Wrong password.', 'status' => 0]);
        }
        unset($u->password);
        return Utils::response(['message' => 'Logged in successfully.', 'status' => 1, 'data' => $u]);
    }
}
